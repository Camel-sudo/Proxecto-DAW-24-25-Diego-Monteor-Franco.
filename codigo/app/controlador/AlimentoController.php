<?php
include_once("Controller.php");
include_once(MODEL_PATH . "AlimentoModel.php");
include_once(MODEL_PATH . "RegistroDiarioModel.php");

class AlimentoController extends Controller
{
    public function __construct()
    {
        parent::__construct();  
    }
    public function buscarAlimentoForm(){
        $this->vista->show("buscar-alimento");
    }
    public function buscar(){
        $query = $_GET['q'] ?? '';
        var_dump (AlimentoModel::buscar_alimento($query)); 
    }
    public function guardarSeleccion()
{
    header('Content-Type: application/json');
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    try {        
        $inputJSON = file_get_contents('php://input');
        $input = json_decode($inputJSON, true);

        $idAlimento = $input['idAlimento'] ?? null;
        $cantidad = $input['cantidad'] ?? null;

        if (!$idAlimento || !$cantidad) {
            throw new Exception("Faltan parámetros.");
        }

        $id_cliente = $_SESSION['id_cliente'] ?? null;
        if (!$id_cliente) {
            throw new Exception("Usuario no identificado.");
        }

        $alimento = AlimentoModel::get_alimento_by_id($idAlimento);
        if (!$alimento) {
            $alimentoData = $input['alimento'] ?? null;

if (!$alimento && $alimentoData) {
    $idAlimento = $alimentoData['id_alimento'] ?? null;
    $nombre = $alimentoData['nombre'] ?? null;
    $marca = $alimentoData['marca'] ?? null;
    $calorieking_id = $alimentoData['calorieking_id'] ?? null;
    $porcion_estandar = $alimentoData['porcion_estandar'] ?? 100;
    $calorias = $alimentoData['calorias'] ?? 0;
    $proteinas = $alimentoData['proteinas'] ?? 0;
    $carbohidratos = $alimentoData['carbohidratos'] ?? 0;
    $grasas = $alimentoData['grasas'] ?? 0;
    $fibra = $alimentoData['fibra'] ?? 0;
    $sodio = $alimentoData['sodio'] ?? 0;
    $ultima_actualizacion = $alimentoData['ultima_actualizacion'] ?? date('Y-m-d');

    $alimento = new Alimento(
        $idAlimento,
    $calorieking_id,
    $nombre,
    $marca,
    $porcion_estandar,
    $calorias,
    $proteinas,
    $carbohidratos,
    $grasas,
    $fibra,
    $sodio,
    $ultima_actualizacion);
    $idAlimento = AlimentoModel::guardar(
        $alimento
    );
}

        }

        $fecha = date('Y-m-d');
        $tipo = 'completo';
        //  echo json_encode(['success' => false, 'error' => $id_cliente]);
        $id_registro = RegistroDiarioModel::crear_registro_diario($id_cliente, $fecha);
        //modificar agregar alimento
        RegistroDiarioModel::agregar_alimento_registro(
        
            $idAlimento,
            $alimento->nombre,
            'almuerzo',
            $cantidad,
            'g',
            ($alimento->calorias * $cantidad) / 100,
            ($alimento->proteinas * $cantidad) / 100,
            ($alimento->carbohidratos * $cantidad) / 100,
            ($alimento->grasas * $cantidad) / 100
        );

        echo json_encode(['success' => true]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }

    exit;
}


    
}