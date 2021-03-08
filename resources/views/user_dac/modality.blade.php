@extends('layouts.dashboard')

@section('content')
<style type="text/css">
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

	.text-label-blue{
		color: #007bff !important;
	}

/*	.table-bordered1 {
	  border: .1px solid #000;
	}*/

	.table-bordered1 tr {
	  border-top: .1px solid #000 !important;
	}

	tr {
	  display:flex;
	  flex-wrap:wrap; /* allow to wrap on multiple rows */
	}
	td,th {
	  display:block;
	  flex:1 /* to evenly distributs flex elements */
	}

	.collapsed_td {
	  width:100%; /* fill entire width,row */
	  flex:auto; /* reset the flex properti to allow width take over */
	}

</style>
<div id="page-wrapper" class="gray-bg dashbard-1" ng-init="my_subprojects();show_profile()">
<!-- <div id="page-wrapper" class="gray-bg dashbard-1" ng-init="fetch_dac_dashboard_modalities();show_profile()"> -->
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

<!-- 	<div class="row" ng-class="{'justify-content-center': fetch_dac_modality_div == false}">
		<div class="col-sm-12 text-center" ng-hide="fetch_dac_modality_div == true">
			<h2 class="font-weight-light mb-0">Choose a modality to generate</h2>
		</div>
		<div class="col-sm-2 text-center py-3 px-3" ng-repeat="modalities in my_modality">
			<img ng-if="modalities.sp_groupings.grouping == 'IP CDD'" ng-cloak class="text-center rounded-circle" src="https://image.flaticon.com/icons/svg/2510/2510283.svg" style="width: 100px; height: 100px; object-position: center; object-fit: contain; background-color: #f3f3f4;border: solid 3px #e0e0e0;">

			<img ng-if="modalities.sp_groupings.grouping == 'KKB'" ng-cloak class="text-center rounded-circle" src="https://image.flaticon.com/icons/svg/1312/1312285.svg" style="width: 100px; height: 100px; object-position: center; object-fit: contain; background-color: #f3f3f4;border: solid 3px #e0e0e0;">

			<img ng-if="modalities.sp_groupings.grouping == 'MAKILAHOK'" ng-cloak class="text-center rounded-circle" src="https://image.flaticon.com/icons/svg/3050/3050525.svg" style="width: 100px; height: 100px; object-position: center; object-fit: contain; background-color: #f3f3f4;border: solid 3px #e0e0e0;">
		
			<img ng-if="modalities.sp_groupings.grouping == 'LandE'" ng-cloak class="text-center rounded-circle" src="https://image.flaticon.com/icons/svg/1312/1312307.svg" style="width: 100px; height: 100px; object-position: center; object-fit: contain; background-color: #f3f3f4;border: solid 3px #e0e0e0;">

			<img ng-if="modalities.sp_groupings.grouping == 'CCL'" ng-cloak class="text-center rounded-circle" src="https://image.flaticon.com/icons/svg/3313/3313557.svg" style="width: 100px; height: 100px; object-position: center; object-fit: contain; background-color: #f3f3f4;border: solid 3px #e0e0e0;">

			<img ng-if="modalities.sp_groupings.grouping == 'NCDDP'" ng-cloak class="text-center rounded-circle" src="https://image.flaticon.com/icons/svg/1373/1373259.svg" style="width: 100px; height: 100px; object-position: center; object-fit: contain; background-color: #f3f3f4;border: solid 3px #e0e0e0;">
			<button class="btn btn-outline-primary btn-block mt-3 btn-lg rounded-0" ng-click="fetch_dac_modality_sp(modalities.sp_groupings.id)">
				<span ng-bind="modalities.sp_groupings.grouping"></span>
			</button>
		</div>
	</div>
 -->

	<div class="row wrapper border-bottom white-bg page-heading justify-content-end animated fadeInRight">
		<div class="col-lg-8">
		  <h2> Modality </h2>
		  <ol class="breadcrumb">
		      <li class="breadcrumb-item">
		        <a href="{{ url('/admin_rcis/routes') }}" >Homssse</a>
		      </li>
		      <li class="breadcrumb-item">
		          <strong> Modality </strong>
		      </li>
		  </ol>
		</div>

		<div class="col-lg-4" style="margin-top: 40px;">
			<div class="input-group">
				<div class="input-group-prepend">
				  <a class="btn btn-outline-secondary rounded-0" href="{{ url('/dac/routes/show_modality') }}"> <i class="fa fa-refresh"></i> </a>
				</div>
				<input class="form-control nav-item nav-link" style="border: 1px solid;" type="text" name="" placeholder="Search..." ng-model="search_data_modality.$">
<!-- 				<div class="input-group-prepend">
				  <button class="btn btn-outline-primary rounded-0" ng-if="search_data_modality.$ == null || search_data_modality.$.length == 0" ng-click="Export_All_Data()"> Export <i class="fa fa-external-link"></i> </button>
				  <button class="btn btn-outline-success rounded-0" ng-if="search_data_modality.$.length > 0" ng-click="Export_Modal_Data()"> Export <i class="fa fa-external-link"></i> </button>
				</div> -->
			</div>
		</div>
	</div>

 	@include('user_dac.subprojects')

	<!-- LOG OUT MODAL -->
	<div class="modal inmodal fade" id="exampleModal" tabindex="-1" role="dialog"  aria-hidden="true">
	    <div class="modal-dialog modal-sm">
	        <div class="modal-content animated bounceInRight">
	            <div class="modal-header py-2 px-3">
	                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
	            </div>
	      		<div class="modal-body">
	        		<p class="modal-title" id="exampleModalLabel">Ready to Leave?</p>
	      			<h5>
	      				Select "Sign out" below if you are ready to end your current session.
	      			</h5>
	      		</div>
		      <div class="modal-footer">
				<button class="btn btn-white" type="button" data-dismiss="modal">Cancel</button>
		        <a class="btn btn-primary" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"> Sign out</a>
		    	<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
		      		@csrf
		    	</form>
		      </div>
	        </div>
	    </div>
	</div>

@include('user_dac.modality_modal')
</div>
@endsection
