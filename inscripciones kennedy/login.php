<?php
session_start();
$servidor = "localhost";    
$usuarioBD = "root";      
$passwordBD = "";         
$base_datos = "usuarios";  

$conn = new mysqli($servidor, $usuarioBD, $passwordBD, $base_datos);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if (isset($_POST['email']) && isset($_POST['contra'])) {
    $email = $_POST['email'];
    $contra = $_POST['contra'];

    $sql = "SELECT * FROM usu_datos WHERE email = '$email'";
    $resultado = $conn->query($sql);

    if ($resultado->num_rows > 0) {
        $fila = $resultado->fetch_assoc();

        if ($fila['contra'] === $contra) {

            $_SESSION['email'] = $email;

            echo "<script>
                    document.body.innerHTML += '<div id=\"loader-overlay\"><div class=\"loader\"></div></div>';
                    document.getElementById('loader-overlay').style.display = 'flex';
                    setTimeout(() => { window.location.href = \"index.html\"; }, 2000);
                  </script>";

                      header("Location: index_log.html");
            exit();

        } else {
            echo "
<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
<script>
Swal.fire({
  icon: 'error',
  title: 'Contraseña incorrecta',
  text: 'Intenta nuevamente',
  confirmButtonText: 'Aceptar'
}).then(function() {
    window.location.href = 'login.html';
});
</script>
";
            exit();
        }

    } else {
                // ❌ EMAIL NO EXISTE — usar mismo popup
        echo "
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script>
        Swal.fire({
          icon: 'error',
          title: 'Usuario no encontrado',
          text: 'Revisa el email ingresado',
          confirmButtonText: 'Aceptar'
        }).then(function() {
            window.location.href = 'login.html';
        });
        </script>";
        exit();
    }

} else {
    echo "No se enviaron datos de inicio de sesión.";
}

$conn->close();
?>
