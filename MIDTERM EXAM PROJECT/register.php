<?php
include 'core/models.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $age = htmlspecialchars($_POST['age']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("INSERT INTO users (name, age, email, phone, password, user_type) VALUES (?, ?, ?, ?, ?, 'staff')");
    if ($stmt->execute([$name, $age, $email, $phone, $password])) {
        echo "<p style='color: green;'>Registration successful! <a href='login.php' style='color: red;'>Click here to log in</a>.</p>";
    } else {
        echo "<p style='color: red;'>Error: Could not register. Please try again.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Staff Registration</title>
</head>
<body style="display: flex; justify-content: center; align-items: center; height: 100vh; background: linear-gradient(135deg, #2c2c2c, #1a1a1a); margin: 0; font-family: Arial, sans-serif;">
    <div style="text-align: center; padding: 30px; background: rgba(255, 255, 255, 0.1); border-radius: 15px; box-shadow: 0 8px 20px rgba(0, 0, 0, 0.5); backdrop-filter: blur(10px);">
        <h2 style="color: #f8f8f8; margin-bottom: 15px;">Register as Staff</h2>
        <form method="POST" action="register.php" style="color: #dddddd; font-size: 1em;">
            <label style="display: block; margin: 5px 0;">Name:</label>
            <input type="text" name="name" required style="padding: 8px; width: 100%; max-width: 300px; border: 1px solid #ff4d4d; border-radius: 5px; background: #333; color: white;">
            
            <label style="display: block; margin: 5px 0;">Age:</label>
            <input type="number" name="age" required style="padding: 8px; width: 100%; max-width: 300px; border: 1px solid #ff4d4d; border-radius: 5px; background: #333; color: white;">
            
            <label style="display: block; margin: 5px 0;">Email:</label>
            <input type="email" name="email" required style="padding: 8px; width: 100%; max-width: 300px; border: 1px solid #ff4d4d; border-radius: 5px; background: #333; color: white;">
            
            <label style="display: block; margin: 5px 0;">Phone:</label>
            <input type="text" name="phone" required style="padding: 8px; width: 100%; max-width: 300px; border: 1px solid #ff4d4d; border-radius: 5px; background: #333; color: white;">
            
            <label style="display: block; margin: 5px 0;">Password:</label>
            <input type="password" name="password" required style="padding: 8px; width: 100%; max-width: 300px; border: 1px solid #ff4d4d; border-radius: 5px; background: #333; color: white;">
            
            <input type="submit" value="Register" style="padding: 10px 20px; background-color: #ff4d4d; color: #ffffff; border: none; border-radius: 5px; cursor: pointer; font-size: 1em; margin-top: 10px; transition: background-color 0.3s, transform 0.2s;">
        </form>
        <p style="margin-top: 10px; color: #dddddd;">Already have an account? <a href="login.php" style="color: #ff4d4d; text-decoration: none;">Log in here</a>.</p>
    </div>
    <script>
        // Add hover effects for the register button
        const registerButton = document.querySelector('input[type="submit"]');
        registerButton.addEventListener('mouseover', () => {
            registerButton.style.backgroundColor = '#e60000';
            registerButton.style.transform = 'scale(1.05)';
        });
        registerButton.addEventListener('mouseout', () => {
            registerButton.style.backgroundColor = '#ff4d4d';
            registerButton.style.transform = 'scale(1)';
        });
    </script>
</body>
</html>