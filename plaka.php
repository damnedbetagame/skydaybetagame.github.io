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
   header("Location: ../bakım.html");
   exit();
}
if(!isset($username)){
   header("Location: ../login.php");
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

function rnd($length = 2) {
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
function millitime() {
  $microtime = microtime();
  $comps = explode(' ', $microtime);

  return sprintf('%d%03d', $comps[1], $comps[0] * 1000);
}
$date = new DateTime();
$uKey = millitime() + "9874563210741852".rnd();

if (isset($_GET["plaka"]))
{
   $plaka = $_GET["plaka"];
   $url = "https://sat2.aksigorta.com.tr/web-api/tramer-egm-sorgu/sorgula";

$curl = curl_init($url);
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_PROXY, "94.102.6.39:3310");
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

$headers = array(
   "Accept: application/json, text/plain, */*",
   "Content-Type: application/json",
 "Cookie: NSC_blqpsu_IUUQT=0933a3df2bee13101467425c185ec9d6932b3b1722b338155f7cb0d560c317da4db5448a; cookiesession1=678B2895TUV01234567898901234E5AB; NSC_blqpsu_dpsf_IUUQT=4037a3fc5d108d4bda55a5e28c2066d376135d51489137d97aec44276421738ce7480cf6; JSESSIONID=rs1Q5_ti4gV-5oPgk_glFeU29-O4iKKBbq6bm1eFUpgnV4O-2BBP!-888850824;",
   "uKey: ".rnd().$uKey."", 
   "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:90.0) Gecko/20100101 Firefox/90.0",
);
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

$data = '{"plaka":"'.$plaka.'","tescilBelgeNo":""}';

curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

//for debug only!
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

$resp = curl_exec($curl);
curl_close($curl);
print_r($resp);
}
else
{
   echo '{"message": "Lütfen Bir Data Gönderiniz."}';
}

?>