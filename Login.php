<!DOCTYPE html>
<html>
<head>
    <title>Inicio de sesion</title>
    <link rel="stylesheet" type="text/css" href="res\StyleLogin.css">
    <script src="https://kit.fontawesome.com/33bfb3cecc.js" crossorigin="anonymous"></script>
    <script src="res\script.js" defer></script>
    <script src="res\comando.js" defer></script>
</head>
<body>

<div class="video-background">
        <video autoplay muted loop id="video-bg">
            <source src="res\fondo.mp4" type="video/mp4">
            Tu navegador no admite la etiqueta de video.
        </video>
</div>
<body onload="nobackbutton();">
<div class="login-form">
        <h2>Iniciar sesión</h2>
        <form method="POST" action="#">
            <label for="nombreuser">Nombre de Administrador:</label>
            <input type="text" name="Username" placeholder="Administrador" required>

            <label for="contra">Contraseña</label>
            <div class="password-container">
                <input type="password" name="contra" id="password" required>
                <i class="fa-solid fa-eye" id="toggle-password"></i>
            </div>

            <p>¿No cuenta con una cuenta?</p>
            <a href="http://localhost/consultorio/SigninAdmin.php">Registrarse</a>
            <p></p>
            <input type="submit" value="Acceder">
        </form>
    </div>
</body>
</html>
<?php
session_start();
include("Conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['Username'];
    $contra = $_POST['contra'];

    // Consulta SQL para verificar las credenciales del usuario
    $consulta_usuario = "SELECT * FROM admin WHERE Username = ? AND contra = ?";
    
    if ($stmt = $conn->prepare($consulta_usuario)) {
        $stmt->bind_param("ss", $username, $contra);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows == 1) {
            // Inicio de sesión exitoso
            $_SESSION['Username'] = $username;
            header("location: http://localhost/consultorio/Index.html"); 
            echo '<div class="notification success-notification">Inicio exitoso</div>';// Redirige a la página después del inicio de sesión exitoso
        } else {
            // Credenciales incorrectas
            echo '<div class="notification error-notification">Error: Usuario o contraseña incorrectos.</div>';
        }
        $stmt->close();
    } else {
        echo '<div class="notification error-notification">Error en la preparación de la declaración: ' . $conn->error . '</div>';
    }
}
$conn->close();
?>