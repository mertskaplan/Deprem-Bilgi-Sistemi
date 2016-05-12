# Deprem Bilgi Sistemi - v3.0
Haberciler ve geliştiriciler için Türkiye'deki son depremlerin bilgilerini veren özelleştirilebilir **RSS** yayını.

> **Adres:** http://deprem.mertskaplan.com/

### Özelleştirme Seçenekleri
* **Yerleşim yeri dışındaki depremleri göstermeme seçeneği:** Özellikle denizlerde meydana gelen depremlerin liste dışına alınması ile insanları daha çok etkileyebilecek depremlerin öne çıkması hedeflenmiştir.
* **Hashtag ekleme seçeneği:** Yerleşim yerlerinin başına hashtag (#) ekleme seçeneği ile hashtag kullanılan platformlarda kullanım kolaylığı yaratmak amaçlanmıştır. Hashtaglerin bölünmemesi için bu özellik sadece tek kelimeden oluşan yer adları için eklenmiştir. 
* **Flash ekleme seçeneği:** Magnitüd[[1]](#Dipnot) ölçeğine göre (Richter ölçeği) 5 ve üzeri büyüklükteki depremler için metinlerin başına flash karakteri (⚡) eklenerek daha önemli depremlerin görünürlülüğünün artırılması yoluna gidilmiştir.
* **Deprem büyüklüğü seçeneği:** Belirli büyüklükten küçük depremler gösterilmeyerek daha iyi bir hedefleme yapılması sağlanmıştır.
* **Harita seçeneği:** Depremlerin konum bilgilerinin işaretlenmesi için farklı online harita sistemleri için bağlantılar eklenerek çeşitlilik sağlanmıştır. Bu harita sistemleri şöyledir:
    * OpenStreetMap (*varsayılan*)
    * Google Maps
    * Yandex.Haritalar
    * Wikimapia
    * Bing Haritalar
    * Here Maps
    * Waze Live Map

### Özelleştirme Methodu
Özelleştirmeler için PHP'deki **GET methodu** kullanılmıştır. Örnek olarak aşağıda varsayılan GET bağlantısına ait değerler gösterilmektedir.

    /rss&mag=0&map=o&local=0&hashtag=0&flash=0

**Not 1:** İlk GET değeri için kullanılan "**?**" karakterine gerek kalmaması için **[.htaccess](https://github.com/mertskaplan/Deprem-Bilgi-Sistemi/blob/master/.htaccess)** ile "**&**" karakteri de kullanılabilir hale getirilmiştir.

**Not 2:** Deprem büyüklüğü süzgecini belirleyen "**mag**" değeri, normalde "**,**" ile ayrılmasına rağmen[[2]](#Dipnot) adres satırı için "**.**" ile de kullanılabilir hale getirilmiştir. Örnek:  `mag=3,8` = `mag=3.8`

### Altyapı
Sistem için temelde **PHP** olmak üzere, **HTML5**, **CSS3**, **JS** ve **XML** dilleri ile **Bootstrap** ve **AngularJS** kütüphanelerinden yararlanılmıştır.

### Değişiklikler
##### v3.0
* Deprem merkezlerine ait otamatik olarak üretilen harita görseli eklendi.
* "Yerleşim yeri dışı" kısmına komşu ülkeler ve yeni yerler eklendi.
* Veri kaynağından kaynaklanan ve düzensizliğe neden olan köşeli parantez karakterleri yer adlarından kaldırıldı.
* Türkçe dosya adları proje diline uygun olarak İngilizce'ye çevrildi.
* Twitter için özel, 140 karaktere uygun içerik mesajı seçeneği hazırlandı.
* SSL desteği eklendi.
* Yeni yer adları süzgece eklendi.
* Arka plan deseni dosyalar içine alındı.
* JS kaynağı optimize edildi.
* Hatalı kullanılan "depremin şiddeti" tamlaması "depremin büyüklüğü" olarak değiştirildi.
* En büyük deprem büyüklüğü 8.9 olarak düzeltildi.
* Logo dosyalar arasına eklendi.

##### v2.0
* 5 ve üzeri depremlerde metin alanının başında flash ikonunun çıkması seçeneği eklendi.
* UTF-8 desteklemeyen ve büyük harflerle yazılmış olan yer adları, oluşturulan sistem ile büyük oranda Türkçeleştirilerek ilk harfleri büyük, devamı küçük harfle olacak hale getirildi.
* Türkçeleştirme algoritmasından kaçan yer adları için otomatik depolama listesi oluşturularak manuel düzenleme imkanı yaratıldı.

### Kaynak
Deprem verileri, [*Boğaziçi Üniversitesi Kandilli Rasathanesi ve Deprem Araştırma Enstitüsü Bölgesel Deprem-Tsunami İzleme ve Değerlendirme Merkezi*](http://www.koeri.boun.edu.tr/sismo/2/tr/)'nden alınmaktadır.

### Lisans
Uygulama, [GNU Genel Kamu Lisansı, sürüm 3](https://github.com/mertskaplan/Deprem-Bilgi-Sistemi/blob/master/LICENSE) altında yayınlandı. Ancak **ticari kullanımlarda** verilerin kaynağı olan *Boğaziçi Üniversitesi Rektörlüğü*’nün yazılı izni ve onayı alınmalıdır.

### Destek Ol

Sistemin oluşturulması için harcanan zaman ve kullanılan bilgiyi desteklemek, benzer projelerin ortaya çıkmasını sağlamak için [**Paypal ile bağış yap**](https://www.paypal.me/mertskaplan/10)abilirsin.

### İletişim
Web: [mertskaplan.com](http://mertskaplan.com) | Mail: mail@mertskaplan.com | Twitter: [@mertskaplan](https://twitter.com/mertskaplan)


#### Dipnot

1. [^](#Özelleştirme-seçenekleri) Richter ölçeğinde, sismografla kaydedilmiş zemin hareketinin mikron cinsinden ölçülen maksimum genliğinin 10 tabanına göre logaritması depremin büyüklüğü olarak tanımlanır ve 0'dan 8,9'a kadar olan rakamlarla belirtilir. Rakamlar büyüdükçe depremin büyüklüğü de logaritmik olarak artar.
2. [^](#Özelleştirme-methodu) Buğdaycı, İlhami (1999, Eylül) TÜBİTAK Bilim ve Teknik Dergisi, Sismoloji, Depremin Büyüklüğü ve Şiddeti. *Erişim Tarihi: 10 Ocak 2016* [*http://www.biltek.tubitak.gov.tr/sandik/deprem/sismoloji2.html*](http://www.biltek.tubitak.gov.tr/sandik/deprem/sismoloji2.html)