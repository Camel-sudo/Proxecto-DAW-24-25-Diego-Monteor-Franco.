<?php
include_once("ConnectionDB.php");

class Usuario
{
    public $id_usuario;
    public $nombre;
    public $apellidos;
    public $email;
    public $contrasena_hash;
    public $tipo_usuario;
    public $fecha_registro;
    public $altura;
    public $peso;
    public $edad;
    public $sexo;
    public $actividad_fisica;
    public $objetivo;
    public $metabolismo_basal;

    public function __construct(
        $id_usuario,
        $nombre,
        $apellidos,
        $email,
        $contrasena_hash,
        $tipo_usuario = null,
        $fecha_registro,
        $altura,
        $peso,
        $edad,
        $sexo,
        $actividad_fisica,
        $objetivo,
        $metabolismo_basal = null
    ) {
        $this->id_usuario = $id_usuario;
        $this->nombre = $nombre;
        $this->apellidos = $apellidos;
        $this->email = $email;
        $this->contrasena_hash = $contrasena_hash;
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
    public static function calcularMetabolismoBasal($sexo, $peso, $altura, $edad)
    {
        if ($sexo === 'masculino') {
            return 10 * $peso + 6.25 * $altura - 5 * $edad + 5;
        } elseif ($sexo === 'femenino') {
            return 10 * $peso + 6.25 * $altura - 5 * $edad - 161;
        } else {
            return 10 * $peso + 6.25 * $altura - 5 * $edad;
        }
    }

    public static function get_usuarios()
    {
    }

    public static function getUsuarioPorEmail(string $email): ?Usuario
    {
        $db = ConnectionDB::get();
        $sql = "SELECT * FROM usuario WHERE email = :email LIMIT 1";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return new Usuario(
                $row['id_usuario'],
                $row['nombre'],
                $row['apellidos'],
                $row['email'],
                $row['contrasena_hash'],
                $row['tipo_usuario'],
                $row['fecha_registro'],
                $row['altura'],
                $row['peso'],
                $row['edad'],
                $row['sexo'],
                $row['actividad_fisica'],
                $row['objetivo'],
                $row['metabolismo_basal']
            );
        } else {
            return null;
        }
    }

    public static function alta_usuario(Usuario $usuario): bool
    {
        $db = ConnectionDB::get();
        $sql = "INSERT INTO usuario 
            (nombre, apellidos, email, contrasena_hash, tipo_usuario, fecha_registro)
            VALUES (:nombre, :apellidos, :email, :contrasena_hash, :tipo_usuario, :fecha_registro)";
        $stmt = $db->prepare($sql);

        $stmt->bindParam(':nombre', $usuario->nombre, PDO::PARAM_STR);
        $stmt->bindParam(':apellidos', $usuario->apellidos, PDO::PARAM_STR);
        $stmt->bindParam(':email', $usuario->email, PDO::PARAM_STR);
        $stmt->bindParam(':contrasena_hash', $usuario->contrasena_hash, PDO::PARAM_STR);
        $stmt->bindParam(':tipo_usuario', $usuario->tipo_usuario, PDO::PARAM_STR);
        $stmt->bindParam(':fecha_registro', $usuario->fecha_registro, PDO::PARAM_STR);

        try {
            if ($stmt->execute()) {
                $id_usuario = $db->lastInsertId();
                ClienteModel::guardarCiente((int)$id_usuario);
                return true;
            }
            return false;
        } catch (PDOException $e) {
            error_log("Error subiendo usuario: " . $e->getMessage());
            return false;
        } finally {
            $stmt = null;
            $db = null;
        }
    }
}
