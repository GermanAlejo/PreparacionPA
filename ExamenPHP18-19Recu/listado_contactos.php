<html>
	<head>
		<meta charset="UTF-8">
		<title>PA - Examen PHP (Junio, 2019)</title>
	</head>
	<body>
		<h1>Agenda</h1>
		<h2>Bienvenido Usuario pepe</h2>
		<form action='logout.php' method='POST'>
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
				<tr><td align='center'><input type='checkbox' name='contacto1' value='1' /></td><td align='center'>Juanito</td><td align='center'>666666666</td><td align='center'>prueba@prueba.es</td><td align='center'><img src='fotos/usuario1/1558183868prueba1.jpg'/> </td></tr><tr><td align='center'><input type='checkbox' name='contacto2' value='2' /></td><td align='center'>Mama</td><td align='center'>912345678</td><td align='center'>mama@mama.es</td><td> </td></tr>                    
			</table>
			<input name='total_checks' type='hidden' value='2'/>                    <input type='submit' name='btnBorrar' value='Eliminar contacto/s'/>
		</form>
		<form action="alta_contacto.php" method="POST">
			<input type='submit' name='btnNuevo' value='Nuevo Contacto'/>
		</form>
	</body>
</html>


