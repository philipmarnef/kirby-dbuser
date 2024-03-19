<?php

return [
	'debug' => true,
	'ready' => function () {
		return [
			'db' => [
				'type' => 'sqlite',
				'database' => dirname(kirby()->root('base')) . '/db-users.sqlite',
			],
		];
	}
];
