<?php

class AESEncryptAbstract {

}

class AESEncrypt extends AESEncryptAbstract
{

	function strEncode($text)
	{
		$str = "";

		if($text != null && strlen($text) > 0){
			$str = mcrypt_encrypt( $this->getCipher(), $this->getKey(), $this->addPKCS7Padding($text), $this->getMode(), $this->getIV()) ;
			$str = base64_encode($str);
		}
        
		return $str;
	}

	function strDecode($text)
	{
		$str = "";

                if($text != null && strlen($text) > 0){
			$str = base64_decode($text) ;
			$str = mcrypt_decrypt( $this->getCipher(), $this->getKey(), $str, $this->getMode(), $this->getIV()) ;
                }
		return $str;
	}

	function imgEncode($content)
	{
		$data = null;

		if($content != null){
			$data = mcrypt_encrypt( $this->getCipher(), $this->getKey(), $this->addPKCS7Padding($content), $this->getMode(), $this->getIV()) ;
		}

		return $data;
	}

	function imgDecode($content)
        {
                $data = null;

                if($content != null){
                        $data = mcrypt_decrypt( $this->getCipher(), $this->getKey(), $content, $this->getMode(), $this->getIV()) ;
                }

                return $data;
        }

	private function addPKCS7Padding($source)
        {
             $block = mcrypt_get_block_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
             $pad = $block - (strlen($source) % $block);
             if ($pad <= $block) {
                 $char = chr($pad);
                 $source .= str_repeat($char, $pad);
             }
             return $source;
        }

	private function getCipher()
	{
		return MCRYPT_RIJNDAEL_128 ;
	}

	private function getMode()
	{
		return MCRYPT_MODE_CBC ;
	}

	private function getKey()
	{
		$key = (string)"dongbinhuiasxiny";
		return $key;
	}

	private function getIV()
	{
		$iv = (string)"poilkjmnbyhtgvfr";
		return $iv;
	}

	function ShowMSG()
	{
		echo "you get me\n" ;
	}
}

?>
