<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include '../conexion.php'; 
if (!isset($_SESSION['usuario'])) {
    echo "Error: Usuario no está seteado en la sesión";
    exit();
}

$outgoing_id = $_SESSION['usuario'];

$sql = "SELECT COUNT(*) as unread_count FROM mensajes WHERE entrante_msg_id = {$outgoing_id} AND visto = 0";
$query = mysqli_query($conexion, $sql);

if (!$query) {
    echo "Error: No se pudo ejecutar la consulta a la base de datos";
    exit();
}

$row = mysqli_fetch_assoc($query);
$unread_count = $row['unread_count'];

// Imprime 'true' si hay mensajes no leídos, 'false' en caso contrario
echo $unread_count > 0 ? 'true' : 'false';
?>
