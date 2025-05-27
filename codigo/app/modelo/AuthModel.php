<?php
class AuthModel {
    public static function usuarioLogueado() {
        return isset($_SESSION['usuario_id']);
    }

    public static function usuarioNombre() {
        return $_SESSION['usuario_nombre'] ?? 'Invitado';
    }

    public static function rol() {
        return $_SESSION['usuario_rol'] ?? null;
    }
}
