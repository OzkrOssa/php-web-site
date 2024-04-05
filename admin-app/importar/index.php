<?php

use Phppot\DataSource;

require_once 'DataSource.php';
$db = new DataSource();
$conn = $db->getConnection();
$row = 1;
if (isset($_POST["import"])) {

	$fileName = $_FILES["file"]["tmp_name"];

	if ($_FILES["file"]["size"] > 0) {

		$file = fopen($fileName, "r");

		while (($column = fgetcsv($file, 100000, ",")) !== FALSE) {
			if ($row == 1) {
				$row++;
			} else {

				$nombre = "";
				if (isset($column[0])) {
					$nombre = mysqli_real_escape_string($conn, $column[0]);
				}


				$tipo = "";
				if (isset($column[1])) {
					$tipo = mysqli_real_escape_string($conn, $column[1]);
				}
				$iden = "";
				if (isset($column[2])) {
					$iden = mysqli_real_escape_string($conn, $column[2]);
				}
				$factura = "";
				if (isset($column[3])) {
					$factura = mysqli_real_escape_string($conn, $column[3]);
				}
				$valor = "";
				if (isset($column[4])) {
					$valor = mysqli_real_escape_string($conn, $column[4]);
				}





				//verificar si tipo de id ya existe

				$tipover = "SELECT * FROM ids WHERE (tipo = ?)";
				$paramTypet = "s";
				$paramArrayt = array(
					$tipo
				);
				$vertipo = $db->select($tipover, $paramTypet, $paramArrayt);

				if (!empty($vertipo)) {
					//Si tipo de id existe verificar si cliente ya existe

					$cliver = "SELECT * FROM clientes WHERE (id = ?)";
					$paramcliver = "s";
					$cliverparamArrayt = array(
						$iden
					);
					$clivergo = $db->select($cliver, $paramcliver, $cliverparamArrayt);
					if (!empty($clivergo)) {
						//Si cliente existe instertar datos de factura
						foreach ($clivergo as $clientestab) {
							$idclient = $clientestab["idclientes"];
							$insfac = "INSERT into facturas (valor, cliente, numero)
							   values (?, ?, ?)";
							$paramfac = "iii";
							$paramArrayfac = array(
								$valor,
								$idclient,
								$factura
							);
							$insertfact = $db->insert($insfac, $paramfac, $paramArrayfac);
						}
					} else {
						//Si no existe crear cliente
						foreach ($vertipo as $rowtipo) {
							$tipoar = $rowtipo["ids"];
							$inscl = "INSERT into clientes (tipoid, id, nombre)
							   values (?, ?, ?)";
							$paramTypecl = "sss";
							$paramArraycl = array(
								$tipoar,
								$iden,
								$nombre
							);
							$insertcl = $db->insert($inscl, $paramTypecl, $paramArraycl);
						}

						//Seleccionar cliente creado

						$cliver3 = "SELECT * FROM clientes WHERE (id = ?)";
						$paramcliver3 = "s";
						$cliverparamArrayt3 = array(
							$iden
						);
						$clivergo3 = $db->select($cliver3, $paramcliver3, $cliverparamArrayt3);

						//Insertar datos de factura
						foreach ($clivergo3 as $clientestab) {
							$idclient = $clientestab["idclientes"];
							$insfac = "INSERT into facturas (valor, cliente, numero)
							   values (?, ?, ?)";
							$paramfac = "iii";
							$paramArrayfac = array(
								$valor,
								$idclient,
								$factura
							);
							$insertfact = $db->insert($insfac, $paramfac, $paramArrayfac);
						}
					}
				} else {
					//Si tipo de id no existe insertardatos de tipo de id

					$instipo = "INSERT into ids (tipo)
						   values (?)";
					$paramTypei = "s";
					$paramArrayi = array(
						$tipo
					);
					$inserttipo = $db->insert($instipo, $paramTypei, $paramArrayi);

					//Verificar si cliente ya existe					

					$cliver = "SELECT * FROM clientes WHERE (id = ?)";
					$paramcliver = "s";
					$cliverparamArrayt = array(
						$iden
					);
					$clivergo = $db->select($cliver, $paramcliver, $cliverparamArrayt);

					if (!empty($clivergo)) {
						//Si cliente existe instertar datos de factura
						foreach ($clivergo as $clientestab) {
							$idclient = $clientestab["idclientes"];
							$insfac = "INSERT into facturas (valor, cliente, numero)
							   values (?, ?, ?)";
							$paramfac = "iii";
							$paramArrayfac = array(
								$valor,
								$idclient,
								$factura
							);
							$insertfact = $db->insert($insfac, $paramfac, $paramArrayfac);
						}
					} else {
						//Si no existe seleccionar id de tipo de identificacion

						$tipover2 = "SELECT * FROM ids WHERE (tipo = ?)";
						$paramTypet2 = "s";
						$paramArrayt2 = array(
							$tipo
						);
						$vertipo2 = $db->select($tipover2, $paramTypet2, $paramArrayt2);


						foreach ($vertipo2 as $rowtipo2) {
							//Insertar datos de cliente con tipo de id seleccionado
							$tipoar2 = $rowtipo2["ids"];
							$inscl2 = "INSERT into clientes (tipoid, id, nombre)
							   values (?, ?, ?)";
							$paramTypecl2 = "sss";
							$paramArraycl2 = array(
								$tipoar2,
								$iden,
								$nombre
							);
							$insertcl2 = $db->insert($inscl2, $paramTypecl2, $paramArraycl2);
						}

						//Seleccionar cliente creado

						$cliver3 = "SELECT * FROM clientes WHERE (id = ?)";
						$paramcliver3 = "s";
						$cliverparamArrayt3 = array(
							$iden
						);
						$clivergo3 = $db->select($cliver3, $paramcliver3, $cliverparamArrayt3);

						//Insertar datos de factura
						foreach ($clivergo3 as $clientestab) {
							$idclient = $clientestab["idclientes"];
							$insfac = "INSERT into facturas (valor, cliente, numero)
							   values (?, ?, ?)";
							$paramfac = "iii";
							$paramArrayfac = array(
								$valor,
								$idclient,
								$factura
							);
							$insertfact = $db->insert($insfac, $paramfac, $paramArrayfac);
						}
					}

					if (!empty($inserttipo)) {
						$type = "success";
						$message = "Registros Insertados";
					} else {
						$type = "error";
						$message = "Problem in Importing CSV Data";
					}
				}
			}
		}
	}
}
?>
<!DOCTYPE html>
<html>

