<?php
include 'core/dbConfig.php';

// Get all mangas
function getAllMangas($pdo) {
    $stmt = $pdo->query("SELECT * FROM Manga");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Insert customer
function addCustomer($pdo, $name, $email, $phone) {
    $stmt = $pdo->prepare("INSERT INTO Customer (name, email, phone_number) VALUES (?, ?, ?)");
    $stmt->execute([$name, $email, $phone]);
    return $pdo->lastInsertId();
}

// Insert manga
function addManga($pdo, $title, $author, $genre, $publication_date) {
    $stmt = $pdo->prepare("INSERT INTO Manga (title, author, genre, publication_date) VALUES (?, ?, ?, ?)");
    $stmt->execute([$title, $author, $genre, $publication_date]);
}

// Update manga
function updateManga($pdo, $manga_id, $title, $author, $genre, $publication_date) {
    $stmt = $pdo->prepare("UPDATE Manga SET title = ?, author = ?, genre = ?, publication_date = ? WHERE manga_id = ?");
    $stmt->execute([$title, $author, $genre, $publication_date, $manga_id]);
}

// Delete manga
function deleteManga($pdo, $manga_id) {
    $stmt = $pdo->prepare("DELETE FROM Manga WHERE manga_id = ?");
    $stmt->execute([$manga_id]);
}
?>
