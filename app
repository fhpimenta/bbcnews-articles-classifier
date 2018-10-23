#!/usr/bin/env php
<?php
ini_set('memory_limit', '1024M');

use BBCNewsClassifier\Command\Classification;
use Symfony\Component\Console\Application;

require __DIR__ . '/vendor/autoload.php';

$application = new Application();
$application->add(new Classification());

$application->run();