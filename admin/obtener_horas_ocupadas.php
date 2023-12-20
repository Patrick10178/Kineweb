<?php
include '../conexion.php';

$response = [
    'horas_ocupadas' => [],
    'todas_las_horas' => [],
    'kinesiologos_ocupados' => [],
    'todos_los_kinesiologos' => []
];

if(isset($_GET['fecha'])) {
    $fecha = $_GET['fecha'];

    // Obtener horas ocupadas
    $query_ocupadas = "SELECT horario_id FROM citas WHERE fecha = '$fecha'";
    $result_ocupadas = mysqli_query($conexion, $query_ocupadas);
    
    // Crear un arreglo para contar cuántas veces aparece cada horario_id
    $contador_horarios = array();

    while($row = mysqli_fetch_assoc($result_ocupadas)) {
        $horario_id = $row['horario_id'];

        // Aumentar el contador para el horario_id actual
        if (!isset($contador_horarios[$horario_id])) {
            $contador_horarios[$horario_id] = 1;
        } else {
            $contador_horarios[$horario_id]++;
        }

        // Marcar como ocupado si la cuenta es igual o mayor a 3
        if ($contador_horarios[$horario_id] >= 3) {
            $response['horas_ocupadas'][] = $horario_id;
        }
    }

    // Obtener todas las horas
    $query_todas = "SELECT * FROM horario";
    $result_todas = mysqli_query($conexion, $query_todas);
    while($row = mysqli_fetch_assoc($result_todas)) {
        $response['todas_las_horas'][] = [
            'id_horario' => $row['id_horario'],
            'nombre_horario' => $row['nombre_horario']
        ];
    }

        // Si se proporciona un horario específico, obtener los kinesiólogos ocupados
        if(isset($_GET['horario_id'])) {
            $horario_id = $_GET['horario_id'];
            $query_kines_ocupados = "SELECT DISTINCT kine_id FROM citas WHERE fecha = '$fecha' AND horario_id = '$horario_id' and estado_id = 1";
            $result_kines_ocupados = mysqli_query($conexion, $query_kines_ocupados);
            while($row = mysqli_fetch_assoc($result_kines_ocupados)) {
                $response['kinesiologos_ocupados'][] = $row['kine_id'];
            }
        }
    
        // Obtener todos los kinesiólogos
        $query_todos_kines = "SELECT id, nombre, apellidoP, apellidoM FROM Usuarios WHERE id_cargo = 1";
        $result_todos_kines = mysqli_query($conexion, $query_todos_kines);
        while($row = mysqli_fetch_assoc($result_todos_kines)) {
            $response['todos_los_kinesiologos'][] = [
                'id' => $row['id'],
                'nombre' => $row['nombre'],
                'apellidoP' => $row['apellidoP'],
                'apellidoM' => $row['apellidoM']
            ];
        }

    echo json_encode($response);
}
?>
