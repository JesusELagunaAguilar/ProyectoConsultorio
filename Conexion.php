<?php

$server='localhost';
$user='root';
$pass='';
$bd='consultorio';

try{
    $conn=mysqli_connect($server,$user,$pass,$bd);
        } catch(Exception $e){
        echo 'ERROR, NO SE PUDO CONECTAR', $e->getMessage()."/n";
    }
?>