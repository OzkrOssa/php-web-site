<?php
require('dbcon.php');



$conn->exec("CREATE TABLE ids (
ids INT(11) UNIQUE AUTO_INCREMENT PRIMARY KEY NOT NULL,
tipo VARCHAR(30) NOT NULL
)");

$conn->exec("CREATE TABLE clientes (
idclientes INT(11) UNIQUE AUTO_INCREMENT PRIMARY KEY NOT NULL,
tipoid VARCHAR(100) NOT NULL,
id VARCHAR(100) NOT NULL,
nombre VARCHAR(100) NOT NULL,
reg_date TIMESTAMP
)");

$conn->exec("CREATE TABLE facturas (
idfacturas INT(11) UNIQUE AUTO_INCREMENT PRIMARY KEY NOT NULL,
valor INT(100) NOT NULL,
cliente INT(100) NOT NULL,
numero INT(100) NOT NULL,
fechapago DATE NOT NULL,
pagada VARCHAR(100) NOT NULL DEFAULT 'no',
reg_date TIMESTAMP
)");

$conn->exec("CREATE TABLE usuarios (
idusuario INT(11) UNIQUE AUTO_INCREMENT PRIMARY KEY NOT NULL,
usuario VARCHAR(100) NOT NULL,
clave VARCHAR(100) NOT NULL,
nombre VARCHAR(100) NOT NULL,
correo VARCHAR(100) NOT NULL,
reg_date TIMESTAMP
)");

$conn->exec("CREATE TABLE sesiones (
idsesion INT(11) UNIQUE AUTO_INCREMENT PRIMARY KEY NOT NULL,
usuario VARCHAR(100) NOT NULL,
clave VARCHAR(100) NOT NULL,
token VARCHAR(1000) NOT NULL,
reg_date TIMESTAMP
)");



$conn->exec("INSERT INTO usuarios (usuario, clave, nombre, correo) VALUES ('admin', '$2y$10$kJvRgixhQr8Gj0tz9UYg8O6P45k6Mg3LxCHBXZLmQ.YIJZcKxfDG2', 'Diego Rocha', 'diegorf3000@gmail.com')");


$conn->exec("INSERT INTO ids (tipo) VALUES ('Cedula')");

$conn->exec("INSERT INTO ids (tipo) VALUES ('Nit')");
