<?php

class jsonwrapper extends CoreModel {
	
	public function json() {
		$objectVars = get_object_vars($this);
		foreach ($objectVars as &$objvar) {
			if (is_array($objvar)) {
				foreach ($objvar as &$o) {
					if ($o instanceof self) {
						$o = $o->json();
					}
				}
			} else if ($objvar instanceof self)  {
				$objvar = $objvar->json();
			}
		}
		return json_encode($objectVars);	
	}
	
}

?>