<!-- MODALITY -->
<div class="row wrapper border-bottom white-bg page-heading justify-content-end animated fadeInRight" ng-init="fetch_rpmo_reports();show_profile()">
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
