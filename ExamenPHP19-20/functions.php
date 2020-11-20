<?php

//this function handles the connection to the DB
function dbConnection() {
    //Connect to database
    $con = mysqli_connect("localhost", "root", "");

//check connection
    if (!$con) {
        die("ERROR: Can't connect to host");
    }
    $db = mysqli_select_db($con, "guerrasclon");

    if (!$db) {
        die("ERROR: Can't connect to DB ");
    }
    mysqli_set_charset($con, "utf-8");
    return $con;
}

function desconectar($con) {
    $con->close();
    //mysqli_close($con);
}

function logOut($nombre){
    
    setcookie('nombre', $nombre,time()+3600*24*14);
    session_destroy();
    
}

