<?php

include '../conexion.php';

//recibe el id con el metodo GET (extraido del url) y lo almacena en una variable//

$rut = $_GET['id'];

//sentencia sql para eliminar//

$eliminar = "UPDATE `usuarios` SET `id_cargo` = '4' WHERE `Usuarios`.`id` =$rut";

//ejecutar//

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
