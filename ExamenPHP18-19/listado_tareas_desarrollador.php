<html>
    <head>
        <meta charset="UTF-8">
        <title>PA - Examen PHP (Diciembre, 2018)</title>
    </head>

    <?php
    session_start();

    if (!isset($_SESSION['nombre'])) {
        header('location: login.html');
    } else {
        if (isset($_SESSION['tipo']) === 'jefe') {
            header('location: listado_tareas_jefe.html');
        } else {

            if (isset($_POST['btnLogout'])) {
                session_destroy();

                header('Location: login.php');
            }

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
        }
    }
    ?>


    <body>
        <h1>Gestor tareas</h1>
        <h2>Bienvenido Usuario pepe</h2>
        <form action='#' method='POST'>
            <input type='submit' name='btnLogout' value='Cerrar sesi&oacute;n'/>                
        </form>
        <hr>


        <form action="resumen_tareas.html" method="POST">
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
                            <?php
                                if($tarea['nombreusuario'] === null || 
                                        $tarea['nombreusuario'] === ''){
                                    ?>
                            <input type="checkbox" name="<?php echo $i++; ?>" value="<?php echo $tarea['id']; ?>">
                            <?php
                                }
                            ?>
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

            <input type='submit' name='btnTareas' value='Seleccionar tarea/s'/>
        </form>
    </body>
</html>
