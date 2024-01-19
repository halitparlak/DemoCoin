<?php
$host = "localhost";
$kullanici = "root";
$sifre = "";
$veritabani = "democoin";
$tablo = "users";

$baglanti = mysqli_connect($host, $kullanici, $sifre);
@mysqli_select_db($baglanti, $veritabani);

if (isset($_POST["kayit"])) {

	$name = $_POST["isim"];
	$surname = $_POST["soyisim"];
	$phone = $_POST["telno"];
	$email = $_POST["email"];
	$password = $_POST["sifre"];

	$mailVarMiQuery = "SELECT email FROM users WHERE email = '$email'";
	$mailVarMiQueryResult = mysqli_query($baglanti, $mailVarMiQuery);

	$mailVarMiQueryArray = mysqli_fetch_assoc($mailVarMiQueryResult);
	$mailVarMi = $mailVarMiQueryArray['email'];


	if(empty($mailVarMi)){

		$ekle = "INSERT INTO users (isim, soyisim, email, telno, sifre) VALUES ('$name','$surname','$email','$phone','$password')";
		$calistirekle = mysqli_query($baglanti, $ekle);

		if ($calistirekle) {
			echo '<script> alert("Kayıt başarılı."); </script>';
            //echo "Kayıt başarılı.";
        } else {
			echo '<script> alert("Kayıt sırasında bir hata oluştu."); </script>';
			
            //echo "Kayıt sırasında bir hata oluştu.";
        }
		

	} else {
		echo '<script> alert("Bu e-posta kullanilmaktadir."); </script>';
		echo "Bu e-posta kullanilmaktadir.";
	}



}
mysqli_close($baglanti);
?>
<!DOCTYPE html>
<!--
Author: Keenthemes
Product Name: Metronic - Bootstrap 5 HTML, VueJS, React, Angular & Laravel Admin Dashboard Theme
Purchase: https://1.envato.market/EA4JP
Website: http://www.keenthemes.com
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Dribbble: www.dribbble.com/keenthemes
Like: www.facebook.com/keenthemes
License: For each use you must have a valid license purchased only from above link in order to legally use the theme for your project.
-->
<html lang="tr">
<!--begin::Head-->

<head>
	<title>DemoCoin - Kayıt Ol</title>
	<link rel="icon" type="image/x-icon" href="favicon.ico">
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
	<!--end::Global Stylesheets Bundle-->
	<style>
		body,
		html {
			height: 112%;
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
</head>
<!--end::Head-->
<!--begin::Body-->

<body id="kt_body" class="bg-body">
	<!--begin::Main-->
	<div class="d-flex flex-column flex-root">
		<!--begin::Authentication - Sign-up -->
		<div class="d-flex flex-column flex-column-fluid bgi-position-y-bottom position-x-center bgi-no-repeat bgi-size-contain bgi-attachment-fixed">
			<!--begin::Content-->
			<div class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20">
				<!--begin::Logo-->

				<!--end::Logo-->
				<!--begin::Wrapper-->
				<div class="w-lg-600px bg-body rounded shadow-sm p-10 p-lg-15 mx-auto">
					<!--begin::Form-->
					<form class="form w-100"  id="kayitform" name="kayitform" action="kayit.php" method="POST">
						<!--begin::Heading-->
						<div class="mb-10 text-center">
							<!--begin::Title-->
							<h1 class="text-dark mb-3">Kayıt Ol</h1>
							<!--end::Title-->
							<!--begin::Link-->
							<div class="text-gray-400 fw-bold fs-4">Hesabınız Var Mı?
								<a href="giris.php" class="link-primary fw-bolder">Giriş Yap</a>
							</div>
							<!--end::Link-->
						</div>
						<!--end::Heading-->
						<!--begin::Action-->

						<!--end::Action-->
						<!--begin::Separator-->

						<!--end::Separator-->
						<!--begin::Input group-->
						<div class="row fv-row mb-7">
							<!--begin::Col-->
							<div class="col-xl-6">
								<label class="form-label fw-bolder text-dark fs-6">İsim</label>
								<input class="form-control form-control-lg form-control-solid" type="text" placeholder="İsminizi Yazınız" name="isim" id="isim" autocomplete="off" pattern="[a-zA-ZğüşıöçĞÜŞİÖÇ]+" min="1" max="30" title="Lütfen geçerli bir isim girin." required>
							</div>
							<!--end::Col-->
							<!--begin::Col-->
							<div class="col-xl-6">
								<label class="form-label fw-bolder text-dark fs-6">Soyisim</label>
								<input class="form-control form-control-lg form-control-solid" type="text" placeholder="Lütfen Soyisminizi Giriniz" name="soyisim" id="soyisim" autocomplete="off" pattern="[a-zA-ZğüşıöçĞÜŞİÖÇ]+" min="1" max="30" title="Lütfen geçerli bir soyisim girin." required>
							</div>
							<!--end::Col-->
						</div>
						<!--end::Input group-->
						<!--begin::Input group-->
						<div class="fv-row mb-7">
							<label class="form-label fw-bolder text-dark fs-6">Email</label>
							<input class="form-control form-control-lg form-control-solid" type="email" placeholder="Lütfen E-Posta Adresini Giriniz" name="email" minlength="1" autocomplete="off" required>
						</div>
						<div class="fv-row mb-7">
							<label class="form-label fw-bolder text-dark fs-6">Telefon Numarası</label>
							<input class="form-control form-control-lg form-control-solid" type="text" placeholder="Lütfen Telefon Numaranızı Griniz" minlength="1" maxlength="12" name="telno" id="telno" autocomplete="off" required>
						</div>
						<!--end::Input group-->
						<!--begin::Input group-->
						<div class="mb-10 fv-row" data-kt-password-meter="true">
							<!--begin::Wrapper-->
							<div class="mb-1">
								<!--begin::Label-->
								<label class="form-label fw-bolder text-dark fs-6">Şifre</label>
								<!--end::Label-->
								<!--begin::Input wrapper-->
								<div class="position-relative mb-3">
									<input class="form-control form-control-lg form-control-solid" type="password" placeholder="Lütfen En Az 8 Haneli Bir Şifre Giriniz" name="sifre" id="sifre" title="Lütfen En Az 8 Haneli Bir Şifre Giriniz" autocomplete="off" required>
									<span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2" data-kt-password-meter-control="visibility">
										<i class="bi bi-eye-slash fs-2"></i>
										<i class="bi bi-eye fs-2 d-none"></i>
									</span>
								</div>
								<!--end::Input wrapper-->
								<!--begin::Meter-->

								<!--end::Meter-->
							</div>
							<!--end::Wrapper-->
							<!--begin::Hint-->

							<!--end::Input group=-->
							<!--begin::Input group-->

							<!--end::Input group-->
							<!--begin::Input group-->

							<!--end::Input group-->
							<!--begin::Actions-->
							<div class="text-center">
								<button type="submit" id="kayit" name="kayit" class="btn btn-lg btn-primary">
									<span class="indicator-label">Kayıt Ol</span>
								</button>
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
		<!--end::Authentication - Sign-up-->
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
	<script src="assets/js/custom/authentication/sign-up/general.js"></script>
	<!--end::Page Custom Javascript-->
	<!--end::Javascript-->
</body>
<!--end::Body-->

</html>