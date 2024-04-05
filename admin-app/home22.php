<?php
require('session.php');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Control de Inventario</title>
	<link href="https://fonts.googleapis.com/css2?family=Open+Sans&family=Roboto:wght@100;400;700&display=swap" rel="stylesheet">
	<link href="css/general.css" rel="stylesheet">
	<style type="text/css">


	</style>
</head>

<body>




	<?php




	/* Select products */
	$facts = $conn->prepare("SELECT * FROM facturas WHERE pagada='no'");
	$facts->execute();
	$result = $facts->fetch();

	if (!empty($result)) {
		// output data of each row


		while ($row = $facts->fetch()) {
			$sqlcliente = $conn->prepare("SELECT * FROM clientes WHERE idclientes =?");
			$idcli = $row["cliente"];
			$sqlcliente->execute(array($idcli));
			$cliente = $sqlcliente->fetch();


			$valor = number_format($row["valor"], 0, ".", ".");
			echo "<a href='edit.php?id=" . $row["idfacturas"] . "'>Editar</a>" . ', ' . $row["idfacturas"] . ', ' . $cliente["nombre"] . ', ' . $row["numero"] . ', $' . $valor . ', ' . $row["pagada"] . ', ' . "<a href='home.php?del=" . $row["idfacturas"] . "'>Borrar</a>" . '<br>';
		}
	}

	?>
	<br />
	<br /><br />
	Nueva Factura:<br /><br />


	<form action="" method="post" name="nuevafactura">
		<select name="cliente">
			<option value="" disabled selected hidden>Seleccione cliente</option>
			<?php

			$cl = $conn->prepare("SELECT * FROM clientes");
			$cl->execute();
			while ($clrow = $cl->fetch()) {

				echo "<option value='" . $clrow["idclientes"] . "'>"  . $clrow["nombre"] . "</option>";
			}
			?>



		</select><br /><br />

		<input name="numero" type="text" placeholder="Numero de Factura" /><br /><br />
		<input name="valor" type="text" placeholder="Valor a pagar" /><br /><br />
		<input name="ingresar" type="submit" value="Ingresar Factura" /><br /><br />
		<?php
		if (isset($_POST['ingresar'])) {
			if ((!empty($_POST['cliente']))) {
				$clid = $_POST['cliente'];
				$pvalor = $_POST['valor'];
				$pnumero = $_POST['numero'];
				if ((!empty($clid)) && (!preg_match('/[^A-Za-z0-9]/', $clid)) && (!empty($pvalor)) && (is_numeric($pvalor)) && (!empty($pnumero)) && (is_numeric($pnumero))) {
					$clid = $_POST['cliente'];
					$pvalor = $_POST['valor'];
					$pnumero = $_POST['numero'];
					$vercl = $conn->prepare("SELECT * FROM clientes WHERE idclientes= ' $clid '");
					$vercl->execute();
					$vercli = $vercl->fetch();

					if (!empty($vercli)) {

						$insfac = $conn->prepare("INSERT INTO facturas (valor, cliente, numero, pagada) VALUES (?, ?, ?, 'no')");
						$insfac->execute(array($pvalor, $clid, $pnumero));

						header('Location: home.php');
					} else {
						echo "Cliente invalido";
					}
				} else {
					echo "Entrada invalida";
				}
			} else {
				echo "Seleccione cliente";
			}
		}
		?>
	</form><br />




	<br />
	<br /><br />
	Nuevo cliente:<br /><br />


	<form action="" method="post" name="nuevocliente">
		<select name="tipodoc">
			<option value="" disabled selected hidden>Seleccione tipo de ID</option>
			<?php
			$cl2 = $conn->prepare("SELECT * FROM ids");
			$cl2->execute();
			while ($clrow2 = $cl2->fetch()) {

				echo "<option value='" . $clrow2["ids"] . "'>"  . $clrow2["tipo"] . "</option>";
			}
			?>



		</select><br /><br />

		<input name="numerodoc" type="text" placeholder="Numero de identificación" /><br /><br />
		<input name="nombrecl" type="text" placeholder="Nombre completo" /><br /><br />
		<input name="ingresarc" type="submit" value="Ingresar Cliente" />
		<?php
		if (isset($_POST['ingresarc'])) {
			if ((!empty($_POST['tipodoc'])) and (!empty($_POST['numerodoc'])) and (!empty($_POST['nombrecl']))) {
				$tipodoc = $_POST['tipodoc'];
				$numerodoc = $_POST['numerodoc'];
				$nombrecl = $_POST['nombrecl'];

				if ((ctype_alpha(str_replace(' ', '', $nombrecl)) === true) && (is_numeric($numerodoc))) {

					$ncliente = $conn->prepare("INSERT INTO clientes (tipoid, id, nombre) VALUES (?, ?, ?)");
					$ncliente->execute(array($tipodoc, $numerodoc, $nombrecl));

					header('Location: home.php');
				} else {
					echo "<br />Entrada invalida";
				}
			} else {
				echo "<br />Todos los campos deben estar completos";
			}
		}
		?>
	</form><br />




	<a href="pagadas.php"><input name="pagadas" type="submit" value="Ver Facturas Pagadas" /></a>
	<br /><br />
	<a href="search.php"><input name="buscar" type="submit" value="Buscar Facturas" /></a>
	<br /><br />
	<form action="logout.php" method="post">
		<input name="logout" type="submit" value="Salir" />
	</form>

</body>

</html>