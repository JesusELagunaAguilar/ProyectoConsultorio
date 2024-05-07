<?php
include("Conexion.php");

$curpDeseada = '';
$data = [];

// Consultar
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["search"])) {
    $curpDeseada = isset($_POST["curpbuscar"]) ? $_POST["curpbuscar"] : '';

    if (empty($curpDeseada)) {
        echo '<div class="notification error-notification">El campo de búsqueda está vacío</div>';
    } else {
        $sql = "SELECT `Nombre(s)`, `Apellidop`, `Apellidom`, `Genero`, `Direccion`, `Celular`, `Enfermedadescro`,
                `Condicionesmed`, `Cirugiasant`, `Alergias`, `Vacunas`, `Enfermrec`, `Tratamientosant`,
                `Sangre`, `Nombrecon`, `Apellidocon`, `Numcon`, `Exammed`, `Curp`, `FechaN` FROM historial
                WHERE Curp = '$curpDeseada'";

        $result = mysqli_query($conn, $sql);

        if ($result === false) {
            echo '<div class="notification error-notification">Error en la consulta: ' . mysqli_error($conn) . '</div>';
        } else {
            $data = mysqli_fetch_assoc($result);

            if (empty($data)) {
                echo '<div class="notification error-notification">Paciente no encontrado</div>';
                // Puedes hacer algo más si no encuentras el paciente
            } else {
                echo '<div class="notification success-notification">Paciente encontrado</div>';
            }
        }
    }
}

// Modificar
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["updateBtn"])) {
    $curp = isset($_POST["Curp"]) ? $_POST["Curp"] : '';

    // Resto del código para la modificación
    $nombre = $_POST['nombre'];
    $apellidoPaterno = $_POST['ApellidoP'];
    $apellidoMaterno = $_POST['Apellidom'];
    $fechaNacimiento = $_POST['Fecha'];
    $genero = $_POST['Genero'];
    $direccion = $_POST['Direccion'];
    $numeroTelefono = $_POST['Celular'];
    $enfermedadesCronicas = $_POST['EnfermedadesCro'];
    $condicionMedica = $_POST['CondicionMedi'];
    $antecedentesCirugia = $_POST['CirugiasAnt'];
    $alergias = $_POST['alergia'];
    $antecedentesVacunas = $_POST['Vacunas'];
    $enfermedadesRecientes = $_POST['EnfermRec'];
    $tratamientosAnteriores = $_POST['TratamientosAnt'];
    $tipoSangre = $_POST['tipoSangre'];
    $nombreContactoEmergencia = $_POST['NombreCon'];
    $apellidoContactoEmergencia = $_POST['ApellidoCon'];
    $numeroContactoEmergencia = $_POST['NumCon'];
    $examenesMedicos = $_POST['ExamMed'];

    $sqlUpdate = "UPDATE historial SET 
        `Nombre(s)` = '$nombre', 
        `Apellidop` = '$apellidoPaterno', 
        `Apellidom` = '$apellidoMaterno', 
        `FechaN` = '$fechaNacimiento', 
        `Genero` = '$genero', 
        `Direccion` = '$direccion', 
        `Celular` = '$numeroTelefono', 
        `Enfermedadescro` = '$enfermedadesCronicas', 
        `Condicionesmed` = '$condicionMedica', 
        `Cirugiasant` = '$antecedentesCirugia', 
        `Alergias` = '$alergias', 
        `Vacunas` = '$antecedentesVacunas', 
        `Enfermrec` = '$enfermedadesRecientes', 
        `Tratamientosant` = '$tratamientosAnteriores', 
        `Sangre` = '$tipoSangre', 
        `Nombrecon` = '$nombreContactoEmergencia', 
        `Apellidocon` = '$apellidoContactoEmergencia', 
        `Numcon` = '$numeroContactoEmergencia', 
        `Exammed` = '$examenesMedicos' 
        WHERE Curp = '$curp'";

    $resultUpdate = mysqli_query($conn, $sqlUpdate);

    if ($resultUpdate === false) {
        echo '<div class="notification error-notification">Error al actualizar datos: ' . mysqli_error($conn) . '</div>';
    } else {
        echo '<div class="notification success-notification">Datos modificados con éxito</div>';
        // Limpiar los campos
        echo '<script>
            document.getElementById("nombre").value = "";
            document.getElementById("ApellidoP").value = "";
            document.getElementById("Apellidom").value = "";
            document.getElementById("Fecha").value = "";
            document.getElementById("Genero").value = "";
            document.getElementById("Direccion").value = "";
            document.getElementById("Celular").value = "";
            document.getElementById("EnfermedadesCro").value = "";
            document.getElementById("CondicionMedi").value = "";
            document.getElementById("CirugiasAnt").value = "";
            document.getElementById("alergia").value = "";
            document.getElementById("Vacunas").value = "";
            document.getElementById("EnfermRec").value = "";
            document.getElementById("TratamientosAnt").value = "";
            document.getElementById("tipoSangre").value = "";
            document.getElementById("NombreCon").value = "";
            document.getElementById("ApellidoCon").value = "";
            document.getElementById("NumCon").value = "";
            document.getElementById("ExamMed").value = "";
        </script>';
    }
}

mysqli_close($conn);
?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Historial Médico</title>
    <link rel="stylesheet" href="res\StyleMod.css">
    <script src="https://kit.fontawesome.com/33bfb3cecc.js" crossorigin="anonymous"></script>

