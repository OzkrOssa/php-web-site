<?php
require('dbcon.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="https://fonts.googleapis.com/css2?family=Open+Sans&family=Roboto:wght@100;400;700&display=swap" rel="stylesheet">
<script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
<script type="text/javascript" src="js/jquery.easing.1.3.js"></script>
<script type="text/javascript" src="js/jquery.mousewheel.js"></script>
<link href="css/generalc.css" rel="stylesheet">
<title>RED PLANET</title>
<style type="text/css">
	#passcont {
	
    width: 100%;
    height: 100%;
    margin: auto;
    top: 0px;
    bottom: 0px;
    left: 0px;
    right: 0px;
	}
	
	/* Style the tab */
.tab {
      overflow: hidden;
    /* border: 1px solid #ccc; */
    background-color: #ce8585;
}

/* Style the buttons that are used to open the tab content */
.tab button {
  background-color: inherit;
    float: left;
    border: none;
    outline: none;
    cursor: pointer;
    padding: 14px 16px;
    transition: 0.3s;
    width: 200px;
	color: white;
	font-weight: bold;
}

/* Change background color of buttons on hover */
.tab button:hover {
  background-color: #ec5757;
}

/* Create an active/current tablink class */
.tab button.active {
  background-color: #f16060;
}

/* Style the tab content */
.tabcontent {
  display: none;
  padding: 60px 100px;
  border: 1px solid #ccc;
  border-top: none;
}
	.nombre {
		font-size: 27px;
		font-weight: bold;
		color: #544f4f;
	}
	.info {
		color: #544f4f;
    font-size: 16px;
	}
</style>

</head>

<body>
<div id="containeri">

	<div id="elementcont">
	 <div id="usercont">
		 <div id="passcont" style="font-size: 20px; text-align: center;">
		 <h1  style="text-align: center; margin-top: 0px; color: #e02b33;">
	<img src="images/nuevo_logo.png" width="330" height="65" alt=""/></h1>
	<?php
	$state = $_GET['lapTransactionState'];
	$refcode = $_GET['referenceCode'];
	
	
	
	if($state=='APPROVED'){
	    $camb = $conn->prepare("UPDATE facturas SET pagada='si' WHERE numero=?");
    	$camb->execute(array($refcode));
	    echo '<h1  style="text-align: center; color: #f16060; line-height: 1.3em;">
			 Gracias por su pago! </h1></br>
		 	<span class="b" style="color: #595959 !important;">Su pago fue realizado exitosamente!</span></br></br></br>
								<a href="http://www.red-planet.com.co"><input type="submit" value="Volver" /></a>';
								
	}
	if($state=='DECLINED'){ 
		 echo '<h1  style="text-align: center; color: #f16060; line-height: 1.3em;">
			 Error </h1></br>
		 	<span class="b" style="color: #595959 !important;">No fue posible procesar su pago.</br></br> Por favor contactenos para mas informacion.</span></br></br></br>
								<a href="http://www.red-planet.com.co"><input type="submit" value="Volver" /></a>';
	}	
	if($state=='PENDING'){ 
		 echo '<h1  style="text-align: center; color: #f16060; line-height: 1.3em;">TRANSACCION PENDIENTE</h1></br>
		 	<span class="b" style="color: #595959 !important;">Su transaccion esta siendo verificada.</br></br>Le contactaremos tan pronto se complete el proceso.</span></br></br></br>
								<a href="http://www.red-planet.com.co"><input type="submit" value="Volver" /></a>';
	}
	?>	  
		</div>
		
	</div>
	<div id="usercont" style="background-image: url(images/woman.jpg); background-size: cover;">
	</div>
</div>
</div>




</body>
</html>