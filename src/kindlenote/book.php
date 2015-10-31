<?php namespace smaegaard\kindlenote;
/* 
 *  Book
 */

class Book {
    private $title;
    private $highlights;
    private $author;
    
    public function __construct( $title, $author ) {
       $this->title = $title;
       $this->author = $author;
       $this->highlights = array();
    }
    
    public function getTitle() {
        return $this->title;
    }
    
    public function getAuthor() {
        return $this->author;
    }

    public function addHighlight( $highlight ) {
        $this->highlights[] = $highlight;
    }
    
    public function getHighlights() {
        return $this->highlights;
    }
}

