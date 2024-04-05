<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require('../dbcon.php');
$sesusuario = $_SESSION["user"];
$sespass = $_SESSION["password"];
$sestoken = $_SESSION["token"];



$sql = $conn->prepare("SELECT * FROM sesiones WHERE usuario=? AND clave=? AND token=? ");
$sql->execute(array($sesusuario, $sespass, $sestoken));
$result = $sql->fetch();
print_r($result);


if (empty($result)) {
	//						echo ("no coincide la sesión");
	//						exit(0);
	//header('Location: index.php'); 
} else {
	//						echo "OK";
}

function home()
{
	header('Location: home.php');
}
