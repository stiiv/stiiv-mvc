<?php

class Input
{
/****************************************************************************
 *
 *                              UPLOAD HANDLER
 *
 ****************************************************************************/

    // upload information
    private $_upload_name,
			$_upload_type,
			$_upload_size,
			$_upload_temp,
			$_upload_error,
			$_types = array('jpeg', 'JPG', 'jpg', 'pjpeg', 'gif', 'x-png', 'png'),
			$_allowedTypes = array();

    // 1 MB = 1048576 B
    const MB = 1048576;

    // give upload_error meaning ( copied from PHP Manual => upload error messages )
    protected $_upload_errors = array(
        0 => 'No error',
        1 => 'The uploaded file exceeds the upload_max_filesize directive in php.ini',
        2 => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
        3 => 'The uploaded file was only partially uploaded',
        4 => 'No file was uploaded',
        6 => 'Missing a temporary folder. Introduced in PHP 5.0.3',
        7 => 'Failed to write file to disk. Introduced in PHP 5.1.0.',
        8 => 'A PHP extension stopped the file upload'
    );
			
	public $errorMsg = array();

    public function __construct() {
        $this->_allowedTypes = add_to_array_elements('image/', $this->_types);
    }

    /**
     * Check if anything has been uploaded
     * @return bool
     */
    public function is_file_uploaded() {
        return ( $this->upload_error() != UPLOAD_ERR_NO_FILE ) ? true : false;
    }

	/**
	 * Desc: checks if the uploaded file is allowed type
	 * @return true or false
	 */
	public function is_valid_upload_type() {
		
		if($this->upload_type() == null) {
			return false;
		}
		elseif(!in_array($this->upload_type(), $this->_allowedTypes)) {
			$this->errorMsg["file_type"] =
                'Datoteka nije dozvoljenog formata! Dozvoljeni format: '.implode(',', $this->_types);
			return false;
		}
		else {
			return true;
		}
	}

    /**
     * Determine whether the uploaded file exceeds max file size in php.ini or form
     * @return boolean (true if max_upload_size is ok, false otherwise )
     */
    public function is_max_upload_size() {
        if( $this->upload_error() == UPLOAD_ERR_INI_SIZE || $this->upload_error() == UPLOAD_ERR_FORM_SIZE ) {
            $this->errorMsg["max_upload_size"] =
                "Datoteka je prevelika, najveća dopuštena veličina : "
                .$this->byte_to_mb( $this->form_max_upload_size() )." MB";
            return false;
        }
        return true;
    }

    /**
     * Value of max_file_size in bytes
     * @return int (value of form max_file_size, 0 otherwise)
     */
    public function form_max_upload_size() {
        return (int)( isset($_REQUEST["MAX_FILE_SIZE"]) && is_numeric($_REQUEST["MAX_FILE_SIZE"]) ) ? $_REQUEST["MAX_FILE_SIZE"] : 0;
    }

    /**
     * Convert bytes into Megabytes
     * @param bool $bytes
     * @return int
     */
    public function byte_to_mb($bytes = false) {
        if(is_numeric($bytes) && $bytes) {
            return (int)$bytes / self::MB;
        }
        return 0;
    }

    /**
     * Convert Megabytes into bytes
     * @param bool $mb
     * @return int
     */
    public function mb_to_byte($mb = false) {
        if( is_numeric($mb) ) {
            return (int)$mb * self::MB;
        }
        return 0;
    }
	
	/**
	 * Desc: if the file exists in images folder
	 * @param string : directory where the searched file is placed
	 * @return true or false
	 */
	public function does_file_exist($path_dir) {
		if(file_exists($path_dir.$this->upload_name())) {
			$this->errorMsg["file_exists"] = 'Datoteka <strong>'.$this->upload_name().'</strong> već postoji';
			return true;
		}
		return false;
	}
	
	/**
	 * Desc: handle upload
     * @param string $dir - directory to permanently store uploaded file
     * @return boolean
	 */
	public function handle_upload($stored_dir) {
        if( is_string($stored_dir) ) {

            if( $this->is_valid_upload_type()
                && $this->is_max_upload_size()
                && $this->is_file_uploaded()
                && empty($this->errorMsg)
            ) {
                if( move_uploaded_file($this->upload_temp(), $stored_dir.DS.$this->upload_name()) ) {
                    return true;
                } else {
                    $this->errorMsg["upload_error"] = $this->upload_err_message();
                    return false;
                }
            }

        }
        return false;
	}

    /**
     * Value of name attribute in form
     * @return mixed
     */
    public function upload_file_form_name() {
        return array_keys($_FILES)[0];
    }
	
	/**
	 * Setting up class properties
	 */
	public function upload_name() {
		return $this->_upload_name = $_FILES[$this->upload_file_form_name()]['name'];
	}
	
	public function upload_size() {
		return $this->_upload_size = $_FILES[$this->upload_file_form_name()]['size'];
	}
	
	public function upload_type() {
		return $this->_upload_type = $_FILES[$this->upload_file_form_name()]['type'];
	}
	
	public function upload_temp() {
		return $this->_upload_temp = $_FILES[$this->upload_file_form_name()]['tmp_name'];
	}
	
	public function upload_error() {
		return $this->_upload_error = $_FILES[$this->upload_file_form_name()]['error'];
	}
	
