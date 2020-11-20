<?php
include 'functions.php';

if (isset($_SESSION['nombre'])) {

    $rangoJedi = $_SESSION['rango'];

    if ($rangoJedi === 'M') {
        header('location: maestro.php');
    } else if ($rangoJedi === 'P') {
        header('location: padawan.php');
    }
} else {

    if (isset($_POST['btnlogin'])) {

        if (isset($_POST['user']) && isset($_POST['pass'])) {

            $arraySanitize = array(
                'user' => FILTER_SANITIZE_STRING,
                'pass' => FILTER_SANITIZE_STRING
            );

            $formInput = filter_input_array(INPUT_POST, $arraySanitize);

            $nombre = $formInput['user'];
            $pass = $formInput['pass'];


            $sql = "SELECT id, nombre, contrasenya, rango FROM jedis WHERE nombre LIKE '" . $nombre . "';";

            $con = dbConnection();

            $result = mysqli_query($con, $sql);

            if (mysqli_num_rows($result) == 1) {

                $usuario = mysqli_fetch_array($result);
                echo $usuario['nombre'];
                if (password_verify($pass, $usuario['contrasenya'])) {

                    session_start();
                    $_SESSION['nombre'] = $usuario['nombre'];
                    $_SESSION['rango'] = $usuario['rango'];
                   
                    if ($_SESSION['rango'] === 'M') {
                        header('location: maestro.php');
                    } else if ($_SESSION['rango'] === 'P') {
                        header('location: padawan.php');
                    }
                } else {
                    echo "Contraseña incorrecta";
                }
            } else {
                echo "No existe el usuario";
            }
        } else {
            echo "Rellene los campos";
        }
    }
}
?>


<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Login</title>
    </head>
    <body>
        <form action="#" method="post">
            <span>Usuario</span><br>
            <input type="text" name="user" value=""><br>
            <span>Contraseña</span><br>
            <input type="password" name="pass"><br>

            <input type="submit" value="Login" name="btnlogin">
        </form>
    </body>
</html>
