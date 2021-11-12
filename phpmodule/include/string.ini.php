<?php
	function strEncode($data,$key,$encode_type = "crypt"){
	        if($encode_type == "crypt"){
			
	                $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
	                $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
	                return urlencode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256,$key,$data,MCRYPT_MODE_ECB,$iv));
	        }
                elseif($encode_type == "md5"){
                        return urlencode($data);
                }
                else{
                        echo "Please write \$encode_type type to config.ini.php!!"; exit ;
                }
	}

	function strDecode($data,$key,$encode_type){
                if($encode_type == "crypt"){
                        $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256 , MCRYPT_MODE_ECB);
                        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
                        return trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256,$key,urldecode($data),MCRYPT_MODE_ECB,$iv));
                }
                elseif($encode_type == "md5"){
                        return urldecode($data);
                }
                else{
                        echo "Please write \$encode_type type to config.ini.php file!!"; exit ;
                }

	}

	function rotate($str) {
		// Shaun fix encrypt & decrypt 
		//$head = substr($str, 0, $len);
		//$tail = substr($str, -$len);
		//$str = substr_replace($str, $tail, 0, $len);
		//$str = substr_replace($str, $head, -$len);

		$strLen = strlen($str);
		$len = floor($strLen/3);
		$remainder = $strLen % 3 ;
		
		$header = substr($str , ($strLen-$len) ,$len) ;
		$mind = substr($str ,$len,$len+$remainder)  ;
		$footer = substr($str, 0 ,$len)  ;
		$str = 	$header . $mind . $footer 	; 
		return $str ; 
		/*
		echo "total Len  : " . strlen($str);
		echo "\n" ; 
		echo "header     : ". $header  ;
		echo "\n" ; 
		echo "header Len : ". strlen($header)  ;
		echo "\n" ; 
		echo "mind       : ". $mind  ;
		echo "\n" ; 
		echo "mind Len   : ". strlen($mind)  ;
		echo "\n" ; 
		echo "footer     : ". $footer ;
		echo "\n" ; 
		echo "footer Len : ". strlen($footer)  ;
		echo "\n" ; 
		echo "decrypt    : ". $str  ;
		echo "\n" ; 
		echo "decrypt Len: ". strlen($str)  ;
		echo "\n" ; 
		*/

	}


	function strDe($src) {
		$src = rotate($src);
		//echo $src ; echo "\n";
		$temp = base64_decode($src);
		if (empty($temp)) {
			return -1;
		}
		$temp = gzinflate($temp);
		if (empty($temp)) {
			return -2;
		}
		$temp = json_decode($temp, true);
		if (empty($temp)) {
			return -3;
		}
		//$temp = json_decode($src , true) ; 
		return $temp;
	}

	function strEn($src,$tag = true) {
		$temp = json_encode($src);

		if (empty($temp)) {
			return -4;
		}
		$temp = gzdeflate($temp , -1);
		if (empty($temp)) {
			return -5;
		}
		$temp = base64_encode($temp);
		if (empty($temp)) {
			return -6;
		}
		$temp = rotate($temp);

		//$temp = json_encode($src);

		if(!$tag){
			return $temp;
		}
		else{
			return '[WGESTART]' . $temp . '[WGEEND]';
		}
	}

	function getCsv($filename){
		$arr = array();
		if (($handle = fopen($filename, "r")) !== FALSE) {
			$no = 0 ; 
			while (($data = fgetcsv($handle, filesize($filename), ",")) !== FALSE) {
				if(is_array($data)){
					foreach($data as $dk => $dv){
						$arr[$no][$dk] = str_replace("\t","",str_replace(" ","",$dv) ) ; 
					}
				}
				$no++ ; 
				//print_r($arr); 
			}
			fclose($handle);
		}
		return $arr ; 
	}


	function writeFile($path_file,$str){
		$fp = fopen($path_file, 'w+');
		fwrite($fp, $str);
		fclose($fp);
	}





?>
