<?php
require_once 'modelo.php';
class Controlador
{
	public $modelo;

	public function __construct()
	{
		$this->modelo = new Modelo();
		if (is_null($this->modelo->conexion))
			header('Location: vistaerrores.php');
	}

	public function getClases()
	{
		return $this->modelo->getClases();
	}

	public function altaGrupo()
	{

		$nombreGrupo = $_GET['ngrupo'];
		$idClase = $_GET['clase'];
		$descripcion = $_GET['descripcion'];
		$idReto = 1; // ÉSTE DEBERÍAN DE COGERSE DE OTRA VISTA
		$idProfesor = 2; // ÉSTE DEBERÍAN DE COGERSE DE OTRA VISTA
		return $this->modelo->altaGrupo(array($nombreGrupo, $descripcion, $idClase, $idReto, $idProfesor));
	}

	public function altaGrupoAlumno($id)
	{
		$alumno1 = $_GET['alumno1'];
		$alumno2 = $_GET['alumno2'];
		$alumno3 = $_GET['alumno3'];

		return $this->modelo->altaGrupoAlumno(array($alumno1, $alumno2, $alumno3, $id));
	}
}
