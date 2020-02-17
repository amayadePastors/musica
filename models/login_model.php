<?php
require "funciones_generales.php"; 
set_error_handler("errores");

function loguearse($db){
	$escorrecto=false;
	$nombre=limpiarCampo($_POST['username']);
	$password=limpiarCampo($_POST['passcode']);
	$customerId=comprobarLogin($db,$nombre,$password);
	
	if($customerId!=null && !empty($customerId)){	
		session_start();
		$_SESSION["username"] =$nombre;
		$_SESSION["id"] =$customerId;
		$_SESSION["carrito"]=array();
		$escorrecto=true;
	}
	else
		trigger_error ("El usuario y/o la contrasena no son correctos");			
	
	return $escorrecto;
}

function comprobarLogin($db,$nombre,$password){
	$customerId=null;
	$sql = "SELECT CustomerId FROM customer WHERE FirstName ='$nombre' and LastName='$password'";
	$resultado = mysqli_query($db, $sql);
	if($resultado){
		if(mysqli_num_rows($resultado) == 1){
			$row = mysqli_fetch_assoc($resultado);
			$customerId= $row['CustomerId'];		
		}
	}
	else
		trigger_error("Error: " . $sql . "<br/>" . mysqli_error($db));
		
	return $customerId;
}
	
?>




