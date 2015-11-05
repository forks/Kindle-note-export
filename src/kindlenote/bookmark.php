<?php namespace smaegaard\kindlenote;
/*
 *  Contains a single bookmark
 * 
 */
use smaegaard\kindlenote;

class bookmark {
    private $page;
    private $location;
    private $date;
    
    public function __construct( $page, $location, $date ) {
        $this->page = $page;
        $this->location = $location;
        $this->date = $date;
    }
    
    public function getPage() {
        return $this->page;
    }
    
    public function getLocation() {
        return $this->location;
    }
    
    public function getDate() {
        return $this->date;
    }
}

