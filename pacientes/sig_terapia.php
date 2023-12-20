<?php

include '../conexion.php';
//recibe los nuevos datos y los almacena en variables//
$coment = $_POST['coment'];
$id = $_POST['id_video'];

//sentencia sql para actualizar los datos//
$actualizar = "UPDATE videos SET estado= 2, coment='$coment' WHERE id_videos='$id'";

//ejecucion//
$ejecutar = mysqli_query($conexion, $actualizar);
 
 if ($ejecutar){
    echo "
    <script>
        alert('Continuacion de terapia registrada');
        window.location = 'videos.php';
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
