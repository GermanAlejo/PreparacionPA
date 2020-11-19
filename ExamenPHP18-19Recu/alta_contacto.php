
<?php
include 'functions.php';

session_start();

if (isset($_SESSION['nombre'])) {

    if (isset($_POST['btnInsertar'])) {

        $todoOK = true;
        if (isset($_POST['nombre']) && isset($_POST['telefono']) && isset($_POST['email'])) {

            $nombre = filter_var(trim($_POST['nombre'], FILTER_SANITIZE_MAGIC_QUOTES));
            if ($nombre == '') {
                echo "NOMBRE - NO SE PUEDE<br/>";
                $todoOK = False;
            }

            $telefono = filter_var(trim($_POST['telefono'], FILTER_SANITIZE_MAGIC_QUOTES));
            $aux = substr($telefono, 0, 1);
            echo $aux;
            //preg_replace('/[^0-9]/', $_POST['phone']);
            if ($telefono == '' || ($aux != '6' || $aux != '7' || $aux != '9') || count($telefono) != 9) {
                echo "Telefono no correcto";
                $todoOK = false;
            }
            $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
            if ($email == '') {
                echo "Formato email invalido";
                $todoOK = false;
            }

            //comprobamos foto
            if ($_FILES['foto']['error'] !== 4) {

                $foto = $_FILES['foto'];
                $permitido = array('png', 'jpg');
                $ext = pathinfo($foto, PATHINFO_EXTENSION);
                if (!in_array($ext, $permitido) || $foto['size'] / 1024 > 500) {
                    echo "La foto debe ser .jpg o .png y 500kb como maximo";
                    $todoOK = false;
                } else {
                    $nombreFoto = basename($foto);
                    //falta guardar la foto en una carpeta
                }
            } else {
                $nombreFoto = '';
            }

            if ($todoOK) {

                //realizamos la insercion
                $sqlInsert = "INSERT INTO contactos(id_contacto, id_usuario, nombre, "
                        . "telefono, email, foto) VALUES (NULL, '" . $_SESSION['id'] . "', '"
                        . $nombre . "', '" . $telefono . "', '" . $email . "', '" . $nombreFoto . "')";
                
                $con = dbConnection();
                
                $query = mysqli_query($con, $sqlInsert);
                if(!$query){
                    echo "error query insercion";
                }
                
                desconectar($con);
                header('location: listado_contactos.php');
                
            }
        } else {
            echo "Los campos nombre, tlf y email son obligatorios";
        }
    }
} else {
    header('location: login.php');
}
?>


<html>
    <head>
        <meta charset="UTF-8">
        <title>PA - Examen PHP (Junio, 2019)</title>
    </head>
    <body>
        <h1>Agenda</h1>
        <h2>Bienvenido Usuario <?php echo $_SESSION['nombre']; ?></h2>
        <h3>Insertar contacto</h3>
        <hr>
        <form action="#" method="POST" enctype="multipart/form-data">
            <table>
                <tr>
                    <td>Nombre: </td>
                    <td><input type="text" name="nombre" /> </td>
                </tr>
                <tr>
                    <td>Tel&eacute;fono: </td>
                    <td><input type="text" name="telefono" /> </td>
                </tr>
                <tr>
                    <td>Email:</td>
                    <td>        
                        <input type="text" name="email" />
                    </td>
                </tr>
                <tr>
                    <td>Foto: </td>
                    <td><input type="file" name="foto" /></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="btnInsertar" value="Insertar" />
                    </td>
                </tr>
            </table>
        </form>
    </body>
</html>
