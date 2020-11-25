<?php
include 'functions.php';

session_start();

if (isset($_SESSION['username'])) {

    if (isset($_POST['logout'])) {

        session_destroy();
        header('location: index.php');
    } else if (isset($_POST['eliminarPrueba'])) {

        $idPrueba = $_POST['idPrueba'];

        $sqlEliminar = "DELETE FROM prueba WHERE id_prueba=$idPrueba";

        $con = dbConnection();

        $query = mysqli_query($con, $sqlEliminar);

        if (!$query) {
            echo "Error sql eliminar";
        } else {
            header('location: gestionCitas.php');
        }
    } else if (isset($_POST['registrarPrueba'])) {
        header('location: altaPrueba.php');
    } else {

        $con = dbConnection();

        if (!$con) {
            echo "Error al conectar";
        } else {

            $idHospital = $_SESSION['id_hospital'];
            $sqlHospital = "SELECT nombre FROM hospital WHERE id=$idHospital LIMIT 1";

            $query1 = mysqli_query($con, $sqlHospital);

            if (!$query1) {
                echo "Error sql";
            } else {

                $hospital = mysqli_fetch_array($query1);
                $nombreHospital = $hospital['nombre'];

                //query pacientes
                $sqlPacientes = "SELECT * FROM prueba WHERE hospital_asociado=$idHospital";

                $query2 = mysqli_query($con, $sqlPacientes);

                if (!$query2) {
                    echo "Error sql pacientes";
                } else {

                    $pacientes = array();
                    $numPacientes = mysqli_num_rows($query2);
                    for ($i = 0; $i < $numPacientes; $i++) {
                        array_push($pacientes, mysqli_fetch_array($query2));
                    }
                }
            }
        }
    }
} else {
    header("location: index.php");
}

desconectar($con);

function eliminarPrueba($pruebaId) {

    $sqlEliminar = "DELETE FROM prueba WHERE id_prueba=$idPrueba";

    $con = dbConnection();

    $query = mysqli_query($con, $sqlEliminar);

    if (!$query) {
        echo "Error sql eliminar";
    } else {
        header('location: gestionCitas.php');
    }
}
?>


<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Gestion Citas</title>
    </head>
    <body>
        <h1>Bienvenid@ <?php echo $_SESSION['username']; ?>.</h1>
        <h2>Hospital: <?php echo $nombreHospital; ?></h2>

        <form action="#" method="post">
            <input type="submit" value="Logout" name="logout" />
        </form>

        <table border="1">
            <tr>
                <th>Nombre del paciente</th>
                <th>DNI</th>
                <th>Localidad</th>
                <th>Fecha de la prueba</th>
                <th>Resultado</th>
                <th>
                    <form action="#" method="post">
                        <input type="submit" value="Registrar Prueba" name="registrarPrueba">
                    </form>
                </th>
            </tr>

            <?php
//imprime pacientes
            $i = 0;
            foreach ($pacientes as $paciente) {

                if ($paciente['resultado_prueba'] === 0) {
                    $resultado = "Negativo";
                } else {
                    $resultado = "Positivo";
                }
                ?>

                <tr>
                    <td><?php echo $paciente['nombre_paciente']; ?></td>
                    <td><?php echo $paciente['dni_paciente']; ?></td>
                    <td><?php echo $paciente['localidad_paciente']; ?></td>
                    <td><?php echo $paciente['fecha_prueba']; ?></td>
                    <td><?php echo $resultado; ?></td>
                    <td>
                        
                        <?php
                        
                           
                        
                        ?>
                        <form action='#' method="post">
                            <input type='submit' name='eliminar' value='ELIMINAR PRUEBA' name="eliminarPrueba" />
                            <input type='hidden' value="<?php echo $i; ?>" name='idPrueba'/>
                        </form>
                    </td>
                </tr>

                <?php
                $i++;
            }
            ?>

<!--            <tr>
    <td>Juan Antonio</td>
    <td>34515743B</td>
    <td>Arahal</td>
    <td>2020-03-28</td>
    <td>Negativo</td>
    <td>
        <form action='' method="">
            <input type='submit' name='eliminar' value='ELIMINAR PRUEBA' name="eliminarPrueba"/>
            <input type='hidden' value="5" name='idPrueba'/>
        </form>
    </td>
</tr>-->


        </table>

    </body>
</html>