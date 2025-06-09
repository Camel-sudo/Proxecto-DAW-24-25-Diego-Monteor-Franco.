<?php
include_once("Controller.php");
include_once(MODEL_PATH . "RegistroDiarioModel.php");

class RegistroDiarioController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    private function obtenerDietas($id_cliente, $fecha = null) {
        return RegistroDiarioModel::obtener_registros_con_alimentos($id_cliente, $fecha);
    }
    
    public function misDietas()
{
    $id_cliente = $_SESSION['id_cliente'] ?? null;
    if (!$id_cliente) {
        $this->vista->show("error", ["mensaje" => "No estás autenticado."]);
        return;
    }

    $fecha = $_GET['fecha'] ?? null;
    try {
        $dietas = $this->obtenerDietas($id_cliente, $fecha);
        $this->vista->show("mis-dietas", ["dietas" => $dietas]);
    } catch (Exception $e) {
        $this->vista->show("error", ["mensaje" => "Error al cargar las dietas: " . $e->getMessage()]);
    }
}

public function ajaxMisDietas()
{
    header('Content-Type: application/json');
    $id_cliente = $_SESSION['id_cliente'] ?? null;
    $fecha = $_GET['fecha'] ?? null;

    if (!$id_cliente) {
        echo json_encode(['success' => false, 'error' => 'No estás autenticado.']);
        return;
    }

    try {
        $dietas = $this->obtenerDietas($id_cliente, $fecha);
        echo json_encode(['success' => true, 'dietas' => $dietas]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
}


}
