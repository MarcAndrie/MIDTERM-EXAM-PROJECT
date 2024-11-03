<?php
include 'core/models.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? AND user_type = 'staff'");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['user_type'] = 'staff';
        header("Location: staff.php");
        exit();
    } else {
        echo "<p style='color: red;'>Invalid login credentials.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Staff Login</title>
</head>
<body style="display: flex; justify-content: center; align-items: center; height: 100vh; background: linear-gradient(135deg, #2c2c2c, #1a1a1a); margin: 0; font-family: Arial, sans-serif;">
    <div style="text-align: center; padding: 40px; background: rgba(255, 255, 255, 0.1); border-radius: 15px; box-shadow: 0 8px 20px rgba(0, 0, 0, 0.5); backdrop-filter: blur(10px);">
        <h2 style="color: #f8f8f8; margin-bottom: 20px;">Login as Staff</h2>
        <form method="POST" action="login.php" style="color: #dddddd; font-size: 1.1em;">
            <label style="display: block; margin: 10px 0;">Email:</label>
            <input type="email" name="email" required style="padding: 10px; width: 100%; max-width: 300px; border: 1px solid #ff4d4d; border-radius: 5px; background: #333; color: white;">
            <br><br>
            <label style="display: block; margin: 10px 0;">Password:</label>
            <input type="password" name="password" required style="padding: 10px; width: 100%; max-width: 300px; border: 1px solid #ff4d4d; border-radius: 5px; background: #333; color: white;">
            <br><br>
            <input type="submit" value="Login" style="padding: 10px 20px; background-color: #ff4d4d; color: #ffffff; border: none; border-radius: 5px; cursor: pointer; font-size: 1.1em; transition: background-color 0.3s, transform 0.2s;">
        </form>
        <p style="margin-top: 20px; color: #dddddd;">Don't have an account? <a href="register.php" style="color: #ff4d4d; text-decoration: none;">Register here</a>.</p>
    </div>
    <script>
        // Add hover effects for the submit button
        const submitButton = document.querySelector('input[type="submit"]');
        submitButton.addEventListener('mouseover', () => {
            submitButton.style.backgroundColor = '#e60000';
            submitButton.style.transform = 'scale(1.05)';
        });
        submitButton.addEventListener('mouseout', () => {
            submitButton.style.backgroundColor = '#ff4d4d';
            submitButton.style.transform = 'scale(1)';
        });
    </script>
</body>
</html>
