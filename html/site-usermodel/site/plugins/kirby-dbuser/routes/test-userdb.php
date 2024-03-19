<?php

use Kirby\Database\Db;

return [
	'pattern' => 'develop/test-userdb',
	'action'  => function() {
			$users = Db::select('users');
			$result = [];
			foreach( $users as $user) {
					$result[] = $user->email;
			}
			return $result;
	}
];
