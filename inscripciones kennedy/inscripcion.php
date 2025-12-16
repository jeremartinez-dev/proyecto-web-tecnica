<?php
include 'db.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Limpiar y obtener datos
    $nombre = trim($_POST['nombre'] ?? '');
    $apellido = trim($_POST['apellido'] ?? '');
    $dni = trim($_POST['dni'] ?? '');
    $fecha_nacimiento = trim($_POST['fecha_nacimiento'] ?? '');
    $nacionalidad = trim($_POST['nacionalidad'] ?? '');
    $domicilio = trim($_POST['domicilio'] ?? '');
    $telefono = trim($_POST['telefono'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $tecnicatura = trim($_POST['tecnicatura'] ?? '');
    $genero = trim($_POST['genero'] ?? '');

    // Validaciones básicas
    if (empty($nombre) || empty($apellido) || empty($dni) || empty($fecha_nacimiento) || empty($tecnicatura)) {
        die("Error: Todos los campos obligatorios deben completarse.");
    }

    if (!preg_match('/^\d+$/', $dni)) {
        die("Error: El DNI debe contener solo números.");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Error: Email inválido.");
    }

    $check = $conn->prepare("SELECT id FROM estudiantes WHERE dni = ?");
    if (!$check) {
        die("Error en la preparación (check): " . $conn->error);
    }
    $check->bind_param("s", $dni);
    $check->execute();
    $check->store_result();
    if ($check->num_rows > 0) {
        $check->close();
        die("Error: Ya existe un estudiante con el DNI " . htmlspecialchars($dni) . ".");
    }
    $check->close();

    // 
    $sql = "INSERT INTO estudiantes (nombre, apellido, dni, fecha_nacimiento, nacionalidad, domicilio, telefono, email, tecnicatura, genero)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Error en la preparación (insert): " . $conn->error);
    }

    $stmt->bind_param(
        "ssssssssss",
        $nombre,
        $apellido,
        $dni,
        $fecha_nacimiento,
        $nacionalidad,
        $domicilio,
        $telefono,
        $email,
        $tecnicatura,
        $genero
    );

    if ($stmt->execute()) {
        $stmt->close();
        header("Location: legajos.php?status=success");
        exit;
    } else {
        $err = $stmt->error;
        $stmt->close();
        die("Error al guardar la inscripción: " . $err);
    }
} else {
    header("Location: inscripcion.html");
    exit;
}
?>
