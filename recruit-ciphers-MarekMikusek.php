<?php

interface CiphersContract{
	public function encrypt(string $input):string;
	public function decrypt(string $input):string;
}

class Cesar implements CiphersContract{
	
	public function encrypt(string $input):string{
	    $offset = 5;
		$letters=range('a', 'z');
		$numberOfLetters = count($letters);
		$encoded='';
		while($offset>=$numberOfLetters){
			$offset-=$numberOfLetters;
		}
		while($offset<0){
			$offset+=$numberOfLetters;
		}
		if(intval($offset)==0){
			return '';
		}
		foreach(str_split($input) as $letter){
			$key =array_search($letter, $letters);
			$encoded.=$letters[($key +$offset) % $numberOfLetters];
		}
				return $encoded;
	}
	public function decrypt(string $input):string{
		$offset=5;
		
		$letters=range('a', 'z');
		$numberOfLetters = count($letters);
		while($offset>=$numberOfLetters){
			$offset-=$numberOfLetters;
		}	
		while($offset<0){
			$offset+=$numberOfLetters;
		}
		if(intval($offset)==0){
			return false;
		}
		$decoded='';
		foreach(str_split($input) as $letter){
			$key =array_search($letter, $letters);
			$decoded.=$letters[($key + $numberOfLetters - $offset) % $numberOfLetters];
		}
				return $decoded;
	}
	
	public function test(){
		$testEncrypt = $this->encrypt('cesar'); 
		$testDecrypt = $this->decrypt('hjxfw'); 
		echo sprintf("Test of function encrypting according to Cesar: encrypting 'cesar' with offset 8 gives result '%s', result is %s \r\n", $testEncrypt, $testEncrypt=='hjxfw'?'OK': 'not OK');
		echo sprintf("Test of function decrypting according to Cesar: decrypting 'hjxfw' with offset 8 gives result %s, result is %s \r\n", $testDecrypt, $testDecrypt=='cesar'?'OK': 'not OK');
	}
}


class AtBash implements CiphersContract
{
	public function encrypt(string $input):string{
		$letters=range('a', 'z');
		$numberOfLetters = count($letters);
		$encoded='';
		foreach(str_split($input) as $letter){
			$key =array_search($letter, $letters);
			$encoded.=$letters[$numberOfLetters - $key-1];
		}
				return $encoded;
	}
	public function decrypt(string $input):string{
		$letters=range('a', 'z');
		$numberOfLetters = count($letters);
		$decoded='';
		foreach(str_split($input) as $letter){
			$key =array_search($letter, $letters);
			$decoded.=$letters[$numberOfLetters - $key-1];
		}
				return $decoded;
	}

	public  function test(){
		$testEncrypt = $this->encrypt('atbash'); 
		$testDecrypt = $this->decrypt('zgyzhs'); 
		echo sprintf("Test of function encrypting according to AtBash: encrypting 'atbash' gives result '%s', result is %s \r\n", $testEncrypt, $testEncrypt=='zgyzhs'?'OK': 'not OK');
		echo sprintf("Test of function decrypting according to AtBash: decrypting 'zgyzhs' gives result %s, result is %s  \r\n", $testDecrypt, $testDecrypt=='atbash'?'OK': 'not OK');
	}
}

class Bacon implements CiphersContract{
	public 	function encrypt(string $input):string{
		$letters=range('a', 'z');
		$encoder =[];
		foreach($letters as $id => $letter){
			$binaryId = decbin($id);
			$encoder[$letter] = str_replace(['0','1'],['a','b'],str_pad($binaryId, 5, "0", STR_PAD_LEFT));
		}
		$encoded='';
		foreach(str_split($input) as $letter){
			$encoded.=$encoder[$letter].' ';
		}
		return trim($encoded);
	}
	public function decrypt(string $input):string{
		$letters=range('a', 'z');
		$decoder =[];
		foreach($letters as $id => $letter){
			$binaryId = decbin($id);
			$decoder[str_replace(['0','1'],['a','b'],str_pad($binaryId, 5, "0", STR_PAD_LEFT))] = $letter;
		}
		$decoded='';
		foreach(explode(' ',$input) as $code){
			if(!isset($decoder[$code])){
				return false;
			}
			$decoded.=$decoder[$code];
		}
		return $decoded;
	}

	public function test(){
		$testEncrypt = $this->encrypt('bacon'); 
		$testDecrypt = $this->decrypt($testEncrypt); 
		echo sprintf("Test of function encrypting according to Bacon: 'bacon' gives result '%s', result is %s \r\n", $testEncrypt, $testEncrypt=='aaaab aaaaa aaaba abbba abbab'?'OK': 'not OK');
		echo sprintf("Test of function decrypting according to Bacon: 'aaaab aaaaa aaaba abbba abbab' gives result %s, result is %s  \r\n", $testDecrypt, $testDecrypt=='bacon'?'OK': 'not OK');
	}
}
	
$cezar = new Cesar();
$cezar->test();
	
$bacon = new Bacon();
$bacon ->test();

$atBash = new AtBash();
$atBash ->test();