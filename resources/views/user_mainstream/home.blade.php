@extends('layouts.dashboard')

@section('content')
<style type="text/css">
  .card, .card .card-footer{
    border-radius: 0px;
  }

  .orange{
    color: #fdab14;
  }

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
  height: 35px;
  font-size: 14px;
  color:#007bff;
  line-height: 32px;
  content: 'Select files to upload';
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

.bd-placeholder-img{
  object-fit: cover;
}

.bg_yellow_d_1{
  background-color: #f8951b !important;
  color: #ffffff;
}

.bg_yellow_d_2{
  background-color: #f8821b !important;
  color: #ffffff;
}
</style>

<div id="page-wrapper" class="gray-bg dashbard-1" ng-init="fetch_mainstream_dashboard()">
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
  
	<!-- DASHBOARD -->
	<div ng-if="fetch_mainstream_dashboard_div == true" ng-cloak>
		<div class="row animated fadeInRight">
			<div class="col-lg-12">
				<div class="wrapper wrapper-content">
					<div class="row">
					    <div class="col-lg-4">
			                <div class="widget style1 bg_yellow_d_2">
			                    <div class="row">
			                        <div class="col-4">
			                            <i class="fa fa-stack-overflow fa-5x"></i>
			                        </div>
			                        <div class="col-8 text-right">
			                            <span> REVIEWED SPCR </span>
			                            <h2 class="font-bold">12</h2>
			                        </div>
			                    </div>
			                </div>
					    </div>
					    <div class="col-lg-4">
					    	<div class="widget style1 bg_yellow_d_1">
			                    <div class="row">
			                        <div class="col-4">
			                            <i class="fa fa-file-text fa-5x"></i>
			                        </div>
			                        <div class="col-8 text-right">
			                            <span> COMPLETED SP </span>
			                            <h2 class="font-bold">12</h2>
			                        </div>
			                    </div>
			                </div>
					    </div>
					    <div class="col-lg-4">
					    	<div class="widget style1 navy-bg">
			                    <div class="row">
			                        <div class="col-4">
			                            <i class="fa fa-file fa-5x"></i>
			                        </div>
			                        <div class="col-8 text-right">
			                            <span> ON-GOING SP </span>
			                            <h2 class="font-bold">1</h2>
			                        </div>
			                    </div>
			                </div>
					    </div>
					</div>

					<div class="row">
						<div class="col-md-12">
							<div class="ibox">
								<div class="ibox-title">
									<h2 class="mb-0">Latest Submitted SPCR</h2>
									<p class="mt-0 mb-0 py-0" style="font-size: .8em;">Thusday January 30, 2020</p>
								</div>
								<div class="ibox-content font-weight-bold" style="font-size: 18px;">
									<div class="row">
										<div class="col">
											<label class="text-navy" style="margin-bottom: 0px;"> <small>SP Title</small> </label>
											<p> Construction of feelings </p>

											<label class="text-navy" style="margin-bottom: 0px;"> <small>MODALITY | Assigned Focal</small> </label>
											<p style="font-size: .8em;"> <span>IP CDD</span> |
												<span class="font-weight-light">
													<span>Wilfredo Aparicio Jr.</span>, <span>Potamio Valdehueza</span>
												</span>
											</p>

											<label class="text-navy" style="margin-bottom: 0px;"> <small>Assigned DAC</small> </label>
											<p style="font-size: .8em;">Juan Pablo Quiñal</p>
										</div>

										<div class="col">
											
										</div>
										
										<div class="col">
											
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div ng-if="fetch_mainstream_spcrs_div == true" ng-cloak>
		@include('user_mainstream.spcr')
	</div>

	<div ng-if="fetch_mainstream_upload_div == true" ng-cloak>
		@include('user_mainstream.upload')
	</div>

</div>

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
@include('user_dac.reports_modal')
@endsection