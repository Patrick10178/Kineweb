<?php

include '../conexion.php';

$rut = $_POST['rut'];
$nombre = $_POST['nombre'];
$apellidop = $_POST['apellidop'];
$apellidom = $_POST['apellidom'];
$correo = $_POST['correo'];
$telefono = $_POST['telefono'];
$contrasena = md5($_POST['contrasena']); 
$dia = $_POST['dia_nace'];
$mes = $_POST['mes_nace'];
$ano = $_POST['ano_nace'];
$nace = "$ano-$mes-$dia";
$tipo_usuario = $_POST['tipo_usuario'];
$sexo = $_POST['sexo'];
$admin = isset($_POST['admin']) ? 1 : 0;

if (!preg_match("/^[0-9]{7,8}-[0-9kK]{1}$/", $rut)) {
    echo "
    <script>
        alert('El formato del rut es inválido');
        window.history.back();
    </script>
    ";
    exit();
}

$allowed_domains = [
    'gmail.com', 
    'outlook.com', 
    'hotmail.com', 
    'live.com', 
    'yahoo.com', 
    'aol.com', 
    'icloud.com', 
    'msn.com', 
    'protonmail.com', 
    'zoho.com',
    'mail.com',
    'rediffmail.com',
    'gmx.com',
    'yandex.com',
    'hushmail.com',
    'fastmail.com',
    'inbox.com'
];
$email_domain = explode('@', $correo)[1];

if (!in_array($email_domain, $allowed_domains)) {
    echo "
    <script>
        alert('el correo electrónico no es válido. Por favor, verifique la dirección del correo');
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
$new_img_name = NULL;

if (isset($_FILES['image']) && !empty($_FILES['image']['name'])) {
    $img_name = $_FILES['image']['name'];
    $img_type = $_FILES['image']['type'];
    $tmp_name = $_FILES['image']['tmp_name'];

    $img_explode = explode('.', $img_name);
    $img_ext = end($img_explode);
    $extensions = ["jpeg", "png", "jpg"];

    if (in_array($img_ext, $extensions) === true) {
        $types = ["image/jpeg", "image/jpg", "image/png"];

        if (in_array($img_type, $types) === true) {
            $time = time();
            $new_img_name = $time . $img_name;

            if (!move_uploaded_file($tmp_name, "../imagenes/" . $new_img_name)) {
                $new_img_name = NULL;  // Si la imagen no se carga correctamente, la dejamos como NULL
            }
        }
    }
}
// Verificar si el RUT ya está registrado
$verificar_rut = mysqli_query($conexion, "SELECT * FROM usuarios WHERE id = '$rut'");

if (mysqli_num_rows($verificar_rut) > 0) {

    $fila = mysqli_fetch_assoc($verificar_rut);

    $contrasena = isset($_POST['contrasena']) && !empty($_POST['contrasena']) ? md5($_POST['contrasena']) : null;
    $sql = "UPDATE `usuarios` SET `nombre`='$nombre', `apellidoP`='$apellidop', `apellidoM`='$apellidom', `correo`='$correo', `telefono`='$telefono', `nace`='$nace', `sex`='$sexo', `id_cargo`='$tipo_usuario', `admin`='$admin'";    
    if ($new_img_name) {
        $sql .= ", `img`='$new_img_name'";
    }
    if ($contrasena) {
        $sql .= ", `contrasena`='$contrasena'";
    }
    $sql .= " WHERE `id`='$rut'";
    $mensaje = "Usuario actualizado exitosamente.";
} else {
    // Nuevo paciente, realizar inserción
    if (empty($_POST['contrasena'])) {
        echo "<script>alert('La contraseña es obligatoria para nuevos Usuarios.'); window.history.back();</script>";
        exit();
    }
    $contrasena = md5($_POST['contrasena']);
    $sql = "INSERT INTO `usuarios` (`id`, `nombre`, `apellidoP`, `apellidoM`, `sex`, `correo`, `telefono`, `contrasena`, `id_cargo`, `nace`, `img`, `admin`)
    VALUES ('$rut', '$nombre', '$apellidop', '$apellidom', '$sexo', '$correo', '$telefono', '$contrasena', '$tipo_usuario', '$nace', ". ($new_img_name ? "'$new_img_name'" : "NULL") .", '$admin')";
    $mensaje = "usuario registrado exitosamente.";
}

$ejecutar = mysqli_query($conexion, $sql);

if ($ejecutar) {
    echo "<script>alert('$mensaje'); window.location = 'pacientes.php';</script>";
} else {
    echo "<script>alert('Error, inténtelo nuevamente'); window.history.back();</script>";
}