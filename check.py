import pandas as pd
import re
import csv
import sys
from urllib.parse import unquote

# Load dataset
if len(sys.argv) != 2:
    print("Usage: python check.py <path_to_csvfile>")
    sys.exit(1)

csvfile = sys.argv[1]
df = pd.read_csv(csvfile)

# URL Decoding
df['decoded_request'] = df['request'].apply(unquote)

# Feature Extraction
def detect_attack_patterns(df):
    # Path Traversal
    df['is_path_traversal'] = df['decoded_request'].apply(lambda x: 1 if re.search(r'(\.\./|\.\.\\|%2F%2E%2E|%2E%2E%2F)', x) else 0)
    
    # SQL Injection
    sql_patterns = r"(\bUNION\b|\bSELECT\b|--|%27|%23|\bAND\b|\bOR\b|\bINFORMATION_SCHEMA\b|\bTABLES\b|\bFROM\b|\bWHERE\b)"
    df['is_sql_injection'] = df['decoded_request'].apply(lambda x: 1 if re.search(sql_patterns, x, re.IGNORECASE) else 0)
    
    # OGNL Injection
    ognl_patterns = r"(\$\{.*?\}|\#\{|@|\#context|\#request|\#response|\#session|\#application|\#servletContext|\#out|\#parameters|\#attr|\#header|\#cookie|\#method)"
    df['is_ognl_injection'] = df['decoded_request'].apply(lambda x: 1 if re.search(ognl_patterns, x, re.IGNORECASE) else 0)
    
    # XSS
    xss_patterns = r"(<script.*?>.*?</script.*?>|%3Cscript.*?%3E.*?%3C/script.*?%3E|<.*?on\w+=.*?>|<.*?javascript:.*?>|%3C.*?on\w+%3D.*?%3E|%3C.*?javascript:.*?%3E)"
    df['is_xss'] = df['decoded_request'].apply(lambda x: 1 if re.search(xss_patterns, x, re.IGNORECASE) else 0)
    
    # Remote File Inclusion (RFI)
    rfi_patterns = r"(https?://[^\s]+(\.php|\.txt|\.html)|ftp://[^\s]+(\.php|\.txt|\.html))"
    df['is_rfi'] = df['decoded_request'].apply(lambda x: 1 if re.search(rfi_patterns, x, re.IGNORECASE) else 0)
    
    # Malicious Payloads
    malicious_payload_patterns = r"(cmd=|exec=|shell=|bash=|powershell=|cmd.exe|/bin/bash|/bin/sh|%3B|%26|%7C)"
    df['is_malicious_payload'] = df['decoded_request'].apply(lambda x: 1 if re.search(malicious_payload_patterns, x, re.IGNORECASE) else 0)
    
    # HTTP Methods Abuse
    http_methods_abuse_patterns = r"(\bTRACE\b|\bTRACK\b|\bOPTIONS\b|\bCONNECT\b|\bDELETE\b|\bPUT\b|\bPATCH\b)"
    df['is_http_methods_abuse'] = df['method'].apply(lambda x: 1 if re.search(http_methods_abuse_patterns, x, re.IGNORECASE) else 0)
    
    # Password-Based Attacks
    password_attack_patterns = r"(password=|passwd=|pwd=|login=|username=|user=)"
    df['is_password_attack'] = df['decoded_request'].apply(lambda x: 1 if re.search(password_attack_patterns, x, re.IGNORECASE) else 0)
    
    # Repeated Login Attempts by IP
    df['is_repeated_login'] = df.groupby('client')['is_password_attack'].transform('sum').apply(lambda x: 1 if x > 5 else 0)
    
    # Denial of Service (DoS) Attacks
    df['request_count'] = df.groupby('client')['client'].transform('count')
    df['is_dos_attack'] = df['request_count'].apply(lambda x: 1 if x > 20 else 0)
    
    # Attack Focus
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
        elif row['is_password_attack']:
            return 'Password-Based Attack'
        elif row['is_dos_attack']:
            return 'Denial of Service (DoS) Attack'
        else:
            return 'Normal'

    df['attack_focus'] = df.apply(determine_attack_focus, axis=1)

    # Count anomalies
    totals = {
        'Path Traversal': df[df['is_path_traversal'] == 1].shape[0],
        'SQL Injection': df[df['is_sql_injection'] == 1].shape[0],
        'OGNL Injection': df[df['is_ognl_injection'] == 1].shape[0],
        'XSS': df[df['is_xss'] == 1].shape[0],
        'Remote File Inclusion (RFI)': df[df['is_rfi'] == 1].shape[0],
        'Malicious Payload': df[df['is_malicious_payload'] == 1].shape[0],
        'HTTP Methods Abuse': df[df['is_http_methods_abuse'] == 1].shape[0],
        'Password-Based Attacks': df[df['is_password_attack'] == 1].shape[0],
        'Denial of Service (DoS)': df[df['is_dos_attack'] == 1].shape[0]
    }

    # Print results
    for attack_type, count in totals.items():
        print(f"{attack_type}: {count}")

    # Save results to CSV
    df.to_csv('attack_detection_results.csv', index=False, quoting=csv.QUOTE_MINIMAL, escapechar='\\', doublequote=True)
