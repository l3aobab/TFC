<?php 
session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Crea usuario/iniciar Sesion</title>
	<link rel="stylesheet" type="text/css" href="estilos.css">
</head>
<body>
	<div class="grid-container-1">
		<div class="CABECERA">
			<div class="grid-container-1-a">
				<div class="LOGO">
					<div class="logo-completo">
						<img class="prueba" src="imagenes\logo.png" width="150">
					</div>
				</div>
				<div class="MENU">
					<ul class="menu2">
						<li><a href="index.html">Inicio</a></li>
						<li><a href="tienda.php">Tienda</a></li>
						<li><a href="carrito.php">Carrito</a></li>	
					</ul>
				</div>
				<div class="SESION">
					<?php 
						if (isset($_SESSION['user'])) {
							echo "Estas conectado como ".$_SESSION['user'];
						}
						else {
					?>
					<!--Los botones de creacion de usuario e inicio de sesion se mantienen para facilitar la navegacion por la pagina-->
					<form method="post" action="usuario.php">
						<input type="submit" name="crear" value="Crear usuario"><br>
						<input type="submit" name="iniciar" value="Iniciar sesion">
					</form>
					<?php 
						}
					 ?>
				</div>
			</div>
		</div>
		<div class="CUERPO">
			<?php 
				
				#Este es el formulario para crear un nuevo usuario
				if (isset($_POST['crear'])) {
					echo "
						<form method='POST' action='usuario.php'>
							<label>Nombre del usuario</label>
							<input type='text' name='nombre'><br>
							<label>Correo electronico</label>
							<input type='text' name='correo'><br>
							<label>Password</label>
							<input type='password' name='contrasinal'><br>
							<input type='submit' name='cre_usu' value='Crear usuario'>
						</form>
					";
				}

				#Este es el formulario para iniciar sesion
				if (isset($_POST['iniciar'])) {
					echo "
						<form method='POST' action='usuario.php'>
							<label>Nombre de usuario</label>
							<input type='text' name='name'><br>
							<label>Password</label>
							<input type='password' name='contra'><br>
							<input type='submit' name='ini_ses' value='Iniciar sesion'>
						</form>
					";
				}

				if (isset($_POST['cre_usu'])||isset($_POST['ini_ses'])) {	
					$conexion=mysqli_connect('localhost','root','','shop') or die(mysqli_error());
					#si usarmos php 7.4 tenemos que ponerle antes un isset al $conexion
					if ($conexion) {
						#aqui estamos creando el usuario en la base de datos
						if (isset($_POST['nombre'])) { 
							$conexion=mysqli_connect('localhost','root','', 'shop') or die(mysqli_error());
							if ($conexion) {
								mysqli_set_charset($conexion,'UTF8');
								$nombre=$_POST['nombre'];
								$correo=$_POST['correo'];
								$contrasinal=$_POST['contrasinal'];
								#aqui hasheamos la contraseña del usuario
								$cifrado = password_hash($contrasinal, PASSWORD_DEFAULT, [15]);
								#Aqui nos aseguramos de que se han rellenado todos los datos en el formulario, si no, se envia un mensaje de error
								if (($nombre != FALSE)&&($correo != FALSE)&&($contrasinal != FALSE)) {									
										$resultado=mysqli_query($conexion,"INSERT INTO usuarios (nombre,correo,contrasinal) VALUES ('".$nombre."','".$correo."','".$cifrado."')");

										if ($resultado != FALSE) {
											echo "El usuario ha sido registrado correctamente";
											
										}
										else {
											echo "No se ha podido registrar el nuevo usuario";
										}
									}

									else {
										echo "ERROR, Datos mal introducidos";
									}
								}

							}

					
						}
						#aqui estamos inciando sesion
						if (isset($_POST['name'])) {
							$conexion=mysqli_connect('localhost','root','','shop') or die(mysqli_error());
							#si usarmos php 7.4 tenemos que ponerle antes un isset al $conexion
							if ($conexion) {
							$name=$_POST['name'];
							$contra=$_POST['contra'];
							
							$consulta=mysqli_query($conexion,"SELECT * FROM usuarios");
							if ($consulta != FALSE) {
								while ($fila=mysqli_fetch_array($consulta)) {
									$nombre_usaurio=$fila['nombre'];
									$correo_usuario=$fila['correo'];
									$contrasinal_usuario=$fila['contrasinal'];

									#aqui estamos comparando la contraseña introducida en el formulario con la que tenemos guardada en un hash en la base de datos
									if ((password_verify($contra,$contrasinal_usuario))&&(strcmp($name, $nombre_usaurio)==0)) {
										$_SESSION['user'] = $name;
										#Si los datos coinciden nos redirecciona a index.php
										header("Location: index.php");
									}
									else {
										#En caso de que los datos no coincidan nos mostrara un mensaje de error
										echo "ERROR. Usuario o contraseña incorrectos";
									}
								}
							}

							}
						}
					
				}
			?> 
		</div>
		<div class="IZQUIERDA"><ul></ul></div>
		<div class="DERECHA"><ul></ul></div>
		<div class="PIE">
			<p>Isekai Express es una empresa muy seria en la que nos tomamos muy en serio nuestro trabajo</p>
			<p>Copyright 2021 by isekaiexpress.com. All Rights Reserved.</p>
		</div>
	</div>
</body>
</html>