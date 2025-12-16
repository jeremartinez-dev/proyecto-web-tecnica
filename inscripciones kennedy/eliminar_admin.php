<?php
include 'db_admin.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $conn->query("DELETE FROM estudiantes WHERE id = $id");
}

header("Location: legajos_admin.php");
exit;
?>
