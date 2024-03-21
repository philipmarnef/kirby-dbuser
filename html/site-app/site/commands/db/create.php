<?php

use Kirby\Cms\User;
use Kirby\Toolkit\A;
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

		$password = User::hashPassword('12345678');
		$users_flat = [];
		for ($i=0; $i < 1200; $i++) { 
			$users_flat[] = Str::random(8);
			$users_flat[] = 'user' . $i . '@example.com';
			$users_flat[] = $password;
			$users_flat[] = 'subscriber';
			$users_flat[] = 'en';
		}

		$questions = A::join(array_fill(0, 1200, '(?, ?, ?, ?, ?)'), ', ');
		$sql = 'INSERT INTO users (id, email, password, role, language) VALUES '.$questions;
		Db::$connection->execute($sql, $users_flat);

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
