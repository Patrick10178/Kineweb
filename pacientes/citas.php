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
    <style>
    .caja__trasera {
        display: none;
    }
    </style>

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
         <div class="contenedor__todo">
         <div class="contenedor__login-register">

            <!--Registro de citas-->
            <!-- Input para buscar por RUT -->
            <form action="registro_citas.php" method = "POST" class="formulario__register">
                <h2>Datos Cita</h2>
                <span id="rut-error" class="input-error-message" style="display: none; color: red;">RUT incorrecto</span>
                <input type="hidden" id="cita" name="cita" required>
                <input type="hidden" id="rutSearch"  name="rut" required>
                <!-- Lista desplegable para los resultados -->
                <div id="rutResults-list" style="display: none;"></div>
                <input type="date"  id="fecha" name="fecha"  required min=<?php $hoy=date("Y-m-d"); echo $hoy;?> />
                <br>
                <label for="horario"></label>
                <select id="horario" name="horario" require>
                <option value="0" class=opcion>Seleccionar horario</option>
                <?php
                    $sql="SELECT * FROM horario";
                    $result=mysqli_query($conexion,$sql);
                    while($mostrar=mysqli_fetch_array($result)){
                        echo '<option value="'.$mostrar['id_horario'].'">'.$mostrar['nombre_horario'].' </option>';
                    }
                ?>
                </select>
                <!-- Nuevo código: Lista desplegable para kinesiólogos -->
                <label for="kine_id"></label>
                <select id="kine_id" name="kine_id" required>
                    <option value="0">Seleccionar kinesiólogo</option>
                    <!-- Los kinesiólogos se agregarán dinámicamente usando JavaScript -->
                </select>
                <input type="text" placeholder="Motivo terapia" id="terapia" name="terapia" required>
                <button>Guardar</button>
                <button type="button" id="closeBtn">Cerrar</button>
            </form>
            </div>
            </div>
            <h2>Mis Citas</h2>
            <hr>

    <div class="caja__trasera">
    <div class="caja__trasera-register">
        <button id="btn__registrarse">Nueva Cita</button>
    </div>
    </div>
    <Br>

            <table id=pacientes>
                <tr>
                <td>Codigo Cita</td>
                <td>Rut Paciente</td>
                <td>Nombre Paciente</td>
                <td>Rut Kinesiólogo</td>
                <td>Nombre Kinesiólogo</td>
                <td>Fecha</td>
                <td>Hora</td>
                <td>Motivo</td>
                <td>Estado</td>
                <td>Acciones</td>

                </tr>
                <?php
                $sql = "SELECT 
                c.id_cita, 
                p.id as paciente_id, 
                p.nombre as nombre_paciente, 
                p.apellidoP as apellidoP_paciente, 
                p.apellidoM as apellidoM_paciente, 
                k.id as kine_id, 
                k.nombre as nombre_kine, 
                k.apellidoP as apellidoP_kine, 
                k.apellidoM as apellidoM_kine, 
                c.fecha, 
                c.terapia, 
                h.nombre_horario, h.id_horario,
                e.descripcion 
                FROM citas c 
                JOIN usuarios p ON c.paciente_id = p.id 
                JOIN usuarios k ON c.kine_id = k.id 
                JOIN horario h ON c.horario_id = h.id_horario 
                JOIN estado e ON c.estado_id = e.id_estado 
                WHERE c.paciente_id = '$usuario';";
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
                    <td><?php echo $mostrar['id_cita']; ?></td>
                    <td><?php echo calcularRUT($mostrar['paciente_id']); ?></td>
                    <td><?php echo $mostrar['nombre_paciente'] . " " . $mostrar['apellidoP_paciente'] . " " . $mostrar['apellidoM_paciente']; ?></td>
                    <!-- Agregar información del kinesiólogo -->
                    <td><?php echo calcularRUT($mostrar['kine_id']); ?></td>
                    <td><?php echo $mostrar['nombre_kine'] . " " . $mostrar['apellidoP_kine'] . " " . $mostrar['apellidoM_kine']; ?></td>
                    <td><?php echo $mostrar['fecha']; ?></td>
                    <td><?php echo $mostrar['nombre_horario']; ?></td>
                    <td><?php echo $mostrar['terapia']; ?></td>
                    <td><?php echo $mostrar['descripcion']; ?></td>
                    <td>
                        <a href="#" onclick="abrirModificarCita(<?php echo htmlspecialchars(json_encode($mostrar)); ?>);" class="modificarbtn" id="boton">modificar</a>
                        <a href="eliminar_cita.php?id=<?php echo $mostrar['id_cita']; ?>" class="cancelarbtn" id="boton">cancelar</a>
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