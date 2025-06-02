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
    public static function crear_registro_diario($id_cliente, $fecha, $tipo = 'almuerzo', $id_nutricionista = null)
{
    $db = ConnectionDB::get();
    //no funciona
    try {
        $query = $db->prepare("SELECT id_registro FROM registro_diario WHERE id_cliente = ? AND fecha = ? AND tipo = ?");
        $query->execute([$id_cliente, $fecha, $tipo]);

        $registro = $query->fetch(PDO::FETCH_ASSOC);

        if ($registro) {
            return $registro['id_registro'];
        }
        $query = $db->prepare("
            INSERT INTO registro_diario (
                id_cliente, id_nutricionista, fecha, tipo,
                calorias_objetivo, proteinas_objetivo, carbohidratos_objetivo, grasas_objetivo,
                calorias_consumidas, proteinas_consumidas, carbohidratos_consumidas, grasas_consumidas
            ) VALUES (?, null, ?, ?, 0, 0, 0, 0, 0, 0, 0, 0)
        ");
        $query->execute([$id_cliente, $fecha, $tipo]);

        return $db->lastInsertId();
    } catch (PDOException $e) {
        error_log("Error al crear registro diario: " . $e->getMessage());
        throw new Exception("Error al crear registro diario: " . $e->getMessage());
    }
}



public static function agregar_alimento_registro(
    $id_alimento, $descripcion, $momento_dia,
    $cantidad, $unidad, $calorias, $proteinas, $carbohidratos, $grasas,
    $es_recomendacion = false, $consumido = true
) {
    $db = ConnectionDB::get();

    $query = $db->prepare("
        INSERT INTO registro_alimento (
             id_alimento, descripcion, momento_dia, cantidad, unidad,
            calorias, proteinas, carbohidratos, grasas, es_recomendacion, consumido
        ) VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");

    return $query->execute([
        $id_alimento, $descripcion, $momento_dia, $cantidad, $unidad,
        $calorias, $proteinas, $carbohidratos, $grasas,
        $es_recomendacion ? 1 : 0,
        $consumido ? 1 : 0
    ]);
}


    public static function get_registro_diario($id_cliente, $fecha, $tipo)
    {
    }
}