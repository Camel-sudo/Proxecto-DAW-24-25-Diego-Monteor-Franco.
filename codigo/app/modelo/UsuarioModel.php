<?php
include_once("ConnectionDB.php");

class Usuario
{
    public $id_usuario;
    public $nombre;
    public $apellidos;
    public $email;
    public $contraseña_hash;
    public $tipo_usuario;
    public $fecha_registro;
    public $altura;
    public $peso;
    public $edad;
    public $sexo;
    public $actividad_fisica;
    public $objetivo;
    public $metabolismo_basal;

    public function __construct($id_usuario, $nombre, $apellidos, $email, $contraseña_hash, $tipo_usuario, $fecha_registro, $altura, $peso, $edad, $sexo, $actividad_fisica, $objetivo, $metabolismo_basal)
    {
        $this->id_usuario = $id_usuario;
        $this->nombre = $nombre;
        $this->apellidos = $apellidos;
        $this->email = $email;
        $this->contraseña_hash = $contraseña_hash;
        $this->tipo_usuario = $tipo_usuario;
        $this->fecha_registro = $fecha_registro;
        $this->altura = $altura;
        $this->peso = $peso;
        $this->edad = $edad;
        $this->sexo = $sexo;
        $this->actividad_fisica = $actividad_fisica;
        $this->objetivo = $objetivo;
        $this->metabolismo_basal = $metabolismo_basal;
    }

}
class UsuarioModel
{
    public static function get_usuarios()
    {
    }

    public static function alta_usuario($usuario)
    {
        $db = ConnectionDB::get();
        $sql = "INSERT INTO usuario 
    (nombre, apellidos, email, contraseña_hash, tipo_usuario, altura, peso, edad, sexo, actividad_fisica, objetivo, metabolismo_basal)
    VALUES (:nombre, :apellidos, :email, :contraseña_hash, :tipo_usuario, :altura, :peso, :edad, :sexo, :actividad_fisica, :objetivo, :metabolismo_basal)";
        $stmt = $db->prepare($sql);

        $stmt->bindParam(':nombre', $usuario->nombre, PDO::PARAM_STR);
        $stmt->bindParam(':apellidos', $usuario->apellidos, PDO::PARAM_STR);
        $stmt->bindParam(':email', $usuario->email, PDO::PARAM_STR);
        $stmt->bindParam(':contraseña_hash', $usuario->contraseña_hash, PDO::PARAM_STR);
        $stmt->bindParam(':tipo_usuario', $usuario->tipo_usuario, PDO::PARAM_STR);
        $stmt->bindParam(':altura', $usuario->altura, PDO::PARAM_STR);
        $stmt->bindParam(':peso', $usuario->peso, PDO::PARAM_STR);
        $stmt->bindParam(':edad', $usuario->edad, PDO::PARAM_INT);
        $stmt->bindParam(':sexo', $usuario->sexo, PDO::PARAM_STR);
        $stmt->bindParam(':actividad_fisica', $usuario->actividad_fisica, PDO::PARAM_STR);
        $stmt->bindParam(':objetivo', $usuario->objetivo, PDO::PARAM_STR);
        $stmt->bindParam(':metabolismo_basal', $usuario->metabolismo_basal, PDO::PARAM_STR);
        try {
            $stmt->execute();
            return true;
        } catch (PDOException $th) {
            error_log("Error subiendo usuario: " . print_r($th, true));
            return false;
        } finally {
            $stmt = null;
            $db = null;
        }
    }

}