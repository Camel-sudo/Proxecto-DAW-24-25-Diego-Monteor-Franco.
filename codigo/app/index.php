<?php
session_start();
include_once("globals.php");
include_once(CONTROLLER_PATH."NutriproController.php");
include_once(CONTROLLER_PATH."Controller.php");
include_once(CONTROLLER_PATH."UsuarioController.php");
include_once(CONTROLLER_PATH."AuthController.php");
include_once(CONTROLLER_PATH."RegistroDiarioController.php");
include_once(CONTROLLER_PATH."RegistroAlimentoController.php");
include_once(CONTROLLER_PATH."AlimentoController.php");
include_once(CONTROLLER_PATH."ClienteController.php");
include_once(CONTROLLER_PATH."NutricionistaController.php");


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
        }else{
            error_log("No tienes permisos para: " .$controller.":". $action);
        }
    } catch (\Throwable $th) {
        error_log("Cargando controlador inexistente: " . $controller);
        $objeto = new NutriproController();
        $objeto->landing_page();
    }
} else {
    $objeto = new NutriproController();
    $objeto->landing_page();
}