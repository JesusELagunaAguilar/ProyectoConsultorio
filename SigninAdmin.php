<!DOCTYPE html>
<html>
<head>
    <title>Registro</title>
    <link rel="stylesheet" type="text/css" href="res\StyleLogin.css">
    <script src="https://kit.fontawesome.com/33bfb3cecc.js" crossorigin="anonymous"></script>
    <script src="res\script.js" defer></script>
</head>
<body>
<div class="back"><a href="Index.html"><i class="fas fa-home"></i></a></div>
<div class="video-background">
        <video autoplay muted loop id="video-bg">
            <source src="res\fondo.mp4" type="video/mp4">
            Tu navegador no admite la etiqueta de video.
        </video>
</div>
<div class="login-form">
        <h2>Crear un administrador</h2>
        <form method="POST" action="#">
            <label for="nombreuser">Nombre de Administrador:</label>
            <input type="text" name="Username" placeholder="Administradores" required>
            
            <label for="contra">Contraseña</label>
            <div class="password-container">
                <input type="password" name="contra" id="password" required>
                <i class="fa-solid fa-eye" id="toggle-password"></i>
            </div>
            <label for="correo">Correo Electrónico:</label>
            <input type="email" name="email" placeholder="Example: correo@hotmail.com" required>

            <p>¿Ya tienes una cuenta? <a href="http://localhost/consultorio/Login.php">Iniciar sesión</a></p>

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

                $consulta_existencia = "SELECT Username FROM admin WHERE Username = ?";

                if ($stmt = $conn->prepare($consulta_existencia)) {
                    $stmt->bind_param("s", $nombreuser);
                    $stmt->execute();
                    $stmt->store_result();

                    if ($stmt->num_rows > 0) {
                        echo '<div class="notification error-notification">Error: Este nombre ya existe, pruebe con otro.</div>';
                    } else {
                        $stmt->close();
                        $sql = "INSERT INTO admin (Username, contra, email) VALUES (?, ?, ?)";

                        if ($stmt = $conn->prepare($sql)) {
                            $stmt->bind_param("sss", $nombreuser, $contra, $correo);
                            if ($stmt->execute()) {
                                echo '<div class="notification success-notification">Registro exitoso</div>';
                                header("location: http://localhost/consultorio/Login.php"); 
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