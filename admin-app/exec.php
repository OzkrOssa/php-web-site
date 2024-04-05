<?php
require('dbcon.php');



$usuarios = "INSERT INTO clientes (tipoid, id, nombre) VALUES ('2', '9085656654-2', 'LarryCura SAS')";
$conn->query($usuarios);

if ($conn->error) {
     die("Connection failed:  " . $conn->error);
}
