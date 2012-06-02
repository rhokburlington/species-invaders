<?php

class jsonwrapper extends CoreModel {
	
	public function json() {
		$objectVars = get_object_vars($this);
		foreach ($objectVars as &$objvar) {
			if (is_array($objvar)) {
				foreach ($objvar as &$o) {
					if (is_object($o)) {
						$o = get_object_vars($o);
					}
				}
			} else if (is_object($objvar))  {
				$objvar = get_object_vars($o);
			}
		}
		return json_encode($objectVars);	
	}
	
}

?>