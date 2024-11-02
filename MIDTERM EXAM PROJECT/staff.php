<?php
include 'core/models.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'staff') {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$mangas = getAllMangas($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add'])) {
        $stmt = $pdo->prepare("INSERT INTO Manga (title, author, genre, publication_date, added_by) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$_POST['title'], $_POST['author'], $_POST['genre'], $_POST['publication_date'], $user_id]);
    } elseif (isset($_POST['update'])) {
        $stmt = $pdo->prepare("UPDATE Manga SET title = ?, author = ?, genre = ?, publication_date = ?, last_updated = NOW() WHERE manga_id = ?");
        $stmt->execute([$_POST['title'], $_POST['author'], $_POST['genre'], $_POST['publication_date'], $_POST['manga_id']]);
    } elseif (isset($_POST['delete'])) {
        $stmt = $pdo->prepare("DELETE FROM Manga WHERE manga_id = ?");
        $stmt->execute([$_POST['manga_id']]);
    }
}

$mangas = getAllMangas($pdo);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Staff Dashboard</title>
</head>
<body style="display: flex; flex-direction: column; align-items: center; background: linear-gradient(135deg, #2c2c2c, #1a1a1a); margin: 0; font-family: Arial, sans-serif; color: #f8f8f8;">
    <h1 style="margin-top: 20px;">Manga Management</h1>
    <div style="padding: 30px; background: rgba(255, 255, 255, 0.1); border-radius: 15px; box-shadow: 0 8px 20px rgba(0, 0, 0, 0.5); backdrop-filter: blur(10px); width: 80%; max-width: 800px;">

        <form method="POST" style="margin-bottom: 30px;">
            <h2 style="margin-bottom: 15px;">Add New Manga</h2>
            <input type="text" name="title" placeholder="Title" required style="padding: 8px; width: calc(100% - 16px); margin-bottom: 10px; border: 1px solid #ff4d4d; border-radius: 5px; background: #333; color: white;">
            <input type="text" name="author" placeholder="Author" required style="padding: 8px; width: calc(100% - 16px); margin-bottom: 10px; border: 1px solid #ff4d4d; border-radius: 5px; background: #333; color: white;">
            <input type="text" name="genre" placeholder="Genre" required style="padding: 8px; width: calc(100% - 16px); margin-bottom: 10px; border: 1px solid #ff4d4d; border-radius: 5px; background: #333; color: white;">
            <input type="date" name="publication_date" required style="padding: 8px; width: calc(100% - 16px); margin-bottom: 10px; border: 1px solid #ff4d4d; border-radius: 5px; background: #333; color: white;">
            <input type="submit" name="add" value="Add Manga" style="padding: 10px; background-color: #ff4d4d; color: #ffffff; border: none; border-radius: 5px; cursor: pointer; font-size: 1em; transition: background-color 0.3s;">
        </form>

        <h2 style="margin-bottom: 15px;">All Manga Entries</h2>
        <table style="width: 100%; border-collapse: collapse; margin-top: 15px;">
            <thead>
                <tr>
                    <th style="padding: 10px; background-color: #ff4d4d; color: white;">Title</th>
                    <th style="padding: 10px; background-color: #ff4d4d; color: white;">Author</th>
                    <th style="padding: 10px; background-color: #ff4d4d; color: white;">Genre</th>
                    <th style="padding: 10px; background-color: #ff4d4d; color: white;">Publication Date</th>
                    <th style="padding: 10px; background-color: #ff4d4d; color: white;">Added By</th>
                    <th style="padding: 10px; background-color: #ff4d4d; color: white;">Last Updated</th>
                    <th style="padding: 10px; background-color: #ff4d4d; color: white;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($mangas as $manga): ?>
                    <tr style="background: rgba(255, 255, 255, 0.1);">
                        <td style="padding: 10px;"><?= htmlspecialchars($manga['title']) ?></td>
                        <td style="padding: 10px;"><?= htmlspecialchars($manga['author']) ?></td>
                        <td style="padding: 10px;"><?= htmlspecialchars($manga['genre']) ?></td>
                        <td style="padding: 10px;"><?= htmlspecialchars($manga['publication_date']) ?></td>
                        <td style="padding: 10px;"><?= htmlspecialchars($manga['added_by']) ?></td>
                        <td style="padding: 10px;"><?= htmlspecialchars($manga['last_updated']) ?></td>
                        <td style="padding: 10px;">
                            <form method="POST" style="display: inline;">
                                <input type="hidden" name="manga_id" value="<?= $manga['manga_id'] ?>">
                                <input type="text" name="title" value="<?= htmlspecialchars($manga['title']) ?>" style="width: 60%; padding: 5px; border: 1px solid #ff4d4d; border-radius: 5px; background: #333; color: white;">
                                <input type="text" name="author" value="<?= htmlspecialchars($manga['author']) ?>" style="width: 60%; padding: 5px; border: 1px solid #ff4d4d; border-radius: 5px; background: #333; color: white;">
                                <input type="text" name="genre" value="<?= htmlspecialchars($manga['genre']) ?>" style="width: 60%; padding: 5px; border: 1px solid #ff4d4d; border-radius: 5px; background: #333; color: white;">
                                <input type="date" name="publication_date" value="<?= $manga['publication_date'] ?>" style="width: 60%; padding: 5px; border: 1px solid #ff4d4d; border-radius: 5px; background: #333; color: white;">
                                <input type="submit" name="update" value="Update" style="padding: 5px 10px; background-color: #ff4d4d; color: #ffffff; border: none; border-radius: 5px; cursor: pointer; font-size: 0.9em; margin-right: 5px;">
                                <input type="submit" name="delete" value="Delete" onclick="return confirm('Are you sure?');" style="padding: 5px 10px; background-color: #ff4d4d; color: #ffffff; border: none; border-radius: 5px; cursor: pointer; font-size: 0.9em;">
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
        <!-- Centered Logout Button -->
        <div style="text-align: center; margin-top: 30px;">
            <a href="logout.php" style="color: #ff4d4d; text-decoration: none; font-size: 1.2em;">Logout</a>
        </div>
    </div>
</body>
</html>
