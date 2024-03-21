<?php

use Kirby\Cms\User;


return [
	'debug' => true,
	'db' => [
		'type' => 'sqlite',
		'database' => dirname(__DIR__, 2) . '/db-users.sqlite',
	],
	'hooks' => [
		'user.create:before' => fn(User $user, array $input) => CustomApp::db_user_create($input),
		'user.update:before' => fn(User $user, array $values, array $strings) => CustomApp::db_user_update($user->id(), $values, $strings),
		'user.delete:before' => fn(User $user) => CustomApp::db_user_delete($user),
		'user.changeName:before' => fn(User $user, string $name) => CustomApp::db_user_update($user->id(), ['name' => $name]),
		'user.changeEmail:before' => fn(User $user, string $email) => CustomApp::db_user_update($user->id(), ['email' => $email]),
		'user.changePassword:before' => fn(User $user, string $password) => CustomApp::db_user_update($user->id(), ['password' => User::hashPassword($password)]),
		'user.changeRole:before' => fn(User $user, string $role) => CustomApp::db_user_update($user->id(), ['role' => $role]),
		'user.changeLanguage:before' => fn(User $user, string $language) => CustomApp::db_user_update($user->id(), ['language' => $language]),

		'user.login:after' => fn(User $user) => kirby()->session()->set('user_logged_in', $user->id()),
		'user.logout:after' => fn() => kirby()->session()->remove('user_logged_in'),
	]
];
