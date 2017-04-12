<?php

if ( !function_exists('til') ) {
	$til = new stdclass;
	global $til;

	function til($val='') {
		global $til;
		return $til;
	}
}



til()->version = 0.8;