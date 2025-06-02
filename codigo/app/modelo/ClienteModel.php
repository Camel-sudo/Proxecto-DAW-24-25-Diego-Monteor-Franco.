<?php
include_once(MODEL_PATH . "UsuarioModel.php");
class ClienteModel
{
    public static function guardar_cliente($id_usuario)
    {
        $db = ConnectionDB::get();

        $sql = "INSERT INTO cliente (id_usuario, id_nutricionista) VALUES (?, NULL)";
        $stmt = $db->prepare($sql);
        return $stmt->execute([$id_usuario]);
    }

    public static function añadir_cliente_a_nutricionista($id_cliente, $id_nutricionista)
    {
        $db = ConnectionDB::get();

        $sql = "UPDATE cliente SET id_nutricionista = ? WHERE id_cliente = ?";
        $stmt = $db->prepare($sql);
        return $stmt->execute([$id_nutricionista, $id_cliente]);
    }

    public static function get_cliente_by_usuario($id_usuario)
    {
        $db = ConnectionDB::get();

        $sql = "SELECT * FROM cliente WHERE id_usuario = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$id_usuario]);
        return $stmt->fetch(PDO::FETCH_OBJ);
    }
}
