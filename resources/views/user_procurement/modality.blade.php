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

  .table-bordered1 tr {
    border-top: .1px solid #000 !important;
  }

  .table-bordered1 tr {
    display:flex;
    flex-wrap:wrap; /* allow to wrap on multiple rows */
  }
  .table-bordered1 td, .table-bordered1 th {
    display:block;
    flex:1 /* to evenly distributs flex elements */
  }

</style>

<!-- MODALITY -->
<div id="page-wrapper" class="gray-bg dashbard-1" ng-init="show_modality();show_profile()">
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
    <div class="col-lg-8">
      <h2> Modality </h2>
      <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="{{ url('/procurement/routes') }}" >Home</a>
          </li>
          <li class="breadcrumb-item">
              <strong> Modality </strong>
          </li>
      </ol>
    </div>

<!--     <div class="col-lg-3" >
      <div ng-if="search_modal == false">
        <label><small> Search Subproject <i class="fa fa-search"></i> </small></label>
        <input class="form-control nav-item nav-link" type="text" name="" placeholder="Search..." ng-model="search_data_modality" ng-change="search_sp(search_data_modality)">
      </div> 
    </div>
 -->
    <div class="col-lg-4" style="margin-top: 40px;">
      <div class="input-group">
        <div class="input-group-prepend">
          <button class="btn btn-danger rounded-0" ng-click="show_modality();clear_filter()"> <i class="fa fa-eraser"></i> </button>
          <button class="btn btn-secondary rounded-0" data-backdrop="static" data-keyboard="false" data-target="#filterModal" data-toggle="modal"> <i class="fa fa-filter"></i> </button>
        </div>
          <input class="form-control nav-item nav-link" style="border: 1px solid;" type="text" name="" placeholder="Search..." ng-model="search_data_modality" ng-change="search_sp(search_data_modality)">
        <div class="input-group-prepend">

          <button class="btn btn-outline-primary rounded-0" ng-if="search_modal == false" ng-click="Export_All_Data(1)"> SP <i class="fa fa-external-link"></i> </button>

          <button class="btn btn-outline-warning rounded-0" ng-click="Export_All_Data(2)"> PMR <i class="fa fa-external-link"></i> </button>

        </div>
      </div>
    </div>
  </div>

  @include('user_procurement.modality_list')
  @include('user_procurement.modality_modal')
@endsection