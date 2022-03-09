<?php 
session_start();
?>
<!-- 
Esta es una pagina gemela a index.html, su funcion es mantener la sesion iniciada para navegar por toda sin cerrarla
-->
<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Inicio</title>
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
						<!--Aqui cambiamos index.html por index.php-->
						<li><a href="index.php">Inicio</a></li>
						<li><a href="tienda.php">Tienda</a></li>
						<li><a href="carrito.php">Carrito</a></li>	
					</ul>
				</div>
				<div class="SESION">			
					 <div class="menu2">
					 	<p>
					 		<?php echo "Hola, ".$_SESSION['user'].""; ?>
					 	</p>
					 		<form method="POST" action="index.php" class="salir">
								<input type="submit" name="salir" value="Cerrar sesion">
							</form>
						
					 </div>	
				</div>
			</div>
		</div>
		<?php 
			#con este boton salimos de la sesion actual y nos redirecciona a index.html
			if (isset($_POST['salir'])) {
					session_destroy();
					header("Location: index.html");
				}
		?>
		<div class="CUERPO">
			<h3>Bienvenido!</h3>
			<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
			tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
			quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
			consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
			cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
			proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>

			<img class="prueba" src="imagenes\one_punch_man.jpg" width="300">

			<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
			tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
			quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
			consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
			cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
			proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>

			<img src="imagenes\saitama.gif" width="300" class="saitama">

			<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Alias ad ipsum nulla natus asperiores modi eius aperiam sit animi rem, quis ducimus eveniet nostrum officia molestiae? Cum sed asperiores quisquam.</p>
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