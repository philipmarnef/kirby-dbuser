<?php

use Kirby\Cms\User;
use Kirby\Database\Db;
use Kirby\Toolkit\Str;

return [
	'description' => 'Nice command',
	'args' => [],
	'command' => static function ($cli): void {
		for ($i=0; $i < 2001; $i++) { 
			kirby()->impersonate('kirby');
			kirby()->users()->create([
				'id'        => Str::random(8),
				'email'     => 'user' . $i . '@example.com',
				'password'  => User::hashPassword('12345678'),
				'role'      => 'subscriber',
				'language'  => 'en',
			]);
		}

		$cli->success('Database setup complete!');
	}
];
