# Website Anomaly Detection

This project is designed to analyze and detect anomalies in web server log files. The application performs several types of attack detection, including Path Traversal, SQL Injection, OGNL Injection, XSS, Remote File Inclusion (RFI), Malicious Payloads, HTTP Methods Abuse, and Password-Based Attacks.

## Features

- **Log Conversion:** Converts web server log files (`access.log`) into CSV format (`access.csv`).
- **Anomaly Detection:** Analyzes the converted CSV file for various types of security anomalies.
- **Attack Detection:** Identifies and categorizes different attack types.
- **Results Output:** Saves the results of the analysis to both a text file and a CSV file.

## Files

- `check.py`: Main script for converting log files to CSV, performing anomaly detection, and saving results.
- `result.txt`: Output file containing the summary of detected anomalies.
- `attack_detection_results.csv`: CSV file containing detailed detection results.

## Prerequisites

- Python 3.x
- Pandas
- tqdm

You can install the required Python packages using pip:

```bash
pip install pandas tqdm
