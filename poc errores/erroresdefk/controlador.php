<?php
require_once 'modelo.php';
class Controlador
{
	public $modelo;

	public function __construct()
	{
		$this->modelo = new Modelo();
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
		$idReto = 0; // ÉSTE DEBERÍAN DE COGERSE DE OTRA VISTA
		$idProfesor = 1; // ÉSTE DEBERÍAN DE COGERSE DE OTRA VISTA
		return $this->modelo->altaGrupo(array($nombreGrupo, $descripcion, $idClase, $idReto, $idProfesor));
	}

	public function altaGrupoAlumno($id)
	{
		$alumnos = [];
		foreach ($_GET['alumno'] as $alumno) {
			array_push($alumnos, $alumno);
		}
		return $this->modelo->altaGrupoAlumno($alumnos, $id);
	}
}
