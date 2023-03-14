<?php

require_once 'controlador.php';

$controlador = new Controlador();
$clases = $controlador->getClases();
$mensajeAlertas = '';
if (is_string($clases)) {
	echo ($clases);

	switch ($clases) {
		case '42S02':
			$mensajeAlertas = 'La consulta de obtener clases está mal';
			break;
	}
}


if (!isset($_GET['ngrupo'])) {
	$mensaje = "No existe ultimo grupo insertado";
} else {
	$idUltimo = $controlador->altaGrupo();
	if ($idUltimo > 0) {
		$mensaje = "insertado, id último: " . $idUltimo;
		$controlador->altaGrupoAlumno($idUltimo);
	} else {
		$mensaje = "Ha habido un rollback";
	}
}

?>


<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Alta grupos</title>
</head>

<body>




	<div>
		<form action="index.php" method="get">
			<legend>Inscripcion Grupo</legend>
			<div>
				<label for="ngrupo">Nombre Grupo</label>
				<input type="text" name="ngrupo" id="ngrupo" />
			</div>
			<div>
				<label for="descripcion">Descripcion</label>
				<input type="text" name="descripcion" id="descripcion" />
			</div>
			<div>
				<select name="clase">
					<?php foreach ($clases as $c) : ?>
						<option value="<?php echo $c->id ?>"><?php echo $c->nombre ?></option>
					<?php endforeach; ?>
				</select>

			</div>
			<div>
				<label for="alumno1">Alumno 1</label>
				<input type="text" name="alumno1" id="alumno1" />
			</div>
			<div>
				<label for="alumno2">Alumno 2</label>
				<input type="text" name="alumno2" id="alumno2" />
			</div>
			<div>
				<label for="alumno3">Alumno 3</label>
				<input type="text" name="alumno3" id="alumno3" />
			</div>

			<p><?php echo $mensaje ?></p>
			<p><?php echo $mensajeAlertas ?></p>


			<button type="submit">ENVIAR</button>
		</form>
	</div>

</body>

</html>