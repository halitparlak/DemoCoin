<?php
$host = "localhost";
$kullanici = "root";
$sifre = "";
$veritabani = "democoin";
$tablo = "users";

$baglanti = mysqli_connect($host, $kullanici, $sifre);
@mysqli_select_db($baglanti, $veritabani);

if (isset($_POST["giris"])) {
	$email = $_POST["email"];
	$sifre = $_POST["sifre"];

	// Veritabanında kullanıcıyı kontrol et
	$sql = "SELECT * FROM users WHERE email='$email' AND sifre='$sifre'";
	$result = $baglanti->query($sql);

	if ($result->num_rows > 0) {
		// Giriş başarılıysa oturumu başlat
		session_start();

		// Kullanıcı bilgilerini oturumda sakla (örneğin, kullanıcı ID)
		$row = $result->fetch_assoc();
		$_SESSION['userid'] = $row['userid'];

		// Başarılı giriş durumunda anasayfa.php'ye yönlendir
		header("Location: anasayfa.php");
		exit();
	} else {
		// Hatalı giriş durumunda hata mesajını ekrana yazdırabilir veya başka bir işlem yapabilirsiniz
		echo "Hatalı e-posta veya şifre";
	}
}

mysqli_close($baglanti);
?>


<!DOCTYPE html>
<html lang="tr">

<head>
	<title>DemoCoin - Giriş Yap</title>
	<meta name="description" content="The most advanced Bootstrap Admin Theme on Themeforest trusted by 94,000 beginners and professionals. Multi-demo, Dark Mode, RTL support and complete React, Angular, Vue &amp; Laravel versions. Grab your copy now and get life-time updates for free." />
	<meta name="keywords" content="Metronic, bootstrap, bootstrap 5, Angular, VueJs, React, Laravel, admin themes, web design, figma, web development, free templates, free admin themes, bootstrap theme, bootstrap template, bootstrap dashboard, bootstrap dak mode, bootstrap button, bootstrap datepicker, bootstrap timepicker, fullcalendar, datatables, flaticon" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta charset="utf-8" />
	<meta property="og:locale" content="en_US" />
	<meta property="og:type" content="article" />
	<meta property="og:title" content="Metronic - Bootstrap 5 HTML, VueJS, React, Angular &amp; Laravel Admin Dashboard Theme" />
	<meta property="og:url" content="https://keenthemes.com/metronic" />
	<meta property="og:site_name" content="Keenthemes | Metronic" />
	<link rel="canonical" href="https://preview.keenthemes.com/metronic8" />
	<link rel="shortcut icon" />
	<!--begin::Fonts-->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
	<!--end::Fonts-->
	<!--begin::Global Stylesheets Bundle(used by all pages)-->
	<link href="assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
	<link href="assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
	<style>
		body,
		html {
			height: 100%;
			margin: 0;
		}

		body {
			display: flex;
			flex-direction: column;
			align-items: center;
			justify-content: flex-end;
			background-image: url(assets/media/illustrations/sketchy-1/1.jpeg);
			background-repeat: no-repeat;
			background-size: cover;
			background-attachment: fixed;
		}
	</style>


	<!--end::Global Stylesheets Bundle-->
</head>

<body id="kt_body" class="bg-body">
	<!--begin::Main-->
	<div class="d-flex flex-column flex-root">
		<!--begin::Authentication - Sign-in -->
		<div class="d-flex flex-column flex-column-fluid bgi-position-y-bottom position-x-center bgi-no-repeat bgi-size-contain bgi-attachment-fixed" style="background-image: url(assets/media/illustrations/sketchy-1/1.jpeg)">
			<!--begin::Content-->
			<div class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20">
				<!--begin::Logo-->

				<!--end::Logo-->
				<!--begin::Wrapper-->
				<div class="w-lg-500px bg-body rounded shadow-sm p-10 p-lg-15 mx-auto">
					<!--begin::Form-->
					<form class="form w-100" novalidate="novalidate" id="girisform" name="girisform" action="giris.php" method="post">
						<!--begin::Heading-->
						<div class="text-center mb-10">
							<!--begin::Title-->
							<h1 class="text-dark mb-3">Giriş Yap</h1>
							<!--end::Title-->
							<!--begin::Link-->
							<div class="text-gray-400 fw-bold fs-4">Hesabın yok mu?
								<a href="kayit.php" class="link-primary fw-bolder">Kayıt Ol</a>
							</div>
							<!--end::Link-->
						</div>
						<!--begin::Heading-->
						<!--begin::Input group-->
						<div class="fv-row mb-10">
							<!--begin::Label-->
							<label class="form-label fs-6 fw-bolder text-dark" for="email">Email</label>
							<!--end::Label-->
							<!--begin::Input-->
							<input class="form-control form-control-lg form-control-solid" type="text" name="email" id="email" autocomplete="off" />
							<!--end::Input-->
						</div>
						<!--end::Input group-->
						<!--begin::Input group-->
						<div class="fv-row mb-10">
							<!--begin::Wrapper-->
							<div class="d-flex flex-stack mb-2">
								<!--begin::Label-->
								<label class="form-label fw-bolder text-dark fs-6 mb-0" for="sifre">Şifre</label>
								<!--end::Label-->
								<!--begin::Link-->
								<!--end::Link-->
							</div>
							<!--end::Wrapper-->
							<!--begin::Input-->
							<input class="form-control form-control-lg form-control-solid" type="password" name="sifre" id="sifre" autocomplete="off" />
							<!--end::Input-->
						</div>
						<!--end::Input group-->
						<!--begin::Actions-->
						<div class="text-center">
							<!--begin::Submit button-->
							<button type="submit" id="giris" name="giris" class="btn btn-lg btn-primary w-100 mb-5">
								<span class="indicator-label">Giriş Yap</span>
							</button>
							<!--end::Submit button-->
							<!--begin::Separator-->
						</div>

						<!--end::Actions-->
					</form>
					<!--end::Form-->
				</div>
				<!--end::Wrapper-->
			</div>
			<!--end::Content-->
			<!--begin::Footer-->
			<!--end::Footer-->
		</div>
		<!--end::Authentication - Sign-in-->
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
	<!--begin::Page Custom Javascript(used by this page)-->
	<script src="assets/js/custom/authentication/sign-in/general.js"></script>
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
<!--end::Body-->
</body>

</html>