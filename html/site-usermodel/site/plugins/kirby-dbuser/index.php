<?php

use \Kirby\Cms\App;

App::plugin('phmadam/dbuser', [
	'blueprints' => [
		'users/subscriber' => __DIR__ . '/blueprints/users/subscriber.yml',
	],
	'routes' => [
		require __DIR__ . '/routes/create-userdb.php',
		require __DIR__ . '/routes/test-userdb.php',
	],
]);
