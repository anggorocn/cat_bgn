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
		<link href="assets/css/gaya-baru.css" rel="stylesheet" type="text/css" />

		<link href="assets/css/w3.css" rel="stylesheet" type="text/css" />
	</head>
	<!--end::Head-->
	<!--begin::Body-->
	<body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable aside-minimize">

		<div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper" style="padding-left: 0px;">
			<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
				<div id="kt_header" class="header header-fixed black" style="left: -25px;">
					<div class="container-fluid d-flex align-items-stretch justify-content-between">
						<div class="topbar" style="width:15%">
							<div class="topbar-item">
								<div class="btn btn-icon btn-icon-mobile w-auto btn-clean d-flex align-items-center btn-lg px-2" style="height: 100%; background: white; margin-right: -25px;border-radius: 0px;border-bottom-right-radius: 30px;">
			                    <img src="images/logobps.png" style="width: 65%">
			                </div>
							</div>
						</div>
						<div class="header-menu-wrapper header-menu-wrapper-left" id="kt_header_menu_wrapper">
							<a href="app" class="brand-logo" style="background-color:white;">
			                    
							</a>
							<!-- <div id="kt_header_menu" class="header-menu header-menu-mobile header-menu-layout-default"> -->
							<div id="kt_header_menu" class="header-menu header-menu-mobile header-menu-layout-default" style="display: none;">
								<ul class="menu-nav">
									<li class="menu-item menu-item-open menu-item-here menu-item-submenu menu-item-rel menu-item-open menu-item-here menu-item-active" data-menu-toggle="click" aria-haspopup="true">
										<a href="javascript:;" class="menu-link menu-toggle">
											<span class="menu-text">Pages</span>
											<i class="menu-arrow"></i>
										</a>
										<div class="menu-submenu menu-submenu-classic menu-submenu-left">
											<ul class="menu-subnav">
												<li class="menu-item menu-item-active" aria-haspopup="true">
													<a href="index.html" class="menu-link">
														<span class="svg-icon menu-icon">
															<!--begin::Svg Icon | path:assets/media/svg/icons/Clothes/Briefcase.svg-->
															<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																	<rect x="0" y="0" width="24" height="24" />
																	<path d="M5.84026576,8 L18.1597342,8 C19.1999115,8 20.0664437,8.79732479 20.1528258,9.83390904 L20.8194924,17.833909 C20.9112219,18.9346631 20.0932459,19.901362 18.9924919,19.9930915 C18.9372479,19.9976952 18.8818364,20 18.8264009,20 L5.1735991,20 C4.0690296,20 3.1735991,19.1045695 3.1735991,18 C3.1735991,17.9445645 3.17590391,17.889153 3.18050758,17.833909 L3.84717425,9.83390904 C3.93355627,8.79732479 4.80008849,8 5.84026576,8 Z M10.5,10 C10.2238576,10 10,10.2238576 10,10.5 L10,11.5 C10,11.7761424 10.2238576,12 10.5,12 L13.5,12 C13.7761424,12 14,11.7761424 14,11.5 L14,10.5 C14,10.2238576 13.7761424,10 13.5,10 L10.5,10 Z" fill="#000000" />
																	<path d="M10,8 L8,8 L8,7 C8,5.34314575 9.34314575,4 11,4 L13,4 C14.6568542,4 16,5.34314575 16,7 L16,8 L14,8 L14,7 C14,6.44771525 13.5522847,6 13,6 L11,6 C10.4477153,6 10,6.44771525 10,7 L10,8 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
																</g>
															</svg>
															<!--end::Svg Icon-->
														</span>
														<span class="menu-text">My Account</span>
													</a>
												</li>
												<li class="menu-item" aria-haspopup="true">
													<a href="javascript:;" class="menu-link">
														<span class="svg-icon menu-icon">
															<!--begin::Svg Icon | path:assets/media/svg/icons/Code/Compiling.svg-->
															<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																	<rect x="0" y="0" width="24" height="24" />
																	<path d="M2.56066017,10.6819805 L4.68198052,8.56066017 C5.26776695,7.97487373 6.21751442,7.97487373 6.80330086,8.56066017 L8.9246212,10.6819805 C9.51040764,11.267767 9.51040764,12.2175144 8.9246212,12.8033009 L6.80330086,14.9246212 C6.21751442,15.5104076 5.26776695,15.5104076 4.68198052,14.9246212 L2.56066017,12.8033009 C1.97487373,12.2175144 1.97487373,11.267767 2.56066017,10.6819805 Z M14.5606602,10.6819805 L16.6819805,8.56066017 C17.267767,7.97487373 18.2175144,7.97487373 18.8033009,8.56066017 L20.9246212,10.6819805 C21.5104076,11.267767 21.5104076,12.2175144 20.9246212,12.8033009 L18.8033009,14.9246212 C18.2175144,15.5104076 17.267767,15.5104076 16.6819805,14.9246212 L14.5606602,12.8033009 C13.9748737,12.2175144 13.9748737,11.267767 14.5606602,10.6819805 Z" fill="#000000" opacity="0.3" />
																	<path d="M8.56066017,16.6819805 L10.6819805,14.5606602 C11.267767,13.9748737 12.2175144,13.9748737 12.8033009,14.5606602 L14.9246212,16.6819805 C15.5104076,17.267767 15.5104076,18.2175144 14.9246212,18.8033009 L12.8033009,20.9246212 C12.2175144,21.5104076 11.267767,21.5104076 10.6819805,20.9246212 L8.56066017,18.8033009 C7.97487373,18.2175144 7.97487373,17.267767 8.56066017,16.6819805 Z M8.56066017,4.68198052 L10.6819805,2.56066017 C11.267767,1.97487373 12.2175144,1.97487373 12.8033009,2.56066017 L14.9246212,4.68198052 C15.5104076,5.26776695 15.5104076,6.21751442 14.9246212,6.80330086 L12.8033009,8.9246212 C12.2175144,9.51040764 11.267767,9.51040764 10.6819805,8.9246212 L8.56066017,6.80330086 C7.97487373,6.21751442 7.97487373,5.26776695 8.56066017,4.68198052 Z" fill="#000000" />
																</g>
															</svg>
															<!--end::Svg Icon-->
														</span>
														<span class="menu-text">Task Manager</span>
														<span class="menu-label">
															<span class="label label-success label-rounded">2</span>
														</span>
													</a>
												</li>
												<li class="menu-item menu-item-submenu" data-menu-toggle="hover" aria-haspopup="true">
													<a href="javascript:;" class="menu-link menu-toggle">
														<span class="svg-icon menu-icon">
															<!--begin::Svg Icon | path:assets/media/svg/icons/Code/CMD.svg-->
															<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																	<rect x="0" y="0" width="24" height="24" />
																	<path d="M9,15 L7.5,15 C6.67157288,15 6,15.6715729 6,16.5 C6,17.3284271 6.67157288,18 7.5,18 C8.32842712,18 9,17.3284271 9,16.5 L9,15 Z M9,15 L9,9 L15,9 L15,15 L9,15 Z M15,16.5 C15,17.3284271 15.6715729,18 16.5,18 C17.3284271,18 18,17.3284271 18,16.5 C18,15.6715729 17.3284271,15 16.5,15 L15,15 L15,16.5 Z M16.5,9 C17.3284271,9 18,8.32842712 18,7.5 C18,6.67157288 17.3284271,6 16.5,6 C15.6715729,6 15,6.67157288 15,7.5 L15,9 L16.5,9 Z M9,7.5 C9,6.67157288 8.32842712,6 7.5,6 C6.67157288,6 6,6.67157288 6,7.5 C6,8.32842712 6.67157288,9 7.5,9 L9,9 L9,7.5 Z M11,13 L13,13 L13,11 L11,11 L11,13 Z M13,11 L13,7.5 C13,5.56700338 14.5670034,4 16.5,4 C18.4329966,4 20,5.56700338 20,7.5 C20,9.43299662 18.4329966,11 16.5,11 L13,11 Z M16.5,13 C18.4329966,13 20,14.5670034 20,16.5 C20,18.4329966 18.4329966,20 16.5,20 C14.5670034,20 13,18.4329966 13,16.5 L13,13 L16.5,13 Z M11,16.5 C11,18.4329966 9.43299662,20 7.5,20 C5.56700338,20 4,18.4329966 4,16.5 C4,14.5670034 5.56700338,13 7.5,13 L11,13 L11,16.5 Z M7.5,11 C5.56700338,11 4,9.43299662 4,7.5 C4,5.56700338 5.56700338,4 7.5,4 C9.43299662,4 11,5.56700338 11,7.5 L11,11 L7.5,11 Z" fill="#000000" fill-rule="nonzero" />
																</g>
															</svg>
															<!--end::Svg Icon-->
														</span>
														<span class="menu-text">Team Manager</span>
														<i class="menu-arrow"></i>
													</a>
													<div class="menu-submenu menu-submenu-classic menu-submenu-right">
														<ul class="menu-subnav">
															<li class="menu-item" aria-haspopup="true">
																<a href="javascript:;" class="menu-link">
																	<i class="menu-bullet menu-bullet-dot">
																		<span></span>
																	</i>
																	<span class="menu-text">Add Team Member</span>
																</a>
															</li>
															<li class="menu-item" aria-haspopup="true">
																<a href="javascript:;" class="menu-link">
																	<i class="menu-bullet menu-bullet-dot">
																		<span></span>
																	</i>
																	<span class="menu-text">Edit Team Member</span>
																</a>
															</li>
															<li class="menu-item" aria-haspopup="true">
																<a href="javascript:;" class="menu-link">
																	<i class="menu-bullet menu-bullet-dot">
																		<span></span>
																	</i>
																	<span class="menu-text">Delete Team Member</span>
																</a>
															</li>
															<li class="menu-item" aria-haspopup="true">
																<a href="javascript:;" class="menu-link">
																	<i class="menu-bullet menu-bullet-dot">
																		<span></span>
																	</i>
																	<span class="menu-text">Team Member Reports</span>
																</a>
															</li>
															<li class="menu-item" aria-haspopup="true">
																<a href="javascript:;" class="menu-link">
																	<i class="menu-bullet menu-bullet-dot">
																		<span></span>
																	</i>
																	<span class="menu-text">Assign Tasks</span>
																</a>
															</li>
															<li class="menu-item" aria-haspopup="true">
																<a href="javascript:;" class="menu-link">
																	<i class="menu-bullet menu-bullet-dot">
																		<span></span>
																	</i>
																	<span class="menu-text">Promote Team Member</span>
																</a>
															</li>
														</ul>
													</div>
												</li>
											</ul>
										</div>
									</li>
								</ul>
							</div>
						</div>
						<div id="kt_quick_user" class="offcanvas offcanvas-right p-10">
							<div class="offcanvas-header d-flex align-items-center justify-content-between pb-5">
								<h3 class="font-weight-bold m-0" style="color:black;">User Profile
								</h3>
								<a href="#" class="btn btn-xs btn-icon btn-light btn-hover-primary" id="kt_quick_user_close">
									<i class="ki ki-close icon-xs text-muted"></i>
								</a>
							</div>
							<div class="offcanvas-content pr-5 mr-n5">
								<div class="d-flex align-items-center mt-5" style="align-items: flex-start !important;">
									<div class="symbol symbol-100 mr-5">

										<?php
										$vurlfoto= "assets/media/users/300_21.jpg";
										if(file_exists(public_path()."/uploads/foto_pegawai/"."ssss" .".png"))
										{
											$vurlfoto= "uploads/foto_pegawai/"."ssss" .".png";
										}
										?>
										<div class="symbol-label" style="background-image:url('<?=$vurlfoto?>')"></div>
										<i class="symbol-badge bg-success"></i>
									</div>
									<div class="d-flex flex-column">
										<a href="#" class="font-weight-bold font-size-h5 text-dark-75 text-hover-primary">{{$user->nama}}
										</a>
										<div class="text-muted mt-1"></div>
										
										<div class="navi mt-2">
											<a href="javascript:void(0)" class="navi-item">
												<span class="navi-link p-0 pb-2">
													<span class="navi-icon mr-1">
														<span class="svg-icon svg-icon-lg svg-icon-primary">
															<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
																<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
																	<rect x="0" y="0" width="24" height="24" />
																	<path d="M21,12.0829584 C20.6747915,12.0283988 20.3407122,12 20,12 C16.6862915,12 14,14.6862915 14,18 C14,18.3407122 14.0283988,18.6747915 14.0829584,19 L5,19 C3.8954305,19 3,18.1045695 3,17 L3,8 C3,6.8954305 3.8954305,6 5,6 L19,6 C20.1045695,6 21,6.8954305 21,8 L21,12.0829584 Z M18.1444251,7.83964668 L12,11.1481833 L5.85557487,7.83964668 C5.4908718,7.6432681 5.03602525,7.77972206 4.83964668,8.14442513 C4.6432681,8.5091282 4.77972206,8.96397475 5.14442513,9.16035332 L11.6444251,12.6603533 C11.8664074,12.7798822 12.1335926,12.7798822 12.3555749,12.6603533 L18.8555749,9.16035332 C19.2202779,8.96397475 19.3567319,8.5091282 19.1603533,8.14442513 C18.9639747,7.77972206 18.5091282,7.6432681 18.1444251,7.83964668 Z" fill="#000000" />
																	<circle fill="#000000" opacity="0.3" cx="19.5" cy="17.5" r="2.5" />
																</g>
															</svg>
														</span>
													</span>
													<span class="navi-text text-muted text-hover-primary"></span>
												</span>
											</a>
										</div>

										<div class="navi mt-2">
											<span id="prosesupload" style="display: none;">
												<form class="formadd" id="ktheaderformisi" method="POST" enctype="multipart/form-data" autocomplete="off">
													<?php
													$accept= ".jpg,.jpeg,.png" ;
													?>
													<input id="reqFile" class="" name="reqLinkFile" type="file" maxlength="10" class="multi maxsize-10240 MultiFile-applied" accept="{{$accept}}" >
													<button onclick="setsimpanfoto()" class="btn btn-sm btn-light-warning font-weight-bolder">Save</button>
													<button onclick="setfoto('')" class="btn btn-sm btn-light-warning font-weight-bolder">Batal</button>
													<?php
													$setdisplaylogout= "";
													if(!empty($user->sso_urllogout))
													{
														$setdisplaylogout= "none";
													?>
													<a href="javascript:void(0)" onclick="logoutsso()" class="btn btn-sm btn-light-primary font-weight-bolder">Sign Out</a>
													<?php
													}
													?>

													<form action="/app/logout" method="POST" id="nossologout" style="display: <?=$setdisplaylogout?>" >
														 @csrf
														 <button  class="btn btn-sm btn-light-primary font-weight-bolder">Sign Out</button>
													</form>
												</form>
											</span>
											<span id="awalupload">
												<div class="row">
													<!-- <button onclick="setfoto(1)" class="btn btn-sm btn-light-warning font-weight-bolder">Ubah Foto</button> -->
													<?php
													$setdisplaylogout= "";
													if(!empty($user->sso_urllogout))
													{
														$setdisplaylogout= "none";
													?>
													<a href="javascript:void(0)" onclick="logoutsso()" class="btn btn-sm btn-light-primary font-weight-bolder">Sign Out</a>
													<?php
													}
													?>

													<form action="/app/logout" method="POST" id="nossologout" style="display: <?=$setdisplaylogout?>" >
														 @csrf
														 <button  class="btn btn-sm btn-light-primary font-weight-bolder">Sign Out</button>
													</form>
												</div>
											</span>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="topbar">
							<div class="topbar-item">
								<div class="btn btn-icon btn-icon-mobile w-auto btn-clean d-flex align-items-center btn-lg px-2" id="kt_quick_user_toggle">
									<span class="font-weight-bold font-size-base d-none d-md-inline mr-1">Hi,</span>
									<span class="font-weight-bolder font-size-base d-none d-md-inline mr-3">{{$user->nama}}</span>
									<!-- <span class="symbol symbol-lg-35 symbol-25 symbol-light-success">
										<span class="symbol-label font-size-h5 font-weight-bold">S</span>
									</span> -->
								</div>
							</div>
						</div>
					</div>
				</div>
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
	            eModal.iframe(page, 'Aplikasi Assesment | BPS')
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