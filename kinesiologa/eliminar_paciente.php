<?php

include '../conexion.php';

$rut = $_GET['id'];

$eliminar = "DELETE FROM usuarios WHERE `usuarios`.`id` =$rut";



$ejecutar = mysqli_query($conexion, $eliminar);
 
 if ($ejecutar){
    echo "
    <script>
        alert('paciente eliminado exitosamente');
        window.location = 'pacientes.php';
    </script>
    ";
 }else{
    echo "
    <script>
        alert('error, intentelo nuevamente');
        window.location = 'pacientes.php';
    </script>
    ";
 }
