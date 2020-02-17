<?php
session_start();
require_once("../db/conexion.php");
require_once("../models/confirmarcompra_model.php");


if(confirmarCompra($db)){
	require_once("../views/confirmarcompra_view.php");
	//vaciamos el carrito y el invoiceid
	$_SESSION["carrito"]=array();
	$_SESSION["invoiceId"]=null;
}
mysqli_close($db);
?>

