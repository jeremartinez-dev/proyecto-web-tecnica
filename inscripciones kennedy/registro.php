<?php
session_start();

$servidor = "localhost";    
$usuarioBD = "root";      
$passwordBD = "";         
$base_datos = "usuarios";  

$conn = new mysqli($servidor, $usuarioBD, $passwordBD, $base_datos);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

if (isset($_POST['email']) && isset($_POST['contra'])) {
    $email = $_POST['email'];
    $contra = $_POST['contra'];

    $sql = "SELECT * FROM usu_datos WHERE email = '$email'";
    $resultado = $conn->query($sql);

    if ($resultado->num_rows > 0) {
        echo "<script>alert('Este correo ya está registrado, intenta con otro'); window.location.href='index.html';</script>";
        exit();
    }

    $sql = "INSERT INTO usu_datos (email, contra) VALUES ('$email', '$contra')";
    if ($conn->query($sql) === TRUE) {
        $_SESSION['email'] = $email;
        echo "<script>
            document.body.innerHTML += '<div id=\"loader-overlay\"><div class=\"loader\"></div></div>';
            document.getElementById('loader-overlay').style.display = 'flex';
            setTimeout(() => { window.location.href = \"index.html\"; }, 2000);
        </script>";
        
header("Location: index_log.html");
          exit();

    } else {
        echo "Error al registrar: " . $conn->error;
    }
} else {
    echo "No se enviaron datos válidos para el registro.";
}

$conn->close();
?>