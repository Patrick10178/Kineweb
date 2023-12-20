<?php
include '../conexion.php';

function convertirEnlaceYouTube($enlace) {
    $url = parse_url($enlace);
    parse_str($url['query'], $query);
    $videoId = $query['v'];
    return "https://www.youtube.com/embed/$videoId";
}

// Recibe los nuevos datos y los almacena en variables
$rut = $_POST['rut'];
$nombre = $_POST['nombre'];
$link = $_POST['link'];

// Convierte el enlace de YouTube
$link = convertirEnlaceYouTube($link);

// Sentencia SQL para actualizar los datos
$query = "INSERT INTO `videos` (`id_paciente`, `nombrev`, `link`, `estado`)
             VALUES ('$rut', '$nombre', '$link', 1)";

// Ejecución
$ejecutar = mysqli_query($conexion, $query);
 
if ($ejecutar){
    echo "
    <script>
        alert('Agregado exitosamente');
        window.location = 'perfil_paciente.php?id=$rut';
    </script>
    ";
} else {
    echo "
    <script>
        alert('Error, intentelo nuevamente');
        window.location = 'pacientes.php';
    </script>
    ";
}
?>
