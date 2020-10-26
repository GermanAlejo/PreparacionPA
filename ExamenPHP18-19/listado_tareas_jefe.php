<!DOCTYPE html>

<?php

function eliminarTarea($tarea) {

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

    $res = false;

    foreach ($tarea as $id) {

        $query = $con->query("SELECT anexo FROM tareas WHERE id = $id");
        $nombre = $query->fetch_assoc();
        $query = $con->query("DELETE FROM tareas WHERE id = $id");
        if ($nombre !== null) {
            unlink("anexos/" . $nombre['anexo']);
        }
        if ($query) {
            $res = true;
        }
    }

    return $res;
}
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>PA - Examen PHP (Diciembre, 2018)</title>
    </head>
    <body>

        <?php
        session_start();

        if (!isset($_SESSION['nombre'])) {
            header('location: login.html');
        } else {
            if ($_SESSION['tipo'] !== 'jefe') {
                header('location: listado_tareas_desarrollador');
            }
        }

        if (isset($_POST['btnLogout'])) {
            session_destroy();
            header('location: login.html');
        } else if ($_POST['btnBorrar']) {
            $num = $_POST['total_checks'];
            $tareasBorrar = array();
            for($i=0;$i < $num;$i++){
                if(isset($_POST[$i])){
                    $tareasBorrar[] = $_POST[$i];
                }
            }
            eliminarTarea($tareasBorrar);
        } else if ($_POST['btnNueva']) {
            header('location: alta_tarea.html');
        }

        //OBTENER DATOS
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

        $sql = "SELECT * FROM tareas";

        $query = mysqli_query($con, $sql);

        if (!$query) {
            echo 'error en query';
        } else {

            if (mysqli_num_rows($query) === 0) {
                echo 'query vacia';
            } else {
                $tareas = array();
                for ($i = 0; $i < $query->num_rows; $i++) {
                    array_push($tareas, $query->fetch_assoc());
                }
            }
        }
        ?>
        <h1>Gestor tareas</h1>
        <h2>Bienvenido Usuario admin</h2>
        <form action='#' method='POST'>
            <input type='submit' name='btnLogout' value='Cerrar sesi&oacute;n'/>                
        </form>
        <hr>


        <form action="#" method="POST">
            <table cellpadding="10" border="1">
                <tr>
                    <th></th>
                    <th>T&iacute;tulo</th>
                    <th>Descripci&oacute;n</th>
                    <th>Perfiles y tiempos</th>
                    <th>Anexo</th>
                    <th>Usuario</th>
                </tr>                        
                <?php
                //print_r($tareas);
//echo sizeof($tareas);
                $i = 0;
                foreach ($tareas as $tarea) {
                    ?>
                    <tr>
                        <td>

                            <input type="checkbox" name="<?php echo $i++; ?>" value="<?php echo $tarea['id']; ?>">

                        </td>
                        <td align='center'><?php echo $tarea['titulo']; ?></td>
                        <td align='center'><?php echo $tarea['descripcion']; ?></td>
                        <?php
                        $tiempos = explode(",", $tarea['tiempos']);
                        $perfiles = explode(",", $tarea['perfiles']);
                        $num = count($tiempos);
                        ?>
                        <td align='center'>
                            <ul type='square'>
                                <?php
                                for ($j = 0; $j < $num; $j++) {
                                    echo "<li>$perfiles[$j]: $tiempos[$j] minutos</li>";
                                }
                                ?>
                            </ul>
                        </td>
                        <td align='center'><a href='anexos/<?php echo $tarea['anexo']; ?>'><?php echo $tarea['anexo']; ?></a> </td>
                        <td align='center'><?php echo $tarea['nombreusuario']; ?></td>
                    </tr>
                <?php } ?>


                <input name="total_checks" type="hidden" value="<?php echo $i; ?> ">
            </table>

            <input type='submit' name='btnBorrar' value='Eliminar tarea/s'/>
        </form>
        <form action="#" method="POST">
            <input type='submit' name='btnNueva' value='Nueva Tarea'/>
        </form>
    </body>
</html>

