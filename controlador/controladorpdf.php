<?php

use Shuchkin\SimpleXLSX;

require_once 'modelo/profesor.php';
require_once 'modelo/reto.php';
require_once 'modelo/pdf.php';
require_once 'modelo/SimpleXLSX.php';

class ControladorPDF
{
    private $modeloprofesores;
    private $modeloretos;
    /**
     * Constructor
     * Inicializa los modelos que se van a utilizar en funcionalidades varias
     */
    public function __construct()
    {
        $this->modeloprofesores = new Profesor();
        $this->modeloretos = new Reto();
    }
    /**
     * Función que carga el index de Varios
     */
    public function index()
    {
        $idProfesor = $_SESSION['user'];
        $profesor = $this->modeloprofesores->obtenerNombre($idProfesor);
        require_once 'vista/headeruser.php';
        require_once 'vista/pdf/index.php';
    }

    /**
     * Genera un PDF con todos los retos
     */
    public function generarretos()
    {
        $retos = $this->modeloretos->listarRetos();
        $pdf = new PDF();
        $pdf->AliasNbPages();
        $pdf->AddPage();
        $pdf->SetFont('Times', '', 12);
        $header = array('Nombre', 'Profesor', 'Dirigido', 'Inicio Reto', 'Fin Reto');
        $pdf->tablaretos($header, $retos, $this->modeloprofesores);
        /**No me enteré que habia que hacer un salto de página por lo que genero otra página */
        $pdf->AddPage();
        /** Y pongo de nuevo otra tabla igual pero con los retos no publicados*/
        $retosno = $this->modeloretos->listarNoPublicados();
        $pdf->tablaretos($header, $retosno, $this->modeloprofesores);
        $pdf->Output('retos.pdf', 'D');
    }

    /**
     * Genera un pdf con los profesores que están en la BBDD
     */
    public function generarprof()
    {
        $profesores = $this->modeloprofesores->listar();
        $pdf = new PDF();
        $pdf->AliasNbPages();
        $pdf->AddPage();
        $pdf->SetFont('Times', '', 12);
        $header = array('Nombre', 'Correo');
        $pdf->tablaprofesores($header, $profesores);
        $pdf->Output('profesores.pdf', 'D');
    }
    /**
     * Función que lee un archivo excel cargado a traves del input y añade los datos a la BBDD
     */
    public function actualizarprofesores()
    {
        /**Subo archivo */
        $fileTmpPath = $_FILES['docprofesores']['tmp_name'];
        $fileName = $_FILES['docprofesores']['name'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        /**Compruebo si es un xlsx */
        $allowedfileExtensions = array('xlsx');
        if (in_array($fileExtension, $allowedfileExtensions)) {
            /**Lo guardo en la carpeta para actualizarlo luego */
            $uploadFileDir = './assets/uploads/';
            $dest_path = $uploadFileDir . 'profesores.' . $fileExtension;
            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                $message = 'Archivo subido correctamente';
            } else {
                $message = 'Algo ocurrió al subir el archivo al servidor.';
            }

            /**Lo leo */
            if ($xlsx = SimpleXLSX::parse($dest_path)) {
                $this->modeloprofesores->inserccionmasiva($xlsx->rows());
                header('Location: index.php');
            } else {
                echo SimpleXLSX::parseError();
            }
        }
    }
}
