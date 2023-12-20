<?php 
    session_start();
    if(isset($_SESSION['usuario'])){
        include '../conexion.php';
        $outgoing_id = $_SESSION['usuario'];
        $incoming_id = mysqli_real_escape_string($conexion, $_POST['incoming_id']);
        $message = mysqli_real_escape_string($conexion, $_POST['message']);
        if(!empty($message)){
            $sql = mysqli_query($conexion, "INSERT INTO mensajes (entrante_msg_id, saliente_msg_id, msg)
                                        VALUES ({$incoming_id}, {$outgoing_id}, '{$message}')") or die();
        }
    }else{
        header("location: ../login.php");
    }


    
?>