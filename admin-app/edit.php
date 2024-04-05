<?php
require('session.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Control de Inventario</title>
<link rel="stylesheet" type="text/css" href="css/TopBar.css">
<style type="text/css">


</style>
</head>

<body>




<?php

$id = $_GET['id'];		
		
		
	/* Select products */	
$sql = "SELECT * FROM facturas WHERE idfacturas='" .$id ."'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

$sql2 =  "SELECT * FROM clientes WHERE idclientes='" .$row["cliente"] ."'";
$result2 = $conn->query($sql2);
$row2 = $result2->fetch_assoc();
$cliente = $row2["nombre"];

$valor = number_format($row["valor"],0,".",".");
?>
 <form action="" method="post" name="nuevafactura">
 Cliente:<br />
<select name="cliente">
 		<?php
	  		echo "<option " ."value='" .$row2["idclientes"] ."'>"  .$row2["nombre"] ."</option>";
		  $cl = "SELECT * FROM clientes";
		  $sqlcl = $conn->query($cl);
			while($clrow = $sqlcl->fetch_assoc()) {

				
					echo "<option " ."value='" .$clrow["idclientes"] ."'>"  .$clrow["nombre"] ."</option>";
					


			}
  		?>
 
 
 
</select><br /><br />
 Numero de Factura:<br />
<input name="numero" type="text" value="<?php echo $row["numero"]; ?>"/><br /><br />
  Valor a pagar:<br />
<input name="valor" type="text" value="$<?php echo $valor; ?>"/><br /><br />
  <input name="ingresar" type="submit" value="Actualizar" />
  <?php
  if(isset($_POST['ingresar'])){
	  $pvalor = preg_replace("/\D/", "", $_POST['valor']);
	  $pnumero = $_POST['numero'];	  
	  $pcliente = $_POST['cliente'];
  	$factura = "UPDATE facturas SET valor='" .$pvalor ."', cliente='" .$pcliente ."', numero='" .$pnumero ."' WHERE idfacturas='" .$id ."'";
	  $conn->query($factura);
	  
	  if ($conn->error) {
     die("Connection failed:  " . $conn->error);
}
	  else {
	  header('Location: edit.php?id=' .$id );
	  }
  }
 ?>	
 </form><br />
  <a href="home.php"><input name="home" type="submit" value="Volver" /></a>
  
</body>
</html>