<?php

use Kirby\Cms\User;
use Kirby\Database\Db;
use Kirby\Toolkit\Str;

return [
	'description' => 'Nice command',
	'args' => [],
	'command' => static function ($cli): void {
		kirby()->impersonate('kirby');
		$password = User::hashPassword('12345678');

		for ($i=7006; $i < 10001; $i++) { 
			kirby()->users()->create([
				'id'        => Str::random(8),
				'email'     => 'user' . $i . '@example.com',
				'password'  => $password,
				'role'      => 'subscriber',
				'language'  => 'en',
			]);
		}

		$cli->success('Database setup complete!');
	}
];
