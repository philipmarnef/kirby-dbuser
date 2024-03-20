<?php

use \Kirby\Cms\App;

load([
	'SubscriberUser' => 'src/SubscriberUser.php',
]);

App::plugin('phmadam/dbuser', [
	'blueprints' => [
		'users/subscriber' => __DIR__ . '/blueprints/users/subscriber.yml',
	],
	'routes' => [
		require __DIR__ . '/routes/create-userdb.php',
		require __DIR__ . '/routes/test-userdb.php',
		require __DIR__ . '/routes/test-model.php',
	],
	'userModels' => [
		'subscriber' => SubscriberUser::class
	],
]);
