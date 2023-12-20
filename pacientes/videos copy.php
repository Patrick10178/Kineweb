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
    <title>Videos</title>

    <link rel="stylesheet" href="css/estilos.css">

    <script src="https://kit.fontawesome.com/41bcea2ae3.js" crossorigin="anonymous"></script>
</head>
<body id="body">
    
    <header>
        <div class="icon__menu">
            <i class="fa-solid fa-video" id="btn_open2"></i>
            <h4>Video</h4>  
        </div>
        <div class="usuario">
            <h4>
            <?php
            //Mostrar informacion de sesion//
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

            <a href="consultas.php">
              <div class="option">
                <i class="fa-solid fa-inbox" title="Consultas"></i>
                <h4>Consultas</h4>
            </div>
            </a>

            <a href="videos.php" class="selected">
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

    <main>
             <?php
            //Mostrar id de la terapia pendiente a realizar//
                 $sql="SELECT MIN(id_videos)   
                 FROM videos   
                 WHERE id_paciente = $usuario AND estado = 1;   ";
                 $result=mysqli_query($conexion,$sql);
                 while($mostrar=mysqli_fetch_array($result)){
                    $num= $mostrar ['MIN(id_videos)'];
                 }
              ?>
            <?php
            //Mostrar datos y link de la terapia a realizar//
                 $sql="SELECT * FROM `videos` WHERE id_videos=$num ";
                 $result=mysqli_query($conexion,$sql);
                 while($mostrar=mysqli_fetch_array($result)){
                    ?>      
                    <h2>Terapia en casa</h2>         
                    <hr>
                    <br>
                <div class="contenedor__login-register" >
                                <!--Formulario de registro el cual enviara los datos a través del metodo post a "registro.php". la funcion de required es para que el
                                    usuario no pueda avanzar hasta rellenar todos los campos-->
                                <form action="actualizar_perfil.php" method = "POST"  enctype="multipart/form-data" class="formulario__register" name=form1 id="exp">
                                    <h2>Experiencia</h2>
                                    <textarea id="w3review" name="w3review" rows="5" cols="45" placeholder="Deja tus comentarios sobre la terapia (opcional)..."></textarea>
                                    <br>
                                    <button>enviar</button>
                                </form>
                </div>
                     <div class="padre"> 
                
                         <div class=rectangle-17>
                
                              <div class="btn">
                                    <div class="play"></div>
                                    <p>reproducir</p>
                                    <h2><?php echo $mostrar ['nombre']; ?></h2>
                             </div> 
                
                        </div>   
        
                         <div class="clip">
                            <iframe width="90%" height="500" src="<?php echo $mostrar ['link']; ?>"></iframe>
                            <b class="close">Cerrar</b>   
                        </div> 
                </div>
        
            <br>
        
            <div id=boton_video>
                        <br>
                        <div class="caja__trasera">
                                <div class="caja__trasera-register">
                                     <button id="btn__registrarse">Continuar terapia</button>
                                </div>
                        </div>
            </div>
            <?php  } ?>     
    </main>

    <script src="js/script.js"></script>
    <script>
        let btn = document.querySelector('.btn');
        let clip = document.querySelector('.clip');
        let close = document.querySelector('.close');
        btn.onclick = function(){
            btn.classList.add('active');
            clip.classList.add('active');
        }
        close.onclick = function(){
            btn.classList.remove('active');
            clip.classList.remove('active');
            setTimeout(function(){
                location.reload();
            },1000);
        }


    </script>
</body>
</html>