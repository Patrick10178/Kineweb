<?php

include '../conexion.php';

//recibe el id con el metodo GET (extraido del url) y lo almacena en una variable//

$rut = $_GET['id'];

//sentencia sql para eliminar//

$eliminar = "DELETE FROM usuarios WHERE `usuarios`.`id` =$rut";

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
