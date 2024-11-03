<?php
include 'core/models.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $age = htmlspecialchars($_POST['age']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);
    $username = htmlspecialchars($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check if the username already exists
    $checkStmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $checkStmt->execute([$username]);
    if ($checkStmt->rowCount() > 0) {
        echo "Error: Username already exists. Please choose a different username.";
    } else {
        // If the username does not exist, proceed with registration
        $stmt = $pdo->prepare("INSERT INTO users (name, age, email, phone, username, password, user_type) VALUES (?, ?, ?, ?, ?, ?, 'staff')");
        if ($stmt->execute([$name, $age, $email, $phone, $username, $password])) {
            echo "Registration successful! <a href='login.php'>Click here to log in</a>.";
        } else {
            echo "Error: Could not register. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Staff Registration</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            font-family: Arial, sans-serif;
            background: #2a2a2a;
            color: #f5f5f5;
            margin: 0;
        }
        .container {
            background: #333;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            width: 300px;
            text-align: center;
        }
        h2 {
            margin-bottom: 20px;
            color: #ff4d4d;
        }
        label {
            display: block;
            margin: 10px 0 5px;
            text-align: left;
        }
        input[type="text"], input[type="number"], input[type="email"], input[type="password"] {
            width: 100%;
            padding: 8px;
            border: none;
            border-radius: 4px;
            margin-bottom: 15px;
            background: #555;
            color: #f5f5f5;
        }
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 4px;
            background-color: #ff4d4d;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        input[type="submit"]:hover {
            background-color: #e60000;
        }
        .back-button {
            display: inline-block;
            margin-top: 15px;
            text-decoration: none;
            color: #ff4d4d;
            font-size: 14px;
            transition: color 0.3s;
        }
        .back-button:hover {
            color: #e60000;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Register as Staff</h2>
        <form method="POST" action="register.php">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="age">Age:</label>
            <input type="number" id="age" name="age" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="phone">Phone:</label>
            <input type="text" id="phone" name="phone" required>

            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <input type="submit" value="Register">
        </form>
        <a class="back-button" href="login.php">Back</a>
    </div>
</body>
</html>
