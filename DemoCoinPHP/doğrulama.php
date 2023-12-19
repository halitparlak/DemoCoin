<?php
require 'vendor/autoload.php';

use PragmaRX\Google2FA\Google2FA;

// Kullanıcıya ait bir benzersiz anahtar (secret key) oluştur
$secretKey = (new Google2FA())->generateSecretKey();

// Oluşturulan anahtarı ekrana yazdır
echo "Secret Key: $secretKey\n";

// QR kodu URL'ini al
$qrCodeUrl = (new Google2FA())->getQRCodeUrl(
    'DemocoinPHP',
    'halitprlk@hotmail.com',
    $secretKey
);

// QR kodu içeriğini ekrana yazdır
echo "<img src='$qrCodeUrl' alt='QR Code'>\n";
?>

