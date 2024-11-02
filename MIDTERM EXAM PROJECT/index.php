<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manga Cafe - Role Selection</title>
</head>
<body style="display: flex; justify-content: center; align-items: center; height: 100vh; font-family: Arial, sans-serif; background-color: #2b2b2b; margin: 0;">
    <div style="text-align: center; padding: 40px; background: linear-gradient(135deg, #444444, #555555); border-radius: 15px; box-shadow: 0 8px 20px rgba(0, 0, 0, 0.5);">
        <h1 style="color: #f8f8f8; margin-bottom: 20px; font-size: 2.5em;">Welcome to Manga Cafe</h1>
        <p style="color: #dddddd; margin-bottom: 30px; font-size: 1.2em;">Please choose your role:</p>
        <a href="login.php" style="text-decoration: none;">
            <button style="padding: 15px 30px; margin: 10px; background-color: #bf5669; color: #ffffff; border: none; border-radius: 5px; cursor: pointer; font-size: 1.2em; transition: background-color 0.3s, transform 0.2s;">
                Staff
            </button>
        </a>
        <a href="customer.php" style="text-decoration: none;">
            <button style="padding: 15px 30px; margin: 10px; background-color: #bf5669; color: #ffffff; border: none; border-radius: 5px; cursor: pointer; font-size: 1.2em; transition: background-color 0.3s, transform 0.2s;">
                Customer
            </button>
        </a>
    </div>

    <script>
        // Add hover effects for buttons
        document.querySelectorAll('button').forEach(button => {
            button.addEventListener('mouseover', () => {
                button.style.backgroundColor = '#bf5669';
                button.style.transform = 'scale(1.05)';
            });
            button.addEventListener('mouseout', () => {
                button.style.backgroundColor = '#bf5669';
                button.style.transform = 'scale(1)';
            });
        });
    </script>
</body>
</html>
