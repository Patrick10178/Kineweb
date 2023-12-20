<?php

include '../conexion.php';

$cita = $_GET['id'];

$cancelar = "UPDATE `citas` SET `estado_id` = '3' WHERE `citas`.`id_cita` = '$cita'";



$ejecutar = mysqli_query($conexion, $cancelar);
 
 if ($ejecutar){
    echo "
    <script>
        alert('cita cancelada exitosamente');
        window.location = 'citas.php';
    </script>
    ";
 }else{
    echo "
    <script>
        alert('error, intentelo nuevamente');
        window.location = 'citas.php';
    </script>
    ";
 }
 