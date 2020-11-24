var ganador = [2, 12, 19, 35, 44, 45];
var premios = [0, 0, 0, 90, 3000, 150000, 1000000];
var numCombinaciones = 1;

function comprobarDiv(div) {
//console.log("daw");
    if (div.hasChildNodes) {
        var aciertos = 0;
        var inputs = div.getElementsByTagName("input");
        //console.log("daw");
        for (var i = 0; i < inputs.length; i++) {

            if (ganador.indexOf(parseInt(inputs[i].value)) !== -1) {
                console.log(inputs[i].value);
                aciertos++;
            }
        }

        pintaAciertos(div.lastChild, aciertos);

    }
}

function pintaAciertos(span, n) {

    span.textContent = "";
    span.textContent = "Tiene " + n + " aciertos y su premio es de " + premios[n + 1] + "€";

}

function comprobar() {

    var divPadre = document.getElementById("combinaciones");
    //var numComb = divPadre.childElementCount;
    var hijos = divPadre.getElementsByTagName("div");
    console.log(hijos);
    for (var i = 0; i < hijos.length; i++) {

        comprobarDiv(hijos[i]);

    }

}

function validar(valor) {

    if (isNaN(valor.value)) {
        valor.value = "";
    } else {
        if (valor.value > 49) {
            valor.value = valor.value.substring(0, valor.value.length - 1);
        }
    }
}

function agregarCombinacion() {

    numCombinaciones++;
    var divPadre = document.getElementById("combinaciones");
    var newDiv = document.createElement("div");
    newDiv.id = "combinacion" + numCombinaciones;

    for (var i = 0; i < 6; i++) {
        var input = document.createElement("input");
        input.type = "text";
        input.size = "5";
        input.setAttribute("class", "numPrimitiva");
        input.setAttribute("onkeyup", "validar(this)");
        newDiv.appendChild(input);
    }

    var span = document.createElement("span");

    //console.log(divPadre.firstElementChild);
    var eliminar = document.createElement("button");
    eliminar.setAttribute("onclick", "eliminar(this)");
    eliminar.textContent = "Eliminar Combinacion";
    //console.log(newDiv);
    newDiv.appendChild(span);
    newDiv.appendChild(eliminar);
    divPadre.appendChild(newDiv);
}

function eliminar(element) {

    var padre = element.parentNode;
    
    $(padre).fadeOut("slow", function(){
        $(padre).remove();
    });
    
    numCombinaciones--;
}

