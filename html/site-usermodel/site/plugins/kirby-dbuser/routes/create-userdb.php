<?php

use Kirby\Cms\User;
use Kirby\Data\Json;
use Kirby\Database\Database;
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
			$pdo = $db->connection();

			// add users table with 
			// userdata: id, email, name, role, language and password
			// secrets and content data stored as JSON
			$sql = <<<SQL
				CREATE TABLE IF NOT EXISTS users (
					id STRING PRIMARY KEY,
					email TEXT,
					name TEXT,
					role TEXT,
					language TEXT,
					content JSON,
					secrets JSON,
					created_at TIMESTAMP DEFAULT (unixepoch()) NOT NULL,
					updated_at TIMESTAMP DEFAULT (unixepoch()) NOT NULL
				);
			SQL;

			try {
				$pdo->beginTransaction();
				$pdo->exec($sql);
				$pdo->commit();
			} catch (Exception $e) {
				echo $e->getMessage();
			}

			// set the users table as the one we want to query
			$query = $db->table('users');
			// three users show be enough for a start
			$users =  [
					[ 
						'id'        => Str::random(8),
						'email'     => 'philip@example.com',
						'name'			=> 'Philip',
						'role'      => 'subscriber',
						'language'  => 'en',
						'secrets'  => Json::encode( [ 'password' => User::hashPassword('12345678') ] ),
					],
					[ 
						'id'        => Str::random(8),
						'email'     => 'adam@example.com',
						'name'			=> 'Adam',
						'role'      => 'subscriber',
						'language'  => 'en',
						'secrets' 	=> Json::encode( [ 'password' => User::hashPassword('12345678') ] ),
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
