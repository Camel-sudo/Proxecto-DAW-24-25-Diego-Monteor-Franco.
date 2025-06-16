<?php
include_once 'ConnectionDB.php';
include_once 'ClienteModel.php';
include_once 'AlimentoModel.php';

class RegistroDiario
{
    public $id_registro;
    public $id_cliente;
    public $id_nutricionista;
    public $fecha;
    public $tipo;
    public $calorias_objetivo;
    public $proteinas_objetivo;
    public $carbohidratos_objetivo;
    public $grasas_objetivo;
    public $calorias_consumidas;
    public $proteinas_consumidas;
    public $carbohidratos_consumidas;
    public $grasas_consumidas;
    public $cliente;
    public $nutricionista;
    public $alimentos = []; 

    public function __construct($id_registro, $id_cliente, $id_nutricionista, $fecha, $tipo, $calorias_objetivo, $proteinas_objetivo, $carbohidratos_objetivo, $grasas_objetivo, $calorias_consumidas, $proteinas_consumidas, $carbohidratos_consumidas, $grasas_consumidas)
    {
        $this->id_registro = $id_registro;
        $this->id_cliente = $id_cliente;
        $this->id_nutricionista = $id_nutricionista;
        $this->fecha = $fecha;
        $this->tipo = $tipo;
        $this->calorias_objetivo = $calorias_objetivo;
        $this->proteinas_objetivo = $proteinas_objetivo;
        $this->carbohidratos_objetivo = $carbohidratos_objetivo;
        $this->grasas_objetivo = $grasas_objetivo;
        $this->calorias_consumidas = $calorias_consumidas;
        $this->proteinas_consumidas = $proteinas_consumidas;
        $this->carbohidratos_consumidas = $carbohidratos_consumidas;
        $this->grasas_consumidas = $grasas_consumidas;
    }
}

class RegistroDiarioModel
{
    public static function crear_registro_diario(int $id_cliente, string $fecha, string $tipo = 'almuerzo', ?int $id_nutricionista = null): int
    {
        $db = ConnectionDB::get();

        try {
            $query = $db->prepare("SELECT id_registro FROM registro_diario WHERE id_cliente = :id_cliente AND fecha = :fecha AND tipo = :tipo");
            $query->bindValue(':id_cliente', $id_cliente, PDO::PARAM_INT);
            $query->bindValue(':fecha', $fecha, PDO::PARAM_STR);
            $query->bindValue(':tipo', $tipo, PDO::PARAM_STR);
            $query->execute();

            $registro = $query->fetch(PDO::FETCH_ASSOC);

            if ($registro) {
                return (int)$registro['id_registro'];
            }

            $query = $db->prepare("
                INSERT INTO registro_diario (
                    id_cliente, id_nutricionista, fecha, tipo,
                    calorias_objetivo, proteinas_objetivo, carbohidratos_objetivo, grasas_objetivo,
                    calorias_consumidas, proteinas_consumidas, carbohidratos_consumidas, grasas_consumidas
                ) VALUES (:id_cliente, :id_nutricionista, :fecha, :tipo, 0, 0, 0, 0, 0, 0, 0, 0)
            ");
            $query->bindValue(':id_cliente', $id_cliente, PDO::PARAM_INT);
            if ($id_nutricionista === null) {
                $query->bindValue(':id_nutricionista', null, PDO::PARAM_NULL);
            } else {
                $query->bindValue(':id_nutricionista', $id_nutricionista, PDO::PARAM_INT);
            }
            $query->bindValue(':fecha', $fecha, PDO::PARAM_STR);
            $query->bindValue(':tipo', $tipo, PDO::PARAM_STR);

            $query->execute();

            return (int)$db->lastInsertId();
        } catch (PDOException $e) {
            error_log("Error al crear registro diario: " . $e->getMessage());
            throw new Exception("Error al crear registro diario");
        }
    }

    public static function agregar_alimento_registro(
        int $id_registro,
        int $id_alimento,
        string $descripcion,
        string $momento_dia,
        float $cantidad,
        string $unidad,
        float $calorias,
        float $proteinas,
        float $carbohidratos,
        float $grasas,
        bool $es_recomendacion = false,
        bool $consumido = true
    ): bool {
        $db = ConnectionDB::get();

        $query = $db->prepare("
            INSERT INTO registro_alimento (
                id_registro, id_alimento, descripcion, momento_dia,
                cantidad, unidad, calorias, proteinas, carbohidratos, grasas,
                es_recomendacion, consumido
            ) VALUES (
                :id_registro, :id_alimento, :descripcion, :momento_dia,
                :cantidad, :unidad, :calorias, :proteinas, :carbohidratos, :grasas,
                :es_recomendacion, :consumido
            )
        ");

        $query->bindValue(':id_registro', $id_registro, PDO::PARAM_INT);
        $query->bindValue(':id_alimento', $id_alimento, PDO::PARAM_INT);
        $query->bindValue(':descripcion', $descripcion, PDO::PARAM_STR);
        $query->bindValue(':momento_dia', $momento_dia, PDO::PARAM_STR);
        $query->bindValue(':cantidad', $cantidad);
        $query->bindValue(':unidad', $unidad, PDO::PARAM_STR);
        $query->bindValue(':calorias', $calorias);
        $query->bindValue(':proteinas', $proteinas);
        $query->bindValue(':carbohidratos', $carbohidratos);
        $query->bindValue(':grasas', $grasas);
        $query->bindValue(':es_recomendacion', $es_recomendacion ? 1 : 0, PDO::PARAM_INT);
        $query->bindValue(':consumido', $consumido ? 1 : 0, PDO::PARAM_INT);

        try {
            return $query->execute();
        } catch (PDOException $e) {
            error_log("Error al agregar alimento al registro: " . $e->getMessage());
            return false;
        }
    }

    public static function obtener_registros_con_alimentos(int $id_cliente, ?string $fecha = null): array
    {
        $db = ConnectionDB::get();

        $sql = "
            SELECT 
                rd.fecha,
                ra.id_registro_alimento,
                ra.momento_dia,
                ra.descripcion,
                ra.cantidad,
                ra.unidad,
                ra.calorias,
                ra.proteinas,
                ra.carbohidratos,
                ra.grasas,
                ra.consumido
            FROM registro_diario rd
            JOIN registro_alimento ra ON rd.id_registro = ra.id_registro
            WHERE rd.id_cliente = :id_cliente
        ";

        $params = [':id_cliente' => $id_cliente];

        if ($fecha) {
            $sql .= " AND rd.fecha = :fecha";
            $params[':fecha'] = $fecha;
        }

        $sql .= " ORDER BY rd.fecha DESC, rd.tipo ASC";

        $stmt = $db->prepare($sql);

        foreach ($params as $key => $value) {
            if ($key === ':id_cliente') {
                $stmt->bindValue($key, $value, PDO::PARAM_INT);
            } else {
                $stmt->bindValue($key, $value, PDO::PARAM_STR);
            }
        }

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
