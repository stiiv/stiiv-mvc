<?php

class View {
    
    public $title, 
           $data = array(),
           $lang;

    public function __construct() {
        $this->_set_title();
        // LANGUAGE SETTINGS
        $this->_display_lang();
    }

    protected function _set_title() {

        if(!isset($this->title)) {
            $title = explode('/', $_SERVER['REQUEST_URI']);
            $title = $title[2];

            if( empty($title) ) {
                $title = DEFAULT_CONTROLLER;
            }
            $this->title = ucfirst( $title );
        }
    }

    protected function _display_lang() {
        // DISPLAY LANGUAGE SETTINGS
        $languages = simplexml_load_file(INCLUDES.'languages.xml');
        $eng = $languages->english;
        $cro = $languages->croatian;
        $get = "";

        if( isset($_GET['lang']) ) {
            switch($_GET['lang']) {
                case "en":
                    $this->lang = $eng;
                    $get = $_GET['lang'];
                break;

                default: 
                    $this->lang = $cro;
                    $get = $_GET['lang'];
            }

        } else {
            $this->lang = $cro;
            $get = $_GET['lang'] = "hr";
        }
        Session::set("lang", $get);

        //pretty_print($this->lang, "Lang object");
        // set session for language
        $get_lang = isset($_GET['lang']) ? $_GET['lang'] : 'hr';
    }
    
    /**
     * Desc: include template file
     * @param string $template
     * @param [, true if is no requirement for templates header and footer ]
     * @return void
     */
    public function render($template, $noInclude = false) {
        if( isset($this->data) && !empty($this->data) ) {
            extract($this->data);
            
            if($noInclude) {
                require_once VIEWS.$template.".php";
            } else {
                require_once HEADER;
                require_once VIEWS.$template.".php";
                require_once FOOTER;
            }
        }
    }

    /**
     * Display variable if set
     * @param $var
     * @return string
     */
    public function var_check(&$var) {
        return isset($var) ? $var : '';
    }
    
}