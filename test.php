<?php

use Kirby\Http\Remote;
use Kirby\Toolkit\Str;

require_once __DIR__ . '/html/site-app/vendor/autoload.php';

$times = [];

$ta = Remote::get('http://ldbuser-app.test');
echo "Testing DB: (".Str::between($ta->content(), "Kirby ", " users.")."): ";
for ($i=0; $i < 100; $i++) { 
    $before = microtime(true);
    $ta = Remote::get('http://ldbuser-app.test');
    $after = microtime(true);
    $times[] = $after - $before;
}
printf("Average time: %.3fms\n", array_sum($times) / count($times) * 1000);

$times = [];

$ta = Remote::get('http://ldbuser-files.test');
echo "Testing files: (".Str::between($ta->content(), "Kirby ", " users.")."): ";
for ($i=0; $i < 100; $i++) { 
    $before = microtime(true);
    $ta = Remote::get('http://ldbuser-files.test');
    $after = microtime(true);
    $times[] = $after - $before;
}
printf("Average time: %.3fms\n", array_sum($times) / count($times) * 1000);
