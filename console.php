#!/usr/bin/env php

<?php 

require_once __DIR__ . '/vendor/autoload.php'; 

use Symfony\Component\Console\Application; 
use Console\AnalyzeCommand;
date_default_timezone_set("Europe/Stockholm");

$app = new Application('Foreign exchange analyzer', 'v1.0');
$app->add(new AnalyzeCommand());
$app->run();