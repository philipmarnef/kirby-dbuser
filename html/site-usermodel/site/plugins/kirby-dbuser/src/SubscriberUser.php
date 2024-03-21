<?php

use Kirby\Cms\User;
use Kirby\Content\Content;
use Kirby\Data\Json;
use Kirby\Database\Db;

class SubscriberUser extends User
{

	/**
	 * Creates a new User from the given props and returns a new User object
	 */
	public static function create(array $props = null): User
	{

		// ToDo ( see UserActions::create )
		return new User([]);

	}

	/**
	 * Deletes the user
	 *
	 * @throws \Kirby\Exception\LogicException
	 */
	public function delete(): bool
	{

		// ToDo ( see UserActions->delete() )
		return false;
	}

	/**
	 * Read the account information from the database
	 */
	protected function readCredentials(): array
	{

		$credentials = Db::first('users', '*', [ 'id' => $this->id() ] )->toArray();

		if ( is_array($credentials) ) {
			unset($credentials['secrets']);
			return $credentials;
		}

		return [];

	}

	/**
	 * Reads the secrets from the user secrets column
	 */
	protected function readSecrets(): array
	{

		$row = Db::first('users', 'secrets', [ 'id' => $this->id() ] )->toArray();
		$secrets = isset( $row['secrets'] ) ? Json::decode( $row['secrets'] ) : [];

		// an empty password hash means that no password was set
		if (($secrets['password'] ?? null) === '') {
			unset($secrets['password']);
		}

		return $secrets;

	}

	/**
	 * Updates the user data
	 */
	public function update(
		array $input = null,
		string $languageCode = null,
		bool $validate = false
	): static {

		// in multi-lang, …
		if ($this->kirby()->multilang() === true) {
			// look up the actual language object if possible
			$language = $this->kirby()->language($languageCode);

			// validate the language code
			if ($language === null) {
				throw new InvalidArgumentException('Invalid language: ' . $languageCode);
			}

			$lang = $language->code();
		} else {
			// otherwise use hardcoded "default" code for single lang
			$lang = 'default';
		}

		if ( $lang !== 'default' )  $data = [ $lang => $input ];

		$row = Db::first('users', 'content', [ 'id' => $this->id() ] )->toArray();
		$oldContent = Json::decode($row['content']);
		$newContent = array_merge_recursive($oldContent, $input );

		$this->content = new Content($newContent);

		try {
			Db::update('users', [ 
				'content' => Json::encode($newContent), 
				'updated_at' => time()
			], [ 'id' => $this->id() ] );
		} catch (Exception $e) {

		}

		// set auth user data only if the current user is this user
		if ($this->isLoggedIn() === true) {
			$this->kirby()->auth()->setUser($this);
		}

		// update the users collection
		$this->kirby()->users()->set($this->id(), $this);

		return $this;
	}


	/**
	 * Writes the account information to the database
	 */
		protected function writeCredentials(array $credentials): bool
		{
			return Db::update( 'users', $credentials, ['id' => $this->id() ] );
		}

	/**
	 * Writes a specific secret to the user secrets column
	 */
	protected function writeSecret(

		string $key,
		#[SensitiveParameter]
		mixed $secret
		): bool {
			
		$secrets = $this->readSecrets();

		if ($secret === null) {
			unset($secrets[$key]);
		} else {
			$secrets[$key] = $secret;
		}

		return Db::update( 'users', [ 'secrets' => Json::encode($secrets) ], ['id' => $this->id() ] );

	}
}
