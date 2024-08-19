<!DOCTYPE html>
<html>
<head>
  <title>Create Account</title>
  <link rel="stylesheet" type="text/css" href="CSS/Register.css"> 
</head>
<body>
  <div class="container">
    <h1>Create an Account</h1>
    <form>
      <div class="form-group">
        <label for="full_name">Full Name</label>
        <input type="text" id="full_name" name="full_name" required>
      </div>
      <div class="form-group">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" required>
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" required>
      </div>
      <button type="submit">CREATE ACCOUNT</button>
    </form>
    <a href="login.php" class="sign-in">Sign In</a>
  </div>
</body>
</html>