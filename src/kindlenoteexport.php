#!/usr/bin/php
<?php namespace smaegaard;
require_once __DIR__ . '../../vendor/autoload.php';

include 'kindlenote/scanner.php';

$scanner = new kindlenote\Scanner();

$scanner->run();
