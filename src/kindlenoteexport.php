#!/usr/bin/php
<?php
require_once __DIR__ . '../../vendor/autoload.php';

//include 'kindlenote/scanner.php';

$scanner = new smaegaard\kindlenote\scanner();

$scanner->run();
