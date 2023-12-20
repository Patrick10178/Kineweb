<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login kineweb</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">


    <link rel="stylesheet" href="assets/css/estilos.css">
</head>
<body>

        <main>

            <div class="contenedor__todo">
                <div class="caja__trasera">
    
                    <div class="caja__trasera-register">
                        <h3>Kineweb</h3>
                        <p class="justificado"> Tiene como objetivo reintegrar al paciente a su actividad habitual y deportiva en el más breve período de tiempo, en las mejores condiciones y sin riesgo de recaer con su lesión. Contamos con la infraestructura adecuada y con los mejores adelantos tecnológicos que se manejan a nivel mundial.</p>
                    </div>
                </div>
                <div class="contenedor__login-register">
                    <!--Recoge los datos insertados y los envia a "valida_login.php" para validarlos en la base de datos, y los llevara a su respectivo login
                         dependiendo si es paciente, kinesiologa o secretaria-->
                         <form method="POST" class="formulario__login">
                            <h2>Iniciar Sesión</h2>
                            <input type="text" placeholder="Su rut sin puntos y sin dígito verificador" name="rut" id="rut" onkeyup="checkRutValidity(this)">
                            <span id="rut-error" class="input-error-message" style="display: none; color: red;">RUT incorrecto</span>
                            <input type="password" placeholder="Contraseña" name="contrasena">
                            <!-- Botón para entrar como usuario regular -->
                            <button type="submit" formaction="valida_login.php">Entrar</button>
                            <!-- Botón para entrar como administrador -->
                            <button type="submit" formaction="valida_admin.php">Entrar como admin</button>
                        </form>

                    </form>
                </div>
            </div>

        </main>

        <script src="assets/js/script.js"></script>
</body>
</html>