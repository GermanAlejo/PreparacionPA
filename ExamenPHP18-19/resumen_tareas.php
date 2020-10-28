<?php
include "funciones.php";

function obtenerTareas($tareas) {
    $con = conectar();
    $datos = array();

    foreach ($tareas as $id) {
        $result = $con->query("SELECT * FROM tareas WHERE id = $id");
        if ($result->num_rows !== 0) {
            array_push($datos, $result->fetch_assoc());
        }
    }

    desconectar($con);

    return $datos;
}

function asignar($datos, $usuario) {
    $con = conectar();
    $res = False;
    print_r($datos);
    foreach ($datos as $tarea) {
        $id = $tarea['id'];
        $result = $con->query("UPDATE tareas SET nombreusuario = '$usuario' WHERE id = $id ");
        if ($result) {
            $res = True;
        }
    }

    desconectar($con);

    return $res;
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>PA - Examen PHP (Diciembre, 2018)</title>
    </head>
    <body>


        <?php
        session_start();
        if (!isset($_SESSION['nombre'])) {
            header('Location: login.php');
        }
        if (isset($_SESSION['nombre'])) {
            if ($_SESSION['tipo'] !== 'desarrollador') {
                header('Location: listado_tareas_jefe.php');
            }
            $usuario = $_SESSION['nombre'];
        }
        $tareas = array();

        if (isset($_POST['btnTareas'])) {
            $num = $_POST['total_checks'];

            for ($i = 0; $i < $num; $i++) {
                if (isset($_POST[$i])) {
                    $tareas[] = $_POST[$i];
                }
            }
            $datos = obtenerTareas($tareas);
            $_SESSION['datos'] = $datos;
        }

        if (isset($_POST['btnLogout'])) {
            session_destroy();
            header('Location: login.php');
        }

        if (isset($_POST['btnAsginar'])) {
            if (isset($_SESSION['datos'])) {
                if (asignar($_SESSION['datos'], $usuario)) {
                    echo "Tareas asignadas";
                    header('Location: listado_tareas_desarrollador.php');
                } else {
                    echo "Error al asignar";
                }
            } else {
                echo "no hay datos";
            }
        }
        ?>
        <h1>Gestor tareas</h1>
        <h2>Bienvenido Usuario pepe</h2>
        <form action='#' method='POST'>
            <input type='submit' name='btnLogout' value='Cerrar sesi&oacute;n'/>                
        </form>
        <hr>
        <table cellpadding="10" border="1">
            <tbody>
                <tr>
                    <th>Tarea</th>
                    <th>Tiempo</th>
                </tr>
                <?php
                $suma = 0;
                foreach ($datos as $tarea) {
                    ?>
                    <tr>
                        <td><?php echo $tarea['titulo']; ?></td>
                        <td><?php
                            $perfilesTarea = explode(',', $tarea['perfiles']);
                            $tiempoTarea = explode(',', $tarea['tiempos']);
                            for ($i = 0; $i < count($perfilesTarea); $i++) {
                                if ($perfil['perfil'] === $perfilesTarea[$i]) {
                                    echo "Dura: $tiempoTarea[$i]";
                                    $suma += $tiempoTarea[$i];
                                } else {
                                    echo "sin tiempo<br/>";
                                }
                            }
                            ?></td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
        <br>Tiempo total: <?php echo $suma; ?> <br>          
        <form action="#" method="POST">
            <input type="hidden" name="paaram[]" value="<?php $datos[$i]; ?>">
            <input type="submit" name="btnAsginar" value="Asignar Tareas">                
        </form>
    </body>
</html>

