<!DOCTYPE html>
<html lang="en">

<head>
    <title>@yield('seo_title', 'TechnoBlast')</title>
    <meta name="description" content="@yield('description')">
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no, target-densityDpi=device-dpi" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    @php
        $settings = \App\Models\FooterInfo::first();
        $favicon = $settings ? $settings->favicon : ''; // Check if $settings is not null before accessing properties
    @endphp
    
    @if ($favicon)
        <link rel="icon" type="image/png" href="{{ asset($favicon) }}">
    @endif

    <link rel="stylesheet" href="{{ asset('Frontend/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('Frontend/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('Frontend/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('Frontend/css/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('Frontend/css/jquery.nice-number.min.css') }}">
    <link rel="stylesheet" href="{{ asset('Frontend/css/jquery.calendar.css') }}">
    <link rel="stylesheet" href="{{ asset('Frontend/css/add_row_custon.css') }}">
    <link rel="stylesheet" href="{{ asset('Frontend/css/mobile_menu.css') }}">
    <link rel="stylesheet" href="{{ asset('Frontend/css/jquery.exzoom.css') }}">
    <link rel="stylesheet" href="{{ asset('Frontend/css/multiple-image-video.css') }}">
    <link rel="stylesheet" href="{{ asset('Frontend/css/ranger_style.css') }}">

    <link rel="stylesheet" href="{{ asset('Frontend/css/jquery.classycountdown.css') }}">
    <link rel="stylesheet" href="{{ asset('Frontend/css/venobox.min.css') }}">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">


    <link rel="stylesheet" href="{{ asset('Frontend/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('Frontend/css/responsive.css') }}">
    <!-- <link rel="stylesheet" href="css/rtl.css"> -->
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">

</head>

<body>

    <!--============================
        HEADER START
    ==============================-->

        @include('frontend.layouts.header')

    <!--============================
        HEADER END
    ==============================-->


    <!--============================
        MAIN MENU START
    ==============================-->

        @include('frontend.layouts.menu')

    <!--============================
        MAIN MENU END
    ==============================-->

    <!--==========================
        Main Content Start
    ===========================-->

        @yield('content')

    <!--==========================
        Main Content End
    ===========================-->


    <!--============================
        FOOTER PART START
    ==============================-->

        @include('frontend.layouts.footer')

    <!--============================
        FOOTER PART END
    ==============================-->


    <!--============================
        SCROLL BUTTON START
    ==============================-->
    <div class="wsus__scroll_btn">
        <i class="fas fa-chevron-up"></i>
    </div>
    <!--============================
        SCROLL BUTTON  END
    ==============================-->


    <!--jquery library js-->
    <script src="{{ asset('Frontend/js/jquery-3.6.0.min.js') }}"></script>
    <!--bootstrap js-->
    <script src="{{ asset('Frontend/js/bootstrap.bundle.min.js') }}"></script>
    <!--font-awesome js-->
    <script src="{{ asset('Frontend/js/Font-Awesome.js') }}"></script>
    <!--select2 js-->
    <script src="{{ asset('Frontend/js/select2.min.js') }}"></script>
    <!--slick slider js-->
    <script src="{{ asset('Frontend/js/slick.min.js') }}"></script>
    <!--simplyCountdown js-->
    <script src="{{ asset('Frontend/js/simplyCountdown.js') }}"></script>
    <!--product zoomer js-->
    <script src="{{ asset('Frontend/js/jquery.exzoom.js') }}"></script>
    <!--nice-number js-->
    <script src="{{ asset('Frontend/js/jquery.nice-number.min.js') }}"></script>
    <!--counter js-->
    <script src="{{ asset('Frontend/js/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('Frontend/js/jquery.countup.min.js') }}"></script>
    <!--add row js-->
    <script src="{{ asset('Frontend/js/add_row_custon.js') }}"></script>
    <!--multiple-image-video js-->
    <script src="{{ asset('Frontend/js/multiple-image-video.js') }}"></script>
    <!--sticky sidebar js-->
    <script src="js/sticky_sidebar.js"></script>
    <!--price ranger js-->
    <script src="{{ asset('Frontend/js/ranger_jquery-ui.min.js') }}"></script>
    <script src="{{ asset('Frontend/js/ranger_slider.js') }}"></script>
    <!--isotope js-->
    <script src="{{ asset('Frontend/js/isotope.pkgd.min.js') }}"></script>
    <!--venobox js-->
    <script src="{{ asset('Frontend/js/venobox.min.js') }}"></script>
    <!--classycountdown js-->
    <script src="{{ asset('Frontend/js/jquery.classycountdown.js') }}"></script>
    <!--Toastr js-->
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <!--Sweetalert js-->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <!--main/custom js-->
    <script src="{{ asset('Frontend/js/main.js') }}"></script>


    <!--Twakto js-->
    @auth
        <script src="{{ asset('Frontend/js/tawkto.js') }}"></script>
    @endauth

    <script src="//cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>


      <!-- Notification Error -->
    <script>
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                toastr.error("{{ $error }}")
            @endforeach
        @endif
    </script>

    @include('frontend.layouts.scripts')
    @stack('scripts')
</body>

</html>

