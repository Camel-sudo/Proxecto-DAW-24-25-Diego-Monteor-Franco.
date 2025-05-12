<?php
include_once 'UsuarioModel.php';
include_once 'ConectionDb.php';
class Cliente extends Usuario
{

    public $idNutricionista;
    public function __construct($id_usuario, $nombre, $apellidos, $email, $contraseña_hash, $tipo_usuario, $fecha_registro, $altura, $peso, $edad, $sexo, $actividad_fisica, $objetivo, $metabolismo_basal, $idNutricionista)
    {
        parent::__construct($id_usuario, $nombre, $apellidos, $email, $contraseña_hash, $tipo_usuario, $fecha_registro, $altura, $peso, $edad, $sexo, $actividad_fisica, $objetivo, $metabolismo_basal);
        $this->idNutricionista = $idNutricionista;
    }
    /**
     * Get the value of idNutricionista
     */
    public function getIdNutricionista()
    {
        return $this->idNutricionista;
    }

    /**
     * Set the value of idNutricionista
     *
     * @return  self
     */
    public function setIdNutricionista($idNutricionista)
    {
        $this->idNutricionista = $idNutricionista;

        return $this;
    }
}

class ClienteModel 
{
}
