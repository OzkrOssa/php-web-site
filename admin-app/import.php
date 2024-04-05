<?php
require('dbcon.php');
$row = 1;

$fileName = $_FILES["file"]["tmp_name"];

if ($_FILES["file"]["size"] > 0) {

	$file = fopen($fileName, "r");

	while (($column = fgetcsv($file, 100000, ";")) !== FALSE) {


		if ($row == 1) {
			$row++;
		} else {

			if (isset($column[0])) {
				$nombre = $column[0];
			}


			$tipo = "";
			if (isset($column[1])) {
				$tipo = $column[1];
			}
			$iden = "";
			if (isset($column[2])) {
				$iden = $column[2];
			}
			$factura = "";
			if (isset($column[3])) {
				$factura = $column[3];
			}
			$contrato = "";
			if (isset($column[4])) {
				$contrato = $column[4];
			}
			$valor = "";
			if (isset($column[5])) {
				$valor = $column[5];
			}
			$fecha1 = "";
			if (isset($column[6])) {
				$fecha1 = $column[6];
			}
			$fecha = date("Y-m-d", strtotime(str_replace('/', '-', $fecha1)));



			//verificar si tipo de id ya existe

			$tipover = $conn->prepare("SELECT * FROM ids WHERE (tipo = ?)");
			$tipover->execute(array($tipo));
			$vertipo = $tipover->fetch();

			if (!empty($vertipo)) {
				//Si tipo de id existe verificar si cliente ya existe

				$cliver = $conn->prepare("SELECT * FROM clientes WHERE (id = ?)");
				$cliver->execute(array($iden));
				$clivergo = $cliver->fetch();
				if (!empty($clivergo)) {
					//Si cliente existe instertar datos de factura

					$idclient = $clivergo["idclientes"];
					$insfac = $conn->prepare("INSERT into facturas (valor, cliente, numero, fechapago, contrato)
							   values (?, ?, ?, ?, ?)");
					$insfac->execute(array(
						$valor,
						$idclient,
						$factura,
						$fecha,
						$contrato
					));

					header('Location: home.php?import=ok&id=x');
				} else {
					//Si no existe crear cliente

					$tipoar = $vertipo["ids"];
					$inscl = $conn->prepare("INSERT into clientes (tipoid, id, nombre)
							   values (?, ?, ?)");
					$inscl->execute(array(
						$tipoar,
						$iden,
						$nombre
					));



					//Seleccionar cliente creado

					$cliver3 = $conn->prepare("SELECT * FROM clientes WHERE (id = ?)");

					$cliver3->execute(array(
						$iden
					));
					$clivergo = $cliver3->fetch();
					//Insertar datos de factura
					$idclient = $clivergo["idclientes"];
					$insfac = $conn->prepare("INSERT into facturas (valor, cliente, numero, fechapago, contrato)
							   values (?, ?, ?, ?, ?)");
					$insfac->execute(array(
						$valor,
						$idclient,
						$factura,
						$fecha,
						$contrato
					));

					header('Location: home.php?import=ok&id=x');
				}
			} else {
				//Si tipo de id no existe insertardatos de tipo de id

				$instipo = $conn->prepare("INSERT into ids (tipo)
						   values (?)");
				$instipo->execute(array(
					$tipo
				));

				//Verificar si cliente ya existe					

				$cliver = $conn->prepare("SELECT * FROM clientes WHERE (id = ?)");
				$cliver->execute(array(
					$iden
				));
				$clivergo = $cliver->fetch();
				if (!empty($clivergo)) {
					//Si cliente existe instertar datos de factura

					$idclient = $clivergo["idclientes"];
					$insfac = $conn->prepare("INSERT into facturas (valor, cliente, numero, fechapago, contrato)
							   values (?, ?, ?, ?, ?)");
					$insfac->execute(array(
						$valor,
						$idclient,
						$factura,
						$fecha,
						$contrato
					));

					header('Location: home.php?import=ok&id=x');
				} else {
					//Si no existe seleccionar id de tipo de identificacion

					$tipover2 = $conn->prepare("SELECT * FROM ids WHERE (tipo = ?)");
					$tipover2->execute(array(
						$tipo
					));
					$vertipo2 = $tipover2->fetch();



					//Insertar datos de cliente con tipo de id seleccionado
					$tipoar2 = $vertipo2["ids"];
					$inscl2 = $conn->prepare("INSERT into clientes (tipoid, id, nombre)
							   values (?, ?, ?)");
					$inscl2->execute(array(
						$tipoar2,
						$iden,
						$nombre
					));


					//Seleccionar cliente creado

					$cliver3 = $conn->prepare("SELECT * FROM clientes WHERE (id = ?)");
					$cliver3->execute(array(
						$iden
					));

					//Insertar datos de factura
					$clivergo = $cliver3->fetch();
					//Insertar datos de factura
					$idclient = $clivergo["idclientes"];
					$insfac = $conn->prepare("INSERT into facturas (valor, cliente, numero, fechapago, contrato)
							   values (?, ?, ?, ?, ?)");
					$insfac->execute(array(
						$valor,
						$idclient,
						$factura,
						$fecha,
						$contrato
					));

					header('Location: home.php?import=ok&id=x');
				}

				if (!empty($inserttipo)) {
					header('home.php?import=ok&id=x');
				} else {
					header('Location: home.php?import=no&id=x');
				}
			}
		}
	}
}