</head>
<body>
    <div class="back"><a href="menu.html"><i class="fas fa-home"></i></a></div>
    <div class="consultar"><a href="Consulta.php"><i
                class="fas fa-magnifying-glass"></i></a>

        <h1>Consulta por CURP</h1>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="curp">Ingrese la CURP:</label>
            <input type="text" id="curpbuscar" name="curpbuscar" value="<?php echo $curpDeseada; ?>">
            <button type="submit" name="search" class="btsearch">Buscar</button>
        </form>

        <form action="" method="post">
            <h2>Modificar datos del Paciente</h2>

            <label for="Curp">Curp:</label>
            <input type="text" id="Curp" name="Curp" value="<?php echo isset($data['Curp']) ? $data['Curp'] : ''; ?>"
                placeholder="CURP no se puede modificar" readonly required>

            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre"
                value="<?php echo isset($data['Nombre(s)']) ? $data['Nombre(s)'] : ''; ?>" required>

            <label for="ApellidoP">Apellido Paterno:</label>
            <input type="text" id="ApellidoP" name="ApellidoP"
                value="<?php echo isset($data['Apellidop']) ? $data['Apellidop'] : ''; ?>" required>

            <label for="Apellidom">Apellido Materno:</label>
            <input type="text" id="Apellidom" name="Apellidom"
                value="<?php echo isset($data['Apellidom']) ? $data['Apellidom'] : ''; ?>" required>

            <label for="Fecha">Fecha De Nacimiento:</label>
            <input type="date" id="Fecha" name="Fecha"
                value="<?php echo isset($data['FechaN']) ? $data['FechaN'] : ''; ?>" required placeholder="">

            <label for="Genero">Género:</label>
            <select id="Genero" name="Genero" required>
                <option value="M" <?php echo (isset($data['Genero']) && $data['Genero'] === 'M') ? 'selected' : ''; ?>>
                    Masculino</option>
                <option value="F" <?php echo (isset($data['Genero']) && $data['Genero'] === 'F') ? 'selected' : ''; ?>>
                    Femenino</option>
            </select>

            <label for="Direccion">Direccion:</label>
            <input type="text" id="Direccion" name="Direccion"
                value="<?php echo isset($data['Direccion']) ? $data['Direccion'] : ''; ?>" required>

            <label for="Celular">Numero De Telefono:</label>
            <input type="text" id="Celular" name="Celular"
                value="<?php echo isset($data['Celular']) ? $data['Celular'] : ''; ?>" required>

            <label for="EnfermedadesCro">Enfermedades Cronicas del paciente:</label>
            <input type="text" id="EnfermedadesCro" name="EnfermedadesCro"
                value="<?php echo isset($data['Enfermedadescro']) ? $data['Enfermedadescro'] : ''; ?>" required>

            <label for="CondicionMedi">Condicion Medica Del Paciente:</label>
            <input type="text" id="CondicionMedi" name="CondicionMedi"
                value="<?php echo isset($data['Condicionesmed']) ? $data['Condicionesmed'] : ''; ?>" required>

            <label for="CirugiasAnt">Antecedentes De Cirugia:</label>
            <input type="text" id="CirugiasAnt" name="CirugiasAnt"
                value="<?php echo isset($data['Cirugiasant']) ? $data['Cirugiasant'] : ''; ?>" required>

            <label for="Alergia">Tipos de Alergia:</label>
            <input type="text" id="alergia" name="alergia"
                value="<?php echo isset($data['Alergias']) ? $data['Alergias'] : ''; ?>">

            <label for="Vacunas">Antecedentes De Vacunas:</label>
            <input type="text" id="Vacunas" name="Vacunas"
                value="<?php echo isset($data['Vacunas']) ? $data['Vacunas'] : ''; ?>">

            <label for="EnfermRec">Enfermedades Recientes:</label>
            <input type="text" id="EnfermRec" name="EnfermRec"
                value="<?php echo isset($data['Enfermrec']) ? $data['Enfermrec'] : ''; ?>">

            <label for="TratamientosAnt">Tratamientos Anteriores:</label>
            <input type="text" id="TratamientosAnt" name="TratamientosAnt"
                value="<?php echo isset($data['Tratamientosant']) ? $data['Tratamientosant'] : ''; ?>">

            <label for="tipoSangre">Tipo de Sangre:</label>
            <input type="text" id="tipoSangre" name="tipoSangre"
                value="<?php echo isset($data['Sangre']) ? $data['Sangre'] : ''; ?>" required>

            <label for="NombreCon">Nombre De Contacto De Emergencia:</label>
            <input type="text" id="NombreCon" name="NombreCon"
                value="<?php echo isset($data['Nombrecon']) ? $data['Nombrecon'] : ''; ?>" required>

            <label for="ApellidoCon">Apellido De Contacto De Emergencia:</label>
            <input type="text" id="ApellidoCon" name="ApellidoCon"
                value="<?php echo isset($data['Apellidocon']) ? $data['Apellidocon'] : ''; ?>" required>

            <label for="NumCon">Numero De Contacto De Emergencia:</label>
            <input type="text" id="NumCon" name="NumCon"
                value="<?php echo isset($data['Numcon']) ? $data['Numcon'] : ''; ?>" required>

            <label for="ExamMed">Examenes medicos:</label>
            <input type="text" id="ExamMed" name="ExamMed"
                value="<?php echo isset($data['Exammed']) ? $data['Exammed'] : ''; ?>" required>

                <button type="submit" name="updateBtn" id="updateBtn" class="boton" disabled>Modificar Datos</button>
            </form>
            <script>
    <?php
        if (!empty($data)) {
            echo 'document.getElementById("updateBtn").removeAttribute("disabled");';
        }
    ?>
</script>
</body>
</html>