<?php

class Pagination {

    public $current_page,
           $per_page,
           $total;

    public function __construct($current_page, $per_page, $total) {
        $this->current_page = (int)$current_page;
        $this->per_page     = (int)$per_page;
        $this->total        = (int)$total;
    }

    /**
     * Check whether pagination is needed or not - if the per_page is less or equal to total = pagination not needed
     * @return bool
     */
    public function needs_pagination() {
        return ( isset($this->per_page) && ($this->per_page >= $this->total) ) ? false : true;
    }

    public function total_pages() {
        return ceil($this->total / $this->per_page);
    }

    public function offset() {
        // Assuming 20 items per page
        // page 1 has an offset of 0  (1-1) * 20
        // page 2 has an offset of 1  (2-1) * 20
        //      page 2 starts with item 21
        return ($this->current_page -1) * $this->per_page;
    }

    public function prev_page() {
        return $this->current_page - 1;
    }

    public function next_page() {
        return $this->current_page + 1;
    }

    public function has_prev_page() {
        return ($this->prev_page() >= 1);
    }

    public function has_next_page() {
        return ($this->next_page() <= $this->total_pages());
    }

} 