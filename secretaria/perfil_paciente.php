<?php
include '../valida_sesion.php';
include '../conexion.php';
//recibbir id para revisar perfil//
$id= $_GET["id"];
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

    </div>

    <main>
        <div class="contenedor__todo">
        

</div>
            <h2>Perfil</h2>
            <hr>
            <br>
            <div class="contenedor__login-register">
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


            
            <?php
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
            
                $sql2="SELECT * FROM usuarios  WHERE id='$id' ";
                  
                $result=mysqli_query($conexion,$sql2);
                while($mostrar=mysqli_fetch_array($result)){
                    
                ?>

                            <div class="contenedor__login-register1">
                                <!--Formulario de registro el cual enviara los datos a través del metodo post a "registro.php". la funcion de required es para que el
                                    usuario no pueda avanzar hasta rellenar todos los campos-->
                                <form action="actualizar_perfil.php" method = "POST"  enctype="multipart/form-data" class="formulario__register1" name=form2>
                                    <h2>Modificar Datos</h2>
                                    <input type="hidden" value="<?php echo $mostrar ['id'];?>" name= "rut" require>
                                    <div class="input_container">
                                    <input type="text" placeholder="Nombre" name="nombre" value="<?php echo $mostrar['nombre']?>" required>
                                    <input type="text" placeholder="Apellido Paterno" name="apellidop" value="<?php echo $mostrar['apellidoP']?>" required>
                                    </div>
                                    <div class="input_container">
                                    <input type="text" placeholder="Apellido Materno" name="apellidom" value="<?php echo $mostrar['apellidoM']?>" required>
                                    <input type="email" placeholder="Correo" name="correo" value="<?php echo $mostrar['correo']?>" required>
                                    </div>
                                    <div class="input_container">
                                    <input type="number" placeholder="Telefono" name="telefono" value="<?php echo $mostrar['telefono']?>" required>
                                    </div>
                                    <div class="input_container">
                                    <input type="text" placeholder="Fecha de nacimiento" onfocus="(this.type='date')" name= "nace" value="<?php echo $mostrar['nace']?>" required> 
                                    <input type="text" placeholder="Foto" onfocus="(this.type='file')" name="image" accept="image/x-png,image/gif,image/jpeg,image/jpg"> 
                                    </div>
                                    <button>Actualizar</button>
                                    <button type="button" id="closeBtn1">Cerrar</button>
                                </form>
                            </div>

                <div class="padre">
                    <div id=izquierda>
                        <img src="../imagenes/<?php echo $mostrar['img']; ?>" alt="" width="300px" height="300px">
                        <br>
                        <div class="caja__trasera">
                                <div class="caja__trasera-register1">
                                    <button id="btn__registrarse1">Modificar Datos</button>
                                </div>
                         </div>
                    </div>
                    

                    <div id=derecha>
                        <table class="perfil">  
                            <tr>
                                <td>Rut</td>
                                <td><?php echo calcularRUT($mostrar['id'])?></td>
                            </tr>
                            <tr>
                                <td>Nombres</td>
                                <td><?php echo $mostrar['nombre']?></td>
                            </tr>
                            <tr>
                                <td>Apellido Paterno:</td>
                                <td><?php echo $mostrar['apellidoP']?></td>
                            </tr>
                            <tr>
                                <td>Apellido Materno:</td>
                                <td><?php echo $mostrar['apellidoM']?></td>
                            </tr>
                            <tr>
                                <td>Telefono:</td>
                                <td><?php echo $mostrar['telefono']?></td>
                            </tr>

                            <tr>
                                <td>Correo:</td>
                                <td><?php echo $mostrar['correo']?></td>
                            </tr>

                            <tr>
                                <td>Fecha de nacimiento:</td>
                                <td><?php echo $mostrar["nace"];?></td>
                            </tr>
                            <tr>
                                <td>Edad:</td>
                                <td><?php $fecha_nacimiento = new DateTime($mostrar["nace"]);
                                            $hoy = new DateTime();
                                            $edad = $hoy->diff($fecha_nacimiento);
                                            echo $edad->y;?></td>
                            </tr>
                            <tr>
                                <td>Proxima Cita:</td>
                                <td>
                                <?php 
                                $sq2="SELECT * FROM usuarios u JOIN citas c ON c.paciente_id = u.id JOIN horario h on c.horario_id = h.id_horario WHERE id= '$id' and id_cargo= 3 and estado_id=1 ORDER BY c.fecha ASC, h.nombre_horario ASC LIMIT 1";
                                $result2=mysqli_query($conexion,$sq2);
                                if (mysqli_num_rows($result2)>0){
                                    while($mostrar=mysqli_fetch_array($result2)){
                                echo $mostrar ['fecha']; ?>

                                </tr>
                                <td>Hora:</td>
                                    <td>
                                        <?php echo $mostrar ['nombre_horario']?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Motivo</td>
                                    <td><?php echo $mostrar["terapia"];?></td>
                                </tr>
                                
                                <?php
                                }
                                }if (mysqli_num_rows($result2)==0){
                                    echo "No tiene cita pendiente";
                                }  
                                ?>
                            </td>
                               
                        </table>
                        <div class="caja__trasera">
                                <div class="caja__trasera-register">
                                    <button id="btn__registrarse">Agendar nueva cita</button>
                                </div>
                         </div>

                        
                    </div>
                    <?php 
                    }   
                ?>
                
                </div>
            </div>

            <br>  
            <h2>Citas</h2>
            <hr>
            <br>   
            <table id=pacientes>
                <tr>
                    <td>Codigo Cita</td>
                    <td>Nombre Paciente</td>
                    <td>Kinesiólogo</td>
                    <td>Fecha</td>
                    <td>Hora</td>
                    <td>Motivo</td>
                    <td>Estado</td>
                    <td>Acciones</td>

                </tr>
                <?php
                $sql="SELECT 
                c.id_cita, 
                p.id AS paciente_id, 
                p.nombre AS nombre_paciente, 
                p.apellidoP AS apellidoP_paciente, 
                p.apellidoM AS apellidoM_paciente, 
                p.telefono AS telefono_paciente,  
                k.id AS kine_id, 
                k.nombre AS nombre_kine, 
                k.apellidoP AS apellidoP_kine, 
                k.apellidoM AS apellidoM_kine,      
                c.fecha, 
                c.terapia, 
                c.estado_id,                      -- Agregado el campo estado_id de la tabla citas
                h.nombre_horario, 
                h.id_horario, 
                e.descripcion 
            FROM 
                citas c 
            JOIN 
                Usuarios p ON c.paciente_id = p.id 
            JOIN 
                Usuarios k ON c.kine_id = k.id 
            JOIN 
                horario h ON c.horario_id = h.id_horario 
            JOIN 
                estado e ON c.estado_id = e.id_estado 
            WHERE 
                p.id_cargo = 3 and paciente_id = $id
            ORDER BY 
                c.fecha, h.id_horario";
                $result=mysqli_query($conexion,$sql);

                while($mostrar=mysqli_fetch_array($result)){

                ?>
                <tr>
                     
                    <td><?php echo $mostrar ['id_cita']?></td>
                    <td><?php echo $mostrar['nombre_paciente'] . " " . $mostrar['apellidoP_paciente'] . " " . $mostrar['apellidoM_paciente']?></td>
                    <td><?php echo $mostrar['nombre_kine'] . " " . $mostrar['apellidoP_kine'] . " " . $mostrar['apellidoM_kine']?></td>
                    <td><?php echo $mostrar ['fecha']?></td>
                    <td><?php echo $mostrar ['nombre_horario']?></td>
                    <td><?php echo $mostrar ['terapia']?></td>
                    <td><?php echo $mostrar ['descripcion']?></td>
                    <td>
                        <a href="#" onclick="abrirModificarCita(<?php echo htmlspecialchars(json_encode($mostrar)); ?>);" id="boton" class="modificarbtn"><Map></Map>Modificar</a> 
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
    <script src="../assets/js/confirmacion.js"></script>
</body>
</html>