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

include 'book.php';

class Scanner {

    private $argv;
    private $argc;
    private $books;

    public function __construct() {
        $this->argv = $_SERVER['argv'];
        $this->argc = $_SERVER['argc'];
        $this->books = array();
    }

    public function run() {
        $options = getopt("tf:");

        if (array_key_exists("f", $options)) {
            if (file_exists($options["f"])) {
                $clipfile = fopen($options["f"], "r") or die("Could not open file.");
            } else {
                echo "ERROR - Could not found file : " . $options["f"] . "\n";
                usage();
                exit(66);
            }
        } else {
            echo "ERROR - No clipping file given with option -f\n";
            $this->usage();
            exit(66);
        }

        $just_titles = false;
// Just list books titles 
        if (array_key_exists("t", $options)) {
            $just_titles = true;
        }

        $highlight_start = false;
        $skip = false;

// pass clippings file
// yes its ugly
        while (!feof($clipfile)) {
            $line = fgets($clipfile);

            if (strpos($line, "- Your Highlight on page") !== false) {
                $skip = true;
                $highlight_start = true;
            }

            if (strpos($line, "- Your Bookmark") !== false) {
                $skip = true;
                $highlight_start = true;
            }

            if (strpos($line, "==========") !== false) {
                if (!$just_titles) {
                    echo "\n";
                }
                $highlight_start = false;
                $skip = true;
            }

            if (strlen($line) <= 2) {
                $skip = true;
            }

            if (!$skip) {
                if ($highlight_start == true) {
                    if (!$just_titles) {
                        echo $line;
                    }
                } else {
                    if (!in_array($line, $this->books)) {
                        if (!$just_titles) {
                            echo "====" . $line;
                        }

                        $this->books[] = $line;

                        $newbook = true;
                    }
                }
            }
            $skip = false;
        }

        if ($just_titles) {
            foreach ($this->books as $title) {
                echo $title;
            }
        }

        fclose($clipfile);
    }

    private function usage() {
        echo "Usage: " . $this->argv[0] . " [OPTION] -f MyClippingFile\n";
        echo "\n";
        echo "options: \n";
        echo "-t        list only the book titels.\n";
        echo "-f file   The file containing the clippings.\n";
        echo "\n";
    }

}
