<?php session_start(); ?><?php


							require('../dbcon.php');
							$sesdel = "DELETE FROM sesiones";
							$conn->exec($sesdel);
							if (isset($_POST['Entrar'])) {



								if ((!empty($_POST['Usuario'])) && (!preg_match('/[^A-Za-z0-9]/', $_POST['Usuario']))) {




									$usuario = $_POST['Usuario'];
									$pass = $_POST['Pass'];
									$token = md5(rand(5, 500000));
									$_SESSION["token"] = 0;

									$sql = $conn->prepare("SELECT * FROM usuarios WHERE usuario =? ");
									$sql->execute(array($usuario));
									$result = $sql->fetch();

									if (!empty($result)) {
										$hash = $result["clave"];


										if (password_verify($pass, $hash)) {
											$_SESSION["user"] = $usuario;
											$_SESSION["userid"] = $result["idusuario"];
											$_SESSION["password"] = $hash;
											$_SESSION["token"] = $token;

											$ses = $conn->prepare("INSERT INTO sesiones (usuario, clave, token) VALUES (?, ?, ?)");
											$ses->execute(array($usuario, $hash, $token));
											$conn = null;
											header('Location: home.php');
										} else {
											echo 'Usuario o contraseña incorrectos';
										}
									} else {
										echo "Usuario o contraseña incorrectos";
									}
								} else {
									echo 'Usuario invalido';
								}
							}
							?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link href="https://fonts.googleapis.com/css2?family=Open+Sans&family=Roboto:wght@100;400;700&display=swap" rel="stylesheet">
	<link href="css/general.css" rel="stylesheet">
	<title>RED PLANET</title>
	<style type="text/css">
		#passcont {
			position: absolute;
			width: 205px;
			height: 205px;
			margin: auto;
			top: 0px;
			bottom: 0px;
			left: 0px;
			right: 0px;
		}
	</style>

</head>

<body>
	<div id="containeri" style="background-image:url(images/index_back.jpg); background-size: 100%;">
		<h1 style="text-align: center; margin-top: 100px; color: white;">Sistema de admininstración de pagos</h1>
		<div id="usercont">
			<div id="passcont">
				<form action="" method="post">
					<span class="b">Usuario:</span><br />
					<input name="Usuario" type="text" />
					<br />
					<br />
					<span class="b">Contraseña:</span> <br /><input name="Pass" type="password" />
					<br />
					<br /><br />


					<div class="center">
						<input type="submit" name="Entrar" id="Entrar" value="Entrar" />
					</div>

				</form>
			</div>
		</div>
	</div>

</body>

</html>