<?php

namespace smaegaard\kindlenote;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include "book.php";

class BookCollection {

    private $books;

    public function __construct() {
        $this->books = array();
    }

    public function addNew($title) {
        if ($this->haveBook($title)) {
            return false;
        } else {
            $this->books[] = new Book($title);
            return true;
        }
    }

    public function addHighlight($title, $highlight) {
        $this->getBook($title)->addHighlight($highlight);
    }

    /*
     *  return array of titles
     */
    public function getTitles() {
        $titles = array();
        foreach ($this->books as $book) {
            $titles[] = $book->getTitle();
        }
        return $titles;
    }

    public function getBook($title) {
        foreach ($this->books as $book)
            if ($book->getTitle() == $title)
                return $book;
    }

    /*
     *  is book in collection.
     */

    public function haveBook($title) {
        foreach ($this->books as $book) {
            if ($book->getTitle() == $title)
                return true;
        }

        return false;
    }

}
