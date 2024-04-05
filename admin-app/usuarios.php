<?php
require('session.php');
require('header.php');
?>


<body>
	<?php
	if ((!empty($_GET['del']))) {


		$idfactu = $_GET['del'];
		$checkfacts = $conn->prepare("SELECT * FROM usuarios WHERE idusuario= ?");
		$checkfacts->execute(array($idfactu));
		$rrow = $checkfacts->fetch();
		if (!empty($rrow)) {

			echo '<div id="blackscreen">
						<div id="msg">
							<div id="msgicon">
							<img src="images/trashg-01.png" width="150" alt=""/> </div></br>
						  <span class="tit">Borrar Usuario</span></br></br></br>
							<span class="msg">Esta seguro que desea borrar este usuario?</span></br></br>

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
				$delreg = $conn->prepare("DELETE FROM usuarios WHERE idusuario= ?");
				$delreg->execute(array($idfactu));

				header('Location: usuarios.php');
			}
			if (isset($_POST['cancelar'])) {
				header('Location: usuarios.php');
			}
		}
	}
	if ((!empty($_GET['key']))) {
		$key = $_GET['key'];
		echo '<div id="blackscreen">
						<div id="msg">
							<div id="msgicon">
							<img src="images/keygrad-02.png" width="150" alt=""/> </div></br>
						  
							

							<div id="msgbutcont">
							<form action="" method="post" name="cambiarclave">
								<input name="oldpass" type="password" placeholder="Contraseña actual"/></br></br>
								<input name="newpass1" type="password" placeholder="Contraseña Nueva"/></br></br>
								<input name="newpass2" type="password" placeholder="Verificar Contraseña"/></br></br>
								<input name="aceptar2" type="submit" value="Cambiar contraseña" />
								</form></br>
								
									<a href="usuarios.php"><input name="cancelar2" type="submit" value="Cancelar" /></a>
							</br> 
								
							</div>
						</div>
					</div>
		';
		$oldpass = $_POST['oldpass'];
		$newpass = $_POST['newpass1'];
		$newpass2 = $_POST['newpass2'];
		if (isset($_POST['aceptar2'])) {
			if ($newpass == $newpass2) {

				$passcheck = $conn->prepare("SELECT * FROM usuarios WHERE idusuario=?");
				$passcheck->execute(array($key));
				$passrow = $passcheck->fetch();


				if (password_verify($oldpass, $passrow["clave"])) {
					$newhash = password_hash($newpass, PASSWORD_DEFAULT);

					$delreg = $conn->prepare("UPDATE usuarios SET clave=? WHERE idusuario=?");
					$delreg->execute(array($newhash, $key));

					header('Location: usuarios.php');
				} else {
					echo $passrow["clave"];
				}
			} else {
				echo "Las contraseñas no coinciden";
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
						<h1 class="sectitle">Usuarios</h1>
					</div>
					<div id="sectiontab">

						<form action="" method="post" name="nuevafactura">
							<img src="images/plusicon-02.png" width="20" alt="" />&nbsp;<span class="colorp">Nuevo usuario: </span>


							<input name="nombrec" type="text" placeholder="Nombre completo" />&nbsp;&nbsp;

							<input name="usuarioc" type="text" placeholder="Usuario" />&nbsp;&nbsp;

							<input name="correoc" type="text" placeholder="Correo electronico" />&nbsp;&nbsp;

							<input name="contra1" type="password" placeholder="Contraseña" /></br></br>
							<input name="contra2" type="password" placeholder="Confirmar contraseña" />&nbsp;&nbsp;

							<input name="ingresar" type="submit" value="Ingresar Usuario" />&nbsp;&nbsp;
							<?php
							if (isset($_POST['ingresar'])) {
								if ((!empty($_POST['nombrec'])) && (!empty($_POST['usuarioc'])) && (!empty($_POST['correoc'])) && (!empty($_POST['contra1'])) && (!empty($_POST['contra2']))) {
									$nombrec = $_POST['nombrec'];
									$usuarioc = $_POST['usuarioc'];
									$correoc = $_POST['correoc'];
									$contra1 = $_POST['contra1'];
									$contra2 = $_POST['contra2'];

									if (($contra1 == $contra2)) {

										$hash = password_hash($contra1, PASSWORD_DEFAULT);

										$insus = $conn->prepare("INSERT INTO usuarios (usuario, clave, nombre, correo) VALUES (?, ?, ?, ?)");
										$insus->execute(array($usuarioc, $hash, $nombrec, $correoc));





										header('Location: usuarios.php');
									} else {
										echo "Las contraseñas no coinciden";
									}
								} else {
									echo "Por favor complete todos los campos";
								}
							}
							?>
						</form></br></br>



						<?php
						if (!empty($_GET)) {
							$id = $_GET['id'];





							if ($id != 'x') {

								/* Select products */
								$sql = $conn->prepare("SELECT * FROM usuarios WHERE idusuario=?");
								$sql->execute(array($id));
								$row = $sql->fetch();




								echo '<div class="edit">
							<img src="images/editiconp-02.png" width="20" alt=""/>&nbsp;<span class="colorp">Editar Usuario: </span> <br /><br /><form action="" method="post" name="nuevafactura">
							   	
							   &nbsp;&nbsp;<span class="colorp">Usuario:</span>
                          <input name="numero" type="text" value="' . $row["usuario"] . '"/>&nbsp;&nbsp;
                          	
							   
							   <span class="colorp">Nombre:</span>
                          <input name="cliente" type="text" value="' . $row["nombre"] . '"/>&nbsp;&nbsp;
						  
						  <span class="colorp">Correo:</span>
                          <input name="valor" type="text" value="' . $row["correo"] . '"/>
						  
						  </br></br>
                            <input name="ingresar2" type="submit" value="Actualizar" />
							';

								if (isset($_POST['ingresar2'])) {
									$pnumero = strtolower($_POST['numero']);
									$pcliente = $_POST['cliente'];
									$pval = $_POST['valor'];
									if (ctype_alnum($pnumero) && (preg_match('/^[a-zA-Z\s]+$/', $pcliente))) {




										$factura = $conn->prepare("UPDATE usuarios SET usuario=?, nombre=?, correo=? WHERE idusuario=?");
										$factura->execute(array($pnumero, $pcliente, $pval, $id));

										if (headers_sent()) {
											echo '<script>window.location="usuarios.php"</script>';
										} else {
											'<script>window.location="usuarios.php"</script>';
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
									<td>Usuario</td>
									<td>Nombre</td>
									<td>Correo</td>
									<td>Acciones</td>
								</tr>

								<?php

								$idusuario = $_SESSION["userid"];
								$facts = $conn->prepare("SELECT * FROM usuarios");
								$facts->execute();

								$i = 1;

								if ($idusuario == 1) {
									// output data of each row


									while ($row = $facts->fetch()) {





										echo "
												 <tr>
												<td class='color'>" . $row["usuario"] . "</td>
												<td>" . $row["nombre"] . "</td>
												  <td>" . $row["correo"] . "</td>
												  <td>
													<a href='usuarios.php?id=" . $row["idusuario"] . "'><img src='images/editicon-02.png' width='25'/></a>&nbsp;
													<a href='usuarios.php?del=" . $row["idusuario"]  . "&id=x'><img src='images/trashicon-02.png' width='25'/></a>&nbsp;
													<a href='usuarios.php?key=" . $row["idusuario"]  . "&id=x'><img src='images/keyicon-02.png' width='25'/></a>
												  </td>
												  </tr>";
									}
								} else {

									while ($row = $facts->fetch()) {
										if ($i == 1) {
											$i++;
										} else {




											echo "
													 <tr>
													<td class='color'>" . $row["usuario"] . "</td>
													<td>" . $row["nombre"] . "</td>
													  <td>" . $row["correo"] . "</td>
													  <td>
														<a href='usuarios.php?id=" . $row["idusuario"] . "'><img src='images/editicon-02.png' width='25'/></a>&nbsp;
														<a href='usuarios.php?del=" . $row["idusuario"]  . "&id=x'><img src='images/trashicon-02.png' width='25'/></a>&nbsp;
														<a href='usuarios.php?key=" . $row["idusuario"]  . "&id=x'><img src='images/keyicon-02.png' width='25'/></a>
													  </td>
													  </tr>";
										}
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