
<?php
include 'functions.php';

if (isset($_POST['btnRegistrar'])) {
    
    if (count(array_filter($_POST))!= count($_POST)) {
        echo 'Rellene todos los campos';
    }else{

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
            echo 'Registro fallido';
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

                $_SESSION['nombre'] = $nombre;
                //gets last inserted id
                $_SESSION['id'] =  mysqli_insert_id($con);
                
                //creamos carpeta fotos para el usuario
                $newRuta = "user" . $_SESSION['id'];
                mkdir('fotos/' . $newRuta, 0777, true);
                /*
                 * La funcion mkdir crea automaticamente la carpeta raiz 
                 * si esta no existe
                 */

                desconectar($con);
                header('location: login.php');
            }
        }
    }
    
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