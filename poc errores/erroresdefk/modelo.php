<?php


class Modelo
{
	private $conexion;
	public $nombreGrupo;
	public $idClase;
	public $descripcion;

	public $idReto;
	public $idProfesor;

	public function __construct()
	{
		$this->conexion = new PDO('mysql:host=localhost;dbname=retosevg;charset=utf8', 'root', '');
	}

	public function getClases()
	{
		try {
			$clases = $this->conexion->query('SELECT * FROM clase');
			return $clases->fetchAll(PDO::FETCH_OBJ);
		} catch (Exception $e) {
			return $clases->errorInfo();
		}
	}

	public function altaGrupo($data)
	{
		try {
			$this->nombreGrupo = $data[0];
			if ($data[1] == '') {
				$tmp = NULL;
				$this->descripcion = $tmp;
			} else {
				$this->descripcion = $data[1];
			}
			$this->idClase = $data[2];
			$this->idReto = $data[3];
			$this->idProfesor = $data[4];
			$insert = $this->conexion->prepare('INSERT INTO grupo (nombre, descripcion, idClase, idReto, idProfesor) VALUES (?, ?, ?, ?, ?)');
			$insert->execute(array($this->nombreGrupo, $this->descripcion, $this->idClase, $this->idReto, $this->idProfesor));
			return $this->conexion->lastInsertId();
		} catch (PDOException $e) {
			return $insert->errorInfo();
		}
	}

	public function altaGrupoAlumno($alumnos, $id)
	{

		try {
			$insert = $this->conexion->prepare('INSERT INTO alumno (idGrupo, nombre) VALUES (?,?)');
			foreach ($alumnos as $alumno) {
				$insert->execute(array($id, $alumno));
			}
		} catch (PDOException $e) {
			return $insert->errorInfo();
		}
	}
}
