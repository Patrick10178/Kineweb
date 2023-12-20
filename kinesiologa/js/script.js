// Función para calcular dígito verificador
function calcularDV(rut) {
    let suma = 0;
    let multiplicador = 2;

    for(let i = rut.length - 1; i >= 0; i--) {
        suma += rut.charAt(i) * multiplicador;
        multiplicador++;
        if(multiplicador > 7) multiplicador = 2;
    }

    let modulo = suma % 11;
    let dv = 11 - modulo;

    if (dv === 10) return 'K';
    if (dv === 11) return '0';
    return dv.toString();
}
const inputSearch = document.getElementById('inputSearch');
const resultsList = document.getElementById('results-list');

inputSearch.addEventListener('keyup', function() {
    // Obtenemos el valor del input
    let query = inputSearch.value.trim();
    
    if(query.length > 1) { // Para evitar búsquedas con pocos caracteres
        fetch('buscar_paciente.php?q=' + query)
        .then(response => response.json())
        .then(data => {
            // Limpiamos los resultados anteriores
            resultsList.innerHTML = '';
            
            // Mostramos la lista desplegable
            resultsList.style.display = 'block';
            
            // Iteramos sobre cada paciente y creamos un elemento div para mostrarlo
            data.forEach(paciente => {
                let pacienteDiv = document.createElement('div');
                pacienteDiv.textContent = paciente.nombre + " " + paciente.apellidoP + " " + paciente.apellidoM + " (" + paciente.rut + "-" + calcularDV(paciente.rut) + ")";
                resultsList.appendChild(pacienteDiv);
                
                // Evento al hacer clic en un 
                pacienteDiv.addEventListener('click', function() {
                    inputSearch.value = paciente.nombre + " " + paciente.apellidoP + " " + paciente.apellidoM;
                    resultsList.style.display = 'none'; // Ocultamos la lista desplegable

                    // Redireccionamos al perfil del paciente
                    window.location.href = 'perfil_paciente.php?id=' + paciente.rut;
                });
            });
        })
        .catch(error => {
            console.error("Error buscando pacientes:", error);
        });
    } else {
        resultsList.style.display = 'none'; // Ocultamos la lista desplegable si el input tiene pocos caracteres
    }
});

//Ejecutar función en el evento click
document.getElementById("btn_open").addEventListener("click", open_close_menu);
document.getElementById("btn_open2").addEventListener("click", open_close_menu);
document.getElementById("icon-search").addEventListener("click", open_close_menu);


//Declaramos variables
var side_menu = document.getElementById("menu_side");
var btn_open = document.getElementById("btn_open");
var body = document.getElementById("body");


//Evento para mostrar y ocultar menú
    function open_close_menu(){
        body.classList.toggle("body_move");
        side_menu.classList.toggle("menu__side_move");
    }


//Si el ancho de la página es menor a 760px, ocultará el menú al recargar la página

if (window.innerWidth < 760){

    body.classList.add("body_move");
    side_menu.classList.add("menu__side_move");
}

//Haciendo el menú responsive(adaptable)

window.addEventListener("resize", function(){

    if (window.innerWidth > 760){

        body.classList.remove("body_move");
        side_menu.classList.remove("menu__side_move");
    }

    if (window.innerWidth < 760){

        body.classList.add("body_move");
        side_menu.classList.add("menu__side_move");
    }

});

var soundPlayed = false; 

function loadNotifications() {
    console.log('cargando notifications...'); // Mensaje de depuración
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "notificacion.php", true);

    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            console.log('Response from notificacion.php: ', xhr.responseText); 
            var hasUnreadMessages = xhr.responseText.trim() === 'true'; 
            var notificationDot = document.getElementById('notification-dot');

            if (hasUnreadMessages) {
                console.log('mostrando notificacion...'); 
                // Verificar si el sonido ya se ha reproducido
                if (!localStorage.getItem('soundPlayed')) {
                    var notificationSound = document.getElementById('notification-sound');
                    notificationSound.play();
                    localStorage.setItem('soundPlayed', 'true'); // Marcar sonido como reproducido
                }
                notificationDot.style.display = 'inline-block';
            } else {
                console.log('escondiendo notificaion...'); 
                notificationDot.style.display = 'none';
                localStorage.removeItem('soundPlayed'); // Restablecer cuando no hay mensajes no leídos
            }
        }
    };

    xhr.send();
}

setInterval(loadNotifications, 1000);



//Ejecutando funciones
document.getElementById("btn__registrarse").addEventListener("click", register);
window.addEventListener("resize", anchoPage);
document.getElementById('closeBtn').addEventListener('click', function() {
    location.reload();
});




//Declarando variables
var formulario_login = document.querySelector(".formulario__login");
var formulario_register = document.querySelector(".formulario__register");
var contenedor_login_register = document.querySelector(".contenedor__login-register");
var caja_trasera_login = document.querySelector(".caja__trasera-login");
var caja_trasera_register = document.querySelector(".caja__trasera-register");

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

    function register(){
        

        if (window.innerWidth > 850){
            formulario_register.style.display = "block";
            contenedor_login_register.style.left = "40%";
            formulario_login.style.display = "none";
            caja_trasera_register.style.opacity = "0";
            caja_trasera_login.style.opacity = "1";
            console.log('Function register called');
        }else{
            formulario_register.style.display = "block";
            contenedor_login_register.style.left = "0px";
            formulario_login.style.display = "none";
            caja_trasera_register.style.display = "none";
            caja_trasera_login.style.display = "block";
            caja_trasera_login.style.opacity = "1";
        }
}






       