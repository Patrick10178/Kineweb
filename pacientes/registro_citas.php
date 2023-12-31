<?php

include '../conexion.php';
$idCita = $_POST['cita'];
$rut = $_POST['rut'];
$horario = $_POST['horario'];
$terapia = $_POST['terapia'];
$fecha = $_POST['fecha'];
$kine_id = $_POST['kine_id'];


// Validar formato correcto del rut (xxxxxxxx-y)
if (!preg_match("/^[0-9]{7,8}-[0-9kK]{1}$/", $rut)) {
    echo "
    <script>
        alert('El formato del rut es inválido');
        window.history.back();
    </script>
    ";
    exit();
}

// Eliminar el guion y obtener el rut sin dígito verificador
$rut = str_replace("-", "", $rut);
$rutSinDV = substr($rut, 0, -1);

// Obtener el dígito verificador ingresado
$dvIngresado = strtoupper(substr($rut, -1));

// Calcular el dígito verificador esperado
$factor = 2;
$suma = 0;

for ($i = strlen($rutSinDV) - 1; $i >= 0; $i--) {
    $suma += $rutSinDV[$i] * $factor;
    $factor = $factor == 7 ? 2 : $factor + 1;
}

$dvEsperado = 11 - ($suma % 11);
$dvEsperado = $dvEsperado == 10 ? "K" : ($dvEsperado == 11 ? "0" : strval($dvEsperado));

// Verificar si el dígito verificador ingresado coincide con el esperado
if ($dvIngresado != $dvEsperado) {
    echo "
    <script>
        alert('El RUT ingresado no es válido');
        window.history.back();
    </script>
    ";
    exit();
}
$rut=$rutSinDV;


//si en el agendamiento de hora no selecciona una, sera devuelto hasta que lo haga //

if ($horario==0){
    echo "
    <script>
        alert('Tiene que seleccionar una hora');
        window.history.back();
    </script>
    ";
};

// Comprueba si estás actualizando o creando una nueva cita
if ($idCita) {

    if (empty($kine_id)) {
        echo "<script>alert('No se detectaron cambios en la cita.'); window.location = 'citas.php';</script>";
        die();
    }

    // Actualizar cita existente
    $actualizar = "UPDATE `citas` SET `paciente_id`='$rut', `horario_id`='$horario', `terapia`='$terapia', `fecha`='$fecha', `kine_id`='$kine_id', `estado_id`= 1 WHERE `id_cita`='$idCita'";
    $ejecutar = mysqli_query($conexion, $actualizar);
 
 if ($ejecutar){
    echo "
    <script>
        alert('cita modificada exitosamente');
        window.location = 'citas.php';
    </script>
    ";
 }else{
    echo "
    <script>
        alert('error, intentelo nuevamente');
        window.location = 'pacientes.php';
    </script>
    ";
 }
} 

?>