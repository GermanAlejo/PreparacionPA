<?php

if (isset($_POST['btnRegistrar'])) {

    if (isset($_POST['usuario']) && isset($_POST['password']) && isset($_POST['email'])) {

        $arraySanitize = array(
            'usuario' => FILTER_SANITIZE_STRING,
            'password' => FILTER_SANITIZE_STRING,
            'email' => FILTER_SANITIZE_EMAIL
        );

        $formInput = filter_input_array(INPUT_POST, $arraySanitize);

        $nombre = $formInput['usuario'];
        $pass = $formInput['password'];
        $email = $formInput['email'];
        $perfil = $_POST['perfil'];

        //Connect to database
        $con = mysqli_connect("localhost", "root", "");

//check connection
        if (!$con) {
            die("ERROR: Can't connect to host");
        }
        $db = mysqli_select_db($con, "gestortareas");

        if (!$db) {
            die("ERROR: Can't connect to DB ");
        }

        mysqli_set_charset($con, "utf-8");
        
        $sqlExiste = "SELECT COUNT(*) FROM usuario WHERE usuario.nombre='" . $nombre . "';";
        
        $query1 = mysqli_query($con, $sqlExiste);
        
        if(mysqli_num_rows($query1) > 0){
            echo 'Usuario ya registrado';
            mysqli_close($con);
        }else{
            
            $hashedPass = password_hash($pass, PASSWORD_DEFAULT);
            
            $sqlInsert = "INSERT INTO usuarios (id, nombre, clave, email, perfil, tipo)"
                    . " VALUES (NULL, '" . $nombre . "', '" . $hashedPass . "',"
                    . "'" . $email . "', '" . $perfil . "', 'desarrollador')";
            
            $res = mysqli_query($con, $sqlInsert);
            if(!$res){
                echo 'error al insertar';
                mysqli_close($con);
            }else{
                
                $_SESSION['user'] = $nombre;
                $_SESSION['perfil'] = $perfil;
                
                mysqli_close($con);
                header('location: login.html');
                
            }
            
        }
        
    }else{
        echo 'campo no lleno';
    }
} else {
    header('location: login.html');
}
