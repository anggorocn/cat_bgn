<?php
$user=Session::get('user');
// dd($user);
?>
<!DOCTYPE html>
<html lang="en">
	<!--begin::Head-->
	<head>
		<base href="{{ asset('/') }}">
		
		<meta charset="utf-8" />
		<title>Aplikasi CAT | BPS</title>
		<meta name="description" content="Basic datatables examples" />
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
		<meta name="csrf_token" content="{{ csrf_token() }}" />
		<!-- PWA  -->
		<meta name="theme-color" content="#6777ef"/>
		
		<meta http-equiv="cache-control" content="no-cache" />
		<meta http-equiv="Pragma" content="no-cache" />
		<meta http-equiv="Expires" content="-1" />
		<link rel="canonical" href="https://keenthemes.com/metronic" />
		<!--begin::Fonts-->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
		<!--end::Fonts-->
		<!--begin::Page Vendors Styles(used by this page)-->
		<link href="assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
		<!--end::Page Vendors Styles-->
		<!--begin::Global Theme Styles(used by all pages)-->
		<link href="assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
		<link href="assets/plugins/custom/prismjs/prismjs.bundle.css" rel="stylesheet" type="text/css" />
		<link href="assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
		<!--end::Global Theme Styles-->
		<!--begin::Layout Themes(used by all pages)-->
		<link href="assets/css/themes/layout/header/base/light.css" rel="stylesheet" type="text/css" />
		<link href="assets/css/themes/layout/header/menu/light.css" rel="stylesheet" type="text/css" />
		<link href="assets/css/themes/layout/brand/dark.css" rel="stylesheet" type="text/css" />
		<link href="assets/css/themes/layout/aside/dark.css" rel="stylesheet" type="text/css" />
		<!--end::Layout Themes-->
		<link rel="shortcut icon" href="assets/media/images/favicon.ico" />

		<script type="text/javascript" src="assets/plugins/global/plugins.bundle.js"></script>
		<script type="text/javascript" src="assets/js/scripts.bundle.js"></script>
		<!--end::Global Theme Bundle-->
		<!--begin::Page Vendors(used by this page)-->
		<script type="text/javascript" src="assets/plugins/custom/datatables/datatables.bundle.js"></script>
		<!--end::Page Vendors-->
		<!--begin::Page Scripts(used by this page)-->
		<script type="text/javascript" src="assets/js/pages/crud/datatables/data-sources/valsix-serverside.js"></script>
		
		<!-- FONT AWESOME -->
    	<link rel="stylesheet" href="assets/font-awesome-4.7.0/css/font-awesome.css" type="text/css">

		<link rel="stylesheet" type="text/css" href="assets/jconfirm/css/jquery-confirm.css"/>
		<script type="text/javascript" src="assets/jconfirm/js/jquery-confirm.js"></script>

		<script type="text/javascript" src="assets/emodal/eModal.js"></script>

		<script type="text/javascript">
		function openAdd(page) {
			//alert("hai");
			eModal.iframe(page, 'Aplikasi CAT | Badan Pusat Statistik ')
		}

		function closePopup() {
			eModal.close();
		}
		</script>

		<!-- VALSIX -->
		<link href="assets/css/gaya.css" rel="stylesheet" type="text/css" />

	</head>
	<!--end::Head-->
	<!--begin::Body-->
	<body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable aside-minimize">

		<div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper" style="padding-left: 0px;padding-top: 0px;">
			<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
				@yield('content')
				@yield('header')
			</div>
			 @include('app/footer') 
		</div>


		<!--begin::Global Config(global config for global JS scripts)-->
		<script>var KTAppSettings = { "breakpoints": { "sm": 576, "md": 768, "lg": 992, "xl": 1200, "xxl": 1400 }, "colors": { "theme": { "base": { "white": "#ffffff", "primary": "#3699FF", "secondary": "#E5EAEE", "success": "#1BC5BD", "info": "#8950FC", "warning": "#FFA800", "danger": "#F64E60", "light": "#E4E6EF", "dark": "#181C32" }, "light": { "white": "#ffffff", "primary": "#E1F0FF", "secondary": "#EBEDF3", "success": "#C9F7F5", "info": "#EEE5FF", "warning": "#FFF4DE", "danger": "#FFE2E5", "light": "#F3F6F9", "dark": "#D6D6E0" }, "inverse": { "white": "#ffffff", "primary": "#ffffff", "secondary": "#3F4254", "success": "#ffffff", "info": "#ffffff", "warning": "#ffffff", "danger": "#ffffff", "light": "#464E5F", "dark": "#ffffff" } }, "gray": { "gray-100": "#F3F6F9", "gray-200": "#EBEDF3", "gray-300": "#E4E6EF", "gray-400": "#D1D3E0", "gray-500": "#B5B5C3", "gray-600": "#7E8299", "gray-700": "#5E6278", "gray-800": "#3F4254", "gray-900": "#181C32" } }, "font-family": "Poppins" };</script>
		<!--end::Global Config-->
		<!--begin::Global Theme Bundle(used by all pages)-->

		<script>
			

			function openAdd(page) {
	            //alert("hai");
	            eModal.iframe(page, 'Aplikasi Assesment BPS')
	        }

       		function closeIFrame(page) {
				eModal.close()
			}

			function getdatakepada(vdetil) {
				if (window.parent && window.parent.document)
			    {
			        if (typeof window.parent.setdatakepada === 'function')
			        {
						return parent.setdatakepada(vdetil);
					}
				}
			}
		</script>
		<!--end::Page Scripts-->

		<!-- BG HEADER -->
		<style type="text/css">
			.black {
				/*background-color: rgba(255,255,255,1);*/

				-webkit-border-radius: 0px;
				-webkit-border-bottom-left-radius: 30px;
				-moz-border-radius: 0px;
				-moz-border-radius-bottomleft: 30px;
				border-radius: 0px;
				border-bottom-left-radius: 30px;
			}
		</style>
		<script type="text/javascript">
			
			$(document).ready(function(){
			  $(window).scroll(function(){
			  	var scroll = $(window).scrollTop();
				  if (scroll > 0) {
				    $(".black").css("background" , "rgba(255,255,255,1)");  	
				  }

				  else{
					  $(".black").css("background" , "rgba(0,0,0,0)");  	
				  }
			  })
			})
		</script>
		
		<!-- END BG HEADER -->

	</body>
	<!--end::Body-->
</html>