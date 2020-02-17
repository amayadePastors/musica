<?php
session_start();
require_once("../db/conexion.php");
require_once("../models/downmusic_model.php");
$artista;
$album;
$cancion;

if (isset($_POST['btnlimpiar']) && !empty($_POST['btnlimpiar'])){
		$_POST=array();
		header("Location: downmusic_controller.php");
	}

if (!isset($_POST) || empty($_POST)){
	$artistas = obtenerArtistas($db);
}
else{
	if (isset($_POST['artista']) && !empty($_POST['artista'])){
		$artista=$_POST['artista'];
		$artistas=array($artista);
	}
	if (isset($_POST['btnartista']) && !empty($_POST['btnartista']))
		$albumes = obtenerAlbumes($db,$_POST['artista']);

	if (isset($_POST['album']) && !empty($_POST['album'])){
		$album=$_POST['album'];
		$albumes=array($album);	
	}

	if (isset($_POST['btnalbum']) && !empty($_POST['btnalbum']))
		$canciones = obtenerCanciones($db,$_POST['album'],$artista);	

	if (isset($_POST['cancion']) && !empty($_POST['cancion'])) { 
		$cancion=$_POST['cancion'];
		if (isset($_POST['btncancion']) && !empty($_POST['btncancion'])){
			$codigoCancion=obtenerCodigoCancion($cancion,$db,$album);
			if(!annadirAlCarrito($codigoCancion,$db))
				trigger_error("Error: Ha habido un problema al anadir el producto al carrito");				
			$_POST=array();
			header("Location: downmusic_controller.php");
		}
	}
}

	
?>
<html>
<head>
    <meta charset="UTF-8">
    <title>Web Musica</title>
</head>

<body>
	<h1>Descargar Canciones</h1>
	<form  action="downmusic_controller.php" method="post">
		<label for="artista">Seleccionar Artista: </label><br/>
		<select name="artista">
			<?php foreach($artistas as $artista) : ?>
				<option> <?php echo $artista ?> </option>
			<?php endforeach; ?>
		</select><br/><br/>
		<input type="submit" name="btnartista" value ="Selecionar artista">
		<br/>
		<br/>
		<label for="album">Seleccionar Album: </label><br/>
		<select name="album">
			<?php 
				foreach($albumes as $album) : ?>
				<option> <?php echo $album ?> </option>
			<?php endforeach; ?>
		</select><br/><br/>
		<input type="submit" name="btnalbum" value ="Selecionar album">
		<br/>
		<br/>
		<label for="cancion">Seleccionar Canción: </label><br/>
		<select name="cancion">
				<?php 	
				foreach($canciones as $cancion) : ?>
					<option> <?php echo $cancion ?> </option>
				<?php endforeach; ?>
		</select><br/><br/>
		<input type="submit" name="btncancion"value="Seleccionar Cancion"><br/><br/>
		<input type="submit" name="btnlimpiar"value="Limpiar Seleccion"><br/><br/>
		<br/><a href="logout_controller.php">Cerrar Sesion</a>
		<br/><a href="../views/inicio.php">Volver al Menu Principal</a>
		
	</form>	
</body>

</html>
<?php

if (isset($_SESSION["carrito"]) && !empty($_SESSION["carrito"])) {
	$infocarrito=obtenerInfoCarrito($db);
	require_once("../views/downmusic_view.php");	
}
	
mysqli_close($db);		
	
?>



