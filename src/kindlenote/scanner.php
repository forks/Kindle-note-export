<?php

namespace smaegaard\kindlenote;

/*
 *  This is just a quick script to Reformat kindle highlights in a more 
 *  ( according to my tasty ) readable format.
 *  
 *  this will just write the Title of the book once followed by all the 
 *  notes related to that book, with a empty line following each note. 
 *  
 *  If the option TITLES is giving after the clipping file, it will just print
 *  a list of the book titles.
 */

use smaegaard\kindlenote;

class scanner {

    private $argv;
    private $argc;
    private $books;
    private $opt;
    private $clipfile;

    public function __construct() {
        $this->argv = $_SERVER['argv'];
        $this->argc = $_SERVER['argc'];
        $this->books = new bookcollection();
        $this->opt = array();
        $this->opt['titles'] = false;
        $this->opt['authors'] = false;
        $this->opt['bookmarks'] = false;
    }

    public function run() {
        $options = getopt("atbho:f:");

        if (array_key_exists("h", $options)) {
            $this->usage();
            exit(1);
        }

        if (array_key_exists("f", $options)) {
            if (file_exists($options["f"])) {
                $this->opt['file'] = $options["f"];   //$clipfile = fopen($options["f"], "r") or die("Could not open file.");
            } else {
                echo "ERROR - Could not find file : " . $options["f"] . "\n";
                usage();
                exit(66);
            }
        } else {
            echo "ERROR - No clipping file parsed with option -f\n";
            $this->usage();
            exit(66);
        }

        if (array_key_exists("o", $options)) {
            $this->opt['directory'] = $options["o"];
        }

        // Just list books titles 
        if (array_key_exists("t", $options)) {
            $this->opt['titles'] = true;
        }

        if (array_key_exists("a", $options)) {
            $this->opt['authors'] = true;
        }

        if (array_key_exists("b", $options)) {
            $this->opt['bookmarks'] = true;
        }

        $this->parse();

        $this->output();
    }

    private function parse() {
        $this->clipfile = fopen($this->opt['file'], "r") or die("Could not open file.");

        $last_title = NULL;

        while (!feof($this->clipfile)) {

            $line = fgets($this->clipfile);

            if (strpos($line, "==========") !== false) {
                continue;
            }

            if (strpos($line, "- Your Highlight on page") !== false) {
                fgets($this->clipfile);
                $line = fgets($this->clipfile);
                $this->books->addHighlight($last_title, $line);
                continue;
            }

            if (strpos($line, "- Your Bookmark") !== false) {
                $this->books->addBookmark($last_title, $line);
                $line = fgets($this->clipfile);
                continue;
            }

            if (empty($line) || (strlen($line) <= 2)) {
                continue;
            }

            if ($this->books->haveBook($line) == false) {
                $last_title = $this->books->addNew($line);
            }
        }

        fclose($this->clipfile);
    }

    private function output() {

        if (!empty($this->opt['directory'])) {
            if (!file_exists($this->opt['directory'])) {
                if (!mkdir($this->opt['directory'])) {
                    echo "Can't create directory : " . $this->opt['directory'] . "\n";
                    exit(2);
                }
            }

            foreach ($this->books as $book) {
                $file = fopen($this->opt['directory'] . DIRECTORY_SEPARATOR . $book->getTitle(), "w")
                        or die("Could not create file : " . $this->opt['directory'] . DIRECTORY_SEPARATOR . $book->getTitle());
                fwrite($file, $book->getTitle() . " by " . $book->getAuthor() . "\n\n");
                $highlights = $book->getHighlights();
                foreach ($highlights as $high) {
                    fwrite($file, $high . "\n");
                }
                // if bookmarks flag is parsed on the commandline.
                // is not a array
                if ($this->opt['bookmarks'] == true) {
                    $bookmarks = $book->getBookmarks();

                    if (!empty($bookmarks)) {
                        foreach ($bookmarks as $bookmark) {
                            if (empty($bookmark->getPage()))
                                fwrite($file, "bookmark at location " . $bookmark->getLocation() . "\n\n");
                            else
                                fwrite($file, "bookmark on page " . $bookmark->getPage() . "\n\n");
                        }
                    }
                }
                fclose($file);
            }
        }

        if ($this->opt['titles'] == true) {
            foreach ($this->books as $book) {
                echo $book->getTitle() . "\n";
            }
        }

        if ($this->opt['authors'] == true) {
            foreach ($this->books->getAuthors() as $author) {
                echo $author . "\n";
            }
        }
    }

    private function usage() {
        echo "Usage: " . $this->argv[0] . " [OPTION] -f MyClippingFile\n";
        echo "\n";
        echo "options: \n";
        echo "-h                Print this help\n";
        echo "-f <file>         The clipping file to be parsed\n";
        echo "-t                List all book titles found in the clipping file\n";
        echo "-a                List the all the authors. Authors are only listed once\n";
        echo "-b                list bookmarks.\n";
        echo "-o <directory>    The directory to output files to\n";
        echo "\n";
    }

}