	public function error() {
		return $this->_error;
	}

    /**
     * Display appropriate upload error status as message
     * @return string
     */
    public function upload_err_message() {
        return $this->_upload_errors[$this->upload_error()];
    }

    /**
     * Display update information
     * @return string
     */
    public function upload_info() {
        $html  = "<hr />";
        $html .= "FILE FORM NAME: ".$this->upload_file_form_name()."<br />";
        $html .= "FILE NAME: ".$this->upload_name()."<br />";
        $html .= "FILE SIZE: ".$this->upload_size()." B<br />";
        $html .= "FILE TYPE: ".$this->upload_type()."<br />";
        $html .= "FILE TEMP DIRECTORY: ".$this->upload_temp()."<br />";
        $html .= "FILE ERROR: ".$this->upload_err_message()."<br />";
        $html .= "<hr />";
        return $html;
    }



/*******  __toString() **************/
    public function __toString() {
        return $this->upload_info();
    }



/****************************************************************************
 *
 *                              VALIDATION HANDLER
 *
 ****************************************************************************/

    // Array of available rules
    protected $_allowed_rules = array(
        'required', 'email', 'minlength', 'maxlength', 'select', 'digit',
        'match'
    );

    /**
     * Filter given string
     * @param string $input
     * @return mixed|string
     */
    public function escape($input) {
        return is_string($input) ? filter_var($input, FILTER_SANITIZE_STRING) : "";
    }

    /**
     * Hash given string
     * @param string $string
     * @return string
     */
    public function hash($string) {
        return password_hash($string, PASSWORD_BCRYPT);
    }

    /**
     * First and main function.
     * @param string $input - Input value
     * @param string $field_name - Name to give for the field error
     * @param string/array $rules
     * @return $this
     */
    public function check($input, $field_name, $rules) {

        if( is_string($input) || is_numeric($input) ) {

            $input = trim( $input );

            if( is_array($rules) ) {

                $rule_array = array_keys($rules);
                // check if the set of rules exist in $this->_allowed_rules array
                if( $this->_rule_exists($rule_array) ) {
                    $this->_validate($input, $field_name, $rules);
                    $this->_input = $input;
                }

            } elseif( is_string($rules) ) {}
        }

        return $this->escape( trim($input) );

    } // end check

    /**
     * @param string $input - Input value
     * @param string $field_name - Name to give for the field error
     * @param array $rules - rules to check against
     * @return void
     */
    protected function _validate($input, $field_name, $rules) {
        $encoding = 'UTF-8';
        // get form name="" values
        $request_keys = array_keys($_REQUEST);

        foreach($rules as $rule => $satisfier) {

            switch($rule) {
                case 'required':
                    if( empty($input) ) {
                        $this->errorMsg[$field_name][] = 'Required';
                        return;
                    }
                    break;

                case 'email':
                    ( !filter_var($input, FILTER_VALIDATE_EMAIL) ) ? $this->errorMsg[$field_name][] = 'Not valid email' : null;
                    break;

                case 'minlength':
                    (mb_strlen($input, $encoding) <= $satisfier) ? 
                        $this->errorMsg[$field_name][] = "Too short. At least {$satisfier} characters required" : null;
                    break;

                case 'maxlength':
                    (mb_strlen($input, $encoding) >= $satisfier) ? 
                        $this->errorMsg[$field_name][] = "Too long. Maximum {$satisfier} characters" : null;
                    break;

                case 'select':
                    ($input < 1 || $input == null) ? $this->errorMsg[$field_name][] = 'Not selected' : null;
                    break;

                case 'digit':
                    ( !is_numeric($input) ) ? $this->errorMsg[$field_name][] = 'Must contain only digits' : null;
                    break;

                case 'match':
                    // check if the given satisfier is correct
                    if( !in_array($satisfier, $request_keys) ) {
                        $this->errorMsg[$field_name][] = "Satisfier '{$satisfier}' does not match any field";
                        return;
                    }

                    if( $_REQUEST[$satisfier] != $input) {
                        $this->errorMsg[$field_name][] = 'No match';
                    }
                    break;
            }
        }
    }

    /**
     * Check if input rule exists in $this->_allowed_rules;
     * @param array $array
     * @return boolean
     */
    protected function _rule_exists($array) {
        if(is_array($array)) {
            foreach($array as $value) {
                return in_array($value, $this->_allowed_rules);
            }
        }
        return false;
    }

    public function has_errors() {
        return !empty($this->errorMsg);
    }

    public function get_errors() {
        return $this->has_errors() ? $this->errorMsg : null;
    }

    /**
     * Get errors in formatted unordered list form
     * @return null|string
     */
    public function get_formatted_errors() {

        if($this->has_errors()) {

            $html = '<ul class="validate-error">';

            foreach($this->errorMsg as $title_group => $group) {

                $html .= '<li>';
                $html .= $title_group.':';
                    $html .= '<ul>';

                // if group array has more than one value, iterate through it
                if(count($group) > 1) {
                    foreach($group as $grouped_error) {
                        $html .= '<li>'.$grouped_error.'</li>';
                    }
                } else {
                    $html .= '<li>'.$group[0].'</li>';
                }

                    $html .= '</ul>';
                $html .= '</li>';
            }
            $html .= '</ul>';

            return $html;
        }
        return null;

    }
}