<?php

use Kirby\Database\Db;

return [
	'pattern' => 'develop/test-userdb',
	'action'  => function() {
	
		$kirby = kirby();

		if ( !$kirby->user() || !$kirby->user()->isAdmin() ) return;

		return Db::select('users')->toArray() ?? [];

	}
];
