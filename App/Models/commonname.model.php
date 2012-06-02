<?php

class commonname extends jsonwrapper {
	
	protected $speciesid;
	protected $name;
	
	
	public function getCommonNameBySpeciesID($speciesid) {
		$resultNames = array();
		$db = DB::instance();
		$query = 'SELECT * FROM `common-names` WHERE speciesid=?';
		$db->query($query, 'i', array($speciesid));
		while ($resultRow = $db->fetchResult()) {
			$commonName = new commonname();
			$commonName->populate($resultRow);
			$resultNames[] = $commonName;
		}
		return $resultNames;
	}
	
}

?>