<?php
require('session.php');
require('header.php');
?>


<body>
	<?php
	if ((!empty($_GET['del']))) {


		$idfactu = $_GET['del'];
		$checkfacts = $conn->prepare("SELECT * FROM facturas WHERE cliente= ?");
		$checkfacts->execute(array($idfactu));
		$rrow = $checkfacts->fetch();
		if (!empty($rrow)) {

			echo '<div id="blackscreen">
						<div id="msg">
							<div id="msgicon">
							<img src="images/trashg-01.png" width="150" alt=""/> </div></br>
						  <span class="tit">Borrar Cliente</span></br></br></br>
							<span class="msg">Hay facturas asociadas a este cliente, esta seguro que desea borrarlo?</span></br></br>

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
				$delreg = $conn->prepare("DELETE FROM clientes WHERE idclientes= ?");
				$delreg->execute(array($idfactu));

				header('Location: clientes.php');
			}
			if (isset($_POST['cancelar'])) {
				header('Location: clientes.php');
			}
		} else {
			echo '<div id="blackscreen">
						<div id="msg">
							<div id="msgicon">
							<img src="images/trashg-01.png" width="150" alt=""/> </div></br>
						  <span class="tit">Borrar Cliente</span></br></br></br>
							<span class="msg">Esta seguro que desea borrar este cliente?</span></br></br>

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
				$delreg = $conn->prepare("DELETE FROM clientes WHERE idclientes= ?");
				$delreg->execute(array($idfactu));

				header('Location: clientes.php');
			}
			if (isset($_POST['cancelar'])) {
				header('Location: clientes.php');
			}
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
						<h1 class="sectitle">Clientes</h1>
					</div>
					<div id="sectiontab">

						<form action="" method="post" name="nuevafactura">
							<img src="images/plusicon-02.png" width="20" alt="" />&nbsp;<span class="colorp">Nuevo Cliente: </span>


							<input name="numero" type="text" placeholder="Nombre completo" />&nbsp;&nbsp;
							<select class="selct" name="cliente">
								<option value="" disabled selected hidden>Tipo de Identificación</option>
								<?php

								$cl = $conn->prepare("SELECT * FROM ids");
								$cl->execute();
								while ($clrow = $cl->fetch()) {

									echo "<option value='" . $clrow["ids"] . "'>"  . $clrow["tipo"] . "</option>";
								}
								?>



							</select>&nbsp;&nbsp;
							<input name="valor" type="text" placeholder="Numero de Identificación" />&nbsp;&nbsp;

							<input name="ingresar" type="submit" value="Ingresar Cliente" />&nbsp;&nbsp;
							<?php
							if (isset($_POST['ingresar'])) {
								if ((!empty($_POST['cliente']))) {
									$clid = $_POST['cliente'];
									$pvalor = $_POST['valor'];
									$pnumero = $_POST['numero'];
									if ((!empty($clid)) && (is_numeric($clid)) && (!empty($pvalor)) && (is_numeric($pvalor)) && (!empty($pnumero))) {
										$clid = $_POST['cliente'];
										$pvalor = $_POST['valor'];
										$pnumero = $_POST['numero'];


										$insfac = $conn->prepare("INSERT INTO clientes (tipoid, id, nombre) VALUES (?, ?, ?)");
										$insfac->execute(array($clid, $pvalor, $pnumero));

										$dbh = null;

										header('Location: clientes.php');
									} else {
										echo "Entrada invalida";
									}
								} else {
									echo "Seleccione tipo de ID";
								}
							}
							?>
						</form></br></br>



						<?php
						if (!empty($_GET)) {
							$id = $_GET['id'];





							if ($id != 'x') {

								/* Select products */
								$sql = $conn->prepare("SELECT * FROM clientes WHERE idclientes=?");
								$sql->execute(array($id));
								$row = $sql->fetch();

								$rc = $row["tipoid"];
								$sql2 =  $conn->prepare("SELECT * FROM ids WHERE ids=? ");
								$sql2->execute(array($rc));
								$row2 = $sql2->fetch();
								$cliente = $row2["tipo"];


								echo '<div class="edit">
							<img src="images/editiconp-02.png" width="20" alt=""/>&nbsp;<span class="colorp">Editar Cliente: </span> <br /><br /><form action="" method="post" name="nuevafactura">
							   	
							   &nbsp;&nbsp;<span class="colorp">Numero Completo:</span>
                          <input name="numero" type="text" value="' . $row["nombre"] . '"/>&nbsp;&nbsp;
                          	<span class="colorp">Tipo de ID:</span>
								<select name="cliente">
							';

								echo "<option " . "value='" . $row2["ids"] . "'>"  . $row2["tipo"] . "</option>";
								$cl = $conn->prepare("SELECT * FROM ids");
								$cl->execute();
								while ($clrow = $cl->fetch()) {


									echo "<option value='" . $clrow["ids"] . "'>"  . $clrow["tipo"] . "</option>";
								}
								echo '
							</select>
							   
							   &nbsp;&nbsp;<span class="colorp">Numero de ID:</span>
                          <input name="valor" type="text" value="' . $row["id"] . '"/></br></br>
                            <input name="ingresar2" type="submit" value="Actualizar" />
							';

								if (isset($_POST['ingresar2'])) {
									$pnumero = $_POST['numero'];
									$pcliente = $_POST['cliente'];
									$pval = $_POST['valor'];
									if (is_numeric($pval) && is_numeric($pcliente)) {




										$factura = $conn->prepare("UPDATE clientes SET tipoid=?, id=?, nombre=? WHERE idclientes=?");
										$factura->execute(array($pcliente, $pval, $pnumero, $id));

										if (headers_sent()) {
											echo '<script>window.location="clientes.php"</script>';
										} else {
											'<script>window.location="clientes.php"</script>';
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
									<td>Tipo de identificacion</td>
									<td>Numero de identificacion</td>
									<td>Acciones</td>
								</tr>

								<?php




								$facts = $conn->prepare("SELECT * FROM clientes");
								$facts->execute();

								if (!empty($facts)) {
									// output data of each row


									while ($row = $facts->fetch()) {
										$sqlcliente = $conn->prepare("SELECT * FROM ids WHERE ids =?");
										$idcli = $row["tipoid"];
										$sqlcliente->execute(array($idcli));
										$cliente = $sqlcliente->fetch();


										echo "
											 <tr>
											<td class='color'>" . $row["nombre"] . "</td>
											<td>" . $cliente["tipo"] . "</td>
											  <td>" . $row["id"] . "</td>
											  <td>
												<a href='clientes.php?id=" . $row["idclientes"] . "'><img src='images/editicon-02.png' width='25'/></a>&nbsp;
												<a href='clientes.php?del=" . $row["idclientes"]  . "&id=x'><img src='images/trashicon-02.png' width='25'/></a>
											  </td>
											  </tr>";
									}
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