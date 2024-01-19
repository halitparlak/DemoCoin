<?php
session_start();

// Veritabanı bağlantısı
$host = "localhost";
$kullanici = "root";
$sifre = "";
$veritabani = "democoin";
$tablo = "users";

$baglanti = mysqli_connect($host, $kullanici, $sifre, $veritabani);
if (!$baglanti) {
    die("Veritabanı bağlantısı başarısız: " . mysqli_connect_error());
}

if (isset($_SESSION['userid'])) {
    $user_id = $_SESSION['userid'];
    // Kullanıcı ID'sini kullanarak istediğiniz işlemleri gerçekleştirin
} else {
    // Kullanıcı oturumu yoksa, giriş sayfasına yönlendirin veya başka bir işlem yapın
    header("Location: giris.php");
    exit();
}
$userID = $_SESSION['userid'];

$alisAdet = 1.00;
$satisAdet = 1.00;
if	(isset($_POST['girdi'])) {
	
	$phpDegiskeni = $_POST['girdi'];
	
} else {
	$phpDegiskeni = 1.00;
}

//token alma
$tokenCountQuery = "SELECT token FROM users WHERE userid = $userID";
$tokenResult = mysqli_query($baglanti, $tokenCountQuery);
$row = mysqli_fetch_assoc($tokenResult);
$tokenCount = $row['token'];






?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anasayfa</title>
</head>

