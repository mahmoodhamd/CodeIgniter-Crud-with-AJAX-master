<!-- login_view.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
<?php

    // Check if the user is not logged in or does not have a valid remember me token
    if ($this->session->userdata('user_id') === null) {
        
       
        ?>
        <h2>Login</h2>
       
        <form action="<?php echo site_url('Auth/login'); ?>" method="POST">
            <label for="username_email">Username or Email:</label>
            <input type="text" name="email" id="email" required>
            <br>
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>
            <br>
            <input type="checkbox" name="remember_me" id="remember_me">
            <label for="remember_me">Remember Me</label>
            <button type="submit">Login</button>
        </form>
        <p>Don't have an account? <a href="<?php echo site_url('Auth/register_validation'); ?>">Register</a></p>
        <?php
    } else {
        // Display the user ID (or perform any other action you want)
        $this->session->userdata('user_id');
    
    }
?>


    
    
</body>
</html>

