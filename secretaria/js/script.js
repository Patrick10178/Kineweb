

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
                // rellenar campo con datos
                /*pacienteDiv.addEventListener('click', function() {
                    inputSearch.value = paciente.nombre + " " + paciente.apellidoP + " " + paciente.apellidoM;
                    resultsList.style.display = 'none'; // Ocultamos la lista desplegable
                });*/

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


//Ejecutando funciones
document.getElementById("btn__registrarse").addEventListener("click", register);
window.addEventListener("resize", anchoPage);
document.getElementById('closeBtn').addEventListener('click', function() {
    location.reload();
})

//Declarando variables
var formulario_login = document.querySelector(".formulario__login");
var formulario_register = document.querySelector(".formulario__register");
var formulario_register1 = document.querySelector(".formulario__register1");
var contenedor_login_register = document.querySelector(".contenedor__login-register");
var contenedor_login_register1 = document.querySelector(".contenedor__login-register1");
var caja_trasera_login = document.querySelector(".caja__trasera-login");
var caja_trasera_register = document.querySelector(".caja__trasera-register");
var caja_trasera_register1 = document.querySelector(".caja__trasera-register1");


const rutSearch = document.getElementById('rutSearch');
const rutResultsList = document.getElementById('rutResults-list');

rutSearch.addEventListener('keyup', function() {
    let query = rutSearch.value.trim();
    

    if (query.length > 1) {
        fetch('buscar_paciente.php?q=' + query)
        .then(response => response.json())
        .then(data => {
            rutResultsList.innerHTML = '';           
            rutResultsList.style.display = 'block';

            data.forEach(paciente => {
                let li = document.createElement('li');
                li.textContent = paciente.nombre + " " + paciente.apellidoP + " " + paciente.apellidoM + " (" + paciente.rut + "-" + calcularDV(paciente.rut) + ")";
                rutResultsList.appendChild(li);

                li.addEventListener('click', function() {
                    rutSearch.value = paciente.rut + "-" + calcularDV(paciente.rut);
                    rutResultsList.style.display = 'none';
                });
            });
        checkRutValidity(this);})
        .catch(error => {
            console.error("Error buscando pacientes:", error);
        });
    } else {
        rutResultsList.style.display = 'none';
    }
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
document.addEventListener('DOMContentLoaded', function() {
    var inputFecha = document.getElementById('fecha');

    inputFecha.addEventListener('input', function() {
        var fechaSeleccionada = new Date(this.value + 'T00:00:00'); // Asegura que la fecha se interpreta en el huso horario local
        var dia = fechaSeleccionada.getDay();
        if (dia === 0 || dia === 6) { // 0 = Domingo, 6 = Sábado
            this.value = '';
            alert('Los sábados y domingos no están disponibles. Por favor, elija otro día.');
        }
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

document.getElementById("btn__registrarse1").addEventListener("click", register1);
window.addEventListener("resize", anchoPage);
document.getElementById('closeBtn1').addEventListener('click', function() {
    location.reload();
})
function activarFecha() {
    document.getElementById("selects-fecha").style.display = "block";
    document.getElementById("fecha-placeholder").style.display = "none";
}

// Vincula la función al evento keyup del campo de RUT
document.getElementById('rut').addEventListener('keyup', function() {
    checkRutValidity(this);
});

function abrirModificarPaciente(datosPaciente) {
    // Aquí asumimos que 'datosPaciente' tiene propiedades como 'rut', 'nombre', 'apellidoP', etc.
    var rutCompleto = datosPaciente.id ? (datosPaciente.id.toString() + '-' + calcularDV(datosPaciente.id.toString())) : '';
    document.querySelector("[name='rut']").value = rutCompleto;
    document.querySelector("[name='nombre']").value = datosPaciente.nombre || '';
    document.querySelector("[name='apellidop']").value = datosPaciente.apellidoP || '';
    document.querySelector("[name='apellidom']").value = datosPaciente.apellidoM || '';
    document.querySelector("[name='correo']").value = datosPaciente.correo || '';
    document.querySelector("[name='telefono']").value = datosPaciente.telefono || '';
    
    // Suponiendo que el sexo es 'm' o 'f' y tienes dos botones de radio
    if (datosPaciente.sex === 'm') {
        document.querySelector("#masculino").checked = true;
    } else if (datosPaciente.sex === 'f') {
        document.querySelector("#femenino").checked = true;
    }

    // Configurar la fecha de nacimiento, si tienes campos separados para día, mes y año
    // Asegúrate de que la fecha esté en un formato que puedas dividir (ejemplo: 'YYYY-MM-DD')
    // Manejar la fecha de nacimiento
    if (datosPaciente.nace) {
        var fechaNacimiento = new Date(datosPaciente.nace);
        document.querySelector("[name='dia_nace']").value = fechaNacimiento.getDate();
        document.querySelector("[name='mes_nace']").value = fechaNacimiento.getMonth() + 1; // Los meses en JavaScript empiezan en 0
        document.querySelector("[name='ano_nace']").value = fechaNacimiento.getFullYear();

         // Hacer visibles los campos de fecha
        document.getElementById("selects-fecha").style.display = "block";
        document.getElementById("fecha-placeholder").style.display = "none";
    }

    // Abre el formulario de modificación
    document.getElementById('btn__registrarse').click();
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
    // ... más campos según sea necesario

    // Abrir el formulario (asumiendo que usas el mismo botón que para "Nueva Cita")
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



function register1(){
    if (window.innerWidth > 850){
        formulario_register1.style.display = "block";
        contenedor_login_register1.style.left = "410px";
        formulario_login1.style.display = "none";
        caja_trasera_register1.style.opacity = "0";
        caja_trasera_login1.style.opacity = "1";
    }else{
        formulario_register1.style.display = "block";
        contenedor_login_register1.style.left = "0px";
        formulario_login1.style.display = "none";
        caja_trasera_register1.style.display = "none";
        caja_trasera_login1.style.display = "block";
        caja_trasera_login1.style.opacity = "1";
    }
}

