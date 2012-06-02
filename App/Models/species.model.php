<?php

class species extends CoreModel implements JsonSerializable {
	
	public $speciesid;
	public $kingdom;
	public $phylum;
	public $class;
	public $order;
	public $family;
	public $genus;
	public $species;
	public $extra_notes;
	public $commonNames; //array of common name objects
	
	
	public function getSpeciesByID($id) {
		$db = DB::instance();
		$query = 'SELECT * FROM species WHERE speciesid=?';
		$db->query($query, 'i', array($id));
		$resultRow = $db->fetchResult();
		$this->populate($resultRow);
	}
	
	
	public function jsonSerialize() {
		return get_object_vars($this);
	}
	
}

?>