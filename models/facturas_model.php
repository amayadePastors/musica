<?php
include "funciones_generales.php";
set_error_handler("errores");

function infoFacturasEntreFechas($fechaini,$fechafin,$cliente,$db){
	$infofacturas=array();
	$sql = "SELECT invoice.InvoiceId, invoice.InvoiceDate, invoice.Total,invoiceLine.InvoiceLineId, track.Name as CANCION, album.Title, artist.Name, mediatype.Name as TIPO, invoiceLine.UnitPrice, invoiceLine.Quantity  
			FROM track,invoiceline,mediatype,album,artist,invoice WHERE artist.ArtistId=album.ArtistId and album.AlbumId=track.AlbumId 
			and track.TrackId=invoiceline.TrackId and mediatype.MediaTypeId=track.MediaTypeId and invoiceline.InvoiceId=invoice.InvoiceId 
			and CustomerId='$cliente' and date_format(InvoiceDate,'%Y-%m-%d') >='$fechaini' && date_format(InvoiceDate,'%Y-%m-%d') <='$fechafin' order by invoice.InvoiceId,invoiceLine.InvoiceLineId ASC";		
	$resultado = mysqli_query($db, $sql);
	if ($resultado) {
		$invoiceid=0;
		while ($row = mysqli_fetch_assoc($resultado)) {
			if($invoiceid!=$row['InvoiceId']){
				$invoiceid=$row['InvoiceId'];
				$infofacturas[$invoiceid]=array('fecha'=>$row['InvoiceDate'],'total'=>$row['Total'],'canciones'=>array());
			}
			array_push($infofacturas[$invoiceid]['canciones'],array($row['InvoiceLineId'],$row['CANCION'],$row['Title'],$row['Name'],$row['TIPO'],$row['UnitPrice'],$row['Quantity']));	
		}
		
	}else
		trigger_error("Error: " . $sql . "<br/>" . mysqli_error($db));
	
	return $infofacturas;
}
	
?>
