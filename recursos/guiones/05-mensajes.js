function encuentraElemento(elemento){
    if(document.getElementById && !(document.all)) {
        var element = document.getElementById(elemento);
    } else if(document.all) {
        var element = document.all[elemento];
    }
    return element;
}

function cambiarAyuda(cadenadetexto) {
    var element = encuentraElemento("ayuda");
    element.innerHTML = "<center><b><p class='concejo'>" + cadenadetexto + "</p></b></center>";
}

function ponerError(cadenadetexto) {
    var mensaje = "<img src='recursos/imagenes/error.png' alt='Error ' width='48px' align='left' />" + cadenadetexto
    $.prompt( mensaje , { buttons: { Aceptar: true }, opacity: 0.5 } );
}

function ponerAviso(cadenadetexto) {
    /* var element = encuentraElemento("ayuda"); */
    /* element.innerHTML = "<center><b><p class='aviso'><img src='img/hormiga-aviso.png' width='24px' align='left' />" + cadenadetexto + "</p></b></center>"; */
    var mensaje = "<img src='recursos/imagenes/aviso.png' width='48px' align='left' />" + cadenadetexto
    $.prompt( mensaje , { buttons: { Aceptar: true }, opacity: 0.2 } );
}

function quitarAyuda() {
    var element = encuentraElemento("ayuda");
    element.innerHTML = "&nbsp;";
}

function mensaje(mensaje) {
    alert(mensaje);
}