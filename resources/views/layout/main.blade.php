<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{$settings->site_title}}</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">
    <meta name="csrf-token" content="{{ csrf_token() }}">
     <!-- Favicon-->
    <link rel="shortcut icon" href="img/favicon.ico">
    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="<?php echo asset('vendor/bootstrap/css/bootstrap.min.css') ?>" type="text/css">
    <link rel="stylesheet" href="<?php echo asset('vendor/bootstrap/css/bootstrap-datepicker.min.css') ?>" type="text/css">
    <link rel="stylesheet" href="<?php echo asset('vendor/bootstrap/css/bootstrap-select.min.css') ?>" type="text/css">
    <!-- Font Awesome CSS-->
    <link rel="stylesheet" href="<?php echo asset('vendor/font-awesome/css/font-awesome.min.css') ?>" type="text/css">
    <!-- Fontastic Custom icon font-->
    <link rel="stylesheet" href="<?php echo asset('css/fontastic.css') ?>" type="text/css">
    <!-- Ion icon font-->
    <link rel="stylesheet" href="<?php echo asset('css/ionicons.min.css') ?>" type="text/css">
    <!-- Google fonts - Roboto -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700">
    <!-- jQuery Circle-->
    <link rel="stylesheet" href="<?php echo asset('css/grasp_mobile_progress_circle-1.0.0.min.css') ?>" type="text/css">
    <!-- Custom Scrollbar-->
    <link rel="stylesheet" href="<?php echo asset('vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.css') ?>" type="text/css">

    <link rel="stylesheet" href="<?php echo asset('vendor/daterange/css/daterangepicker.min.css') ?>" type="text/css">

    <!-- table sorter stylesheet-->
    <link rel="stylesheet" type="text/css" href="<?php echo asset('vendor/datatable/dataTables.bootstrap4.min.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo asset('vendor/datatable/buttons.bootstrap4.min.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo asset('vendor/datatable/select.bootstrap4.min.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo asset('vendor/datatable/dataTables.checkboxes.css') ?>">
    <!-- theme stylesheet-->
    <link rel="stylesheet" href="<?php echo asset('css/style.default.css') ?>" id="theme-stylesheet" type="text/css">
    <!-- Custom stylesheet - for your changes-->
    <link rel="stylesheet" href="<?php echo asset('css/custom.css') ?>" type="text/css">
    <!-- Tweaks for older IEs--><!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->

<script type="text/javascript" src="<?php echo asset('vendor/jquery/jquery.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('vendor/jquery/jquery-ui.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('vendor/jquery/bootstrap-datepicker.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('vendor/popper.js/umd/popper.min.js') ?>">
</script>
<script type="text/javascript" src="<?php echo asset('vendor/bootstrap/js/bootstrap.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('vendor/bootstrap/js/bootstrap-select.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('js/grasp_mobile_progress_circle-1.0.0.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('vendor/jquery.cookie/jquery.cookie.js') ?>">
</script>
<script type="text/javascript" src="<?php echo asset('vendor/chart.js/Chart.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('vendor/jquery-validation/jquery.validate.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js')?>"></script>
<script type="text/javascript" src="<?php echo asset('js/charts-custom.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('js/front.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('vendor/daterange/js/moment.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('vendor/daterange/js/knockout-3.4.2.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('vendor/daterange/js/daterangepicker.min.js') ?>"></script>

