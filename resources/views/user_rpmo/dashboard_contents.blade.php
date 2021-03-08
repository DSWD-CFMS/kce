<!-- DASHBOARD -->
<div class="row animated fadeInRight" ng-init="fetch_rpmo_dashboard()">
	<div class="col-lg-12">
		<div class="wrapper wrapper-content">
			<div class="row">
				<!-- Percentage as to total SP's -->
			    <div class="col-lg-3">
                    <div class="ibox">
                        <div class="ibox-content">
                            <h5 class="m-b-md">NOT YET STARTED</h5>
                            <h1 class="text-secondary">
                                <i class="fa fa-play fa-rotate-270"></i> <span ng-bind="nys_count"></span> SP's
                            </h1>

                            <h4 class="my-0 py-0"> <span class="font-weight-light">Percentage as to total SP's</h4>
                            <div class="progress">
                            	@verbatim
									<div class="progress-bar progress-bar-striped progress-bar-animated bg-secondary" role="progressbar" style="width: {{nys_count/(nys_count+ongoing_count+completed_count)*100 | number:2}}%;" aria-valuenow="{{nys_count/(nys_count+ongoing_count+completed_count)*100 | number:2}}" aria-valuemin="0" aria-valuemax="100"><span class="text-dark font-weight-bold" ng-bind="(nys_count/(nys_count+ongoing_count+completed_count)*100 | number:2) +'%'"></span></div>
                            	@endverbatim
							</div>
                        </div>
                    </div>
			    </div>

			    <div class="col-lg-3">
                    <div class="ibox">
                        <div class="ibox-content">
                            <h5 class="m-b-md">ON-GOING</h5>
                            <h1 class="text-navy">
                                <i class="fa fa-play fa-rotate-270"></i> <span ng-bind="ongoing_count"></span> SP's
                            </h1>

                            <h4 class="my-0 py-0"> <span class="font-weight-light">Percentage as to total SP's</h4>
                            <div class="progress">
                            	@verbatim
									<div class="progress-bar progress-bar-striped progress-bar-animated bg-secondary" role="progressbar" style="width: {{ongoing_count/(nys_count+ongoing_count+completed_count)*100 | number:2}}%;" aria-valuenow="{{ongoing_count/(nys_count+ongoing_count+completed_count)*100 | number:2}}" aria-valuemin="0" aria-valuemax="100"><span class="text-dark font-weight-bold" ng-bind="(ongoing_count/(nys_count+ongoing_count+completed_count)*100 | number:2) +'%'"></span></div>
                            	@endverbatim
							</div>
                        </div>
                    </div>
			    </div>

			    <div class="col-lg-3">
                    <div class="ibox">
                        <div class="ibox-content">
                            <h5 class="m-b-md">COMPLETED</h5>
                            <h1 class="text-success">
                                <i class="fa fa-play fa-rotate-270"></i> <span ng-bind="completed_count"></span> SP's
                            </h1>

                            <h4 class="my-0 py-0"> <span class="font-weight-light">Percentage as to total SP's</h4>
                            <div class="progress">
                            	@verbatim
									<div class="progress-bar progress-bar-striped progress-bar-animated bg-secondary" role="progressbar" style="width: {{completed_count/(nys_count+ongoing_count+completed_count)*100 | number:2}}%;" aria-valuenow="{{completed_count/(nys_count+ongoing_count+completed_count)*100 | number:2}}" aria-valuemin="0" aria-valuemax="100"><span class="text-dark font-weight-bold" ng-bind="(completed_count/(nys_count+ongoing_count+completed_count)*100 | number:2) +'%'"></span></div>
                            	@endverbatim
							</div>
                        </div>
                    </div>
			    </div>

			    <div class="col-lg-3">
                    <div class="ibox">
                        <div class="ibox-content">
                            <h5 class="m-b-md">WEIGHTED PERCENTAGE</h5>
                            <h1 class="text-secondary">
                                <i class="fa fa-play fa-rotate-270"></i> <span ng-bind="actual_weighted"></span>%
                            </h1>

                            <h4 class="my-0 py-0"> <span class="font-weight-light">&nbsp;</h4>
                            <div class="" style="height: 1rem;">
                            	<span><i> Weighted Percentage of ON-GOING </i></span>
							</div>
                        </div>
                    </div>
			    </div>

			    <!-- Latest updated SP -->
			    <div class="col-lg-12">
			      <div class="ibox">
				      <div class="ibox-title">
				        <h2>LATEST UPDATED SP</h2>
				      </div>
				      <div class="ibox-content font-weight-bold">
					  	@verbatim
						<div id="accordion">
						  	<div class="row" style="cursor: pointer;">
						  		<div class="col-lg-12">
								  	<div class="row mt-2">
						            	<div class="col text-warning mb-2"> <b>SP ID </b> </div>
						            	<div class="col text-warning mb-2"> <b>SP TITLE</b> </div>
						            	<div class="col text-warning mb-2"> <b>MUNICIPALITY</b> </div>
						            	<div class="col text-warning mb-2"> <b>BARANGAY</b> </div>
						            	<div class="col text-warning mb-2"> <b>CYCLE</b> </div>
						            	<div class="col text-warning mb-2"> <b>BATCH</b> </div>
						            	<div class="col text-warning mb-2"> <b>CATEGORY</b> </div>
						            	<div class="col text-warning mb-2"> <b>TYPE</b> </div>
								  	</div>
						  			<div class="row" ng-cloak>
							      		<div class="col" ng-bind="my_sp_data[0].sp_id"></div>
							      		<div class="col" ng-bind="my_sp_data[0].sp_title"></div>
							      		<div class="col" ng-bind="my_sp_data[0].sp_municipality"></div>
							      		<div class="col" ng-bind="my_sp_data[0].sp_brgy"></div>
							      		<div class="col" ng-bind="my_sp_data[0].sp_cycle"></div>
							      		<div class="col" ng-bind="my_sp_data[0].sp_batch"></div>
							      		<div class="col" ng-bind="my_sp_data[0].sp_category.category"></div>
							      		<div class="col" ng-bind="my_sp_data[0].sp_type.type"></div>
						  			</div>
						  		</div>	
						  	</div>
							<div class="container-fluid">
							<div class="row">
								<div class="col-lg-12" ng-cloak>
								<canvas id="myChart" style="width: 100%;"></canvas>
								</div>
							</div>
							</div>
						</div>
					  	@endverbatim
				      </div>
			      </div>
			    </div>
			</div>
		</div>
	</div>
</div>