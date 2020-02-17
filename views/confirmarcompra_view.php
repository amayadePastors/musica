<html>
<head>
    <meta charset="UTF-8">
    <title>Web Musica</title>
</head>
	<h1>Confirmar Compra </h1>
<?php 
	echo "Compra realizada correctamente. <br/>";
	echo "Numero de factura " . $_SESSION["invoiceId"];
?>

<br/><a href="logout_controller.php">Cerrar Sesión</a><br/>
<br/><a href="../views/inicio.php">Volver al menu principal</a><br/>

</body>

</html>
