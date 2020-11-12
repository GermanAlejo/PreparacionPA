
<?php
include 'functions.php';

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

        $con = dbConnection();

        $sqlExiste = "SELECT COUNT(*) FROM usuario WHERE usuario.nombre='" . $nombre . "';";

        $query1 = mysqli_query($con, $sqlExiste);

        if (mysqli_num_rows($query1) > 0) {
            echo 'Usuario ya registrado';
            mysqli_close($con);
        } else {

            $hashedPass = password_hash($pass, PASSWORD_DEFAULT);

            $sqlInsert = "INSERT INTO usuarios (id, nombre, clave, email)"
                    . " VALUES (NULL, '" . $nombre . "', '" . $hashedPass . "',"
                    . "'" . $email . "')";

            $res = mysqli_query($con, $sqlInsert);

            if (!$res) {
                echo 'error al insertar';
                desconectar($con);
            } else {

                $_SESSION['user'] = $nombre;
                $_SESSION['id'] = $id;
                
                //falta carpeta fotos

                desconectar($con);
                header('location: login.php');
            }
        }
    }
} else {
    header('location: login.php');
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
        <h2>Registro de usuario</h2>
        <form action="#" method="POST">
            Nombre: <input type="text" name="usuario" value="" /> <br>
            Password: <input type="password" name="password" /> <br>
            Email: <input type="text" name="email" /> <br><br>
            <input type="submit" name="btnRegistrar" value="Registrar"/>
            <input type="reset" name="btnCancelar" value="Cancelar"/> <br><br>
        </form>
    </body>
</html> 