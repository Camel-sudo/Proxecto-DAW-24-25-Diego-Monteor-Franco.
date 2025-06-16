<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once("Controller.php");
include_once(MODEL_PATH . "ClienteModel.php");

class ClienteController extends Controller
{
    public function altaCliente()
    {
        header('Content-Type: application/json');

        try {
            $inputJSON = file_get_contents('php://input');
            $input = json_decode($inputJSON, true);

            $id_usuario = $input['id_usuario'] ?? null;
            $id_nutricionista = $_SESSION['id_nutricionista'] ?? null;

            if (!$id_usuario || !$id_nutricionista) {
                throw new Exception("Faltan parámetros.");
            }

            $id_cliente = ClienteModel::altaCliente($id_usuario, $id_nutricionista);
            echo json_encode(['success' => true, 'id_cliente' => $id_cliente]);

        } catch (Exception $e) {
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }

        exit;
    }

    public function seleccionarPaciente()
{
    header('Content-Type: application/json');

    try {
        $input = json_decode(file_get_contents("php://input"), true);


        $id_cliente = $input['id_cliente'] ?? null;

        if (!$id_cliente) {
            throw new Exception("ID cliente no proporcionado.");
        }

        $_SESSION['id_cliente'] = $id_cliente;

        echo json_encode(['success' => true]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }

    exit;
}


    public function clientesDisponibles()
    {
        header('Content-Type: application/json');

        try {
            $usuarios = ClienteModel::obtenerClientesDisponibles();
            echo json_encode(['success' => true, 'usuarios' => $usuarios]);

        } catch (Exception $e) {
            echo json_encode(['success' => false, 'error' => 'Error al obtener usuarios disponibles']);
        }

        exit;
    }

    public function eliminarCliente()
    {
        header('Content-Type: application/json');

        try {
            $inputJSON = file_get_contents('php://input');
            $input = json_decode($inputJSON, true);
            $id_cliente = $input['id_cliente'] ?? null;

            if (!$id_cliente) {
                throw new Exception("Falta el ID del cliente.");
            }

            $success = ClienteModel::eliminarCliente($id_cliente);

            echo json_encode(['success' => $success]);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }

        exit;
    }

    public function obtenerClientes()
    {
        header('Content-Type: application/json');

        try {
            $id_nutricionista = $_SESSION['id_nutricionista'] ?? null;

            if (!$id_nutricionista) {
                throw new Exception("Usuario no autenticado.");
            }

            $clientes = ClienteModel::obtenerClientesPorNutricionista($id_nutricionista);
            echo json_encode(['success' => true, 'clientes' => $clientes]);

        } catch (Exception $e) {
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }

        exit;
    }

    public function editarCliente()
    {
        header('Content-Type: application/json');

        try {
            $inputJSON = file_get_contents('php://input');
            $input = json_decode($inputJSON, true);

            $id_cliente = $input['id_cliente'] ?? null;
            $datos = $input['datos'] ?? null;

            if (!$id_cliente || !$datos || !isset($datos['nombre'], $datos['apellidos'])) {
                throw new Exception("Faltan datos obligatorios.");
            }

            $success = ClienteModel::editarCliente($id_cliente, $datos);
            echo json_encode(['success' => $success]);

        } catch (Exception $e) {
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }

        exit;
    }
}
