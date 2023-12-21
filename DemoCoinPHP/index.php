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
<html lang="en">
	<!--begin::Head-->
	<head><base href="">
		<title>DemoCoin</title>
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
									<a href="../../demo1/dist/landing.html">
										<img alt="Logo"  class="logo-default h-25px h-lg-30px" />
										<img alt="Logo"  class="logo-sticky h-20px h-lg-25px" />
									</a>
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
									<a href="giris.php" class="btn btn-outline-success ">Giriş Yap</a>
                                    <a href="kayit.php" class="btn btn-outline-primary ">Kayıt Ol</a>
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
                        <table class="table table-rounded table-striped border gy-7 gs-7">
    <thead>
        <tr class="fw-bold fs-6 text-gray-800 border-bottom border-gray-200">
            <th>Coin</th>
            <th>Güncel Fiyat</th>
            <th>Piyasa Değeri</th>
            <th>Mevcut Arz</th>
            <th>İşlem Hacmi (24 Saat)</th>
            <th>Değişim (24 Saat)</th>
            <!-- <th>işlemler</th> -->
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
    foreach ($data['data'] as $crypto) {
        echo '<tr>';
        echo '<td>' . $crypto['name'].'</td>';
        echo '<td>' ." "."$". number_format($crypto['priceUsd'],2)." "."USD".'</td>';
        echo '<td>' ." "."$". number_format($crypto['marketCapUsd'])." "."b".'</td>';
        echo '<td>' ." "."$". number_format($crypto['supply'],2)." "."m".'</td>';
        echo '<td>' ." "."$". number_format($crypto['volumeUsd24Hr'],2)." "."b".'</td>';
        echo '<td>' . number_format($crypto['changePercent24Hr'],2)."%".'</td>';
        // echo '<td>'.'<button type="button" class="btn btn-outline-success">AL</button>'.
        // '<button type="button" class="btn btn-outline-danger">SAT</button>'
        // .'</td';
        echo '</tr>';
    }
} else {
    echo "'API'den veri alınamadı.'";
}

?>
    </tbody>
</table>
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
		<script>var hostUrl = "assets/";</script>
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
<script>
    // Function to fetch and update data
    function fetchData() {
        // CoinCap API Endpoint and API Key
        var apiEndpoint = 'https://api.coincap.io/v2/assets';
        var apiKey = '0d031cac-8cb5-4e18-ad20-9bad23e57bdd';

        // Perform AJAX request
        var xhr = new XMLHttpRequest();
        xhr.open('GET', apiEndpoint + '?apiKey=' + apiKey, true);

        xhr.onload = function () {
            if (xhr.status >= 200 && xhr.status < 300) {
                // Parse JSON response
                var data = JSON.parse(xhr.responseText);

                // Update table content
                if (data && data.data) {
                    var tableBody = document.querySelector('tbody');
                    tableBody.innerHTML = ''; // Clear existing rows

                    data.data.forEach(function (crypto) {
                        var newRow = '<tr>' +
                            '<td>' + crypto.name + '</td>' +
                            '<td>' + "$" + number_format(crypto.priceUsd, 2) + " USD" + '</td>' +
                            '<td>' + "$" + number_format(crypto.marketCapUsd) + " b" + '</td>' +
                            '<td>' + "$" + number_format(crypto.supply, 2) + " m" + '</td>' +
                            '<td>' + "$" + number_format(crypto.volumeUsd24Hr, 2) + " b" + '</td>' +
                            '<td>' + number_format(crypto.changePercent24Hr, 2) + "%" + '</td>' +
                            '<td>'+
                            '</tr>';
                        tableBody.innerHTML += newRow;
                    });
                }
            } else {
                console.error('Failed to fetch data. Status: ' + xhr.status);
            }
        };

        xhr.onerror = function () {
            console.error('Network error occurred');
        };

        xhr.send();
    }

    // Function to format numbers with commas
    function number_format(number, decimals) {
        return parseFloat(number).toFixed(decimals).replace(/\d(?=(\d{3})+\.)/g, '$&,');
    }

    // Call fetchData function initially
    fetchData();

    // Set interval to call fetchData every 5 minutes (adjust as needed)
    setInterval(fetchData, 1000); // 300,000 milliseconds = 5 minutes
</script>

		<!--end::Page Custom Javascript-->
		<!--end::Javascript-->
	</body>
	<!--end::Body-->
</html>