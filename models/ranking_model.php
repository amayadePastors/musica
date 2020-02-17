<?php
include "funciones_generales.php";
set_error_handler("errores");

function obtenerRanking($fechaini,$fechafin,$db){
	$canciones = array();
	$sql="select count(invoiceline.TrackId), sum(invoiceline.Quantity) as DESCARGAS,track.Name from invoiceline,track,invoice where invoiceline.TrackId=track.TrackId and invoice.InvoiceId=invoiceline.InvoiceId and date_format(invoice.InvoiceDate,'%Y-%m-%d') >='$fechaini' and date_format(invoice.InvoiceDate,'%Y-%m-%d') <='$fechafin' group by invoiceline.TrackId order by sum(invoiceline.Quantity) desc limit 10";
	$resultado = mysqli_query($db, $sql);
	if ($resultado) {
		while ($row = mysqli_fetch_assoc($resultado)) 
			$canciones[$row['Name']] = $row['DESCARGAS'];		
		
	}else
		trigger_error("Error: " . $sql . "<br/>" . mysqli_error($db));

	return $canciones;
}
	
?>
