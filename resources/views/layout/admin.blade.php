<!DOCTYPE html>
<html lang="en">

<head>
    <base href="/public">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- Title -->
<title>MarketMind Investments</title>

<!-- Favicons for different devices -->
<link rel="icon" type="image/png" href="{{ asset('assets/images/mymarketmindmainicon.png') }}" sizes="32x32">
<link rel="icon" type="image/png" href="{{ asset('assets/images/mymarketmindmainicon.png') }}" sizes="192x192">
<link rel="icon" type="image/png" href="{{ asset('assets/images/mymarketmindmainicon.png') }}" sizes="512x512">

<!-- Apple Touch Icon -->
<link rel="apple-touch-icon" href="{{ asset('assets/images/mymarketmindmainicon.png') }}" sizes="180x180">

    <!-- google fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&amp;display=swap" rel="stylesheet">
    <!-- remix icon font css  -->
    <link rel="stylesheet" href="admin_assets/css/remixicon.css">
    <!-- Apex Chart css -->
    <link rel="stylesheet" href="admin_assets/css/lib/apexcharts.css">
    <!-- Data Table css -->
    <link rel="stylesheet" href="admin_assets/css/lib/dataTables.min.css">
    <!-- Text Editor css -->
    <link rel="stylesheet" href="admin_assets/css/lib/editor-katex.min.css">
    <link rel="stylesheet" href="admin_assets/css/lib/editor.atom-one-dark.min.css">
    <link rel="stylesheet" href="admin_assets/css/lib/editor.quill.snow.css">
    <!-- Date picker css -->
    <link rel="stylesheet" href="admin_assets/css/lib/flatpickr.min.css">
    <!-- Calendar css -->
    <link rel="stylesheet" href="admin_assets/css/lib/full-calendar.css">
    <!-- Vector Map css -->
    <link rel="stylesheet" href="admin_assets/css/lib/jquery-jvectormap-2.0.5.css">
    <!-- Popup css -->
    <link rel="stylesheet" href="admin_assets/css/lib/magnific-popup.css">
    <!-- Slick Slider css -->
    <link rel="stylesheet" href="admin_assets/css/lib/slick.css">
    <!-- prism css -->
    <link rel="stylesheet" href="admin_assets/css/lib/prism.css">
    <!-- file upload css -->
    <link rel="stylesheet" href="admin_assets/css/lib/file-upload.css">

    <link rel="stylesheet" href="admin_assets/css/lib/audioplayer.css">
    <!-- main css -->
    <link rel="stylesheet" href="admin_assets/css/style.css">

   

</head>

<body class="dark:bg-neutral-800 bg-neutral-100 dark:text-white">
    @include('snippets.admin_sidebar')

    <main class="dashboard-main">

        @include('snippets.admin_header')
  <div class="pt-[80px]">   @yield('content')</div>
      


            <footer class="d-footer mt-4">
  
            <div class="flex items-center justify-between gap-3">
                <p class="mb-0">© 2024 Market. All Rights Reserved.</p>
                <p class="mb-0">Made by <span class="text-primary-600">MarketMind</span></p>
            </div>
        </footer>

        <style>
            html, body {
    margin: 0;
    padding: 0;
    overflow-x: hidden;
    height: 100%;
}

        </style>
    </main>

    <!-- jQuery library js -->
    <script src="admin_assets/js/lib/jquery-3.7.1.min.js"></script>
    <!-- Apex Chart js -->
    <script src="admin_assets/js/lib/apexcharts.min.js"></script>
    <!-- Data Table js -->
    <script src="admin_assets/js/lib/simple-datatables.min.js"></script>
    <!-- Iconify Font js -->
    <script src="admin_assets/js/lib/iconify-icon.min.js"></script>
    <!-- jQuery UI js -->
    <script src="admin_assets/js/lib/jquery-ui.min.js"></script>
    <!-- Vector Map js -->
    <script src="admin_assets/js/lib/jquery-jvectormap-2.0.5.min.js"></script>
    <script src="admin_assets/js/lib/jquery-jvectormap-world-mill-en.js"></script>
    <!-- Popup js -->
    <script src="admin_assets/js/lib/magnifc-popup.min.js"></script>
    <!-- Slick Slider js -->
    <script src="admin_assets/js/lib/slick.min.js"></script>
    <!-- prism js -->
    <script src="admin_assets/js/lib/prism.js"></script>
    <!-- file upload js -->
    <script src="admin_assets/js/lib/file-upload.js"></script>
    <!-- audioplayer -->
    <script src="admin_assets/js/lib/audioplayer.js"></script>

    <script src="admin_assets/js/flowbite.min.js"></script>
    <!-- main js -->
    <script src="admin_assets/js/app.js"></script>

    <script src="admin_assets/js/homeOneChart.js"></script>

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    @if (session('message'))
    <script>
        swal("Successful!", "{{ session('message') }}!", "success");
    </script>
    @endif
    @if (session('error'))
    <script>
        swal("Error!", "{{ session('error') }}!", "warning");
    </script>
    @endif
    @if (Session::has('success'))
    <script>
        swal("Successful!", "{{ Session::get('success') }}!", "success");
    </script>
    @endif

    @if (Session::has('error'))
    <script>
        swal("Error!", "{{ Session::get('error') }}!", "warning");
    </script>
    @endif

</body>

</html>