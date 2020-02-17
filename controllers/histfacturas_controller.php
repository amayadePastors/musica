<?php
session_start();
require_once("../db/conexion.php");
require_once("../models/histfacturas_model.php");


$cliente=$_SESSION["id"];
$facturas=infoFacturasCliente($cliente,$db);
require_once("../views/histfacturas_views.php");

mysqli_close($db);
?>
	
