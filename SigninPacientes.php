<!DOCTYPE html>
<html>
<head>
    <title>Registro de Paciente</title>
    <link rel="stylesheet" type="text/css" href="res\StyleLogin.css">
    <script src="https://kit.fontawesome.com/33bfb3cecc.js" crossorigin="anonymous"></script>
</head>
<body>
<div class="video-background">
        <video autoplay muted loop id="video-bg">
            <source src="res\fondo.mp4" type="video/mp4">
            Tu navegador no admite la etiqueta de video.
        </video>
    </div>
<div class="login-form">
        <h2>Crear un usuario</h2>
        <form method="POST" action="">
            <label for="nombreuser">Nombre de paciente:</label>
            <input type="text" name="Username" placeholder="Pacientes" required>

            <label for="correo">Correo Electrónico:</label>
            <input type="email" name="email" required>

            <label for="contra">Contraseña:</label>
            <input type="password" name="contra" required>

            <p>¿Ya tienes una cuenta? <a href="">Iniciar sesión</a></p>

            <input type="submit" value="Registrar">
        </form>
    </div>
</body>
</html>
<?php
include("Conexion.php");

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nombreuser = $_POST['Username'];
        $contra = $_POST['contra'];
        $correo = $_POST['email'];

        $consulta_existencia = "SELECT Username FROM usuario WHERE Username = ?";

        if ($stmt = $conn->prepare($consulta_existencia)) {
            $stmt->bind_param("s", $nombreuser);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                echo '<div class="notification error-notification">Error: Este nombre ya existe, pruebe con otro.</div>';
            } else {
                $stmt->close();
                $sql = "INSERT INTO usuario (Username, contra, email) VALUES (?, ?, ?)";

                    if ($stmt = $conn->prepare($sql)) {
                        $stmt->bind_param("sss", $nombreuser, $contra, $correo);
                        if ($stmt->execute()) {
                            echo '<div class="notification success-notification">Registro exitoso</div>';
                        } else {
                            echo '<div class="notification error-notification">Error: ' . $stmt->error . '</div>';
                        }

                        $stmt->close();
                    } else {
                        echo '<div class="notification error-notification">Error en la preparación de la declaración: ' . $conn->error . '</div>';
                    }
                }
            }
$conn->close();
    }
?>