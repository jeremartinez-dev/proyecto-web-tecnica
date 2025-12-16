<?php
session_start();

if (!isset($_SESSION['admin_logueado']) || $_SESSION['admin_logueado'] !== true) {
    header("Location: login_admin.html");
    exit;
}

include 'db_admin.php';

if (!isset($_GET['id'])) {
    header("Location: legajos_admin.php");
    exit;
}

$id = intval($_GET['id']);
$sql = "SELECT * FROM estudiantes WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "No se encontró el legajo.";
    exit;
}

$alumno = $result->fetch_assoc();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Legajo</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f5f8ff;
            margin: 0;
            padding: 20px;
        }

        h1 {
            color: #0056b3;
            text-align: center;
        }

        form {
            background-color: white;
            max-width: 500px;
            margin: 30px auto;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        label {
            display: block;
            margin-top: 10px;
            color: #333;
            font-weight: bold;
        }

        input, select {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            background-color: #0056b3;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 15px;
        }

        button:hover {
            background-color: #004099;
        }

        .volver {
            display: block;
            text-align: center;
            margin-top: 15px;
            color: #0056b3;
            text-decoration: none;
        }

        .volver:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<h1>Editar Legajo</h1>

<form action="actualizar_admin.php" method="POST">
    <input type="hidden" name="id" value="<?= htmlspecialchars($alumno['id']) ?>">

    <label>Nombre:</label>
    <input type="text" name="nombre" value="<?= htmlspecialchars($alumno['nombre']) ?>" required>

    <label>Apellido:</label>
    <input type="text" name="apellido" value="<?= htmlspecialchars($alumno['apellido']) ?>" required>

    <label>DNI:</label>
    <input type="text" name="dni" value="<?= htmlspecialchars($alumno['dni']) ?>" required>

    <label>Fecha de nacimiento:</label>
    <input type="date" name="fecha_nacimiento" value="<?= htmlspecialchars($alumno['fecha_nacimiento']) ?>" required>

    <label>Nacionalidad:</label>
    <input type="text" name="nacionalidad" value="<?= htmlspecialchars($alumno['nacionalidad']) ?>" required>

    <label>Domicilio:</label>
    <input type="text" name="domicilio" value="<?= htmlspecialchars($alumno['domicilio']) ?>" required>

    <label>Teléfono / Celular:</label>
    <input type="text" name="telefono" value="<?= htmlspecialchars($alumno['telefono']) ?>" required>

    <label>Email:</label>
    <input type="email" name="email" value="<?= htmlspecialchars($alumno['email']) ?>" required>

    <label>Tecnicatura:</label>
    <select name="tecnicatura" required>
        <option value="Programación" <?= ($alumno['tecnicatura'] == 'Programación') ? 'selected' : '' ?>>Programación</option>
        <option value="Informática" <?= ($alumno['tecnicatura'] == 'Informática') ? 'selected' : '' ?>>Informática</option>
        <option value="Electromecánica" <?= ($alumno['tecnicatura'] == 'Electromecánica') ? 'selected' : '' ?>>Electromecánica</option>
    </select>

    <label>Género:</label>
    <select name="genero" required>
        <option value="Masculino" <?= ($alumno['genero'] == 'Masculino') ? 'selected' : '' ?>>Masculino</option>
        <option value="Femenino" <?= ($alumno['genero'] == 'Femenino') ? 'selected' : '' ?>>Femenino</option>
        <option value="Otro" <?= ($alumno['genero'] == 'Otro') ? 'selected' : '' ?>>Otro</option>
    </select>

    <button type="submit">Guardar cambios</button>
</form>

<a class="volver" href="legajos_admin.php">⬅ Volver a Legajos</a>

</body>
</html>
