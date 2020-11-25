<?php
include 'functions.php';

session_start();

if (isset($_SESSION['username'])) {

    $idHospital = $_SESSION['id_hospital'];

    if (isset($_POST['registrar'])) {
        if (count(array_filter($_POST)) === count($_POST)) {

            $todoOK = true;

            $nombre = filter_var(trim($_POST['nombre']), FILTER_SANITIZE_MAGIC_QUOTES);
            $pattern = '/[[:alpha:]]*/';
            if ($nombre === "" || preg_match($pattern, $nombre) !== 1) {
                echo "El nombre debe ser valido";
                $todoOK = false;
            }

            $pattern = "/^[[:digit:]] {8} [[:upper:]]$/";
            $dni = filter_var(trim($_POST['dni']), FILTER_SANITIZE_MAGIC_QUOTES);
            if ($dni === "" || preg_match($pattern, $dni) === 1) {
                echo "El dni debe ser valido";
                $todoOK = false;
            }


            $localidad = filter_var(trim($_POST['localidad'], FILTER_SANITIZE_STRING));
            if ($localidad === "" || strlen($localidad) < 5 || preg_match($pattern, $subject) || !ctype_upper($localidad[0])) {
                echo "La localidad debe ser valida";
                $todoOK = false;
            }

            $pattern = "^([0-2][0-9]|(3)[0-1])(\-)(((0)[0-9])|((1)[0-2]))(\-)\d{4}$^";
            $fecha = $_POST['fechaPrueba'];
            if (preg_match($pattern, $fecha)) {
                $fecha = date('Y-m-d', strtotime($fecha));
            } else {
                echo "Fecha no valida";
                $todoOK = false;
            }

            $resultado = filter_var(trim($_POST['resultado']), FILTER_SANITIZE_STRING);
            if ($resultado === "" || ($resultado !== "0" || $resultado != "1")) {
                echo "Resultado no valido";
                $todoOK = false;
            } else {
                $resultado = (int) $resultado;
            }

            if ($todoOK) {

                $sql = "INSERT INTO prueba (id_prueba, nombre_paciente, dni_paciente, "
                        . "localidad_paciente, fecha_prueba, resultado_prueba, hospital_asociado)"
                        . " VALUES (NULL, $nombre, $dni, $localidad, $fecha, $resultado, $idHospital)";

                $con = dbConnection();

                $query = mysqli_query($con, $sql);

                if (!$query) {
                    echo "Error sql";
                } else {
                    header('location: gestionCitas.php');
                }

                desconectar($con);
            }
        } else {
            echo "Rellene todos los campos";
        }
    }
} else {
    header('location: index.php');
}
?>


<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>registrar prueba</title>
    </head>
    <body>
        <form action="#" method="post">
            Nombre del paciente: <br/>
            <input type="text" name="nombre"> <br/>
            DNI <br/>
            <input type="text" name="dni"> <br/>
            Localidad: <br/>
            <input type="text" name="localidad"> <br/>
            Fecha de la prueba: <br/>
            <input type="date" name="fechaPrueba"> <br/>
            Resultado: <br/>
            <input type="text" name="resultado"> <br/>
            <input type="submit" value="Registrar" name="registrar">
        </form>
    </body>
</html>