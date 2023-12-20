<?php

include '../conexion.php';

//recibe el id con el metodo GET (extraido del url) y lo almacena en una variable//

$cita = $_GET['id'];

//sentencia sql para eliminar//

$eliminar = "DELETE FROM citas WHERE `citas`.`id_cita` = '$cita'";

//ejecutar//

$ejecutar = mysqli_query($conexion, $eliminar);
 
 if ($ejecutar){
    echo "
    <script>
        alert('cita eliminada exitosamente');
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
 