<?php
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

/*
 *  Show usage
 */
function usage() {
    global $argv, $argc;

    echo "Usage: " . $argv[0] . " \"path/to/My Clippings.txt\" [OPTION]/\n";
    echo "";
    echo "TITLES    list just the book titels that has highlights";
    echo "";
    echo "ex. to just list the titles in the clipping file type : \n";
    echo "". $argv[0] . " \"My Clippings.txt\" TITLES\n";
    echo "\nto list all highlights : \n";
    echo "" , $argv[0] . " \"My Clippings.txt\" \n";
}

// check if number of args is wrong
if (($argc < 2) || ($argc > 3 )) {
    usage();
}

// Just list books titles ?
if( $argv[2] == 'TITLES' ) {
    $just_titles = true;
} else {
    $just_titles = false;
}

if (!file_exists($argv[1])) {
    echo "Could not found file : " . $argv[1] . "\n";
}

$clipfile = fopen($argv[1], "r") or die("Could not open file.");

$books = array();
$highlight_start = false;
$skip = false;

// pass clippings file
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
        if( ! $just_titles ) {
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
            if( ! $just_titles ) {
            echo $line;
            }
        } else {
            if (!in_array($line, $books)) {
                if(! $just_titles ) {
                echo "====" . $line;
                }
                
                $books[] = $line;

                $newbook = true;
            }
        }
    }
    $skip = false;
}

if( $just_titles ) {
    foreach ($books as $title) {
        echo $title;
    }
}

fclose($clipfile);
