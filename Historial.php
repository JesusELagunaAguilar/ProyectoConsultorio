<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial Médico</title>
    <link rel="stylesheet" href="res\StyleHis.css">
    <script src="https://kit.fontawesome.com/33bfb3cecc.js" crossorigin="anonymous"></script>
</head>
<body>
<div class="back"><a href="Index.html"><i class="fas fa-home"></i></a></div>
<div class="consultar"><a href="http://localhost/consultorio/Consulta.php"><i class="fas fa-magnifying-glass"></i></a>
    <form action="#" method="post">
        <h2>Alta Historial Médico</h2>
        
        <label for="Curp">Curp:</label>
        <input type="text" id="Curp" name="Curp" required>
        
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required>

        <label for="ApellidoP">Apellido Paterno:</label>
        <input type="text" id="ApellidoP" name="ApellidoP" required>

        <label for="Apellidom">Apellido Materno:</label>
        <input type="text" id="Apellidom" name="Apellidom" required>

        <label for="Fecha">Fecha De Nacimiento:</label>
        <input type="date" id="Fecha" name="Fecha" required placeholder="DD/MM/AA">

        <label for="Genero">Género:</label>
        <select id="Genero" name="Genero" required>
            <option value="M">Masculino</option>
            <option value="F">Femenino</option>
        </select>


        <label for="Direccion">Direccion:</label>
        <input type="text" id="Direccion" name="Direccion" required placeholder="Calle/Colonia/Codigo Postal">

        <label for="Celular">Numero De Telefono:</label>
        <input type="text" id="Celular" name="Celular" required>

        <label for="EnfermedadesCro">Enfermedades Cronicas del paciente:</label>
        <input type="text" id="EnfermedadesCro" name="EnfermedadesCro" required>

        <label for="CondicionMedi">Condicion Medica Del Paciente:</label>
        <input type="text" id="CondicionMedi" name="CondicionMedi" required>

        <label for="CirugiasAnt">Antecedentes De Cirugia:</label>
        <input type="text" id="CirugiasAnt" name="CirugiasAnt" required>

        <label for="Alergia">Tipos de Alergia:</label>
        <input type="text" id="alergia" name="alergia">

        <label for="Vacunas">Antecedentes De Vacunas:</label>
        <input type="text" id="Vacunas" name="Vacunas">

        <label for="EnfermRec">Enfermedades Recientes:</label>
        <input type="text" id="EnfermRec" name="EnfermRec">

        <label for="TratamientosAnt">Tratamientos Anteriores:</label>
        <input type="text" id="TratamientosAnt" name="TratamientosAnt">

        <label for="tipoSangre">Tipo de Sangre:</label>
        <input type="text" id="tipoSangre" name="tipoSangre" required>

        <label for="NombreCon">Nombre De Contacto De Emergencia:</label>
        <input type="text" id="NombreCon" name="NombreCon" required>

        <label for="ApellidoCon">Apellido De Contacto De Emergencia:</label>
        <input type="text" id="ApellidoCon" name="ApellidoCon" required>

        <label for="NumCon">Numero De Contacto De Emergencia:</label>
        <input type="text" id="NumCon" name="NumCon" required>

        <label for="ExamMed">Examenes medicos:</label>
        <input type="text" id="ExamMed" name="ExamMed" required>

        <button class="boton" type="submit">Guardar Datos</button>
    </form>

</body>
</html>

<?php
include("Conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
    $curp = $_POST['Curp'];

    $sql = "INSERT INTO historial (
        `Nombre(s)`, `Apellidop`, `Apellidom`, `Genero`, `Direccion`, `Celular`, `Enfermedadescro`,
        `Condicionesmed`, `Cirugiasant`, `Alergias`, `Vacunas`, `Enfermrec`, `Tratamientosant`,
        `Sangre`, `Nombrecon`, `Apellidocon`, `Numcon`, `Exammed`, `Curp`, `FechaN`
    ) VALUES (
        '$nombre', '$apellidoPaterno', '$apellidoMaterno','$genero',
        '$direccion', '$numeroTelefono', '$enfermedadesCronicas', '$condicionMedica',
        '$antecedentesCirugia', '$alergias', '$antecedentesVacunas', '$enfermedadesRecientes',
        '$tratamientosAnteriores', '$tipoSangre', '$nombreContactoEmergencia', '$apellidoContactoEmergencia',
        '$numeroContactoEmergencia', '$examenesMedicos', '$curp', '$fechaNacimiento'
    )";
    if ($conn->query($sql) === TRUE) {
        echo '<div class="notification success-notification">Registro exitoso</div>';
    } else {
        echo '<div class="notification error-notification">Error en la preparación de la declaración: ' . $conn->error . '</div>';
    }
}


?>