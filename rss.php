<?php

	function find($first, $latest, $text) {
		@preg_match_all("/" . preg_quote($first, "/") .
		"(.*?)". preg_quote($latest, "/")."/i", $text, $m);
		return @$m[1];
	}
	
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
			if		($local[$x] == "MARMARA DENIZI" || $local[$x] == "AKDENIZ" || $local[$x] == "AKDENİZ") {$localFilter = 1;}
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
			
			echo "
					<item>
						<title>$mag[$x] - $local[$x]</title>
						<link>$link</link>
						<guid>$link</guid>
						<pubDate>$dateFormat $time[$x] +0200</pubDate>
						<description>". date('j ') . $month . date(' Y ') . $day ." günü $time[$x] sularında merkez üssü $local[$x] olan $mag[$x] büyüklüğünde deprem meydana geldi.</description>
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