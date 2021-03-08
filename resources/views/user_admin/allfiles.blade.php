<!-- UPLOAD -->
<style type="text/css">
  /*uploads css*/
  input[type=file] {
  cursor: pointer;
  width: 100%;
  height: 42px;
  overflow: hidden;
  color:transparent;
  }

  input[type=file]:before {
  width: 100%;
  height: 38px;
  font-size: 16px;
  color:#007bff;
  line-height: 32px;
  content: 'Drop/Select files to be uploaded' !important;
  display: inline-block;
  background: white;
  border: 2px solid #007bff;
  border-radius: 26px;
  text-align: center;
  font-family: Helvetica, Arial, sans-serif;
  }

  input[type=file]::-webkit-file-upload-button {
  visibility: hidden !important;
  }
</style>
<div class="row wrapper border-bottom white-bg page-heading justify-content-center animated fadeInRight" ng-init="fetch_all_file();fetch_users_list();show_profile();">

	<div class="col-lg-9">
		<h2> Uploads </h2>
		<ol class="breadcrumb">
		  <li class="breadcrumb-item">
		    <a href="{{ url('/admin/routes') }}" >Dashboard</a>
		  </li>
		  <li class="breadcrumb-item">
		      <strong> Uploads </strong>
		  </li>
		  <li class="breadcrumb-item">
		      <strong class="text-warning"> All files </strong>
		  </li>
		</ol>
	</div>

	<div class="col-lg-3">
		<h3> &nbsp; </h3>
		<div class="input-group">
			<div class="input-group-prepend">
			  <a class="btn btn-outline-secondary rounded-0" href="{{ url('/admin/routes/files/myfiles') }}"> My files <i class="fa fa-inbox"></i> </a>
			</div>
			<a class="btn btn-outline-secondary rounded-0" href="{{ url('/admin/routes/files/allfiles') }}"> All files <i class="fa fa-files-o"></i> </a>
      <div class="input-group-prepend">
        <a class="btn btn-outline-secondary rounded-0" href="{{ url('/admin/routes/files') }}"> Upload a file <i class="fa fa-upload"></i> </a>
      </div>            
		</div>
	</div>

</div>

<div class="row pt-1">
  <div class="col-lg-2 mb-3">
    <label for="inputState">Origin</label>
     <select class="form-control" ng-options="emp.Fname as (emp.Fname +' '+ emp.Lname) for emp in users_list" ng-model="search_data.origin"></select>
  </div>

  <!-- Category -->
  <div class="col-lg-2 mb-3 px-2">
    <label for="inputState">Category</label>
    <select id="inputState" class="form-control" ng-model="search_data.category" ng-disabled="search_data.origin == undefined">
      <option value="" selected>All</option>
      <option value="SP_files_BP"> SP files | Building Permit</option>
      <option value="SP_files_FP"> SP files | Fullblown Proposal</option>
      <option value="SP_files_VO"> SP files | Variation Order</option>
      <option value="SP_files_MT"> SP files | Materials Testing</option>
      <option value="SP_files_EMSR"> SP files | ESMR </option>
      <option value="SP_files_CSR"> SP files | CSR </option>
      <option value="SP_files_SPCR"> SP files | SPCR </option>

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
      <input class="form-control" type="text" name="search_files" placeholder="ex. Filename.pdf" ng-model="search_data.name">
    </div>
  </div>

  <div class="col-lg-1 mb-3 px-2">
    <div class="form-group">
      <label>Clear Filter </label><br>
      <button class="btn btn-danger" style="border-radius: 26px !important;" ng-click="clearFilter()"> &nbsp;&nbsp; <i class="fa fa-eraser"></i> &nbsp;&nbsp;</button>
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
      <small ng-if="all_files.sp_id != null"> <b>Subproject ID:</b> <span ng-bind="all_files.sp_id"></span> </small> <br>
      <button class="btn btn-light" style="border-radius: 26px;"> <i class="fa fa-download"></i> <a class="text-secondary" href="/download/{{all_files.id}}" target="_blank"> Download </a> </button>
    </p>
  </div>
  @endverbatim
  <div class="col-lg-12 text-center" ng-if="bars.length == 0" ng-cloak>
    <h4 ng-cloak> Sorry, Your requested file is not in our database. </h4>
  </div>
</div>
