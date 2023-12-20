<?php
    while($row = mysqli_fetch_assoc($query)){
        // Consulta para obtener el último mensaje entre los dos usuarios
        $sql2 = "SELECT * FROM mensajes WHERE (entrante_msg_id = {$row['id']}
                OR saliente_msg_id = {$row['id']}) AND (saliente_msg_id = {$outgoing_id} 
                OR entrante_msg_id = {$outgoing_id}) ORDER BY msg_id DESC LIMIT 1";
        $query2 = mysqli_query($conexion, $sql2);
        $row2 = mysqli_fetch_assoc($query2);
        (mysqli_num_rows($query2) > 0) ? $result = $row2['msg'] : $result ="No hay mensajes";
        (strlen($result) > 28) ? $msg =  substr($result, 0, 28) . '...' : $msg = $result;

        // Determinar si el último mensaje fue enviado por el usuario actual
        if(isset($row2['saliente_msg_id'])){
            ($outgoing_id == $row2['saliente_msg_id']) ? $you = "Tú: " : $you = "";
        }else{
            $you = "";
        }

        // Consulta para obtener la cantidad de mensajes no leídos
        $sql_unread = "SELECT COUNT(*) as unread_count FROM mensajes WHERE entrante_msg_id = {$outgoing_id} AND saliente_msg_id = {$row['id']} AND visto = 0";
        $query_unread = mysqli_query($conexion, $sql_unread);
        $row_unread = mysqli_fetch_assoc($query_unread);
        $unread_count = $row_unread['unread_count'];

    // Generar el HTML de la lista de chats
    $output .= '<a href="chat.php?id='. $row['id'] .'">
                <div class="content">
                <img src="../imagenes/' . $row['img'] . '" alt="">
                <div class="details">
                    <span>'. $row['nombre']. " " . $row['apellidoP'] .'</span>
                    <p>'. $you . $msg;
    
    // Agregar el indicador de mensajes no leídos si hay mensajes no leídos
    if ($unread_count > 0) {
        $output .= '<span class="unread-count"> '. $unread_count .'</span>';
    }
    
    // Continuar con el código HTML
    $output .= '</p></div></div></a>';
    }
?>
