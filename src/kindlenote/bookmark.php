<?php namespace smaegaard\kindlenote;
/*
 *  Contains a single bookmark
 * 
 */

class Bookmark {
    private $mark;
    private $location;
    private $date;
    
    public function __construct( $page, $location, $date ) {
        $this->mark = $page;
        $this->location = $location;
        $this->date = $date;
    }
    
    public function getPage() {
        return $this->page;
    }
    
    public function getLocatation() {
        return $this->location;
    }
    
    public function getDate() {
        return $this->date;
    }
}

