<?php
require('session.php');
require('header.php');
?>


<body>
	<div id="container">
		<div id="subcont">
			<?php
			require('bar.php');
			?>
			<div id="subcont2">
				<div id="contenido">
					<div id="sectiontit" class="padlr">
						<h1 class="sectitle">Editar Factura</h1>
					</div>
					<div id="sectiontab">
						<?php

						$id = $_GET['id'];


						/* Select products */
						$sql = $conn->prepare("SELECT * FROM facturas WHERE idfacturas=?");
						$sql->execute(array($id));
						$row = $sql->fetch();

						$rc = $row["cliente"];
						$sql2 =  $conn->prepare("SELECT * FROM clientes WHERE idclientes=? ");
						$sql2->execute(array($rc));
						$row2 = $sql2->fetch();
						$cliente = $row2["nombre"];

						$valor = number_format($row["valor"], 0, ".", ".");
						?>
						<form action="" method="post" name="nuevafactura">
							<span class="colorp">Cliente:</span><br />
							<select name="cliente">
								<?php
								echo "<option " . "value='" . $row2["idclientes"] . "'>"  . $row2["nombre"] . "</option>";
								$cl = $conn->prepare("SELECT * FROM clientes");
								$cl->execute();
								while ($clrow = $cl->fetch()) {


									echo "<option " . "value='" . $clrow["idclientes"] . "'>"  . $clrow["nombre"] . "</option>";
								}
								?>



							</select><br /><br />
							<span class="colorp">Numero de Factura:</span><br />
							<input name="numero" type="text" value="<?php echo $row["numero"]; ?>" /><br /><br />
							<span class="colorp">Valor a pagar:</span><br />
							<input name="valor" type="text" value="$<?php echo $valor; ?>" /><br /><br />
							<input name="ingresar" type="submit" value="Actualizar" />
							<?php
							if (isset($_POST['ingresar'])) {
								$pvalor = preg_replace("/\D/", "", $_POST['valor']);
								$pnumero = $_POST['numero'];
								$pcliente = $_POST['cliente'];
								if (is_numeric($pvalor) && is_numeric($pnumero)) {

									$vercl = $conn->prepare("SELECT * FROM clientes WHERE idclientes= ' $pcliente '");
									$vercl->execute();
									$vercli = $vercl->fetch();

									if (!empty($vercli)) {
										$factura = $conn->prepare("UPDATE facturas SET valor=?, cliente=?, numero=? WHERE idfacturas=?");
										$factura->execute(array($pvalor, $pcliente, $pnumero, $id));

										header('Location: home.php');
									} else {
										echo "Cliente invalido";
									}
								} else {
									echo "Numero de factura o valor invalido";
								}
							}
							?>
						</form><br />
						<a href="home.php"><input name="home" type="submit" value="Volver" /></a>



					</div>


				</div>


			</div>


		</div>
	</div>

</body>

</html>