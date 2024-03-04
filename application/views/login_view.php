<!-- login_view.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <!-- <//?php echo form_open('Auth/login'); ?> -->
    <form action="<?php echo site_url('Auth/login'); ?>" method="POST">
        <label for="username_email">Username or Email:</label>
        <input type="text" name="email" id="email" required>
        <br>
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required>
        <br>
        <button type="submit">Login</button>
</form>
<p>Don't have an account? <a href="<?php echo site_url('Auth/register_validation'); ?>">Register</a></p>
  
</body>
</html>
