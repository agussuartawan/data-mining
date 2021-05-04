<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>{{ config('app.name') }}</title>
  <link href="{{asset('')}}vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="{{asset('')}}vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="{{asset('')}}css/ruang-admin.min.css" rel="stylesheet">
  <link href="{{asset('')}}vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{asset('')}}vendor/select2/dist/css/select2.min.css">
  <link rel="stylesheet" type="text/css" href="{{asset('')}}vendor/toastr/toastr.min.css">
  @stack('styles')
</head>

<body id="page-top">
  <div id="wrapper">
    <!-- Sidebar -->
    @include('partials.sidebar')
    <!-- Sidebar -->
    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        <!-- TopBar -->
        @include('partials.topbar')
        <!-- Topbar -->

        <!-- Container Fluid-->
        <div class="container-fluid" id="container-wrapper">          
          {{-- main content --}}
          @yield('content')

          <!-- Modal Logout -->
          @include('partials.modal-logout')
        </div>
        <!---Container Fluid-->

      </div>
      <!-- Footer -->
      @include('partials.footer')
      <!-- Footer -->
    </div>
  </div>

  <!-- Scroll to top -->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <script src="{{asset('')}}vendor/jquery/jquery.min.js"></script>
  <script src="{{asset('')}}vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="{{asset('')}}vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="{{asset('')}}js/ruang-admin.min.js"></script>
  <script src="{{asset('')}}vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="{{asset('')}}vendor/datatables/dataTables.bootstrap4.min.js"></script>
  <script src="{{asset('')}}vendor/select2/dist/js/select2.min.js"></script>
  <script src="{{asset('')}}vendor/toastr/toastr.min.js"></script>
  @stack('scripts')  
</body>

</html>