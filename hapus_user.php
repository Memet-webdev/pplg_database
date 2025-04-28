<?php
session_start();
include 'db.php';

// Pastikan hanya admin yang bisa hapus
if (!isset($_SESSION['admin_id'])) {
    header("Location: dashboard.php");
    exit();
}

// Proses hapus user
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);

    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        header("Location: dashboard.php?success=hapus");
        exit();
    } else {
        echo "Gagal menghapus user.";
    }
}
?>