<head>
	<script src="jquery-3.2.1.min.js"></script>

	<style>
		body {
			font-family: Arial;
			width: 550px;
		}

		.outer-scontainer {
			background: #F0F0F0;
			border: #e0dfdf 1px solid;
			padding: 20px;
			border-radius: 2px;
		}

		.input-row {
			margin-top: 0px;
			margin-bottom: 20px;
		}

		.btn-submit {
			background: #333;
			border: #1d1d1d 1px solid;
			color: #f0f0f0;
			font-size: 0.9em;
			width: 100px;
			border-radius: 2px;
			cursor: pointer;
		}

		.outer-scontainer table {
			border-collapse: collapse;
			width: 100%;
		}

		.outer-scontainer th {
			border: 1px solid #dddddd;
			padding: 8px;
			text-align: left;
		}

		.outer-scontainer td {
			border: 1px solid #dddddd;
			padding: 8px;
			text-align: left;
		}

		#response {
			padding: 10px;
			margin-bottom: 10px;
			border-radius: 2px;
			display: none;
		}

		.success {
			background: #c7efd9;
			border: #bbe2cd 1px solid;
		}

		.error {
			background: #fbcfcf;
			border: #f3c6c7 1px solid;
		}

		div#response.display-block {
			display: block;
		}
	</style>
	<script type="text/javascript">
		$(document).ready(function() {
			$("#frmCSVImport").on("submit", function() {

				$("#response").attr("class", "");
				$("#response").html("");
				var fileType = ".csv";
				var regex = new RegExp("([a-zA-Z0-9\s_\\.\-:])+(" + fileType + ")$");
				if (!regex.test($("#file").val().toLowerCase())) {
					$("#response").addClass("error");
					$("#response").addClass("display-block");
					$("#response").html("Invalid File. Upload : <b>" + fileType + "</b> Files.");
					return false;
				}
				return true;
			});
		});
	</script>
</head>

<body>
	<h2>Import CSV file into Mysql using PHP</h2>

	<div id="response" class="<?php if (!empty($type)) {
									echo $type . " display-block";
								} ?>">
		<?php if (!empty($message)) {
			echo $message;
		} ?>
	</div>
	<div class="outer-scontainer">
		<div class="row">

			<form class="form-horizontal" action="" method="post" name="frmCSVImport" id="frmCSVImport" enctype="multipart/form-data">
				<div class="input-row">
					<label class="col-md-4 control-label">Choose CSV
						File</label> <input type="file" name="file" id="file" accept=".csv">
					<button type="submit" id="submit" name="import" class="btn-submit">Import</button>
					<br />

				</div>

			</form>

		</div>
		<?php
		$sqlSelect = "SELECT * FROM facturas";
		$result = $db->select($sqlSelect);
		if (!empty($result)) {
		?>
			<table id='userTable'>
				<thead>
					<tr>
						<th>Valor</th>
						<th>Cliente</th>
						<th>Numero</th>
						<th>Pagada</th>

					</tr>
				</thead>
				<?php

				foreach ($result as $row) {
				?>

					<tbody>
						<tr>
							<td><?php echo $row['valor']; ?></td>
							<td><?php echo $row['cliente']; ?></td>
							<td><?php echo $row['numero']; ?></td>
							<td><?php echo $row['pagada']; ?></td>
						</tr>
					<?php
				}
					?>
					</tbody>
			</table>
		<?php } ?>
	</div>

</body>

</html>