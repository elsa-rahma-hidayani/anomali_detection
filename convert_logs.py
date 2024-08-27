import re
import pandas as pd
from tqdm import tqdm
from urllib.parse import unquote
import csv
import sys
import os

# Define regex patterns and columns
combined_regex = r'^(?P<client>\S+) \S+ (?P<userid>\S+) \[(?P<datetime>[^\]]+)\] "(?P<method>[A-Z]+) (?P<request>[^ "]+)? HTTP/[0-9.]+" (?P<status>[0-9]{3}) (?P<size>[0-9]+|-) "(?P<referrer>[^"]*)" "(?P<useragent>[^"]*)"'
columns = ['client', 'userid', 'datetime', 'method', 'request', 'status', 'size', 'referrer', 'user_agent']

def logs_to_df(logfile):
    parsed_lines = []
    with open(logfile) as source_file:
        for line in tqdm(source_file):
            try:
                log_line = re.findall(combined_regex, line)[0]
                parsed_lines.append(log_line)
            except Exception as e:
                continue

    # Convert parsed lines to DataFrame
    df = pd.DataFrame(parsed_lines, columns=columns)
    return df

def decode_url(encoded_str):
    try:
        return unquote(encoded_str)
    except Exception as e:
        return encoded_str

# Main function to convert the log file
if __name__ == "__main__":
    if len(sys.argv) != 2:
        print("Usage: python convert_logs.py <path_to_logfile>")
        sys.exit(1)
    
    logfile = sys.argv[1]
    output_csv = 'access.csv'
    
    # Load log file and convert to DataFrame
    df = logs_to_df(logfile)

    # Save DataFrame to CSV
    df.to_csv(output_csv, index=False, quoting=csv.QUOTE_MINIMAL, escapechar='\\', doublequote=True)
    
    print(f"Log file converted to CSV: {output_csv}")
