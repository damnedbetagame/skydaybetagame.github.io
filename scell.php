<?php


if (isset($_POST['tc']))
{
$tc = $_POST['tc'];
 $ch = curl_init();
    curl_setopt_array($ch, array(
    CURLOPT_URL => "https://www.sigortacell.com/anasayfa",
    CURLOPT_FOLLOWLOCATION => 1,
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_POST => 0,
    CURLOPT_HTTPHEADER => array(
        'accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9',
        'cache-control: max-age=0',
        'sec-ch-ua: "Opera GX";v="77", "Chromium";v="91", ";Not A Brand";v="99"',
        'sec-ch-ua-mobile: ?0',
        'sec-fetch-dest: document',
        'sec-fetch-mode: navigate',
        'sec-fetch-site: none',
        'sec-fetch-user: ?1',
        'upgrade-insecure-requests: 1',
        'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.164 Safari/537.36 OPR/77.0.4054.275'
    ),
    CURLOPT_COOKIEJAR => getcwd().'/anan.txt',
    CURLOPT_COOKIEFILE => getcwd().'/anan.txt'
    ));
    $fim = curl_exec($ch);


$yarrak = explode('name="csrf-token" content="', $fim);
$yarrak = explode('"', $yarrak[1]);



$csrf = $yarrak[0];

$url = "https://www.sigortacell.com/api/provider/inquiryId";

$curl = curl_init($url);
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_ENCODING , "gzip");
$headers = array(
   "accept: application/json, text/plain, */*",
   "accept-language: tr-TR,tr;q=0.9,en-US;q=0.8,en;q=0.7",
   "content-length: 24",
   "Content-Type: application/json",
   "origin: https://www.sigortacell.com",
   "referer: https://www.sigortacell.com/anasayfa",
   'sec-ch-ua: "Chromium";v="92", " Not A;Brand";v="99", "Google Chrome";v="92"',
   "sec-ch-ua-mobile: ?0",
   "sec-fetch-dest: empty",
   "sec-fetch-mode: cors",
   "sec-fetch-site: same-origin",
   "user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/92.0.4515.107 Safari/537.36",
   'x-csrf-token: '.$csrf.'',
   "x-requested-with: XMLHttpRequest",
   "x-socket-id: fXIX0eDOV4xvvv9mAACv",
);
curl_setopt($curl, CURLOPT_COOKIEJAR, getcwd().'/anan.txt');
curl_setopt($curl, CURLOPT_COOKIEFILE, getcwd().'/anan.txt');

curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

$data = '{"tcKimlik":'.$tc.'}';

curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

$resp = curl_exec($curl);
$json = json_decode($resp);
curl_close($curl);

print_r($resp);

}
else
{
   echo '[
{"message": "Lütfen Bir Data Gönderiniz."}
]';
}


?>