<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">    

    <!-- Bootstrap css-->
	<link  id="style" href="/assetsSp/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet"/>

    <!-- Icons css-->
    <link href="/assetsSp/plugins/web-fonts/icons.css" rel="stylesheet" />
    <link href="/assetsSp/plugins/web-fonts/font-awesome/font-awesome.min.css" rel="stylesheet">
    <link href="/assetsSp/plugins/web-fonts/plugin.css" rel="stylesheet" />

    <!-- Style css-->
    <link href="/assetsSp/css/style.css" rel="stylesheet">

    <!-- Select2 css-->
    <link href="/assetsSp/plugins/select2/css/select2.min.css" rel="stylesheet">

    <!-- Mutipleselect css-->
    <link rel="stylesheet" href="/assetsSp/plugins/multipleselect/multiple-select.css">
    <title></title>
    <script type='text/javascript'>
      window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
</head>
<body>
<div id="app"></div>
<!-- Back-to-top -->
<a href="#top" id="back-to-top"><i class="fe fe-arrow-up"></i></a>
<script src="{{ asset('js/main.js') }}"></script>
<script type="text/javascript" language="javascript" src="{{ asset('qrcode.min.js') }}"></script>
<!-- Jquery js-->
<script src="/assetsSp/plugins/jquery/jquery.min.js"></script>

<!-- Bootstrap js-->
<script src="/assetsSp/plugins/bootstrap/js/popper.min.js"></script>
<script src="/assetsSp/plugins/bootstrap/js/bootstrap.min.js"></script>

<!-- Internal Chart.Bundle js-->
<script src="/assetsSp/plugins/chart.js/Chart.bundle.min.js"></script>

<!-- Peity js-->
<script src="/assetsSp/plugins/peity/jquery.peity.min.js"></script>

<!-- Select2 js-->
<script src="/assetsSp/plugins/select2/js/select2.min.js"></script>
<script src="/assetsSp/js/select2.js"></script>

<!-- Perfect-scrollbar js -->
<script src="/assetsSp/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>

<!-- Sidemenu js -->
<script src="/assetsSp/plugins/sidemenu/sidemenu.js"></script>

<!-- Sidebar js -->
<script src="/assetsSp/plugins/sidebar/sidebar.js"></script>

<!-- Internal Morris js -->
<script src="/assetsSp/plugins/raphael/raphael.min.js"></script>
<script src="/assetsSp/plugins/morris.js/morris.min.js"></script>

<!-- Circle Progress js-->
<script src="/assetsSp/js/circle-progress.min.js"></script>
<script src="/assetsSp/js/chart-circle.js"></script>

<!-- Internal Dashboard js-->
<script src="/assetsSp/js/index.js"></script>

<!-- Color Theme js -->
<script src="/assetsSp/js/themeColors.js"></script>

<!-- Sticky js -->
<script src="/assetsSp/js/sticky.js"></script>

<!-- Custom js -->
<script src="/assetsSp/js/custom.js"></script>
</body>
</html>