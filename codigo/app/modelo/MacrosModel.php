<?php
include_once 'ConnectionDB.php';
include_once 'ClienteModel.php';

class MacrosObjetivo
{
    public $id_objetivo;
    public $id_cliente;
    public $id_nutricionista;
    public $proteinas_porcentaje;
    public $carbohidratos_porcentaje;
    public $grasas_porcentaje;
    public $fecha_establecido;
    public $activo;
    public $cliente;
    public $nutricionista;

    public function __construct($id_objetivo, $id_cliente, $id_nutricionista, $proteinas_porcentaje, $carbohidratos_porcentaje, $grasas_porcentaje, $fecha_establecido, $activo)
    {
        $this->id_objetivo = $id_objetivo;
        $this->id_cliente = $id_cliente;
        $this->id_nutricionista = $id_nutricionista;
        $this->proteinas_porcentaje = $proteinas_porcentaje;
        $this->carbohidratos_porcentaje = $carbohidratos_porcentaje;
        $this->grasas_porcentaje = $grasas_porcentaje;
        $this->fecha_establecido = $fecha_establecido;
        $this->activo = $activo;
    }
}

class MacrosObjetivoModel
{
    public static function calcular_macros($id_cliente, $proteinas_porcentaje, $carbohidratos_porcentaje, $grasas_porcentaje, $id_nutricionista = null)
    {
    }
    public static function get_macros($id_cliente)
    {
    }
}