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
	
	public function getInvadingLocationsBySpeciesID($speciesid) {
		$resultIDs = array();
		$db = DB::instance();
		$query = 'SELECT invading_location FROM `species-invadinglocations` WHERE speciesid=?';
		$db->query($query, 'i', array($speciesid));
		while ($resultRow = $db->fetchResult()) {
			$resultIDs[] = $resultRow['invading_location'];
		}
		return $resultIDs;
	}
	
	
	public function getNativeLocationsBySpeciesID($speciesid) {
		$resultIDs = array();
		$db = DB::instance();
		$query = 'SELECT native_location FROM `species-nativelocations` WHERE speciesid=?';
		$db->query($query, 'i', array($speciesid));
		while ($resultRow = $db->fetchResult()) {
			$resultIDs[] = $resultRow['native_location'];
		}
		return $resultIDs;
	}
	
	
	public function insertNewSpecies($kingdom, $phylum, $class, $order, $family, $genus, $species, $extraNotes) {
		$db = DB::instance();
		$query = 'INSERT INTO species (kingdom, phylum, class, order, family, genus, species, extra_notes, date_added VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())';
		$db->query($query, 's,s,s,s,s,s,s', array($kingdom, $phylum, $class, $order, $family, $genus, $species, $extraNotes));
	}
	
	public function associateSpeciesWithInvadingLocation($speciesid, $locationid) {
		$db = DB::instance();
		$query = 'INSERT INTO `species-invadinglocations` (speciesid, invading_location) VALUES (?, ?)';
		$db->query($query, 'i,i', array($speciesid, $locationid));
	}
	
}

?>