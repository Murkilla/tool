<?php
date_default_timezone_set('Asia/Taipei');
if($_GET){
	$arr = explode('/',key($_GET));
	foreach($arr as $ak => $av){
		if($av != ''){
			$path_arr_key[] = $ak ; 
			$path_arr_val[] = $av ; 
		}
	}
	//echo count($path_arr_key); exit ;
	if(count($path_arr_key) == '1'){
		$_GET["fun"] =  $path_arr_val[0] ; 
		$_GET["act"] =  'view' ; 
		if (isset($path_arr_val[2])) {
			$_GET[$path_arr_val[2]] =  $_GET[key($_GET)] ; 
		}
	}
	else{
		$_GET["fun"] =  $path_arr_val[0] ; 
		$_GET["act"] =  $path_arr_val[1] ; 
		if (isset($path_arr_val[2])) {
			$_GET[$path_arr_val[2]] =  $_GET[key($_GET)] ; 
		}
	}
}
require_once dirname(__FILE__).'/phpmodule/include/config.ini.php';
session_start();


require_once $config['path_class']."/everest.ini.php";
$obj = new initClasse();


