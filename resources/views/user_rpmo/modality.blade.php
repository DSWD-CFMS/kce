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
</style>
<!-- MODALITY -->
<div id="page-wrapper" class="gray-bg dashbard-1" ng-init="fetch_my_modalities();show_profile()">
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
    <!-- LogOut Modal -->
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
  </div>

	<div class="row" ng-class="{'justify-content-center': fetch_rpmo_modality_div == false}">
		<div class="col-sm-12 text-center" ng-hide="fetch_rpmo_modality_div == true">
			<h1 class="font-weight-light">Choose a modality to generate</h1>
		</div>

		<div class="col-sm-2 text-center py-3 px-3" ng-repeat="modalities in my_modality">
			<!-- <i ng-class="{'fa fa-road fa-3x': modalities.sp_groupings[0].grouping == 'NCDDP', 'fa fa-bug fa-3x': modalities.sp_groupings[0].grouping == 'KKB', 'fa fa-gitlab fa-3x': modalities.sp_groupings[0].grouping == 'IP CDD', 'fa fa-street-view fa-3x': modalities.sp_groupings[0].grouping == 'MAKILAHOK', 'fa fa-envira fa-3x': modalities.sp_groupings[0].grouping == 'CCL', 'fa fa-heartbeat fa-3x': modalities.sp_groupings[0].grouping == 'LandE'}"></i> -->
			<img ng-if="modalities.sp_groupings[0].grouping == 'IP CDD'" class="text-center rounded-circle" src="https://image.flaticon.com/icons/svg/2510/2510283.svg" style="width: 100px; height: 100px; object-position: center; object-fit: contain; background-color: #f3f3f4;border: solid 3px #e0e0e0;">

			<img ng-if="modalities.sp_groupings[0].grouping == 'KKB'" class="text-center rounded-circle" src="https://image.flaticon.com/icons/svg/1312/1312285.svg" style="width: 100px; height: 100px; object-position: center; object-fit: contain; background-color: #f3f3f4;border: solid 3px #e0e0e0;">

			<img ng-if="modalities.sp_groupings[0].grouping == 'MAKILAHOK'" class="text-center rounded-circle" src="https://image.flaticon.com/icons/svg/3050/3050525.svg" style="width: 100px; height: 100px; object-position: center; object-fit: contain; background-color: #f3f3f4;border: solid 3px #e0e0e0;">
		
			<img ng-if="modalities.sp_groupings[0].grouping == 'LandE'" class="text-center rounded-circle" src="https://image.flaticon.com/icons/svg/1312/1312307.svg" style="width: 100px; height: 100px; object-position: center; object-fit: contain; background-color: #f3f3f4;border: solid 3px #e0e0e0;">

			<img ng-if="modalities.sp_groupings[0].grouping == 'CCL'" class="text-center rounded-circle" src="https://image.flaticon.com/icons/svg/3313/3313557.svg" style="width: 100px; height: 100px; object-position: center; object-fit: contain; background-color: #f3f3f4;border: solid 3px #e0e0e0;">

			<img ng-if="modalities.sp_groupings[0].grouping == 'NCDDP'" class="text-center rounded-circle" src="https://image.flaticon.com/icons/svg/1373/1373259.svg" style="width: 100px; height: 100px; object-position: center; object-fit: contain; background-color: #f3f3f4;border: solid 3px #e0e0e0;">

			<button class="btn btn-outline-primary btn-block mt-2 rounded-0" ng-click="fetch_rpmo_modality(modalities.sp_groupings[0].id)">
				<span ng-bind="modalities.sp_groupings[0].grouping"></span>
			</button>
		</div>
	</div>

	<!-- MODALITY -->
	<div class="row animated fadeInDown" ng-if="fetch_rpmo_modality_div == true" ng-cloak>
		<div class="col-lg-12">
			<nav>
			  <div class="nav nav-tabs" id="nav-tab" role="tablist">
			    <a class="nav-item nav-link active rounded-0" id="nav-profile-tab" data-toggle="tab" href="#nav-nys" role="tab" aria-controls="nav-profile" aria-selected="false"> <spab class="text-success"> <span ng-bind="modality_type"></span> : NYS projects</span> </a>

			    <a class="nav-item nav-link rounded-0" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true"> <spab class="text-primary"> <span ng-bind="modality_type"></span> : On-going projects</spab> </a>

			    <a class="nav-item nav-link rounded-0" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false"> <spab class="text-success"> <span ng-bind="modality_type"></span> : Completed projects</span> </a>
			  </div>
			</nav>
			<div class="tab-content" id="nav-tabContent">

			<!-- NYS -->
			@include('user_rpmo.modality_nys')

			<!-- ON GOING -->
			@include('user_rpmo.modality_ongoing')
			
			<!-- COMPLETED -->
			@include('user_rpmo.modality_completed')

			</div>
		</div>
	</div>
	@include('user_rpmo.modality_modal')
</div>
@endsection