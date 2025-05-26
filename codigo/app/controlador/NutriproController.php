<?php
// NutriproController.php

// Incluir globals.php desde la carpeta superior
include_once(__DIR__ . '/../globals.php');

// Ahora usamos las constantes para incluir archivos
include_once(CONTROLLER_PATH . "Controller.php");
include_once(MODEL_PATH . "ConnectionDB.php");
include_once(VIEW_PATH . "View.php");

class NutriproController extends Controller {
    // Carga la pagina de inicio
    public function landing_page(){
        $view = new View();
        $view->show('landing-page', []);
    }
}
