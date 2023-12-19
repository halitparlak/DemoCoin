<?php

// CoinCap API Endpoint'i
$apiEndpoint = 'https://api.coincap.io/v2/assets';

// API Anahtarınız
$apiKey = '0d031cac-8cb5-4e18-ad20-9bad23e57bdd';

// cURL ile API'ye istek gönderme
$ch = curl_init($apiEndpoint . '?apiKey=' . $apiKey);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);

// cURL hata kontrolü
if (curl_errno($ch)) {
    echo 'cURL Hatası: ' . curl_error($ch);
}

curl_close($ch);

// JSON verisini PHP dizisine çevirme
$data = json_decode($response, true);

// Veriyi işleme
if ($data && isset($data['data'])) {
    foreach ($data['data'] as $crypto) {
        echo 'Coin: ' . $crypto['name'] . ', Fiyat: ' . $crypto['priceUsd'] . ' USD' . $crypto['changePercent24Hr']. '%' . PHP_EOL ;
        echo "<br>";
    }
} else {
    echo "'API'den veri alınamadı.'";
}

?>
