<?php

class jsonwrapper extends CoreModel {
	
	public function json() {
		return json_encode(get_object_vars($this));	
	}
	
}

?>