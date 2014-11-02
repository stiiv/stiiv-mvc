<?php

function date_trans($trans) {
    
    $trans = substr($trans, 0, 10);
    $date_trans = explode('-', $trans);
    return $date_trans[2].'.'.$date_trans[1].'.'.$date_trans[0].'.';
}

/**
 * @Desc: add given word into array element
 * @param string - word to add
 * @param array - array to add given word to
 * return mixed
 */
function add_to_array_elements($word, $type) {
    
    if(is_array($type)) {
        $i = 0;
        $elements = '';	
        foreach($type as $element) {
            $i++;
            //check if an element is a last in array (if it is, remove comma)
            if($i >= count($type)) {
                $elements .= $word.$element;
            }
            else {
                $elements .= $word.$element.',';
            }
        }
        return explode(',', $elements);
    }
    return false;
}

function pretty_print($val, $name = "Name", $color = "darkgreen") {
    echo "<pre style=\"color: {$color};\"><h3> {$name} = ", print_r($val, true), '</h3></pre>';
}

/**
 * Redirect to the given page
 * @param $location
 * @return void
 */
function redir_to($location) {
    header("Location: ".BASE_URL.$location);
}

/**
 * Redirect to the given page in given time
 * @param $location
 * @param [, int $time ]
 * @return void
 */
function redir_sec($location, $time = 3) {
    header("Refresh: {$time}; url=".BASE_URL.$location);
}