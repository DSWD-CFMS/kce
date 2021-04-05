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

    <!-- Gritter -->
    <link href="{{ asset('ispinia/js/plugins/gritter/jquery.gritter.css') }}" rel="stylesheet">

    <link href="{{ asset('ispinia/css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('ispinia/css/style.css') }}" rel="stylesheet">

</head>

<body ng-app="Admin_Function" ng-controller="Admin_Controller" ng-class="{'mini-navbar': mini_navbar == true}">
  <div id="wrapper" ng-init="fetch_admin_dashboard();show_profile_dashboard();">
    <p id="user_id" hidden>{{Auth::user()->id}}</p>
    <nav class="navbar-default navbar-static-side" role="navigation">
      <div class="sidebar-collapse">
          <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
              <div class="dropdown profile-element">
                  <img ng-if="PhotoObj.length == 0" alt="image" class="rounded-circle" style="height: 50px; width: 50px; border-radius: 50px; object-fit: cover;" src="https://image.flaticon.com/icons/svg/747/747376.svg" ng-cloak>
                  <img ng-if="PhotoObj.length > 0" alt="image" class="rounded-circle" style=" cursor: pointer; height: 50px; width: 50px; border-radius: 50px; object-fit: cover;" src="/get_profile_photo/{{Auth::user()->id}}" ng-cloak>

                  <a data-toggle="dropdown" class="dropdown-toggle" href="">
                      <span class="block m-t-xs font-bold">{{Auth::user()->Fname}} {{Auth::user()->Lname}}</span>
                      <span class="text-muted text-xs block"> KCE IT Admin <b class="caret"></b></span>
                  </a>
                  <ul class="dropdown-menu animated fadeInRight m-t-xs">
                      <li><a class="dropdown-item" href="{{ url('/admin/routes/profile') }}">Profile</a></li>
                  </ul>
                </div>
                <div class="logo-element">
                  <a href="{{ url('/admin/routes/profile') }}">
                    <img ng-if="PhotoObj.length == 0" alt="image" class="rounded-circle" style="height: 50px; width: 50px; border-radius: 50px; object-fit: cover;" src="https://image.flaticon.com/icons/svg/747/747376.svg" ng-cloak>
                    <img ng-if="PhotoObj.length > 0" alt="image" class="rounded-circle" style=" cursor: pointer; height: 50px; width: 50px; border-radius: 50px; object-fit: cover;" src="/get_profile_photo/{{Auth::user()->id}}" ng-cloak>
                  </a>
                </div>
              </li>
              <li>
                  <a href="{{ url('/admin/routes') }}" ><i class="fa fa-tachometer"></i> <span class="nav-label">Dashboard</span></a>
              </li>

              <li>
                  <a href="{{ url('/admin/routes/show_modality') }}" ><i class="fa fa-list-alt"></i> <span class="nav-label">Modality</span><span class="fa arrow"></span></a>
              </li>

              <li>
                  <a href="http://crg-kcapps-svr.entdswd.local/finance/hires/frontend/web/index.php?r=assigned-sp" target="_blank"><i class="fa fa-gg"></i> <span class="nav-label">Assigning Module</span></a>
              </li>

              <li>
                <a href="{{ url('/admin/routes/show_reports') }}" >
                  <i class="fa fa-fw fa-bullhorn"></i>
                  <span class="nav-label" ng-class="{'text-warning': fetch_admin_reports_div == true}">Reports</span>
                </a>
              </li>

              <li>
                <a href="{{ url('/admin/routes/show_user_list') }}" >
                  <i class="fa fa-fw fa-user"></i>
                  <span class="nav-label" ng-class="{'text-warning': fetch_admin_enroll_user_div == true}"> Users </span>
                </a>
              </li>

              <li>
                <a href="{{ url('/admin/routes/files') }}" >
                  <i class="fa fa-fw fa-upload"></i>
                  <span class="nav-label" ng-class="{'text-warning': fetch_admin_upload_div == true}"> Files</span>
                </a>
              </li>
          </ul>
      </div>
    </nav>
    @yield('content')

        <!-- Chats -->
<!--         <div class="small-chat-box fadeInRight animated">
          <div class="heading" draggable="true">
              <small class="chat-date float-right">
                  02.19.2015
              </small>
              Small chat
          </div>

          <div class="content">

              <div class="left">
                  <div class="author-name">
                      Monica Jackson <small class="chat-date">
                      10:02 am
                  </small>
                  </div>
                  <div class="chat-message active">
                      Lorem Ipsum is simply dummy text input.
                  </div>

              </div>
              <div class="right">
                  <div class="author-name">
                      Mick Smith
                      <small class="chat-date">
                          11:24 am
                      </small>
                  </div>
                  <div class="chat-message">
                      Lorem Ipsum is simpl.
                  </div>
              </div>
              <div class="left">
                  <div class="author-name">
                      Alice Novak
                      <small class="chat-date">
                          08:45 pm
                      </small>
                  </div>
                  <div class="chat-message active">
                      Check this stock char.
                  </div>
              </div>
              <div class="right">
                  <div class="author-name">
                      Anna Lamson
                      <small class="chat-date">
                          11:24 am
                      </small>
                  </div>
                  <div class="chat-message">
                      The standard chunk of Lorem Ipsum
                  </div>
              </div>
              <div class="left">
                  <div class="author-name">
                      Mick Lane
                      <small class="chat-date">
                          08:45 pm
                      </small>
                  </div>
                  <div class="chat-message active">
                      I belive that. Lorem Ipsum is simply dummy text.
                  </div>
              </div>
          </div>
          <div class="form-chat">
              <div class="input-group input-group-sm">
                  <input type="text" class="form-control">
                  <span class="input-group-btn"> <button
                      class="btn btn-primary" type="button">Send
              </button> </span></div>
          </div>
        </div>
        <div id="small-chat">
            <span class="badge badge-warning float-right">5</span>
            <a class="open-small-chat" href="">
                <i class="fa fa-comments"></i>
            </a>
        </div> -->
  </div>

    <!-- Mainly scripts -->
    <script src="{{asset('ispinia/js/jquery-3.4.1.js')}}"></script>
    <script src="{{asset('ispinia/js/popper.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('/js/pre_req/moment_.js') }}"></script>
    <script src="{{asset('ispinia/js/bootstrap.js')}}"></script>
    <script src="{{asset('ispinia/js/plugins/metisMenu/jquery.metisMenu.js')}}"></script>
    <script src="{{asset('ispinia/js/plugins/slimscroll/jquery.slimscroll.min.js')}}"></script>

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
    <script type="text/javascript" src="{{ asset('/js/admin_functions.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/angular-routes/admin-routes.js') }}"></script>
</body>
</html>
