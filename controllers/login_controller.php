<?php
// Llamada al fichero que inicia la conexión a la Base de Datos
require_once "db/conexion.php";
// Llamada al modelo de login
require_once "models/login_model.php";

//muestra el formulario
?>
<html>
<head>
    <meta charset="UTF-8">
    <title>Web Musica</title>
</head>

<body>
	<h1>LOGIN</h1>
	<form  action="" method="post">
		<label for="username">Nombre de usuario:</label>
		<input type='text' name='username' value='' size=9><br/>
		<br/>
		<label for="passcode">Password:</label>
		<input type='text' name='passcode' value='' size=40><br/>
		<br/>
		</br>
		<input type="submit" value="Acceder al Portal">
		</br>
	</form>
</body>
</html>

<?php
if (isset($_POST) && !empty($_POST)) {
	if(loguearse($db)){
		header("Location: views/inicio.php");
		exit();	
	}
}
mysqli_close($db);
?>



