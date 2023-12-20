<?php
header('Content-Type: application/json');

// Conexión a la base de datos
$conexion = mysqli_connect("localhost", "root", "", "bd");

// Capturar el término de búsqueda del parámetro 'q' en la URL
$term = mysqli_real_escape_string($conexion, $_GET['q']);

// Consulta SQL para buscar pacientes
$sql = "SELECT id, nombre, apellidoP, apellidoM FROM Usuarios WHERE (id LIKE '%$term%' OR nombre LIKE '%$term%' OR apellidoP LIKE '%$term%' OR apellidoM LIKE '%$term%') AND id_cargo = 3 LIMIT 10";

$resultado = mysqli_query($conexion, $sql);

$lista_pacientes = array();

while ($row = mysqli_fetch_assoc($resultado)) {
    // Agregando cada paciente al array
    $lista_pacientes[] = array(
        'rut' => $row['id'], // Usando 'id' como 'rut'
        'nombre' => $row['nombre'],
        'apellidoP' => $row['apellidoP'],
        'apellidoM' => $row['apellidoM']
    );
}

// Devolver los resultados como JSON
echo json_encode($lista_pacientes);

mysqli_close($conexion);
?>
