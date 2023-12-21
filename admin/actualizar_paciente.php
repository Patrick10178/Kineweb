<?php

include '../conexion.php';
//recibe los nuevos datos y los almacena en variables//
$rut = $_POST['rut'];
$nombre = $_POST['nombre'];
$apellidop = $_POST['apellidop'];
$apellidom = $_POST['apellidom'];
$correo = $_POST['correo'];
$telefono = $_POST['telefono'];

//sentencia sql para actualizar los datos//
$actualizar = "UPDATE usuarios SET nombre='$nombre', apellidoP='$apellidop', apellidoM='$apellidom', correo='$correo', telefono='$telefono' WHERE id='$rut'";


//ejecucion//
$ejecutar = mysqli_query($conexion, $actualizar);
 
 if ($ejecutar){
    echo "
    <script>
        alert('usuario actualizado exitosamente');
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
