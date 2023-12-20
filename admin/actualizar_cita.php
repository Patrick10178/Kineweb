<?php

include '../conexion.php';
//recibe los nuevos datos y los almacena en variables//
$cita = $_POST['cita'];
$terapia = $_POST['terapia'];
$horario = $_POST['horario'];
$fecha = $_POST['fecha'];

//si en la modificacion de hora no selecciona una, sera devuelto hasta que lo haga //

if ($horario==0){
    echo "
    <script>
        alert('Tiene que seleccionar una hora');
        window.location = 'modificar_cita.php?id=$cita';
    </script>
    ";
};
//sentencia sql para actualizar los datos//
$actualizar = "UPDATE citas SET terapia='$terapia', horario_id='$horario', fecha='$fecha' WHERE id_cita='$cita'";

$ejecutar = mysqli_query($conexion, $actualizar);
 
 if ($ejecutar){
    echo "
    <script>
        alert('cita modificada exitosamente');
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

 
