<?php
include functions . php;

session_start();

if (isset($_SESSION['nombre']) && $_SESSION['rango'] === 'M') {

    if (isset($_POST['logout'])) {
        setcookie('nombre', $nombre, time() + 3600 * 24 * 14);
        session_destroy();
        header('location: login.php');
    } else {
        
        
        
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
            <tr>
                <td>Utapau</td>
                <td>Misión en Utapau</td>
                <td>2019-01-01</td>
                <td>2019-12-08</td>
                <td>anakin</td>
                <td>
                    <a target='_blank' href="fichas_misiones/Utapau.pdf">Utapau.pdf</a>
                </td>
                <td>
                    <form action='#' method='post'>
                        <input type='submit' name='finalizar' value='FINALIZAR' disabled="True" />
                        <input type='hidden' value="1" name='idMision'/>
                    </form>
                </td>
            <tr>
            <tr>
                <td>Geonosis</td>
                <td>mision geonosis</td>
                <td>2019-12-07</td>
                <td></td>
                <td>ahsoka</td>
                <td>
                    <a target='_blank' href="fichas_misiones/Geonosis.pdf">Geonosis.pdf</a>
                </td>
                <td>
                    <form action='#' method='post'>
                        <input type='submit' name='finalizar' value='FINALIZAR'/>
                        <input type='hidden' value="2" name='idMision'/>
                    </form>
                </td>
            </tr>		
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
            <form action='#' method='post'>
                <tr>
                    <td>Coruscant</td>
                    <td>Mision Coruscant</td>
                    <td>2019-12-09</td>
                    <td>
                        <select name='padawanseleccionado'>
                            <option value='SIN ASIGNAR' selected>SIN ASIGNAR</option>
                            <option value='anakin'>anakin</option>
                            <option value='ahsoka'>ahsoka</option>
                        </select>
                    </td>
                    <td>
                        <a target='_blank' href="fichas_misiones/Coruscant.pdf">Coruscant.pdf</a>
                    </td>
                    <td>
                        <input type='hidden' name='misionSeleccionada' value='3'/>
                        <input type='hidden' name='fechaMSeleccionada' value='fechaInicio'/>
                        <input type='submit' name='asignar' value='ASIGNAR'/> 
                    </td>
                </tr>
            </form>
        </table>

        <br><br>
        <form action="#" method="post">
            <input type="submit" name="altamision" value="Alta Mision">
        </form>
    </body>
</html>