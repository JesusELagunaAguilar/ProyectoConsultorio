<?php
// Inicia la sesión
session_start();


// Cierra la sesión
session_unset();
session_destroy();

// Redirige a la página principal después de cerrar la sesión
header("Location: http://localhost/consultorio/Login.php");
exit(); // Asegura que el script se detiene aquí y no se ejecuta más
?>
