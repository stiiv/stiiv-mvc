<?php

class Controller {

    public $view, $model;
    // variable to set with Input() helper class
    protected $_input;

    public function __construct() {
        $this->view = new View();
    }

    //default method
    public function index() {}

    protected function _load_model($model) {
        require_once MODELS.strtolower($model)."_model.php";

        $model = ucfirst($model)."_Model";
        $this->model = new $model();
    }      

}