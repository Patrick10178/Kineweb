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
    <title>Pacientes</title>

    <link rel="stylesheet" href="css/estilos.css">

    <script src="https://kit.fontawesome.com/41bcea2ae3.js" crossorigin="anonymous"></script>
    <style>
    #boton {
    display: inline-block;
    width: calc(100% - 4px);
    padding: 6px 6px;
    border: 2px solid #fff;
    font-size: 14px;
    font-weight: 600;
    background: #006e8c;
    cursor: pointer;
    color: white;
    outline: none;
    transition: all 300ms;
    text-align: center;
    box-sizing: border-box;
    margin: 0;
}
    </style>

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
            Kinesiologa
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

            <a href="preguntas.php" id="preguntas-link">
                <div class="option">
                    <div class="icon-wrapper">
                        <i class="fa-solid fa-inbox" title="Preguntas"></i>
                        <span id="notification-dot" class="notification-dot"></span> 
                        <audio id="notification-sound" src="../noti.mp3" preload="auto"></audio>
                    </div>
                    <h4>Preguntas</h4>
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
                    <td>Correo</td>
                    <td>Telefóno</td>
                    <td>Proxima cita</td>
                    <td>Acciones</td>
                </tr>
                <?php
                $sql="SELECT * FROM usuarios  WHERE id_cargo= 3 ";
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
                <tr>
                    <td><?php echo calcularRUT($mostrar['id'])?></td>
                    <?php $id = $mostrar ['id'];?>
                    <td><?php echo $mostrar ['nombre'] ; echo " "; echo $mostrar ['apellidoP'] ; echo " "; echo $mostrar ['apellidoM']?></td>
                    <td><?php echo $mostrar ['correo']?></td>
                    <td><?php echo $mostrar ['telefono']?></td>
                    <td>
                        <?php 
                        $sq2="SELECT * FROM usuarios u JOIN citas c ON c.paciente_id = u.id JOIN horario h on c.horario_id = h.id_horario WHERE id = '$id' and id_cargo= 3 and estado_id=1 ORDER BY c.fecha ASC, h.nombre_horario ASC LIMIT 1";
                        $result2=mysqli_query($conexion,$sq2);
                        if (mysqli_num_rows($result2) > 0) {
                            while ($mostrar = mysqli_fetch_array($result2)) {
                                echo $mostrar['fecha'] . " de las " . $mostrar['nombre_horario'];
                            }
                        }if (mysqli_num_rows($result2)==0){
                            echo "No tiene cita pendiente";
                        }  
                        ?>
                    </td>
                    <td>
                        <a href="perfil_paciente.php?id=<?php echo $id;?>" class="modificarbtn" id="boton">Ver Paciente</a> 
                    </td>


                </tr>

                <?php
                }
                ?>
            </table>
            <div id="notification-container">
            </div>

        </div>     
    </main>
    
    <script src="js/script.js"></script>
</body>
</html>