<body>
    <a href="logout.php" class="btn btn-outline-primary "> Logout </a>
    <a href="anasayfa.php" class="btn btn-outline-primary "> Ana Sayfa </a>
    <?php


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
            echo '<tr><th>Coin</th><th>Miktar</th><th>Al</th><th>Sat</th></tr>';

            // Her bir coin için satır ekleyin
            foreach ($portfolio as $asset => $data) {
                $amount = $data['amount'];

                // Amount değeri 0'dan büyükse tabloya ekle
                if ($amount > 0) {
                    echo "<form method='post' action='portfoy.php'>";
                    echo '<tr>';
                    echo '<td>' . $asset . '</td>';
                    $coinisim = $asset;
                    $coinname = $asset;
                    echo '<td>' . $amount . '</td>';

                    echo '<td>' . "<button type='submit' class='btn btn-outline-success' name='buy' id='buy' value='$asset'>AL</button>" . '</td>';
                    echo '<td>' . "<button type='submit' class='btn btn-outline-success' name='sell' id='sell' value='$asset'>SAT</button>" . '</td>';
                    echo '<td>' . "<input type='double' placeholder='Alim Satim Adedini Giriniz' class='btn btn-outline-success' name='girdi' id='girdi' required></input>" . '</td>';


                    echo '</tr>';
                    echo "</form>";
                    



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

    if (isset($_POST["buy"])) {
        // POST verilerini al
/*         $coinisim = $asset;
        $coinname = $asset; */

        $coinisim = $_POST["buy"];
        $coinname = $_POST["buy"];

        /* echo $coinValue; */


        $host = "localhost";
        $kullanici = "root";
        $sifre = "";
        $veritabani = "democoin";
        $tablo = "cryptoDB";
    
        $baglanti = mysqli_connect($host, $kullanici, $sifre, $veritabani);
        if (!$baglanti) {
            die("Veritabanı bağlantısı başarısız: " . mysqli_connect_error());
        }
        $coinValueQuery = "SELECT cryptoValueUSD FROM cryptodb WHERE cryptoName='$coinisim'";
        $coinValue = mysqli_query($baglanti, $coinValueQuery);
        $row = mysqli_fetch_assoc($coinValue);
        $coinValueReal = $row['cryptoValueUSD'];
        /* echo $coinValueReal; */
        $coinValueReal2 = (float) ($coinValueReal);
        /* echo $coinValueReal2; */
        $coinValueReal3 = intval($coinValueReal2)*$phpDegiskeni;
        /* echo $coinValueReal3; */
        if ($tokenCount >= $coinValueReal3) {
            $newTokenCount = $tokenCount - $coinValueReal3;
            
            $host = "localhost";
            $kullanici = "root";
            $sifre = "";
            $veritabani = "democoin";
            $tablo = "users";
    
            $newTokenCountQuery = "UPDATE users SET token=$newTokenCount WHERE userid='$userID'";
            $newTokenKaydet = mysqli_query($baglanti, $newTokenCountQuery);
            $jsonKayit = "UPDATE users
        SET portfolio = JSON_SET(
            COALESCE(portfolio, '{}'), -- Eğer portföy null ise yeni bir JSON_OBJECT() oluştur
            '$.$coinisim.amount', COALESCE(CAST(JSON_UNQUOTE(JSON_EXTRACT(portfolio, '$.$coinisim.amount')) AS DECIMAL(10,2)), 0) + $phpDegiskeni -- Eğer BTC.amount null ise 0'a ekle
        )
        WHERE userid = $userID";
            $jsonKaydet = mysqli_query($baglanti, $jsonKayit);
            header("Refresh:0");
            echo "Alim gerceklesti";
        } else {
            echo "Yetersiz Bakiye";
        }
    
    
    }

    if (isset($_POST['sell'])) {
 /*        $coinisim = $asset;
        $coinname = $asset; */

        $coinisim = $_POST["sell"];
        $coinname = $_POST["sell"];
    
        $host = "localhost";
        $kullanici = "root";
        $sifre = "";
        $veritabani = "democoin";
        $tablo = "cryptoDB";
    
        $baglanti = mysqli_connect($host, $kullanici, $sifre, $veritabani);
        if (!$baglanti) {
            die("Veritabanı bağlantısı başarısız: " . mysqli_connect_error());
        }
    
        $coinValueQuery = "SELECT cryptoValueUSD FROM cryptodb WHERE cryptoName='$coinisim'";
        $coinValue = mysqli_query($baglanti, $coinValueQuery);
        $row = mysqli_fetch_assoc($coinValue);
        $coinValueReal = $row['cryptoValueUSD'];
        $coinValueReal3 = intval($coinValueReal)*$phpDegiskeni; // Coin değerini tam sayıya çevirme işlemi
    
        $coinAmount = null;
    
        $coinAmountQuery = "SELECT JSON_UNQUOTE(JSON_EXTRACT(portfolio, '$.$coinisim.amount')) AS amount
            FROM users
            WHERE userid = $userID
            AND JSON_UNQUOTE(JSON_EXTRACT(portfolio, '$.$coinisim')) IS NOT NULL";
        $coinAmountResult = mysqli_query($baglanti, $coinAmountQuery);
        $dizi = mysqli_fetch_assoc($coinAmountResult);
        $coinAmount = $dizi['amount'];
    
        if ($coinAmount < $phpDegiskeni) {
            echo 'Elinizde ' . $phpDegiskeni . ' adet satabilecek ' .  $coinisim . ' bulunmamaktadir!';
        } else {
            // Satış işlemi sırasında kullanılacak yeni adet hesaplanıyor
            $newAmount = $coinAmount - $phpDegiskeni;
    
            $jsonKayit = "UPDATE users
                SET portfolio = JSON_SET(
                    COALESCE(portfolio, '{}'),
                    '$.$coinisim.amount',
                    COALESCE(CAST(JSON_UNQUOTE(JSON_EXTRACT(portfolio, '$.$coinisim.amount')) AS DECIMAL(10,2)), 0) - $phpDegiskeni
                )
                WHERE userid = $userID";
            $jsonKaydet = mysqli_query($baglanti, $jsonKayit);
    
            // Kullanıcının yeni toplam token sayısı hesaplanıyor
            $newTokenCount = $tokenCount + ($coinValueReal3 * $phpDegiskeni);
    
            $newTokenCountQuery = "UPDATE users SET token=$newTokenCount WHERE userid='$userID'";
            $newTokenKaydet = mysqli_query($baglanti, $newTokenCountQuery);
    
            echo "Satış gerçekleşti";
            header("Refresh:0"); // Bu satırı gerektiğiniz şekilde düzenleyebilirsiniz
        }
    }


    $baglanti->close();
    ?>

</body>

</html>