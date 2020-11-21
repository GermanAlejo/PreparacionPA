
<?php
include 'functions.php';

session_start();

if (isset($_SESSION['nombre']) && $_SESSION['rango'] === 'M') {

    if (isset($_POST['logout'])) {
        setcookie('nombre', $nombre, time() + 3600 * 24 * 14);
        session_destroy();
        header('location: login.php');
    } else {

        if (isset($_POST['guardar'])) {

            if (isset($_POST['titulo']) && isset($_POST['descripcion']) && isset($_POST['fecha_inicio'])) {

                $todoOK = true;
                $titulo = filter_var(trim($_POST['titulo']), FILTER_SANITIZE_MAGIC_QUOTES);
                if ($titulo === "") {
                    echo "Titulo no valido";
                    $todoOK = false;
                }

                $descripcion = filter_var(trim($_POST['descripcion']), FILTER_SANITIZE_MAGIC_QUOTES);
                if ($descripcion === "") {
                    echo "Descripcion no valida";
                    $todoOK = false;
                }

                $pattern = "^([0-2][0-9]|(3)[0-1])(\-)(((0)[0-9])|((1)[0-2]))(\-)\d{4}$^";
                if (preg_match($pattern, $_POST['fecha_inicio'])) {
                    $fecha_inicio = date('Y-m-d', strtotime($_POST['fecha_inicio']));
                } else {
                    echo "Fecha no valida";
                    $todoOK = false;
                }

                $padawan = $_POST['padawan'];
                if ($padawan === "SIN ASIGNAR") {
                    $padawan = NULL;
                }

                if ($_FILES['ficha_mision']['error'] !== 4) {

                    $ficha = $_FILES['ficha_mision'];
                    if ($ficha['type'] !== 'application/pdf' || $ficha['size'] / 1024 > 1000) {
                        echo 'El anexo debe ser un pdf de menos de 1Mb';
                        $todoOK = false;
                    }
                } else if (!isset($_FILES['ficha_mision'])) {
                    $ficha = NULL;
                }

                if ($todoOK) {

                    if (nuevaMision($titulo, $descripcion, $fecha_inicio, $ficha, $jedi)) {
                        if ($ficha !== null) {
                            move_uploaded_file($anexo['tmp_name'], 'fichas_misiones/' . $ficha);
                        }
                        header('location: maestro.php');
                    } else {
                        echo "Error insertar mision";
                    }
                } else {
                    echo "Error form";
                }
            } else {
                echo "Rellene todos los campos";
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
        <meta charset="utf-8">
        <title>Alta misión</title>
    </head>
    <body>
        <form action="#" method="post">
            <span>Nombre: </span><br>
            <input type="text" name="nombre" value=""><br>
            <span>Descripción: </span><br>
            <input type="text" name="descripcion" value=""><br>
            <span>Fecha de inicio: </span><br>
            <input type="text" name="FechaInicio" value=""><br>
            <span>Padawan asignado: </span><br>
            <select name="padawan">
                <option value="SIN ASIGNAR" selected>NO ASIGNAR</option> 
                <option value='anakin'>anakin</option>
                <option value='ahsoka'>ahsoka</option>		
            </select><br>
            <span>Ficha de la misión: </span><br>
            <input type="file" name="fichamision"/><br>
            <input type="submit" name="guardar" value="Guardar">
            <input type="submit" name="logout" value="logout">
        </form>
    </body>
</html>