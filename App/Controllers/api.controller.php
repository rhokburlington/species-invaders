<?php

class api extends CoreController implements ICoreController {
	
	const ID = 'id';
	const NATIVE_LOCATION = 'native_locations';
	const INVADING_LOCATION = 'invading_locations';
	const COMMON_NAME = 'common_name';
	const SEARCH = 'search';
	
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
			case self::NATIVE_LOCATION:
				try {
					$result = json_encode($species->associateSpeciesWithNativeLocation(Input::post('speciesid'), Input::post('locationid')));
				} catch (InputIOException $e) {
					$result = json_encode($species->getNativeLocationsBySpeciesID($paramValue));
				}
				break;
			case self::INVADING_LOCATION:
				try {
					$result = json_encode($species->associateSpeciesWithInvadingLocation(Input::post('speciesid'), Input::post('locationid')));	
				} catch (InputIOException $e) {
					$result = json_encode($species->getInvadingLocationsBySpeciesID($paramValue));
				}
				break;
			case self::COMMON_NAME:
				$result = json_encode($species->addCommonName(Input::post('speciesid'), Input::post('common_name')));
				break;
			case self::SEARCH:
				$result = json_encode($species->search(urldecode($paramValue)));
				break;
			case null:
				try {
					$result = json_encode($species->insertNewSpecies(Input::post('kingdom'), 
																	Input::post('phylum'),
																	Input::post('class'),
																	Input::post('order'),
																	Input::post('family'),
																	Input::post('genus'),
																	Input::post('species'),
																	Input::post('extra_notes')));
				} catch (InputIOException $e) {
					$result = json_encode($species->getAllSpecies());
				}
				break;
			default:
				header('HTTP/1.1 400 Bad API Request');
		}
		
		$this->jsonPrecontroller();
		echo $result;
	}
	
	
	public function locations_precontroller($paramName=null, $paramValue=null) {
		$location = new location();
		$result = null;
		switch ($paramName) {
			case self::ID:
				try {
					$result = json_encode($location->updateLocation(Input::post('locationid'), Input::post('name'), Input::post('polygon')));
				} catch (InputIOException $e) {
					$location->getLocationByID($paramValue);
					$result = $location->json();
				}
				break;
			case null:
				try {
					$result = json_encode($location->insertNewLocation(Input::post('name'), Input::post('polygon')));
				} catch (InputIOException $e) {
					$result = json_encode($location->getAllLocations());
				}
				break;
			default:
				header('HTTP/1.1 400 Bad API Request');
		}
		$this->jsonPrecontroller();
		echo $result;
	}
	
}

?>