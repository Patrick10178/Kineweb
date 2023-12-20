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
    <title>Preguntas</title>

    <link rel="stylesheet" href="css/estilos.css">

    <script src="https://kit.fontawesome.com/41bcea2ae3.js" crossorigin="anonymous"></script>
</head>
<body id="body">
    
    <header>
        <div class="icon__menu">
            <i class="fa-solid fa-inbox" id="btn_open2"></i>
            <h4>Consultas</h4>  
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

            <a href="consultas.php" id="consultas-link" class="selected">
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


            <a href="citas.php">
                <div class="option">
                    <i class="fa-regular fa-calendar" title="Citas"></i>
                    <h4>Citas</h4>
                </div>
            </a>

        </div>

    </div>

    <main2>
        <div class="wrapper">
            <section class="users">
                <header2>
                    <?php
                     $sql= mysqli_query($conexion, "SELECT * FROM usuarios WHERE id='$usuario'");
                     if(mysqli_num_rows($sql)>0){
                        $row= mysqli_fetch_assoc($sql);
                     }
                    ?>
                    
                    <div class="content">
                    <img src="../imagenes/<?php echo $row['img']; ?>" alt="">
                        <div class="details">
                            <span><?php echo $row ['nombre'] . " " . $row['apellidoP']. " " . $row['apellidoM'] ?></span>
                        </div>
                        
                    </div>
                 </header2>    
                    <div class ="search">
                          <span class="text">Seleccione un Kinesiologo para consultar</span>
                          <input type="text" placeholder="ingrese nombre a buscar...">
                          <button><i class="fas fa-search"></i></button>
                    </div>
                 <div class="users-list">
                </div>             
            </section>        
        </div>
    </main2>
    <script src="js/users.js"></script>
    <script src="js/script.js"></script>
</body>
</html>