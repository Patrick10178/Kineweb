<?php
    session_start();
    include '../conexion.php';

    $outgoing_id = $_SESSION['usuario'];
    $searchTerm = mysqli_real_escape_string($conexion, $_POST['searchTerm']);
    //busca en la base de datos coincidencias con lo escrito en la barra de busqueda//
    $sql = "SELECT * FROM usuarios WHERE NOT id = {$outgoing_id} AND (nombre LIKE '%{$searchTerm}%' OR apellidoP LIKE '%{$searchTerm}%'OR apellidoM LIKE '%{$searchTerm}%') AND id_cargo=3";
    $output = "";
    $query = mysqli_query($conexion, $sql);
    if(mysqli_num_rows($query) > 0){
        include_once "data.php";
    }else{
        $output .= 'Ningun paciente encontrado';
    }
    echo $output;
?>