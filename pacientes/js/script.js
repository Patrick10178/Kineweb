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



//Ejecutar función en el evento click
document.getElementById("btn_open").addEventListener("click", open_close_menu);



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



//Declarando variables
var formulario_login = document.querySelector(".formulario__login");
var formulario_register = document.querySelector(".formulario__register");
var contenedor_login_register = document.querySelector(".contenedor__login-register");
var caja_trasera_login = document.querySelector(".caja__trasera-login");
var caja_trasera_register = document.querySelector(".caja__trasera-register");

document.getElementById('closeBtn').addEventListener('click', function() {
    location.reload();
});

document.getElementById('fecha').addEventListener('change', function() {
    console.log('Fecha cambiada');
    var fechaSeleccionada = this.value;
    var horarioSelect = document.getElementById('horario');

    // Hacer una solicitud AJAX para obtener horas ocupadas y todas las horas
    fetch('obtener_horas_ocupadas.php?fecha=' + fechaSeleccionada)
    .then(response => {
        console.log(response);
        return response.json();
    })
    .then(data => {
        // Reiniciar el selector de horas
        horarioSelect.innerHTML = '<option value="0" class=opcion>Seleccionar horario</option>';

        data.todas_las_horas.forEach(hora => {
            var option = document.createElement('option');
            option.value = hora.id_horario;
            option.textContent = hora.nombre_horario;

            // Si la hora está ocupada, deshabilitar la opción
            if (data.horas_ocupadas.includes(hora.id_horario.toString())) {
                option.disabled = true;
            }

            horarioSelect.appendChild(option);
        });
    });
});

document.getElementById('horario').addEventListener('change', function() {
    var fechaSeleccionada = document.getElementById('fecha').value;
    var horarioSeleccionado = this.value;
    var kineSelect = document.getElementById('kine_id');

    // Hacer una solicitud AJAX para obtener kinesiólogos ocupados y todos los kinesiólogos
    fetch('obtener_horas_ocupadas.php?fecha=' + fechaSeleccionada + '&horario_id=' + horarioSeleccionado)
    .then(response => response.json())
    .then(data => {
        // Reiniciar el selector de kinesiólogos
        kineSelect.innerHTML = '<option value="0">Seleccionar kinesiólogo</option>';

        data.todos_los_kinesiologos.forEach(kine => {
            var option = document.createElement('option');
            option.value = kine.id;
            option.textContent = kine.nombre + " " + kine.apellidoP + " " + kine.apellidoM;

            // Si el kinesiólogo está ocupado, deshabilitar la opción
            if (data.kinesiologos_ocupados.includes(kine.id.toString())) {
                option.disabled = true;
            }

            kineSelect.appendChild(option);
        });
    });
});


function activarFecha() {
    document.getElementById("selects-fecha").style.display = "block";
    document.getElementById("fecha-placeholder").style.display = "none";
}

function abrirModificarCita(datosCita) {
    // Cargar los datos en los campos del formulario
    var rutCompleto = datosCita.paciente_id ? (datosCita.paciente_id.toString() + '-' + calcularDV(datosCita.paciente_id.toString())) : '';
    document.getElementById('cita').value = datosCita.id_cita;
    document.getElementById('rutSearch').value = rutCompleto;
    document.getElementById('fecha').value = datosCita.fecha;   
    document.getElementById('terapia').value = datosCita.terapia; 
    // Llamar a cargarHoras y luego cargarKinesiologos de forma secuencial
    cargarHoras(datosCita.fecha, datosCita.id_horario, function() {
        cargarKinesiologos(datosCita.fecha, datosCita.id_horario, datosCita.kine_id);
    });

    // Abrir el formulario
    document.getElementById('btn__registrarse').click();
}
function cargarHoras(fecha, idHorario, callback) {
    var horarioSelect = document.getElementById('horario');

    fetch('obtener_horas_ocupadas.php?fecha=' + fecha)
    .then(response => response.json())
    .then(data => {
        horarioSelect.innerHTML = '<option value="0" class=opcion>Seleccionar horario</option>';

        data.todas_las_horas.forEach(hora => {
            var option = document.createElement('option');
            option.value = hora.id_horario;
            option.textContent = hora.nombre_horario;
            if (data.horas_ocupadas.includes(hora.id_horario.toString())) {
                option.disabled = true;
            }
            horarioSelect.appendChild(option);
        });

        seleccionarEnLista('horario', idHorario);
        callback(); // Llama al callback después de cargar y seleccionar la hora
    });
}

function cargarKinesiologos(fecha, idHorario, idKine) {
    var kineSelect = document.getElementById('kine_id');

    fetch('obtener_horas_ocupadas.php?fecha=' + fecha + '&horario_id=' + idHorario)
    .then(response => response.json())
    .then(data => {
        kineSelect.innerHTML = '<option value="0">Seleccionar kinesiólogo</option>';

        data.todos_los_kinesiologos.forEach(kine => {
            var option = document.createElement('option');
            option.value = kine.id;
            option.textContent = kine.nombre + " " + kine.apellidoP + " " + kine.apellidoM;
            if (data.kinesiologos_ocupados.includes(kine.id.toString())) {
                option.disabled = true;
            }
            kineSelect.appendChild(option);
        });

        seleccionarEnLista('kine_id', idKine);
    });
}

function seleccionarEnLista(idLista, valor) {
    let lista = document.getElementById(idLista);
    for (let i = 0; i < lista.options.length; i++) {
        if (lista.options[i].value == valor) {
            lista.selectedIndex = i;
            break;
        }
    }
}
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
        }else{
            formulario_register.style.display = "block";
            contenedor_login_register.style.left = "0px";
            formulario_login.style.display = "none";
            caja_trasera_register.style.display = "none";
            caja_trasera_login.style.display = "block";
            caja_trasera_login.style.opacity = "1";
        }
}






       