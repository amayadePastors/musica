<html>
<head>
    <meta charset="UTF-8">
    <title>Web Musica</title>
</head>
<body>
	<h3>Top 10 descargas </h3>
	<?php 
		foreach($canciones as $clave=>$valor) : 
				echo "N. descargas: " .$valor . "    Cancion: ". $clave . "</br>";
		endforeach; 
	?>

</body>

</html>
