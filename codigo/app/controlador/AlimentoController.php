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
    public function buscarAlimentoForm() {
        $fecha = $_GET['fecha'] ?? date('Y-m-d');
        $momento = $_GET['momento'] ?? 'almuerzo';

        $fecha = htmlspecialchars($fecha, ENT_QUOTES, 'UTF-8');
        $momento = htmlspecialchars($momento, ENT_QUOTES, 'UTF-8');

        $this->vista->show("buscar-alimento", [
            "fecha" => $fecha,
            "momento" => $momento
        ]);
    }
    
    public function buscar() {
        $q = $_GET['q'] ?? '';
        if (empty($q)) {
            echo json_encode(['error' => 'No se proporcionó término de búsqueda']);
            return;
        }
        $resultados = AlimentoModel::buscarCombinado($q);
    
        header('Content-Type: application/json');
        echo json_encode($resultados);
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

        if (!$cantidad) {
            throw new Exception("Falta la cantidad.");
        }

        $id_cliente = $_SESSION['id_cliente'] ?? null;
        if (!$id_cliente) {
            throw new Exception("Usuario no identificado.");
        }

        $fecha = $input['fecha'] ?? date('Y-m-d');
        $momento_dia = $input['momento_dia'] ?? 'almuerzo';

        $alimento = null;

        if ($idAlimento) {
            // Si viene idAlimento, busca el alimento
            $alimento = AlimentoModel::get_alimento_by_id($idAlimento);
        }

        if (!$alimento) {
            // Si no existe alimento, intenta crear uno nuevo
            $alimentoData = $input['alimento'] ?? null;

            if (!$alimentoData) {
                throw new Exception("No se proporcionó información para crear el alimento.");
            }

            $idAlimento = $alimentoData['id_alimento'] ?? null;
            $nombre = $alimentoData['nombre'] ?? null;
            if (!$nombre) {
                throw new Exception("El nombre del alimento es obligatorio.");
            }
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
                $ultima_actualizacion
            );

            $idAlimento = AlimentoModel::guardar($alimento);
        }

        $id_registro = RegistroDiarioModel::crear_registro_diario($id_cliente, $fecha);

        RegistroDiarioModel::agregar_alimento_registro(
            $id_registro,
            $idAlimento,
            $alimento->nombre,
            $momento_dia,
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