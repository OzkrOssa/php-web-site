<?php
require('dbcon.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link href="https://fonts.googleapis.com/css2?family=Open+Sans&family=Roboto:wght@100;400;700&display=swap" rel="stylesheet">
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-mousewheel/3.1.13/jquery.mousewheel.min.js"></script>
	<link href="css/generalc.css" rel="stylesheet">
	<title>RED PLANET</title>
	<style type="text/css">
		#passcont {
			width: 350px;
			height: 480px;
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
			background-color: #8224e3;
		}

		/* Style the buttons that are used to open the tab content */
		button.tablinks.active {
			background-color: inherit;
			float: left;
			border: none;
			outline: none;
			cursor: pointer;
			padding: 14px 16px;
			transition: 0.3s;
			width: 175px;
			height: 60px;
			color: #9700fd;
			font-weight: bold;
			font-size: 13px;
		}

		button.tablinks {
			background-color: inherit;
			float: left;
			border: none;
			outline: none;
			cursor: pointer;
			padding: 14px 16px;
			transition: 0.3s;
			width: 175px;
			height: 60px;
			color: #f8b002;
			font-weight: bold;
			font-size: 13px;
		}

		/* Create an active/current tablink class */
		.tab button.active {
			background-color: #f8b002;
		}

		/* Style the tab content */
		.tabcontent {
			display: none;
			padding: 70px 20px;
			border: 1px solid #ccc;
			border-top: none;
			height: 130px;
		}
	</style>

</head>

<body>
	<div id="containeri">

		<div id="elementcont">
			<div id="usercont" style="background-image: url(images/fondo2.jpg);
    background-size: cover;">

				<div id="passcont" style=" text-align: center;">
					<h1 style="text-align: center; margin-top: 0px; color: #e02b33;">
					</h1>
					<h1 style="text-align: center; color: #9b51e0;">
						Consultar Factura </h1>
					<span style="color:#848484;">Consulte su valor a pagar por numero de factura o numero de identificacion y realice su pago en linea.</span></br></br>
					<div class="tab">
						<button class="tablinks active" onclick="openCity(event, 'London')">Numero de factura</button>
						<button class="tablinks" onclick="openCity(event, 'Paris')">Numero de Identificación</button>
					</div>

					<!-- Tab content -->
					<div id="London" class="tabcontent" style="display: block;">
						<form name="metodo1" action="pagar.php" method="post">

							<input name="metodo" type="hidden" value="1" />
							<input name="numerofac" id="numerofac" type="text" placeholder="Numero de factura" required />
							<br />
							<br /><br />


							<div class="center">
								<input type="submit" name="consultar" id="Entrar" value="Consultar" />
							</div>

						</form>


					</div>

					<div id="Paris" class="tabcontent">
						<form id="metodo2" action="pagar.php" method="post">
							<input name="metodo" type="hidden" value="2" />
							<select class="selct" name="tipoid" id="field" required>
								<option value="" disabled selected hidden>Tipo de Identificación</option>
								<?php

								$cl = $conn->prepare("SELECT * FROM ids");
								$cl->execute();
								while ($clrow = $cl->fetch()) {

									echo "<option value='" . $clrow["ids"] . "'>"  . $clrow["tipo"] . "</option>";
								}
								?>



							</select>

							<br /><br />
							<input name="numeroid" id="field" type="text" placeholder="Numero de indentificacion" required />
							<br />
							<br /><br />


							<div class="center">
								<input type="submit" name="consultar2" id="Entrar" value="Consultar" />
							</div>

						</form>
					</div>
					<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
					<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
					<script src="jhttps://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/additional-methods.min.js"></script>
					<script>
						// just for the demos, avoids form submit

						$("#metodo2").validate({
							rules: {
								numeroid: {
									required: true
								}

							}
						});
						$("#metodo1").validate({
							rules: {
								numerofac: {
									required: true,
									number: true
								}

							}
						});
					</script>

				</div>

			</div>
			<div id="usercont" style="background-image: url(images/fondo1.jpg); background-size: cover;">
			</div>
		</div>

		<script>
			function openCity(evt, cityName) {
				// Declare all variables
				var i, tabcontent, tablinks;

				// Get all elements with class="tabcontent" and hide them
				tabcontent = document.getElementsByClassName("tabcontent");
				for (i = 0; i < tabcontent.length; i++) {
					tabcontent[i].style.display = "none";
				}

				// Get all elements with class="tablinks" and remove the class "active"
				tablinks = document.getElementsByClassName("tablinks");
				for (i = 0; i < tablinks.length; i++) {
					tablinks[i].className = tablinks[i].className.replace(" active", "");
				}

				// Show the current tab, and add an "active" class to the button that opened the tab
				document.getElementById(cityName).style.display = "block";
				evt.currentTarget.className += " active";
			}
		</script>


</body>

</html>