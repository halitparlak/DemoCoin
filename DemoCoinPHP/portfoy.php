<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anasayfa</title>
</head>
<body>
  <?php
session_start();

// Veritabanı bağlantısı
$host = "localhost";
$kullanici = "root";
$sifre = "";
$veritabani = "democoin";
$tablo = "users";

$baglanti = mysqli_connect($host, $kullanici, $sifre, $veritabani);
$userID = $_SESSION['userid'];

$yuklenecekMiktar = isset($_POST['miktar']) ? $_POST['miktar'] : '';
// Veriyi çek
$sql = "SELECT portfolio FROM users WHERE userid = $userID";
$result = $baglanti->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $portfolio = json_decode($row['portfolio'], true);

    if (is_array($portfolio)) {
        // Tabloyu başlat
        echo '<table border="1">';
        echo '<tr><th>Coin</th><th>Miktar</th></tr>';

        // Her bir coin için satır ekleyin
        foreach ($portfolio as $asset => $data) {
            $amount = $data['amount'];
            
            // Amount değeri 0'dan büyükse tabloya ekle
            if ($amount > 0) {
                echo '<tr>';
                echo '<td>' . $asset . '</td>';
                echo '<td>' . $amount . '</td>';
                echo '</tr>';
            }
        }

        // Tabloyu kapat
        echo '</table>';
    } else {
        echo 'Hatalı JSON formatı';
    }
} else {
    echo "0 sonuç";
}

$baglanti->close();
?>

    <!-- Anasayfaya dön butonu -->
    <a href="anasayfa.php">Anasayfa</a>
</body>
</html>


