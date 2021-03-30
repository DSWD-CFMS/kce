<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>KC-ENGINEERING | Building Better Communities With You</title>

    <link href="{{ asset('ispinia/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('ispinia/font-awesome/css/font-awesome.css') }}" rel="stylesheet">

    <!-- Toastr style -->
    <link href="{{ asset('ispinia/css/plugins/toastr/toastr.min.css') }}" rel="stylesheet">

    <!-- Tags Input -->
    <link href="{{ asset('ispinia/css/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css') }}" rel="stylesheet">

    <!-- Gritter -->
    <link href="{{ asset('ispinia/js/plugins/gritter/jquery.gritter.css') }}" rel="stylesheet">
    
    <link href="{{ asset('/css/file-upload-with-preview.min.css') }}" rel="stylesheet" type="text/css">

    <link href="{{ asset('ispinia/css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('ispinia/css/style.css') }}" rel="stylesheet">
</head>

<body ng-app="Main_Function" ng-controller="RPMO_Controller" ng-class="{'mini-navbar': mini_navbar == true}">
	<div id="wrapper">
		<!-- RPMO USERS   -->
		<p id="user_id" hidden>{{Auth::user()->id}}</p>
		<nav class="navbar-default navbar-static-side" role="navigation" ng-init="show_profile_dashboard()">
		  <div class="sidebar-collapse">
		      <ul class="nav metismenu" id="side-menu">
		        <li class="nav-header">
		          <div class="dropdown profile-element">
		              <img ng-if="PhotoObj.length == 0" alt="image" class="rounded-circle" style="height: 50px; width: 50px; border-radius: 50px; object-fit: cover;" src="https://image.flaticon.com/icons/svg/747/747376.svg" ng-cloak>
		              <img ng-if="PhotoObj.length > 0" alt="image" class="rounded-circle" style=" cursor: pointer; height: 50px; width: 50px; border-radius: 50px; object-fit: cover;" src="/get_profile_photo/{{Auth::user()->id}}" ng-cloak>
		              <a data-toggle="dropdown" class="dropdown-toggle" href="">
		                  <span class="block m-t-xs font-bold">{{Auth::user()->Fname}} {{Auth::user()->Lname}}</span>
		                  <span class="text-muted text-xs block"> RPMO <b class="caret"></b></span>
		              </a>
		              <ul class="dropdown-menu animated fadeInRight m-t-xs">
		                  <li><a class="dropdown-item" href="{{ url('/rpmo/routes/profile') }}">Profile</a></li>
		              </ul>
		            </div>
		            <div class="logo-element">
		              <a href="{{ url('/rpmo/routes/profile') }}">
		                <img ng-if="PhotoObj.length == 0" alt="image" class="rounded-circle" style="height: 50px; width: 50px; border-radius: 50px; object-fit: cover;" src="https://image.flaticon.com/icons/svg/747/747376.svg" ng-cloak>
		                <img ng-if="PhotoObj.length > 0" alt="image" class="rounded-circle" style=" cursor: pointer; height: 50px; width: 50px; border-radius: 50px; object-fit: cover;" src="/get_profile_photo/{{Auth::user()->id}}" ng-cloak>
		              </a>
		            </div>
		          </li>
		          <li>
		              <a href="{{ url('/rpmo/routes') }}" ng-class="{'text-warning': fetch_rpmo_dashboard_div == true}"><i class="fa fa-tachometer"></i> <span class="nav-label">Dashboard</span></a>
		          </li>

		          <li>
		              <a href="{{ url('/rpmo/routes/show_modality') }}" ><i class="fa fa-list-alt"></i> <span class="nav-label">Modality</span></a>
		          </li>

                  <li>
		              <a href="{{ url('/rpmo/routes/new_module') }}" ><i class="fa fa-gg"></i> <span class="nav-label">New Module</span></a>
		          </li>

		          <li>
		              <a href="" ng-click="fetch_rpmo_ceac()"><i class="fa fa-fw fa-slideshare"></i>
		                <span class="nav-label" ng-class="{'text-warning': fetch_rpmo_ceac_div == true}">CEAC</span>
		              </a>
		          </li>

		          <li>
		              <a href="{{ url('/rpmo/routes/show_reports') }}" ><i class="fa fa-bullhorn"></i> <span class="nav-label">Reports</span></a>
		          </li>

		          <li>
		              <a href="{{ url('/rpmo/routes/files') }}" ><i class="fa fa-archive"></i> <span class="nav-label">Files</span></a>
		          </li>
		      </ul>
		  </div>
		</nav>

		@yield('content')
	</div>

    <!-- Mainly scripts -->
    <script src="{{asset('ispinia/js/jquery-3.4.1.js')}}"></script>
    <script src="{{asset('ispinia/js/popper.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('/js/pre_req/moment_.js') }}"></script>
    <script src="{{asset('ispinia/js/bootstrap.js')}}"></script>
    <script src="{{asset('ispinia/js/plugins/metisMenu/jquery.metisMenu.js')}}"></script>
    <script src="{{asset('ispinia/js/plugins/slimscroll/jquery.slimscroll.min.js')}}"></script>
    <script src="{{ asset('/js/file-upload-with-preview.min.js') }}"></script>

    <!-- Tags Input -->
    <script src="{{asset('ispinia/js/plugins/bootstrap-tagsinput/bootstrap-tagsinput.js')}}"></script>
    <!-- Flot -->
    <script src="{{asset('ispinia/js/plugins/flot/jquery.flot.js')}}"></script>
    <script src="{{asset('ispinia/js/plugins/flot/jquery.flot.tooltip.min.js')}}"></script>
    <script src="{{asset('ispinia/js/plugins/flot/jquery.flot.spline.js')}}"></script>
    <script src="{{asset('ispinia/js/plugins/flot/jquery.flot.resize.js')}}"></script>
    <script src="{{asset('ispinia/js/plugins/flot/jquery.flot.pie.js')}}"></script>

    <!-- Peity -->
    <script src="{{asset('ispinia/js/plugins/peity/jquery.peity.min.js')}}"></script>
    <script src="{{asset('ispinia/js/demo/peity-demo.js')}}"></script>

    <!-- Custom and plugin javascript -->
    <script src="{{asset('ispinia/js/inspinia.js')}}"></script>
    <script src="{{asset('ispinia/js/plugins/pace/pace.min.js')}}"></script>

    <!-- jQuery UI -->
    <script src="{{asset('ispinia/js/plugins/jquery-ui/jquery-ui.min.js')}}"></script>

    <!-- GITTER -->
    <script src="{{asset('ispinia/js/plugins/gritter/jquery.gritter.min.js')}}"></script>

    <!-- Sparkline -->
    <script src="{{asset('ispinia/js/plugins/sparkline/jquery.sparkline.min.js')}}"></script>

    <!-- Sparkline demo data  -->
    <script src="{{asset('ispinia/js/demo/sparkline-demo.js')}}"></script>

    <!-- ChartJS-->
    <script src="{{asset('js/charts/Chart.bundle.min.js')}}"></script>

    <!-- Toastr -->
    <script src="{{asset('ispinia/js/plugins/toastr/toastr.min.js')}}"></script>

    <script type="text/javascript" src="{{ asset('/js/angular/angular.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/angular/angular-route.js') }}"></script>

    <script type="text/javascript" src="{{ asset('/js/alasql.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/xlsx.min.js') }}"></script>
    
    <script type="text/javascript" src="{{ asset('/js/printThis.js') }}"></script>

    <script src="{{ asset('/js/location/build/phil.min.js') }}"></script>
    <script src="{{ asset('/js/file-upload-with-preview.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/sockets/socket.io.dev.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/swal/sweetalert2@9.js') }}"></script>

    <script type="text/javascript" src="{{ asset('/js/tableExport/tableExport.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/tableExport/libs/FileSaver/FileSaver.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/tableExport/libs/js-xlsx/xlsx.core.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/tableExport/libs/jsPDF/jspdf.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/tableExport/libs/jsPDF-AutoTable/jspdf.plugin.autotable.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/tableExport/libs/pdfmake/pdfmake.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/tableExport/libs/pdfmake/vfs_fonts.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/tableExport/libs/es6-promise/es6-promise.auto.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/tableExport/libs/html2canvas/html2canvas.min.js') }}"></script>
    
	<script type="text/javascript" src="{{ asset('/js/rpmo_functions.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/angular-routes/rpmo-routes.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $('.tagsinput').tagsinput({
                tagClass: 'label label-primary'
            });
        });
    </script>
</body>
</html>
