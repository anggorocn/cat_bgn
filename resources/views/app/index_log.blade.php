<!DOCTYPE html>
<html lang="en">
	<!--begin::Head-->
	<head>
		<base href="{{ asset('/') }}">
		<meta charset="utf-8" />
		<meta name="description" content="Basic datatables examples" />
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
		<meta name="csrf_token" content="{{ csrf_token() }}" />
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
		<link rel="shortcut icon" href="images/logo-title.png" />

		<script src="assets/plugins/global/plugins.bundle.js"></script>
		<script src="assets/plugins/custom/prismjs/prismjs.bundle.js"></script>
		<script src="assets/js/scripts.bundle.js"></script>
		<!--end::Global Theme Bundle-->
		<!--begin::Page Vendors(used by this page)-->
		<script src="assets/plugins/custom/datatables/datatables.bundle.js"></script>
		<!--end::Page Vendors-->
		<!--begin::Page Scripts(used by this page)-->
		<script src="assets/js/pages/crud/datatables/data-sources/valsix-serverside.js"></script>
		<script src="assets/js/pages/widgets.js"></script>
		<script src="assets/plugins/custom/jstree/jstree.bundle.js"></script>

		<!-- select multi -->
		<script src="assets/js/pages/crud/forms/widgets/select2.js"></script>
		<!-- <link href="assets/select2/select2.min.css" rel="stylesheet" />
		<script src="assets/select2/select2.min.js"></script> -->
		<link href="assets/select2totreemaster/src/select2totree.css" rel="stylesheet">
		<script src="assets/select2totreemaster/src/select2totree.js"></script>
		
		<script type="text/javascript">
			$(document).ready(function() {
				$('.jscaribasicmultiple').select2();
			});
		</script>

		<!-- FONT AWESOME -->
    	<link rel="stylesheet" href="assets/font-awesome-4.7.0/css/font-awesome.css" type="text/css">

    	<link rel="stylesheet" href="assets/froala_editor_2.9.8/css/froala_editor.css">
		<link rel="stylesheet" href="assets/froala_editor_2.9.8/css/froala_style.css">
		<link rel="stylesheet" href="assets/froala_editor_2.9.8/css/plugins/code_view.css">
		<link rel="stylesheet" href="assets/froala_editor_2.9.8/css/plugins/draggable.css">
		<link rel="stylesheet" href="assets/froala_editor_2.9.8/css/plugins/colors.css">
		<link rel="stylesheet" href="assets/froala_editor_2.9.8/css/plugins/emoticons.css">
		<link rel="stylesheet" href="assets/froala_editor_2.9.8/css/plugins/image_manager.css">
		<link rel="stylesheet" href="assets/froala_editor_2.9.8/css/plugins/image.css">
		<link rel="stylesheet" href="assets/froala_editor_2.9.8/css/plugins/line_breaker.css">
		<link rel="stylesheet" href="assets/froala_editor_2.9.8/css/plugins/table.css">
		<link rel="stylesheet" href="assets/froala_editor_2.9.8/css/plugins/char_counter.css">
		<link rel="stylesheet" href="assets/froala_editor_2.9.8/css/plugins/video.css">
		<link rel="stylesheet" href="assets/froala_editor_2.9.8/css/plugins/fullscreen.css">
		<link rel="stylesheet" href="assets/froala_editor_2.9.8/css/plugins/file.css">
		<link rel="stylesheet" href="assets/froala_editor_2.9.8/css/plugins/quick_insert.css">
		<link rel="stylesheet" href="assets/froala_editor_2.9.8/css/plugins/help.css">
		<link rel="stylesheet" href="assets/froala_editor_2.9.8/css/third_party/spell_checker.css">
		<link rel="stylesheet" href="assets/froala_editor_2.9.8/css/plugins/special_characters.css">
		<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/codemirror.min.css"> -->
		<link rel="stylesheet" href="assets/codemirror/5.3.0/codemirror.min.css">

		<script type="text/javascript" src="assets/froala_editor_2.9.8/js/froala_editor.min.js" ></script>
		<script type="text/javascript" src="assets/froala_editor_2.9.8/js/plugins/align.min.js"></script>
		<script type="text/javascript" src="assets/froala_editor_2.9.8/js/plugins/char_counter.min.js"></script>
		<script type="text/javascript" src="assets/froala_editor_2.9.8/js/plugins/code_beautifier.min.js"></script>
		<script type="text/javascript" src="assets/froala_editor_2.9.8/js/plugins/code_view.min.js"></script>
		<script type="text/javascript" src="assets/froala_editor_2.9.8/js/plugins/colors.min.js"></script>
		<script type="text/javascript" src="assets/froala_editor_2.9.8/js/plugins/draggable.min.js"></script>
		<script type="text/javascript" src="assets/froala_editor_2.9.8/js/plugins/emoticons.min.js"></script>
		<script type="text/javascript" src="assets/froala_editor_2.9.8/js/plugins/entities.min.js"></script>
		<script type="text/javascript" src="assets/froala_editor_2.9.8/js/plugins/file.min.js"></script>
		<script type="text/javascript" src="assets/froala_editor_2.9.8/js/plugins/font_size.min.js"></script>
		<script type="text/javascript" src="assets/froala_editor_2.9.8/js/plugins/font_family.min.js"></script>
		<script type="text/javascript" src="assets/froala_editor_2.9.8/js/plugins/fullscreen.min.js"></script>
		<script type="text/javascript" src="assets/froala_editor_2.9.8/js/plugins/image.min.js"></script>
		<script type="text/javascript" src="assets/froala_editor_2.9.8/js/plugins/image_manager.min.js"></script>
		<script type="text/javascript" src="assets/froala_editor_2.9.8/js/plugins/line_breaker.min.js"></script>
		<script type="text/javascript" src="assets/froala_editor_2.9.8/js/plugins/inline_style.min.js"></script>
		<script type="text/javascript" src="assets/froala_editor_2.9.8/js/plugins/link.min.js"></script>
		<script type="text/javascript" src="assets/froala_editor_2.9.8/js/plugins/lists.min.js"></script>
		<script type="text/javascript" src="assets/froala_editor_2.9.8/js/plugins/paragraph_format.min.js"></script>
		<script type="text/javascript" src="assets/froala_editor_2.9.8/js/plugins/paragraph_style.min.js"></script>
		<script type="text/javascript" src="assets/froala_editor_2.9.8/js/plugins/quick_insert.min.js"></script>
		<script type="text/javascript" src="assets/froala_editor_2.9.8/js/plugins/quote.min.js"></script>
		<script type="text/javascript" src="assets/froala_editor_2.9.8/js/plugins/table.min.js"></script>
		<script type="text/javascript" src="assets/froala_editor_2.9.8/js/plugins/save.min.js"></script>
		<script type="text/javascript" src="assets/froala_editor_2.9.8/js/plugins/url.min.js"></script>
		<script type="text/javascript" src="assets/froala_editor_2.9.8/js/plugins/video.min.js"></script>
		<script type="text/javascript" src="assets/froala_editor_2.9.8/js/plugins/help.min.js"></script>
		<script type="text/javascript" src="assets/froala_editor_2.9.8/js/plugins/print.min.js"></script>
		<script type="text/javascript" src="assets/froala_editor_2.9.8/js/third_party/spell_checker.min.js"></script>
		<script type="text/javascript" src="assets/froala_editor_2.9.8/js/plugins/special_characters.min.js"></script>
		<script type="text/javascript" src="assets/froala_editor_2.9.8/js/plugins/word_paste.min.js"></script>

		<!-- VALSIX -->
		<link href="assets/css/gaya.css" rel="stylesheet" type="text/css" />
	
	</head>
	<!--end::Head-->
	<!--begin::Body-->
	<body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading">

		<div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper" style="padding-left: 0px;padding-top: 0px">
			<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
				@yield('content')
			</div>
		</div>


		<!-- <script>var HOST_URL = "https://preview.keenthemes.com/metronic/theme/html/tools/preview";</script> -->
		<!--begin::Global Config(global config for global JS scripts)-->
		<script>var KTAppSettings = { "breakpoints": { "sm": 576, "md": 768, "lg": 992, "xl": 1200, "xxl": 1400 }, "colors": { "theme": { "base": { "white": "#ffffff", "primary": "#3699FF", "secondary": "#E5EAEE", "success": "#1BC5BD", "info": "#8950FC", "warning": "#FFA800", "danger": "#F64E60", "light": "#E4E6EF", "dark": "#181C32" }, "light": { "white": "#ffffff", "primary": "#E1F0FF", "secondary": "#EBEDF3", "success": "#C9F7F5", "info": "#EEE5FF", "warning": "#FFF4DE", "danger": "#FFE2E5", "light": "#F3F6F9", "dark": "#D6D6E0" }, "inverse": { "white": "#ffffff", "primary": "#ffffff", "secondary": "#3F4254", "success": "#ffffff", "info": "#ffffff", "warning": "#ffffff", "danger": "#ffffff", "light": "#464E5F", "dark": "#ffffff" } }, "gray": { "gray-100": "#F3F6F9", "gray-200": "#EBEDF3", "gray-300": "#E4E6EF", "gray-400": "#D1D3E0", "gray-500": "#B5B5C3", "gray-600": "#7E8299", "gray-700": "#5E6278", "gray-800": "#3F4254", "gray-900": "#181C32" } }, "font-family": "Poppins" };</script>
		<!--end::Global Config-->
		<!--begin::Global Theme Bundle(used by all pages)-->

		

		<!--end::Page Scripts-->
	</body>
	<!--end::Body-->
</html>