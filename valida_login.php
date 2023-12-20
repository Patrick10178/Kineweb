<?php
session_start();
include 'conexion.php';

$rut = $_POST['rut'];
$contrasena = md5($_POST['contrasena']); // Encripta la contraseña utilizando MD5

if (!preg_match("/^[0-9]{7,8}-[0-9kK]{1}$/", $rut)) {
    echo "
    <script>
        alert('El formato del rut es inválido');
        window.history.back();
    </script>
    ";
    exit();
}

$rut = str_replace("-", "", $rut);
$rutSinDV = substr($rut, 0, -1);

$dvIngresado = strtoupper(substr($rut, -1));

$factor = 2;
$suma = 0;

for ($i = strlen($rutSinDV) - 1; $i >= 0; $i--) {
    $suma += $rutSinDV[$i] * $factor;
    $factor = $factor == 7 ? 2 : $factor + 1;
}

$dvEsperado = 11 - ($suma % 11);
$dvEsperado = $dvEsperado == 10 ? "K" : ($dvEsperado == 11 ? "0" : strval($dvEsperado));

if ($dvIngresado != $dvEsperado) {
    echo "
    <script>
        alert('El RUT ingresado no es válido');
        window.history.back();
    </script>
    ";
    exit();
}
$rut = $rutSinDV;

$consulta = "SELECT * FROM usuarios WHERE id='$rut' AND contrasena='$contrasena'";
$resultado = mysqli_query($conexion, $consulta);

if (mysqli_num_rows($resultado) > 0) {
    $usuario = mysqli_fetch_assoc($resultado);
    
    $idCargo = $usuario['id_cargo'];

    $_SESSION['usuario'] = $rut;

    if ($idCargo == 1) {
        header("Location: kinesiologa/index.php");
        exit();
    } elseif ($idCargo == 2) {
        header("Location: secretaria/index.php");
        exit();
    } elseif ($idCargo == 3) {
        header("Location: pacientes/index.php");
        exit();
    }
} else {
    echo "
    <script>
        alert('RUT o contraseña inválidos');
        window.history.back();
    </script>
    ";
    exit();
}
?>
