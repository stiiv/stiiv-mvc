<?php


class Language {

	public $display,
		   $lang_html_links;

    public function __construct() {
    	$this->display = $this->_display_lang();
    }

	/**
     * Determine which langauge would be displayed on website elements
     * @return object SimpleXMLElement
     */
    protected function _display_lang() {
        $lang_switch = null;
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
                    $lang_switch = $languages->$lang_name;
                    Session::set('lang', $alias);

                } else { // language does not exists in xml file
                    $lang_switch = $languages->$lang_name_default;
                }

            } else { // $_GET is not set
                $lang_switch = $languages->$lang_name_default;
            }
        } // end foreach
        // set html links for languages
        $this->lang_html_links = $this->_lang_links($allowed_langs);
        return $lang_switch;
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


}