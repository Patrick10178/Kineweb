<?php
session_start();
include 'conexion.php';

$rut = $_POST['rut'];
$contrasena = md5($_POST['contrasena']); // Encripta la contraseña utilizando MD5

// Validación del formato del RUT
if (!preg_match("/^[0-9]{7,8}-[0-9kK]{1}$/", $rut)) {
    echo "<script>
        alert('El formato del rut es inválido');
        window.history.back();
    </script>";
    exit();
}

// Limpiar y calcular el dígito verificador del RUT
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
    echo "<script>
        alert('El RUT ingresado no es válido');
        window.history.back();
    </script>";
    exit();
}
$rut = $rutSinDV;

// Consulta para verificar si el usuario es administrador
$consulta = "SELECT * FROM usuarios WHERE id='$rut' AND contrasena='$contrasena' AND admin = 1";
$resultado = mysqli_query($conexion, $consulta);

if (mysqli_num_rows($resultado) > 0) {
    $_SESSION['usuario'] = $rut;
    // El usuario es administrador, redirige a la página de administración
    header("Location: admin/index.php");
    exit();
} else {
    // El usuario no es administrador o las credenciales son incorrectas
    echo "<script>
        alert('No tienes permisos de administrador o las credenciales son incorrectas.');
        window.history.back();
    </script>";
    exit();
}
?>
