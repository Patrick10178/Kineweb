
function confirmacion2(e) {
    if (confirm("¿esta seguro de cancelar este registro?")) {
        return true;
    }else{
        e.preventDefault();
    }
    
}

let linkCancel= document.querySelectorAll(".cancelarbtn");

for (var i = 0; i<linkCancel.length; i++){
    linkCancel[i].addEventListener('click', confirmacion2)
}

function confirmacion(e) {
    if (confirm("¿esta seguro de eliminar este registro?")) {
        return true;
    }else{
        e.preventDefault();
    }
    
}

let linkDelete= document.querySelectorAll(".eliminarbtn");

for (var i = 0; i<linkDelete.length; i++){
    linkDelete[i].addEventListener('click', confirmacion)
}



