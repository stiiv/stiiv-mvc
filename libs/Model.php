<?php

class Model {
    
    protected $_db;
    
    public function __construct() {
        $this->_db = DB::getInstance();
    }

    /**
     * Count how many results has in given table
     * @param $table
     * @return mixed
     */
    public function count_table($table) {
        $sql = "SELECT COUNT(*) AS count FROM {$table} ";
        $results = $this->_db->query($sql)->getResults();
        return (int)$results[0]->count;
    }

    /**
     * @return int - number of matched results
     */
    public function countRes() {
        return $this->_db->countResults();
    }

    /**
     * Check whether there is results or not
     * @return bool
     * @todo requires additional checks
     */
    /*public function has_results() {
        return ($this->_db->getResults() > 0) ? true : false;
    }*/
}