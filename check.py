import os
import pandas as pd
from urllib.parse import unquote
import re
import csv
import sys

# Ensure the log file path is passed as an argument
if len(sys.argv) < 2:
    with open('result.txt', 'w') as result_file:
        result_file.write("Error: Log file path not provided.")
    print("Error: Log file path not provided.")
    exit()

log_file_path = sys.argv[1]
csv_file_path = 'access.csv'

# Ensure the log file exists
if not os.path.isfile(log_file_path):
    with open('result.txt', 'w') as result_file:
        result_file.write("Error: access.log file was not found.")
    print("Error: access.log file was not found.")
    exit()

# Convert log file to CSV
def convert_log_to_csv(log_file_path, csv_file_path):
    try:
        with open(log_file_path, 'r') as log_file, open(csv_file_path, 'w', newline='') as csv_file:
            reader = csv.reader(log_file, delimiter=' ')
            writer = csv.writer(csv_file)
            writer.writerow(['client', 'userid', 'datetime', 'method', 'request', 'status', 'size', 'referrer', 'user_agent'])
            
            for line in reader:
                if len(line) > 8:  # Basic check to skip incomplete lines
                    writer.writerow(line[:9])  # Adjust based on actual log format
        print("Log conversion to CSV successful.")
    except Exception as e:
        with open('result.txt', 'w') as result_file:
            result_file.write(f"Error during log conversion: {str(e)}")
        print(f"Error during log conversion: {str(e)}")
        exit()

# Run conversion
convert_log_to_csv(log_file_path, csv_file_path)

# Check if CSV file was created
if not os.path.isfile(csv_file_path):
    with open('result.txt', 'w') as result_file:
        result_file.write("Error: access.csv file was not created. Please check the log conversion process.")
    print("Error: access.csv file was not created. Please check the log conversion process.")
    exit()

# Load dataset
try:
    df = pd.read_csv(csv_file_path)
    print("CSV loaded successfully.")
except Exception as e:
    with open('result.txt', 'w') as result_file:
        result_file.write(f"Error loading CSV: {str(e)}")
    print(f"Error loading CSV: {str(e)}")
    exit()

# URL Decoding
df['decoded_request'] = df['request'].apply(unquote)

# Feature Extraction for Path Traversal
df['is_path_traversal'] = df['decoded_request'].apply(lambda x: 1 if re.search(r'(\.\./|\.\.\\|%2F%2E%2E|%2E%2E%2F)', x) else 0)

# Feature Extraction for SQL Injection
sql_patterns = r"(\bUNION\b|\bSELECT\b|--|%27|%23|\bAND\b|\bOR\b|\bINFORMATION_SCHEMA\b|\bTABLES\b|\bFROM\b|\bWHERE\b)"
df['is_sql_injection'] = df['decoded_request'].apply(lambda x: 1 if re.search(sql_patterns, x, re.IGNORECASE) else 0)

# Feature Extraction for OGNL Injection
ognl_patterns = r"(\$\{.*?\}|\#\{|@|\#context|\#request|\#response|\#session|\#application|\#servletContext|\#out|\#parameters|\#attr|\#header|\#cookie|\#method)"
df['is_ognl_injection'] = df['decoded_request'].apply(lambda x: 1 if re.search(ognl_patterns, x, re.IGNORECASE) else 0)

# Feature Extraction for XSS
xss_patterns = r"(<script.*?>.*?</script.*?>|%3Cscript.*?%3E.*?%3C/script.*?%3E|<.*?on\w+=.*?>|<.*?javascript:.*?>|%3C.*?on\w+%3D.*?%3E|%3C.*?javascript:.*?%3E)"
df['is_xss'] = df['decoded_request'].apply(lambda x: 1 if re.search(xss_patterns, x, re.IGNORECASE) else 0)

# Feature Extraction for Remote File Inclusion (RFI)
rfi_patterns = r"(https?://[^\s]+(\.php|\.txt|\.html)|ftp://[^\s]+(\.php|\.txt|\.html))"
df['is_rfi'] = df['decoded_request'].apply(lambda x: 1 if re.search(rfi_patterns, x, re.IGNORECASE) else 0)

# Feature Extraction for Malicious Payloads
malicious_payload_patterns = r"(cmd=|exec=|shell=|bash=|powershell=|cmd.exe|/bin/bash|/bin/sh|%3B|%26|%7C)"
df['is_malicious_payload'] = df['decoded_request'].apply(lambda x: 1 if re.search(malicious_payload_patterns, x, re.IGNORECASE) else 0)

# Feature Extraction for HTTP Methods Abuse
http_methods_abuse_patterns = r"(\bTRACE\b|\bTRACK\b|\bOPTIONS\b|\bCONNECT\b|\bDELETE\b|\bPUT\b|\bPATCH\b)"
df['is_http_methods_abuse'] = df['method'].apply(lambda x: 1 if re.search(http_methods_abuse_patterns, x, re.IGNORECASE) else 0)

# Feature Extraction for Password-Based Attacks
password_attack_patterns = r"(password=|passwd=|pwd=|login=|username=|user=)"
df['is_password_attack'] = df['decoded_request'].apply(lambda x: 1 if re.search(password_attack_patterns, x, re.IGNORECASE) else 0)

# Identify Repeated Login Attempts by IP
df['is_repeated_login'] = df.groupby('client')['is_password_attack'].transform('sum').apply(lambda x: 1 if x > 5 else 0)

# Determine attack focus based on first detected attack (including Password-Based Attacks)
def determine_attack_focus(row):
    if row['is_sql_injection']:
        return 'SQL Injection'
    elif row['is_path_traversal']:
        return 'Path Traversal'
    elif row['is_ognl_injection']:
        return 'OGNL Injection'
    elif row['is_xss']:
        return 'XSS'
    elif row['is_rfi']:
        return 'Remote File Inclusion (RFI)'
    elif row['is_malicious_payload']:
        return 'Malicious Payload'
    elif row['is_http_methods_abuse']:
        return 'HTTP Methods Abuse'
    elif row['is_repeated_login']:
        return 'Repeated Login Attempts (Password Attack)'
    else:
        return 'No Attack Detected'

df['attack_focus'] = df.apply(determine_attack_focus, axis=1)

# Save the results in result.txt
try:
    df[df['attack_focus'] != 'No Attack Detected'].to_csv('result.txt', columns=['client', 'datetime', 'decoded_request', 'attack_focus'], index=False)
    print("Anomaly detection completed and results saved to result.txt.")
except Exception as e:
    with open('result.txt', 'w') as result_file:
        result_file.write(f"Error saving results: {str(e)}")
    print(f"Error saving results: {str(e)}")
    exit()
