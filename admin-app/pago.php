<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Control de Inventario</title>
	<link rel="stylesheet" type="text/css" href="css/TopBar.css">
	<style type="text/css">


	</style>
</head>

<body>



	<form action="" method="post" name="buscarfactura">
		Consultar factura por numero de identificación:<br /><br />
		<select name="id">
			<?php

			$cl = "SELECT * FROM ids";
			$sqlcl = $conn->query($cl);
			while ($clrow = $sqlcl->fetch_assoc()) {

				echo "<option " . "value='" . $clrow["ids"] . "'>"  . $clrow["tipo"] . "</option>";
			}
			?>



		</select><br /><br />

		<input name="numero" type="text" placeholder="Numero de identificación" /><br /><br />
		<input name="buscar" type="submit" value="Buscar" />

	</form><br /><br />
	<?php
	if (isset($_POST['buscar'])) {
		$pid = $_POST['id'];
		$pnumero = $_POST['numero'];
		$cliente = "SELECT * FROM clientes WHERE tipoid ='" . $pid . "' AND id='" . $pnumero . "'";
		$resultc = $conn->query($cliente);
		$clientec = $resultc->fetch_assoc();

		$factura = "SELECT * FROM facturas WHERE cliente ='" . $clientec["idclientes"] . "' AND pagada='no' ORDER BY idfacturas DESC LIMIT 1";
		$resultf = $conn->query($factura);
		if ($resultf->num_rows > 0) {
			$row = $resultf->fetch_assoc();
			$valor = number_format($row["valor"], 0, ".", ".");
			$sign = md5('4Vj8eK4rloUd272L48hsrarnUA~508029~' . $row["numero"] . '~' . $row["valor"] . '~COP');
			echo $clientec["nombre"] . '<br>Factura numero: ' . $row["numero"] . '<br>Su valor a pagar es:  $' . $valor  . '<br>'
				. '<form action="https://sandbox.checkout.payulatam.com/ppp-web-gateway-payu/" method="post">
					 <input name="merchantId"    type="hidden"  value="508029"   >
					  <input name="accountId"     type="hidden"  value="512321" >
					  <input name="description"   type="hidden"  value="Test PAYU"  >
					  <input name="referenceCode" type="hidden"  value="' . $row["numero"] . '" >
					  <input name="amount"        type="hidden"  value="' . $row["valor"] . '"   >
					  <input name="tax"           type="hidden"  value="0"  >
					  <input name="taxReturnBase" type="hidden"  value="0" >
					  <input name="currency"      type="hidden"  value="COP" >
					  <input name="signature"     type="hidden"  value="' . $sign . '"  >
					  <input name="test"          type="hidden"  value="1" >
					  <input name="buyerEmail"    type="hidden"  value="test@test.com" >
					  <input name="responseUrl"    type="hidden"  value="http://www.test.com/response" >
					  <input name="confirmationUrl"    type="hidden"  value="http://www.test.com/confirmation" >
					  <input name="pagar1" type="submit" value="Pagar Ahora" />

					 </form>';
		} else {
			echo "No se encontraron registros. <br>";
		}
	}
	?> <br />









	<form action="" method="post" name="buscarfactura">
		Buscar por numero de factura:<br /><br />


		<input name="numero" type="text" placeholder="Numero de factura" /><br /><br />
		<input name="buscarf" type="submit" value="Buscar" />

	</form><br /><br />
	<?php
	if (isset($_POST['buscarf'])) {
		$pnumero = $_POST['numero'];


		$factura = "SELECT * FROM facturas WHERE numero ='" . $pnumero . "' AND pagada='no' ORDER BY idfacturas DESC LIMIT 1";
		$resultf = $conn->query($factura);
		if ($resultf->num_rows > 0) {
			$row2 = $resultf->fetch_assoc();
			$cliente2 = "SELECT * FROM clientes WHERE idclientes='" . $row2["cliente"] . "'";
			$resultc2 = $conn->query($cliente2);
			$clientec2 = $resultc2->fetch_assoc();
			$valor2 = number_format($row2["valor"], 0, ".", ".");
			$sign2 = md5('4Vj8eK4rloUd272L48hsrarnUA~508029~' . $row2["numero"] . '~' . $row2["valor"] . '~COP');
			echo $clientec2["nombre"] . '<br>Factura numero: ' . $row2["numero"] . '<br>Su valor a pagar es:  $' . $valor2  . '<br>'
				. '<form action="https://sandbox.checkout.payulatam.com/ppp-web-gateway-payu/" method="post">
					 <input name="merchantId"    type="hidden"  value="508029"   >
					  <input name="accountId"     type="hidden"  value="512321" >
					  <input name="description"   type="hidden"  value="Test PAYU"  >
					  <input name="referenceCode" type="hidden"  value="' . $row2["numero"] . '" >
					  <input name="amount"        type="hidden"  value="' . $row2["valor"] . '"   >
					  <input name="tax"           type="hidden"  value="0"  >
					  <input name="taxReturnBase" type="hidden"  value="0" >
					  <input name="currency"      type="hidden"  value="COP" >
					  <input name="signature"     type="hidden"  value="' . $sign2 . '"  >
					  <input name="test"          type="hidden"  value="1" >
					  <input name="buyerEmail"    type="hidden"  value="test@test.com" >
					  <input name="responseUrl"    type="hidden"  value="http://www.test.com/response" >
					  <input name="confirmationUrl"    type="hidden"  value="http://www.test.com/confirmation" >
					  <input name="pagar2" type="submit" value="Pagar Ahora" />

					 </form>';
		} else {
			echo "No se encontraron registros.";
		}
	}
	?> <br />




	<a href="home.php"><input name="home" type="submit" value="Volver" /></a>

</body>

</html>