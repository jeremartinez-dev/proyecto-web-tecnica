<?php
include 'db_admin.php';
$id = $_POST['id'];
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$dni = $_POST['dni'];
$fecha_nacimiento = $_POST['fecha_nacimiento'];
$nacionalidad = $_POST['nacionalidad'];
$domicilio = $_POST['domicilio'];
$telefono = $_POST['telefono'];
$email = $_POST['email'];
$tecnicatura = $_POST['tecnicatura'];
$genero = $_POST['genero'];

$sql = "UPDATE legajos_admin SET nombre='$nombre', apellido='$apellido', dni='$dni', fecha_nacimiento='$fecha_nacimiento', nacionalidad='$nacionalidad', domicilio='$domicilio', telefono='$telefono', email='$email', tecnicatura='$tecnicatura',  genero='$genero'  WHERE id=$id";

if ($conn->query($sql) === TRUE) {
  header("Location: legajos_admin.php?editado=1");
} else {
  echo "Error al actualizar: " . $conn->error;
}
$conn->query($sql);

header("Location: inscripciones_admin.php");
?>
