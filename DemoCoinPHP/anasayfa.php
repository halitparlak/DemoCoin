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

// POST edilen veriyi al


$alisAdet = 1.00;
$satisAdet = 1.00;
if (isset($_POST['girdi'])) {

	$phpDegiskeni = $_POST['girdi'];
} else {
	$phpDegiskeni = 1.00;
}



//token alma
$tokenCountQuery = "SELECT token FROM users WHERE userid = $userID";
$tokenResult = mysqli_query($baglanti, $tokenCountQuery);
$row = mysqli_fetch_assoc($tokenResult);
$tokenCount = $row['token'];

//isim alma
$nameQuery = "SELECT isim FROM users WHERE userid = $userID";
$nameResults = mysqli_query($baglanti, $nameQuery);
$name = mysqli_fetch_assoc($nameResults);

//soyisim alma
$surnameQuery = "SELECT soyisim FROM users WHERE userid = $userID";
$surnameResults = mysqli_query($baglanti, $surnameQuery);
$surname = mysqli_fetch_assoc($surnameResults);

if (isset($_POST['sell'])) {

	if ($phpDegiskeni > 0) {

		//$phpDegiskeni = $_POST['girdi'];

		$coinName = $_POST['coinname'];
		$coinisim = $_POST['coinname'];
		$coinValue = $_POST['coinvalue'];
		$coinValue2 = (float) str_replace(',', '', $coinValue);
		/* echo $coinValue2; */
		$coinValue3 = intval($coinValue2) * $phpDegiskeni;
		/* echo $coinValue3; */

		$coinAmount = null;

		$coinAmountQuery = "SELECT JSON_UNQUOTE(JSON_EXTRACT(portfolio, '$.$coinisim.amount')) AS amount
	FROM users
	WHERE userid = $userID
	AND JSON_UNQUOTE(JSON_EXTRACT(portfolio, '$.$coinisim')) IS NOT NULL";
		$coinAmountResult = mysqli_query($baglanti, $coinAmountQuery);
		$dizi = mysqli_fetch_assoc($coinAmountResult);
		$coinAmount = $dizi['amount'];

		if ($coinAmount < $phpDegiskeni) {

			echo '<script>alert("Elinizde ' . $phpDegiskeni . ' adet satabilecek ' .  $coinisim . ' bulunmamaktadir!"); </script>';
		} else {

			$newTokenCount = $tokenCount + $coinValue3;
			$newTokenCountQuery = "UPDATE users SET token=$newTokenCount WHERE userid='$userID'";
			$newTokenKaydet = mysqli_query($baglanti, $newTokenCountQuery);
			$jsonKayit = "UPDATE users
	SET portfolio = JSON_SET(
		COALESCE(portfolio, '{}'), -- Eğer portföy null ise yeni bir JSON_OBJECT() oluştur
		'$.$coinisim.amount', COALESCE(CAST(JSON_UNQUOTE(JSON_EXTRACT(portfolio, '$.$coinisim.amount')) AS DECIMAL(10,2)), 0) - '$phpDegiskeni' -- Eğer BTC.amount null ise 0'a ekle
	)
	WHERE userid = $userID";
			$jsonKaydet = mysqli_query($baglanti, $jsonKayit);
			echo '<script>alert(" ' . $phpDegiskeni . ' adet ' .  $coinisim . ' satışınız gerçekleşmiştir!"); </script>';
			header("Refresh:0");
		}
	} else {
		echo '<script> alert("Satış adedine sıfır ve negatif değerler girilemez."); </script>';
	}
}

