<?php
session_start();

$admin_usuario = "admin";
$admin_contrasena = "1234";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['usuario'] ?? '';
    $contrasena = $_POST['contrasena'] ?? '';

    if ($usuario === $admin_usuario && $contrasena === $admin_contrasena) {
        $_SESSION['admin_logueado'] = true;
        header("Location: legajos_admin.php");
        exit;
    } else {
        header("Location: login_admin.html?error=1");
        exit;
    }
}
?>
