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
	
	
	public function insertNewLocation($name, $polygon) {
		try {
			$db = DB::instance();
			$query = 'INSERT INTO locations (name, polygon, date_added) VALUES (?, PolyFromText("POLYGON(('.$this->formatPolygon($polygon).'))"), NOW())';
			$db->query($query, 's', array($name));
		} catch (Exception $e) {
			return FALSE;
		}
		return TRUE;
	}
	
	
	public function updateLocation($locationid, $name, $polygon) {
		try {
			$db = DB::instance();
			$query = 'UPDATE locations SET name=?, polygon=PolyFromText("POLYGON(('.$this->formatPolygon($polygon).'))") WHERE locationid=?';
			$db->query($query, 's,i', array($name, $locationid));
		} catch (Exception $e) {
			return FALSE;
		}
		return TRUE;
	}
	
	
	private function formatPolygon($polygon) {
		/*
		 * format of the post polygon data
		 * -72.790346 44.216194,-72.789617 44.216278,-72.789059 44.216447,-72.788565 44.21674,-72.788243 44.21704,-72.787911 44.21747,-72.787653 44.217755,-72.787492 44.218008,-72.78746 44.218354,-72.787417 44.218524,-72.787557 44.218708,-72.787803 44.218839,-72.788093 44.218977,-72.78834 44.219108,-72.788608 44.219085,-72.788844 44.218946,-72.788748 44.218716,-72.788544 44.218516,-72.78849 44.218339,-72.788426 44.218201,-72.788415 44.217993,-72.788662 44.217647,-72.789016 44.217355,-72.789552 44.217109,-72.790185 44.216916,-72.790711 44.216824,-72.791011 44.216624,-72.791247 44.216363,-72.791269 44.216055,-72.791226 44.215932,-72.790636 44.215932,-72.790614 44.216124,-72.790346 44.216194
		 */
		preg_match('/((\-?\d+\.\d*\s\-?\d+\.\d*,?)*)/i', $polygon, $matches);
		return $matches[1]; //this sanitizes the polygon post data...Bobby DropTables!
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