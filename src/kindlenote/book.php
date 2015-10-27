<?php namespace smaegaard\kindlenote;
/* 
 *  Book
 */

class Book {
    private $title;
    private $highlights;
    
    public function __construct( $title ) {
       $this->title = $title;
       $this->highlights = array();
    }
    
    public function getTitle() {
        return $this->title;
    }
    
    public function addHighlight( $highlight ) {
        $this->highlights[] = $highlight;
    }
}

