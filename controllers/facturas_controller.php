<?php
session_start();
require_once("../db/conexion.php");
require_once("../models/facturas_model.php");

?>
<h1>Consultar facturas entre 2 fechas</h1>
<form  action="" method="post">
		<label for="fechaini">Seleccionar Fecha de inicio:</label>
		<input type="date" name="fechaini"><br>
		<label for="fechafin">Seleccionar Fecha de fin:</label>
		<input type="date" name="fechafin">
		
		<input type="submit" value="Aceptar"><br/><br/>
		<br/><a href="../views/inicio.php">Volver al menu Principal</a>
		<br/><a href="logout_controller.php">Cerrar Sesion</a>
	</form>
	
<?php
// Aquí va el código al pulsar submit
	if (isset($_POST) && !empty($_POST)) { 
		$cliente=$_SESSION["id"];
		$fechaini=$_POST['fechaini'];
		$fechafin=$_POST['fechafin'];
		if($fechaini>$fechafin)
			trigger_error("La fecha de fin no puede ser inferior a la de inicio");
		else{
			$facturasentrefechas=infoFacturasEntreFechas($fechaini,$fechafin,$cliente,$db);
			require("../views/facturas_view.php");
		}
	}
	
	mysqli_close($db);
?>