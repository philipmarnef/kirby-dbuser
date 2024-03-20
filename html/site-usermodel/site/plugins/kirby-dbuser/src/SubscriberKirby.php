<?php

use Kirby\Cms\App as Kirby;
use Kirby\Cms\Users;
use Kirby\Database\Db;

class SubscriberKirby extends Kirby
{

    public function users () : Users
    {
        // use the cached array if available
        if (is_a($this->users, 'Kirby\Cms\Users') === true) {
            return $this->users;
        }

				$users = parent::users();

        // query subscribers table
        try {
          $dbusers = Db::table('users')?->fetch('array')->iterator('array')->all();
          // pass $subscribers array to the `Users::factory` method 
          $subscribers = Users::factory($dbusers);
          // and assign the collection to the `users` property
          $this->users = $users->add($subscribers);
        } catch (Exception $e) {

        }

        return $this->users = $users;
    }
}
