<?php

class jsonwrapper extends CoreModel {
	
	public function json() {
		return json_encode($this->toArray());	
	}
	
	public function toArray() {
		$objectVars = get_object_vars($this);
		foreach ($objectVars as &$objvar) {
			if (is_array($objvar)) {
				foreach ($objvar as &$o) {
					if (is_object($o) && $o instanceof self) {
						$o = $o->toArray($o);
					}
				}
			} else if (is_object($objvar) && $objvar instanceof self)  {
				$objvar = $objvar->toArray();
			}
		}
		return $objVars;
	}
	
}

?>