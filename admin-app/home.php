<?php

require('session.php');
require('header.php');
?>

<body>
	<?php
	if ((!empty($_GET['del']))) {
		echo '<div id="blackscreen">
			<div id="msg">
				<div id="msgicon">
				<img src="images/trashg-01.png" width="150" alt=""/> </div></br>
			  <span class="tit">Borrar Factura</span></br></br></br>
				<span class="msg">Esta seguro que desea borrar esta factura?</span></br></br>

				<div id="msgbutcont">
					<form action="" method="post">
						<input name="aceptar" type="submit" value="Si" />
					</form></br> 
					<form action="" method="post">
						<input name="cancelar" type="submit" value="Cancelar" />
					</form>
				</div>
			</div>
		</div>';
		if (isset($_POST['aceptar'])) {
			$idfactu = $_GET['del'];
			$delreg = $conn->prepare("DELETE FROM facturas WHERE idfacturas= ?");
			$delreg->execute(array($idfactu));

			header('Location: home.php');
		}
		if (isset($_POST['cancelar'])) {
			header('Location: home.php');
		}
	}
	if ((!empty($_GET['emp']))) {
		echo '<div id="blackscreen">
			<div id="msg">
				<div id="msgicon">
				<img src="images/trashg-01.png" width="150" alt=""/> </div></br>
			  <span class="tit">Borrar Registros</span></br></br></br>
				<span class="msg">Esta seguro que desea borrar todos los registros?</span></br></br>

				<div id="msgbutcont">
					<form action="" method="post">
						<input name="aceptar" type="submit" value="Si" />
					</form></br> 
					<form action="" method="post">
						<input name="cancelar" type="submit" value="Cancelar" />
					</form>
				</div>
			</div>
		</div>';
		if (isset($_POST['aceptar'])) {
			$idfactu = $_GET['del'];
			$delreg = $conn->prepare("DELETE FROM facturas");
			$delreg->execute(array($idfactu));

			header('Location: home.php');
		}
		if (isset($_POST['cancelar'])) {
			header('Location: home.php');
		}
	}
	?>
	<div id="container">
		<div id="subcont">
			<?php
			require('bar.php');
			?>
			<div id="subcont2">
				<div id="contenido">
					<div id="sectiontit" class="padlr">
						<h1 class="sectitle">Facturas</h1>
					</div>
					<div id="sectiontab">

						<form action="" method="post" name="nuevafactura">
							<img src="images/plusicon-02.png" width="20" alt="" />&nbsp;<span class="colorp">Nueva Factura: </span> <select class="selct" name="cliente">
								<option value="" disabled selected hidden>Seleccione cliente</option>
								<?php

								$cl = $conn->prepare("SELECT * FROM clientes");
								$cl->execute();
								while ($clrow = $cl->fetch()) {

									echo "<option value='" . $clrow["idclientes"] . "'>"  . $clrow["nombre"] . "</option>";
								}
								?>



							</select>&nbsp;&nbsp;

							<input name="numerooo" type="text" placeholder="Numero de Factura" />&nbsp;&nbsp;
							<input name="valor" type="text" placeholder="Valor a pagar" />&nbsp;&nbsp;
							<input name="fechaa" type="text" placeholder="fecha de pago aaaa-mm-dd" />&nbsp;&nbsp;
							<input name="ingresar" type="submit" value="Ingresar Factura" />&nbsp;&nbsp;

							<?php

							if (isset($_POST['ingresar'])) {
								if ((!empty($_POST['cliente']))) {
									$clid = $_POST['cliente'];
									$pvalor = $_POST['valor'];
									$fechaa = $_POST['fechaa'];
									$pnumerooo = $_POST['numerooo'];
									if ((!empty($clid)) && (!preg_match('/[^A-Za-z0-9]/', $clid)) && (!empty($pvalor)) && (is_numeric($pvalor)) && (!empty($pnumerooo)) && (is_numeric($pnumerooo)) && (!empty($fechaa))) {
										$clid = $_POST['cliente'];
										$pvalor = $_POST['valor'];
										$pnumero = $_POST['numero'];
										$vercl = $conn->prepare("SELECT * FROM clientes WHERE idclientes= ' $clid '");
										$vercl->execute();
										$vercli = $vercl->fetch();

										if (!empty($vercli)) {

											$insfac = $conn->prepare("INSERT INTO facturas (valor, cliente, numero, fechapago, pagada) VALUES (?, ?, ?, ?, 'no')");
											$insfac->execute(array($pvalor, $clid, $pnumerooo, $fechaa));

											$dbh = null;

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
						</form></br>

						<form action="ms_import.php" method="post" name="frmCSVImport" id="frmCSVImport" enctype="multipart/form-data">
							<img src="images/plusicon-02.png" width="20" alt="" />&nbsp;<span class="colorp">Importar registros: </span>

							&nbsp;&nbsp;
							<span style="color: #909ba4;">Seleccione archivo .csv</span> <input type="file" name="file" id="file" accept=".csv">
							<input type="submit" name="import" value="Importar" />


						</form></br></br>
						<form action="home.php?emp=1" method="post">
							<input name="vaciar" type="submit" value="Borrar Registros" />

						</form></br></br>

						<?php
						if (isset($_POST['vaciar'])) {
							header('Location: home.php?emp=1');
						}
						if (!empty($_GET)) {
							$id = $_GET['id'];





							if ($id != 'x') {

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

								echo '<div class="edit">
							<img src="images/editiconp-02.png" width="20" alt=""/>&nbsp;<span class="colorp">Editar Factura: </span> <br /><br /><form action="" method="post" name="nuevafactura">
							   <span class="colorp">Cliente:</span>	
                          	<select name="cliente">
							';

								echo "<option " . "value='" . $row2["idclientes"] . "'>"  . $row2["nombre"] . "</option>";
								$cl = $conn->prepare("SELECT * FROM clientes");
								$cl->execute();
								while ($clrow = $cl->fetch()) {


									echo "<option value='" . $clrow["idclientes"] . "'>"  . $clrow["nombre"] . "</option>";
								}
								echo '
							</select>
							   &nbsp;&nbsp;<span class="colorp">Numero de Factura:</span>
                          <input name="numero" type="text" value="' . $row["numero"] . '"/>
							   &nbsp;&nbsp;<span class="colorp">Valor a pagar:</span>
                          <input name="valor" type="text" value="' . $valor . '"/><br /><br />
						  <span class="colorp">Fecha de Pago: </span>
						  <input name="fecha" type="text" value="' . $row["fechapago"] . '"/>&nbsp;&nbsp;
						  <span class="colorp">Pagada: </span><select name="pagada">
						  	<option value="' . $row["pagada"] . '">' . $row["pagada"]  . '</option>
							<option value="si">si</option>
							<option value="no">no</option>
						  </select><br /><br />
                            <input name="ingresar2" type="submit" value="Actualizar" />
							';

								if (isset($_POST['ingresar2'])) {
									$pvalor = preg_replace("/\D/", "", $_POST['valor']);
									$pnumero = $_POST['numero'];
									$pcliente = $_POST['cliente'];
									$ppagada = $_POST['pagada'];
									if (is_numeric($pvalor) && is_numeric($pnumero)) {

										$vercl = $conn->prepare("SELECT * FROM clientes WHERE idclientes=?");
										$vercl->execute(array($pcliente));
										$vercli = $vercl->fetch();

										if (!empty($vercli)) {
											$factura = $conn->prepare("UPDATE facturas SET valor=?, cliente=?, numero=?, pagada=? WHERE idfacturas=?");
											$factura->execute(array($pvalor, $pcliente, $pnumero, $ppagada, $id));

											if (headers_sent()) {
												echo '<script>window.location="home.php"</script>';
											} else {
												// es posible añadir nuevas cabeceras HTTP
											}
										} else {
											echo "Cliente invalido";
										}
									} else {
										echo "Numero de factura o valor invalido";
									}
								}

								echo '</form></div><br /><br />';
							}
						}

						?>







						<table class="tabdis" width="100%" border="1">
							<tbody>
								<tr class="tabhead">
									<td>Nombre de cliente</td>
									<td>Numero de factura</td>
									<td>Valor a pagar</td>
									<td>Fecha de pago</td>
									<td>Pagada</td>
									<td>Acciones</td>
								</tr>

								<?php




								$facts = $conn->prepare("SELECT * FROM facturas");
								$facts->execute();


								// output data of each row


								while ($row = $facts->fetch()) {
									$sqlcliente = $conn->prepare("SELECT * FROM clientes WHERE idclientes =?");
									$idcli = $row["cliente"];
									$sqlcliente->execute(array($idcli));
									$cliente = $sqlcliente->fetch();


									$valor = number_format($row["valor"], 0, ".", ".");
									echo "
											 <tr>
											<td class='color'>" . $cliente["nombre"] . "</td>
											<td>" . $row["numero"] . "</td>
											<td>$" . $valor . "</td>
											  <td>" . $row["fechapago"] . "</td>
											  <td class='color'>" . $row["pagada"] . "</td>
											  <td>
												<a href='home.php?id=" . $row["idfacturas"] . "'><img src='images/editicon-02.png' width='25'/></a>&nbsp;
												<a href='home.php?del=" . $row["idfacturas"]  . "&id=x'><img src='images/trashicon-02.png' width='25'/></a>
											  </td>
											  </tr>";
								}


								?>







							</tbody>
						</table>


					</div>


				</div>


			</div>


		</div>
		<div id="footer">
			<div id="footertxt">Powered by AYC Networks</div>
		</div>


	</div>

</body>

</html>