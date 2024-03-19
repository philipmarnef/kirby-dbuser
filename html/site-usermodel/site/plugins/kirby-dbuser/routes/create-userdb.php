<?php

use Kirby\Database\Database;
use Kirby\Cms\User;
use Kirby\Toolkit\Str;

return [
	'pattern' => 'develop/create-userdb',
	'action' => function () {
		$kirby = kirby();

		if ( !$kirby->user() || !$kirby->user()->isAdmin() ) return;

		$dbname = dirname($kirby->root('base')) . '/db-users.sqlite';

		try {
			// create new SQLite database file
			$database = new SQLite3($dbname);
		} catch (Exception $e) {
			echo $e->getMessage();
		}

		if ($database) {
			// create new Database object
			// replace `path_to_file` with the absolute path to the file on your computer!
			$db = new Database([
					'type'     => 'sqlite',
					'database' => $dbname,
			]);
			// add users table with id, email, name, role, language and password fields
			// all fields use type text
			$db->createTable('users', [
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
			// set the users table as the one we want to query
			$query = $db->table('users');
			// three users show be enough for a start
			$users =  [
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
					]
			];
			// loops through users array and insert each data set into users table
			foreach ($users as $user ) {
				$query->values($user);
				$result[] = $query->insert();
			}
	}

	return $result;
	}
];
