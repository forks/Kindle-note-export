<?php namespace smaegaard\kindlenote;
/* 
 *  Book
 */
use smaegaard\kindlenote;

class book {
    private $title;
    private $highlights;
    private $bookmarks;
    private $author;
    
    public function __construct( $title, $author ) {
       $this->title = $title;
       $this->author = $author;
       $this->highlights = array();
       $this->bookmarks = array();
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
    
    public function addBookmark( $page, $location, $date ) {
        $this->bookmarks[] = new bookmark( $page, $location, $date );
    }
    
    public function getBookmarks() {
        return $this->bookmarks;
    }
    
    public function getHighlights() {
        return $this->highlights;
    }
}

