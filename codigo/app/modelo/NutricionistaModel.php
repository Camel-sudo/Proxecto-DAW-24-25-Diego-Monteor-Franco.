<?php
include_once 'UsuarioModel.php';

class Nutricionista extends Usuario
{
    public array $clientes;

    public function __construct($id_usuario, $nombre, $apellidos, $email, $contraseña_hash, $tipo_usuario, $fecha_registro, $altura, $peso, $edad, $sexo, $actividad_fisica, $objetivo, $metabolismo_basal, $clientes = [])
    {
        parent::__construct($id_usuario, $nombre, $apellidos, $email, $contraseña_hash, $tipo_usuario, $fecha_registro, $altura, $peso, $edad, $sexo, $actividad_fisica, $objetivo, $metabolismo_basal);
        $this->clientes = $clientes;
    }
}

class NutricionistaModel
{
    public static function altaNutricionista(int $id_usuario): int
    {
        $db = ConnectionDB::get();
        $stmt = $db->prepare("INSERT INTO nutricionista (id_usuario) VALUES (:id_usuario)");
        $stmt->bindValue(':id_usuario', $id_usuario, PDO::PARAM_INT);
        if (!$stmt->execute()) {
            throw new Exception("Error al insertar nutricionista");
        }
        return (int)$db->lastInsertId();
    }

    public static function getNutricionistaByUsuarioId(int $id_usuario): ?object
    {
        $db = ConnectionDB::get();
        $stmt = $db->prepare("SELECT * FROM nutricionista WHERE id_usuario = :id_usuario");
        $stmt->bindValue(':id_usuario', $id_usuario, PDO::PARAM_INT);
        $stmt->execute();
        $nutricionista = $stmt->fetch(PDO::FETCH_OBJ);
        return $nutricionista ?: null;
    }
}
