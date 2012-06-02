<?php

class location extends jsonwrapper {
	
	protected $locationid;
	protected $name;
	protected $polygon;
	protected $date_added;
	protected $date_modified;
	
	public function getAllLocations() {
		$resultIDs = array();
		$db = DB::instance();
		$query = 'SELECT locationid FROM locations';
		$db->query($query);
		while ($resultRow = $db->fetchResult()) {
			$resultIDs[] = $resultRow['locationid'];
		}
		return $resultIDs;
	}
	
}

?>