<!doctype html>
<html>

<head>
	<meta charset="utf-8">
	<title>Transfiriendo a portal de pagos..</title>
</head>

<body>
	<?php
	$correo = $_POST['field'];
	$numerofac = $_POST['numerofac'];
	$valor = $_POST['valor'];


	$sign = md5('xlex99bM7AgHr0Akj82YA8Vtus~733284~' . $numerofac . '~' . $valor . '~COP');
	echo '<form name ="go" id="go" action="https://checkout.payulatam.com/ppp-web-gateway-payu/" method="post">
					 <input name="merchantId"    type="hidden"  value="733284"   >
					  <input name="accountId"     type="hidden"  value="738315" >
					  <input name="description"   type="hidden"  value="Pago de Factura - Redplanet"  >
					  <input name="referenceCode" type="hidden"  value="' . $numerofac . '" >
					  <input name="amount"        type="hidden"  value="' . $valor . '"   >
					  <input name="tax"           type="hidden"  value="0"  >
					  <input name="taxReturnBase" type="hidden"  value="0" >
					  <input name="currency"      type="hidden"  value="COP" >
					  <input name="signature"     type="hidden"  value="' . $sign . '"  >
					  <input name="test"          type="hidden"  value="0" >
					  <input name="buyerEmail"    type="hidden"  value="' . $correo . '" >
					  <input name="responseUrl"    type="hidden"  value="http://red-planet.com.co/pago/response.php" >
					  <input name="confirmationUrl"    type="hidden"  value="http://red-planet.com.co/pago/approved.php" >

					 </form>
					 
					 ';



	?>
	<script type="text/javascript">
		document.getElementById('go').submit();
	</script>
</body>

</html>