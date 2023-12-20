<?php
include '../valida_sesion.php';
include '../conexion.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Citas</title>

    <link rel="stylesheet" href="css/estilos.css">

    <script src="https://kit.fontawesome.com/41bcea2ae3.js" crossorigin="anonymous"></script>
</head>
<body id="body">
    
    <header>
        <div class="icon__menu">
            <i class="fa-regular fa-calendar" id="btn_open2"></i>
            <h4>Citas</h4>  
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
            Paciente
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

            <a href="index.php" >
                <div class="option">
                    <i class="fas fa-home" title="Inicio"></i>
                    <h4>Inicio</h4>
                </div>
            </a>

            <a href="consultas.php" id="consultas-link">
                <div class="option">
                    <div class="icon-wrapper">
                        <i class="fa-solid fa-inbox" title="consultas"></i>
                        <span id="notification-dot" class="notification-dot"></span>
                        <audio id="notification-sound" src="../noti.mp3" preload="auto"></audio>
                    </div>
                    <h4>consultas</h4>
                </div>
            </a>


            <a href="videos.php">
              <div class="option">
                <i class="fa-solid fa-video" title="Videos"></i>
                <h4>Videos</h4>
            </div>
            </a>


            <a href="citas.php" class="selected">
                <div class="option">
                    <i class="fa-regular fa-calendar" title="Citas"></i>
                    <h4>Citas</h4>
                </div>
            </a>

        </div>

    </div>

    <main>
    <main>       
         <div class="contenedor__todo">
            <h2>Mis Citas</h2>
            <hr>
            <br>
            <table id=pacientes>
                <tr>
                    <td>Codigo Cita</td>
                    <td>Rut</td>
                    <td>Nombre</td>
                    <td>Motivo</td>
                    <td>Fecha</td>
                    <td>Hora</td>
                    <td>Acciones</td>

                </tr>
                <?php
                $sql="SELECT * FROM citas c JOIN usuarios u ON c.paciente_id = u.id JOIN horario h on c.horario_id = h.id_horario WHERE id= '$usuario'";
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
                
                    return $rutFormateado;}
                while($mostrar=mysqli_fetch_array($result)){

                ?>
                <form action="actualizar_cita.php" method="POST">
                    <td><?php echo $mostrar ['id_cita']?></td>
                    <input type="hidden" value="<?php echo $mostrar ['id_cita'];?>" name= "cita">
                    <td><?php echo calcularRUT($mostrar['id'])?></td>
                    <td><?php echo $mostrar ['nombre'] ; echo " "; echo $mostrar ['apellidoP'] ; echo " "; echo $mostrar ['apellidoM']?></td>
                    <td><input type="text" value="<?php echo $mostrar ['terapia'];?>" name= "terapia" require></td>
                    <td><input type="date" value="<?php echo $mostrar ['fecha'];?>" name= "fecha" require min=<?php $hoy=date("Y-m-d"); echo $hoy;?> /></td>
                    <td>
                        <select id="horari" name="horario" require>
                        <option value="0" class=opcion>Seleccionar horario</option>
                         <?php
                         $sql="SELECT * FROM horario";
                         $result=mysqli_query($conexion,$sql);
                         while($mostrar=mysqli_fetch_array($result)){
                            echo '<option value="'.$mostrar['id_horario'].'">'.$mostrar['nombre_horario'].' </option>';
                            }
                         ?></td>
                    <td><input type="submit" value="Actualizar"></td>

                    <input type="hidden" value="<?php echo $mostrar ['id'];?>" name= "rut" require>
                    

                </form>

                <?php
                }
                ?>
            </table> 
    </main>

    <script src="js/script.js"></script>
</body>
</html>