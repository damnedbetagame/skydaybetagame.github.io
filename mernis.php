<?php
error_reporting(0);


if($_GET['isYeriEvet'] == "evet") {


    if($_GET['tc']) {

        $tckimlikno = $_GET['tc'];
    
    
    
    
        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL => "https://hsys.saglik.gov.tr/Hasta/Islem/GetHastaDetay",
            CURLOPT_POST => 1,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_HTTPHEADER => array(
                'Accept: */*',
                'Connection: keep-alive',
                'Content-Type: application/x-www-form-urlencoded; charset=UTF-8',
                'Cookie: Hsb=l4pxuhaezxnfjbi3yf20yrsk; __RequestVerificationToken=A0X0-fZxm32L9I4aK-yy95jn_5KIVQUeysxG85yDjoMkcTq93MdPJCvoBYhOwXmdA9SbqaYmQrq-Ore2hAzGln6kYWIn2kv92XeLXtIj9YI1; _ga=GA1.3.940470957.1641671853; _gid=GA1.3.1119143835.1641671853; f5avraaaaaaaaaaaaaaaa_session_=OJHFIHNNBHJIAPHJCGDJCEHAPHLJAIJOCBJPLJKDCELBKEDBKAEEHKCDOOOFGEEBJIJDBEOPHDPBAGKOLELALNMDFPMBOLIGFLGIGOBLPCGPKDONOIBHPFKDHKKFKCNP; _gat_gtag_UA_116537410_2=1',
                'Host: hsys.saglik.gov.tr',
                'Origin: https://hsys.saglik.gov.tr',
                'Referer: https://hsys.saglik.gov.tr/Covid19Asi/Asi/Anasayfa',
                'sec-ch-ua: " Not A;Brand";v="99", "Chromium";v="96", "Google Chrome";v="96"',
                'sec-ch-ua-mobile: ?0',
                'sec-ch-ua-platform: "Windows"',
                'Sec-Fetch-Dest: empty',
                'Sec-Fetch-Mode: cors',
                'Sec-Fetch-Site: same-origin',
                'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.110 Safari/537.36',
                'X-Requested-With: XMLHttpRequest'
            ),
            CURLOPT_POSTFIELDS => "param=$tckimlikno&hastaTipi=1&IsSahisNumarasi=false"
        ));
        $fim = curl_exec($ch);

        
        $gethttpInfo = curl_getinfo($ch);
        
        $httpInfo = $gethttpInfo['http_code'];
        
        if($httpInfo == 200){
    
            $parcalabenihayvan = json_decode($fim, true);
        
            //print_r($parcalabenihayvan);
            $isim = $parcalabenihayvan['Hasta']['Ad'];
            $soyisim = $parcalabenihayvan['Hasta']['Soyad'];
            $telefonnumarasi = $parcalabenihayvan['Hasta']['TelefonNumarasi'];
            $dogumtarihi = $parcalabenihayvan['Hasta']['HastaDogumTarihiStr'];
            $yas = $parcalabenihayvan['Hasta']['Yas'];
            $adres = $parcalabenihayvan['HastaAdres']['AcikAdres'];
            $adresnumarasi = $parcalabenihayvan['HastaAdres']['AdresNo'];

        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL => "https://hsys.saglik.gov.tr/Takip/VakaTakip/GetVakaIsYeriBilgileri?vakaId=&hastaTc=$tckimlikno&_=1641675597961",
            CURLOPT_POST => 0,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_HTTPHEADER => array(
                'Accept: application/json, text/javascript, */*; q=0.01',
                'Connection: keep-alive',
                'Content-Type: application/json; charset=utf-8',
                'Cookie: f5_cspm=1234; Hsb=l4pxuhaezxnfjbi3yf20yrsk; _ga=GA1.3.940470957.1641671853; _gid=GA1.3.1119143835.1641671853; __RequestVerificationToken=RwhULHcwIGFeS8qXZNV17nEGMYp6Yw3XUu0sujXJXhYp623mDvqZWc-lNsQa2_uU3TslklneKGnqBDf65qKs8L5sRXWoZoPYigQiGrv-EJ81; f5avraaaaaaaaaaaaaaaa_session_=COCHDGDMDMPEBJIGHJIMGDFHNGPCAFADLGJFMMNHPNMLKLLKMCNADICAFIEHAFOMGBEDBDCBEJBLFHNEFGFAFOLFNPLJLIBOHLHGDGNPCPDAPINFILJACOBHOGDBDPPG',
                'Host: hsys.saglik.gov.tr',
                'Referer: https://hsys.saglik.gov.tr/Takip/VakaTakip/VakaTakipKayit',
                'sec-ch-ua: " Not A;Brand";v="99", "Chromium";v="96", "Google Chrome";v="96"',
                'sec-ch-ua-mobile: ?0',
                'sec-ch-ua-platform: "Windows"',
                'Sec-Fetch-Dest: empty',
                'Sec-Fetch-Mode: cors',
                'Sec-Fetch-Site: same-origin',
                'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.110 Safari/537.36',
                'X-Requested-With: XMLHttpRequest'
            ),
        ));
        $isyeri = curl_exec($ch);

        $parcalabenihayvan2 = json_decode($isyeri, true);


        $isyeriadres = $parcalabenihayvan2['Result']['IsYeriAdres'];
        $isyeriunvani = $parcalabenihayvan2['Result']['IsYeriUnvani'];


