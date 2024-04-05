<?php
/*
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
*/

$servername = "localhost";
$username = "plasifub_rsTp6084h";
$password = "2y%O0G\qw'06";
$dbname = "plasifub_U688bMd8e";

$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
