<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

function obtenerTipoDocumento($conn, $tipo)
{
	$tipover = $conn->prepare("SELECT * FROM ids WHERE (tipo = ?)");
	$tipover->execute(array($tipo));
	$vertipo = $tipover->fetch();
	return $vertipo;
}

function redireccionar($estado)
{
	$str = 'Location: home.php?import=' . $estado . '&id=x';
	header($str);
}

function obtenerDato($row, $i)
{
	$dato = "";
	if (isset($row[$i])) {
		$dato = $row[$i];
	}

	//echo $i . " " . $dato . "<br>";
	return $dato;
}

require('../dbcon.php');
$row_cont = 1;


$fileName = $_FILES["file"]["tmp_name"];

if ($_FILES["file"]["size"] > 0) {

	$file = fopen($fileName, "r");

	while (($row = fgetcsv($file, 100000, ",")) !== FALSE) {
		if ($row_cont == 1) {
			$row_cont++;
		} else {

			$nombre = obtenerDato($row, 0);
			$tipo = obtenerDato($row, 1);
			$iden = obtenerDato($row, 2);
			$factura = obtenerDato($row, 3);
			$contrato = obtenerDato($row, 4);
			$valor = obtenerDato($row, 5);
			$fecha1 = obtenerDato($row, 6);

			$fecha = date("Y-m-d", strtotime(str_replace('/', '-', $fecha1)));



			//verificar si tipo de id ya existe

			$vertipo = obtenerTipoDocumento($conn, $tipo);

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

					redireccionar("ok");
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

					redireccionar("ok");
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

					redireccionar("ok");
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

					redireccionar("ok");
				}

				if (!empty($inserttipo)) {
					header('home.php?import=ok&id=x');
				} else {
					redireccionar("no");
				}
			}
		}
	}
}
