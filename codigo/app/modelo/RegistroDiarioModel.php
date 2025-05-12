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
    public $alimentos = []; // Array de RegistroAlimentos

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
    public static function crear_registro_diario($id_cliente, $fecha, $tipo, $id_nutricionista = null)
    {
    }

    public static function agregar_alimento_registro($id_registro, $id_alimento, $descripcion, $momento_dia, $cantidad, $unidad, $calorias, $proteinas, $carbohidratos, $grasas, $es_recomendacion = false, $consumido = true)
    {
    }

    public static function get_registro_diario($id_cliente, $fecha, $tipo)
    {
    }
}