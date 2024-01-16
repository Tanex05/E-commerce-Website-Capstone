<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <meta name="csrf-token" content="{{ csrf_token() }}" />

  <title>General Dashboards &mdash; Technoblast</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="{{ asset('Backend/assets/modules/bootstrap/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('Backend/assets/modules/fontawesome/css/all.min.css') }}">

  <!-- CSS Libraries -->
  <link rel="stylesheet" href="{{ asset('Backend/assets/modules/jqvmap/dist/jqvmap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('Backend/assets/modules/weather-icon/css/weather-icons.min.css') }}">
  <link rel="stylesheet" href="{{ asset('Backend/assets/modules/weather-icon/css/weather-icons-wind.min.css') }}">
  <link rel="stylesheet" href="{{ asset('Backend/assets/modules/summernote/summernote-bs4.css') }}">
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
  <link rel="stylesheet" href="//cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">

  <!-- Template CSS -->
  <link rel="stylesheet" href="{{ asset('Backend/assets/css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('Backend/assets/css/components.css') }}">

<!-- Start GA -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-94034622-3"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-94034622-3');
</script>
<!-- /END GA --></head>

<body>
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      <div class="navbar-bg"></div>

      <!-- Navbar Content -->
      @include('Staff.layouts.navbar')

      <!-- Sidebar Content -->
      @include('Staff.layouts.sidebar')

      <!-- Main Content -->
      <div class="main-content">
        @yield('content')
      </div>

      <footer class="main-footer">
        <div class="footer-left">
          Copyright &copy; 2024 <div class="bullet"></div> Design By <a href="https://nauval.in/">Montano L. Kiseo III</a>
        </div>
        <div class="footer-right">
        </div>
      </footer>
    </div>
  </div>

  <!-- General JS Scripts -->
  <script src="{{ asset('Backend/assets/modules/jquery.min.js') }}"></script>
  <script src="{{ asset('Backend/assets/modules/popper.js') }}"></script>
  <script src="{{ asset('Backend/assets/modules/tooltip.js') }}"></script>
  <script src="{{ asset('Backend/assets/modules/bootstrap/js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('Backend/assets/modules/nicescroll/jquery.nicescroll.min.js') }}"></script>
  <script src="{{ asset('Backend/assets/modules/moment.min.js') }}"></script>
  <script src="{{ asset('Backend/assets/js/stisla.js') }}"></script>

  <!-- JS Libraies -->
  <script src="{{ asset('Backend/assets/modules/simple-weather/jquery.simpleWeather.min.js') }}"></script>
  <script src="{{ asset('Backend/assets/modules/chart.min.js') }}"></script>
  <script src="{{ asset('Backend/assets/modules/jqvmap/dist/jquery.vmap.min.js') }}"></script>
  <script src="{{ asset('Backend/assets/modules/jqvmap/dist/maps/jquery.vmap.world.js') }}"></script>
  <script src="{{ asset('Backend/assets/modules/summernote/summernote-bs4.js') }}"></script>
  <script src="{{ asset('Backend/assets/modules/chocolat/dist/js/jquery.chocolat.min.js') }}"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
  <script src="//cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <!-- Page Specific JS File -->
  <script src="{{ asset('Backend/assets/js/page/index-0.js') }}"></script>

  <!-- Template JS File -->
  <script src="{{ asset('Backend/assets/js/scripts.js') }}"></script>
  <script src="{{ asset('Backend/assets/js/custom.js') }}"></script>

  <!-- Dynamic Delete Alert -->
  <script>
    $(document).ready(function(){
        // This function runs when the document (webpage) has finished loading

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('body').on('click', '.delete-item', function(event){
            // This sets up a click event listener for elements with the class 'delete-item' in the body of the HTML

            event.preventDefault();
            // This prevents the default behavior of the clicked element, which is often navigating to a new page

            let deleteUrl = $(this).attr('href');
            // This gets the value of the 'href' attribute of the clicked element and stores it in the variable 'deleteUrl'

            Swal.fire({
                // This initializes a pop-up modal using the SweetAlert (Swal) library
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                // This uses a promise to execute code after the user interacts with the modal
                if (result.isConfirmed) {
                    // If the user clicks the confirmation button in the modal

                    $.ajax({
                        // This initiates an AJAX request to the server
                        type: 'DELETE', // The type of request is DELETE
                        url: deleteUrl, // The URL where the DELETE request will be sent
                        success: function(data) {
                            // This function is executed if the server responds successfully
                            console.log(data); // This logs the server's response to the console

                            Swal.fire({
                                // This initializes another pop-up modal using SweetAlert
                                title: "Deleted!",
                                text: "Your file has been deleted.",
                                icon: "success"
                            });
                        },
                        error: function(xhr, status, error) {
                            // This function is executed if there is an error in the AJAX request
                            console.log(error); // This logs the error to the console
                        }
                    });
                }
            });
        });
    });

  </script>

  <!-- Notification Error -->
  <script>
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            toastr.error("{{ $error }}")
        @endforeach
    @endif
  </script>

  @stack('scripts')

</body>
</html>
