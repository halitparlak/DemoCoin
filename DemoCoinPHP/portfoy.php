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
</body>

</html>