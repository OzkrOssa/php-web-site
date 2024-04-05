<?php
session_start();
require('dbcon.php');
$sesdel = "DELETE FROM sesiones";
$conn->exec($sesdel);
$conn = null;
// remove all session variables
session_unset();

// destroy the session
session_destroy();
header('Location: index.php');
