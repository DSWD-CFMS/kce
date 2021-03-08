@extends('layouts.admin_rcis_dashboard')

@section('content')
<style type="text/css">
  .card, .card .card-footer{
    border-radius: 0px;
  }

  .orange{
    color: #fdab14;
  }
</style>

<!-- FILES -->
<div id="page-wrapper" class="gray-bg dashbard-1" ng-init="show_downloadables();show_profile()">
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
    </nav>
  </div>

  <div class="row justify-content-end wrapper border-bottom white-bg page-heading animated fadeInRight">
    <div class="col">
          <h2>Files </h2>
          <ol class="breadcrumb">
              <li class="breadcrumb-item">
                  <a href="{{ url('/admin_rcis/routes') }}" >Home</a>
              </li>
              <li class="breadcrumb-item">
                  <strong> Files </strong>
              </li>
          </ol>
    </div>
      
      <div class="col-lg-2" ng-if="my_files == false">
            <div class="form-group mb-0 mt-2">
              <label class="col-form-label" for="inputState">Origin</label>
            <select class="form-control" ng-options="emp.Fname as (emp.Fname +' '+ emp.Lname) for emp in users_list" ng-model="search_data.origin"></select>
      </div>
      </div>

      <!-- Category -->
      <div class="col-lg-2" ng-if="my_files == false">
            <div class="form-group mb-0 mt-2">
        <label class="col-form-label" for="inputState">Category</label>
        <select id="inputState" class="form-control" ng-model="search_data.category" ng-disabled="search_data.origin == undefined">
          <option value="" selected>All</option>
          <option value="Standard Drawing Plans"> Standard Drawing Plans </option>
          <option value="O&M Feedback Report"> O&M Feedback Report </option>
          <option value="Procurement Documents"> Procurement Documents </option>
          <option value="O&M Blgu certificate"> O&M Blgu certificate </option>
          <option value="O&M Billboard"> O&M Billboard </option>

          <option value="O&M"> O&M </option>
          <option value="Geo-Tagged Photos"> Geo-Tagged Photos </option>
          <option value="Publication"> Publication </option>
          <option value="Monitoring"> Monitoring </option>
          <option value="SI Report"> SI Report </option>

          <option value="Photo Documents"> Photo Documents </option>
          <option value="Field Report"> Field Report </option>
          <option value="Site Validation"> Site Validation </option>
          <option value="Presentation"> Presentation </option>
          <option value="Resolution"> Resolution </option>

          <option value="Spotcheck"> Spotcheck </option>
          <option value="Manuals"> Manuals </option>
          <option value="Letters"> Letters </option>
          <option value="Reports"> Reports </option>
          <option value="Minutes"> Minutes </option>

          <option value="LARR"> LARR </option>
          <option value="Policy"> Policy </option>
          <option value="Video"> Video </option>
          <option value="Memos"> Memos </option>
          <option value="Forms"> Forms </option>

          <option value="NOL"> NOL </option>
          <option value="Monthly Plan"> Monthly Plan </option>
          <option value="Accomplishments"> Accomplishments </option>
          <option value="Others"> Others </option>
        </select>
      </div>
      </div>

      <!-- Searching -->
      <div class="col-lg-3" ng-if="my_files == false" ng-cloak>
        <div class="form-group mb-0 mt-2">
          <label class="col-form-label">Search</label>
          <input class="form-control" type="text" name="search_files" placeholder="ex. Filename.pdf" ng-model="search_data.name" ng-disabled="search_data.category == undefined">
        </div>
      </div>

      <div class="col-lg-2">
        <button class="btn btn-warning btn-block" ng-if="my_files == true" style="border-radius: 26px !important; margin-top: 40px;" ng-click="go_Back_to_all_files()" ng-cloak> Back <i class="fa fa-undo"></i> </button>

        <button ng-if="my_files == false" class="btn btn-secondary btn-block" style="border-radius: 26px !important; margin-top: 40px;" ng-click="show_my_files()" ng-cloak> My files <i class="fa fa-archive"></i> </button>
      </div>
  </div>

  <div class="wrapper wrapper-content animated fadeInRight ecommerce px-0 pb-0" ng-if="my_files == false" ng-cloak>
      <div class="row ibox-content tbl">
        <div class="col-lg-12">
          <div class="row">
        @verbatim
        <div class="col-lg-3"  ng-repeat="all_files in bars = (all_file | filter: search_data.name | filter: search_data.category | filter: search_data.origin)" ng-cloak>
          <p class="py-2 mb-0 pl-2 text-truncate" style="border-left:solid 2px #007bff; max-width: 290px;">
            <b>Filename:</b> <span ng-bind="all_files.filename"></span>
          </p>
          <p class="py-2 pl-2" style="border-left:solid 2px #007bff;">
            <b>Category:</b> <span ng-bind="all_files.category"></span> <br>
            <b>Origin:</b> <span ng-bind="(all_files.users.Fname +' '+ all_files.users.Lname)"></span> <br>
            <small> <b>Uploaded On:</b> <span ng-bind="all_files.updated_at | date:'fullDate'"></span> </small> <br>
            <button class="btn btn-light" style="border-radius: 26px;"> <i class="fa fa-download"></i> <a class="text-secondary" href="/download/{{all_files.id}}"> Download </a> </button>
          </p>

          </p>
        </div>
        @endverbatim
          </div>
        </div>
      </div>
  </div>

  <div class="wrapper wrapper-content animated fadeInRight ecommerce px-0 pb-0" ng-if="my_files == true" ng-cloak>
      <div class="row">
        <div class="col-lg-3" style="border-radius: 0.25rem;">
          <div class="form-group mb-5">
            <label for="inputState">Category</label>
            <small id="emailHelp" class="form-text text-muted">These tags helps in grouping your uploaded files</small>
              <select id="inputState" class="form-control" ng-model="uploaded_category">
                <option selected></option>
                <option value="SP_files"> SP files </option>
                <option value="Standard Drawing Plans"> Standard Drawing Plans </option>
                <option value="O&M Feedback Report"> O&M Feedback Report </option>
                <option value="Procurement Documents"> Procurement Documents </option>
                <option value="O&M Blgu certificate"> O&M Blgu certificate </option>
                <option value="O&M Billboard"> O&M Billboard </option>

                <option value="O&M"> O&M </option>
                <option value="Geo-Tagged Photos"> Geo-Tagged Photos </option>
                <option value="Publication"> Publication </option>
                <option value="Monitoring"> Monitoring </option>
                <option value="SI Report"> SI Report </option>

                <option value="Photo Documents"> Photo Documents </option>
                <option value="Field Report"> Field Report </option>
                <option value="Site Validation"> Site Validation </option>
                <option value="Presentation"> Presentation </option>
                <option value="Resolution"> Resolution </option>

                <option value="Spotcheck"> Spotcheck </option>
                <option value="Manuals"> Manuals </option>
                <option value="Letters"> Letters </option>
                <option value="Reports"> Reports </option>
                <option value="Minutes"> Minutes </option>

                <option value="LARR"> LARR </option>
                <option value="Policy"> Policy </option>
                <option value="Video"> Video </option>
                <option value="Memos"> Memos </option>
                <option value="Forms"> Forms </option>

                <option value="NOL"> NOL </option>
                <option value="Monthly Plan"> Monthly Plan </option>
                <option value="Accomplishments"> Accomplishments </option>
                <option value="Others"> Others </option>
              </select>
          </div>
      
          <div class="form-group mb-5">
            <div class="text-center">
              <input id="customFile" type="file" multiple ng-model="Upload_files" onchange="angular.element(this).scope().fileChanged(this)">
              <hr>
              <ul class="list-group mt-3" id="preview" style="max-height: 300px; overflow-y: auto;">
              </ul>
            </div>
          </div>

          <div class="form-group">
            <button class="btn btn-primary btn-block" style="border-radius: 0px;" ng-disabled="uploaded_category == null || uploaded_category == '' || file_upload.length == 0 || file_upload.length == null" ng-click="upload_file(uploaded_category)"> <i class="fa fa-upload"></i> Upload</button>
          </div>
        </div>

        <div class="col-lg-9">
          <div class="row">
        @verbatim
        <div class="col-lg-3"  ng-repeat="all_files in bars = (all_my_file_data | filter: search_data.name | filter: search_data.category | filter: search_data.origin)" ng-cloak>
          <p class="py-2 mb-0 pl-2 text-truncate" style="border-left:solid 2px #007bff; max-width: 290px;">
            <b>Filename:</b> <span ng-bind="all_files.filename"></span>
          </p>
          <p class="py-2 pl-2" style="border-left:solid 2px #007bff;">
            <b>Category:</b> <span ng-bind="all_files.category"></span> <br>
            <b>Origin:</b> <span ng-bind="(all_files.users.Fname +' '+ all_files.users.Lname)"></span> <br>
            <small> <b>Uploaded On:</b> <span ng-bind="all_files.updated_at | date:'fullDate'"></span> </small> <br>
            <button class="btn btn-light" style="border-radius: 26px;"> <i class="fa fa-download"></i> <a class="text-secondary" href="/download/{{all_files.id}}"> Download </a> </button>
          </p>

          </p>
        </div>
        @endverbatim
          </div>
        </div>
      </div>
  </div>
  
  @include('user_admin_rcis.logout_modal')
</div>
@endsection