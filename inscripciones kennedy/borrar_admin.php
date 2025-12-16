<?php
session_start();

if (!isset($_SESSION['admin_logueado']) || $_SESSION['admin_logueado'] !== true) {
    header("Location: login_admin.html");
    exit;
}

include 'db_admin.php';

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['id'])) {
    $id = intval($_POST['id']);

    $stmt = $conn->prepare("DELETE FROM estudiantes WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $stmt->close();
    $conn->close();

    header("Location: legajos_admin.php?deleted=1");
    exit;
} else {
    header("Location: legajos_admin.php");
    exit;
}
?>
