<?php
function limpiarCampo($campoformulario) {
  $campoformulario = trim($campoformulario); 
  $campoformulario = stripslashes($campoformulario); 
  $campoformulario = htmlspecialchars($campoformulario);  

  return $campoformulario;   
}

function errores ($error_level,$error_message,$error_file,$error_line){
	echo "<br/>Codigo error: $error_level  </br> Mensaje: $error_message </br>FILE: $error_file </br>LINE: $error_line </br></br>";
}
?>
