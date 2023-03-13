<?php

/**
 * Modelo Profesor
 */
class Profesor
{

    private $conexion;
    public $id;
    public $nombre;
    public $correo;
    public $password;

    /**
     * Constructor 
     * Conecta con al BBDD
     */
    public function __construct()
    {
        try {
            $this->conexion = Conexion::conectar();
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    /**
     * Funcion que lista todos los profesores
     * @return Array listado de profesores
     */
    public function listar()
    {
        try {
            $consulta = $this->conexion->prepare("SELECT * FROM profesores ORDER BY id ASC");
            $consulta->execute();
            return $consulta->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    /**
     * Función para obtener el nombre de un profesor según su id
     * @param Number $id
     * @return Object Profesor | undefined
     */
    public function obtenerNombre($id)
    {
        try {
            $consulta = $this->conexion->prepare("SELECT * FROM profesores WHERE id = ?");
            $consulta->execute([$id]);
            return $consulta->fetch(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    /**
     * Función que comprueba que el correo y la contraseña son correctas
     * @param String $correo
     * @param String $pass
     * @return Object Si encuentra coincidencia, devuelve un Objeto profesor
     */
    public function comprobar_old($correo, $pass)
    {
        try {
            $sql = "SELECT * FROM profesores WHERE correo = :correo AND pass = :pass";
            $consulta = $this->conexion->prepare($sql);
            $consulta->execute(array('correo' => $correo, 'pass' => $pass));

            if ($consulta->rowCount()) {
                // session_start();
                return $consulta->fetch(PDO::FETCH_OBJ);
            } else
                return false;
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    /**
     * Función que inserta un nuevo profesor en la BBDD
     * @param Profesor $data
     * @return Boolean devuelve true o false
     */
    public function addUser(Profesor $data)
    {
        try {
            $sql = "INSERT INTO profesores (nombre,correo,pass) VALUES (:nombre, :correo, :pass)";
            $insert = $this->conexion->prepare($sql);
            return $insert->execute(array('nombre' => $data->nombre, 'correo' => $data->correo, 'pass' => password_hash($data->password, PASSWORD_DEFAULT)));
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    /**
     * Comprueba que el usuario/contraseña introducidos son válidos
     * @param String $correo
     * @param String $pass
     * @return Profesor || false 
     */
    public function comprobar($correo, $pass)
    {
        try {
            $sql = "SELECT * FROM profesores WHERE correo = :correo";
            $consulta = $this->conexion->prepare($sql);
            $consulta->execute(array('correo' => $correo));

            if ($consulta->rowCount()) {
                $profesor = $consulta->fetch(PDO::FETCH_OBJ);
                if (password_verify($pass, $profesor->pass))
                    return $profesor;
            } else
                return false;
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    /**
     * Función que inserta profesores que vengan en el array
     * Utilizado con la insercción con excel
     * No controlados los posibles fallos
     * @param Array de Profesores 
     */
    public function inserccionmasiva($array)
    {
        $sql = "INSERT INTO profesores (nombre,correo,pass) VALUES (:nombre, :correo, :pass)";
        $consulta = $this->conexion->prepare($sql);

        foreach ($array as $r) {
            $consulta->execute(array('nombre' => $r[0], 'correo' => $r[1], 'pass' => password_hash($r[2], PASSWORD_DEFAULT)));
        }
    }
}
