<?php
session_start();
/* include 'database.php'; */

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



/* 
    $tokenCek = "SELECT token FROM users WHERE userid = $userID";
    $tokenCache = mysqli_query($baglanti, $tokenCek);
    $tokenYeni = $tokenCache + $yuklenecekMiktar;
    $tokenGonder = "UPDATE token FROM users WHERE userid = $userID";
    $tokenGuncelle = mysqli_query($baglanti, $tokenGonder); */




//LISTBOX JSON OKUMA
/* // Veriyi çek JSON OKUMA
$sql = "SELECT portfolio FROM users WHERE userid = $userID";
$result = $baglanti->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $portfolio = json_decode($row['portfolio'], true);

    if (is_array($portfolio)) {
        echo '<select>';
        foreach ($portfolio as $asset => $data) {
            $amount = $data['amount'];
            echo '<option value="' . $asset . '">' . $asset . ' (' . $amount . ')</option>';
        }
        echo '</select>';
    } else {
        echo 'Hatalı JSON formatı';
    }
} else {
    echo "0 results";
}

$baglanti->close(); */

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
    <title>DemoCoin - Para Çek</title>
    <link rel="icon" type="image/x-icon" href="favicon.ico">
</head>

<body>



    <div class="container">
        <h1>Gönderilecek Hesap Bilgileri<br></h1>
        <form method="post" name="yukle" id="yukle">
            <label for="cardNumber">İBAN Numarası:</label>
            <input type="text" id="cardNumber" pattern="^TR\d{24}$" title="TR ile başlayan ve ardından boşluk olmadan 24 adet rakam içeren bir değer giriniz." placeholder="TR53 0011 1000 0000 0103 5143 65" maxlength="26" required>

            <label for="expiryDate">Alıcı İsim Soyisim:</label>
            <input type="text" pattern="[a-zA-ZğüşıöçĞÜŞİÖÇ]+" title="Lütfen sadece harf giriniz." id="expiryDate" placeholder="Melih Tunahan Bağ" maxlength="30" required>

            <label for="cvv">Hesaba Gönderilecek Tutar</label>
            <input type="number" id="miktar" name="miktar" class="miktar" placeholder="Gönderilecek tutarı giriniz." required>

            <button type="submit">Gönder</button>
            <a href="logout.php" class="btn btn-outline-primary "> Logout </a>
            <a href="anasayfa.php" class="btn btn-outline-primary "> Ana Sayfa </a>


        </form>
        <?php
        if (isset($_POST['miktar'])) {

            if ($_POST['miktar'] <= 0) {

                echo "<h1 class='button'>Minimum gönderilecek miktar 0'dan büyük olmalı!</h1>";
            } else {

                $tokenCek = "SELECT token FROM users WHERE userid = $userID";
                $tokenCache = mysqli_query($baglanti, $tokenCek);

                if ($tokenCache) {
                    $row = mysqli_fetch_assoc($tokenCache);
                    $mevcutToken = intval($row['token']); // Değeri int'e dönüştür

                    if($mevcutToken<$_POST['miktar']) {
                        echo "Hesabınızda bulunan bakiyeden fazla bakiye gönderemezsiniz.";
                    } else {

                                            // Yeni token değerini hesapla
                    $tokenYeni = $mevcutToken -  $yuklenecekMiktar;

                    // Token değerini güncelle
                    $tokenGuncelle = "UPDATE users SET token = $tokenYeni WHERE userid = $userID";
                    $result = mysqli_query($baglanti, $tokenGuncelle);

                    if ($result) {
                        echo "<h1 class='button'>Hesaba para aktarma başarılı!</h1>";
                    } else {
                        echo "Para aktarım hatası: " . mysqli_error($baglanti);
                    }

                    }


                } else {
                    echo "Para gönderme hatası: " . mysqli_error($baglanti);
                }
            }
        }

        $baglanti->close();
        ?>
    </div>

</body>

</html>