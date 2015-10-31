<?php

namespace smaegaard\kindlenote;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include "book.php";

class BookCollection implements \IteratorAggregate {

    private $books;

    public function __construct() {
        $this->books = array();
    }

    public function addNew($line) {
        if ($this->haveBook($line)) {
            return false;
        } else {
            $title = $this->getTitleFromLine($line);
            $author = $this->getAuthorFromLine($line);
            $this->books[] = new Book($title, $author);
            return end($this->books)->getTitle();
        }
    }

    public function addHighlight($title, $highlight) {
        $this->getBook($title)->addHighlight($highlight);
    }

    /*
     * return array of authors.
     * 
     * returns no duplicats.
     */

    public function getAuthors() {
        $authors = array();
        foreach ($this->books as $book) {
            $authors[] = $book->getAuthors();
        }
        return array_unique($authors, SORT_STRING);
    }

    public function getBook($title) {
        foreach ($this->books as $book)
            if ($book->getTitle() == $title)
                return $book;
    }

    /*
     *  is book in collection.
     */

    public function haveBook($line) {
        $title = $this->getTitleFromLine($line);
        foreach ($this->books as $book) {
            if ($book->getTitle() == $title)
                return true;
        }

        return false;
    }

    /*
     *  Iterator over books
     */

    public function getIterator() {
        return new \ArrayIterator($this->books);
    }

    private function getTitleFromLine($line) {
        $text = explode("(", $line);
        return $text[0];
    }

    private function getAuthorFromLine($line) {
        $text = explode("(", $line);
        $temp = explode(")", $text[1]);
        return $temp[0];
    }

}
