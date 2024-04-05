<?php
session_start();
require('dbcon.php');
if ($_SESSION["token"] == 1) {
} else {
	header('Location: index.php');
}
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


	Buscar Factura:<br /><br />


	<form action="" method="post" name="buscarfactura">
		Buscar por:<br /><br />
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

		$factura = "SELECT * FROM facturas WHERE cliente ='" . $clientec["idclientes"] . "'";
		$resultf = $conn->query($factura);
		if ($resultf->num_rows > 0) {
			while ($row = $resultf->fetch_assoc()) {

				echo "<a href='edit.php?id=" . $row["idfacturas"] . "'>Editar</a>" . ', ' . $row["idfacturas"] . ', ' . $clientec["nombre"] . ', ' . $row["numero"] . ', $' . $row["valor"] . ', ' . $row["pagada"] . ', ' . "<a href='home.php?del=" . $row["idfacturas"] . "'>Borrar</a>" . '<br>';
			}
		} else {
			echo "No se encontraron registros.";
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


		$factura = "SELECT * FROM facturas WHERE numero ='" . $pnumero . "'";
		$resultf = $conn->query($factura);
		if ($resultf->num_rows > 0) {
			while ($row = $resultf->fetch_assoc()) {
				$cliente2 = "SELECT * FROM clientes WHERE idclientes='" . $row["cliente"] . "'";
				$resultc2 = $conn->query($cliente2);
				$clientec2 = $resultc2->fetch_assoc();
				echo "<a href='edit.php?id=" . $row["idfacturas"] . "'>Editar</a>" . ', ' . $row["idfacturas"] . ', ' . $clientec2["nombre"] . ', ' . $row["numero"] . ', $' . $row["valor"] . ', ' . $row["pagada"] . ', ' . "<a href='home.php?del=" . $row["idfacturas"] . "'>Borrar</a>" . '<br>';
			}
		} else {
			echo "No se encontraron registros.";
		}
	}
	?> <br />




	<a href="home.php"><input name="home" type="submit" value="Volver" /></a>

</body>

</html>