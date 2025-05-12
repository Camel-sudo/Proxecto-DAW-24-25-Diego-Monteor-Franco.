<?php
include("controllers/NutriproController.php");
session_start();
if (isset($_REQUEST['controller'])) {
    $controller = $_REQUEST['controller'];
    try {
        $objeto = new $controller();

        if (isset($_REQUEST['action'])) {
            $action = $_REQUEST['action'];
        }
        $objeto->$action();
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