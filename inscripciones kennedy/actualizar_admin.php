<?php
session_start();

if (!isset($_SESSION['admin_logueado']) || $_SESSION['admin_logueado'] !== true) {
    header("Location: login_admin.html");
    exit;
}

include 'db_admin.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = intval($_POST['id']);
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $dni = $_POST['dni'];
    $email = $_POST['email'];
    $tecnicatura = $_POST['tecnicatura'];
    $nacionalidad = $_POST['nacionalidad'];
    $domicilio = $_POST['domicilio'];
    $telefono = $_POST['telefono'];
    $genero= $_POST['genero'];

    $stmt = $conn->prepare("UPDATE estudiantes SET nombre=?, apellido=?, dni=?, email=?, tecnicatura=?, nacionalidad=?, domicilio=?, telefono=?, genero=? WHERE id=?");
    $stmt->bind_param("sssssssssi", $nombre, $apellido, $dni, $email, $tecnicatura, $nacionalidad, $domicilio, $telefono, $genero, $id);

    if ($stmt->execute()) {
        header("Location: legajos_admin.php?updated=1");
        exit;
    } else {
        echo "Error al actualizar el legajo: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>
