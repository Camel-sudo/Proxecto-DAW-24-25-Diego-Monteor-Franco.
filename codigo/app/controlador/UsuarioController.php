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
    public function EditAccountForm(){
        $this->vista->show('edit-account');
    }
    public function registroUsuario(){
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $nombre = trim($_POST['nombre']);
            $apellidos = trim($_POST['apellidos']);
            $email = trim($_POST['email']);
            $contrasena = $_POST['contrasena'];

            if (!$nombre || !$apellidos || !$email || !$contrasena) {
                die("Error: Faltan campos obligatorios.");
            }
            $contrasena_hash = password_hash($contrasena, PASSWORD_BCRYPT);

            $fecha_registro = date("Y-m-d");

            $usuario = new Usuario(
                null,
                $nombre,
                $apellidos,
                $email,
                $contrasena_hash,
                'base',
                $fecha_registro,
                null,  
                null,  
                null,  
                null,  
                null, 
                null,  
                null   
            );

            if (UsuarioModel::alta_usuario($usuario)) {
                header('Location: index.php?controller=UsuarioController&action=LoginForm');
                exit;
            } else {
                echo "Error al registrar el usuario.";
            }

            }    
        }        
    public function bajaUsuario(){}
    public function cargarMenu(){
        <?php if (!AuthModel::usuarioLogueado()): ?>
            <a href="index.php?controller=Auth&action=LoginForm">Login</a>
        <?php else: ?>
            <span>Hola, <?= AuthModel::usuarioNombre() ?></span>
            <a href="index.php?controller=AuthController&action=logout">Cerrar sesión</a>
            <?php if (AuthModel::rol() === 'admin'): ?>
                <a href="#">Panel Admin</a>
            <?php elseif (AuthModel::rol() === 'nutricionista'): ?>
                <a href="#">Mis pacientes</a>
            <?php elseif (AuthModel::rol() === 'usuario'): ?>
                <a href="#">Mis dietas</a>
            <?php endif; ?>
        <?php endif; ?>
    }
}