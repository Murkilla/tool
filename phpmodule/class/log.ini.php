<?php

class logAbstract{


}

class log extends logAbstract{
	
	function accessLog($msg){
		var_dump(debug_backtrace());
		print_r($msg); 
	}

	function errLog($msg){
		//var_dump(debug_backtrace());
		echo " Error Log System :  ".$msg . "\n" ; 
	}
}

?>
