
var turnoJugador = 1;
var tablero = [0, 0, 0, 0, 0, 0, 0, 0, 0];

function marcarCelda(idCelda) {

    if (tablero[idCelda] === 1) {
        document.querySelector('#c' + idCelda).style = "background-color: red";
    } else if (tablero[idCelda] === 2) {
        document.querySelector('#c' + idCelda).style = "background-color: blue";
    } else {
        document.querySelector('#c' + idCelda).style = "background-color: white";
    }

}

function jugarDeNuevo() {

    var res = confirm("Jugar de nuevo?");

    if (res) {
        for (var i = 0; i < tablero.length; i++) {
            tablero[i] = 0;
            marcarCelda(i);
        }
    }

}

function comprobarGanador() {

    var ganador;

    if (tablero[0] === tablero[1] && tablero[2] === tablero[0]) {
        if (tablero[0] === 1) {
            ganador = 1;
        } else if (tablero[0] === 2) {
            ganador = 2;
        } else {
            ganador = 3;
        }
    } else if (tablero[0] === tablero[4] && tablero[0] === tablero[8]) {
        if (tablero[0] === 1) {
            ganador = 1;
        } else if (tablero[0] === 2) {
            ganador = 2;
        } else {
            ganador = 3;
        }
    } else if (tablero[0] === tablero[3] && tablero[0] === tablero[6]) {
        if (tablero[0] === 1) {
            ganador = 1;
        } else if (tablero[0] === 2) {
            ganador = 2;
        } else {
            ganador = 3;
        }
    } else if (tablero[3] === tablero[4] && tablero[3] === tablero[5]) {
        if (tablero[3] === 1) {
            ganador = 1;
        } else if (tablero[3] === 2) {
            ganador = 2;
        } else {
            ganador = 3;
        }
    } else if (tablero[6] === tablero[7] && tablero[6] === tablero[8]) {
        if (tablero[6] === 1) {
            ganador = 1;
        } else if (tablero[6] === 2) {
            ganador = 2;
        } else {
            ganador = 3;
        }
    } else if (tablero[1] === tablero[4] && tablero[1] === tablero[7]) {
        if (tablero[6] === 1) {
            ganador = 1;
        } else if (tablero[6] === 2) {
            ganador = 2;
        } else {
            ganador = 3;
        }
    } else if (tablero[2] === tablero[5] && tablero[2] === tablero[8]) {
        if (tablero[2] === 1) {
            ganador = 1;
        } else if (tablero[2] === 2) {
            ganador = 2;
        } else {
            ganador = 3;
        }
    } else if (tablero[2] === tablero[4] && tablero[2] === tablero[6]) {
        if (tablero[2] === 1) {
            ganador = 1;
        } else if (tablero[2] === 2) {
            ganador = 2;
        } else {
            ganador = 3;
        }
    } else {
        ganador = 3;
    }

    if (ganador === 3) {

        for (var i = 0; i < tablero.length; i++) {
            if (tablero[i] === 0) {
                ganador = 0;
            }
        }

    }

    return ganador;
}

function actualizarPuntuacion(ganador) {

    if (ganador === 1) {
        document.querySelector('#ganadosJ1').value += 1;
        alert("Ha ganado el jugador " + ganador);
    } else if (ganador === 2) {
        document.querySelector('#ganadosJ2').value += 1;
        alert("Ha ganado el jugador " + ganador);
    } else if (ganador === 3) {
        document.querySelector('#empates').value += 1;
        alert("Empate");
    }

}

function seleccionarCelda(idCelda) {

    if (tablero[idCelda] !== 0) {
        alert("Celda ya ocupada");
    } else if (tablero[idCelda] === 0) {
        tablero[idCelda] = turnoJugador;
        marcarCelda(idCelda);
        if (turnoJugador === 1) {
            turnoJugador = 2;
        } else {
            turnoJugador = 1;
        }
        document.querySelector("#jugadorActivo").value = turnoJugador;
    }

    var ganador = comprobarGanador();
    if (ganador !== 0) {
        actualizarPuntuacion(ganador);
        jugarDeNuevo();
    }
}
