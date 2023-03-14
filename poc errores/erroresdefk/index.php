<?php

require_once 'controlador.php';

$controlador = new Controlador();
$clases = $controlador->getClases();
$mensajeUsuario = '';

if (!isset($_GET['ngrupo'])) {
	$mensaje = "No se ha insertado nada aún";
} else {
	$resultado = $controlador->altaGrupo();
	if (is_array($resultado)) {
		$error = $resultado;
		switch ($error[1]) {
			case 1452:
				if ($error[2] === 'Cannot add or update a child row: a foreign key constraint fails (`retosevg`.`grupo`, CONSTRAINT `FK_reto_idReto` FOREIGN KEY (`idReto`) REFERENCES `reto` (`id`))')
					$mensaje = 'Reto no válido';
				if ($error[2] === 'Cannot add or update a child row: a foreign key constraint fails (`retosevg`.`grupo`, CONSTRAINT `FK_profesor_idProfesor` FOREIGN KEY (`idProfesor`) REFERENCES `profesor` (`id`))')
					$mensaje = 'Profesor no válido';
				break;

			default:
				$mensaje = $error[2];
				break;
		}
	} else {
		$mensaje = "Id Grupo insertado: " . $resultado;
		$controlador->altaGrupoAlumno($resultado);
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
				<label for="alumno">Alumno 1</label>
				<input type="text" name="alumno[]" id="alumno1" />
			</div>
			<div>
				<label for="alumno">Alumno 2</label>
				<input type="text" name="alumno[]" id="alumno2" />
			</div>
			<div>
				<label for="alumno">Alumno 3</label>
				<input type="text" name="alumno[]" id="alumno3" />
			</div>

			<p><?php echo $mensaje ?></p>


			<button type="submit">ENVIAR</button>
		</form>
	</div>

</body>

</html>