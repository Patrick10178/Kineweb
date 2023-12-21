<?php
include '../valida_sesion.php';
include '../conexion.php';
//recibbir id para hacer la modificacion//
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
    <title>Pacientes</title>

    <link rel="stylesheet" href="css/estilos.css">

    <script src="https://kit.fontawesome.com/41bcea2ae3.js" crossorigin="anonymous"></script>
</head>
<body id="body">
    
    <header>
        <div class="icon__menu">
            <i class="fa-solid fa-hospital-user" id="btn_open2"></i>
            <h4>Pacientes</h4>  
        </div>  
        <div class="usuario">
            <h4>
            <?php
                $usuario = $_SESSION["usuario"];
                 $sql="SELECT * FROM usuarios WHERE id='$usuario' ";
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
            Secretaria
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
                        <input type="text" id="inputSearch" placeholder=" Buscar Pacientes">
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
                    <i class="fa-solid fa-hospital-user" title="Pacientes"></i>
                    <h4>Pacientes</h4>
                </div>
            </a>

        </div>

    </div>

    <main>
        <div class="contenedor__todo">
            <h2>Pacientes</h2>
            <hr>
            <br>
            <table id=pacientes>
                <tr>
                    <td>Rut</td>
                    <td>Nombre</td>
                    <td>Apellido Paterno</td>
                    <td>Apellido Materno</td>
                    <td>Correo</td>
                    <td>Telefóno</td>
                    <td>Acciones</td>
                </tr>
                <?php
                $sql="SELECT * FROM usuarios WHERE id = $id";
                $result=mysqli_query($conexion,$sql);

                while($mostrar=mysqli_fetch_array($result)){

                ?>
                <form action="actualizar_paciente.php" method="POST">
                    <td><?php echo $mostrar ['id']?></td>
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