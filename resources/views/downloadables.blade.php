@extends(Auth::check() ? 'layouts.dashboard' : 'layouts.app2')

@section('content')
<div class="container-fluid" style="margin-top: 100px;" ng-init="fetch_my_all_file(); fetch_users_list();">
  <div class="row">
    <div class="col-lg-5 mb-3">
    	<h1 class="font-weight-bold">Downloadables</h1>
	    <p class="font-weight-light"> View or download files from several users </p>
    </div>

    <div class="col-lg-1 mb-3 px-2 text-right">
      <div class="form-group">
        <label>Clear Filter </label><br>
        <button class="btn btn-danger" style="border-radius: 26px !important;" ng-click="clearFilter()"> &nbsp;&nbsp; <i class="fa fa-eraser"></i> &nbsp;&nbsp;</button>
      </div>
    </div>

    <div class="col-lg-2 mb-3 px-2">
      <label for="inputState">Origin</label>
       <select class="form-control" ng-options="emp.Fname as (emp.Fname +' '+ emp.Lname) for emp in users_list" ng-model="search_data.origin"></select>
    </div>

    <!-- Category -->
    <div class="col-lg-2 mb-3 px-2">
      <label for="inputState">Category</label>
      <select id="inputState" class="form-control" ng-model="search_data.category" ng-disabled="search_data.origin == undefined">
        <option value="" selected>All</option>

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

    <!-- Searching -->
    <div class="col-lg-2 mb-3 px-2">
      <div class="form-group">
        <label>Search</label>
        <input class="form-control" type="text" name="search_files" placeholder="ex. Filename.pdf" ng-model="search_data.name" ng-disabled="search_data.category == undefined">
      </div>
    </div>

  </div>

  <div class="row">
    @verbatim
    <div class="col-lg-3"  ng-repeat="all_files in bars = (all_file_data | filter: search_data.name | filter: search_data.category | filter: search_data.origin)" ng-cloak>
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
    <div class="col-lg-12 text-center" ng-if="bars.length == 0" ng-cloak>
      <h4 ng-cloak> Sorry, Your requested file is not in our database. </h4>
    </div>
  </div>
</div>
@endsection