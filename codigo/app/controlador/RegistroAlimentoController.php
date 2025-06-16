<?php
include_once("Controller.php");
include_once(MODEL_PATH . "RegistroAlimentoModel.php");

class RegistroAlimentoController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function modificar()
{
    header('Content-Type: application/json');

    if (empty($_SESSION['usuario_id'])) {
        echo json_encode(['success' => false, 'error' => 'No autorizado']);
        exit;
    }
    $data = json_decode(file_get_contents("php://input"), true);
    if (!$data) {
        echo json_encode(['success' => false, 'error' => 'Datos JSON inválidos']);
        exit;
    }

    if (!isset($data['id'])) {
        echo json_encode(['success' => false, 'error' => 'ID inválido o no proporcionado.']);
        exit;
    }

    $campos = ['cantidad', 'calorias', 'proteinas', 'carbohidratos', 'grasas'];
    $errores = [];
    foreach ($campos as $campo) {
        if (!isset($data[$campo])) {
            $errores[] = "Falta el campo obligatorio: $campo.";
        } elseif (!is_numeric($data[$campo]) || $data[$campo] < 0) {
            $errores[] = "El campo $campo debe ser un número no negativo.";
        }
    }

    if (count($errores) > 0) {
        echo json_encode(['success' => false, 'error' => $errores]);
        exit;
    }

    try {
        $resultado = RegistroAlimentoModel::modificarAlimento($data);
        echo json_encode(['success' => $resultado]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }

    exit;
}



    public function eliminar()
    {
        header('Content-Type: application/json');
        $data = json_decode(file_get_contents("php://input"), true);

        if (!isset($data['id'])) {
            echo json_encode(['success' => false, 'error' => 'ID no proporcionado.']);
            return;
        }

        try {
            $resultado = RegistroAlimentoModel::eliminarAlimento($data['id']);
            echo json_encode(['success' => $resultado]);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
    }
}
