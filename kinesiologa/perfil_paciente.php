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
            Kinesiologa
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
        

</div>
            <h2>Perfil</h2>
            <hr>
            <br>
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
                            <div class="contenedor__login-register">
                        <!--Formulario de registro el cual enviara los datos a través del metodo post a "registro.php". la funcion de required es para que el
                            usuario no pueda avanzar hasta rellenar todos los campos-->
                        <form action="agregar_videos.php" method = "POST" class="formulario__register" name=form1>
                            <h2>Agregar Ejercicios</h2>
                            <input type="hidden" value="<?php echo $mostrar ['id'];?>" name= "rut" require>
                            <div class="input_container">
                            <input type="text" placeholder="Nombre Ejercicio" name="nombre" required>
                            <input type="text" placeholder="Link Video" name="link" required>
                            </div>
                            <button>Agregar</button>
                            <button type="button" id="closeBtn">Cerrar</button>
                        </form>
            </div>
                <div class="padre">
                    <div id=izquierda>
                        <img src="../imagenes/<?php echo $mostrar['img']; ?>" alt="" width="300px" height="300px">
                        <br>
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
                                    <button id="btn__registrarse">Agregar videos de terapia</button>
                        </div>
            </div>
                        
                    </div>
                    <?php 
                    }   
                ?>
                
                </div>
            </div>

            <br>  
            <h2>Seguimiento</h2>
            <hr>
            <br>   
            <table id=pacientes>
                <tr>
                    <td>Codigo Cita</td>
                    <td>Fecha</td>
                    <td>Hora</td>
                    <td>Motivo</td>
                    <td>Estado</td>
                    <td>Acciones</td>

                </tr>
                <?php
                $sql="SELECT * FROM citas c JOIN usuarios u ON c.paciente_id = u.id JOIN horario h on c.horario_id = h.id_horario JOIN estado e on c.estado_id=e.id_estado WHERE id = '$id' ORDER BY c.fecha, c.horario_id";
                $result=mysqli_query($conexion,$sql);

                while($mostrar=mysqli_fetch_array($result)){

                ?>
                <tr>
                     
                    <td><?php echo $mostrar ['id_cita']?></td>
                    <td><?php echo $mostrar ['fecha']?></td>
                    <td><?php echo $mostrar ['nombre_horario']?></td>
                    <td><?php echo $mostrar ['terapia']?></td>
                    <td><?php echo $mostrar ['descripcion']?></td>
                    <td>
                        <a href="confirmar_cita.php?id=<?php echo $mostrar ['id_cita'];?>" class="modificarbtn" id="boton">marcar asistencia</a> 
                        <a href="desconfirmar_cita.php?id=<?php echo $mostrar ['id_cita'];?>" class="modificarbtn" id="boton">marcar inasistencia</a> 
                     </td>
                </tr>

                <?php
                }
                ?>
            </table> 

            <br>   
            <table id=pacientes>
                <tr>
                    <td>Codigo Ejercicio</td>
                    <td>Nombre</td>
                    <td>Estado</td>

                </tr>
                <?php
                $sql="SELECT * FROM videos v JOIN usuarios u ON v.id_paciente = u.id JOIN estado e on v.estado=e.id_estado WHERE id = '$id'";
                $result=mysqli_query($conexion,$sql);

                while($mostrar=mysqli_fetch_array($result)){

                ?>
                <tr>
                     
                    <td><?php echo $mostrar ['id_videos']?></td>
                    <td><?php echo $mostrar ['nombrev']?></td>

                    <td><?php echo $mostrar ['descripcion']?></td>
                </tr>

                <?php
                }
                ?>
            </table> 
                        
    </main>
    <script src="js/script.js"></script>
</body>
</html>