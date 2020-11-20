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
    if (isset($_POST['btnLogin'])) {
        if (isset($_POST['user']) && isset($_POST['pass'])) {

            $arraySanitize = array(
                'usuario' => FILTER_SANITIZE_STRING,
                'pass' => FILTER_SANITIZE_STRING
            );

            $formInput = filter_input_array(INPUT_POST, $arraySanitize);

            $nombre = $formInput['usuario'];
            $pass = $formInput['pass'];

            $slq = "SELECT nombre, rango FROM guerrasclon.jedis WHERE nombre=$nombre";

            $conn = dbConnection();

            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) === 0) {
                echo "No existe el usuario";
            } else {

                $usuario = mysqli_fetch_array($result);

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
            <input type="text" name="user" value="yoda"><br>
            <span>Contraseña</span><br>
            <input type="password" name="pass"><br>

            <input type="submit" value="Login" name="btnlogin">
        </form>
    </body>
</html>
