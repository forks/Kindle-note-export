<?php namespace smaegaard\kindlenote;
/* 
 *  Book
 */
include 'bookmark.php';

class Book {
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
        $this->bookmarks[] = new Bookmark( $page, $location, $date );
    }
    
    public function getHighlights() {
        return $this->highlights;
    }
}

