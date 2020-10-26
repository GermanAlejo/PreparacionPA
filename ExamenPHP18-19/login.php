<?php



if (isset($_POST['btnLogin'])) {

    $arraySanitize = Array(
        'usuario' => FILTER_SANITIZE_STRING,
        'password' => FILTER_SANITIZE_STRING
    );

    $formInput = filter_input_array(INPUT_POST, $arraySanitize);

    $usuario = $formInput['usuario'];
    $pass = $formInput['password'];

    $sql = "SELECT nombre, clave, tipo FROM usuarios WHERE nombre LIKE'" . $usuario . "';";

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


    $query = mysqli_query($con, $sql);

    if (mysqli_num_rows($query) == 1) {

        $aux = mysqli_fetch_array($query);
        
        if (password_verify($pass, $aux['clave'])) {

            session_start();
            $_SESSION['nombre'] = $aux['nombre'];
            $_SESSION['tipo'] = $aux['tipo'];
            $_SESSION['id'] = $aux['id'];



            print_r($aux);
            echo'loko';

            if ($aux['tipo'] === "jefe") {
                header('location: listado_tareas_jefe.php');
            } else if ($aux['tipo'] === "desarrollador") {
                header('location: listado_tareas_desarrollador.php');
            }
        } else {
            echo "No existe ningun usuario con esos datos";
        }
    }

    mysqli_close($con);
} else if (isset($_POST['btnRegistro'])) {
    header('Location: registro_usuario.php');
}
