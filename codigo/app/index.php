<?php
session_start();
include_once("globals.php");
include_once(CONTROLLER_PATH."NutriproController.php");
include_once(CONTROLLER_PATH."Controller.php");
include_once(CONTROLLER_PATH."UsuarioController.php");
include_once(CONTROLLER_PATH."AuthController.php");
include_once(CONTROLLER_PATH."MacrosController.php");
include_once(CONTROLLER_PATH."AlimentoController.php");
//POSIBLE IMPLANTACION FUTURA DE WHITELIST
if (isset($_REQUEST['controller'])) {
    $controller = $_REQUEST['controller'];
    try {
        $objeto = new $controller();

        if (isset($_REQUEST['action'])) {
            $action = $_REQUEST['action'];
        }
        if (AuthModel::tienePermiso($controller, $action)) {
            $objeto->$action();
            exit;
        }
    } catch (\Throwable $th) {
        echo("hola");
        error_log("Cargando controlador inexistente: " . $controller);
        $objeto = new NutriproController();
        $objeto->landing_page();
    }
} else {
    $objeto = new NutriproController();
    $objeto->landing_page();
}