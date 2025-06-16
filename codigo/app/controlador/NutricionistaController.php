<?php
include_once("Controller.php");
include_once(MODEL_PATH . "NutricionistaModel.php");

class NutricionistaController extends Controller
{
    public function misPacientes(){
        $this->vista->show("mis-pacientes");
    }
    public function altaNutricionista()
    {
        header('Content-Type: application/json');
        try {
            $inputJSON = file_get_contents('php://input');
            $input = json_decode($inputJSON, true);

            $id_usuario = $input['id_usuario'] ?? null;
            if (!$id_usuario) {
                throw new Exception("Falta id_usuario.");
            }

            $id_nutricionista = NutricionistaModel::altaNutricionista($id_usuario);

            echo json_encode(['success' => true, 'id_nutricionista' => $id_nutricionista]);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
        exit;
    }
}
