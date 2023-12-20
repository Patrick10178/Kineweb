<?php
include '../valida_sesion.php';
include '../conexion.php';
//recibe la id seleccionada para hacer la modificacion a traves del metodo get, que recibe el id desde el url y lo almacena en una variable//
$id= $_GET["id"];
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
            <h4>Usuarios</h4>  
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
            <a href="../cerrar_sesion.php" style="color: #006e8c;">Cerrar Sesión</a>

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
        <div class="contenedor__todo">
            <h2>Usuarios</h2>
            <hr>
            <br>
            <table id=pacientes>
                <tr>
                    <td>Rut</td>
                    <td>Nombre</td>
                    <td>Apellido Paterno</td>
                    <td>Apellido Materno</td>
                    <td>Correo</td>
                    <td>Telefono</td>
                    <td>Acciones</td>
                </tr>
                <?php
                /*La variable obtenida con el metodo GET,se utilizara para buscarlo en el registro y mostrarlo en la tabla */
                $sql="SELECT * FROM Usuarios WHERE id = $id";
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
                <!--rellena los datos obtenidos y se almacenan en un formulario para que sean editables y puedan escribir la modificacion. 
                    luego los datos seran enviados a actualizar_paciente.php para su update  a la base de datos -->
                <form action="actualizar_paciente.php" method="POST">
                    <td><?php echo calcularRUT($mostrar['id'])?></td>
                    <input type="hidden" value="<?php echo $mostrar ['id'];?>" name= "rut" require>
                    <td><input type="text" value="<?php echo $mostrar ['nombre'];?>" name= "nombre" require></td>
                    <td><input type="text" value="<?php echo $mostrar ['apellidoP'];?>" name= "apellidop" require></td>
                    <td><input type="text" value="<?php echo $mostrar ['apellidoM'];?>" name= "apellidom" require></td>
                    <td><input type="mail" value="<?php echo $mostrar ['correo'];?>" name= "correo" require></td>
                    <td><input type="number" value="<?php echo $mostrar ['telefono'];?>" name= "telefono" require></td>
                    <td><input type="submit" value="Actualizar"></td>
                    

                </form>

                <?php
                }
                ?>
            </table>

    </main>

    <script src="js/script.js"></script>
</body>
</html>