#!/usr/bin/php
<?php namespace smaegaard;

require __DIR__ . '../../vendor/autoload.php';

$scanner = new \smaegaard\kindlenote\Scanner();

$scanner->run();
