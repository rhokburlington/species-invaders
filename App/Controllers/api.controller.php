<?php

class api extends CoreController implements ICoreController {
	
	const ID = 'id';
	
	public function __construct() {
		parent::__construct();
		
	}
	

	private function jsonPrecontroller() {
		header('Content-type: application/json');
	}
	
	
	public function precontroller() {
		header('HTTP/1.1 404 Not Found');
	}
	
	public function species_precontroller($paramName=null, $paramValue=null) {
		$species = new species();
		$result = null;
		switch ($paramName) {
			case self::ID:
				$species->getSpeciesByID($paramValue);
				$result = $species->json();
				break;
			case null:
				$result = json_encode($species->getAllSpecies());
				break;
			default:
				header('HTTP/1.1 400 Bad API Request');
		}
		
		$this->jsonPrecontroller();
		echo $result;
	}
	
}

?>