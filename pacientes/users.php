<?php
//muestra a los pacientes en el area de preguntas//
    session_start();
    include '../conexion.php';
    $outgoing_id = $_SESSION['usuario'];
    $sql = "SELECT * FROM usuarios WHERE NOT id = {$outgoing_id} AND id_cargo=1";
    $query = mysqli_query($conexion, $sql);
    $output = "";
    if(mysqli_num_rows($query) == 0){
        $output .= "No hay pacientes registrados";
    }elseif(mysqli_num_rows($query) > 0){
        include_once "data.php";
    }
    echo $output;
?>