if (isset($_POST["buy"])) {

	if ($phpDegiskeni > 0) {


		//$phpDegiskeni = $_POST['girdi'];
		// POST verilerini al
		$coinName = $_POST['coinname'];
		$coinisim = $_POST['coinname'];
		$coinValue = $_POST['coinvalue'];
		/* echo $coinValue; */
		$coinValue2 = (float) str_replace(',', '', $coinValue);
		/* echo $coinValue2; */
		$coinValue3 = intval($coinValue2) * $phpDegiskeni; //aldigi adet kadar dusup yukseltmek icin
		/* echo $coinValue3; */
		if ($tokenCount >= $coinValue3) {
			$newTokenCount = $tokenCount - $coinValue3;
			$newTokenCountQuery = "UPDATE users SET token=$newTokenCount WHERE userid='$userID'";
			$newTokenKaydet = mysqli_query($baglanti, $newTokenCountQuery);
			$jsonKayit = "UPDATE users
	SET portfolio = JSON_SET(
		COALESCE(portfolio, '{}'), -- Eğer portföy null ise yeni bir JSON_OBJECT() oluştur
		'$.$coinisim.amount', COALESCE(CAST(JSON_UNQUOTE(JSON_EXTRACT(portfolio, '$.$coinisim.amount')) AS DECIMAL(10,2)), 0) + '$phpDegiskeni' -- Eğer BTC.amount null ise 0'a ekle
	)
	WHERE userid = $userID";
			$jsonKaydet = mysqli_query($baglanti, $jsonKayit);
			//header("Refresh:0");
			echo '<script>alert(" ' . $phpDegiskeni . ' adet ' .  $coinisim . ' alımınız gerçekleşmiştir!"); </script>';
		} else {

			echo '<script>alert("Bakiyeniz ' . $phpDegiskeni . ' adet ' .  $coinisim . ' almaya yetmemektedir!"); </script>';
		}
	}
}




mysqli_close($baglanti);
?>
<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->

<head>
	<base href="">
	<title>DemoCoin</title>
	<link rel="icon" type="image/x-icon" href="favicon.ico">
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta charset="utf-8" />
	<meta property="og:locale" content="en_US" />
	<meta property="og:type" content="article" />
	<meta property="og:title" content="Metronic - Bootstrap 5 HTML, VueJS, React, Angular &amp; Laravel Admin Dashboard Theme" />
	<meta property="og:url" content="https://keenthemes.com/metronic" />
	<meta property="og:site_name" content="Keenthemes | Metronic" />
	<link rel="canonical" href="https://preview.keenthemes.com/metronic8" />
	<link rel="shortcut icon" href="" />
	<!--begin::Fonts-->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
	<!--end::Fonts-->
	<!--begin::Global Stylesheets Bundle(used by all pages)-->
	<link href="assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
	<link href="assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
	<!--end::Global Stylesheets Bundle-->
</head>
<!--end::Head-->
<!--begin::Body-->

