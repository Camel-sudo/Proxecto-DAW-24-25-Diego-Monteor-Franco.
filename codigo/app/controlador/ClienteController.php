<?php
include_once("Controller.php");
include_once(MODEL_PATH . "ClienteModel.php");
include_once(MODEL_PATH . "UsuarioModel.php");
include_once(MODEL_PATH . "ConectionDB.php");
class ClienteController extends Controller {

    public function guardarCliente()
    {
        header('Content-Type: application/json');
        try {
            if (!isset($_POST['id_usuario'])) {
                throw new Exception("Falta el parámetro id_usuario");
            }
            $id_usuario = $_POST['id_usuario'];
            $guardado = ClienteModel::guardar_cliente($id_usuario);

            if ($guardado) {
                echo json_encode(['success' => true]);
            } else {
                throw new Exception("No se pudo guardar el cliente.");
            }
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
        exit;
    }

    public function añadirCliente()
    {
        header('Content-Type: application/json');
        try {
            if (!isset($_POST['id_cliente']) || !isset($_POST['id_nutricionista'])) {
                throw new Exception("Faltan parámetros.");
            }

            $id_cliente = $_POST['id_cliente'];
            $id_nutricionista = $_POST['id_nutricionista'];

            $actualizado = ClienteModel::añadir_cliente_a_nutricionista($id_cliente, $id_nutricionista);

            if ($actualizado) {
                echo json_encode(['success' => true]);
            } else {
                throw new Exception("No se pudo asignar el cliente.");
            }
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
        exit;
    }
}
