<?php
include 'core/models.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'staff') {
    header('Location: login.php');
    exit();
}

$stmt = $pdo->prepare("SELECT * FROM ActivityLog ORDER BY action_time DESC");
$stmt->execute();
$logs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Activity Log</title>
</head>
<body>
    <h1>Activity Log</h1>
    <table border="1">
        <tr>
            <th>Log ID</th>
            <th>Action</th>
            <th>Manga ID</th>
            <th>Username</th>
            <th>Action Time</th>
        </tr>
        <?php foreach ($logs as $log): ?>
        <tr>
            <td><?= $log['log_id'] ?></td>
            <td><?= $log['action'] ?></td>
            <td><?= $log['manga_id'] ?></td>
            <td><?= htmlspecialchars($log['username']) ?></td>
            <td><?= $log['action_time'] ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
