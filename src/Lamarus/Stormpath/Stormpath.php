<?php  namespace Lamarus\Stormpath;


class Stormpath {
	
	public function __construct() {
		$this->StormpathUserProvider = new StormpathUserProvider();
	}

}