<?php

function nuevaTarea($titulo, $desc, $perfiles, $tiempos, $anexo) {

    $res = true;

    $con = dbConnection();

    $sql = "INSERT INTO tareas (id, titulo, descripcion, anexo, nombreusuario, perfiles, tiempos)"
            . " VALUES (NULL, '" . $titulo . "', '" . $desc . "', '" . $anexo . "', null, '"
            . $perfiles . "', '" . $tiempos . "')";

    //$query = mysqli_query($con, $sql);

    if (!$query) {
        $res = false;
    }

    desconectar($con);

    return $res;
}
?>

<html><head>
        <meta charset = "UTF-8">
        <title>PA - Examen PHP (Diciembre, 2018)</title>
    </head>
    <body>


        <?php
        include 'funciones.php';
        session_start();


        if (!isset($_SESSION['nombre'])) {
            header('location: login.html');
        } else {
            if ($_SESSION['tipo'] !== 'jefe') {
                header('location: listado_tareas_desarrollador.php');
            } else {

                if (isset($_POST['btnInsertar'])) {

                    $todoOK = true;

                    if (isset($_POST['titulo']) && isset($_POST[descripcion])) {

                        $arraySanitize = array(
                            'titulo' => FILTER_SANITIZE_STRING,
                            'descripcion' => FILTER_SANITIZE_STRING
                        );

                        $formInput = filter_var_array($arraySanitize);

                        $titulo = $formInput['titulo'];
                        $descripcion = $formInput['descripcion'];

                        $perfiles = array();
                        $tiempos = array();

                        if (isset($_POST['perfilP'])) {
                            if ($_POST['tiempoP'] == null) {
                                echo 'Debe asignar un tiempo';
                                $todoOK = false;
                            } else {
                                if ($_POST['tiempoP'] > 480) {
                                    echo 'tiempo maximo de 480';
                                    $todoOK = false;
                                } else {
                                    $perfiles[] = $_POST['perfilP'];
                                    $tiempos[] = $_POST['tiempoP'];
                                }
                            }
                        }

                        if (isset($_POST['perfilAP'])) {
                            if ($_POST['tiempoP'] == null) {
                                echo 'Debe asignar un tiempo';
                                $todoOK = false;
                            } else {
                                if ($_POST['tiempoAP'] > 480) {
                                    echo 'tiempo maximo de 480';
                                    $todoOK = false;
                                } else {
                                    $perfiles[] = $_POST['perfilAP'];
                                    $tiempos[] = $_POST['tiempoAP'];
                                }
                            }
                        }

                        if (isset($_POST['perfilA'])) {
                            if ($_POST['tiempoA'] == null) {
                                echo 'Debe asignar un tiempo';
                                $todoOK = false;
                            } else {
                                if ($_POST['tiempoA'] > 480) {
                                    echo 'tiempo maximo de 480';
                                    $todoOK = false;
                                } else {
                                    $perfiles[] = $_POST['perfilA'];
                                    $tiempos[] = $_POST['tiempoA'];
                                }
                            }
                        }
                        if (!empty($_FILES)) {
                            echo 'loko';
                        }
                        if (isset($_FILES['anexo'])) {

                            $anexo = $_FILES['anexo'];
                            if ($anexo['type'] !== 'application/pdf' || $anexo['size'] / 1024 > 500) {
                                echo 'El anexo debe ser un pdf de menos de 500kb';
                                $todoOK = false;
                            } else {
                                $nombreAnexo = time() . ".pdf";
                                
                            }
                        } else if (!isset($_FILES['anexo'])) {
                            $nombreAnexo = '';
                            $anexo = null;
                        }
                    } else {
                        echo 'El titulo y la descripcion no pueden estar en blanco';
                        $todoOK = false;
                    }

                    if ($todoOK) {

                        $perfiles = implode(',', $perfiles);
                        $tiempos = implode(',', $tiempos);
                        echo $titulo . $descripcion;
                        if (nuevaTarea($titulo, $descripcion, $perfiles, $tiempos, $anexo)) {
                            if ($anexo !== null) {
                                move_uploaded_file($anexo['tmp_name'], 'anexos/' . $nombreAnexo);
                            }
                            echo $titulo . $descripcion;
                            //header('location: listado_tareas_jefe.php');
                        } else {
                            echo 'Error al insertar';
                        }
                    } else {
                        echo 'algo no esta OK';
                    }
                }
            }
        }
        ?>

        <h1>Gestor de tareas</h1>
        <h2>Bienvenido Usuario jefe</h2>
        <h3>Insertar nueva tarea</h3>
        <hr>
        <form action = "#" method = "POST" enctype = "multipart/form-data">
            <table>
                <tbody><tr>
                        <td>Título de la tarea: </td>
                        <td><input type = "text" name = "titulo"> </td>
                    </tr>
                    <tr>
                        <td>Descripción: </td>
                        <td><input type = "text" name = "descripcion"> </td>
                    </tr>
                    <tr>
                        <td>Perfiles y tiempo: </td>
                        <td>
                            <input type = "checkbox" name = "perfilP" value = "P"> Programador <input type = "text" name = "tiempoP" placeholder = "Tiempo Programador"><br>
                            <input type = "checkbox" name = "perfilAP" value = "AP"> Analista-Programador <input type = "text" name = "tiempoAP" placeholder = "Tiempo Analista-Programador"><br>
                            <input type = "checkbox" name = "perfilA" value = "A"> Analista <input type = "text" name = "tiempoA" placeholder = "Tiempo Analista"><br>
                        </td>
                    </tr>
                    <tr>
                        <td>Anexo: </td>
                        <td><input type = "file" name = "anexo"></td>
                    </tr>
                    <tr>
                        <td colspan = "2">
                            <input type = "submit" name = "btnInsertar" value = "Insertar">
                        </td>
                    </tr>
                </tbody></table>
        </form>


    </body></html>