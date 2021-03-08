@extends('layouts.dashboard')

@section('content')
<style type="text/css">
  .card, .card .card-footer{
    border-radius: 0px;
  }

  .orange{
    color: #fdab14;
  }

  .pulsate {
      -webkit-animation: pulsate 3s ease-out;
      -webkit-animation-iteration-count: infinite; 
      opacity: 0.5;
  }
  @-webkit-keyframes pulsate {
      0% { 
          opacity: 0.5;
        color: #676a6c;
      }
      50% { 
          opacity: 1.0;
        color: #f8ac59;
      }
      100% { 
          opacity: 0.5;
        color: #f48c19;
      }
  }
</style>

<!-- MODALITY -->
<div id="page-wrapper" class="gray-bg dashbard-1" ng-init="render_modalities_and_sp();show_profile()">
  <div class="row border-bottom">
    <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
      <div class="navbar-header">
          <a class="navbar-minimalize minimalize-styl-2 py-0 text-secondary" style="text-transform: none !important; text-decoration: none !important; border-radius: 100px;" href="" ng-click="mini_navbar = !mini_navbar">
            
            <i ng-class="{'fa fa-chevron-circle-right fa-2x': mini_navbar == true, 'fa fa-chevron-circle-left fa-2x': mini_navbar == false}"></i>
          </a>
          <h4 class="minimalize-styl-2 mx-0 px-0 pb-0 mb-0" href="#">
            KCE WebApp v2.0
          </h4>
      </div>
      <ul class="nav navbar-top-links navbar-right">
          <li>
              <a href="#exampleModal" data-toggle="modal">
                  <i class="fa fa-sign-out"></i> Sign out
              </a>
          </li>
      </ul>
      @include('user_admin_rcis.logout_modal')
    </nav>
  </div>

  <div class="row wrapper border-bottom white-bg page-heading justify-content-end animated fadeInRight">
    <div class="col-lg-9">
      <h2> Modality </h2>
      <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="{{ url('/admin_rcis/routes') }}" >Home</a>
          </li>
          <li class="breadcrumb-item">
              <strong> Modality </strong>
          </li>
      </ol>
    </div>

    <div class="col-lg-3" style="margin-top: 40px;">
      <div class="input-group">
        <div class="input-group-prepend">
          <button class="btn btn-outline-secondary rounded-0" ng-click="show_modality();clear_filter()"> <i class="fa fa-eraser"></i> </button>
        </div>
          <button class="btn btn-primary rounded-0" data-backdrop="static" data-keyboard="false" data-target="#filterModal" data-toggle="modal"> Filters <i class="fa fa-filter"></i> </button>
        <div class="input-group-prepend">
          <button class="btn btn-primary rounded-0" ng-if="search_modal == false" ng-click="Export_All_Data()"> Export <i class="fa fa-external-link"></i> </button>
          <button class="btn btn-primary rounded-0" ng-if="search_modal == true" ng-click="Export_Modal_Data()"> Export <i class="fa fa-external-link"></i> </button>
        </div>
      </div>
    </div>
  </div>

  @include('user_rpmo.modality_list')
  @include('user_rpmo.modality_modal')
@endsection