<body id="kt_body" data-bs-spy="scroll" data-bs-target="#kt_landing_menu" data-bs-offset="200" class="bg-white position-relative">
	<!--begin::Main-->
	<div class="d-flex flex-column flex-root">
		<!--begin::Header Section-->
		<div class="mb-0" id="home">
			<!--begin::Wrapper-->
			<div class="bgi-no-repeat bgi-size-contain bgi-position-x-center bgi-position-y-bottom ">
				<!--begin::Header-->
				<div class="landing-header" data-kt-sticky="true" data-kt-sticky-name="landing-header" data-kt-sticky-offset="{default: '200px', lg: '300px'}">
					<!--begin::Container-->
					<div class="container">
						<!--begin::Wrapper-->
						<div class="d-flex align-items-center justify-content-between">
							<!--begin::Logo-->
							<div class="d-flex align-items-center flex-equal">
								<!--begin::Mobile menu toggle-->
								<button class="btn btn-icon btn-active-color-primary me-3 d-flex d-lg-none" id="kt_landing_menu_toggle">
									<!--begin::Svg Icon | path: icons/duotune/abstract/abs015.svg-->
									<span class="svg-icon svg-icon-2hx">
										<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
											<path d="M21 7H3C2.4 7 2 6.6 2 6V4C2 3.4 2.4 3 3 3H21C21.6 3 22 3.4 22 4V6C22 6.6 21.6 7 21 7Z" fill="black" />
											<path opacity="0.3" d="M21 14H3C2.4 14 2 13.6 2 13V11C2 10.4 2.4 10 3 10H21C21.6 10 22 10.4 22 11V13C22 13.6 21.6 14 21 14ZM22 20V18C22 17.4 21.6 17 21 17H3C2.4 17 2 17.4 2 18V20C2 20.6 2.4 21 3 21H21C21.6 21 22 20.6 22 20Z" fill="black" />
										</svg>
									</span>
									<!--end::Svg Icon-->
								</button>
								<!--end::Mobile menu toggle-->
								<!--begin::Logo image-->
								<a href="anasayfa.php">
									<img src="assets/media/logos/logo.png" alt="Logo" class="logo-default h-50px h-lg-60px" />
									<img alt="Logo" class="logo-sticky h-40px h-lg-25px" />
								</a>
								<p>Veriler 15 Saniyede Bir Güncellenmektedir</p>
								<!--end::Logo image-->
							</div>
							<!--end::Logo-->
							<!--begin::Menu wrapper-->
							<div class="d-lg-block" id="kt_header_nav_wrapper">
								<div class="d-lg-block p-5 p-lg-0" data-kt-drawer="true" data-kt-drawer-name="landing-menu" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="200px" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_landing_menu_toggle" data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_body', lg: '#kt_header_nav_wrapper'}">
									<!--begin::Menu-->

								</div>
							</div>
							<!--end::Menu wrapper-->
							<!--begin::Toolbar-->
							<div class="flex-equal text-end ms-1">
								<div class="btn-group">
									<button type="button" class="btn btn-success"><?php echo "Token Count: " . $row['token']; ?></button>
									<button type="button" class="btn btn-secondary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
										<span class="visually-hidden"></span>
									</button>
									<ul class="dropdown-menu">
										<li><a class="dropdown-item" href="yukleme.php">
												<h3>Token Yükle </h3>
											</a></li>
										<li><a class="dropdown-item" href="paracek.php">
												<h3> Token Çek</h3>
											</a></li>
									</ul>
								</div>
								<a href="portfoy.php" class="btn btn-outline-primary "><?php echo $name['isim'];
																						echo ' ';
																						echo $surname['soyisim']; ?></a>
								<a href="logout.php" class="btn btn-outline-danger ">Çıkış Yap</a>
								<!-- <form action="yukleme.php">
										<button type='submit' formmethod='post' class='btn btn-outline-success' name='miktar' id='miktar' value=''>Token Yükle</button>
									</form> -->

							</div>
							<!--end::Toolbar-->
						</div>
						<!--end::Wrapper-->
					</div>
					<!--end::Container-->
				</div>
				<!--end::Header-->
				<!--begin::Landing hero-->
				<div class="d-flex flex-column flex-center w-100 min-h-350px min-h-lg-500px px-9">
					<!--begin::Heading-->
					<form id="tradeform" method="post" action="anasayfa.php">
						<table class="table table-rounded table-striped table-light border gy-7 gs-7">
							<thead>
								<tr class="fw-bold fs-6 text-gray-800 border-bottom border-gray-200">
									<th>Coin</th>
									<th>Güncel Fiyat</th>
									<th>Piyasa Değeri</th>
									<th>Mevcut Arz</th>
									<th>İşlem Hacmi (24 Saat)</th>
									<th>Değişim (24 Saat)</th>
									<th>işlemler</th>
									<th>Adet</th>
								</tr>
							</thead>
							<tbody class="fw-bold fs-6 text-gray-800 border-bottom border-gray-200">
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

									$host = "localhost";
									$kullanici = "root";
									$sifre = "";
									$veritabani = "democoin";
									$tablo = "cryptoDB";

									$baglanti = mysqli_connect($host, $kullanici, $sifre, $veritabani);
									if (!$baglanti) {
										die("Veritabanı bağlantısı başarısız: " . mysqli_connect_error());
									}

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


										echo "<form method='post' action='anasayfa.php'>";
										echo '<tr id="' . $crypto['id'] . '">';
										echo '<td>' . $crypto['name'] . '</td>';
										echo '<td>' . " " . "$" . number_format($crypto['priceUsd'], 2) . " " . "USD" . '</td>';
										echo '<td>' . " " . "$" . number_format($crypto['marketCapUsd']) . " " . "b" . '</td>';
										echo '<td>' . " " . "$" . number_format($crypto['supply'], 2) . " " . "m" . '</td>';
										echo '<td>' . " " . "$" . number_format($crypto['volumeUsd24Hr'], 2) . " " . "b" . '</td>';

										$changePercent24Hr = $crypto['changePercent24Hr'];
										$changePercent24HrFormatted = number_format($changePercent24Hr, 2) . "%";

										// Belirtilen koşula göre yazı rengini ayarla
										$color = ($changePercent24Hr < 0) ? 'red' : 'green';

										// Yazı rengini uygula
										echo '<td style="color: ' . $color . ';">' . $changePercent24HrFormatted . '</td>';


										
										echo "<input type='hidden' name='coinname' value='" . $crypto['name'] . "'>";
										echo "<input type='hidden' name='coinvalue' value='" . number_format($crypto['priceUsd'], 2) . "'>";
										echo '<td>' . "<button type='submit' class='btn btn-outline-success' name='buy' id='buy' value='Al'>AL</button>" . "<button type='submit' class='btn btn-outline-danger' name='sell' id='sell' value='Sat'>SAT</button>" . '</td>';
										// echo '<td>' . "<button type='submit' class='btn btn-outline-danger' name='sell' id='sell' value='Sat'>SAT</button>" . '</td>';
										echo '<td>' . "<input min='1' type='text' pattern='^(0|[1-9]\d*)(\.\d+)?$' title='Sadece sıfırdan büyük sayılar girebilirsiniz.' placeholder='Alım-Satım Adedini Giriniz' class='btn btn-outline-success' name='girdi' id='girdi' required></input>" . '</td>';

										echo "</form>";
										echo '</tr>';
									}
								} else {
									echo "'API'den veri alınamadı.'";
								}

								?>
							</tbody>

						</table>
					</form>

					<div class="text-center mb-5 mb-lg-10 py-10 py-lg-20">
					</div>
					<!--end::Heading-->

				</div>
				<!--end::Landing hero-->
			</div>
			<!--end::Wrapper-->
			<!--begin::Curve bottom-->
			<div class="landing-curve landing-dark-color mb-10 mb-lg-20">
				<svg viewBox="15 12 1470 48" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M0 11C3.93573 11.3356 7.85984 11.6689 11.7725 12H1488.16C1492.1 11.6689 1496.04 11.3356 1500 11V12H1488.16C913.668 60.3476 586.282 60.6117 11.7725 12H0V11Z" fill="currentColor"></path>
				</svg>
			</div>
			<!--end::Curve bottom-->
		</div>
	</div>
	<!--end::Main-->
	<script>
		var hostUrl = "assets/";
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
	<!-- Add this script block at the end of your HTML body, just before the closing </body> tag -->



	<!-- ... (existing HTML code) ... -->




	<!--end::Page Custom Javascript-->
	<!--end::Javascript-->
	<!-- 	<script>
		const buyBtn =document.getElementsByName("buy");
		console.log(buyBtn);
		var buyAmount;
		buyBtn.forEach(element => {
			/* console.log(element); */
			element.addEventListener("click", ()=>{
				buyAmount = prompt('Lutfen adet girin: ')
				console.log(buyAmount);
				
			} )
		});
	</script> -->
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
		// Belirli bir süre aralığında formu yenileyen JavaScript fonksiyonu
function refreshForm() {
  // Formu seç
  var form = document.getElementById('tradeform');
  
  // Formu yenileme işlemi
  function reloadForm() {
    form.submit();
  }
  
  // 15 saniyede bir formu yenile
  setInterval(reloadForm, 15000);
}

// Sayfa yüklendiğinde fonksiyonu çağır
window.onload = refreshForm;

	</script>


</body>
<!--end::Body-->

</html>