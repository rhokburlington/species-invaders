<?php

class species extends CoreModel {
	
	protected $speciesid;
	protected $kingdom;
	protected $phylum;
	protected $class;
	protected $order;
	protected $family;
	protected $genus;
	protected $species;
	protected $extra_notes;
	protected $commonNames; //array of common name objects
	
	
	public function getSpeciesByID($id) {
		$db = DB::instance();
		$query = 'SELECT * FROM species WHERE speciesid=?';
		$db->query($query, 'i', array($id));
		$resultRow = $db->fetchResult();
		$this->populate($resultRow);
	}
	
	public function json() {
		return json_encode(get_object_vars($this));
	}
	
}

?>