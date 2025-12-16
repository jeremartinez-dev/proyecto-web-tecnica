<?php
include 'db.php';

$sql = "SELECT id, nombre, apellido, dni, fecha_nacimiento, tecnicatura, fecha_inscripcion 
        FROM estudiantes ORDER BY fecha_inscripcion DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Legajos de Estudiantes</title>
    <link rel="stylesheet" href="style.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');
        body {
            font-family: 'Poppins', sans-serif;
            background: #f4f6fa;
            margin: 0;
            padding: 0;
        }
        header {
            background: #004aad;
            color: white;
            text-align: center;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
        }
        .container {
            width: 90%;
            max-width: 1000px;
            margin: 40px auto;
            background: white;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .top-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }
        .top-actions a {
            text-decoration: none;
            background-color: #007bff;
            color: white;
            padding: 10px 15px;
            border-radius: 8px;
            transition: 0.3s;
        }
        .top-actions a:hover { background-color: #0056b3; }
        .search-box {
            padding: 8px 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
            width: 200px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            border-radius: 8px;
            overflow: hidden;
        }
        thead { background-color: #004aad; color: white; }
        th, td { padding: 12px 15px; text-align: left; }
        tr:nth-child(even) { background-color: #f2f6fc; }
        tr:hover { background-color: #e8f0fe; transition: 0.2s; }
        .success {
            color: green; font-weight: bold; background: #e9ffe9;
            border: 1px solid #b6f5b6; padding: 10px;
            border-radius: 6px; text-align: center;
        }
        @media (max-width: 600px) {
            table { font-size: 12px; }
            .search-box { width: 100%; margin-top: 10px; }
        }
    </style>
</head>
<body>
<header>
    <h1>Legajos de Estudiantes - Escuela Técnica Kennedy</h1>
</header>

<div class="container">

    <?php if (isset($_GET['status']) && $_GET['status'] === 'success'): ?>
        <p class="success">¡Estudiante inscrito con éxito!</p>
    <?php endif; ?>

    <div class="top-actions">
        <a href="inscripcion.html">← Nueva Inscripción</a>
        <input type="text" id="searchInput" class="search-box" placeholder="Buscar por nombre...">
    </div>

    <?php if ($result && $result->num_rows > 0): ?>
        <table id="tablaEstudiantes">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre Completo</th>
                    <th>DNI (Oculto)</th>
                    <th>Fecha Nacimiento (Oculta)</th>
                    <th>Tecnicatura</th>
                    <th>Fecha Inscripción</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <?php
                    $dni_mostrado = substr($row['dni'], 0, 2) . str_repeat('*', strlen($row['dni']) - 4) . substr($row['dni'], -2);
                    $fecha_oculta = date("Y", strtotime($row['fecha_nacimiento']));
                ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                    <td><?php echo htmlspecialchars($row['nombre'] . ' ' . $row['apellido']); ?></td>
                    <td><?php echo htmlspecialchars($dni_mostrado); ?></td>
                    <td><?php echo "Año de nacimiento: " . htmlspecialchars($fecha_oculta); ?></td>
                    <td><?php echo htmlspecialchars($row['tecnicatura']); ?></td>
                    <td><?php echo date("d/m/Y H:i", strtotime($row['fecha_inscripcion'])); ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No hay estudiantes inscritos aún.</p>
    <?php endif; ?>
</div>

<script>
const input = document.getElementById('searchInput');
const table = document.getElementById('tablaEstudiantes').getElementsByTagName('tbody')[0];

input.addEventListener('keyup', function() {
    const filtro = this.value.toLowerCase();
    const filas = table.getElementsByTagName('tr');
    for (let i = 0; i < filas.length; i++) {
        const columnas = filas[i].getElementsByTagName('td');
        const texto = (columnas[1].textContent).toLowerCase();
        filas[i].style.display = texto.includes(filtro) ? '' : 'none';
    }
});
</script>

</body>
</html>
