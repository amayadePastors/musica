
<?php

echo "<br/><br/><table border=1><tr><th>PRODUCTO</th><th>UNIDADES</th><th>PVP</th><th>PRECIO TOTAL</th></tr>";
foreach($infocarrito as $clave=>$valor){
		$pvp=(double)$valor[2];
		echo "<tr>";
		echo "<td>".$valor[1]."</td>";
		echo "<td>".$valor[0]."</td>";
		echo "<td>".$valor[2]."</td>";
		echo "<td>".$pvp*$valor[0]."</td>";
		echo "</tr>";
}

echo '<form action="confirmarcompra_controller.php" method="post">';
echo '<br/><input type="submit" value="Confirmar Compra"><br/></form>';
	

?>