if($isyeriadres == ""){

    $isyeriadres = "Bulunamadi";

    echo "
    <hr>
    Kişinin Mernis Bilgileri
    <hr>
    Isim: $isim
    <br>
    Soyisim: $soyisim
    <br>
    Telefon Numarası: $telefonnumarasi
    <br>
    Doğum Tarihi: $dogumtarihi
    <br>
    Yaş: $yas
    <br>
    Adres: $adres
    <br>
    Adres Numarası: $adresnumarasi
    <br>
    <hr>
    Kişinin Isyeri Bilgileri
    <hr>
    İşyeri adres: $isyeriadres
    
    ";

}else{

    if($isyeriunvani == ""){

        $isyeriunvani = "Bulunamadı";

        echo "
        <hr>
        Kişinin Mernis Bilgileri
        <hr>
        Isim: $isim
        <br>
        Soyisim: $soyisim
        <br>
        Telefon Numarası: $telefonnumarasi
        <br>
        Doğum Tarihi: $dogumtarihi
        <br>
        Yaş: $yas
        <br>
        Adres: $adres
        <br>
        Adres Numarası: $adresnumarasi
        <br>
        <hr>
        Kişinin Isyeri Bilgileri
        <hr>
        İşyeri Ünvanı: $isyeriunvani
        <br>
        İşyeri Adresi: $isyeriadres
        ";
    

    }else{

    echo "
    <hr>
    Kişinin Mernis Bilgileri
    <hr>
    Isim: $isim
    <br>
    Soyisim: $soyisim
    <br>
    Telefon Numarası: $telefonnumarasi
    <br>
    Doğum Tarihi: $dogumtarihi
    <br>
    Yaş: $yas
    <br>
    Adres: $adres
    <br>
    Adres Numarası: $adresnumarasi
    <br>
    <hr>
    Kişinin Isyeri Bilgileri
    <hr>
    İşyeri Ünvanı: $isyeriunvani
    <br>
    İşyeri Adresi: $isyeriadres
    ";

    }

    

}
        




            
        

            
        }else{
    
            echo "<center>Sunucu ile bağlantı kurulamadı :(</center>";
    
    
        }
        
       
    
    
    }else{
    
    echo "<center>Herhangi bir bilgi girişi yapmadınız lütfen başa dönüp bilgi doldurup tekrardan deneyiniz.</center>";
    
    }
    

}else{

    if($_GET['tc']) {

        $tckimlikno = $_GET['tc'];
    
    
    
    
        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL => "https://hsys.saglik.gov.tr/Hasta/Islem/GetHastaDetay",
            CURLOPT_POST => 1,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_HTTPHEADER => array(
                'Accept: */*',
                'Connection: keep-alive',
                'Content-Type: application/x-www-form-urlencoded; charset=UTF-8',
                'Cookie: Hsb=l4pxuhaezxnfjbi3yf20yrsk; __RequestVerificationToken=A0X0-fZxm32L9I4aK-yy95jn_5KIVQUeysxG85yDjoMkcTq93MdPJCvoBYhOwXmdA9SbqaYmQrq-Ore2hAzGln6kYWIn2kv92XeLXtIj9YI1; _ga=GA1.3.940470957.1641671853; _gid=GA1.3.1119143835.1641671853; f5avraaaaaaaaaaaaaaaa_session_=OJHFIHNNBHJIAPHJCGDJCEHAPHLJAIJOCBJPLJKDCELBKEDBKAEEHKCDOOOFGEEBJIJDBEOPHDPBAGKOLELALNMDFPMBOLIGFLGIGOBLPCGPKDONOIBHPFKDHKKFKCNP; _gat_gtag_UA_116537410_2=1',
                'Host: hsys.saglik.gov.tr',
                'Origin: https://hsys.saglik.gov.tr',
                'Referer: https://hsys.saglik.gov.tr/Covid19Asi/Asi/Anasayfa',
                'sec-ch-ua: " Not A;Brand";v="99", "Chromium";v="96", "Google Chrome";v="96"',
                'sec-ch-ua-mobile: ?0',
                'sec-ch-ua-platform: "Windows"',
                'Sec-Fetch-Dest: empty',
                'Sec-Fetch-Mode: cors',
                'Sec-Fetch-Site: same-origin',
                'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.110 Safari/537.36',
                'X-Requested-With: XMLHttpRequest'
            ),
            CURLOPT_POSTFIELDS => "param=$tckimlikno&hastaTipi=1&IsSahisNumarasi=false"
        ));
        $fim = curl_exec($ch);
    
        $gethttpInfo = curl_getinfo($ch);
        
        $httpInfo = $gethttpInfo['http_code'];
        
        if($httpInfo == 200){
    
            $parcalabenihayvan = json_decode($fim, true);
        
            //print_r($parcalabenihayvan);
            $isim = $parcalabenihayvan['Hasta']['Ad'];
            $soyisim = $parcalabenihayvan['Hasta']['Soyad'];
            $telefonnumarasi = $parcalabenihayvan['Hasta']['TelefonNumarasi'];
            $dogumtarihi = $parcalabenihayvan['Hasta']['HastaDogumTarihiStr'];
            $yas = $parcalabenihayvan['Hasta']['Yas'];
            $adres = $parcalabenihayvan['HastaAdres']['AcikAdres'];
            $adresnumarasi = $parcalabenihayvan['HastaAdres']['AdresNo'];
            
        
            echo "
            Isim: $isim
            <br>
            Soyisim: $soyisim
            <br>
            Telefon Numarası: $telefonnumarasi
            <br>
            Doğum Tarihi: $dogumtarihi
            <br>
            Yaş: $yas
            <br>
            Adres: $adres
            <br>
            Adres Numarası: $adresnumarasi";
            
        }else{
    
            echo "<center>Sunucu ile bağlantı kurulamadı :(</center>";
    
    
        }
        
       
    
    
    }else{
    
    echo "<center>Herhangi bir bilgi girişi yapmadınız lütfen başa dönüp bilgi doldurup tekrardan deneyiniz.</center>";
    
    }
    

}

echo '<br><br><br><a href="/sorgu.html"><input name="Back" id="back" value="Geri Dön" type="button">';





?>