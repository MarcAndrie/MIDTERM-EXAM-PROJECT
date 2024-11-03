<?php
include 'core/models.php';
$mangas = getAllMangas($pdo);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Available Manga</title>
    <style>
        body {
            display: flex;
            flex-direction: column;
            align-items: center;
            background: linear-gradient(135deg, #2c2c2c, #1a1a1a);
            margin: 0;
            font-family: Arial, sans-serif;
            color: #f8f8f8;
            padding: 20px;
        }
        h1 {
            margin-bottom: 20px;
        }
        .manga-container {
            width: 80%;
            max-width: 800px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.5);
        }
        .manga-entry {
            margin-bottom: 15px;
            padding: 10px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 10px;
        }
        .manga-entry strong {
            color: #ff4d4d;
        }
        hr {
            border: 1px solid #ff4d4d;
            margin: 10px 0;
        }
        .no-manga {
            text-align: center;
            font-size: 1.2em;
        }
        .back-button {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #ff4d4d;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            text-align: center;
            transition: background-color 0.3s;
        }
        .back-button:hover {
            background-color: #e60000;
        }
    </style>
</head>
<body>
    <h1>Available Manga</h1>
    <div class="manga-container">
        <?php if ($mangas): ?>
            <?php foreach ($mangas as $manga): ?>
                <div class="manga-entry">
                    <p><strong>Title:</strong> <?= htmlspecialchars($manga['title']) ?></p>
                    <p><strong>Author:</strong> <?= htmlspecialchars($manga['author']) ?></p>
                    <p><strong>Genre:</strong> <?= htmlspecialchars($manga['genre']) ?></p>
                    <p><strong>Publication Date:</strong> <?= htmlspecialchars($manga['publication_date']) ?></p>
                </div>
                <hr>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="no-manga">No manga available at the moment.</p>
        <?php endif; ?>
    </div>
    <a class="back-button" href="index.php">Back</a>
</body>
</html>
