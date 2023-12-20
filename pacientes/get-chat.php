<?php 
session_start();
if (isset($_SESSION['usuario'])) {
    include_once '../conexion.php';
    $outgoing_id = $_SESSION['usuario'];
    $incoming_id = mysqli_real_escape_string($conexion, $_POST['incoming_id']);
    $output = "";

    // Actualizar los mensajes como leídos
    $updateSql = "UPDATE mensajes 
                  SET visto = '1' 
                  WHERE saliente_msg_id = {$incoming_id} AND entrante_msg_id = {$outgoing_id}";
    mysqli_query($conexion, $updateSql);

    // Consulta para seleccionar los mensajes
    $sql = "SELECT * FROM mensajes 
            LEFT JOIN usuarios ON usuarios.id = mensajes.saliente_msg_id
            WHERE (saliente_msg_id = {$outgoing_id} AND entrante_msg_id = {$incoming_id})
            OR (saliente_msg_id = {$incoming_id} AND entrante_msg_id = {$outgoing_id}) 
            ORDER BY msg_id";
    $query = mysqli_query($conexion, $sql);

    if (mysqli_num_rows($query) > 0) {
        while ($row = mysqli_fetch_assoc($query)) {
            if ($row['saliente_msg_id'] === $outgoing_id) {
                $output .= '<div class="chat outgoing">
                            <div class="details">
                                <p>' . $row['msg'] . '</p>
                            </div>
                            </div>';
            } else {
                $output .= '<div class="chat incoming">
                            <img src="../imagenes/' . $row['img'] . '" alt="">
                            <div class="details">
                                <p>' . $row['msg'] . '</p>
                            </div>
                            </div>';
            }
        }
    } else {
        $output .= '<div class="text">No hay mensajes disponibles. Una vez escribas, aparecerán los mensajes aquí</div>';
    }
    echo $output;
} else {
    header("location: ../login.php");
}

?>