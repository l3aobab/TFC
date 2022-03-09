<?php 
session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
	<title>Tienda</title>
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
				<?php 

				#Aqui cambiamos las otras dos partes de la cabecera en funcion de si se ha iniciado sesion con un usuario o no.

				#Si hay un usuario conectado, nos mostrara un mensaje de bienvenida y un boton para salir de la sesion, tambien nos cambia el enlace de la pagina principal de index.html a index.php

				#En caso de no haber una sesion iniciada, nos mostrara los botones de creacion de usuario e inicio de sesion, ademas que el enlance a la pagina de inicio sera index.html

				if (isset($_SESSION['user'])) {
					
					?>
					<div class='MENU'>
						<ul class='menu2'>
							<li><a href='index.php'>Inicio</a></li>
							<li><a href='tienda.php'>Tienda</a></li>
							<li><a href='carrito.php'>Carrito</a></li>	
						</ul>
					</div>
					<div class='SESION'>			
						 <div class='menu2'>
						 	<!--Mensaje de bienvenida y boton para cerrar sesion-->
						 	<p>
						 		<?php echo "Hola, ".$_SESSION['user'].""; ?>
							</p>
							<form method="POST" action="tienda.php" class="salir">
								<input type="submit" name="salir" value="Cerrar sesion">
							</form>
						 </div>	
					</div>
					<?php
				}

				else {
				?>
				<div class="MENU">
					<ul class="menu2">
						<li><a href="index.html">Inicio</a></li>
						<li><a href="tienda.php">Tienda</a></li>
						<li><a href="carrito.php">Carrito</a></li>	
					</ul>
				</div>
				<div class="SESION">
					<form method="post" action="usuario.php">
						<input type="submit" name="crear" value="Crear usuario"><br>
						<input type="submit" name="iniciar" value="Iniciar sesion">
					</form>
				</div>
				<?php 
				}
				if (isset($_POST['salir'])) {
					session_destroy();
					header("Location: index.html");
				}
				?>
			</div>
		</div>
		<div class="CUERPO">
			<h3>Bienvenido a la tienda</h3>
			<h6>Que productos me puedo encontrar en ella?</h6>
			<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
			tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
			quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
			consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
			cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
			proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>

			
			<a href="https://myanimelist.net/character/2514/Gilgamesh" target="_blank"><img class="prueba" src="imagenes\gil.jpg" width="380"></a>
			<a href="https://myanimelist.net/character/151143/Kyoujurou_Rengoku" target="_blank"><img class="prueba" src="imagenes\rengoku.jpg" width="380"></a>

			<p>
				Lorem ipsum dolor sit amet consectetur adipisicing elit. Distinctio sint natus dolorem quisquam ab animi dolorum voluptates quae ex sit, odio, aliquam veniam, adipisci. Nulla beatae, autem dolores deserunt fugiat?
			</p>
			<div class="separador">
				<hr class="espacio">
			</div>

			<!--Formulario para buscar productos segun el tipo, consta de un selector para elegir el tipo y un boton para realizar la busqueda-->
			<div class="busqueda">
				<form action="tienda.php" method="POST">
					<label>Selecciona el tipo de producto que quieres buscar</label>
					<select name="ele_producto" class="ele_produc">
			 			<option value="all">Todos</option>
						<option value="book">Libro</option>
						<option value="film">Pelicula</option>
						<option value="show">Serie</option>
					</select>
					<input type="submit" value="BUSCAR" name="Buscar" class="boton_buscar">
				</form>
			</div>

			<div class="grid-container-productos">
				<?php 
					
					$conexion=mysqli_connect('localhost','root','','shop') or die(mysqli_error());
					#si usarmos php 7.4 tenemos que ponerle antes un isset al $conexion
					if ($conexion) {
						#Aqui estan todas las consultas relacionadas con mostrar productos
						$resultado=mysqli_query($conexion,"SELECT * FROM libros");
						$consulta=mysqli_query($conexion,"SELECT * FROM peliculas");
						$request=mysqli_query($conexion,"SELECT * FROM series");
						
						#En este if detectamos que en el selector se ha seleccionado la opcion de TODOS por lo que se mostraran todos los productos
						if (isset($_POST['ele_producto']) && strcmp($_POST['ele_producto'], "all") ==0 ) {
							#Aqui mostramos los libros
							if ($resultado != FALSE) {
								while ($fila=mysqli_fetch_array($resultado)) {

									$imagen=$fila['imagen'];
									$titulo=$fila['titulo'];
									$autor=$fila['autor'];
									$editorial=$fila['editorial'];
									$precio=$fila['precio'];
									$tomo=$fila['tomo'];

									echo "
										<div class='producto'>
										";
											
									echo '
											<div><img src="data:image/jpg;base64,'.base64_encode($imagen).'" width="100px"/></div><br>
										';
									echo "
											<div class='texto'><b>Titulo: </b>",$titulo,"</div>
											<div class='texto'><b>Autor: </b>",$autor,"</div>
											<div class='texto'><b>Editorial: </b>",$editorial,"</div>
											<div class='texto'><b>Precio: </b>",$precio," €</div>
											<div class='texto'><b>Tomo: </b>",$tomo,"</div><br>
											<div class='texto'></div><br>
											<div class='texto'></div><br>
											<form method='POST' action='carrito.php'>
												<input type='hidden' name='titulo' value='",$titulo,"'><br>
												<input type='hidden' name='autor' value='",$autor,"'><br>
												<input type='hidden' name='editorial' value='",$editorial,"'><br>
												<input type='hidden' name='precio' value='",$precio,"'><br>
												<input type='hidden' name='tomo' value='",$tomo,"'><br>
												<input type='submit' name='comprar_libro' value='Comprar' class='compra_tienda'>
											</form>
										</div>
									";					
								}
							}
							
							#Aqui mostramos las peliculas
							if ($consulta != FALSE) {
								while ($fila=mysqli_fetch_array($consulta)) {
								
									$imagen=$fila['imagen'];
									$titulo=$fila['titulo'];
									$director=$fila['director'];
									$year=$fila['year'];
									$estudio=$fila['estudio'];
									$precio=$fila['precio'];
									$distribuidora=$fila['distribuidora'];

									echo "
										<div class='producto'>
										";
									echo '
											<div><img src="data:image/jpg;base64,'.base64_encode($imagen).'" width="100px"/></div><br>
										';
									echo "
											<div class='texto'><b>Titulo: </b>",$titulo,"</div>
											<div class='texto'><b>Director: </b>",$director,"</div>
											<div class='texto'><b>Año: </b>",$year,"</div>
											<div class='texto'><b>Estudio: </b>",$estudio,"</div>
											<div class='texto'><b>Distribuidora: </b>",$distribuidora,"</div>
											<div class='texto'><b>Precio: </b>",$precio," €</div><br>
											<form method='POST' action='carrito.php'>
												<input type='hidden' name='titulo' value='",$titulo,"'><br>
												<input type='hidden' name='director' value='",$director,"'><br>
												<input type='hidden' name='year' value='",$year,"'><br>
												<input type='hidden' name='estudio' value='",$estudio,"'><br>
												<input type='hidden' name='precio' value='",$precio,"'><br>
												<input type='hidden' name='distribuidora' value='",$distribuidora,"'><br>
												<input type='submit' name='comprar_peli' value='Comprar' class='compra_tienda'>
											</form>
										</div>
									";


								}
							}
							
							#Aqui mostramos las series
							if ($request != FALSE) {
								while ($fila=mysqli_fetch_array($request)) {
								
									$imagen=$fila['imagen'];
									$titulo=$fila['titulo'];
									$director=$fila['director'];
									$year=$fila['year'];
									$estudio=$fila['estudio'];
									$precio=$fila['precio'];
									$distribuidora=$fila['distribuidora'];
									$temporada=$fila['temporada'];
									
									echo "
										<div class='producto'>
										";
									echo '
											<div><img src="data:image/jpg;base64,'.base64_encode($imagen).'" width="100px"/></div><br>
										';
									echo "
											<div class='texto'><b>Titulo: </b>",$titulo,"</div>
											<div class='texto'><b>Director: </b>",$director,"</div>
											<div class='texto'><b>Año: </b>",$year,"</div>
											<div class='texto'><b>Estudio: </b>",$estudio,"</div>
											<div class='texto'><b>Distribuidora: </b>",$distribuidora,"</div>
											<div class='texto'><b>Precio: </b>",$precio," €</div>
											<div class='texto'><b>Temporada: </b>",$temporada,"</div><br>
											<form method='POST' action='carrito.php'>
												<input type='hidden' name='titulo' value='",$titulo,"'><br>
												<input type='hidden' name='director' value='",$director,"'><br>
												<input type='hidden' name='year' value='",$year,"'><br>
												<input type='hidden' name='estudio' value='",$estudio,"'><br>
												<input type='hidden' name='precio' value='",$precio,"'><br>
												<input type='hidden' name='distribuidora' value='",$distribuidora,"'><br>
												<input type='hidden' name='temporada' value='",$temporada,"'><br>
												<input type='submit' name='comprar_serie' value='Comprar' class='compra_tienda'>
											</form>
										</div>	
									";

								}
							}
						}

						#Aqui detectamos si en el buscador se ha elegido la opcion de LIBROS, por lo que solo mostraremos los libros
						if (isset($_POST['ele_producto']) && strcmp($_POST['ele_producto'], "book") ==0 ) {
							if ($resultado != FALSE) {
								while ($fila=mysqli_fetch_array($resultado)) {

									$imagen=$fila['imagen'];
									$titulo=$fila['titulo'];
									$autor=$fila['autor'];
									$editorial=$fila['editorial'];
									$precio=$fila['precio'];
									$tomo=$fila['tomo'];

									echo "
										<div class='producto'>
										";
											
									echo '
											<div><img src="data:image/jpg;base64,'.base64_encode($imagen).'" width="100px"/></div><br>
										';
									echo "
											<div class='texto'><b>Titulo: </b>",$titulo,"</div>
											<div class='texto'><b>Autor: </b>",$autor,"</div>
											<div class='texto'><b>Editorial: </b>",$editorial,"</div>
											<div class='texto'><b>Precio: </b>",$precio," €</div>
											<div class='texto'><b>Tomo: </b>",$tomo,"</div><br>
											<form method='POST' action='carrito.php'>
												<input type='hidden' name='titulo' value='",$titulo,"'><br>
												<input type='hidden' name='autor' value='",$autor,"'><br>
												<input type='hidden' name='editorial' value='",$editorial,"'><br>
												<input type='hidden' name='precio' value='",$precio,"'><br>
												<input type='hidden' name='tomo' value='",$tomo,"'><br>
												<input type='submit' name='comprar_libro' value='Comprar' class='compra_tienda'>
											</form>
										</div>
									";
								}
							}
						}

						#Aqui detectamos si en el buscador se ha elegido la opcion de PELICULAS, por lo que solo mostraremos las peliculas
						if (isset($_POST['ele_producto']) && strcmp($_POST['ele_producto'], "film") ==0 ) {
							if ($consulta != FALSE) {
								while ($fila=mysqli_fetch_array($consulta)) {
								
									$imagen=$fila['imagen'];
									$titulo=$fila['titulo'];
									$director=$fila['director'];
									$year=$fila['year'];
									$estudio=$fila['estudio'];
									$precio=$fila['precio'];
									$distribuidora=$fila['distribuidora'];

									echo "
										<div class='producto'>
										";
									echo '
											<div><img src="data:image/jpg;base64,'.base64_encode($imagen).'" width="100px"/></div><br>
										';
									echo "
											<div class='texto'><b>Titulo: </b>",$titulo,"</div>
											<div class='texto'><b>Director: </b>",$director,"</div>
											<div class='texto'><b>Año: </b>",$year,"</div>
											<div class='texto'><b>Estudio: </b>",$estudio,"</div>
											<div class='texto'><b>Distribuidora: </b>",$distribuidora,"</div>
											<div class='texto'><b>Precio: </b>",$precio," €</div><br>
											<form method='POST' action='carrito.php' class='form_tienda'>
												<input type='hidden' name='titulo' value='",$titulo,"'><br>
												<input type='hidden' name='director' value='",$director,"'><br>
												<input type='hidden' name='year' value='",$year,"'><br>
												<input type='hidden' name='estudio' value='",$estudio,"'><br>
												<input type='hidden' name='precio' value='",$precio,"'><br>
												<input type='hidden' name='distribuidora' value='",$distribuidora,"'><br>
												<input type='submit' name='comprar_peli' value='Comprar' class='compra_tienda'>
											</form>
										</div>
									";
								}
							}
						}

						#Aqui detectamos si en el buscador se ha elegido la opcion de SERIES, por lo que solo mostraremos las series
						if (isset($_POST['ele_producto']) && strcmp($_POST['ele_producto'], "show") ==0 ) {
							if ($request != FALSE) {
								while ($fila=mysqli_fetch_array($request)) {
								
									$imagen=$fila['imagen'];
									$titulo=$fila['titulo'];
									$director=$fila['director'];
									$year=$fila['year'];
									$estudio=$fila['estudio'];
									$precio=$fila['precio'];
									$distribuidora=$fila['distribuidora'];
									$temporada=$fila['temporada'];
									
									echo "
										<div class='producto'>
										";
									echo '
											<div><img src="data:image/jpg;base64,'.base64_encode($imagen).'" width="100px"/></div><br>
										';
									echo "
											<div class='texto'><b>Titulo: </b>",$titulo,"</div>
											<div class='texto'><b>Director: </b>",$director,"</div>
											<div class='texto'><b>Año: </b>",$year,"</div>
											<div class='texto'><b>Estudio: </b>",$estudio,"</div>
											<div class='texto'><b>Distribuidora: </b>",$distribuidora,"</div>
											<div class='texto'><b>Precio: </b>",$precio," €</div>
											<div class='texto'><b>Temporada: </b>",$temporada,"</div><br>
											<form method='POST' action='carrito.php'>
												<input type='hidden' name='titulo' value='",$titulo,"'><br>
												<input type='hidden' name='director' value='",$director,"'><br>
												<input type='hidden' name='year' value='",$year,"'><br>
												<input type='hidden' name='estudio' value='",$estudio,"'><br>
												<input type='hidden' name='precio' value='",$precio,"'><br>
												<input type='hidden' name='distribuidora' value='",$distribuidora,"'><br>
												<input type='hidden' name='temporada' value='",$temporada,"'><br>
												<input type='submit' name='comprar_serie' value='Comprar' class='compra_tienda'>
											</form>
										</div>	
									";
								}
							}	
						}
					}

					
				?>
			</div>

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
</body>
</html>