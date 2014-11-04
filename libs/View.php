<?php

class View {
    
    public $title, 
           $data = array(),
           // display language for website elements
           $lang,
           // get html links for available languages
           $lang_html_links;

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

    /**
     * Determine which langauge would be displayed on website elements
     * @return void
     */
    protected function _display_lang() {
        // DISPLAY LANGUAGE SETTINGS
        $lang_name_default = "english";
        $lang_alias_default = "en";
        $languages = simplexml_load_file(INCLUDES.'languages.xml');
        // get html links for available languages
        $allowed_langs = array();

        foreach($languages->children() as $langs) {
            $lang_name = $langs->attributes();
            $lang_alias = $langs->attributes()[1];
            // convert to strings $lang_name, and $lang_alias
            $name  = (string)$lang_name;
            $alias = (string)$lang_alias;
            // set availabble languages array
            $allowed_langs[$alias] = $name;
            
            if( Session::get('lang') != null && empty($_GET['lang']) ) {
                $_GET['lang'] = Session::get('lang');
            }

            if( isset($_GET['lang']) && !empty($_GET['lang']) ) {
                // check whether the language exists in xml file
                if( $_GET['lang'] == $alias ) {
                    $this->lang = $languages->$lang_name;
                    Session::set('lang', $alias);

                } else { // language does not exists in xml file
                    $this->lang = $languages->$lang_name_default;
                }

            } else { // $_GET is not set
                $this->lang = $languages->$lang_name_default;
            }
        } // end foreach
        // set html links for languages
        $this->lang_html_links = $this->_lang_links($allowed_langs);
    }

    /**
     * Set html links for available languages
     * @return string $html
     */
    protected function _lang_links($langs) {
        $html = "";
        foreach($langs as $alias => $name) {
            $html .= '<a class="lang-nav" href="?lang='.$alias.'">'.ucfirst($name).'</a> ';
        }
        return $html;
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