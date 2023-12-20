<?php
include '../valida_sesion.php';
include '../conexion.php';
?>

<?php

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios</title>

    <link rel="stylesheet" href="css/estilos.css">

    <script src="https://kit.fontawesome.com/41bcea2ae3.js" crossorigin="anonymous"></script>
</head>
<body id="body">
    
    <header>
        <div class="icon__menu">
            <i class="fa-solid fa-hospital-user" id="btn_open2"></i>
            <h4>Ex Usuarios</h4>  
        </div>  
        <div class="usuario">
            <h4>
            <?php
                $usuario = $_SESSION["usuario"];
                 $sql="SELECT * FROM Usuarios WHERE id='$usuario' ";
                 $result=mysqli_query($conexion,$sql);
                 while($mostrar=mysqli_fetch_array($result)){
                 echo $mostrar ['nombre'];
                 echo " ";
                 echo $mostrar ['apellidoP'];
                 echo " ";
                 echo $mostrar ['apellidoM'];}
                 echo " ";  
            ?>
            <br>
            Administrador
            <br>
            <a href="../cerrar_sesion.php">cerrar sesion</a>
            </h4>  
            
        </div>


    </header>

    <div class="menu__side" id="menu_side">

        <div class="name__page">
            <i class="fas fa-bars" id="btn_open"></i>
            <h4>MENU</h4>
        </div>

        <div class="options__menu">	
            
            <a href="#">
                <div class="option">
                    <div id="ctn-icon-search">
                        <i class="fas fa-search" id="icon-search"></i>
                    </div>
                    <div id="ctn-bars-search">
                        <input type="text" id="inputSearch" placeholder=" Buscar Usuarios">
                        <div id="results-list"></div>
                    </div>
                </div>
            </a>

            <a href="index.php" >
                <div class="option">
                    <i class="fas fa-home" title="Inicio"></i>
                    <h4>Inicio</h4>
                </div>
            </a>

            <a href="citas.php">
                <div class="option">
                    <i class="fa-regular fa-calendar" title="citas"></i>
                    <h4>Citas</h4>
                </div>
            </a>
            
            <a href="pacientes.php" class="selected">
                <div class="option">
                    <i class="fa-solid fa-hospital-user" title="Usuarios"></i>
                    <h4>Usuarios</h4>
                </div>
            </a>

        </div>

    </div>

    <main>

            <h2>Usuarios Eliminados</h2>
            <hr>
            <br>
            <!-- tabla de los Usuarios-->
            <table id=pacientes>
                <tr>
                    <td>Rut</td>
                    <td>Nombre</td>
                    <td>Correo</td>
                    <td>Telefono</td>
                    <td>Acciones</td>
                </tr>
                <?php
                /* hace la consulta a la base de datos de todos los Usuarios con el cargo de pacientes y los muestra en la tabla con un while */
                $sql="SELECT * FROM Usuarios WHERE id_cargo = 4";
                $result=mysqli_query($conexion,$sql);

                function calcularRUT($id) {
                    // Eliminar guiones si existen
                    $id = str_replace('-', '', $id);
                
                    // Obtener los dígitos del RUT
                    $numero = $id; // Obtener los primeros dígitos del ID (sin el dígito verificador)
                    $digitoVerificador = substr($id, -1); // Obtener el último dígito del ID (dígito verificador)
                
                    // Calcular el dígito verificador real
                    $factor = 2;
                    $suma = 0;
                    for ($i = strlen($numero) - 1; $i >= 0; $i--) {
                        $suma += $factor * intval($numero[$i]);
                        $factor = $factor % 7 == 0 ? 2 : $factor + 1;
                    }
                    $digitoVerificadorCalculado = 11 - ($suma % 11);
                    if ($digitoVerificadorCalculado == 11) {
                        $digitoVerificadorCalculado = 0;
                    } elseif ($digitoVerificadorCalculado == 10) {
                        $digitoVerificadorCalculado = 'K';
                    }
                
                    // Aplicar formato al RUT (XX.XXX.XXX-Y)
                    $rutFormateado = number_format($numero, 0, '.', '.') . '-' . $digitoVerificadorCalculado;
                
                    return $rutFormateado;
                }
                while($mostrar=mysqli_fetch_array($result)){

                ?>
                <tr>
                    <td><?php echo calcularRUT($mostrar['id'])?></td>
                    <td><?php echo $mostrar ['nombre'] ; echo " "; echo $mostrar ['apellidoP'] ; echo " "; echo $mostrar ['apellidoM']?></td>
                    <td><?php echo $mostrar ['correo']?></td>
                    <td><?php echo $mostrar ['telefono']?></td>
                    <td>
                        <a href="restaurar_paciente.php?id=<?php echo $mostrar ['id'];?>" class="modificarbtn" id="boton">Restaurar</a>
                        <a href="destruir_paciente.php?id=<?php echo $mostrar ['id'];?>" class="eliminarbtn" id="boton">Borrado definivo</a>

                    </td>

                </tr>

                <?php
                }
                ?>
            </table>

    </main>
    <script src="js/script.js"></script>
    <script src="../assets/js/confirmacion.js"></script>

   
</body>
</html> 