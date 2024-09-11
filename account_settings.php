<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Settings</title>
    <link rel="stylesheet" href="assets/css/index.css">
    <style>
        /* Custom styles for Account Settings */
        .settings-container {
            max-width: 1200px; /* Perbesar lebar container */
            margin: 50px auto;
            padding: 40px; /* Tambah padding untuk memberikan lebih banyak ruang */
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .settings-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .settings-header h1 {
            font-size: 32px; /* Sedikit perbesar ukuran font untuk judul */
            color: #333;
        }

        .settings-section {
            margin-bottom: 30px;
        }

        .settings-section h2 {
            font-size: 22px; /* Perbesar subjudul */
            margin-bottom: 15px;
            color: #007BFF;
        }

        .settings-section label {
            display: block;
            font-size: 18px; /* Perbesar font label */
            margin-bottom: 10px;
            color: #555;
        }

        .settings-section input[type="text"],
        .settings-section input[type="email"],
        .settings-section input[type="password"] {
            width: 100%;
            padding: 12px; /* Perbesar padding input */
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ddd;
            margin-bottom: 20px;
        }

        .settings-section button {
            padding: 12px 30px; /* Tambah padding pada tombol */
            font-size: 18px;
            color: #fff;
            background-color: #007BFF;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .settings-section button:hover {
            background-color: #0056b3;
        }

        .settings-footer {
            text-align: center;
            margin-top: 20px;
        }

        .settings-footer button {
            padding: 12px 30px; /* Tambah padding pada tombol */
            font-size: 18px;
            color: #fff;
            background-color: #f44336;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .settings-footer button:hover {
            background-color: #d32f2f;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group input[type="checkbox"] {
            margin-right: 10px;
        }
    </style>
</head>
<body>

    <div class="settings-container">
        <div class="settings-header">
            <h1>Account Settings</h1>
        </div>

        <form action="save_settings.php" method="POST">

            <!-- Profile Information Section -->
            <div class="settings-section">
                <h2>Profile Information</h2>
                <label for="full_name">Full Name</label>
                <input type="text" id="full_name" name="full_name" value="John Doe">

                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" value="john.doe@example.com">
            </div>

            <!-- Password Section -->
            <div class="settings-section">
                <h2>Change Password</h2>
                <label for="current_password">Current Password</label>
                <input type="password" id="current_password" name="current_password">

                <label for="new_password">New Password</label>
                <input type="password" id="new_password" name="new_password">

                <label for="confirm_password">Confirm New Password</label>
                <input type="password" id="confirm_password" name="confirm_password">
            </div>

            <!-- Notifications Section -->
            <div class="settings-section">
                <h2>Notifications</h2>
                <div class="form-group">
                    <input type="checkbox" id="email_notifications" name="email_notifications" checked>
                    <label for="email_notifications">Email Notifications</label>
                </div>

                <div class="form-group">
                    <input type="checkbox" id="sms_notifications" name="sms_notifications">
                    <label for="sms_notifications">SMS Notifications</label>
                </div>
            </div>

            <!-- Save Changes Button -->
            <div class="settings-section">
                <button type="submit">Save Changes</button>
            </div>
        </form>

        <!-- Danger Zone -->
        <div class="settings-footer">
            <h2>Danger Zone</h2>
            <button>Delete Account</button>
        </div>
    </div>

</body>
</html>
