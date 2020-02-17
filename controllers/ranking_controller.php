<?php
session_start();
require_once("../db/conexion.php");
require_once("../models/ranking_model.php");
?>
<h1>Consultar Ranking Canciones</h1>
	<form  action="ranking_controller.php" method="post">
		<label for="fechaini">Seleccionar Fecha de inicio:</label>
		<input type="date" name="fechaini"><br>
		<label for="fechafin">Seleccionar Fecha de fin:</label>
		<input type="date" name="fechafin">
		<br/><input type="submit" value="Aceptar"><br/><br/>
		<br/><a href="../views/inicio.php">Volver al menu Principal</a>
		<br/><a href="logout_controller.php">Cerrar Sesion</a>
	</form>	
<?php
// Aquí va el código al pulsar submit
	if (isset($_POST) && !empty($_POST)) { 
		$fechaini=$_POST['fechaini'];
		$fechafin=$_POST['fechafin'];
		if($fechaini>$fechafin)
			trigger_error("La fecha de fin no puede ser inferior a la de inicio");
		else{
			$canciones=obtenerRanking($fechaini,$fechafin,$db);
			require("../views/ranking_view.php");
		}
	}
	mysqli_close($db);
?>