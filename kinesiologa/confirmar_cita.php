<?php

include '../conexion.php';

$cita = $_GET['id'];

$cancelar = "UPDATE `citas` SET `estado_id` = '4' WHERE `citas`.`id_cita` = '$cita'";



$ejecutar = mysqli_query($conexion, $cancelar);
 
 if ($ejecutar){
    echo "
    <script>
        alert('asistencia marcada exitosamente');
        window.history.back();
    </script>
    ";
 }else{
    echo "
    <script>
        alert('error, intentelo nuevamente');
        window.history.back();
    </script>
    ";
 }
 