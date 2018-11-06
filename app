#!/usr/bin/env php
<?php

ini_set('memory_limit', '1024M');

require __DIR__ . '/vendor/autoload.php';

use BBCNewsClassifier\Commands\Classification;
use Symfony\Component\Console\Application;

$application = new Application();
$application->add(new Classification());

$application->run();