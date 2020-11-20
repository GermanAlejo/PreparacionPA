<?php
include 'functions.php';

session_start();

if (isset($_SESSION['nombre']) && $_SESSION['rango'] === 'M') {

    if (isset($_POST['logout'])) {
        setcookie('nombre', $nombre, time() + 3600 * 24 * 14);
        session_destroy();
        header('location: login.php');
        
        
    }else if(isset($_POST['asignar'])){
        
        $misionID = $_POST['misionSeleccionada'];
        $jedi = $_POST['padawanseleccionado'];
        echo 'loko';
        $res = asignarPadawan($jedi, $misionID);
        
        if(!$res){
            echo "Error al asignar Jedi";
        }else{
            header('location: maestro.php');
        }
        
    }else if(isset($_POST['altamision'])){
        
        echo 'loko';
        
    } else {

        $con = dbConnection();

        $sql = "SELECT * FROM misiones ORDER BY fecha_inicio ASC";

        $result = mysqli_query($con, $sql);
        
        if (!$result) {
            echo 'Error sql';
        } else {
            
            $numMisiones = mysqli_num_rows($result);

            //$misiones = array();
            $misionesCon = array();
            $misionesSin = array();

            for ($i = 0; $i < $numMisiones; $i++) {
                
                $aux = mysqli_fetch_array($result);
                
                if ($aux['jedi_asociado'] === null || $aux['jedi_asociado'] === "") {
                    $misionesSin[] = $aux;
                } else {
                    $misionesCon[] = $aux;
                }
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
        <title>maestro</title>
    </head>
    <body>
        <h1>Hola de nuevo, Maestro <?php echo $_SESSION['nombre']; ?></h1>
        <form action="#" method="post">
            <input type="submit" name="logout" value="logout">
        </form>
        <br>
        <h1>Misiones dadas de alta en el sistema y asignadas a algún padawan</h1>
        <table border="1">
            <tr>
                <th>Nombre</th>
                <th>Descripcion</th>
                <th>Fecha de inicio</th>
                <th>Fecha de fin</th>
                <th>Padawan asignado</th>
                <th>Ficha</th>
                <th>Finalizar</th>
            </tr>

            <?php
            
            $numRows = sizeof($misionesCon);

            for ($i = 0; $i < $numRows; $i++) {
                
                if ($misionesCon[$i]['ficha_mision'] !== null) {
                    $rutaFichero = "fichas_misiones/" . $misionesCon[$i]['ficha_mision'];
                } else {
                    $rutaFichero = "";
                }
                ?>
                <tr>
                    <td><?php echo $misionesCon[$i]['titulo'] ?></td>
                    <td><?php echo $misionesCon[$i]['descripcion'] ?></td>
                    <td><?php echo $misionesCon[$i]['fecha_inicio'] ?></td>
                    <td><?php echo $misionesCon[$i]['fecha_fin'] ?></td>
                    <td><?php echo $misionesCon[$i]['jedi_asociado'] ?></td>
                    <td>
                        <a target='_blank' href="<?php echo $rutaFichero; ?>"><?php echo $misionesCon[$i]['ficha_mision']; ?></a>
                    </td>
                    <td>
                        <form action='#' method='post'>
                            <input type='submit' name='finalizar' value='FINALIZAR'/>
                            <input type='hidden' value="<?php echo $misionesCon[$i]['id']; ?>" name='idMision'/>
                        </form>
                    </td>
                </tr>
                <?php
            }
            ?>
        </table>

        <h1>Misiones sin asignar a ningun jedi</h1>

        <table border="1">
            <tr>
                <th>Nombre</th>
                <th>Descripcion</th>
                <th>Fecha de inicio</th>
                <th>Padawan asignado</th>
                <th>Ficha</th>
                <th>Asignar</th>
            </tr>


            <?php
            $numRowsSin = sizeof($misionesSin);

            for ($i = 0; $i < $numRowsSin; $i++) {

                if ($misionesSin[$i]['ficha_mision'] !== null) {
                    $rutaFichero = "fichas_misiones/" . $misionesSin[$i]['ficha_mision'];
                } else {
                    $rutaFichero = "";
                }
                ?>


                <form action='#' method='post'>
                    <tr>
                        <td><?php echo $misionesSin[$i]['titulo'] ?></td>
                        <td><?php echo $misionesSin[$i]['descripcion'] ?></td>
                        <td><?php echo $misionesSin[$i]['fecha_inicio'] ?></td>
                        <td>
                            <?php
                            $jedisDisponibles = jedisDisponibles($misionesSin[$i]['fecha_inicio'], $misionesCon);
                            ?>

                            <select name='padawanseleccionado'>

                                

                                <?php
                                foreach ($jedisDisponibles as $jedi) {
                                    ?>
                                    <option value='<?php echo $jedi; ?>'><?php echo $jedi; ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </td>
                        <td>
                            <a target='_blank' href="<?php echo $rutaFichero; ?>"><?php echo $misionesSin[$i]['ficha_mision']; ?></a>
                        </td>
                        <td>
                            <input type='hidden' name='misionSeleccionada' value='<?php echo $misionesSin[$i]['id']; ?>'/>
                            <input type='hidden' name='fechaMSeleccionada' value='<?php echo $misionesSin[$i]['fecha_inicio']; ?>'/>
                            <input type='submit' name='asignar' value='ASIGNAR'/> 
                        </td>
                    </tr>
                </form>

                <?php
            }
            ?>
        </table>

        <br><br>
        <form action="#" method="post">
            <input type="submit" name="altamision" value="Alta Mision">
        </form>
    </body>
</html>