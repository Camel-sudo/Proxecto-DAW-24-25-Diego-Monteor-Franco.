<?php
include_once(VIEW_PATH."View.php");

class Controller{
    protected View $vista;

    public function __construct()
    {
        $this->vista = new View();
    }

}