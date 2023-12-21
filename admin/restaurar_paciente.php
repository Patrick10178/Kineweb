<?php

include '../conexion.php';

//recibe el id con el metodo GET (extraido del url) y lo almacena en una variable//

$rut = $_GET['id'];

//sentencia sql para eliminar//

$eliminar = "UPDATE `usuarios` SET `id_cargo` = '3' WHERE `usuarios`.`id` =$rut";

//ejecutar//

$ejecutar = mysqli_query($conexion, $eliminar);
 
 if ($ejecutar){
    echo "
    <script>
        alert('usuario recuperado exitosamente');
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
