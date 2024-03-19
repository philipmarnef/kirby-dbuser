<?php

use Kirby\Cms\App;
use Kirby\Cms\User;
use Kirby\Cms\Users;
use Kirby\Database\Db;

class CustomApp extends App {
	protected ?Users $users = null;

	public function users() : Users {
		if (is_a($this->users, Users::class)) {
			return $this->users;
		}

		$users = Db::table('users')->fetch('array')->iterator('array')->all();
		return $this->users = Users::factory($users);
	}

    public static function db_user_create(array $data) : bool {
        $data['password'] = User::hashPassword($data['password']);
        return Db::insert('users', $data);
    }

    public  static function db_user_update(string $id, array $values) : bool
    {
        return Db::update('users', $values, ['id' => $id]);
    }
}