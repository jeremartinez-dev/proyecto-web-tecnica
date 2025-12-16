s<?php
session_start();

if (!isset($_SESSION['admin_logueado']) || $_SESSION['admin_logueado'] !== true) {
    header("Location: login_admin.html");
    exit;
}

include 'db_admin.php';

$sql = "SELECT * FROM estudiantes";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Legajos Admin</title>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');

    * { box-sizing: border-box; }

    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
      color: #fff;
      min-height: 100vh;
      overflow-x: hidden;
    }

    #fondo {
      position: fixed;
      top: 0; left: 0;
      width: 100%; height: 100%;
      z-index: -1;
    }

    h1 {
      text-align: center;
      margin-top: 30px;
      color: #fff;
      text-shadow: 0 3px 10px rgba(0,0,0,0.4);
      font-size: 32px;
      letter-spacing: 1px;
    }

    .tabla-container {
      background: rgba(255, 255, 255, 0.12);
      backdrop-filter: blur(12px);
      border-radius: 12px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
      max-width: 1100px;
      margin: 40px auto;
      padding: 20px;
      overflow-x: auto;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      border-radius: 10px;
      overflow: hidden;
    }

    th, td {
      padding: 14px;
      text-align: center;
    }

    th {
      background: rgba(0, 123, 255, 0.9);
      color: #fff;
      font-weight: 600;
    }

    tr:nth-child(even) { background: rgba(255, 255, 255, 0.08); }
    tr:nth-child(odd) { background: rgba(255, 255, 255, 0.15); }

    tr:hover {
      background: rgba(255, 255, 255, 0.25);
      transition: 0.3s;
    }

    .btn-borrar { background-color: #dc3545; }
    .btn-editar { background-color: #28a745; }

    .btn-borrar, .btn-editar {
      color: white;
      border: none;
      padding: 8px 12px;
      border-radius: 6px;
      cursor: pointer;
      transition: background 0.3s, transform 0.2s;
      font-weight: 500;
    }

    .btn-borrar:hover { background-color: #b02a37; transform: scale(1.05); }
    .btn-editar:hover { background-color: #218838; transform: scale(1.05); }

    .alerta {
      background: rgba(40, 167, 69, 0.85);
      color: white;
      border-radius: 6px;
      padding: 10px;
      margin: 20px auto;
      max-width: 500px;
      text-align: center;
      font-weight: 500;
      box-shadow: 0 4px 10px rgba(0,0,0,0.3);
    }

    .contenedor {
      text-align: center;
      margin: 30px 0;
    }

    .btn-volver {
      background-color: rgba(0, 123, 255, 0.9);
      color: white;
      border: none;
      padding: 12px 20px;
      border-radius: 6px;
      text-decoration: none;
      transition: background 0.3s, transform 0.2s;
      font-weight: 500;
    }

    .btn-volver:hover {
      background-color: #0056b3;
      transform: scale(1.05);
    }
  </style>
</head>
<body>

<div id="fondo"></div>

<h1>Panel de Legajos (Administrador)</h1>

<?php if (isset($_GET['deleted']) && $_GET['deleted'] == 1): ?>
  <div class="alerta"> Legajo eliminado correctamente.</div>
<?php endif; ?>


<div class="tabla-container">
  <table>
    <tr>
      <th>ID</th>
      <th>Nombre</th>
      <th>Apellido</th>
      <th>DNI</th>
      <th>Fecha de nacimiento</th>
      <th>Nacionalidad</th>
      <th>Domicilio</th>
      <th>Teléfono</th>
      <th>Email</th>
      <th>Tecnicatura</th>
      <th>Género</th>
      <th>Acciones</th>
    </tr>

    <?php while ($fila = $result->fetch_assoc()): ?>
    <tr>
      <td><?= $fila['id'] ?></td>
      <td><?= htmlspecialchars($fila['nombre']) ?></td>
      <td><?= htmlspecialchars($fila['apellido']) ?></td>
      <td><?= htmlspecialchars($fila['dni']) ?></td>
      <td><?= htmlspecialchars($fila['fecha_nacimiento']) ?></td>
      <td><?= htmlspecialchars($fila['nacionalidad']) ?></td>
      <td><?= htmlspecialchars($fila['domicilio']) ?></td>
      <td><?= htmlspecialchars($fila['telefono']) ?></td>
      <td><?= htmlspecialchars($fila['email']) ?></td>
      <td><?= htmlspecialchars($fila['tecnicatura']) ?></td>
      <td><?= htmlspecialchars($fila['genero']) ?></td>
      <td>
        <form action="editar_admin.php" method="GET" style="display:inline;">
          <input type="hidden" name="id" value="<?= $fila['id'] ?>">
          <button type="submit" class="btn-editar">Editar</button>
        </form>

        <form action="borrar_admin.php" method="POST" style="display:inline;" onsubmit="return confirmarBorrado()">
          <input type="hidden" name="id" value="<?= $fila['id'] ?>">
          <button type="submit" class="btn-borrar">Borrar</button>
        </form>
      </td>
    </tr>
    <?php endwhile; ?>
  </table>
</div>

<div class="contenedor">
  <a href="login_admin.html" class="btn-volver">⬅ Volver al Panel</a>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r134/three.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vanta@latest/dist/vanta.waves.min.js"></script>
<script>
VANTA.WAVES({
  el: "#fondo",
  mouseControls: true,
  touchControls: true,
  gyroControls: false,
  minHeight: 200.00,
  minWidth: 200.00,
  scale: 1.00,
  scaleMobile: 1.00,
  color: 0x0056b3,
  shininess: 50.00,
  waveHeight: 20.00,
  waveSpeed: 0.9,
  zoom: 0.9
})

function confirmarBorrado() {
  return confirm("¿Seguro que deseas borrar este legajo? Esta acción no se puede deshacer.");
}
</script>

</body>
</html>

<?php
$conn->close();
?>
