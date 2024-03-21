<?php

use Kirby\Cms\App;

require_once dirname(__DIR__) . '/vendor/autoload.php';

ray()->measure();

echo (new App([
	'roots' => [
		'index'			=> __DIR__,
		'base'			=> $base    = dirname(__DIR__),
		'content'		=> $base . '/content',
		'site'			=> $base . '/site',
		'storage'		=> $storage = $base . '/storage',
		'accounts'	=> $storage . '/accounts',
		'cache'			=> $storage . '/cache',
		'sessions'	=> $storage . '/sessions',
		'logs'			=> $storage . '/log',
	],
]))->render();

ray()->measure();