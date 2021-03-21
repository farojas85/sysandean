<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>Principal | Andean</title>
  @include('layouts.partials.header')
</head>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper" id="wrapper">
    <!-- Navbar -->
    @include('layouts.partials.navbar')
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    @include('layouts.partials.sidebar')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      @yield('content-header')
      <!-- /.content-header -->

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          @yield('content')
        </div><!-- /.container-fluid -->
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    @include('layouts.partials.footer')
    <!-- Control Sidebar -->
    @include('layouts.partials.asidebar')
    <!-- /.control-sidebar -->
    @include('layouts.partials.modals')
  </div>
  <!-- ./wrapper -->
  @include('layouts.partials.script')
</body>

</html>