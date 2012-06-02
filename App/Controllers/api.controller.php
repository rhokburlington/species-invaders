<?php

class api extends CoreController implements ICoreController {
	
	public function __construct() {
		parent::__construct();
		
	}
	

	private function jsonPrecontroller() {
		header('Content-type: application/json');
	}
	
	
	public function precontroller() {
		header('HTTP/1.1 404 Not Found');
	}
	
	public function species_precontroller() {
		$this->jsonPrecontroller();
		$species = new species();
		$species->getSpeciesByID(Input::get('id'));
		echo $species->json();
	}
	
}

?>