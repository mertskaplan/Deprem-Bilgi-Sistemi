<?php

	function find($first, $latest, $text) {
		@preg_match_all("/" . preg_quote($first, "/") .
		"(.*?)". preg_quote($latest, "/")."/i", $text, $m);
		return @$m[1];
	}
	
	function strtoupperEN($str) {
		$str = str_replace(array('i', 'ı', 'ü', 'ğ', 'ş', 'ö', 'ç', 'I', 'İ', 'Ü', 'Ğ', 'Ş', 'Ö', 'Ç'), array('I', 'I', 'U', 'G', 'S', 'O', 'C', 'I', 'I', 'U', 'G', 'S', 'O', 'C'), $str);
		return strtoupper($str);
	}
	
	function strtolowerTR($str) {
		$str = str_replace(array('i', 'ı', 'ü', 'ğ', 'ş', 'ö', 'ç', 'I', 'İ', 'Ü', 'Ğ', 'Ş', 'Ö', 'Ç'), array('i', 'ı', 'ü', 'ğ', 'ş', 'ö', 'ç', 'ı', 'i','ü', 'ğ', 'ş', 'ö', 'ç'), $str);
		return strtolower($str);
	}
	
	function ucwords_tr($gelen){
	 
		$sonuc = '';
		$kelimeler = explode(" ", $gelen);

		foreach ($kelimeler as $kelime_duz){

			$kelime_uzunluk = strlen($kelime_duz);
			$ilk_karakter = mb_substr($kelime_duz,0,1,'UTF-8');

			if($ilk_karakter == 'Ç' or $ilk_karakter=='ç'){
				$ilk_karakter = 'Ç';
			}elseif ($ilk_karakter=='Ğ' or $ilk_karakter=='ğ') {
				$ilk_karakter='Ğ';
			}elseif($ilk_karakter=='I' or $ilk_karakter=='ı'){
				$ilk_karakter='I';
			}elseif ($ilk_karakter=='İ' or $ilk_karakter=='i'){
				$ilk_karakter='İ';
			}elseif ($ilk_karakter=='Ö' or $ilk_karakter=='ö'){
				$ilk_karakter='Ö';
			}elseif ($ilk_karakter=='Ş' or $ilk_karakter=='ş'){
				$ilk_karakter='Ş';
			}elseif ($ilk_karakter=='Ü' or $ilk_karakter=='ü'){
				$ilk_karakter='Ü';
			}else{
				$ilk_karakter=strtoupper($ilk_karakter);
			}

			$digerleri=mb_substr($kelime_duz,1,$kelime_uzunluk,'UTF-8');
			$sonuc.=$ilk_karakter.kucuk_yap($digerleri).' ';

		}

		$son=trim(str_replace('  ', ' ', $sonuc));
		return $son;
	}
	
	function kucuk_yap($gelen){
	 
		$gelen=str_replace('Ç', 'ç', $gelen);
		$gelen=str_replace('Ğ', 'ğ', $gelen);
		$gelen=str_replace('I', 'ı', $gelen);
		$gelen=str_replace('İ', 'i', $gelen);
		$gelen=str_replace('Ö', 'ö', $gelen);
		$gelen=str_replace('Ş', 'ş', $gelen);
		$gelen=str_replace('Ü', 'ü', $gelen);
		$gelen=strtolower($gelen);

		return $gelen;
	}
	
	function hashtag($MultiWord){
		$MultiWord = strpos($MultiWord, " ");
		
		if	($MultiWord === false)	{$hashtag = "#";}
		else						{$hashtag = "";}
		return $hashtag;
	}
?>