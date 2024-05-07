<?php
include("Conexion.php");

if (!$conn) {
    die("La conexión falló: " . mysqli_connect_error());
}

$curpDeseada = '';
$curpNoEncontrada = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["deleteBtn"])) {
        // Verificar que la CURP no esté vacía antes de intentar eliminar
        $curpToDelete = $_POST["curpToDelete"];
        if (!empty($curpToDelete)) {
            $deleteSql = "DELETE FROM historial WHERE Curp = '$curpToDelete'";
            $deleteResult = mysqli_query($conn, $deleteSql);

            if ($deleteResult === false) {
                echo '<div class="notification error-notification">Error al eliminar: ' . mysqli_error($conn) . '</div>';
            } else {
                $rowsAffected = mysqli_affected_rows($conn);

                if ($rowsAffected > 0) {
                    echo '<div class="notification success-notification">Paciente eliminado correctamente</div>';
                } else {
                    echo '<div class="notification error-notification">No se encontró ningún paciente con la CURP proporcionada</div>';
                }
            }
        } else {
            echo '<div class="notification error-notification">El campo está vacío, digite la CURP a eliminar</div>';
        }
    } else {
        // Obtiene la CURP del formulario
        $curpDeseada = isset($_POST["curp"]) ? $_POST["curp"] : '';

        // Verifica que la CURP no esté vacía antes de ejecutar la consulta
        if (!empty($curpDeseada)) {
            $sql = "SELECT `Nombre(s)`, `Apellidop`, `Apellidom`, `Genero`, `Direccion`, `Celular`, `Enfermedadescro`,
                    `Condicionesmed`, `Cirugiasant`, `Alergias`, `Vacunas`, `Enfermrec`, `Tratamientosant`,
                    `Sangre`, `Nombrecon`, `Apellidocon`, `Numcon`, `Exammed`, `Curp`, `FechaN` FROM historial
                    WHERE Curp = '$curpDeseada'";

            $result = mysqli_query($conn, $sql);

            if ($result === false) {
                echo '<div class="notification error-notification">Error en la consulta: ' . mysqli_error($conn) . '</div>';
            } else {
                $data = [];
                while ($row = mysqli_fetch_assoc($result)) {
                    $data[] = $row;
                }

                if (empty($data)) {
                    // Si no hay resultados, mostrar notificación de paciente inexistente
                    $curpNoEncontrada = true;
                    echo '<div class="notification error-notification">Paciente inexistente</div>';
                } else {
                    echo '<div class="notification success-notification">Se encontró un registro</div>';
                }
            }
        } else {
            echo '<div class="notification error-notification">El campo está vacío, digite la CURP a consultar</div>';
        }
    }
}

// Cerrar la conexión
mysqli_close($conn);
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta por CURP</title>
    <link rel="stylesheet" href="res\StyleCons.css">
    <script src="https://kit.fontawesome.com/33bfb3cecc.js" crossorigin="anonymous"></script>
</head>
<body>
<div class="back"><a href="Index.html"><i class="fas fa-home"></i></a></div>

    <h1>Consulta por CURP</h1>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="curp">Ingrese la CURP:</label>
        <input type="text" id="curp" name="curp" value="<?php echo $curpDeseada; ?>">
        <button type="submit" name="search" class="btsearch">Buscar</button>
    </form>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <input type="hidden" name="curpToDelete" value="<?php echo $curpDeseada; ?>">
        <button type="submit" name="deleteBtn" class="elimin">Eliminar</button>
    </form>

    <?php if (!empty($data)): ?>
        <h2>Datos de la Tabla para CURP: <?php echo $curpDeseada; ?></h2>

        <div class="table-container">
            <table class="headers-table" border="1">
            <tr>
                <th>Curp</th>
                <th>Nombre(s)</th>
                <th>Apellido Paterno</th>
                <th>Apellido Materno</th>
                <th>Fecha De Nacimiento</th>
                <th>Genero</th>
                <th>Direccion</th>
                <th>Numero De Telefono</th>
                <th>Enfermedades Cronicas del paciente</th>
                <th>Condicion Medica Del Paciente</th>
                <th>Antecedentes De Cirugia</th>
                <th>Tipos de Alergia</th>
                <th>Antecedentes De Vacunas</th>
                <th>Enfermedades Recientes</th>
                <th>Tratamientos Anteriores</th>
                <th>Tipo de Sangre</th>
                <th>Nombre De Contacto De Emergencia</th>
                <th>Apellido De Contacto De Emergencia</th>
                <th>Numero De Contacto De Emergencia</th>
                <th>Examenes medicos</th>
            </tr>
            </table>
            <table class="data-table" border="1">
            <?php foreach ($data as $row): ?>
                <tr>
                    <td><?php echo $row['Curp']; ?></td>
                    <td><?php echo $row['Nombre(s)']; ?></td>
                    <td><?php echo $row['Apellidop']; ?></td>
                    <td><?php echo $row['Apellidom']; ?></td>
                    <td><?php echo $row['FechaN']; ?></td>
                    <td><?php echo $row['Genero']; ?></td>
                    <td><?php echo $row['Direccion']; ?></td>
                    <td><?php echo $row['Celular']; ?></td>
                    <td><?php echo $row['Enfermedadescro']; ?></td>
                    <td><?php echo $row['Condicionesmed']; ?></td>
                    <td><?php echo $row['Cirugiasant']; ?></td>
                    <td><?php echo $row['Alergias']; ?></td>
                    <td><?php echo $row['Vacunas']; ?></td>
                    <td><?php echo $row['Enfermrec']; ?></td>
                    <td><?php echo $row['Tratamientosant']; ?></td>
                    <td><?php echo $row['Sangre']; ?></td>
                    <td><?php echo $row['Nombrecon']; ?></td>
                    <td><?php echo $row['Apellidocon']; ?></td>
                    <td><?php echo $row['Numcon']; ?></td>
                    <td><?php echo $row['Exammed']; ?></td>
                </tr>
            </table>
            </div>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </body>
</html>
