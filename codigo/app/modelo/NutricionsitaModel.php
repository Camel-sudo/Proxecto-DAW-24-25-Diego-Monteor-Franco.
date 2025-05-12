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
class NutricionistaModel{
    public function getClientes(){}
    public function posiblesClientes(){}
    public function altaClientes(){}
    
}
