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


// Giriş yapan kullanıcının ID'sini al
$userID = $_SESSION['userid'];
$yuklenecekMiktar = null;
$yuklenecekMiktar = isset($_POST['miktar']) ? $_POST['miktar'] : '';
$yuklenecekMiktar = intval($yuklenecekMiktar);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 8px;
            font-weight: bold;
        }

        input {
            padding: 8px;
            margin-bottom: 16px;
        }

        button {
            padding: 10px;
            background-color: #007BFF;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #0056b3;
        }
    </style>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>DemoCoin - Token Yükleme</title>
    <link rel="icon" type="image/x-icon" href="favicon.ico">
</head>

<body>



    <div class="container">
        <h1>Kredi Kartı Bilgileri<br></h1>
        <form method="post" name="yukle" id="yukle">
            <label for="cardName">Kart Üstündeki İsim:</label>
            <input type="text" id="cardName" placeholder="Melih Tunahan Bağ" maxlength="30" autocomplete="off" required>

            <label for="cardNumber">Kart Numarası:</label>
            <input type="text" id="cardNumber" pattern="^\d{16}$" maxlength="16" placeholder="1234 4567 8901 2345" title="Lütfen 16 haneli bir kart numarası girin" autocomplete="off" required>

            <label for="expiryDate">Son Kullanma Tarihi:</label>
            <input type="month" id="expiryDate" placeholder="MM/YY" maxlength="5" autocomplete="off" required>

            <label for="cvv">CVV:</label>
            <input type="text" id="cvv" pattern="\d{3}" placeholder="***" title="Lütfen 3 haneli bir CVV girin" maxlength="3" autocomplete="off" required>


            <label for="cvv">Yüklenecek Miktar:</label>
            <input type="number" min="1" id="miktar" name="miktar" class="miktar" placeholder="Yüklenecek tutarı giriniz." required>

            <button  type="submit">Yükle</button>
            <button  href="anasayfa.php">Ana Sayfa</button>
            
            <a href="anasayfa.php" class="btn btn-outline-primary "> Ana Sayfa </a>


        </form>
        <?php
        if (isset($_POST['miktar'])) {

            if ($_POST['miktar'] <= 0) {

                echo "<h1 class='button'>Minimum token yükleme miktarı 0'dan büyük olmalı!</h1>";
            } else {

                $tokenCek = "SELECT token FROM users WHERE userid = $userID";
                $tokenCache = mysqli_query($baglanti, $tokenCek);

                if ($tokenCache) {
                    $row = mysqli_fetch_assoc($tokenCache);
                    $mevcutToken = intval($row['token']); // Değeri int'e dönüştür

                    // Yeni token değerini hesapla
                    $tokenYeni = $mevcutToken + $yuklenecekMiktar;

                    // Token değerini güncelle
                    $tokenGuncelle = "UPDATE users SET token = $tokenYeni WHERE userid = $userID";
                    $result = mysqli_query($baglanti, $tokenGuncelle);

                    if ($result) {
                        echo "<h1 class='button'>Token yükleme başarılı!</h1>";
                    } else {
                        echo "Token güncelleme hatası: " . mysqli_error($baglanti);
                    }
                    
                } else {
                    echo "Token çekme hatası: " . mysqli_error($baglanti);
                }
            }
        }


        ?>
    </div>


    <div class="container">
        <h1>Bitcoin Ile Yukleme Yap<br></h1>
        <form method="post" name="yukle" id="yukle">
            <label for="cardName">DemoCoin BTC Cüzdan Adresi</label>
            <input type="text" id="cardName" value="1FfmbHfnpaZjKFvyi1okTjJJusN455paPH" placeholder="1FfmbHfnpaZjKFvyi1okTjJJusN455paPH" maxlength="34" autocomplete="off" required>


            <label for="cvv">Açıklamaya Yazılacak Sayı </label>
            <input type="text" id="cardName" value="<?php echo $userID ?>" placeholder="<?php echo $userID ?>" maxlength="34" autocomplete="off" required>

            <label for="cvv">Gönderdiğiniz Miktar:</label>
            <input type="number" min="1" id="miktar" name="miktar" class="miktar" placeholder="Gönderdiğiniz Miktar:" required>

            <div>

            <input type="checkbox" id="sacheckbox" label="Belirtilen adrese gönderdim." placeholder="asd" value="Belirtilen adrese gönderdim." required>
            <label for="sacheckbox">Belirtilen adrese gönderdim.</label>
            </div>

            <button  type="submit">Bakiye aktar.</button>
            <button  href="anasayfa.php">Ana Sayfa</button>
            
            <a href="anasayfa.php" class="btn btn-outline-primary "> Ana Sayfa </a>


        </form>
        <?php
        if (isset($_POST['miktar'])) {

            if ($_POST['miktar'] <= 0) {

                echo "<h1 class='button'>Minimum token yükleme miktarı 0'dan büyük olmalı!</h1>";
            } else {

                $tokenCek = "SELECT token FROM users WHERE userid = $userID";
                $tokenCache = mysqli_query($baglanti, $tokenCek);

                if ($tokenCache) {
                    $row = mysqli_fetch_assoc($tokenCache);
                    $mevcutToken = intval($row['token']); // Değeri int'e dönüştür

                    // Yeni token değerini hesapla
                    $tokenYeni = $mevcutToken + $yuklenecekMiktar*42980;

                    // Token değerini güncelle
                    $tokenGuncelle = "UPDATE users SET token = $tokenYeni WHERE userid = $userID";
                    $result = mysqli_query($baglanti, $tokenGuncelle);

                    if ($result) {
                        echo "<h1 class='button'>Token yükleme başarılı!</h1>";
                    } else {
                        echo "Token güncelleme hatası: " . mysqli_error($baglanti);
                    }
                } else {
                    echo "Token çekme hatası: " . mysqli_error($baglanti);
                }
            }
        }

        //$baglanti->close();
        ?>
    </div>

</body>

</html>