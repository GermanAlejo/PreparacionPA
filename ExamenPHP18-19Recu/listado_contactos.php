<html>
    <head>
        <meta charset="UTF-8">
        <title>PA - Examen PHP (Junio, 2019)</title>
    </head>

    <?php
    include 'functions.php';

    session_start();

    if (isset($_SESSION['nombre'])) {

        if (isset($_POST['btnLogout'])) {
            session_destroy();
            header('location: login.php');
        }else if(isset($_POST['btnBorrar'])){
            
            $totalChecks = $_POST['total_checks'];
            
            $contactosBorrar = array();
            for($i=0;$i<$totalChecks;$i++){
                
                if(isset($_POST['contacto' . $i])){
                    $contactosBorrar[] = $_POST['contacto' . $i];
                }
            }
            $res = borrarContacto($contactosBorrar);
            
            if(!$res){
                echo "Error al borrar contacto";
            }
            
        }else if(isset($_POST['btnNuevo'])){
            
            header('location: alta_contacto.php');
            
        }else{

            //conexion a la bd
            $con = dbConnection();
            //usuario que visualiza
            $userID = $_SESSION['id'];

            $sql = "SELECT * FROM contactos WHERE contactos.id_usuario=$userID";

            $query = mysqli_query($con, $sql);

            if (!$query) {
                echo "error en query";
            } else {

                $numRows = mysqli_num_rows($query);

                if ($numRows === 0) {
                    echo "usuario sin contactos";
                } else {

                    $contactos = array();

                    for ($i = 0; $i < $numRows; $i++) {
                        array_push($contactos, mysqli_fetch_array($query));
                    }
                    //$numContactos = count($contactos);
                    //print_r($contactos);
                }
            }
        }
        
        desconectar($con);
    } else {
        header('location: login.php');
    }
    ?>

    <body>
        <h1>Agenda</h1>
        <h2>Bienvenido Usuario <?php echo $_SESSION['nombre']; ?></h2>
        <form action='#' method='POST'>
            <input type='submit' name='btnLogout' value='Cerrar sesi&oacute;n'/>                
        </form>
        <hr>


        <form action="#" method="POST">
            <table cellpadding="10" border="1">
                <tr>
                    <th></th>
                    <th>Nombre</th>
                    <th>Tel&eacute;fono</th>
                    <th>Email</th>
                    <th>Foto</th>
                </tr>

                <?php
                    //print_r($contactos);
                    //echo $contactos[1]['id_contacto'];
                for($i=0;$i<$numRows;$i++){
                    
                    //obtenemos ruta de foto
                    $rutaFoto = obtenerFoto($contactos[$i]['nombre']);
                    
                    ?>
                    <tr>
                        <td align='center'><input type='checkbox' name=<?php echo 'contacto' . $i;?> 
                                                  value=<?php echo $contactos[$i]['id_contacto'];?> />
                        </td>
                        <td align='center'><?php echo $contactos[$i]['nombre'];?></td>
                        <td align='center'><?php echo $contactos[$i]['telefono'];?></td>
                        <td align='center'><?php echo $contactos[$i]['email'];?></td>
                        <td align='center'><img src='<?php echo $rutaFoto;?>'/> </td>
                    </tr>
                    <?php
                }
                ?>
                    
            </table>
            <input name='total_checks' type='hidden' value='<?php $numRows ?>'/>                   
            <input type='submit' name='btnBorrar' value='Eliminar contacto/s'/>
        </form>
        <form action="alta_contacto.php" method="POST">
            <input type='submit' name='btnNuevo' value='Nuevo Contacto'/>
        </form>
    </body>
</html>


