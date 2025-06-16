<?php
class ClienteModel
{
    public static function altaCliente(int $id_usuario, int $id_nutricionista): int
    {
        $conn = ConnectionDB::get();
        $stmt = $conn->prepare("
            INSERT INTO cliente (id_usuario, id_nutricionista)
            VALUES (:id_usuario, :id_nutricionista)
        ");
        $stmt->bindValue(':id_usuario', $id_usuario, PDO::PARAM_INT);
        $stmt->bindValue(':id_nutricionista', $id_nutricionista, PDO::PARAM_INT);

        if (!$stmt->execute()) {
            throw new Exception("Error al crear cliente");
        }

        return (int)$conn->lastInsertId();
    }
    public static function guardarCiente(int $id_usuario): int
    {
        $conn = ConnectionDB::get();
        $stmt = $conn->prepare("
            INSERT INTO cliente (id_usuario)
            VALUES (:id_usuario)
        ");
        $stmt->bindValue(':id_usuario', $id_usuario, PDO::PARAM_INT);

        if (!$stmt->execute()) {
            throw new Exception("Error al crear cliente");
        }

        return (int)$conn->lastInsertId();
    }
    public static function eliminarCliente(int $id_cliente): bool
    {
        $conn = ConnectionDB::get();
        $stmt = $conn->prepare("DELETE FROM cliente WHERE id_cliente = :id_cliente");
        $stmt->bindValue(':id_cliente', $id_cliente, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }

    public static function obtenerClientesPorNutricionista(int $id_nutricionista): array
    {
        $conn = ConnectionDB::get();
        $stmt = $conn->prepare("
            SELECT c.id_cliente, u.nombre, u.apellidos
            FROM cliente c
            JOIN usuario u ON c.id_usuario = u.id_usuario
            WHERE c.id_nutricionista = :id_nutricionista
        ");
        $stmt->bindValue(':id_nutricionista', $id_nutricionista, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function editarCliente(int $id_cliente, array $datos): bool
    {
        if (empty($datos)) {
            throw new InvalidArgumentException('Datos incompletos o inválidos');
        }

        $conn = ConnectionDB::get();
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $id_usuario = self::getUsuarioPorCliente($id_cliente);
        if (!$id_usuario) {
            throw new Exception("Cliente no encontrado");
        }

        $sql = "UPDATE usuario SET 
                  nombre = :nombre, 
                  apellidos = :apellidos, 
                  altura = :altura, 
                  peso = :peso, 
                  edad = :edad, 
                  sexo = :sexo, 
                  actividad_fisica = :actividad_fisica, 
                  objetivo = :objetivo, 
                  metabolismo_basal = :metabolismo_basal
                WHERE id_usuario = :id_usuario";

        $stmt = $conn->prepare($sql);

        // bindValue con tipos correctos (asumiendo que altura, peso y metabolismo_basal son float o null)
        $stmt->bindValue(':nombre', $datos['nombre'] ?? null, PDO::PARAM_STR);
        $stmt->bindValue(':apellidos', $datos['apellidos'] ?? null, PDO::PARAM_STR);

        // Para float se usa PDO::PARAM_STR, ya que PDO no tiene PARAM_FLOAT
        $stmt->bindValue(':altura', isset($datos['altura']) ? (string)$datos['altura'] : null, $datos['altura'] === null ? PDO::PARAM_NULL : PDO::PARAM_STR);
        $stmt->bindValue(':peso', isset($datos['peso']) ? (string)$datos['peso'] : null, $datos['peso'] === null ? PDO::PARAM_NULL : PDO::PARAM_STR);

        $stmt->bindValue(':edad', isset($datos['edad']) ? (int)$datos['edad'] : null, $datos['edad'] === null ? PDO::PARAM_NULL : PDO::PARAM_INT);

        $stmt->bindValue(':sexo', $datos['sexo'] ?? null, PDO::PARAM_STR);
        $stmt->bindValue(':actividad_fisica', $datos['actividad_fisica'] ?? null, PDO::PARAM_STR);
        $stmt->bindValue(':objetivo', $datos['objetivo'] ?? null, PDO::PARAM_STR);

        $stmt->bindValue(':metabolismo_basal', isset($datos['metabolismo_basal']) ? (string)$datos['metabolismo_basal'] : null, $datos['metabolismo_basal'] === null ? PDO::PARAM_NULL : PDO::PARAM_STR);

        $stmt->bindValue(':id_usuario', $id_usuario, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public static function obtenerClientesDisponibles(): array
    {
        $conn = ConnectionDB::get();
        $stmt = $conn->query("
            SELECT u.id_usuario, u.nombre, u.apellidos
            FROM usuario u
            LEFT JOIN cliente c ON u.id_usuario = c.id_usuario
            WHERE c.id_usuario IS NULL AND u.tipo_usuario = 'base'
        ");

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function get_cliente_by_usuario(int $id_usuario): ?object
    {
        $conn = ConnectionDB::get();
        $stmt = $conn->prepare("SELECT * FROM cliente WHERE id_usuario = :id_usuario");
        $stmt->bindValue(':id_usuario', $id_usuario, PDO::PARAM_INT);
        $stmt->execute();

        $cliente = $stmt->fetch(PDO::FETCH_OBJ);
        return $cliente ?: null;
    }

    public static function getUsuarioPorCliente(int $id_cliente): ?int
    {
        $conn = ConnectionDB::get();
        $stmt = $conn->prepare("SELECT id_usuario FROM cliente WHERE id_cliente = :id_cliente");
        $stmt->bindValue(':id_cliente', $id_cliente, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? (int)$result['id_usuario'] : null;
    }
}
