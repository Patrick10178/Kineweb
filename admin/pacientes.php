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
            <i class="fa-solid fa-hospital-user" id="btn_open2"></i>
            <h4>Usuarios</h4>  
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
                <div class="caja__trasera">
                <!-- Boton para registrar nuevo usuario-->
                    <div class="caja__trasera-register">
                        <button id="btn__registrarse">Nuevo usuario</button>
                        <a href="pacientes_eliminados.php" class="btn__eliminados">Pacientes Eliminados</a>
                    </div>
                </div>

                <!--Formulario de registro-->
                <div class="contenedor__login-register">
    <!-- Formulario de registro el cual enviará los datos a través del método post a "registro.php". La función de required es para que el
         usuario no pueda avanzar hasta rellenar todos los campos -->
                    <form action="registro.php" method="POST" enctype="multipart/form-data" class="formulario__register" name="form1">
                        <h2>Datos Usuario</h2>
                        <input type="text" required placeholder="Ingrese su rut" name="rut" onblur="return Rut(form1.rut.value)" />
                        <div class="input_container">
                            <input type="text" placeholder="Nombre" name="nombre" required>
                            <input type="text" placeholder="Apellido Paterno" name="apellidop">
                        </div>
                        <div class="input_container">
                            <input type="text" placeholder="Apellido Materno" name="apellidom">
                            <input type="email" placeholder="Correo" name="correo" required>
                        </div>
                        <div class="input_container">
                            <input type="number" placeholder="Telefono" name="telefono" required>
                            <input type="password" placeholder="Contraseña" name="contrasena">
                        </div>
                        <div class="input_container">
                            <!-- Dropdowns para seleccionar día, mes y año -->
                            <div class="fecha-container" tabindex="0" onfocus="activarFecha()">
                                <span id="fecha-placeholder">Fecha de Nacimiento</span>
                                <div id="selects-fecha" style="display: none;">
                                    <select id="fecha_na" name="dia_nace" required>
                                        <?php for($i=1; $i<=31; $i++): ?>
                                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                        <?php endfor; ?>
                                    </select>
                                    <select id="fecha_na" name="mes_nace" required>
                                        <?php 
                                        $meses = array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
                                        foreach($meses as $index => $mes): ?>
                                            <option value="<?php echo $index + 1; ?>"><?php echo $mes; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <select id="fecha_na" name="ano_nace" required>
                                        <?php for($i=date("Y"); $i>=1900; $i--): ?>
                                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                            </div>
                            <input type="text" placeholder="Foto" onfocus="(this.type='file')" name="image" accept="image/x-png,image/gif,image/jpeg,image/jpg">
                        </div>
                        <div class="input_container">
                            <!-- Dropdown para seleccionar el tipo de usuario -->
                            <div class="fecha-container" tabindex="0" onfocus="activarFecha('tipo-usuario')">
                                <span id="tipo-usuario-placeholder">Tipo de Usuario</span>
                                <select id="selects-tipo-usuario" name="tipo_usuario" style="display: none;" required>
                                    <option value="1">Kinesiólogo</option>
                                    <option value="2">Secretaria</option>
                                    <option value="3">Paciente</option>
                                </select>
                            </div>

                            <!-- Dropdown para seleccionar el sexo -->
                            <div class="fecha-container" tabindex="0" onfocus="activarFecha('sexo')">
                                <span id="sexo-placeholder">Sexo</span>
                                <select id="selects-sexo" name="sexo" style="display: none;" required>
                                    <option value="m">Masculino</option>
                                    <option value="f">Femenino</option>
                                </select>
                            </div>
                        </div>
                        <div class="contenedor__radio">
                            <div class="radio_container">
                                <input type="checkbox" id="admin" name="admin" value="1">
                                <label for="admin">Administrador</label>
                            </div>
                        </div>

                        <h4>
                        <button>Guardar</button>
                        <button type="button" id="closeBtn">Cerrar</button>
                    </form>
            </div>

            </div>

            <h2>Pacientes</h2>
            <hr>
            <br>
            <!-- tabla de los pacientes-->
            <table id=pacientes>
                <tr>
                    <td>Rut</td>
                    <td>Nombre</td>
                    <td>Correo</td>
                    <td>Telefono</td>
                    <td>Fecha nacimiento</td>
                    <td>Acciones</td>
                </tr>
                <?php
                /* hace la consulta a la base de datos de todos los Usuarios con el cargo de pacientes y los muestra en la tabla con un while */
                $sql="SELECT * FROM usuarios WHERE id_cargo = 3";
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
                    <td><?php echo $mostrar ['nace']?></td>
                    
                    <td>
                        <a href="#" onclick="abrirModificarPaciente(<?php echo htmlspecialchars(json_encode($mostrar)); ?>);" id="boton" class="modificarbtn">Modificar</a> 
                        <a href="eliminar_paciente.php?id=<?php echo $mostrar ['id'];?>"id="boton" class="eliminarbtn">Eliminar</a>
                        <a href="perfil_paciente.php?id=<?php echo $mostrar ['id'];?>" class="modificarbtn" id="boton">Ver Paciente</a> 

                    </td>

                </tr>

                <?php
                }
                ?>
            </table>
            <br>
            <h2>Funcionarios</h2>
            <hr>
            <br>
            <!-- tabla de los pacientes-->
            <table id=pacientes>
                <tr>
                    <td>Rut</td>
                    <td>Nombre</td>
                    <td>Correo</td>
                    <td>Telefono</td>
                    <td>Fecha nacimiento</td>
                    <td>Acciones</td>
                </tr>
                <?php
                /* hace la consulta a la base de datos de todos los Usuarios con el cargo de pacientes y los muestra en la tabla con un while */
                $sql="SELECT * FROM usuarios WHERE id_cargo <> 3 and id_cargo <> 4 ";
                $result=mysqli_query($conexion,$sql);
                while($mostrar=mysqli_fetch_array($result)){

                ?>
                <tr>
                    <td><?php echo calcularRUT($mostrar['id'])?></td>
                    <td><?php echo $mostrar ['nombre'] ; echo " "; echo $mostrar ['apellidoP'] ; echo " "; echo $mostrar ['apellidoM']?></td>
                    <td><?php echo $mostrar ['correo']?></td>
                    <td><?php echo $mostrar ['telefono']?></td>
                    <td><?php echo $mostrar ['nace']?></td>
                    
                    <td>
                        <a href="#" onclick="abrirModificarPaciente(<?php echo htmlspecialchars(json_encode($mostrar)); ?>);" id="boton" class="modificarbtn">Modificar</a> 
                        <a href="eliminar_paciente.php?id=<?php echo $mostrar ['id'];?>"id="boton" class="eliminarbtn">Eliminar</a>
                        <a href="perfil_paciente.php?id=<?php echo $mostrar ['id'];?>" class="modificarbtn" id="boton">Ver Funcionario</a> 

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