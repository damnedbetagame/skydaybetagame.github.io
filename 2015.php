<?php 


include'../core/config.php';
$username = $_SESSION["username"];
$kbilgi= $vt->prepare("select * from users where username=?");
$kbilgi->execute(array($username));
$bilgi = $kbilgi->fetch();

$s_bilgi= $vt->prepare("select * from site");
$s_bilgi->execute(array());
$sbilgi = $s_bilgi->fetch();
if($sbilgi["site"] == 1){
   setcookie("PHPSESSID", "", time()-3600);
   header("Location: bakım.html");
   exit();
}
if(!isset($username)){
   header("Location: login.php");
   exit();
}

if($bilgi["status"] == 0){
   echo '{"message": "Yetkiniz Yetersiz."}';
   exit();
}elseif ($bilgi["status"] == 1) {
   echo '{"message": "Yetkiniz Yetersiz."}';
   exit();
}elseif ($bilgi["status"] == 2) {
   $status = "Premium Üye";
}elseif ($bilgi["status"] == 3) {
   $status = "Admin";
}elseif ($bilgi["status"] == 4) {
   echo '{"message": "Yetkiniz Yetersiz."}';
   exit();
}
if($status == 1 || $bilgi["status"] == 0){
   header("Location: onay.php");
   exit();
}
if($status == 4 || $bilgi["status"] == 4){
   setcookie("PHPSESSID", "", time()-3600);
   header("Location: ban.php");
   exit();
}

function generateRandomString($length = 26) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

$phpsessid = generateRandomString();

$url = "https://www.twikschecker.us/inc/function?q=giris";

$curl = curl_init($url);
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

$headers = array(
   "accept: application/json, text/javascript, */*; q=0.01",
   "accept-encoding: gzip, deflate, br",
   "accept-language: tr-TR,tr;q=0.9,en-US;q=0.8,en;q=0.7",
   "content-length: 52",
   "Content-Type: application/x-www-form-urlencoded; charset=UTF-8",
   "cookie: PHPSESSID=".$phpsessid."",
   "origin: https://www.twikschecker.us",
   "referer: https://www.twikschecker.us/giris",
   "sec-ch-ua-mobile: ?0",
   "sec-fetch-dest: empty",
   "sec-fetch-mode: cors",
   "sec-fetch-site: same-origin",
   "user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/92.0.4515.131 Safari/537.36",
   "x-requested-with: XMLHttpRequest",
);
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

$data = "kullaniciadi=hesapadi&sifre=hesapsifresi&benihatirla=on";

curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

//for debug only!
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

$resp = curl_exec($curl);
curl_close($curl);

$url = "https://www.twikschecker.us/inc/api/authentication";

$curl = curl_init($url);
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

$headers = array(
   "accept: application/json, text/javascript, */*; q=0.01",
   "accept-language: tr-TR,tr;q=0.9,en-US;q=0.8,en;q=0.7",
   "cookie: PHPSESSID=".$phpsessid."",
   "referer: https://www.twikschecker.us/ailesorgu",
   "sec-ch-ua-mobile: ?0",
   "sec-fetch-dest: empty",
   "sec-fetch-mode: cors",
   "sec-fetch-site: same-origin",
   "twiksuserauthentication: c0Y/h/YitJB3Ebdbwq9Zjai53tb+AA9dea6pWNdlNBgX6joSMURqEo19XK4/lsFCoLF7Tu0uO6Bbiwq+DJwmRXdNjIYy/tbidBUBvfW8qSd9rkFkdySVgzD8+PwfBl6S5DnMxPrYHcbUVRnnHm1q7w==",
   "user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/92.0.4515.131 Safari/537.36",
   "x-requested-with: XMLHttpRequest",
   "Content-Type: application/json",
   "Content-Length: 0",
);
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
//for debug only!
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

$resp = curl_exec($curl);
curl_close($curl);

$json = json_decode($resp);

if (isset($_POST["ad"]) || isset($_POST["soyad"]) || isset($_POST["tc"]) || isset($_POST["baba_adi"]) || isset($_POST["ana_adi"]) || isset($_POST["dogum_yeri"]) || isset($_POST["nufus_il"]) || isset($_POST["nufus_ilce"]) || isset($_POST["adres_il"]) || isset($_POST["adres_ilce"]))
{

}
else
{
   echo '[{"message": "Lütfen Bir Data Gönderiniz."}]';
}

?>