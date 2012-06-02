<?php

class api extends CoreController implements ICoreController {
	
	public function __construct() {
		parent::__construct();
		
	}
	
	
	public function invoke() {
		echo 'this is the api!';
	}
}

?>