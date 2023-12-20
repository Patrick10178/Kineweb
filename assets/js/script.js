//Ejecutando funciones
document.getElementById("btn__iniciar-sesion").addEventListener("click", iniciarSesion);
document.getElementById("btn__registrarse").addEventListener("click", register);
window.addEventListener("resize", anchoPage);

//Declarando variables
var formulario_login = document.querySelector(".formulario__login");
var formulario_register = document.querySelector(".formulario__register");
var contenedor_login_register = document.querySelector(".contenedor__login-register");
var caja_trasera_login = document.querySelector(".caja__trasera-login");
var caja_trasera_register = document.querySelector(".caja__trasera-register");


function calculateDV(cuerpo) {
    let suma = 0;
    let multiplo = 2;

    for (let i = cuerpo.length - 1; i >= 0; i--) {
        suma += multiplo * parseInt(cuerpo.charAt(i), 10);
        multiplo = (multiplo < 7) ? multiplo + 1 : 2;
    }

    let dvEsperado = 11 - (suma % 11);
    dvEsperado = dvEsperado === 11 ? '0' : dvEsperado === 10 ? 'K' : String(dvEsperado);
    return dvEsperado;
}

function checkRutValidity(rutField) {
    let inputValue = rutField.value.replace(/[^0-9kK]/g, '');
    let cuerpo = inputValue.replace(/-\w?$/, '');
    let rutError = document.getElementById('rut-error'); // Asegúrate de que este elemento existe en tu HTML

    // Limita el cuerpo a 8 dígitos
    if (cuerpo.length > 8) {
        cuerpo = cuerpo.substring(0, 8);
    }

    let dv = '';
    if (cuerpo.length >= 7 && cuerpo.length <= 8) {
        dv = calculateDV(cuerpo);
        rutField.value = `${cuerpo}-${dv}`;

        // Restablece los estilos y errores
        rutError.style.display = 'none';
        rutField.classList.remove('input-invalid');
    } else {
        // Muestra error si la longitud no es la adecuada
        if (cuerpo.length < 7) {
            rutError.textContent = 'El RUT debe tener al menos 7 dígitos antes del guion';
            rutError.style.display = 'block';
            rutField.classList.add('input-invalid');
        }
        rutField.value = cuerpo; // Mantiene solo los números ingresados sin DV
    }

    // Maneja la posición del cursor
    let cursorPosition = rutField.selectionStart;
    if (cursorPosition > cuerpo.length) {
        cursorPosition = cuerpo.length; // Asegura que el cursor se quede en el cuerpo del RUT
    }
    rutField.setSelectionRange(cursorPosition, cursorPosition);
}

let rutField = document.getElementById('rut');
rutField.addEventListener('input', function() {
    checkRutValidity(this);
});

// Para evitar que el usuario coloque el cursor en la posición del DV
rutField.addEventListener('click', function() {
    let cuerpoLength = this.value.replace(/-\w?$/, '').length;
    if (this.selectionStart > cuerpoLength) {
        this.setSelectionRange(cuerpoLength, cuerpoLength);
    }
});


// Asegúrate de vincular esta función con el evento 'input' o 'keyup' del campo de entrada del RUT.


// Vincula la función al evento keyup del campo de RUT
document.getElementById('rut').addEventListener('keyup', function() {
    checkRutValidity(this);
});


    //FUNCIONES

function anchoPage(){

    if (window.innerWidth > 850){
        caja_trasera_register.style.display = "block";
        caja_trasera_login.style.display = "block";
    }else{
        caja_trasera_register.style.display = "block";
        caja_trasera_register.style.opacity = "1";
        caja_trasera_login.style.display = "none";
        formulario_login.style.display = "block";
        contenedor_login_register.style.left = "0px";
        formulario_register.style.display = "none";   
    }
}

anchoPage();


    function iniciarSesion(){
        if (window.innerWidth > 850){
            formulario_login.style.display = "block";
            contenedor_login_register.style.left = "10px";
            formulario_register.style.display = "none";
            caja_trasera_register.style.opacity = "1";
            caja_trasera_login.style.opacity = "0";
        }else{
            formulario_login.style.display = "block";
            contenedor_login_register.style.left = "0px";
            formulario_register.style.display = "none";
            caja_trasera_register.style.display = "block";
            caja_trasera_login.style.display = "none";
        }
    }

    function register(){
        if (window.innerWidth > 850){
            formulario_register.style.display = "block";
            contenedor_login_register.style.left = "410px";
            formulario_login.style.display = "none";
            caja_trasera_register.style.opacity = "0";
            caja_trasera_login.style.opacity = "1";
        }else{
            formulario_register.style.display = "block";
            contenedor_login_register.style.left = "0px";
            formulario_login.style.display = "none";
            caja_trasera_register.style.display = "none";
            caja_trasera_login.style.display = "block";
            caja_trasera_login.style.opacity = "1";
        }
}