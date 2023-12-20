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
    <title>Inicio</title>

    <link rel="stylesheet" href="css/estilos.css">

    <script src="https://kit.fontawesome.com/41bcea2ae3.js" crossorigin="anonymous"></script>
</head>
<body id="body">
    
    <header>
        <div class="icon__menu">
            <i class="fas fa-home" id="btn_open2"></i>
            <h4>Inicio</h4>  
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

            <a href="index.php" class="selected">
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
            <a href="pacientes.php">
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
                        $sql2="SELECT * FROM usuarios  WHERE id='$usuario' ";
                          
                        $result=mysqli_query($conexion,$sql2);
                        while($mostrar=mysqli_fetch_array($result)){
                            
                        ?>
                                <div class="contenedor__login-register">
                                <!--Formulario de registro el cual enviara los datos a través del metodo post a "registro.php". la funcion de required es para que el
                                    usuario no pueda avanzar hasta rellenar todos los campos-->
                                <form action="actualizar_perfil.php" method = "POST"  enctype="multipart/form-data" class="formulario__register" name=form1>
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
                                       
                                </table>
                                <div class="caja__trasera">
                                        <div class="caja__trasera-register">
                                            <button id="btn__registrarse">Actualizar datos</button>
                                            

                                        </div>
                                </div>
                                
                            </div>
                            <?php 
                            }   
                        ?>
                        </div>
                    </div>
                    <h2>Proximas Citas</h2>
                    <hr>
                    <br>
                    
                    <table id=pacientes>
                <tr>
                    <td>Rut</td>
                    <td>Nombre</td>
                    <td>Telefono</td>
                    <td>Fecha</td>
                    <td>Hora</td>
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
                
                    return $rutFormateado;
                }

                while($mostrar=mysqli_fetch_array($result)){

                ?>
                <tr>
                    <?php $id = $mostrar ['id'];?>

                        <?php 
                        $sq2="SELECT * FROM usuarios u JOIN citas c ON c.paciente_id = u.id JOIN horario h on c.horario_id = h.id_horario WHERE id= '$id' and id_cargo= 3 and estado_id=1 and kine_id='$usuario' ORDER BY c.fecha, c.horario_id";
                        $result2=mysqli_query($conexion,$sq2);
                        

                        if (mysqli_num_rows($result2) > 0) {
                            // Recorrer cada fila del resultado
                            while ($mostrar = mysqli_fetch_assoc($result2)) {
                                // Iniciar una nueva fila para cada registro de cita
                                echo '<tr>';
                                // Imprimir los datos de cada cita en su propia celda
                                echo '<td>' . calcularRUT($mostrar['paciente_id']) . '</td>';
                                echo '<td>' . $mostrar['nombre'] . ' ' . $mostrar['apellidoP'] . ' ' . $mostrar['apellidoM'] . '</td>';
                                echo '<td>' . $mostrar['telefono'] . '</td>';
                                echo '<td>' . $mostrar['fecha'] . '</td>';
                                echo '<td>' . $mostrar['nombre_horario'] . '</td>';
                                // Acciones como botones o enlaces
                                echo '<td>';
                                echo '<a href="perfil_paciente.php?id=' . $mostrar['paciente_id'] . '" class="modificarbtn" id="boton">Ver Paciente</a>';
                                // Agrega aquí más botones o enlaces según sea necesario
                                echo '</td>';
                                // Finalizar la fila de la cita
                                echo '</tr>';
                            }
                        }
                        ?>
                    </td>
   


                </tr>

                <?php
                }
                ?>
            </table>
             <br>
            <h2>Estadisticas</h2>
                    <hr>

                    
                    <div class="chart-container" style="position: relative; height:40vh; width:80vw">
                        <h2>Por Rango Etario</h2>
                        <canvas id="graficoEdades"></canvas>
                    </div>
                    <br>
                    <br>

                    <div class="chart-container" style="position: relative; height:40vh; width:80vw">
                        <h2>Por Género</h2>
                        <canvas id="graficoGeneros"></canvas>
                    </div>

                    <?php
                        // SQL para seleccionar datos
                        $sq3 = "SELECT terapia, COUNT(*) as count FROM citas GROUP BY terapia";
                        $result3=mysqli_query($conexion,$sq3);
                        // Inicializar array para los datos
                        $data = [];

                        if ($result3->num_rows > 0) {
                            while($row = $result3->fetch_assoc()) {
                                $data[$row['terapia']] = $row['count'];
                            }
                        } else {
                            echo "0 results";
                        }

                        $total = array_sum($data);
                        foreach($data as $terapia => $count) {
                            $data[$terapia] = ($count / $total) * 100;
                        }

                        // Convertir los datos a formato JSON para usar con Chart.js
                        $jsonData = json_encode($data);
                    ?>
                    <?php

                    // Por rango etario
                    $sqlEdad = "
                        SELECT 
                            terapia, 
                            TIMESTAMPDIFF(YEAR, nace, CURDATE()) AS edad 
                        FROM usuarios
                        INNER JOIN citas ON usuarios.id = citas.paciente_id;
                    ";
                    $resultadoEdad = mysqli_query($conexion, $sqlEdad);
                    $estadisticasEdad = [
                        '0-18' => 0,
                        '19-35' => 0,
                        '36-55' => 0,
                        '56+' => 0,
                    ];

                    while ($fila = mysqli_fetch_assoc($resultadoEdad)) {
                        if ($fila['edad'] <= 18) {
                            $estadisticasEdad['0-18']++;
                        } elseif ($fila['edad'] <= 35) {
                            $estadisticasEdad['19-35']++;
                        } elseif ($fila['edad'] <= 55) {
                            $estadisticasEdad['36-55']++;
                        } else {
                            $estadisticasEdad['56+']++;
                        }
                    }

                    // Por género
                    $sqlGenero = "
                        SELECT 
                            terapia, 
                            sex, 
                            COUNT(*) as cantidad 
                        FROM usuarios
                        INNER JOIN citas ON usuarios.id = citas.paciente_id
                        GROUP BY terapia, sex;
                    ";
                    $resultadoGenero = mysqli_query($conexion, $sqlGenero);
                    $estadisticasGenero = [];

                    while ($fila = mysqli_fetch_assoc($resultadoGenero)) {
                        $sexo = $fila['sex'] == "f" ? 'Femenino' : 'Masculino';
                        $terapia = $fila['terapia'];
                        if (!isset($estadisticasGenero[$terapia])) {
                            $estadisticasGenero[$terapia] = ['Femenino' => 0, 'Masculino' => 0];
                        }
                        $estadisticasGenero[$terapia][$sexo] = $fila['cantidad'];
                    }

                    // Prepara los datos para los gráficos
                    $edadesLabels = json_encode(array_keys($estadisticasEdad));
                    $edadesData = json_encode(array_values($estadisticasEdad));

                    $generosLabels = json_encode(array_keys($estadisticasGenero));
                    $generosData = [];
                    foreach ($estadisticasGenero as $terapia => $datos) {
                        foreach ($datos as $sexo => $cantidad) {
                            $generosData[$sexo][] = $cantidad; // Asume que siempre hay datos para ambos géneros por cada terapia
                        }
                    }
                    $generosData = array_map('json_encode', $generosData);
                    ?>

                    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                        <script>
                        // Datos para el gráfico de edades
                            const edadesLabels = <?php echo $edadesLabels; ?>;
                            const edadesData = <?php echo $edadesData; ?>;

                            const graficoEdades = new Chart(document.getElementById('graficoEdades'), {
                                type: 'bar',
                                data: {
                                    labels: edadesLabels,
                                    datasets: [{
                                        label: 'Cantidad por rango etario',
                                        data: edadesData,
                                        backgroundColor: 'rgba(0, 123, 255, 0.5)',
                                        borderColor: 'rgba(0, 123, 255, 1)',
                                        borderWidth: 1
                                    }]
                                },
                                options: {
                                    scales: {
                                        y: {
                                            beginAtZero: true
                                        }
                                    }
                                }
                            });

                            // Datos para el gráfico de géneros
                            const generosLabels = <?php echo $generosLabels; ?>;
                            const generosDataFemenino = <?php echo $generosData['Femenino']; ?>;
                            const generosDataMasculino = <?php echo $generosData['Masculino']; ?>;

                            const graficoGeneros = new Chart(document.getElementById('graficoGeneros'), {
                                type: 'bar',
                                data: {
                                    labels: generosLabels,
                                    datasets: [
                                        {
                                            label: 'Femenino',
                                            data: generosDataFemenino,
                                            backgroundColor: 'rgba(255, 99, 132, 0.5)',
                                            borderColor: 'rgba(255, 99, 132, 1)',
                                            borderWidth: 1
                                        },
                                        {
                                            label: 'Masculino',
                                            data: generosDataMasculino,
                                            backgroundColor: 'rgba(54, 162, 235, 0.5)',
                                            borderColor: 'rgba(54, 162, 235, 1)',
                                            borderWidth: 1
                                        }
                                    ]
                                },
                                options: {
                                    scales: {
                                        y: {
                                            beginAtZero: true
                                        }
                                    }
                                }
                            });


                </script>
                    <br>
            </main>

    <script src="js/script.js"></script>
</body>
</html>