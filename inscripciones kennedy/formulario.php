<?php
session_start();
$servidor = "localhost";    
$usuarioBD = "root";      
$passwordBD = "";         
$base_datos = "usuarios";  

$conn = new mysqli($servidor, $usuarioBD, $passwordBD, $base_datos);

if (isset($_POST['email']) && isset($_POST['contra'])) {
    $email = $_POST['email'];
    $contra = $_POST['contra'];

    $sql = "SELECT * FROM usu_datos WHERE email = '$email'";
    $resultado = $conn->query($sql);

    if ($resultado->num_rows > 0) {
        echo "<script>alert('Este correo ya está registrado, intenta con otro'); window.location.href='index.html';</script>";
        exit();
    }
//hacer la base de datos de esto que esta abajo
    $sql = "INSERT INTO formulario (nombre, email, telefono,mensaje) VALUES ('$nombre','$email','$telefono','$mensaje')";
    if ($conn->query($sql) === TRUE) {
        $_SESSION['email'] = $email;
        echo "se envio el formulario; window.location.href='index.html' ";
        
header("Location: index_log.html");
          exit();

    } else {
        echo "Error al mandar el mensaje: " . $conn->error;
    }
} else {
    echo "No se.";
}

?>