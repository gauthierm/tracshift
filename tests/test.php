<?php

error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', '1');

require_once __DIR__ . '/../vendor/autoload.php';

$parser = new silverorange\TracShift\Parser\Parser();
$tree = $parser->parseFile(__DIR__ . '/test-document.txt');
