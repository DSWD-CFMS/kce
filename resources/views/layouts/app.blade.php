<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <!-- <meta name="csrf-token" content="{{ csrf_token() }}"> -->

  <title>KC-ENGINEERING | Building Better Communities With You</title>

  <!-- Styles -->
<!--   <link href="{{ asset('/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('css/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
  <link href="{{ asset('/js/lightbox/lightbox.css') }}" rel="stylesheet"> -->

    <link href="{{ asset('ispinia/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('ispinia/font-awesome/css/font-awesome.css') }}" rel="stylesheet">

    <!-- Toastr style -->
    <link href="{{ asset('ispinia/css/plugins/toastr/toastr.min.css') }}" rel="stylesheet">

    <!-- Gritter -->
    <link href="{{ asset('ispinia/js/plugins/gritter/jquery.gritter.css') }}" rel="stylesheet">

    <link href="{{ asset('ispinia/css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('ispinia/css/style.css') }}" rel="stylesheet">

    

</head>
<body id="page-top" class="landing-page no-skin-config" ng-app="Main_Function">
    @guest
        <div id="app" ng-controller="Welcome_Controller">
    @else
    @endguest
  <div class="navbar-wrapper">
    <nav class="navbar navbar-default navbar-fixed-top navbar-expand-md" role="navigation">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}" title="KC-ENGINEERING 'Building Better Communities With You'">KCE WebApp v2.0</a>
            <div class="navbar-header page-scroll">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar">
                    <i class="fa fa-bars"></i>
                </button>
            </div>
            <div class="collapse navbar-collapse justify-content-end" id="navbar">
              <ul class="nav navbar-nav navbar-right">
                <li><a class="nav-link page-scroll" href="#page-top">Home</a></li>
                <li><a class="nav-link page-scroll" href="#team">KCE Team</a></li>
                @guest
                <li>
                    <a class="nav-link"  class="dropdown-toggle" data-toggle="dropdown" href=""> <i class="fa fa-desktop"></i> KCE WebApp</a>
                    <ul class="dropdown-menu">
                      <li>
                          <a class="nav-link text-warning" href="{{ route('modality') }}"> <i class="fa fa-table"></i> Modality</a>
                      </li>
                      <li>
                          <a class="nav-link text-warning" href="{{ route('summary') }}"> <i class="fa fa-list-alt"></i> Summary</a>
                      </li>
                      <li>
                          <a class="nav-link text-warning" href="{{ route('downloadables') }}"> <i class="fa fa-download"></i> Downloadables</a>
                      </li>
                      <li>
                          <a class="nav-link text-warning" href="{{ route('gallery') }}"> <i class="fa fa-picture-o"></i> Gallery</a>
                      </li>
                    </ul>
                  </li>
                  <li>
                      <a class="nav-link" href="{{ route('rcis') }}"> <i class="fa fa-podcast"></i> RPMO Corner</a>
                  </li>
                  <li>
                      <a class="nav-link" href="{{ route('about') }}"> <i class="fa fa-question-circle"></i> About</a>
                  </li>
                  @else
                  @endguest
                  
                  <li><a class="nav-link page-scroll" href="#contact">Contact</a></li>
                  @guest
                      <li>
                        <!-- href="{{ route('login') }}"  -->
                          <a class="nav-link" href="" data-toggle="modal" data-target="#login_modal"><i class="fa fa-sign-in"></i> {{ __('Login') }}</a>
                      </li>
                  @else

                    @if(Auth::user()->role=="DAC")
                      <li><a class="nav-link page-scroll" href="/home">Dashboard</a></li>
                    @elseif(Auth::user()->role=="RPMO")
                      <li><a class="nav-link page-scroll" href="/home">Dashboard</a></li>
                    @elseif(Auth::user()->role=="MAINSTREAM")
                      <li><a class="nav-link page-scroll" href="/home">Dashboard</a></li>
                    @elseif(Auth::user()->role=="PROCUREMENT")
                      <li><a class="nav-link page-scroll" href="/home">Dashboard</a></li>
                    @endif

                      <li>
                          <a class="nav-link" href="{{ route('logout') }}"
                                 onclick="event.preventDefault();
                                               document.getElementById('logout-form').submit();">
                            <i class="fa fa-sign-in"></i> {{ __('Logout') }}
                          </a>

                          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                              @csrf
                          </form>
                      </li>
                  @endguest
              </ul>
            </div>
        </div>
    </nav>
  </div>
  @yield('content')

  <!-- LOGIN MODAL -->
  <div class="modal inmodal fade" id="login_modal" tabindex="-1" role="dialog"  aria-hidden="true">
      <div class="modal-dialog modal-md">
          <div class="modal-content animated bounceInRight">
              <div class="modal-header py-2 px-3" style="border-bottom: none !important;">
                  <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
              </div>
            <div class="modal-body">
                <a href="http://crg-kcapps-svr.entdswd.local/finance/hires/frontend/web/index.php?r=site/login&is_sso=1&system=kce" class='btn btn-primary form-control'><span class='fa fa-gg'></span> LOGIN WITH ISSO</a>
              <h2 class="text-left font-weight-bold">SIGN IN</h2>
              <form method="POST" action="{{ route('login') }}" name="form_login">
                  @csrf

                  <div class="form-group row">
                      <label for="login" class="col-md-12 col-form-label text-md-left">
                          {{ __('Username') }}
                      </label>
                   
                      <div class="col-sm-12">
                          <input id="login" type="text"
                                 class="form-control{{ $errors->has('username') || $errors->has('email') ? ' is-invalid' : '' }}"
                                 name="login" value="{{ old('username') ?: old('email') }}" ng-model="login" required autofocus>
                   
                          @if ($errors->has('username') || $errors->has('email'))
                              <span class="invalid-feedback">
                                  <strong>{{ $errors->first('username') ?: $errors->first('email') }}</strong>
                              </span>
                          @endif
                      </div>
                  </div>

                  <div class="form-group row">
                      <label for="password" class="col-md-12 col-form-label text-md-left"> Password </label>

                      <div class="col-sm-12">
                          <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" ng-model="password" required autocomplete="current-password">

                          @error('password')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                      </div>
                  </div>

                  <div class="form-group row">
                      <div class="col-sm-12">
                          <div class="form-check">
                              <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                              <label class="form-check-label" for="remember">
                                  {{ __('Remember Me') }}
                              </label>
                          </div>
                      </div>
                  </div>

                  <div class="form-group row mb-0">
                      <div class="col-sm-12">
                          <button ng-if="form_login.login.$valid && form_login.password.$valid" type="submit" class="btn btn-primary btn-block btn-lg animated shake" style="border-radius: 50px !important;">
                              {{ __('Login') }} <i class="fa fa-sign-in"></i>
                          </button>

                      </div>
                  </div>
              </form>
            </div>
          <div class="modal-footer">
            <button class="btn btn-white" type="button" data-dismiss="modal">Cancel</button>
          </div>
          </div>
      </div>
  </div>
    <!-- Mainly scripts -->
    <script src="{{asset('ispinia/js/jquery-3.4.1.js')}}"></script>
    <script src="{{asset('ispinia/js/popper.min.js')}}"></script>
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
    <script src="{{asset('ispinia/js/plugins/wow/wow.min.js')}}"></script>

    <!-- jQuery UI -->
    <script src="{{asset('ispinia/js/plugins/jquery-ui/jquery-ui.min.js')}}"></script>

    <!-- GITTER -->
    <script src="{{asset('ispinia/js/plugins/gritter/jquery.gritter.min.js')}}"></script>

    <!-- Sparkline -->
    <script src="{{asset('ispinia/js/plugins/sparkline/jquery.sparkline.min.js')}}"></script>

    <!-- Sparkline demo data  -->
    <script src="{{asset('ispinia/js/demo/sparkline-demo.js')}}"></script>

    <!-- ChartJS-->
    <script src="{{asset('ispinia/js/plugins/chartJs/Chart.min.js')}}"></script>

    <!-- Toastr -->
    <script src="{{asset('ispinia/js/plugins/toastr/toastr.min.js')}}"></script>

  <!-- Angular JS -->
  <script type="text/javascript" src="{{ asset('/js/angular/angular.js') }}"></script>
  <script type="text/javascript" src="{{ asset('/js/angular/angular-route.js') }}"></script>
  <script type="text/javascript" src="{{ asset('/js/alasql.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('/js/xlsx.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('/js/printThis.js') }}"></script>
  
  <script type="text/javascript" src="{{ asset('/js/underscore.js') }}"></script>
  <script type="text/javascript" src="{{ asset('/js/pre_req/moment_.js') }}"></script>
  <!-- Charts -->
  <script type="text/javascript" src="{{ asset('/js/charts/Chart.bundle.js') }}"></script>
  <script type="text/javascript" src="{{ asset('/js/charts/Chart.bundle.min.js') }}"></script>

  <script type="text/javascript" src="{{ asset('/js/lightbox/lightbox.min.js') }}"></script>
  <script src="{{ asset('/js/location/build/phil.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('/js/main_functions.js') }}"></script>


  <script>
      $(document).ready(function () {

          $('body').scrollspy({
              target: '#navbar',
              offset: 80
          });

          // Page scrolling feature
          $('a.page-scroll').bind('click', function(event) {
              var link = $(this);
              $('html, body').stop().animate({
                  scrollTop: $(link.attr('href')).offset().top - 50
              }, 500);
              event.preventDefault();
              $("#navbar").collapse('hide');
          });
      });

      var cbpAnimatedHeader = (function() {
          var docElem = document.documentElement,
                  header = document.querySelector( '.navbar-default' ),
                  didScroll = false,
                  changeHeaderOn = 200;
          function init() {
              window.addEventListener( 'scroll', function( event ) {
                  if( !didScroll ) {
                      didScroll = true;
                      setTimeout( scrollPage, 250 );
                  }
              }, false );
          }
          function scrollPage() {
              var sy = scrollY();
              if ( sy >= changeHeaderOn ) {
                  $(header).addClass('navbar-scroll')
              }
              else {
                  $(header).removeClass('navbar-scroll')
              }
              didScroll = false;
          }
          function scrollY() {
              return window.pageYOffset || docElem.scrollTop;
          }
          init();

      })();

      // Activate WOW.js plugin for animation on scrol
      new WOW().init();

  </script>
  </div>
</body>
</html>
