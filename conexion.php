<?php
/* hace la conexion a la base de datos y se guarda en la variable $conexion para usarla posteriormente*/
$host = 'kine-do-user-15332379-0.c.db.ondigitalocean.com';
$username = 'doadmin';
$password = 'AVNS_jr72UFf5dsz0vYzFeTK';
$dbname = 'defaultdb';
$port = 25060;

$conexion = mysqli_connect($host, $username, $password, $dbname, $port);
?>