<?php
require('session.php');

?>
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




	<?php




	/* Select products */
	$sql = "SELECT * FROM facturas WHERE pagada='si'";
	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
		// output data of each row


		while ($row = $result->fetch_assoc()) {
			$sqlcliente = "SELECT * FROM clientes WHERE idclientes ='" . $row["cliente"] . "'";
			$result2 = $conn->query($sqlcliente);
			$cliente = $result2->fetch_assoc();
			$valor = number_format($row["valor"], 0, ".", ".");
			echo $row["idfacturas"] . ', ' . $cliente["nombre"] . ', ' . $row["numero"] . ', $' . $valor . ', ' . $row["pagada"] . ', ' . "<a href='pagadas.php?del=" . $row["idfacturas"] . "'>Borrar</a>" . '<br>';
		}
	}

	?><br />


	<a href="home.php"><input name="home" type="submit" value="Volver" /></a>

</body>

</html>