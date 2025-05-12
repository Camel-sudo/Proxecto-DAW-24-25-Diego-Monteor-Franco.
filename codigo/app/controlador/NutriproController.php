<?php
//controlador para cargar la pagian de inicio y el resto de controladores
include_once("globals.php");
include_once(MODEL_PATH . "ConectionDb.php");
include_once(CONTROLLER_PATH ."AlimentoController.php");
include_once(CONTROLLER_PATH ."ClienteController.php");
include_once(CONTROLLER_PATH ."MacrosController.php");
include_once(CONTROLLER_PATH ."NutricionistaController.php");
include_once(CONTROLLER_PATH ."UsuarioController.php");
include_once(CONTROLLER_PATH ."producto-controller.php");
include_once(VIEW_PATH . "View.php");

class NutriproController{
    //carga la pagian de inicio
function landing_page(){
    $view = new View();
    $view->show('landing-page',[]);
}
}