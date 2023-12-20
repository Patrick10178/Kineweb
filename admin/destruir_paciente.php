<?php

include '../conexion.php';

//recibe el id con el metodo GET (extraido del url) y lo almacena en una variable//

$rut = $_GET['id'];

//sentencia sql para eliminar//

$eliminar = "DELETE FROM Usuarios WHERE `Usuarios`.`id` =$rut";

//ejecutar//

$ejecutar = mysqli_query($conexion, $eliminar);
 
 if ($ejecutar){
    echo "
    <script>
        alert('Usuario eliminado exitosamente');
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
