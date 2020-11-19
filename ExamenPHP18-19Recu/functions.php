<?php

//this function handles the connection to the DB
function dbConnection() {
    //Connect to database
    $con = mysqli_connect("localhost", "root", "");

//check connection
    if (!$con) {
        die("ERROR: Can't connect to host");
    }
    $db = mysqli_select_db($con, "agenda");

    if (!$db) {
        die("ERROR: Can't connect to DB ");
    }
    mysqli_set_charset($con, "utf-8");
    return $con;
}

function desconectar($con) {
    $con->close();
    //mysqli_close($con);
}

function obtenerFoto($nombreContacto) {

    $sql = "SELECT id FROM usuarios WHERE usuario.nombre=$nombreContacto";

    $con = dbConnection();

    $query = mysqli_query($con, $sql);

    if (mysqli_num_rows($query) === 1) {
        $usuario = mysqli_fetch_array($query);
        //corregir ruta foto
        $rutaFoto = 'fotos/user' . $usuario['id'] . '/prueba1.jpg';
    } else {
        echo "error query foto";
        $rutaFoto = false;
    }


    return $rutaFoto;
}

function borrarContacto($contactosBorrar) {

    $res = false;

    if (empty($contactosBorrar)) {
        $res = true;
    } else {

        $con = dbConnection();

        foreach ($contactosBorrar as $id) {

            $sqlFoto = "SELECT foto FROM contactos WHERE contactos.id_contacto=$id";
            $sqlBorrado = "DELETE FROM contactos WHERE contactos.id_contacto=$id";

            $queryFoto = mysqli_query($con, $sqlFoto);
            if (!$queryFoto) {
                echo "error query foto";
            } else {
                $foto = mysqli_fetch_assoc($queryFoto);
                //comprueba foto existe
                if ($foto['foto'] !== null) {
                    /*
                     * No estoy seguro como guardar las fotos de los contactos ya que
                     * no son usuarios por lo que la ruta no esta completa
                     */
                    unlink("fotos/" . $foto['foto']);
                }

                $queryBorrado = mysqli_query($con, $sqlBorrado);

                if (!$queryBorrado) {
                    echo "error borrado";
                } else {
                    $res = true;
                }
            }
        }
        
        desconectar($con);
    }
}
