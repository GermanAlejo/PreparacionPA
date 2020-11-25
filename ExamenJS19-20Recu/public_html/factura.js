var numFilas = 1;

function conFoco(elemento) {
    elemento.style.backgroundColor = "lavender";
}

function sinFoco(elemento) {
    elemento.style.backgroundColor = "initial";
}

function compruebaUnidades(elemento) {
    var num = elemento.value;

    if (parseInt(num) >= 0) {
        elemento.style.border = "initial";
        return true;
    } else {
        elemento.style.border = "solid thick red";
        return false;
    }
}

function compruebaDescripcion(elemento) {
    var exReg = "/[^a-z_\-0-9]/i";
    var term = elemento.value;

    if (exReg.test(term)) {
        elemento.style.border = "initial";
        return true;
    } else {
        elemento.style.border = "solid thick red";
        return false;
    }
}

function validarForm() {

    var desc = document.getElementById("descripcion1");
    var unid = document.getElementById("unidades1");

    if (compruebaDescripcion(desc) && compruebaUnidades(unid)) {
        return true;
    } else {
        return false;
    }

}

function filaNueva() {

    numFilas++;
    var tabla = document.getElementById("tabla");
    //var newFila = document.createElement("tr");

    var newFila = tabla.insertRow(1);

    //tabla.appendChild(newFila);

    var newSF = document.createElement("td");
    newFila.appendChild(newSF);
    var sf = document.createElement("input");
    sf.type = "checkbox";
    sf.id = "sf" + numFilas;
    sf.name = "sf" + numFilas;
    sf.checked = false;

    newSF.appendChild(sf);

    var newDesc = document.createElement("td");
    newFila.appendChild(newDesc);
    var desc = document.createElement("input");
    desc.type = "text";
    desc.id = "descripcion" + numFilas;
    desc.name = "descripcion" + numFilas;
    desc.onfocus = "conFoco(this)";
    desc.onblur = "sinFoco(this)";
    desc.onsubmit = "compruebaDescripcion(this)";

    newDesc.appendChild(desc);

    var newPrecio = document.createElement("td");
    newFila.appendChild(newPrecio);
    var precio = document.createElement("input");
    precio.type = "text";
    precio.id = "precioUd" + numFilas;
    precio.name = "precioUd" + numFilas;
    precio.onfocus = "conFoco(this)";
    precio.onblur = "sinFoco(this)";

    newPrecio.appendChild(precio);

    var newUni = document.createElement("td");
    newFila.appendChild(newUni);
    var unidades = document.createElement("input");
    unidades.type = "text";
    unidades.id = "unidades" + numFilas;
    unidades.name = "unidades" + numFilas;
    desc.onfocus = "conFoco(this)";
    desc.onblur = "sinFoco(this)";
    desc.onsubmit = "compruebaUnidades(this)";

    newUni.appendChild(unidades);

    var newIva = document.createElement("td");
    newFila.appendChild(newIva);
    var iva = document.createElement("select");
    iva.id = "tipoIva" + numFilas;
    iva.name = "tipoIva" + numFilas;

    var ivas = ["21", "10", "4"];
    for (var i = 0; i < ivas.length; i++) {
        var option = document.createElement("option");
        option.value = ivas[i];
        option.text = ivas[i];
        iva.appendChild(option);
    }

    newIva.appendChild(iva);

    var newTotal = document.createElement("td");
    newFila.appendChild(newTotal);
    newTotal.textContent = "0";

}

function actualizaTotal(elemento){
    
    var id = elemento.id.substring(elemento.id.length, elemento.id.length-1);
    var sumaE = document.getElementById("totalConIva" + id);
    var suma = 0;
    //console.log(suma);
    var prec = document.getElementById("precioUd" + id).value;
    var unid = document.getElementById("unidades" + id).value;
    var iva = parseFloat(document.getElementById("tipoIva" + id).value)/100;
    console.log(prec);
    console.log(unid);
    prec *= iva;
    suma += prec * unid;
    
    sumaE.textContent = suma;//.toFixed(2);
    sumaTotal();
}

function sumaTotal(){
    
    var suma=0;
    
    for(var i=1;i<=numFilas;i++){
        suma += (document.getElementById("totalConIva" + i).textContent);
    }
    
    //var total = suma.toFixed(2);
    
    document.getElementById("sumaTotalConIva").textContent = suma;
    
}

