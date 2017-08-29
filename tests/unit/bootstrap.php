<?php

require (__DIR__.'/../../vendor/autoload.php');

putenv("PRE_BASE_DIR=" . __DIR__ . "/Test");
$runner = new \Fooman\PhpunitPolyfill\Runner();
$runner->execute();