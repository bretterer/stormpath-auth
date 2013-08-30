<?php namespace Lamarus\Stormpath;

use Illuminate\Auth\UserInterface;

class StormpathUser implements UserInterface {

	protected $url;

	public function __construct($url) {
		$this->url = $url;
	}
	/**
	 * Get the unique identifier for the user.
	 *
	 * @return mixed
	 */
	public function getAuthIdentifier() {
		return $this->url;
	}

	/**
	 * Get the password for the user.
	 *
	 * @return string
	 */
	public function getAuthPassword() {

	}
}