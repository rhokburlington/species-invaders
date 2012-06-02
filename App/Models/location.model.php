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
	
	
	public function getLocationByID($locationid) {
		$db = DB::instance();
		$query = 'SELECT locationid, name, AsText(polygon) AS polygon FROM locations WHERE locationid=?';
		$db->query($query, 'i', array($locationid));
		$resultRow = $db->fetchResult();
		$this->populate($resultRow);
		$this->fixPolygon();
	}
	
	private function fixPolygon() {
		$resultArray = array();
		$modifiedPolygon = preg_replace('/^polygon\(\(|\)\)$/i', '', $this->polygon);
		$coordinatePairs = explode(',', $modifiedPolygon);
		foreach ($coordinatePairs as $c) {
			$resultArray[] = explode(' ', $c);
		}
		$this->polygon = $resultArray;
	}
}

?>