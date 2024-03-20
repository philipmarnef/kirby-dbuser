<?php

use Kirby\Cms\User;
use Kirby\Database\Db;
use Kirby\Toolkit\Str;

return [
	'description' => 'Nice command',
	'args' => [],
	'command' => static function ($cli): void {
		Db::connect();
		
		Db::execute('DROP TABLE IF EXISTS users');
		Db::connection()->createTable('users', [
			'id'       => [
					'type'   => 'text',
					'unique' => true,
					'key'    => 'primary'
			],
			'email'    => [
					'type' => 'text',
			],
			'name'     =>  [
					'type' => 'text',
			],
			'role'     =>  [
					'type' => 'text',
			],
			'language' =>  [
					'type' => 'text',
			],
			'password' =>  [
					'type' => 'text',
			],
		]);

		$__ = array_fill(0, 2000, 1);
		$__ = array_map(fn($i) => [
			'id'        => Str::random(8),
			'email'     => 'user' . $i . '@example.com',
			'password'  => User::hashPassword('12345678'),
			'role'      => 'subscriber',
			'language'  => 'en',
		], $__);

		for ($i=0; $i < 2001; $i++) { 
			Db::insert('users', [
				'id'        => Str::random(8),
				'email'     => 'user' . $i . '@example.com',
				'password'  => User::hashPassword('12345678'),
				'role'      => 'subscriber',
				'language'  => 'en',
			]);
		}
		Db::insert('users', [
			'id'        => Str::random(8),
			'email'     => 'iam@adamkiss.com',
			'password'  => User::hashPassword('asdasdasd'),
			'role'      => 'admin',
			'language'  => 'en',
		]);

		$cli->success('Database setup complete!');
	}
];
