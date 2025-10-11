<!DOCTYPE html>
<html lang="en">

<head>

	<!-- Meta Tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	{{-- use title that is passed from blade --}}
	<title>@yield('title', 'Dashboard') | Unified Payment Portal</title>	
	
	<meta name="description" content="Unified Payment Portal">
	<meta name="robots" content="index, follow">

	<!-- Apple Touch Icon -->
	<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('admin/assets/img/apple-touch-icon.png') }}">

	<!-- Favicon -->
	<link rel="icon" href="{{ asset('admin/assets/img/favicon.png') }}" type="image/x-icon">
	<link rel="shortcut icon" href="{{ asset('admin/assets/img/favicon.png') }}" type="image/x-icon">

	<!-- Theme Script js -->
	<script>
		// Make asset URL available to JavaScript
		window.assetUrl = "{{ asset('admin/assets') }}";
	</script>
	<script src="{{ asset('admin/assets/js/theme-script.js') }}"></script>

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="{{ asset('admin/assets/css/bootstrap.min.css') }}">

	<!-- Feather CSS -->
	<link rel="stylesheet" href="{{ asset('admin/assets/plugins/icons/feather/feather.css') }}">

	<!-- Tabler Icon CSS -->
    <link rel="stylesheet" href="{{ asset('admin/assets/plugins/tabler-icons/tabler-icons.min.css') }}">

	<!-- Select2 CSS -->
	<link rel="stylesheet" href="{{ asset('admin/assets/plugins/select2/css/select2.min.css') }}">

	<!-- Fontawesome CSS -->
	<link rel="stylesheet" href="{{ asset('admin/assets/plugins/fontawesome/css/fontawesome.min.css') }}">
	<link rel="stylesheet" href="{{ asset('admin/assets/plugins/fontawesome/css/all.min.css') }}">

	<!-- Datetimepicker CSS -->
	<link rel="stylesheet" href="{{ asset('admin/assets/css/bootstrap-datetimepicker.min.css') }}">

	<!-- Bootstrap Tagsinput CSS -->
	<link rel="stylesheet" href="{{ asset('admin/assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css') }}">

	<!-- Summernote CSS -->
	<link rel="stylesheet" href="{{ asset('admin/assets/plugins/summernote/summernote-lite.min.css') }}">

	<!-- Daterangepikcer CSS -->
	<link rel="stylesheet" href="{{ asset('admin/assets/plugins/daterangepicker/daterangepicker.css') }}">

	<!-- Color Picker Css -->
	<link rel="stylesheet" href="{{ asset('admin/assets/plugins/flatpickr/flatpickr.min.css') }}">
	<link rel="stylesheet" href="{{ asset('admin/assets/plugins/@simonwep/pickr/themes/nano.min.css') }}">

	<!-- Main CSS -->
	<link rel="stylesheet" href="{{ asset('admin/assets/css/style.css') }}">

	<!-- DataTables CSS (Optional - Include in specific pages) -->
	@stack('styles')

</head>

<body>

	{{-- <div id="global-loader">
		<div class="page-loader"></div>
	</div> --}}

	<!-- Main Wrapper -->
	<div class="main-wrapper">