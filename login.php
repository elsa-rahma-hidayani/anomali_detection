<!DOCTYPE html>
<html>
<head>
    <title>Login Form</title>
    <link rel="stylesheet" type="text/css" href="CSS/Login.css"> 
</head>
<body>
    <div class="container">
        <div class="logo">
            <img src="your_logo.png" alt="Company Logo"> 
        </div>
        <h2>Login to your account</h2>
        <form>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" placeholder="Enter your email">
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" placeholder="Enter your password">
            </div>
            <button type="submit">SIGN IN</button>
            
            <div class="forgot">
            <a href="#">Forgot Password</a>
            </div>

            <div class="create">
            <a href="#">Create New Account</a>
            </div>
        </form>
    </div>
</body>
</html>