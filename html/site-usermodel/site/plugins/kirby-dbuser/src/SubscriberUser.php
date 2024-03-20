<?php

use Kirby\Cms\User;
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
	 * Read the content from the database
	 */
	public function readContent(string $languageCode = null): array
	{

		// ToDo ( see ModelWithContent->readContent() )
		return [];

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
	 * Low level data writer method
	 * to store the given data on disk or anywhere else
	 * @internal
	 */
	public function writeContent(array $data, string $languageCode = null): bool
	{

		// ToDo ( see ModelWithContent->writeContent() )

		return true;
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
