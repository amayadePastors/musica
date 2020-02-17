<?php
require "funciones_generales.php";
set_error_handler("errores");

function confirmarCompra($db){
	$exito=false;
	$preciototal=0;
	//abrimos la transaction
	mysqli_begin_transaction($db, MYSQLI_TRANS_START_READ_WRITE);
	//lo primero, creamos el invoice, pero sin el precio total
	if(crearInvoice($db)){
		//lo siguiente es crear cada uno de los invoiceLine
		foreach($_SESSION["carrito"] as $clave=>$valor){
			$pvp=obtenerPVP($db,$clave);
			if($pvp!=null  && !empty($db)){
				if(crearInvoiceLine($db,$clave,$valor,$pvp))
					$preciototal+=($pvp*$valor);
				else{
					trigger_error ("Ha habido un error a la hora de comprar el producto " . $clave);
					mysqli_rollback($db);
				}
			}else
				trigger_error ("Ha habido un error a la hora de obtener el precio del producto " . $clave);
		}
		//por último actualizamos el precio total en el invoice
		if(actualizarPrecio($db,$preciototal)){
			//Si todo ha salido correctamente, hacemo commit para consolidar los cambios
			//mysqli_commit($db);
			$exito=true;
		}else{
			mysqli_rollback($db);
			trigger_error ("Ha habido un error a la hora actualizar el precio del producto " . $clave);
		}
		
	}
	else
		mysqli_rollback($db);
	return $exito;
}

function obtenerPVP($db,$codigoproducto){
	$pvp;
	$sql = "SELECT UnitPrice as PVP FROM track WHERE TrackId = '$codigoproducto'";
	$resultado = mysqli_query($db, $sql);
	if ($resultado) {
		while ($row = mysqli_fetch_assoc($resultado)) 
			$pvp = $row['PVP'];
	}
	return $pvp;
}

function generarInvoiceId($db){
	$sql = "SELECT max(InvoiceId) as MAXIMO FROM invoice";
	$codigo;
	$resultado = mysqli_query($db, $sql);
	if ($resultado) {
		while ($row = mysqli_fetch_assoc($resultado)) 
			$codigo=$row['MAXIMO']+1;
	}
	else 
		trigger_error("Error: " . $sql . "<br/>" . mysqli_error($db));
		
	return $codigo;
}

function generarInvoiceLineId($db){
	$sql = "SELECT max(InvoiceLineId) as MAXIMO FROM invoiceLine";
	$codigo;
	$resultado = mysqli_query($db, $sql);
	if ($resultado) {
		while ($row = mysqli_fetch_assoc($resultado)) 
			$codigo=$row['MAXIMO']+1;
	}
	else 
		trigger_error("Error: " . $sql . "<br/>" . mysqli_error($db));
		
	return $codigo;
}

function crearInvoice($db){
	$creado=false;
	$id=$_SESSION['id'];
	//Lo primero, obtenemos los datos del cliente
	$sql = "Select Address, City, State, Country, PostalCode from Customer where CustomerId='$id'";
	$resultado = mysqli_query($db, $sql);
	if ($resultado) {
		while ($row = mysqli_fetch_assoc($resultado)) {
			$address = $row['Address'];
			$city = $row['City'];
			$state = $row['State'];
			$country = $row['Country'];
			$postalcode = $row['PostalCode'];
		}
		//obtenemos el invoiceId
		$invoiceId=generarInvoiceId($db);
		$_SESSION["invoiceId"] =$invoiceId;

		//creamos el invoice
		$sql2 ="insert into invoice (InvoiceId,CustomerId,InvoiceDate,BillingAddress,BillingCity,BillingState,BillingCountry,BillingPostalCode,Total) values ('$invoiceId','$id',sysdate(),'$address','$city','$state','$country','$postalcode','0')";
		if (mysqli_query($db, $sql2)) {
			$creado=true;
		} else 
			trigger_error("Error: " . $sql2 . "<br/>" . mysqli_error($db));
	}else
		trigger_error("Error: " . $sql . "<br/>" . mysqli_error($db));
		
	return $creado;

}

function crearInvoiceLine($db,$clave,$valor,$pvp){
	$creado=false;
	$id=$_SESSION['id'];
	$invoiceid=$_SESSION['invoiceId'];
	$invoicelineid=generarInvoiceLineId($db);
	$sql = "insert into invoiceLine (InvoiceLineId,InvoiceId,TrackId,UnitPrice,Quantity) values ('$invoicelineid','$invoiceid','$clave','$pvp','$valor')";
	if (mysqli_query($db, $sql)) {
		$creado=true;
	} else 
		trigger_error("Error: " . $sql . "<br/>" . mysqli_error($db));
	
	return $creado;
}


function actualizarPrecio($db,$preciototal){
	$actualizado=false;
	$invoiceid=$_SESSION['invoiceId'];
	$sql = "update invoice set Total = '$preciototal' where InvoiceId='$invoiceid'";
	if (mysqli_query($db, $sql)) 
		$actualizado=true;
	return $actualizado;

}
