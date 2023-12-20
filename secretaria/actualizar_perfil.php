<?php

include '../conexion.php';
//recibe los datos enviados desde el formulario de resgistro de pacientes.php y los almacena en variables para luego realizar la consulta sql //
$rut = $_POST['rut'];
$nombre = $_POST['nombre'];
$apellidop = $_POST['apellidop'];
$apellidom = $_POST['apellidom'];
$correo = $_POST['correo'];
$telefono = $_POST['telefono'];
$nace = $_POST['nace'];

//verifica que se haya recibido la imagen
if(isset($_FILES['image'])){
                    $img_name = $_FILES['image']['name'];
                    $img_type = $_FILES['image']['type'];
                    $tmp_name = $_FILES['image']['tmp_name'];
                    
                    $img_explode = explode('.',$img_name);
                    $img_ext = end($img_explode);
    
                    $extensions = ["jpeg", "png", "jpg"];
                    //verifica que el archivo sea una imagen con esas extensiones
                    if(in_array($img_ext, $extensions) === true){
                        $types = ["image/jpeg", "image/jpg", "image/png"];
                        if(in_array($img_type, $types) === true){
                            $time = time();
                            $new_img_name = $time.$img_name;
                            //mueve la imagen y la guarda en el directorio
                            if(move_uploaded_file($tmp_name,"../imagenes/".$new_img_name)){
                                $query = "UPDATE `usuarios` SET `nombre`= '$nombre' , `apellidoP`= '$apellidop', `apellidoM` = '$apellidom' , `correo` = '$correo', 
                                `telefono` = '$telefono' , `nace` = '$nace', `img`= '$new_img_name' WHERE `id` = $rut";
                            //si no existe el paciente, procede a almacenarlo a la base de datos//

                            $ejecutar = mysqli_query($conexion, $query);
                            
                            if ($ejecutar){
                                echo "
                                <script>
                                    alert('perfil actualizado exitosamente');
                                    window.history.back();
                                </script>
                                ";
                            }else{
                                echo "
                                <script>
                                    alert('error, intentelo nuevamente');
                                    window.history.back();
                                </script>
                                "; }
                            }
                        }else{
                            echo "Please upload an image file - jpeg, png, jpg";
                        }
                    }else{
                        echo "Please upload an image file - jpeg, png, jpg";
                    }
                }else{//si no sube imagen, solo actualizar los datos
                    $query = "UPDATE `usuarios` SET `nombre`= '$nombre' , `apellidoP`= '$apellidop', `apellidoM` = '$apellidom' , `correo` = '$correo', 
                                `telefono` = '$telefono' , `nace` = '$nace' WHERE `id` = $rut";

                        $ejecutar = mysqli_query($conexion, $query);
                                                    
                        if ($ejecutar){
                            echo "
                            <script>
                                alert('perfil actualizado exitosamente');
                                window.history.back();
                            </script>
                            ";
                        }else{
                            echo "
                            <script>
                                alert('error, intentelo nuevamente');
                                window.history.back();
                            </script>
                            "; }
                        
                }





?>