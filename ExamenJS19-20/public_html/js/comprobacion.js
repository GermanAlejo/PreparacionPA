
//$(function(){
//    $('#prueba').click(function() {
//        alert("Hello");
//    });
//});
//
//window.onload = function() {
//    if (window.jQuery) {  
//        // jQuery is loaded  
//        alert("Yeah!");
//    } else {
//        // jQuery is not loaded
//        alert("Doesn't Work");
//    }
//}

$(document).ready(function () {

    var inputsFocus = $("input");

    inputsFocus.focusin(enfocado(inputsFocus));
    inputsFocus.focusout(comprobarVacio(inputsFocus));

    var elemInte = document.getElementById('numIntegrantes');

    $(elemInte).bind("focusout", function () {
        //alert("hola");
        var numInte = parseInt($(elemInte).val());
        var padreDiv = document.getElementById('componentes');
        var modalidad = $('input[name=modalidad]:checked', '#registroForm').val();

        //vacia componentes
        $(padreDiv).empty();

        if (modalidad === "cuarteto" && numInte > 5) {
            console.log("cuartetoMal");
            marcaError(elemInte, "Numero de Integrantes no valido");


        } else if ((modalidad === "chirigota" || modalidad === "comparsa") && numInte > 13) {
            console.log("chirigotamal");
            marcaError(elemInte, "Numero de Integrantes no valido");

        } else if (modalidad === "coro" && numInte > 30) {
            console.log("coro mal");
            marcaError(elemInte, "Numero de Integrantes no valido");

        } else {

            for (var i = 0; i < numInte; i++) {
                console.log("todobien");
                var newInput = document.createElement("input");
                $(newInput).attr("type", "text");
                $(newInput).attr("class", "componente");
                var newLabel = document.createElement("label");
                $(newLabel).text("Componente" + (i + 1));
                $(padreDiv).append(newInput);
                $(newInput).before(newLabel);
            }

        }
    });

});

function marcaError(elemento, mensaje) {

    var elemType = $(elemento).is("span");
    //cosole.log("marcaError");
    var clase = $(elemento).attr("class");
    alert($(elemento).name);
    if (!elemType && clase !== "error") {
        $(elemento).css({'border': '2px, solid, red'});
        var newSpan = document.createElement("span");
        $(newSpan).addClass("error");
        $(newSpan).text(mensaje);
        $(elemento).append(newSpan);
    }

}

function enfocado(elemento) {

    $(elemento).css({'border': 'solid, 2px, green'});

    var spanHijo = $(elemento).next();

    if ($(spanHijo).is("span")) {
        $(spanHijo).remove().fadeOut("slow");
    }

}

function comprobarVacio(elemento) {

    if ($(elemento).text() === "") {
        marcaError(elemento, "error");
    } else {
        $(elemento).css('border', 'none');
    }

}

