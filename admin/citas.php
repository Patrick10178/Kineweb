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
    <style>
        #boton {
        display: inline-block;
        width: calc(33% - 4px);
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

            <a href="citas.php" class="selected">
                <div class="option">
                    <i class="fa-regular fa-calendar" title="citas"></i>
                    <h4>Citas</h4>
                </div>
            </a>
            
            <a href="pacientes.php">
                <div class="option">
                    <i class="fa-solid fa-hospital-user" title="Usuarios"></i>
                    <h4>Usuarios</h4>
                </div>
            </a>

        </div>

    </div>

    <main>        
        <div class="contenedor__todo">
                <div class="caja__trasera">

                    <div class="caja__trasera-register">
                        <button id="btn__registrarse">Nueva Cita</button>
                    </div>
                </div>

                <!--Formulario de registro-->
                <div class="contenedor__login-register">

                    <!--Registro de citas-->
                    <!-- Input para buscar por RUT -->
                    <form action="registro_citas.php" method = "POST" class="formulario__register">
                        <h2>Datos Cita</h2>
                            <!-- Campo oculto para el ID de la cita -->
                        <input type="hidden" name="cita" id="cita">
                        <span id="rut-error" class="input-error-message" style="display: none; color: red;">RUT incorrecto</span>
                        <input type="text" id="rutSearch" placeholder="Rut (Sin puntos, guion y digito verificador)" name="rut" required>
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
                        <button>Guardarr</button>
                        <button type="button" id="closeBtn">Cerrar</button>
                    </form>
                </div>
            </div>

            <h2>Citas</h2>
            <hr>
            <br>
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
                /*muestra las citas y los pacientes y las horas, juntando las tablas con el join*/
                $sql = "SELECT c.id_cita, p.id as paciente_id, p.nombre as nombre_paciente, p.apellidoP as apellidoP_paciente, p.apellidoM as apellidoM_paciente, 
                k.id as kine_id, k.nombre as nombre_kine, k.apellidoP as apellidoP_kine, k.apellidoM as apellidoM_kine, 
                c.fecha, c.terapia, h.nombre_horario, h.id_horario, e.descripcion 
                FROM citas c 
                JOIN Usuarios p ON c.paciente_id = p.id 
                JOIN Usuarios k ON c.kine_id = k.id 
                JOIN horario h ON c.horario_id = h.id_horario 
                JOIN estado e ON c.estado_id = e.id_estado 
                WHERE p.id_cargo = 3;";

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
                     
                    <td><?php echo $mostrar['id_cita']?></td>
                    <td><?php echo calcularRUT($mostrar['paciente_id'])?></td>
                    <td><?php echo $mostrar['nombre_paciente'] . " " . $mostrar['apellidoP_paciente'] . " " . $mostrar['apellidoM_paciente']?></td>
                    <td><?php echo calcularRUT($mostrar['kine_id'])?></td>
                    <td><?php echo $mostrar['nombre_kine'] . " " . $mostrar['apellidoP_kine'] . " " . $mostrar['apellidoM_kine']?></td>

                    <td><?php echo $mostrar['fecha']?></td>
                    <td><?php echo $mostrar['nombre_horario']?></td>
                    <td><?php echo $mostrar['terapia']?></td>
                    <td><?php echo $mostrar['descripcion']?></td>
                    <td>
                        <!--Botones de accion -->
                        <a href="#" onclick="abrirModificarCita1(<?php echo htmlspecialchars(json_encode($mostrar)); ?>);" id="boton" class="modificarbtn"><Map></Map>Modificar</a> 

                        <a href="cancelar_cita.php?id=<?php echo $mostrar ['id_cita'];?>" id="boton" class="cancelarbtn">Cancelar</a>
                        <a href="eliminar_cita.php?id=<?php echo $mostrar ['id_cita'];?>" id="boton" class="eliminarbtn">Eliminar</a> 
                     </td>
                </tr>


                <?php
                }
                ?>
            </table> 
    </main>

    <script src="js/script.js"></script>
    <script src="../assets/js/script.js"></script>
    <script src="../assets/js/confirmacion.js"></script>
</body>
</html>

