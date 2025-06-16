<?php
include_once("Controller.php");
include_once(MODEL_PATH . "AuthModel.php");
include_once(MODEL_PATH . "UsuarioModel.php");

class AuthController extends Controller
{
    public function __construct()
    {
        parent::__construct();  
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function LoginForm()
    {
        $this->vista->show('login');
    }

    public function loginUsuario()
{
    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        http_response_code(405);
        echo "Método no permitido";
        return;
    }

    $email = trim($_POST['email'] ?? '');
    $contrasena = $_POST['contrasena'] ?? '';

    if (!$email || !$contrasena) {
        header('Location: index.php?controller=AuthController&action=LoginForm');
        return;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header('Location: index.php?controller=AuthController&action=LoginForm');
        return;
    }

    $usuario = UsuarioModel::getUsuarioPorEmail($email);

    if (!$usuario || !password_verify($contrasena, $usuario->contrasena_hash)) {
        header('Location: index.php?controller=AuthController&action=LoginForm');
        return;
    }

    $_SESSION['usuario_id'] = $usuario->id_usuario;
    $_SESSION['usuario_nombre'] = $usuario->nombre;
    $_SESSION['usuario_rol'] = $usuario->tipo_usuario;

    if ($usuario->tipo_usuario === 'nutricionista') {
        $nutricionista = NutricionistaModel::getNutricionistaByUsuarioId($usuario->id_usuario);
        if (!$nutricionista) {
            header('Location: index.php?controller=AuthController&action=LoginForm');
            return;
        }
        $_SESSION['id_nutricionista'] = $nutricionista->id_nutricionista;
    } else {
        $id_cliente = ClienteModel::get_cliente_by_usuario($usuario->id_usuario);
        $_SESSION['id_cliente'] = $id_cliente->id_cliente ?? null;
    }

    header('Location: index.php');
}


    public function logout()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $_SESSION = [];
        session_unset();
        session_destroy();

        header('Location: index.php', true, 302);
        exit();
    }
}
