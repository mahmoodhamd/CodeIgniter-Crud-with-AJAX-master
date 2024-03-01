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
    <form action="<?php echo site_url('Auth/login'); ?>"></form>
        <label for="username_email">Username or Email:</label>
        <input type="text" name="username_email" id="username_email" required>
        <br>
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required>
        <br>
        <button type="submit">Login</button>
    <?php echo form_close(); ?>
</body>
</html>
