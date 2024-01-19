<?php
// Veritabanı bağlantısı
$host = "localhost";
$kullanici = "root";
$sifre = "";
$veritabani = "democoin";
$tablo = "cryptoDB";

$baglanti = mysqli_connect($host, $kullanici, $sifre, $veritabani);
if (!$baglanti) {
    die("Veritabanı bağlantısı başarısız: " . mysqli_connect_error());
}

// CoinCap API Endpoint'i ve API Anahtarı
$apiEndpoint = 'https://api.coincap.io/v2/assets';
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
        $cryptoName = mysqli_real_escape_string($baglanti, $crypto['name']);
        $cryptoValueUSD = $crypto['priceUsd'];

        // Var ise güncelleme sorgusu
        $guncellemeSorgusu = "UPDATE cryptoDB SET cryptoValueUSD = $cryptoValueUSD WHERE cryptoName = '$cryptoName'";

        // Sorguyu çalıştır ve hata kontrolü yap
        if (mysqli_query($baglanti, $guncellemeSorgusu)) {
            /* echo 'Veri başarıyla güncellendi: ' . $cryptoName . '<br>'; */
        } else {
            echo 'Hata oluştu: ' . mysqli_error($baglanti) . '<br>';
        }
    }
} else {
    echo "'API'den veri alınamadı.'";
}

mysqli_close($baglanti);
?>
