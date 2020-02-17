<html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Web Musica</title>
	<style>
	th{
		color:#454952;
	}
		td{
			text-align:center;
			color:darkblue;
		}
		.order{
			color:darkgreen;
			font-weight:bold;
		}
		table{
			margin:15px 0 15px  5%;
			width:90%;
			
		}
	</style>
</head>
<body>
	<h1>Histórico Facturas</h1>
		<table border=3 width='90%'>
		<?php foreach($facturas as $clave=>$valor){?>
			<tr>
				<th>
					<table width='90%'>
						<tr>
							<th>INVOICE ID</th>
							<th>INVOICE DATE</th>
							<th>TOTAL</th>
						</tr>
						<tr>
							<td class='order'><?php echo $clave ?></td>
							<td class='order'><?php echo $valor['fecha'] ?></td>
							<td class='order'><?php echo $valor['total'] ?></td>
						</tr>	
					</table>
				</th>
			</tr>
					
			<tr>
				<td>
					<table width='90%'>
						<tr>
							<th>LINE NUMBER</th>
							<th>CANCION</th>
							<th>ALBUM</th>
							<th>ARTISTA</th>
							<th>TIPO</th>
							<th>PVP</th>
							<th>CANTIDAD</th>
						</tr>
					<?php 
						foreach ($valor['canciones'] as $cancion){ ?>
						<tr>
							<td><?php echo $cancion[0] ?></td>
							<td><?php echo $cancion[1] ?></td>
							<td><?php echo $cancion[2] ?></td>
							<td><?php echo $cancion[3] ?></td>
							<td><?php echo $cancion[4] ?></td>
							<td><?php echo $cancion[5] ?></td>
							<td><?php echo $cancion[6] ?></td>
						</tr>
					<?php } ?>
					</table>
				</td>
			</tr>
					
			<?php } ?>
		
		</table>
		
	<br/><a href="../views/inicio.php">Volver al menu Principal</a>
	<br/><a href="logout_controller.php">Cerrar Sesion</a>
</body>
</html>
