<?php
include_once("Controller.php");
include_once(MODEL_PATH . "AuthModel.php");
include_once(MODEL_PATH . "UsuarioModel.php");
class AuthController extends Controller{
    public function __construct()
    {
        parent::__construct();  
    }
    public function LoginForm(){
        $this->vista->show('login');
    }

    public function loginUsuario() {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $email = trim($_POST['email']);
            $contrasena = $_POST['contrasena'];
            if (!$email || !$contrasena) {
                echo 'Faltan campos obligatorios';
                return;
            }
    
            $usuario = UsuarioModel::getUsuarioPorEmail($email);
            if ($usuario && (password_verify($contrasena, $usuario->contrasena_hash))) {
                $_SESSION['usuario_id'] = $usuario->id_usuario;
                $_SESSION['usuario_nombre'] = $usuario->nombre;
                $_SESSION['usuario_rol'] = $usuario->tipo_usuario;
                echo json_encode(['success' => true, 'message' => 'Login correcto']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Usuario o contraseña incorrectos']);
            }
        }
    }
    public function logout() {
        session_destroy();
        header('Location: index.php');
    }
}
