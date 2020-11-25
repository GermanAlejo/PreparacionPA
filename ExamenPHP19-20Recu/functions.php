<?php

function dbConnection(){
    
    $con = mysqli_connect("localhost", "root", "");
    
    if(!$con){
        die("Can't connet to host");
        echo "host";
    }
    
    $db = mysqli_select_db($con, "covid19");
    
    if(!$db){
        die("Can't connet to db");
        echo "DB";
    }
    
    mysqli_set_charset($con, "utf-8");
    
    return $con;
    
}

function desconectar($con){
    mysqli_close($con);
}

