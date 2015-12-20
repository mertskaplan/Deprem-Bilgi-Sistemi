<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
		<title>Deprem Bilgi Sistemi</title>
		
		<link type="image/x-icon" href="favicon.ico" rel="shortcut icon">

		<link rel="stylesheet" href="css/bootstrap.min.css">
		<link rel="stylesheet" href="css/style.css">
		<link rel="stylesheet" href="css/bootstrap-select.min.css">
		<link rel="stylesheet" href="css/animate.min.css">
	
		<script src="js/jquery.min.js"></script>
		<script src="js/angular.min.js"></script>
		<script src="js/bootstrap.js"></script>
		<script src="js/bootstrap-select.min.js"></script>
		<script src="js/i18n/defaults-en_US.min.js"></script>
		<script src="js/script.js"></script>
		<script src="js/clipboard.min.js"></script>
	</head>
		
	<body>
		<div ng-app="depremApp" ng-controller="depremCtrl">
			<div class="container">
				<div class="row">
					<div class="col-sm-offset-1 col-md-offset-2 col-lg-8"></div>
						<div class="jumbotron animated shake form col-sm-offset-1 col-sm-10 col-lg-offset-2 col-lg-8">
							<h1 class="text-center">Deprem Bilgi Sistemi</h1>
							<p class="description text-center">Haberciler ve geliştiriciler için son depremlerin bilgilerini veren özelleştirilebilir RSS yayını.</p>
							<div class="input-group">
								<span class="input-group-addon" id="basic-addon1"><span class="glyphicon glyphicon-link" aria-hidden="true"></span></span>
								<input type="text" class="form-control" id="dynamic" value="http://deprem.mertskaplan.com/rss&mag={{size/10}}&map={{maps}}&local={{local}}&hashtag={{hashtag}}&flash={{flash}}" autofocus>
								<span class="input-group-btn">
									<button class="btn btn-primary" id="copy-dynamic" type="button" data-clipboard-action="copy" data-clipboard-target="#dynamic"><span class="glyphicon glyphicon-duplicate" aria-hidden="true"></span></button>
								</span>
							</div>
							<span id="helpBlock" class="help-block text-center col-sm-12">Varsayılan ayarlar için doğrudan <a href="http://deprem.mertskaplan.com/rss" target="_blank"><em>deprem.mertskaplan.com/rss</em></a> adresini kullanabilirsiniz.</span>

							<h2 class="text-center">Seçenekler</h2>
							<div class="form-horizontal col-sm-12">
								<div class="form-group">
									<label class="control-label col-sm-3" for="size">Yerleşim Dışı:</label>
									<div class="material-switch col-sm-9 text-left">
										<input id="someSwitchOptionPrimary" name="someSwitchOption001" type="checkbox" ng-model="local" ng-true-value="'1'" ng-false-value="'0'">
										<label for="someSwitchOptionPrimary" class="label-primary switch-button"></label> <a class="local" ng-if="(local == 0)">Yerleşim yeri dışındaki depremleri de <strong>göster</strong>.</a><a class="local" ng-if="(local != 0)">Yerleşim yeri dışındaki depremleri <strong>gösterme</strong>.</a>
									</div>
									<span id="yerlesim-uyari" class="yerlesim-uyari col-sm-9 col-sm-offset-3"><strong>Uyarı:</strong> Denizlerde meydana gelen ancak yerleşim yerlerini etkileyecek büyüklükteki depremleri kaçırabilirsiniz.</span>
								</div>
								
								<div class="form-group">
									<label class="control-label col-sm-3" for="size">Hashtag:</label>
									<div class="material-switch col-sm-9 text-left">
										<input id="someSwitchOptionPrimary2" name="someSwitchOption002" type="checkbox" ng-model="hashtag" ng-true-value="'1'" ng-false-value="'0'">
										<label for="someSwitchOptionPrimary2" class="label-primary switch-button"></label> <a class="local" ng-if="(hashtag == 0)">Tek kelimelik yerleşim yerlerinin başına hashtag (#) <strong>ekleme</strong>.</a><a class="local" ng-if="(hashtag != 0)">Tek kelimelik yerleşim yerlerinin başına hashtag (#) <strong>ekle</strong>.</a>
									</div>
								</div>
								
								<div class="form-group">
									<label class="control-label col-sm-3" for="size">Flash:</label>
									<div class="material-switch col-sm-9 text-left">
										<input id="someSwitchOptionPrimary3" name="someSwitchOption003" type="checkbox" ng-model="flash" ng-true-value="'1'" ng-false-value="'0'">
										<label for="someSwitchOptionPrimary3" class="label-primary switch-button"></label> <a class="local" ng-if="(flash == 0)">5 ve üzeri şiddetteki depremlerde metnin başına flash (⚡) <strong>ekleme</strong>.</a><a class="local" ng-if="(flash != 0)">5 ve üzeri şiddetteki depremlerde metnin başına flash (⚡) <strong>ekle</strong>.</a>
									</div>
								</div>
								
								<div class="form-group">
									<label class="control-label col-sm-3" for="cinsiyet">Harita Seçeneği:</label>
									<div class="input-group col-sm-9">
										<span class="input-group-addon" id="basic-addon1"><span class="glyphicon glyphicon-map-marker" aria-hidden="true"></span></span>
										<select class="selectpicker show-tick" name="maps" id="maps" ng-model="maps">
											<option value="o">OpenStreetMap</option>
											<option value="g">Google Maps</option>
											<option value="y">Yandex.Haritalar</option>
											<option value="w">Wikimapia</option>
											<option value="b">Bing Haritalar</option>
											<option value="h">Here Maps</option>
											<option value="z">Waze Live Map</option>
										</select>
										<span class="input-group-btn">
											<a ng-if="(maps == 'o')" class="btn btn-default" id="visit-map" href="http://openstreetmap.org/" target="_blank" role="button" data-toggle="tooltip" data-placement="right" title="ziyaret et"><span class="glyphicon glyphicon-globe" aria-hidden="true"></span></a>
											<a ng-if="(maps == 'g')" class="btn btn-default" id="visit-map" href="http://maps.google.com/" target="_blank" role="button" data-toggle="tooltip" data-placement="right" title="ziyaret et"><span class="glyphicon glyphicon-globe" aria-hidden="true"></span></a>
											<a ng-if="(maps == 'y')" class="btn btn-default" id="visit-map" href="http://harita.yandex.com.tr/" target="_blank" role="button" data-toggle="tooltip" data-placement="right" title="ziyaret et"><span class="glyphicon glyphicon-globe" aria-hidden="true"></span></a>
											<a ng-if="(maps == 'w')" class="btn btn-default" id="visit-map" href="http://wikimapia.org/" target="_blank" role="button" data-toggle="tooltip" data-placement="right" title="ziyaret et"><span class="glyphicon glyphicon-globe" aria-hidden="true"></span></a>
											<a ng-if="(maps == 'b')" class="btn btn-default" id="visit-map" href="http://www.bing.com/maps/" target="_blank" role="button" data-toggle="tooltip" data-placement="right" title="ziyaret et"><span class="glyphicon glyphicon-globe" aria-hidden="true"></span></a>
											<a ng-if="(maps == 'h')" class="btn btn-default" id="visit-map" href="https://www.here.com/" target="_blank" role="button" data-toggle="tooltip" data-placement="right" title="ziyaret et"><span class="glyphicon glyphicon-globe" aria-hidden="true"></span></a>											
											<a ng-if="(maps == 'z')" class="btn btn-default" id="visit-map" href="https://www.waze.com/" target="_blank" role="button" data-toggle="tooltip" data-placement="right" title="ziyaret et"><span class="glyphicon glyphicon-globe" aria-hidden="true"></span></a>
										</span>
									</div>
								</div>
								
								<div class="form-group">
									<label class="control-label col-sm-3" for="size">Deprem Şiddeti:</label>
									<div class="input-group col-sm-9">
										<span class="input-group-addon" id="basic-addon1"><span class="glyphicon glyphicon-flash" aria-hidden="true"></span></span>
										<div class="range">
											<input type="range" id="range" name="range" min="0" max="90" ng-model="size">
										</div>
										<span class="input-group-addon" id="basic-addon2">{{size/10}}<a ng-if="(size == 10 || size == 20 || size == 30 || size == 40 || size == 50 || size == 60 || size == 70 || size == 80 || size == 90)">.0</a><a ng-if="size > 89">+</a></span>
									</div>
									<span id="helpBlock" class="help-block text-center col-sm-9 col-sm-offset-3">Yerel magnitüd ölçeğine göre (Richter ölçeği)</span>
									<div class="range-description-header col-sm-9 col-sm-offset-3">
										<h3>Hissetme ve Etkiler</h3>
									</div>
									<div class="range-description animated fadeIn col-sm-9 col-sm-offset-3" ng-if="(size < 20)">
										<li>Sadece özel sismik aletler sayesinde ölçülür.</li>
									</div>
									<div class="range-description animated fadeIn col-sm-9 col-sm-offset-3" ng-if="(size > 19 && size < 30)">
										<li>Hareket etmeyen insanlar tarafından hissedilebilir.</li>
										<li>Serbest asılı lamba vb. cisimler hafif sallanabilir.</li>
									</div>
									<div class="range-description animated fadeIn col-sm-9 col-sm-offset-3" ng-if="(size > 29 && size < 40)">
										<li>Az sayıda insan tarafından hissedilebilir.</li>
										<li>Hafif sarsıntılar bir pencere önünden geçen bir kamyonu andırır.</li>
										<li>Yan yana duran cam bardaklar hafif titreyebilir.</li>
									</div>
									<div class="range-description animated fadeIn col-sm-9 col-sm-offset-3" ng-if="(size > 39 && size < 50)">
										<li>Çok sayıda insan hisseder.</li>
										<li>Serbest asılı lamba vb. cisimler görülecek şekilde sallanmaya başlar.</li>
										<li>Bardak, tabak vb. takırdamaya başlar.</li>
										<li>Park vaziyetinde arabalar hafif sallanır.</li>
										<li>Çok hafif zararlar meydana gelebilir.</li>
									</div>
									<div class="range-description animated fadeIn col-sm-9 col-sm-offset-3" ng-if="(size > 49 && size < 60)">
										<li>Korku ve paniğe neden olabilir.</li>
										<li>Birçok insan aniden ev ve kapalı mekânları terkeder.</li>
										<li>Kötü inşa edilmiş binalarda büyük hasarlar meydana gelebilir.</li>
										<li>Duvarlarda çatlamalar olabilir.</li>
										<li>Yaralanmalar meydana gelebilir.</li>
									</div>
									<div class="range-description animated fadeIn col-sm-9 col-sm-offset-3" ng-if="(size > 59 && size < 70)">
										<li>Korku ve paniğe neden olma olasılığı vardır.</li>
										<li>Hareket halindeki araba içinde hissedilebilir.</li>
										<li>160 km içindeki binalarda hasarlar oluşturabilir ve çökmeler meydana gelebilir.</li>
										<li>Yaralanmalar ve ölümler olabilir.</li>
										<li>Sahil kenarlarında tsunami olabilir.</li>
									</div>
									<div class="range-description animated fadeIn col-sm-9 col-sm-offset-3" ng-if="(size > 69 && size < 80)">
										<li>Korku ve paniğe neden olma olasılığı yüksektir.</li>
										<li>Daha geniş alanlarda ağır tahribata neden olur.</li>
										<li>Binalarda hafif, orta, ağır derecelerde hasar oluşma ihtimali yüksektir, çökmeler meydana gelebilir.</li>
										<li>Toprakta yarıklar oluşur.</li>
										<li>Ölümler ve yaralanmalar oluşur.</li>
										<li>Sahil bölgelerde büyük tahribat gücü taşıyan tsunami olabilir.</li>
									</div>
									<div class="range-description animated fadeIn col-sm-9 col-sm-offset-3" ng-if="(size > 79 && size < 90)">
										<li>Yüzlerce kilometrelik alanda büyük tahribata yol açar.</li>
										<li>Binalarda ağır hasara ve çökmelere yol açma ihtimali oldukça yüksektir.</li>
										<li>Yüksek miktarda yaralanmalar ve ölümler meydana gelebilir.</li>
										<li>Geniş sahil bölgelerinde 40 metreye yaklaşık tsunami olasılığı vardır.</li>
									</div>
									<div class="range-description animated fadeIn col-sm-9 col-sm-offset-3" ng-if="(size > 89)">
										<li>Binlerce kilometrelik alanda yıkıcıdır.</li>
										<li>Tektonik levhalarda kaymalar, kırılmalar meydana gelir.</li>
										<li>Sahillerin kıyıları deniz seviyesi altına batabilir veya çıkabilir.</li>
										<li>Çok yüksek miktarda yaralanmalar ve ölümler meydana gelebilir.</li>
									</div>
								</div>
							</div>

							<div class="logo text-center">
								<img width="86" height="86" class="grayscale" src="/img/bing-logo.svg">
								<img width="86" height="86" class="grayscale" src="/img/yandex-logo.svg">
								<img width="86" height="86" class="grayscale" src="/img/google-maps-logo.svg">
								<img width="86" height="86" class="grayscale" src="/img/openstreetmap-logo.svg">
								<img width="86" height="86" class="grayscale" src="/img/here-logo.svg">
								<img width="86" height="86" class="grayscale" src="/img/wikimapia-logo.svg">
								<img width="86" height="86" class="grayscale" src="/img/waze-logo.svg">
							</div>	
							<p class="source text-center">Deprem verileri (derin bir nefes alın) <a href="http://www.koeri.boun.edu.tr/sismo/2/tr/" target="_blank">Boğaziçi Üniversitesi Kandilli Rasathanesi ve Deprem Araştırma Enstitüsü Bölgesel Deprem-Tsunami İzleme ve Değerlendirme Merkezi</a>'nden alınmaktadır.</p>							
							<p class="twitter-button text-center">
								<a href="https://twitter.com/DepremBilgiSis" class="twitter-follow-button" data-show-count="false" data-lang="tr" data-size="large" data-dnt="true">Takip et: @DepremBilgiSis</a>
								<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
							</p>
						</div>
					</div>
					<div class="row github">
						<p class="code text-center">
							coded with <a class="tip" data-toggle="tooltip" data-placement="top" title="PHP, HTML, CSS, JS, XML">❤</a> by <a href="http://mertskaplan.com/" target="_blank">mertskaplan</a> under <a href="/LICENSE" rel="license" data-toggle="tooltip" data-placement="top" title="GNU General Public License, version 3" class="license">GPLv3</a> license | <a href="https://github.com/mertskaplan/Deprem-Bilgi-Sistemi" target="_blank">GitHub</a>
						</p>
					</div>
				</div>
			</div>
		</div>

	<script>
		var clipboard = new Clipboard('.btn');

		clipboard.on('success', function(e) {
			console.log(e);
		});

		clipboard.on('error', function(e) {
			console.log(e);
		});
    </script>
	</body>
</html>