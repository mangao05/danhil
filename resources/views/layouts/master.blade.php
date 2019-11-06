
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="user-id" content="{{ Auth::user()->id }}">
  <title>DANHIL ENT.</title>

  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
  
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper" id="app">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="index3.html" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="index3.html" class="nav-link">=></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li>
    </ul>


    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#"><i class="fas fa-th-large"></i></a>
        </li>
      </ul>
    
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="{{  asset('img/sewer.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">DANHIL ENT.</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ asset('img/boy.png') }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{Auth::user()->firstname}} {{Auth::user()->lastname}}</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          
          <li class="nav-item">
            <router-link to="home" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </router-link>
          </li>
          @can(1)
          <li class="nav-item">
            <router-link to="/user" class="nav-link">
              <i class="nav-icon fas fa-users"></i>
              <p>
                User
              </p>
            </router-link>
          </li>
          @endcan
          
          @can(2)
          <li class="nav-item">
            <router-link to="/position" class="nav-link">
              <i class="nav-icon fas fa-user-tag"></i>
              <p>
                Position
              </p>
            </router-link>
          </li>
          @endcan
          @can(3)
          <li class="nav-item">
            <router-link to="/customer" class="nav-link">
              <i class="nav-icon fas fa-user-tag"></i>
              <p>
                Customer
              </p>
            </router-link>
          </li> 
          @endcan

          @can(4)
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Inventory
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              
              <li class="nav-item">
                <router-link to="/product" class="nav-link">
                  <span class="nav-icon ml-4"><img style="width:25px;" src="http://bestanimations.com/Signs&Shapes/Arrows/Right/right-arrow-4.gif" alt=""></span>
                  <p>Item</p>
                </router-link>
              </li>

              <li class="nav-item">
                <router-link to="/package" class="nav-link">
                  <span class="nav-icon ml-4"><img style="width:25px;" src="http://bestanimations.com/Signs&Shapes/Arrows/Right/right-arrow-4.gif" alt=""></span>
                  <p>Package</p>
                </router-link>
              </li>

            </ul> 
          </li>
          @endcan

          <li class="nav-item">
            <router-link to="/test" class="nav-link">
              <i class="nav-icon fas fa-book"></i>
              <p>
                Report
              </p>
            </router-link>
          </li> 

          @can(5)
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-file"></i>
              <p>
                Order
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              
              <li class="nav-item">
                <router-link to="/newOrder" class="nav-link">
                  <span class="nav-icon ml-4"><img style="width:25px;" src="http://bestanimations.com/Signs&Shapes/Arrows/Right/right-arrow-4.gif" alt=""></span>
                  <p>New Order</p>
                </router-link>
              </li>

              <li class="nav-item">
                <router-link to="/orders" class="nav-link">
                  <span class="nav-icon ml-4"><img style="width:25px;" src="http://bestanimations.com/Signs&Shapes/Arrows/Right/right-arrow-4.gif" alt=""></span>
                  <p>Order list</p>
                </router-link>
              </li>

              <li class="nav-item">
                <router-link to="/listOfOrder" class="nav-link">
                  <span class="nav-icon ml-4"><img style="width:25px;" src="http://bestanimations.com/Signs&Shapes/Arrows/Right/right-arrow-4.gif" alt=""></span>
                  <p>Orders</p>
                </router-link>
              </li>

            </ul> 
          </li>
          @endcan

          <li class="nav-item">
            <router-link to="/collections" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Collections
              </p>
            </router-link>
          </li> 

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            {{-- <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Starter Page</li>
            </ol> --}}
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
          <router-view></router-view>
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
        
            <a href="{{ route('logout') }}"
               onclick="event.preventDefault();
                             document.getElementById('logout-form').submit();">
                {{ __('Logout') }}
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        
    </div>
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
      Anything you want
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2014-2019 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="{{ asset('js/app.js') }}"></script>

</body>
</html>
