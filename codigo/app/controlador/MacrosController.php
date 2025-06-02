<?php
include_once("Controller.php");
include_once(MODEL_PATH . "MacrosModel.php");

class MacrosController extends Controller
{
    public function __construct()
    {
        parent::__construct();  
    }
    public function misDietas(){
        $this->vista->show("mis-dietas");
    }
}