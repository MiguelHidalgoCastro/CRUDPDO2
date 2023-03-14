<?php

class Modelo
{
	public $conexion;
	public $nombreGrupo;
	public $idClase;
	public $descripcion;

	public $idReto;
	public $idProfesor;

	public function __construct()
	{
		try {
			$this->conexion = new PDO('mysql:host=localhost;dbname=retosevg', 'root', '');
			$this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch (Exception $e) {
			return $e->getMessage();
		}
	}

	public function getClases()
	{
		try {
			$clases = $this->conexion->query('SELECT * FROM clase');
			return $clases->fetchAll(PDO::FETCH_OBJ);
		} catch (Exception $e) {
			return $e->getCode();
		}
	}

	public function altaGrupo($data)
	{
		try {
			$this->conexion->beginTransaction();
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

			$insert = $this->conexion->prepare('INSERT INTO grupos (nombre, descripcion, idClase, idReto, idProfesor) VALUES (?, ?, ?, ?, ?)');
			$resultado = $insert->execute(array($this->nombreGrupo, $this->descripcion, $this->idClase, $this->idReto, $this->idProfesor));
			if ($resultado) {
				$ultimo = $this->conexion->lastInsertId();
				$this->conexion->commit();
				return $ultimo;
			} 
		} catch (Exception $e) {
			$this->conexion->rollBack();
			// return $e->getCode();
		}
	}

	public function altaGrupoAlumno($data)
	{

		try {
			$insert = $this->conexion->prepare('INSERT INTO alumno (idGrupo, nombre) VALUES (?,?)');
			$insert->execute(array($data[3], $data[0]));
			$insert->execute(array($data[3], $data[1]));
			$insert->execute(array($data[3], $data[2]));
		} catch (PDOException $e) {
			die($e->getMessage());
		}
	}
}
