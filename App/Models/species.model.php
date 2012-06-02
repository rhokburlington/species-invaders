<?php

class species extends jsonwrapper {
	
	protected $speciesid;
	protected $kingdom;
	protected $phylum;
	protected $class;
	protected $order;
	protected $family;
	protected $genus;
	protected $species;
	protected $extra_notes;
	protected $date_added;
	protected $date_modified;
	protected $commonNames; //array of common name objects
	
	
	public function __construct() {
		$this->commonNames = array();
	}
	
	public function getSpeciesByID($id) {
		$db = DB::instance();
		$query = 'SELECT * FROM species WHERE speciesid=?';
		$db->query($query, 'i', array($id));
		$resultRow = $db->fetchResult();
		$this->populate($resultRow);
		$commonName = new commonname();
		$this->commonNames = $commonName->getCommonNameBySpeciesID($this->speciesid);
	}
	
	
	public function getAllSpecies() {
		$resultIDs = array();
		$db = DB::instance();
		$query = 'SELECT speciesid FROM species';
		$db->query($query);
		while ($resultRow = $db->fetchResult()) {
			$resultIDs[] = $resultRow['speciesid'];
		}
		return $resultIDs;
	}
	
}

?>