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

    /**
     * Load model
     * @param string $model
     * @return void
     */
    protected function _load_model($model) {
        require_once MODELS.strtolower($model)."_model.php";

        $model = ucfirst($model)."_Model";
        $this->model = new $model();
    }

    /**
     * Abstract passing title in $this->view->data->title
     * @param string=variable/value separator '::' | array $view_data
     * @return mixed
     */
    public function title($title) {
        return $this->view->title = $title;
    }

    /**
     * Abstract passing key/value pairs in $this->view->data array
     * @param string=variable/value separator '::' | array $view_data
     * @return mixed
     */
    public function data($view_data) {

        if( is_string($view_data) ) {
            // check if the '::' character exists in string
            if( strpos($view_data, "::") !== false ) {
                $var_val = explode('::', $view_data);
                $var = $var_val[0];
                $val = $var_val[1];
                return $this->view->data[$var] = $val;
            }
            return null;

        } elseif( is_array($view_data) ) {
            foreach($view_data as $key => $value) {
                $this->view->data[$key] = $value;
            }
            return $this->view->data;
        } else {
            return false;
        }
    }      

}