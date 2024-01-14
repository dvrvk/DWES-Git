<?php 

if(!empty($_POST)){
  $respuesta = $_POST['usuario'];
  echo filter_var($respuesta, FILTER_VALIDATE_REGEXP, ["options" => ["regexp" => "/d*a/"]]); 
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expresiones</title>
</head>
<body>
<form action="" method="post">
	<input type="text" name="usuario" id="usuario" placeholder="Introduce entre 6 y 12 caracteres" required></input>
	<input type="submit" value="Enviar">
</form>
</body>
</html>