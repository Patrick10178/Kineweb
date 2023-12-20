<?php
 /*funcion para cerrar sesion el cual sera incluido en todas las paginas*/
    session_start();
    session_destroy();
    header("location: index.php");
?>