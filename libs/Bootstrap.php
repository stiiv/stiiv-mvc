<?php

class Bootstrap {

    private $_url;
    public $controller;

    public function __construct() {

        $this->_url = (isset($_GET['url'])) ? $_GET['url'] : null;
        $this->_url = rtrim($this->_url, "/");
        $this->_url = explode("/", $this->_url);
        //print_r($this->_url);
        if(isset($this->_url[0]) && file_exists(CONTROLLERS.$this->_url[0]."_controller.php")) {
            require_once CONTROLLERS.$this->_url[0]."_controller.php";
            $controller_name = ucfirst($this->_url[0]);
            $this->controller = new $controller_name;

        } else {

            if(empty($this->_url[0])) {
                $this->_defaultController();
            } else {
                $this->_error();
            }
        }
        $this->_method_to_load();
    }

    //default controller
    private function _defaultController() {

        require_once CONTROLLERS.DEFAULT_CONTROLLER."_controller.php";
        $controller = ucfirst(DEFAULT_CONTROLLER);
        $this->controller = new $controller();
    }

    //error controller
    private function _error() {
        require_once CONTROLLERS."error_controller.php";
        header("Location: ".BASE_URL."error");
        $this->controller = new Error();
        return false;
    }

    // determine which method to load
    private function _method_to_load() {

        //if(count($this->_url) > 3) {
        //    $this->_error();
        //}

        if(isset($this->_url[1]) && method_exists($this->controller, $this->_url[1])) {
            $method = strtolower($this->_url[1]);

            if(isset($this->_url[2]) && !empty($this->_url[2])) {
                $param = $this->_url[2];
                $this->controller->$method($param);
            } else {
                $this->controller->$method();
            }

        } elseif(empty($this->_url[1])) {
            $this->controller->index();

        } else {
            $this->_error();
        }
    }

}