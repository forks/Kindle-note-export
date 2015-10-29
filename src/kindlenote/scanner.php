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
include 'bookcollection.php';

class Scanner {

    private $argv;
    private $argc;
    private $books;
    private $opt;
    private $clipfile;

    public function __construct() {
        $this->argv = $_SERVER['argv'];
        $this->argc = $_SERVER['argc'];
        $this->books = new BookCollection();
        $this->opt = array();
        $this->opt['titles'] = false;
        $this->opt['authors'] = false;
    }

    public function run() {
        $options = getopt("atf:");

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

        // Just list books titles 
        if (array_key_exists("t", $options)) {
            $this->opt['titles'] = true;
        }
        
        if (array_key_exists("a", $options)) {
            $this->opt['authors'] = true;
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
        if ($this->opt['titles'] == true) {
            foreach ($this->books->getTitles() as $title)
                echo $title . "\n";
        }
        
        if ($this->opt['authors'] == true ) {
            foreach( $this->books->getAuthors() as $author ) {
                echo $author . "\n";
            }
        }
    }

    private function usage() {
        echo "Usage: " . $this->argv[0] . " [OPTION] -f MyClippingFile\n";
        echo "\n";
        echo "options: \n";
        echo "-f file   The file containing the clippings.\n";
        echo "-t        list the book titles in the clipping file.\n";
        echo "-a        list the all the authors. Authors are only listed once.\n";
        echo "\n";
    }

}
