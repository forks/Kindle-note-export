# Kindle-note-export

This is just a quick PHP script to reformat/export kindle highlights.

## usage

From the commandline just run the script.

```
$ src/kindlenoteexport.php [OPTION] -f MyClippingFile
```

options: 
```
-f <filename>       The file containing the clippings.

-t                  List the book titles in the clipping file.

-a                  List the all the authors. Authors are only listed once.

-o <directory>      The directory to output files.
```