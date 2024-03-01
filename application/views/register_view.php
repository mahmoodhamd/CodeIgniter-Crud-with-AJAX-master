<!-- register_view.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
</head>
<body>
    <h2>Register</h2>
    <!-- <//?php echo form_open('Auth/register_validation'); ?> -->
       <form action="<?php echo site_url('Auth/register_validation'); ?>" method="POST">
        <label for="username">Username:</label>
        <input type="text" name="name" id="username" required>
        <?php echo form_error('name'); ?>

        <br>
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required>
        <?php echo form_error('email'); ?>

        <br>
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required>
        <br>
        <button type="submit">Register</button>
      
        </form>
        
    <!-- <//?php echo form_close(); ?> -->
</body>
</html>
