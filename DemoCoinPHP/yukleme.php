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
    <title>Kredi Kartı Bilgileri Girişi</title>
</head>
<body>

    <div class="container">
        <h1>Kredi Kartı Bilgileri<br><?php echo $userID ?></h1>
        <form method="post" name="yukle" id="yukle">
            <label for="cardNumber">Kart Numarası:</label>
            <input type="number" id="cardNumber" placeholder="**** **** **** ****" maxlength="16" required>
            
            <label for="expiryDate">Son Kullanma Tarihi:</label>
            <input type="text" id="expiryDate" placeholder="MM/YY" maxlength="5" required>
            
            <label for="cvv">CVV:</label>
            <input type="password" id="cvv" placeholder="***" maxlength="3" required>

            <label for="cvv">Yüklenecek Miktar:</label>
            <input type="number" id="miktar" name="miktar" class="miktar" placeholder="Yüklenecek tutarı giriniz." required>

            <button type="submit" >Yükle</button>

            
        </form>
        <?php 
        if (isset($_POST['miktar'])) {

            if ($_POST['miktar']<=0) {

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
            
            $baglanti->close();
        ?>
    </div>

</body>
</html>
