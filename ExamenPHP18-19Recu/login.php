<?php

    include 'functions.php';

    if(isset($_POST['btnRegistro'])){
        header('location: registro_usuario.php');
    }else if(isset($_POST['btnLogin'])){
        
        $arraySanitize = array(
            'usuario' => FILTER_SANITIZE_STRING,
            'password' => FILTER_SANITIZE_STRING 
        );
        
        $formInput = filter_input_array(INPUT_POST, $arraySanitize);
        
        $nombre = $formInput['usuario'];
        $pass = $formInput['password'];
        
        $sql = "SELECT nombre, clave FROM usuarios WHERE nombre LIKE '" . $nombre . "';";
        
        $con = dbConnection();
        
        $query = mysqli_query($con, $sql);
        
        if(mysqli_num_rows($query) == 1){
            
            $aux = mysqli_fetch_array($query);
            
            if(password_verify($pass, $aux['clave'])){
                
                session_start();
                $_SESSION['nombre'] = $aux['nombre'];
                $_SESSION['id'] = $aux['id'];
                
                header('location: listado_contactos.html');
                
            }else{
                echo 'La contraseña no es correcta';
            }
            
        }else{
            echo 'error consulta login';
        }
        
        desconectar($con);
        
    }

?>


<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>PA - Examen PHP (Junio, 2019)</title>
    </head>
    <body>
        <h1>Agenda</h1>
        <h2>Autenticaci&oacute;n</h2>
        <form action="#" method="POST">
            Usuario: <input type="text" name="usuario" value="pepe" /> <br>
            Password: <input type="password" name="password" /> <br><br>

            <input type="submit" name="btnLogin" value="Entrar"/><br>                                
        </form>
        <form action="registro_usuario.php" method="POST">
            <input type="submit" name="btnRegistro" value="Registro"/>                                
        </form>
    </body>
</html>
    