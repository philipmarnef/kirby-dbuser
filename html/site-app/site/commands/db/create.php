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

		foreach ([
			[ 
				'id'        => Str::random(8),
				'email'     => 'philip@example.com',
				'password'  => User::hashPassword('12345678'),
				'role'      => 'subscriber',
				'language'  => 'en',
			],
			[ 
				'id'        => Str::random(8),
				'email'     => 'adam@example.com',
				'password'  => User::hashPassword('12345678'),
				'role'      => 'subscriber',
				'language'  => 'en',
			],
			[
				'id'        => Str::random(8),
				'email'     => 'iam@adamkiss.com',
				'password'  => User::hashPassword('asdasdasd'),
				'role'      => 'admin',
				'language'  => 'en',
			]
		] as $newuser) {
			Db::insert('users', $newuser);
		}

		$cli->success('Database setup complete!');
	}
];
