# Kindle-note-export

This is just a quick PHP script to Reformat kindle highlights in a more 
( according to my tasty ) readable format.

This will just write the Title of the book once followed by all the 
notes related to that book, with a empty line following each note. 
  
If the option TITLES is giving after the clipping file, it will just print
a list of the book titles in the clipping file.

## usage

php -f bin/kindle2txt.php MyClippingFile [TITLES]
