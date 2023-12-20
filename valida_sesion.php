<?php
/* Verifica si hay sesión iniciada para acceder a la página */
session_start();
include '../conexion.php';

/* Si no hay sesión iniciada, redirecciona al usuario a logearse */
if (!isset($_SESSION['usuario'])) {
    echo "
    <script>
        alert('Debes iniciar sesión');
        window.location = '../index.php';
    </script>
    ";
    session_destroy();
    die();
} else {
    /* Obtener el cargo y el estado de admin del usuario desde la base de datos */
    $rut = $_SESSION['usuario'];
    $consulta = "SELECT id_cargo, admin FROM usuarios WHERE id='$rut'";
    $resultado = mysqli_query($conexion, $consulta);

    if (mysqli_num_rows($resultado) > 0) {
        $usuario = mysqli_fetch_assoc($resultado);
        $idCargo = $usuario['id_cargo'];
        $esAdmin = $usuario['admin'];

        /* Verificar si el usuario es administrador */
        if ($esAdmin) {
            // El usuario es administrador, puede acceder a cualquier página dentro de la carpeta admin
        } else {
            /* Redirigir según el cargo del usuario */
            if ($idCargo == 1 && strpos($_SERVER['PHP_SELF'], '/kinesiologa/') === false) {
                header("Location: ../kinesiologa/index.php");
                exit();
            } elseif ($idCargo == 2 && strpos($_SERVER['PHP_SELF'], '/secretaria/') === false) {
                header("Location: ../secretaria/index.php");
                exit();
            } elseif ($idCargo == 3 && strpos($_SERVER['PHP_SELF'], '/pacientes/') === false) {
                header("Location: ../pacientes/index.php");
                exit();
            }
        }
    } else {
        echo "
        <script>
            alert('No se pudo verificar la información del usuario');
            window.location = '../index.php';
        </script>
        ";
        session_destroy();
        die();
    }
}
?>
