<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Carrito</title>
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
						 	
						 	<p>
						 		<?php echo "Hola, ".$_SESSION['user'].""; ?>
							</p>
							<form method="POST" action="carrito.php" class="salir">
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
			
			<p>Tienes los siguientes productos en tu carrito de la compra:</p>
			<br>
			<div class="grid-productos-carrito">
				<div class="grid-muestra-productos">
					<?php 
						$conexion=mysqli_connect('localhost','root','','shop') or die(mysqli_error());
						#si usarmos php 7.4 tenemos que ponerle antes un isset al $conexion
						if ($conexion){		
							#Con este if estamos indicando que solo se introduciran y mostraran los productos del carrito si hay un usuario conectado					
							if (isset($_SESSION['user'])) {
							$usuario=$_SESSION['user'];
							
							#en esta consulta seleccionamos todos los productos de la tabla precios cuyo
							$comprobacion=mysqli_query($conexion,"SELECT * FROM precios WHERE usuario='{$usuario}' ");
							$precio_total=mysqli_query($conexion,"SELECT SUM(precio) FROM precios WHERE usuario='{$usuario}' ");
							

							
							#Aqui se insertan los libros en la tabla precios
							if (isset($_POST['comprar_libro'])) {
								$tit=$_POST['titulo'];
								$pre=$_POST['precio'];

								#aqui seleccionamos el precio del producto de la tabla correspondiente
								$comprobacion_precio2=mysqli_query($conexion,"SELECT precio,titulo FROM libros WHERE titulo='{$tit}'");
								
								if ($comprobacion_precio2 != FALSE) {
								
									while ($var=mysqli_fetch_array($comprobacion_precio2)) {
										$comprobar=$var['precio'];
										$comprobar_titulo=$var['titulo'];
										#aqui comparamos el precio y nombre del producto enviados con los correspondientes en la base de datos; en caso de no coincidir se muestra un mensaje de error
										if ((strcmp($pre, $comprobar)==0)&&(strcmp($tit, $comprobar_titulo)==0)) {
											$consulta1=mysqli_query($conexion,"INSERT INTO precios (nombre,precio,usuario) VALUES ('{$tit}','{$pre}','{$usuario}')");
											header("Location: carrito.php");
										}
										else {
											#este es el mensaje de error, a los 5 segundos te redirecciona a la pagina de la tienda
											echo "SE HA PRODUCIDO UN ERROR";
											header("refresh:5;url=tienda.php");

										}
									}
								}
							}

						

							if (isset($_POST['comprar_peli'])) {

								$tit=$_POST['titulo'];
								$pre=$_POST['precio'];
								$comprobacion_precio2=mysqli_query($conexion,"SELECT precio,titulo FROM peliculas WHERE titulo='{$tit}'");
								
								if ($comprobacion_precio2 != FALSE) {
								

									while ($var=mysqli_fetch_array($comprobacion_precio2)) {
										$comprobar=$var['precio'];
										$comprobar_titulo=$var['titulo'];
										if ((strcmp($pre, $comprobar)==0)&&(strcmp($tit, $comprobar_titulo)==0)) {
											$consulta1=mysqli_query($conexion,"INSERT INTO precios (nombre,precio,usuario) VALUES ('{$tit}','{$pre}','{$usuario}')");
											header("Location: carrito.php");
										}
										else {
											echo "SE HA PRODUCIDO UN ERROR";
											header("refresh:5;url=tienda.php");
										}
									}
								}

							}

							if (isset($_POST['comprar_serie'])) {
								$tit=$_POST['titulo'];
								$pre=$_POST['precio'];
								$comprobacion_precio3=mysqli_query($conexion,"SELECT precio,titulo FROM series WHERE titulo='{$tit}'");
								
								if ($comprobacion_precio3 != FALSE) {
								

									while ($var=mysqli_fetch_array($comprobacion_precio3)) {
										$comprobar=$var['precio'];
										$comprobar_titulo=$var['titulo'];
										if ((strcmp($pre, $comprobar)==0)&&(strcmp($tit, $comprobar_titulo)==0)) {
											$consulta1=mysqli_query($conexion,"INSERT INTO precios (nombre,precio,usuario) VALUES ('{$tit}','{$pre}','{$usuario}')");
											header("Location: carrito.php");
										}
										else {
											echo "SE HA PRODUCIDO UN ERROR";
											header("refresh:5;url=tienda.php");
										}
									}
								}
							}

							
							#Aqui mostramos los productos que hay en el carrito
							else {
									while ($fila=mysqli_fetch_array($comprobacion)) {
										$nombre_producto=$fila['nombre'];
										$precio_producto=$fila['precio'];
										echo "
											<div class='mostrar-producto'>
												<div class='imagen-producto'>";

										echo "<img class='prueba' src='imagenes\productos\_".$nombre_producto.".jpg' height='148'>";
										echo "
												</div>
												<div class='texto-producto'>
													<ul>
														<li class='text-product'><b>Titulo: </b>".$nombre_producto."</li>
														<li class='text-product'><b>Precio: </b>".$precio_producto." €</li>
													</ul>			
												</div>
											</div>
										";
									}
								}

					?>
				</div>



				<div class="carrito-espacio">
					<?php 
							#Aqui mostramos el valor total de la compra
							if ($precio_total != FALSE) {
								while ($total=mysqli_fetch_array($precio_total)) {
									$tot=$total['SUM(precio)'];
									echo "
									<div class='texto-total-producto'>
										<p><b>Precio total de tu compra: ".$tot." €</b></p>
									</div>
									";
								}
							}

							#Aqui eliminamos los productos del carrito, mostramos un mensaje informativo y refrescamos la pagina tras 3 segundos. EL primer if corresponde al boton de eliminar productos y el segundo al de tramitar tu compra
							if (isset($_POST['delete_all'])) {
								$usuario=$_SESSION['user'];
								 $deletear=mysqli_query($conexion,"DELETE FROM precios WHERE usuario='{$usuario}' ");
								 echo "Se estan eliminando los productos de tu carrito";
								 header("refresh:3;url=carrito.php");
							}

							
							if (isset($_POST['fake_buy'])) {
								if ((strcmp($_POST['name_user'],'')==0)&&(strcmp($_POST['number_user'],'')==0)&&(strcmp($_POST['address_user'],'')==0)) {
									echo "ERROR. Debes rellenar los campos del formulario";
								}
								else {
								$usuario=$_SESSION['user'];
								$deletear=mysqli_query($conexion,"DELETE FROM precios WHERE usuario='{$usuario}' ");
								echo "Se ha tramitado tu compra";
								header("refresh:3;url=carrito.php");
								}
							}

							

						}

						#Este es el mensaje de error que se muestra cuando no se ha iniciado sesion
						else {
							echo "
									<div class='mostrar-producto'>
										<div class='imagen-producto'></div>
										<div class='texto-producto'>
											<ul>
												<li class='text-product'><b>Debes iniciar sesión para poder añadir un producto al carrito </b></li>
											</ul>										
										</div>
									</div>
								</div>
								<div class='carrito-espacio'>
									<div class='texto-total-producto'>
										<p><b>Precio total de tu compra: 0 €</b></p>
									</div>

							";
						}

					}
						
						
						#Este es el formulario para introducir los datos del usuario

						echo "
								<form method='POST' action='carrito.php' class='datos_user'>
									<label><b>Nombre</b></label><br>
									<input type='text' name='name_user'><br>
									<label><b>Nº tarjeta</b></label><br>
									<input type='text' name='number_user'><br>
									<label><b>Dirección</b></label><br>
									<textarea name='address_user' rows='5'></textarea><br>
									<input type='submit' name='fake_buy' value='TRAMITAR COMPRA'class='fake_buy_items'><br>
									<input type='submit' name='delete_all' value='ELIMINAR TODO' class='delete_all_items'><br>
								</form>

						";
					?>
							
				</div>
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