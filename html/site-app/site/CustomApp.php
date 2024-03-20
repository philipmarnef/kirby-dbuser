<?php

use Kirby\Cms\App;
use Kirby\Cms\User;
use Kirby\Cms\Users;
use Kirby\Database\Db;
use Kirby\Toolkit\Str;

class CustomApp extends App
{
    protected ?Users $users = null;

    public function users(): Users
    {
        if (is_a($this->users, Users::class)) {
            return $this->users;
        }

        $users = [];
        if (
            Str::startsWith($this->path(), 'panel')
            || Str::startsWith($this->path(), 'api')
        ) {
            $users = Db::table('users')
                ->fetch('array')->iterator('array')
                ->all();
        } else if ($user_id = $this->session()->get('user_logged_in')
        ) {
            $users = Db::table('users')
                ->where('role', 'is not', 'subscriber')
                ->orWhere(['id' => $user_id])
                ->fetch('array')->iterator('array')
                ->all();
        } else {
            $users = Db::table('users')
                ->where('role', 'is not', 'subscriber')
                ->fetch('array')->iterator('array')
                ->all();
        }
        
        return $this->users = Users::factory($users);
    }

    public static function db_user_create(array $data): bool
    {
        $data['password'] = User::hashPassword($data['password']);
        Db::insert('users', $data);
        return false; # Halt default Kirby user creation
    }

    public static function db_user_update(string $id, array $values): bool
    {
        Db::update('users', $values, ['id' => $id]);
        return false; # Halt default Kirby user update
    }

    public static function db_user_delete(User $user): bool
    {
        Db::delete('users', ['id' => $user->id()]);
        return false; # Halt default Kirby user deletion
    }
}
