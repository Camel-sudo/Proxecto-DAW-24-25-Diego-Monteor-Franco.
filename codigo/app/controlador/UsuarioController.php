<?php
include_once("Controller.php");
include_once(MODEL_PATH . "UsuarioModel.php");

class UsuarioController extends Controller
{
    public function __construct()
    {
        parent::__construct();  
    }
    public function RegistroForm(){
        $this->vista->show('registro');
    }
    public function LoginForm(){
        $this->vista->show('login');
    }
    public function EditAccountForm(){
        $this->vista->show('edit-account');
    }
    public function registroUsuario(){
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Recoger y limpiar datos
            $nombre = trim($_POST['nombre']);
            $apellidos = trim($_POST['apellidos']);
            $email = trim($_POST['email']);
            $contrasena = $_POST['contrasena'];

            // Validación básica
            if (!$nombre || !$apellidos || !$email || !$contrasena) {
                die("Error: Faltan campos obligatorios.");
            }

            // Hashear contraseña
            $contrasena_hash = password_hash($contrasena, PASSWORD_BCRYPT);

            // Fecha actual
            $fecha_registro = date("Y-m-d");

            // Crear objeto Usuario (sin datos adicionales)
            $usuario = new Usuario(
                null,
                $nombre,
                $apellidos,
                $email,
                $contrasena_hash,
                'base',
                $fecha_registro,
                null,  // altura
                null,  // peso
                null,  // edad
                null,  // sexo
                null,  // actividad_fisica
                null,  // objetivo
                null   // metabolismo_basal
            );

            // Guardar en base de datos
            if (UsuarioModel::alta_usuario($usuario)) {
                // Redirigir a edición de cuenta
                header('Location: index.php?controller=UsuarioController&action=LoginForm');
                exit;
            } else {
                echo "Error al registrar el usuario.";
            }

            }    
        }
        public function loginUsuario() {
            if ($_SERVER["REQUEST_METHOD"] === "POST") {
                $email = trim($_POST['email']);
                $contrasena = $_POST['contrasena'];
                // Hashear contraseña
                if (!$email || !$contrasena) {
                    echo 'Faltan campos obligatorios';
                    return;
                }
        
                $usuario = UsuarioModel::getUsuarioPorEmail($email);
                if ($usuario && (password_verify($contrasena, $usuario->contrasena_hash))) {
                    session_start();
                    $_SESSION['usuario_id'] = $usuario->id_usuario;
                    $_SESSION['usuario_nombre'] = $usuario->nombre;
        
                    echo json_encode(['success' => true, 'message' => 'Login correcto']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Usuario o contraseña incorrectos']);
                }
            }
        }
        
    public function bajaUsuario(){}
    
}