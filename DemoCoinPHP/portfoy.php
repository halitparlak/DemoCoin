<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

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
    // ... (Önceki foreach döngüsü)
} else {
    echo "'API'den veri alınamadı.'";
}

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

// Default value for $phpDegiskeni
$phpDegiskeni = 1.00;

if (isset($_POST['girdi'])) {
    $phpDegiskeni = $_POST['girdi'];
}

// Token alma
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
    <title>Portföyüm</title>
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script>
        function toggleCheckbox() {
            // Checkbox durumunu al
            var checkbox = document.getElementById('showNonZero');
            var form = document.getElementById('filterForm');

            // Checkbox durumu değiştiğinde formu otomatik olarak gönder
            checkbox.addEventListener('change', function () {
                form.submit();
            });
        }
    </script>
</head>

<body onload="toggleCheckbox();">
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <a href="logout.php" class="btn btn-outline-primary "> Logout </a>
    <a href="anasayfa.php" class="btn btn-outline-primary "> Ana Sayfa </a>
    <a class="btn btn-outline-success "><?php echo "Token Count: " . $row['token']; ?></a>
    <button class="btn btn-outline-secondary" type="button" onclick="manualRefresh()"><b>Manuel Yenileme</b></button> <p>Veriler 10 Saniyede Bir Güncellenmektedir</p>

    <form method="post" action="portfoy.php" id="filterForm">
        <label for="showNonZero">Tüm Coinleri Göster:</label>
        <input type="checkbox" name="showNonZero" id="showNonZero" <?php echo isset($_POST['showNonZero']) ? 'checked' : ''; ?>>
        <!-- <input type="submit" value="Filtrele"> -->
    </form>
    <?php


$yuklenecekMiktar = isset($_POST['miktar']) ? $_POST['miktar'] : '';

// Veriyi çek
$sql = "SELECT portfolio FROM users WHERE userid = $userID";
$result = $baglanti->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $portfolio = json_decode($row['portfolio'], true);

    if (is_array($portfolio) && count($portfolio) > 0) {
        // Tabloyu başlat
        echo '<table class="table table-striped table-light" border="1">';
        echo '<tr><th>Coin</th><th>Miktar</th><th>Güncel Piyasa Fiyatı</th><th>İşlemler</th><th>Adet</th></tr>';

        // Her bir coin için satır ekleyin
        foreach ($portfolio as $asset => $data) {
            if (!isset($data['amount'])) {
                // Eğer 'amount' değeri set edilmemişse, varsayılan bir değer atayabilir veya bu durumu başka bir şekilde ele alabilirsiniz.
                $data['amount'] = 0;
            }
            
            $amount = $data['amount'];

            // Amount değeri 0'dan büyükse tabloya ekle
            if (isset($_POST['showNonZero']) || $amount > 0) {
                $coinValueQuery = "SELECT cryptoValueUSD FROM cryptodb WHERE cryptoName='$asset'";
                $coinValueResult = mysqli_query($baglanti, $coinValueQuery);
                $coinValueRow = mysqli_fetch_assoc($coinValueResult);


                if ($coinValueRow !== null) {
                    $coinValue = $coinValueRow['cryptoValueUSD'];
                    
                    // ... rest of your code
                } else {
                    // Handle the case where $coinValueRow is null (e.g., set a default value)
                    $coinValue = 0; // You can change this to a default value or handle it as needed
                }


                //$coinValue = $coinValueRow['cryptoValueUSD'];

                echo "<form method='post' action='portfoy.php'>";
                echo '<tr>';
                echo '<td>' . $asset . '</td>';
                $coinisim = $asset;
                $coinname = $asset;
                echo '<td>' . $amount . '</td>';
                echo '<td>' . $coinValue . " $" . '</td>';
                echo '<td>' . "<button type='submit' class='btn btn-outline-success' name='buy' id='buy' value='$asset'>AL</button>" . "<button type='submit' class='btn btn-outline-danger' name='sell' id='sell' value='$asset'>SAT</button>" . '</td>';
                echo '<td>' . "<input type='text' pattern='^(0|[1-9]\d*)(\.\d+)?$' title='Sadece sıfırdan büyük sayılar girebilirsiniz.' placeholder='Alım-Satım Adedini Giriniz' class='btn btn-outline-success' name='girdi' id='girdi' required ></input>" . '</td>';
                echo '</tr>';
                echo "</form>";
            } 
        }

        // Tabloyu kapat
        echo '</table>';
    } else {
        echo 'Hatalı JSON formatı veya portföy boş';
    }
} else {
    echo "0 sonuç";
}

    if (isset($_POST["buy"])) {

        if ($phpDegiskeni>0) {

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
        $coinValueReal3 = intval($coinValueReal2) * $phpDegiskeni;
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
            echo '<script>alert(" ' . $phpDegiskeni . ' adet ' .  $coinisim . ' alımınız gerçekleşmiştir!"); </script>';
            //header("Refresh:0");
            //echo "Alim gerceklesti";
        } else {
            echo '<script>alert("Bakiyeniz ' . $phpDegiskeni . ' adet ' .  $coinisim . ' almaya yetmemektedir!"); </script>';
            //echo "Yetersiz Bakiye";
        }


        } else {
            echo '<script> alert("Alış adedine sıfır ve negatif değerler girilemez."); </script>';
        }

    }

    if (isset($_POST['sell'])) {

        if ($phpDegiskeni>0) {

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
        $coinValueReal3 = intval($coinValueReal) * $phpDegiskeni; // Coin değerini tam sayıya çevirme işlemi

        $coinAmount = null;

        $coinAmountQuery = "SELECT JSON_UNQUOTE(JSON_EXTRACT(portfolio, '$.$coinisim.amount')) AS amount
            FROM users
            WHERE userid = $userID
            AND JSON_UNQUOTE(JSON_EXTRACT(portfolio, '$.$coinisim')) IS NOT NULL";
        $coinAmountResult = mysqli_query($baglanti, $coinAmountQuery);
        $dizi = mysqli_fetch_assoc($coinAmountResult);
        $coinAmount = $dizi['amount'];

        if ($coinAmount < $phpDegiskeni) {
            echo '<script>alert("Elinizde satabileceğiniz ' . $phpDegiskeni . ' adet ' .  $coinisim . ' bulunmamaktadır!"); </script>';
            //echo 'Elinizde ' . $phpDegiskeni . ' adet satabilecek ' .  $coinisim . ' bulunmamaktadir!';
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
            echo '<script>alert(" ' . $phpDegiskeni . ' adet ' .  $coinisim . ' satışınız gerçekleşmiştir!"); </script>';
            //echo "Satış gerçekleşti";
            //header("Refresh:0"); // Bu satırı gerektiğiniz şekilde düzenleyebilirsiniz
        }


        } else {
            echo '<script> alert("Satış adedine sıfır ve negatif değerler girilemez."); </script>';
        }

    }


    $baglanti->close();
    ?>

