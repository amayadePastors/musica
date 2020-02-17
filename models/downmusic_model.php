<?php
require "funciones_generales.php";
set_error_handler("errores");
	
function  obtenerArtistas($db){
	$artistas = array();
	$sql = "SELECT Name FROM artist";
	$resultado = mysqli_query($db, $sql);
	if ($resultado) {
		while ($row = mysqli_fetch_assoc($resultado)) {
			array_push($artistas,$row['Name']);
		}
	}else
		trigger_error("Error: " . $sql . "<br/>" . mysqli_error($db));
	return $artistas;
}

function obtenerAlbumes($db,$artista){
	$albumes = array();
	$sql = "SELECT Title FROM album where ArtistId=(select ArtistId from artist where Name='$artista')";
	$resultado = mysqli_query($db, $sql);
	if ($resultado) {
		while ($row = mysqli_fetch_assoc($resultado)) {
			array_push($albumes,$row['Title']);
		}
	}else
		trigger_error("Error: " . $sql . "<br/>" . mysqli_error($db));
	return $albumes;
}

function obtenerCanciones($db,$album,$artista){
	$canciones = array();
	$sql = "SELECT name FROM track where AlbumId=(select AlbumId from album where Title='$album' and ArtistId=(select ArtistId from artist where name='$artista'))";
	$resultado = mysqli_query($db, $sql);
	if ($resultado) {
		while ($row = mysqli_fetch_assoc($resultado)) {
			array_push($canciones,$row['name']);
		}
	}else
		trigger_error("Error: " . $sql . "<br/>" . mysqli_error($db));
	return $canciones;

}

function obtenerCodigoCancion($cancion,$db,$album){
	$codigo = null;
	$sql = "SELECT TrackId FROM track WHERE Name ='$cancion' and AlbumId=(select AlbumId from album where Title='$album')";
	$resultado = mysqli_query($db, $sql);
	if ($resultado) {
		while ($row = mysqli_fetch_assoc($resultado)) {
			$codigo = $row['TrackId'];
		}
		if($codigo==null || empty($codigo))
			trigger_error("Error: Ha habido un problema al obtener el id de la canción");
	}else
		trigger_error("Error: " . $sql . "<br/>" . mysqli_error($db));
	return $codigo;
}


function annadirAlCarrito($codigoCancion,$db){
	$anadido=false;
	if(!array_key_exists($codigoCancion,$_SESSION["carrito"])){
		$_SESSION["carrito"][$codigoCancion]=1;
		$anadido=true;
	}	 
	else{
		$_SESSION["carrito"][$codigoCancion]+=1;
		$anadido=true;
	}			
	return $anadido;	
}


function obtenerInfoCarrito($db){
	$infocarrito=array();
	foreach($_SESSION["carrito"] as $clave=>$valor){
		$sql = "SELECT UnitPrice, Name FROM track WHERE TrackId = '$clave'";
		$resultado = mysqli_query($db, $sql);
		if ($resultado) {
			while ($row = mysqli_fetch_assoc($resultado)) 
				$infocarrito[$clave]=array($valor,$row['Name'],$row['UnitPrice']);
		}
		else
			trigger_error("Error: " . $sql . "<br/>" . mysqli_error($db));
	}
	return $infocarrito;
}

?>



