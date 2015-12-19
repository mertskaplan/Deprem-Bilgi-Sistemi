<?php

	include ("functions.php");
	
	date_default_timezone_set("Europe/Istanbul");
	
	$site = "http://m.koeri.boun.edu.tr/dbs/deprem-listesi-touch.asp";
	$content = file_get_contents($site);
	$local = find("&ecenter=", "&mag", $content);
	$date = find("&tarih=", "&", $content);
	$time = find("&saat=", "&", $content);
	$mag = find("&mag=", "&", $content);
	$lat = find("&lat=", "&", $content);
	$lon = find("&lon=", "&", $content);
	
	
	header("Content-Type: application/xml; UTF-8");
	
	echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?><rss version=\"2.0\"
	xmlns:content=\"http://purl.org/rss/1.0/modules/content/\"
	xmlns:wfw=\"http://wellformedweb.org/CommentAPI/\"
	xmlns:dc=\"http://purl.org/dc/elements/1.1/\"
	xmlns:atom=\"http://www.w3.org/2005/Atom\"
	xmlns:sy=\"http://purl.org/rss/1.0/modules/syndication/\"
	xmlns:slash=\"http://purl.org/rss/1.0/modules/slash/\"
	xmlns:xhtml=\"http://www.w3.org/1999/xhtml\"
	>
				<channel>
				<title>Deprem Bilgi Sistemi</title>
				<atom:link href=\"http://deprem.mertskaplan.com/rss\" rel=\"self\" type=\"application/rss+xml\" />
				<link>http://deprem.mertskaplan.com</link>
				<description>Haberciler ve geliştiriciler için son depremlerin bilgilerini veren özelleştirilebilir RSS yayını.</description>
				<lastBuildDate>". date("D, d M Y H:i:s") ." +0200</lastBuildDate>
				<language>tr-TR</language>
				<webMaster>mail@mertskaplan.com (Mert Salih Kaplan)</webMaster>
				<sy:updatePeriod>hourly</sy:updatePeriod>
				<sy:updateFrequency>1</sy:updateFrequency>
				<generator>http://deprem.mertskaplan.com/</generator>
	";
	
	$days = array("Pazartesi","Salı","Çarşamba","Perşembe","Cuma","Cumartesi","Pazar");
	$months = array("Ocak","Şubat","Mart","Nisan","Mayıs","Haziran","Temmuz","Ağustos","Eylül","Ekim","Kasım","Aralık");
	
	$month = $months[date('m') - 1];
	$day = $days[date('N') - 1];
	
	if	(isset($_GET["mag"]))	{$magOp = str_replace(',', '.', $_GET["mag"]);}
	else						{$magOp = 0;}

	for ($x=0; $x <= 140; $x = $x+2) {
		
		$magDot = str_replace(',', '.', $mag[$x]);
		
		if		(isset($_GET["local"]) && $_GET["local"] == 1) {
			if		($local[$x] == "MARMARA DENIZI" || $local[$x] == "AKDENIZ" || $local[$x] == "AKDENİZ" || $local[$x] == "EGE DENIZI" || $local[$x] == "DOGU AKDENIZ") {$localFilter = 1;}
			else	{$localFilter = 0;}
		}
		else	{$localFilter = 0;}

		if	($magDot >= $magOp && $localFilter == 0) {
			$editDate = str_replace("/","-",$date[$x]);
			$dateFormat = date("D, d M Y", strtotime($editDate));
			setlocale(LC_TIME, 'tr_TR');
			$datePrint = date("%e %B %Y, %A", strtotime($editDate));
			
			if		($_GET["map"] == "g") {
				$link = "https://www.google.com/maps/@$lat[$x],$lon[$x],12z";
			}
			elseif	($_GET["map"] == "y") {
				$link = "https://harita.yandex.com.tr/?text=$lat[$x]%2C$lon[$x]";
			}
			elseif	($_GET["map"] == "o") {
				$link = "http://www.openstreetmap.org/#map=12/$lat[$x]/$lon[$x]";
			}
			elseif	($_GET["map"] == "b") {
				$link = "http://www.bing.com/maps/?cp=$lat[$x]~$lon[$x]&amp;lvl=14&amp;sty=h";
			}
			elseif	($_GET["map"] == "w") {
				$link = "http://wikimapia.org/#lang=tr&amp;lat=$lat[$x]&amp;lon=$lon[$x]&amp;z=12";
			}
			elseif	($_GET["map"] == "h") {
				$link = "https://www.here.com/?map=$lat[$x],$lon[$x],12";
			}
			elseif	($_GET["map"] == "z") {
				$link = "https://www.waze.com/livemap/?zoom=12&lat=$lat[$x]&lon=$lon[$x]";
			}
			else	{
				$link = "http://www.openstreetmap.org/#map=12/$lat[$x]/$lon[$x]";
			}
			
			if ($_GET["flash"] == 1 && $mag[$x] >= 5)	{$flash = "⚡";}
			else				{$flash = "";}
			
			$localeRp = str_replace("-",", ",str_replace(")","",str_replace("-(",", ",str_replace(" (",", ",$local[$x]))));
//			$localeUc = ucwords(strtolower($localeRp));
			$localeEx = explode(", ", $localeRp);
			
			$fileop = file("local.txt", FILE_IGNORE_NEW_LINES);
			$fileAykiri = file("aykiri.txt", FILE_IGNORE_NEW_LINES);
			$fileopUp = array_map('strtoupperEN', $fileop);

			for ($y = 0; isset($fileop[$y]); $y++) {
				if ($localeEx[0] == $fileopUp[$y]) {
					$localeTR1[$x] = ucwords_tr(strtolowerTR($fileop[$y]));
					break;
				}
			}
			
			for ($y = 0; isset($fileop[$y]); $y++) {
				if ($localeEx[1] == $fileopUp[$y]) {
					$localeTR2[$x] = ucwords_tr(strtolowerTR($fileop[$y]));
					break;
				}
			}

			for ($y = 0; isset($fileop[$y]); $y++) {
				if ($localeEx[2] == $fileopUp[$y]) {
					$localeTR3[$x] = ucwords_tr(strtolowerTR($fileop[$y]));
					break;
				}
			}
			
			if (!isset($localeTR1[$x])) {
				$localeTR1[$x] = ucwords(strtolower($localeEx[0]));
				
				if (in_array($localeEx[0],$fileAykiri)) {}
				else {
					$open = fopen("aykiri.txt","a");
					$write = "$localeEx[0]\n";
					fwrite($open, $write);
					fclose($open);
				}
			}
			
			if (!isset($localeTR2[$x])) {
				$localeTR2[$x] = ucwords(strtolower($localeEx[1]));
				
				if (in_array($localeEx[1],$fileAykiri)) {}
				else {
					$open = fopen("aykiri.txt","a");
					$write = "$localeEx[1]\n";
					fwrite($open, $write);
					fclose($open);
				}
			}
			
			if (!isset($localeTR3[$x])) {
				$localeTR3[$x] = ucwords(strtolower($localeEx[2]));
				
				if (in_array($localeEx[2],$fileAykiri)) {}
				else {
					$open = fopen("aykiri.txt","a");
					$write = "$localeEx[2]\n";
					fwrite($open, $write);
					fclose($open);
				}
			}
	
			if (isset($localeEx[0])) {
				if ($_GET["hashtag"] == 1) {
					$hashtag1 = hashtag($localeTR1[$x]);
				}
			}

			if (isset($localeEx[1])) {
				$separator1 = ", ";
				if ($_GET["hashtag"] == 1) {
					$hashtag2 = hashtag($localeTR2[$x]);
				}
			}
			else {$separator1 = ""; $hashtag2 = "";}
			
			if (isset($localeEx[2])) {
				$separator2 = ", ";
				if ($_GET["hashtag"] == 1) {
					$hashtag3 = hashtag($localeTR3[$x]);
				}
			}
			else {$separator2 = ""; $hashtag3 = "";}
			
			echo "
					<item>
						<title>$mag[$x] - $hashtag1$localeTR1[$x]$separator1$hashtag2$localeTR2[$x]$separator2$hashtag3$localeTR3[$x]</title>
						<link>$link</link>
						<guid>$link</guid>
						<pubDate>$dateFormat $time[$x] +0200</pubDate>
						<description>$flash ". date('j ') . $month . date(' Y ') . $day ." günü $time[$x] sularında merkez üssü $hashtag1$localeTR1[$x]$separator1$hashtag2$localeTR2[$x]$separator2$hashtag3$localeTR3[$x] olan $mag[$x] büyüklüğünde deprem meydana geldi.</description>
						<source url=\"http://www.koeri.boun.edu.tr/scripts/sondepremler.asp\">BOĞAZİÇİ ÜNİVERSİTESİ KANDİLLİ RASATHANESİ VE DEPREM ARAŞTIRMA ENSTİTÜSÜ (KRDAE) BÖLGESEL DEPREM-TSUNAMİ İZLEME VE DEĞERLENDİRME MERKEZİ (BDTİM)</source>
					</item>
			";
		}
	}
	
	echo "
			</channel>
		</rss>
	";
	
?>