<script type="text/javascript" src="<?php echo asset('vendor/datatable/pdfmake.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('vendor/datatable/vfs_fonts.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('vendor/datatable/jquery.dataTables.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('vendor/datatable/dataTables.bootstrap4.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('vendor/datatable/dataTables.buttons.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('vendor/datatable/buttons.bootstrap4.min.js') ?>">"></script>
<script type="text/javascript" src="<?php echo asset('vendor/datatable/buttons.colVis.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('vendor/datatable/buttons.html5.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('vendor/datatable/buttons.print.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('vendor/datatable/dataTables.select.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('vendor/datatable/sum().js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('vendor/datatable/dataTables.checkboxes.min.js') ?>"></script>

  </head>
  <body>
    <!-- Side Navbar -->
      <nav class="side-navbar">
      <div class="side-navbar-wrapper">
        <!-- Sidebar Header    -->
        <div class="sidenav-header d-flex align-items-center justify-content-center">
          <!-- User Info-->
          <div class="sidenav-header-inner text-center"><span class="brand-big text-center">
            @if($settings->site_logo)<img src="{{url('logo', $settings->site_logo)}}">&nbsp;&nbsp;@endif<strong>{{$settings->site_title}}</strong></span>
          </div>
          <!-- Small Brand information, appears on minimized sidebar-->
          <div class="sidenav-header-logo"><span class="brand-small text-center"> <strong>{{$settings->site_title}}</strong></span></div>
        </div>
        <!-- Sidebar Navigation Menus-->
        <div class="main-menu">
          <ul id="side-main-menu" class="side-menu list-unstyled">                  
            <li><a href="{{url('/dashboard')}}"> <i class="icon-home"></i>{{trans('file.Dashboard')}}</a></li>
            <li><a href="#product" aria-expanded="false" data-toggle="collapse"> <i class="icon-list"></i> {{trans('file.Product')}}</a>
              <ul id="product" class="collapse list-unstyled ">
                <li><a href="{{route('category.index')}}"> {{trans('file.Category')}}</a></li>
                <?php
                  $role = DB::table('roles')->find(Auth::user()->role); 
                  $index_permission_active = DB::table('permissions')
                        ->join('role_has_permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
                        ->where([
                        ['permissions.name', 'products-index'],
                        ['role_id', $role->id] ])->first();
                ?>
                @if($index_permission_active)
                  <li><a href="{{route('products.index')}}">{{trans('file.Product')}} {{trans('file.List')}}</a></li>
                  <?php $add_permission_active = DB::table('permissions')
                      ->join('role_has_permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
                      ->where([
                        ['permissions.name', 'products-add'],
                        ['role_id', $role->id] ])->first();
                  ?>
                  @if($add_permission_active)
                    <li><a href="{{route('products.create')}}">{{trans('file.Add')}} {{trans('file.Product')}}</a></li>
                  @endif
                @endif
                <li><a href="{{route('product.printBarcode')}}">{{trans('file.Print Barcode')}}</a></li>
              </ul>
            </li>
            <?php $index_permission_active = DB::table('permissions')
                      ->join('role_has_permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
                      ->where([
                        ['permissions.name', 'customers-index'],
                        ['role_id', $role->id] ])->first();
            ?>
            @if($index_permission_active)
            <li><a href="#customer" aria-expanded="false" data-toggle="collapse"> <i class="icon-user"></i>{{trans('file.Customer')}}</a>
              <ul id="customer" class="collapse list-unstyled ">
                <li><a href="{{route('customer.index')}}">{{trans('file.Customer')}} {{trans('file.List')}}</a></li>
                <?php $add_permission_active = DB::table('permissions')
                      ->join('role_has_permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
                      ->where([
                        ['permissions.name', 'customers-add'],
                        ['role_id', $role->id] ])->first();
                ?>
                @if($add_permission_active)
                <li><a href="{{route('customer.create')}}">{{trans('file.Add')}} {{trans('file.Customer')}}</a></li>
                @endif
              </ul>
            </li>
            @endif
            <?php $index_permission_active = DB::table('permissions')
                      ->join('role_has_permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
                      ->where([
                        ['permissions.name', 'purchases-index'],
                        ['role_id', $role->id] ])->first();
            ?>
            @if($index_permission_active)
            <li><a href="#purchase" aria-expanded="false" data-toggle="collapse"> <i class="icon-bill"></i>{{trans('file.Purchase')}}</a>
              <ul id="purchase" class="collapse list-unstyled ">
                <?php $add_permission_active = DB::table('permissions')
                      ->join('role_has_permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
                      ->where([
                        ['permissions.name', 'purchases-add'],
                        ['role_id', $role->id] ])->first();
                ?>
                <li><a href="{{route('purchases.index')}}">{{trans('file.Purchase')}} {{trans('file.List')}}</a></li>
                @if($add_permission_active)
                <li><a href="{{route('purchases.create')}}">{{trans('file.Add')}} {{trans('file.Purchase')}}</a></li>
                <li><a href="{{url('purchases/purchase_by_csv')}}">{{trans('file.Import')}} {{trans('file.Purchase')}} {{trans('file.By')}} CSV</a></li>
                @endif
              </ul>
            </li>
            @endif
            <?php $index_permission_active = DB::table('permissions')
                      ->join('role_has_permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
                      ->where([
                        ['permissions.name', 'sales-index'],
                        ['role_id', $role->id] ])->first();
            ?>
            @if($index_permission_active)
            <li><a href="#sale" aria-expanded="false" data-toggle="collapse"> <i class="icon-pencil-case"></i>{{trans('file.Sale')}}</a>
              <ul id="sale" class="collapse list-unstyled ">
                <li><a href="{{route('sales.index')}}">{{trans('file.Sale')}} {{trans('file.List')}}</a></li>
                <?php $add_permission_active = DB::table('permissions')
                      ->join('role_has_permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
                      ->where([
                        ['permissions.name', 'sales-add'],
                        ['role_id', $role->id] ])->first();
                ?>
                @if($add_permission_active)
                <li><a href="{{route('sales.create')}}">{{trans('file.Add')}} {{trans('file.Sale')}}</a></li>
                <li><a href="{{url('sales/sale_by_csv')}}">{{trans('file.Import')}} {{trans('file.Sale')}} {{trans('file.By')}} CSV</a></li>
                @endif
              </ul>
            </li>
            @endif
            <?php $index_permission_active = DB::table('permissions')
                      ->join('role_has_permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
                      ->where([
                        ['permissions.name', 'returns-index'],
                        ['role_id', $role->id] ])->first();
            ?>
            @if($index_permission_active)
            <li><a href="#return" aria-expanded="false" data-toggle="collapse"> <i class="fa fa-undo"></i>{{trans('file.Return')}}</a>
              <ul id="return" class="collapse list-unstyled ">
                <li><a href="{{route('returns.index')}}">{{trans('file.Return')}} {{trans('file.List')}}</a></li>
                <?php $add_permission_active = DB::table('permissions')
                      ->join('role_has_permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
                      ->where([
                        ['permissions.name', 'returns-add'],
                        ['role_id', $role->id] ])->first();
                ?>
                @if($add_permission_active)
                  <li><a href="{{route('returns.create')}}">{{trans('file.Add')}} {{trans('file.Return')}}</a></li>
                @endif
              </ul>
            </li>
            @endif
            <?php $index_permission_active = DB::table('permissions')
                      ->join('role_has_permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
                      ->where([
                        ['permissions.name', 'users-index'],
                        ['role_id', $role->id] ])->first();
            ?>
            @if($index_permission_active)
            <li><a href="#user" aria-expanded="false" data-toggle="collapse"> <i class="fa fa-user"></i>{{trans('file.User')}}</a>
              <ul id="user" class="collapse list-unstyled ">
                <li><a href="{{route('users.index')}}">{{trans('file.User')}} {{trans('file.List')}}</a></li>
                <?php $add_permission_active = DB::table('permissions')
                      ->join('role_has_permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
                      ->where([
                        ['permissions.name', 'users-add'],
                        ['role_id', $role->id] ])->first();
                ?>
                @if($add_permission_active)
                <li><a href="{{route('users.create')}}">{{trans('file.Add')}} {{trans('file.User')}}</a></li>
                @endif
              </ul>
            </li>
            @endif
            <?php
                $profit_loss_active = DB::table('permissions')
                      ->join('role_has_permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
                      ->where([
                        ['permissions.name', 'profit-loss'],
                        ['role_id', $role->id] ])->first();
                $best_seller_active = DB::table('permissions')
                      ->join('role_has_permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
                      ->where([
                        ['permissions.name', 'best-seller'],
                        ['role_id', $role->id] ])->first();
                $product_report_active = DB::table('permissions')
                      ->join('role_has_permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
                      ->where([
                        ['permissions.name', 'product-report'],
                        ['role_id', $role->id] ])->first();
                $purchase_report_active = DB::table('permissions')
                      ->join('role_has_permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
                      ->where([
                        ['permissions.name', 'purchase-report'],
                        ['role_id', $role->id] ])->first();
                $sale_report_active = DB::table('permissions')
                      ->join('role_has_permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
                      ->where([
                        ['permissions.name', 'sale-report'],
                        ['role_id', $role->id] ])->first();
                $product_qty_alert_active = DB::table('permissions')
                      ->join('role_has_permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
                      ->where([
                        ['permissions.name', 'product-qty-alert'],
                        ['role_id', $role->id] ])->first();
                $customer_report_active = DB::table('permissions')
                      ->join('role_has_permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
                      ->where([
                        ['permissions.name', 'customer-report'],
                        ['role_id', $role->id] ])->first();
                $due_report_active = DB::table('permissions')
                      ->join('role_has_permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
                      ->where([
                        ['permissions.name', 'due-report'],
                        ['role_id', $role->id] ])->first();
              ?>
            <li><a href="#report" aria-expanded="false" data-toggle="collapse"> <i class="icon-page"></i>{{trans('file.Report')}}s</a>
              <ul id="report" class="collapse list-unstyled ">
                @if($profit_loss_active)
                <li>
                  {!! Form::open(['route' => 'report.profitLoss', 'method' => 'post', 'id' => 'profitLoss-report-form']) !!}
                  <input type="hidden" name="start_date" value="{{date('Y-m').'-'.'01'}}" />
                  <input type="hidden" name="end_date" value="{{date('Y-m-d')}}" />
                  <a id="profitLoss-link" href="">{{trans('file.profit')}} / {{trans('file.Loss')}}</a>
                  {!! Form::close() !!}
                </li>
                @endif
                @if($best_seller_active)
                <li>
                  <a href="{{url('report/best_seller')}}">{{trans('file.Best Seller')}}</a>
                </li>
                @endif
                @if($product_report_active)
                <li>
                  {!! Form::open(['route' => 'report.byDate', 'method' => 'post', 'id' => 'report-form']) !!}
                  <input type="hidden" name="start_date" value="1988-04-18" />
                  <input type="hidden" name="end_date" value="{{date('Y-m-d')}}" />
                  <a id="report-link" href="">{{trans('file.Product')}} {{trans('file.Report')}} </a>
                  {!! Form::close() !!}
                </li>
                @endif
                @if($product_qty_alert_active)
                <li>
                  <a href="{{route('report.qtyAlert')}}">{{trans('file.Product')}} {{trans('file.Quantity')}} {{trans('file.Alert')}}</a>
                </li>
                @endif
                @if($purchase_report_active)
                <li>
                  {!! Form::open(['route' => 'report.purchaseByDate', 'method' => 'post', 'id' => 'purchase-report-form']) !!}
                  <input type="hidden" name="start_date" value="1988-04-18" />
                  <input type="hidden" name="end_date" value="{{date('Y-m-d')}}" />
                  <a id="purchase-report-link" href="">{{trans('file.Purchase')}} {{trans('file.Report')}}</a>
                  {!! Form::close() !!}
                </li>
                @endif
                @if($sale_report_active)
                <li>
                  {!! Form::open(['route' => 'report.saleByDate', 'method' => 'post', 'id' => 'sale-report-form']) !!}
                  <input type="hidden" name="start_date" value="1988-04-18" />
                  <input type="hidden" name="end_date" value="{{date('Y-m-d')}}" />
                  <a id="sale-report-link" href="">{{trans('file.Sale')}} {{trans('file.Report')}}</a>
                  {!! Form::close() !!}
                </li>
                @endif
                @if($customer_report_active)
                <li>
                  <a id="customer-report-link" href="">{{trans('file.Customer')}} {{trans('file.Report')}}</a>
                </li>
                @endif
                @if($due_report_active)
                <li>
                  {!! Form::open(['route' => 'report.dueByDate', 'method' => 'post', 'id' => 'due-report-form']) !!}
                  <input type="hidden" name="start_date" value="1988-04-18" />
                  <input type="hidden" name="end_date" value="{{date('Y-m-d')}}" />
                  <a id="due-report-link" href="">{{trans('file.Due')}} {{trans('file.Report')}}</a>
                  {!! Form::close() !!}
                </li>
                @endif
              </ul>
            </li>
            @if($role->id <= 2)
            <li><a href="#settings" aria-expanded="false" data-toggle="collapse"> <i class="fa fa-cog"></i>{{trans('file.Settings')}}</a>
              <ul id="settings" class="collapse list-unstyled ">
                <li>
                  <a href="{{route('roles.index')}}">{{trans('file.Role')}}</a>
                </li>
                <li>
                  <a href="{{route('settings.index')}}">{{trans('file.General Setting')}}</a>
                </li>
              </ul>
            </li>
            @endif
          </ul>
        </div>
      </div>
    </nav>
    
    <div class="page">
      <!-- navbar-->
      <header class="header">
        <nav class="navbar">
          <div class="container-fluid">
            <div class="navbar-holder d-flex align-items-center justify-content-between">
              <div class="navbar-header"><a href="{{route('user.profile', ['id' => Auth::id()])}}" class="navbar-brand">
                  <div class="brand-text d-none d-md-inline-block"><h3>{{trans('file.welcome')}} <span>{{Auth::user()->name}}</span> </h3></div></a></div>
              <ul class="nav-menu list-unstyled d-flex flex-md-row align-items-md-center">
                <li class="nav-item dropdown">
                  <a class="dropdown-item" href="{{url('/dashboard')}}"> <i class="fa fa-home"></i> {{trans('file.Dashboard')}}</a>
                </li>
                @if($product_qty_alert_active && $alert_product > 0)
                <li class="nav-item">
                      <a rel="nofollow" data-target="#" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-item"><i class="fa fa-bell"></i><span class="badge badge-danger">{{$alert_product}}</span>
                          <span class="caret"></span>
                          <span class="sr-only">Toggle Dropdown</span>
                      </a>
                      <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default notifications" user="menu">
                          <li class="notifications">
                            <a href="{{route('report.qtyAlert')}}" class="btn btn-link"> <i class="fa fa-exclamation-triangle"></i> {{$alert_product}} product exceeds alert quantity</a>
                          </li>
                      </ul>
                </li>
                @endif
                <li class="nav-item dropdown"> <a class="dropdown-item" href="{{route('user.profile', ['id' => Auth::id()])}}"><i class="fa fa-user"></i> {{trans('file.Profile')}}</a>
                </li>
                <li class="nav-item">
                      <a rel="nofollow" data-target="#" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-item"><i class="fa fa-language"></i> {{__('file.language')}}
                          <span class="caret"></span>
                          <span class="sr-only">Toggle Dropdown</span>
                      </a>
                      <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu">
                          <li>
                            <a href="{{ url('language_switch/en') }}" class="btn btn-link"> English</a>
                          </li>
                          <li>
                            <a href="{{ url('language_switch/es') }}" class="btn btn-link"> Español</a>
                          </li>
                          <li>
                            <a href="{{ url('language_switch/ar') }}" class="btn btn-link"> عربى</a>
                          </li>
                          <li>
                            <a href="{{ url('language_switch/fr') }}" class="btn btn-link"> Français</a>
                          </li>
                          <li>
                            <a href="{{ url('language_switch/de') }}" class="btn btn-link"> Deutsche</a>
                          </li>
                      </ul>
                </li>
                @if($role->id <= 2)
                <li class="nav-item dropdown"> <a class="dropdown-item" href="{{route('settings.index')}}"><i class="fa fa-cog"></i> {{trans('file.Settings')}}</a>
                </li>
                @endif
                <li class="nav-item">
                  <a class="dropdown-item" href="{{ route('logout') }}"
                     onclick="event.preventDefault();
                                   document.getElementById('logout-form').submit();"><i class="fa fa-sign-out"></i>
                      {{ __('file.logout') }}
                  </a>
                  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                      @csrf
                  </form>
                </li>
              </ul>
            </div>
          </div>
        </nav>
      </header>
      <!-- modal section -->
      <div id="customer-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
        <div role="document" class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="exampleModalLabel" class="modal-title">{{$settings->site_title}}</h5>
                    <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                  <p class="italic">{{trans('file.The field labels marked with * are required input fields')}}.</p>
                    {!! Form::open(['route' => 'report.customerByDate', 'method' => 'post']) !!}
                    <?php 
                      $lsms_customer_list = DB::table('customers')->where('is_active', true)->get();
                    ?>
                      <div class="form-group">
                          <label><strong>{{ __('file.Customer') }} *</strong></label>
                          <select name="customer_id" class="selectpicker form-control" required data-live-search="true" id="customer-id" data-live-search-style="begins" title="Select customer...">
                              @foreach($lsms_customer_list as $customer)
                              <option value="{{$customer->id}}">{{$customer->name . ' (' . $customer->phone. ')'}}</option>
                              @endforeach
                          </select>
                      </div>

                      <input type="hidden" name="start_date" value="1988-04-18" />
                      <input type="hidden" name="end_date" value="{{date('Y-m-d')}}" />

                      <div class="form-group">
                          <button type="submit" class="btn btn-primary">{{ __('file.Submit') }}</button>
                      </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
      </div>
      <!-- Counts Section -->
      
      <!-- Header Section-->
      
      <!-- Statistics Section-->
     
      <!-- Updates Section -->
      
      @yield('content')
      <footer class="main-footer">
        <div class="container-fluid">
          <div class="row">
            <div class="col-sm-6">
              <p>&copy; {{$settings->site_title}}</p>
            </div>
            <div class="col-sm-6 text-right">
              <p>{{ __('file.Developed By') }} <a href="http://lion-coders.com" class="external">LionCoders</a></p>
            </div>
          </div>
        </div>
      </footer>
    </div>
    @yield('scripts')
    <script type="text/javascript">

      $('.selectpicker').selectpicker({
          style: 'btn-link',
      });

      $("a#profitLoss-link").click(function(e){
        e.preventDefault();
        $("#profitLoss-report-form").submit();
      });

      $("a#report-link").click(function(e){
        e.preventDefault();
        $("#report-form").submit();
      });

      $("a#purchase-report-link").click(function(e){
        e.preventDefault();
        $("#purchase-report-form").submit();
      });

      $("a#sale-report-link").click(function(e){
        e.preventDefault();
        $("#sale-report-form").submit();
      });

      $("a#customer-report-link").click(function(e){
        e.preventDefault();
        $('#customer-modal').modal();
      });

      $("a#due-report-link").click(function(e){
        e.preventDefault();
        $("#due-report-form").submit();
      });
  </script>
  </body>
</html>