<script src="https://cdn.botpress.cloud/webchat/v1/inject.js"></script>
	<script>
		window.botpressWebChat.init({
			"composerPlaceholder": "Chat with demo-bot",
			"botConversationDescription": "Sizlere yardımcı olabilmek için buradayım:)",
			"botId": "4cd7cf9e-53c3-44b8-9d4c-1b7a70152eab",
			"hostUrl": "https://cdn.botpress.cloud/webchat/v1",
			"messagingUrl": "https://messaging.botpress.cloud",
			"clientId": "4cd7cf9e-53c3-44b8-9d4c-1b7a70152eab",
			"webhookId": "a895508c-eb12-4c85-81af-12e291f47d03",
			"lazySocket": true,
			"themeName": "prism",
			"botName": "demo-bot",
			"avatarUrl": "https://d1muf25xaso8hp.cloudfront.net/https%3A%2F%2Fmeta-q.cdn.bubble.io%2Ff1672952221146x417310664985390140%2FChatbot.png?w=&h=&auto=compress&dpr=1&fit=max",
			"frontendVersion": "v1",
			"useSessionStorage": true,
			"enableConversationDeletion": true,
			"theme": "prism",
			"themeColor": "#2563eb"
		});
	</script>

<script>
    // Form gönderildiğinde sayfayı yenile
    document.getElementById('yourFormId').addEventListener('submit', function() {
        location.reload();
    });
</script>


<!--begin::Javascript-->
    <!--begin::Global Javascript Bundle(used by all pages)-->
    <script src="assets/plugins/global/plugins.bundle.js"></script>
    <script src="assets/js/scripts.bundle.js"></script>
    <!--end::Global Javascript Bundle-->
    <!--begin::Page Vendors Javascript(used by this page)-->
    <script src="assets/plugins/custom/fslightbox/fslightbox.bundle.js"></script>
    <script src="assets/plugins/custom/typedjs/typedjs.bundle.js"></script>
    <!--end::Page Vendors Javascript-->
    <!--begin::Page Custom Javascript(used by this page)-->
    <script src="assets/js/custom/landing.js"></script>
    <script src="assets/js/custom/pages/company/pricing.js"></script>

    <!-- Otomatik sayfa yenileme ve veritabanı güncelleme için JavaScript kodu -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        // Sayfayı belirli aralıklarla otomatik olarak yenile
        setInterval(function() {
            updateCryptoDB();
            location.reload();
        }, 10000); // 10 saniyede bir yenileme

        // Manuel yenileme butonu için JavaScript kodu
        function manualRefresh() {
            updateCryptoDB();
            location.reload();
        }

        // Cryptodb'yi güncelleme fonksiyonu
        function updateCryptoDB() {
            $.ajax({
                type: "GET",
                url: "update_crypto_db.php", // Güncelleme işlemini gerçekleştirecek PHP dosyasının adını buraya yazın
                success: function(response) {
                    console.log(response);
                },
                error: function(error) {
                    console.log("Güncelleme hatası:", error);
                }
            });
        }
    </script>



</body>

</html>