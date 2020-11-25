<?php
include 'functions.php';

if (isset($_SESSION['username']) && isset($_COOKIE['usuario'])) {
    setcookie("usuario", $_COOKIE['username'], time() + 3600 * 24 * 15);
    session_start();
    //$_SESSION['username'] = $_COOKIE['usuario'];
    header("location: gestionsCitas.php");
} else {

    if ($_POST['acceder']) {

        if ((count(array_filter($_POST))=== count($_POST))) {

            $arraySanitize = array(
                'usuario' => FILTER_SANITIZE_STRING,
                'pass' => FILTER_SANITIZE_STRING
            );

            $filterInput = filter_input_array(INPUT_POST, $arraySanitize);

            $user = $filterInput['usuario'];
            $pass = $filterInput['pass'];
            
            $pattern = '~[0-9]~';
            if(preg_match($pattern, $pass) === 1){
                echo "todobien";
            }

            $sql = "SELECT username, password, id_hospital FROM usuario WHERE username LIKE '" . $user . "' LIMIT 1";

            $con = dbConnection();

            $query = mysqli_query($con, $sql);

            if (!$query) {
                echo "Error sql";
            } else {

                $usuario = mysqli_fetch_array($query);

                if ($usuario['password'] === $pass) {
                    session_start();
                    $_SESSION['username'] = $usuario['username'];
                    $_SESSION['id_hospital'] = $usuario['id_hospital'];
                    setcookie("usuario", $usuario['username'], time() + 3600 * 24 * 15);
                    desconectar($con);
                    header('location: gestionCitas.php');
                } else {
                    echo "Datos incorrectos";
                }
            }
        } else {
            echo "Los campos no pueden estar vacios";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Login</title>
    </head>
    <body>
        <h1>Login</h1>
        <form action="#" method="post">
            Usuario:<br/>
            <input type="text" name="usuario" value="<?php echo $_SESSION['username']; ?>"/><br/>
            Contraseña:<br/>
            <input type="password" name="pass" value=""/><br/>
            <input type="submit" value="Acceder" name="acceder" />
        </form>
    </body>
</html>