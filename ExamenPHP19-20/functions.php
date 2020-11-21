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


function jedisDisponibles($fechaInicio, $misiones){
    
    $jedisDisponibles = array();
    
    foreach ($misiones as $mision){
        
        if($mision['fecha_fin'] < $fechaInicio){
            $jedisDisponibles[] = $mision['jedi_asociado'];
        }
        
    }
    
    return $jedisDisponibles;
}

function asignarPadawan($jedi, $misionID){
    
    $res = false;
    
    $sql = "UPDATE misiones SET jedi_asociado='$jedi' WHERE id='" . $misionID . "'";
    
    $con = dbConnection();
    
    $query = mysqli_query($con, $sql);
    
    if(!$query){
        echo "Error update";
    }else{
        $res = true;
    }
    
    return $res;
    
}

function nuevaMision($titulo, $descripcion, $fecha_inicio, $ficha_mision, $jedi){
    
    $sql = "INSERT INTO misiones (id, titulo, descripcion, fecha_inicio, fecha_fin, ficha_mision, jedi_asociado)"
            . " VALUES (NULL, ,'" . $titulo . "', '" . $descripcion . "', '" . $fecha_inicio . "', '', '" . $jedi . "')";
    
    $con = dbConnection();
    
    $query = mysqli_query($con, $sql);
    
    return $query;
    
    
}