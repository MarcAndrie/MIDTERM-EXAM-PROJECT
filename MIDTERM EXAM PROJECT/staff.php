<?php
include 'core/models.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'staff') {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];
$mangas = getAllMangas($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add'])) {
        $stmt = $pdo->prepare("INSERT INTO Manga (title, author, genre, publication_date, added_by, last_updated_by) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$_POST['title'], $_POST['author'], $_POST['genre'], $_POST['publication_date'], $username, $username]);

        $manga_id = $pdo->lastInsertId();

        $logStmt = $pdo->prepare("INSERT INTO ActivityLog (action, manga_id, username) VALUES ('insert', ?, ?)");
        $logStmt->execute([$manga_id, $username]);

    } elseif (isset($_POST['update'])) {
        $stmt = $pdo->prepare("UPDATE Manga SET title = ?, author = ?, genre = ?, publication_date = ?, last_updated_by = ? WHERE manga_id = ?");
        $stmt->execute([$_POST['title'], $_POST['author'], $_POST['genre'], $_POST['publication_date'], $username, $_POST['manga_id']]);

        $logStmt = $pdo->prepare("INSERT INTO ActivityLog (action, manga_id, username) VALUES ('update', ?, ?)");
        $logStmt->execute([$_POST['manga_id'], $username]);

    } elseif (isset($_POST['delete'])) {
        $logStmt = $pdo->prepare("INSERT INTO ActivityLog (action, manga_id, username) VALUES ('delete', ?, ?)");
        $logStmt->execute([$_POST['manga_id'], $username]);

        $stmt = $pdo->prepare("DELETE FROM Manga WHERE manga_id = ?");
        $stmt->execute([$_POST['manga_id']]);
    }

    $mangas = getAllMangas($pdo);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Staff Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #1e1e1e;
            color: #e0e0e0;
            margin: 0;
            padding: 20px;
            text-align: center;
        }
        h1, h2 {
            color: #ff4d4d;
        }
        form {
            margin-bottom: 20px;
            text-align: center;
        }
        input[type="text"], input[type="date"], input[type="submit"] {
            padding: 8px;
            border: 1px solid #444;
            border-radius: 4px;
            background-color: #333;
            color: #e0e0e0;
            width: 100%;
            max-width: 300px;
            margin-bottom: 10px;
        }
        input[type="submit"] {
            background-color: #ff4d4d;
            font-weight: bold;
            cursor: pointer;
            width: auto;
        }
        input[type="submit"]:hover {
            background-color: #e60000;
        }
        table {
            width: 100%;
            max-width: 900px;
            margin: 20px auto;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #444;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #ff4d4d;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #2e2e2e;
        }
        .logout-btn {
            display: inline-block;
            margin-top: 30px;
            padding: 10px 20px;
            background-color: #ff4d4d;
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }
        .logout-btn:hover {
            background-color: #e60000;
        }
    </style>
</head>
<body>
    <h1>Manga Management</h1>

    <form method="POST">
        <h2>Add New Manga</h2>
        <input type="text" name="title" placeholder="Title" required><br>
        <input type="text" name="author" placeholder="Author" required><br>
        <input type="text" name="genre" placeholder="Genre" required><br>
        <input type="date" name="publication_date" required><br>
        <input type="submit" name="add" value="Add Manga">
    </form>

    <h2>All Manga Entries</h2>
    <?php if ($mangas): ?>
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Genre</th>
                    <th>Publication Date</th>
                    <th>Added By</th>
                    <th>Last Updated By</th>
                    <th>Last Updated</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($mangas as $manga): ?>
                    <tr>
                        <form method="POST">
                            <input type="hidden" name="manga_id" value="<?= $manga['manga_id'] ?>">
                            <td><input type="text" name="title" value="<?= htmlspecialchars($manga['title']) ?>" required></td>
                            <td><input type="text" name="author" value="<?= htmlspecialchars($manga['author']) ?>" required></td>
                            <td><input type="text" name="genre" value="<?= htmlspecialchars($manga['genre']) ?>" required></td>
                            <td><input type="date" name="publication_date" value="<?= $manga['publication_date'] ?>" required></td>
                            <td><?= htmlspecialchars($manga['added_by']) ?></td>
                            <td><?= htmlspecialchars($manga['last_updated_by']) ?></td>
                            <td><?= htmlspecialchars($manga['last_updated']) ?></td>
                            <td>
                                <input type="submit" name="update" value="Update">
                                <input type="submit" name="delete" value="Delete" onclick="return confirm('Are you sure?');">
                            </td>
                        </form>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No manga entries available.</p>
    <?php endif; ?>

    <a class="logout-btn" href="logout.php">Logout</a>
</body>
</html>
