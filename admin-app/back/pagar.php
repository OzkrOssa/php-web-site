<?php
require('dbcon.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link href="https://fonts.googleapis.com/css2?family=Open+Sans&family=Roboto:wght@100;400;700&display=swap" rel="stylesheet">
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-mousewheel/3.1.13/jquery.mousewheel.min.js"></script>
	<link href="css/generalc.css" rel="stylesheet">
	<title>RED PLANET</title>
	<style type="text/css">
		#passcont {

			width: 100%;
			height: 100%;
			margin: auto;
			top: 0px;
			bottom: 0px;
			left: 0px;
			right: 0px;
		}

		/* Style the tab */
		.tab {
			overflow: hidden;
			/* border: 1px solid #ccc; */
			background-color: #ce8585;
		}

		/* Style the buttons that are used to open the tab content */
		.tab button {
			background-color: inherit;
			float: left;
			border: none;
			outline: none;
			cursor: pointer;
			padding: 14px 16px;
			transition: 0.3s;
			width: 200px;
			color: white;
			font-weight: bold;
		}

		/* Change background color of buttons on hover */
		.tab button:hover {
			background-color: #ec5757;
		}

		/* Create an active/current tablink class */
		.tab button.active {
			background-color: #f16060;
		}

		/* Style the tab content */
		.tabcontent {
			display: none;
			padding: 60px 100px;
			border: 1px solid #ccc;
			border-top: none;
		}

		.nombre {
			font-size: 27px;
			font-weight: bold;
			color: #544f4f;
		}

		.info {
			color: #544f4f;
			font-size: 16px;
		}
	</style>

</head>

<body>
	<div id="containeri">

		<div id="elementcont">
			<div id="usercont">
				<div id="passcont" style="font-size: 20px; text-align: center;">
					<h1 style="text-align: center; margin-top: 0px; color: #e02b33;">
						<img src="images/nuevo_logo.png" width="330" height="65" alt="" />
					</h1>
					<h1 style="text-align: center; color: #f16060;">
						Consultar Factura </h1></br>
					<?php
					header('Content-Type: text/html; charset=UTF-8');
					require('dbcon.php');
					$metodo = $_POST['metodo'];

					if ($metodo == 1) {
						$numerofac = $_POST['numerofac'];

						$verfac = $conn->prepare("SELECT * FROM facturas WHERE numero=?");
						$verfac->execute(array($numerofac));
						$verfactu = $verfac->fetch();

						if (!empty($verfactu)) {
							$idcliente = $verfactu["cliente"];
							$vercl = $conn->prepare("SELECT * FROM clientes WHERE idclientes=?");
							$vercl->execute(array($idcliente));
							$vercli = $vercl->fetch();
							$valor = number_format($verfactu["valor"], 0, ".", ".");
							$locale = 'en_ES.utf8';
							setlocale(LC_ALL, $locale);
							$fecha = strftime("%A %d de %B del %Y", strtotime($verfactu["fechapago"]));
							$sign = md5('4Vj8eK4rloUd272L48hsrarnUA~508029~' . $numerofac . '~' . $verfactu["valor"] . '~COP');
							echo "<span class='nombre'>" . $vercli["nombre"] . '</span></br></br><span class="b">Numero de Factura:</span> <span class="info">' . $numerofac . "</span></br></br><span class='b'>Su valor a pagar es:</span> <span class='info'><b>$" . $valor . "</b></span></br></br> <span class='b'>Fecha de Pago: </span> <span class='info'>"  . $fecha . "</span></br></br>" . '</br><span class="b">Correo de notificación: </span></br></br> <form action="bridge.php" method="post" id="formcorreo"><input name="field" id="field"  type="text" placeholder="Ingrese su correo*"/></br></br></br>'
								. '
							 <input name="numerofac"    type="hidden"  value="' . $numerofac  . '"   >
							  <input name="valor"     type="hidden"  value="' . $verfactu["valor"] . '" >
							  
							  <input id ="pagar" name="pagar1" type="submit" value="Pagar Ahora" />

							 </form>';
						} else {
							echo "<span class='b'>No se encontraron facturas con el numero ingresado.</span></br></br>
								<a href='consultar.php'><input type='submit' value='Volver' /></a>
							";
						}
					}
					if ($metodo == 2) {
						$numeroid = $_POST['numeroid'];
						$tipoid = $_POST['tipoid'];
						$vercl = $conn->prepare("SELECT * FROM clientes WHERE id=? AND tipoid=?");
						$vercl->execute(array($numeroid, $tipoid));
						$vercli = $vercl->fetch();
						if (!empty($vercli)) {
							$verfac = $conn->prepare("SELECT * FROM facturas WHERE cliente=?");
							$verfac->execute(array($vercli["idclientes"]));
							$verfactu = $verfac->fetch();

							if (!empty($verfactu)) {
								$valor = number_format($verfactu["valor"], 0, ".", ".");
								$locale = 'en_ES.utf8';
								setlocale(LC_ALL, $locale);
								$fecha = strftime("%A %d de %B del %Y", strtotime($verfactu["fechapago"]));
								$sign = md5('4Vj8eK4rloUd272L48hsrarnUA~508029~' . $verfactu["numero"] . '~' . $verfactu["valor"] . '~COP');
								echo "<span class='nombre'>" . $vercli["nombre"] . '</span></br></br><span class="b">Numero de Factura:</span> <span class="info">' . $verfactu["numero"] . "</span></br></br><span class='b'>Su valor a pagar es:</span> <span class='info'><b>$" . $valor . "</b></span></br></br> <span class='b'>Fecha de Pago: </span> <span class='info'>"  . $fecha . "</span></br></br>" . '</br><span class="b">Correo de notificación: </span></br></br> <form action="bridge.php" method="post" id="formcorreo"><input name="field" id="field"  type="text" placeholder="Ingrese su correo*"/></br></br></br>'
									. '
											 <input name="numerofac"    type="hidden"  value="' . $verfactu["numero"]  . '"   >
											  <input name="valor"     type="hidden"  value="' . $verfactu["valor"] . '" >

											  <input id ="pagar" name="pagar1" type="submit" value="Pagar Ahora" />

											 </form>';
							} else {
								echo "<span class='b'>No se encontraron facturas asociadas al documento ingresado</span></br></br>
								<a href='consultar.php'><input type='submit' value='Volver' /></a>";
							}
						} else {
							echo "<span class='b'>No se encontraron clientes con el documento ingresado</span></br></br>
								<a href='consultar.php'><input type='submit' value='Volver' /></a>";
						}
					}

					?>

				</div>
				<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
				<script src="js/jquery.validate.min.js"></script>
				<script src="js/additional-methods.min.js"></script>
				<script>
					// just for the demos, avoids form submit

					$("#formcorreo").validate({
						rules: {
							field: {
								required: true,
								email: true
							}
						}
					});
				</script>
			</div>
			<div id="usercont" style="background-image: url(images/woman.jpg); background-size: cover;">
			</div>
		</div>
	</div>




</body>

</html>