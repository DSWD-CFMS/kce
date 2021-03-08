@extends('layouts.dashboard')

@section('content')
<!-- MODALITY -->
<div id="page-wrapper" class="gray-bg dashbard-1" ng-init="fetch_rpmo_reports();show_profile()">
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
      <h2> Reports </h2>
      <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="{{ url('/admin_rcis/routes') }}" >Home</a>
          </li>
          <li class="breadcrumb-item">
              <strong> Reports </strong>
          </li>
      </ol>
    </div>

    <div class="col-lg-3" style="margin-top: 40px;">
      <div class="input-group">
        <div class="input-group-prepend">
          <button class="btn btn-outline-secondary rounded-0" ng-click="fetch_rpmo_reports();clearFilter()"> <i class="fa fa-eraser"></i> </button>
        </div>
          <button class="btn btn-primary rounded-0" data-backdrop="static" data-keyboard="false" data-target="#filter_modal" data-toggle="modal"> Filters <i class="fa fa-filter"></i> </button>
        <div class="input-group-prepend">
          <button class="btn btn-primary rounded-0" ng-if="search_modal == false" ng-click="Export_All_Data()"> Export <i class="fa fa-external-link"></i> </button>
          <button class="btn btn-primary rounded-0" ng-if="search_modal == true" ng-click="Export_Modal_Data()"> Export <i class="fa fa-external-link"></i> </button>
        </div>
      </div>
    </div>
  </div>

@include('user_rpmo.reports_list')
@include('user_rpmo.reports_modal')
@endsection
