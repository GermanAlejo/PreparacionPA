
$(function(){
    $('#prueba').click(function() {
        alert("Hello");
    });
});

function marcaError(elemento, mensaje){
    
    var elemType = $(elemento).is("span");
    var clase = $(elemento).attr("class");
    
    if(!elemType && clase !== "error"){
        $(elemento).css({'border': '2px, solid, red'});
        var newSpan = document.createElement("span");
        $(newSpan).addClass("error");
        $(newSpan).text(mensaje);
        $(elemento).append(newSpan);
    }
    
}

function enfocado(elemento){
    
    $(elemento).css({'border': 'solid, 2px, green'});
    
    var spanHijo = $(elemento).next();
    
    if($(spanHijo).is("span")){
        $(spanHijo).remove().fadeOut("slow");
    }
    
}

function comprobarVacio(elemento){
    
    if($(elemento).text() === ""){
        marcaError(elemento, "error");
    }else{
        $(elemento).css('border','none');
    }
    
}

