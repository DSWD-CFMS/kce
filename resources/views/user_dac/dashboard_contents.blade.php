<!-- DASHBOARD -->
<div class="row animated fadeInRight" ng-init="fetch_dac_dashboard();show_profile();">
	<div class="col-lg-12">
		<div class="wrapper wrapper-content px-0 py-1">
			<div class="row">
				<div class="col-lg-3">
					<div class="ibox">
						<div class="ibox-content border-0 py-1 px-1">
							<h5 class="m-b-md">NOT YET STARTED</h5>
							<h1 class="text-secondary" style="cursor: pointer !important;">
								<i class="fa fa-play fa-rotate-270"></i> <span ng-bind="NYS"></span> SP's
							</h1>

							<h4 class="my-0 py-0"> <span class="font-weight-light">Percentage as to total SP's</h4>
							<div class="progress">
								@verbatim
									<div class="progress-bar progress-bar-striped progress-bar-animated bg-secondary" role="progressbar" style="width: {{NYS/(total_sp)*100 | number:2}}%;" aria-valuenow="{{NYS}}" aria-valuemin="0" aria-valuemax="{{NYS/(total_sp)*100 | number:2}}"><span ng-bind="NYS/(total_sp)*100 | number:2"></span></div>
								@endverbatim
							</div>
						</div>
					</div>
				</div>

				<div class="col-lg-3">
					<div class="ibox">
						<div class="ibox-content border-0 py-1 px-1">
							<h5 class="m-b-md">ON-GOING</h5>
							<h1 class="text-navy" style="cursor: pointer !important;">
								<i class="fa fa-play fa-rotate-270"></i> <span ng-bind="Ongoing"></span> SP's
							</h1>

							<h4 class="my-0 py-0"> <span class="font-weight-light">Percentage as to total SP's</h4>
							<div class="progress">
								@verbatim
									<div class="progress-bar progress-bar-striped progress-bar-animated bg-secondary" role="progressbar" style="width: {{Ongoing/(total_sp)*100 | number:2}}%;" aria-valuenow="{{Ongoing}}" aria-valuemin="0" aria-valuemax="{{Ongoing/(total_sp)*100 | number:2}}"><span ng-bind="Ongoing/(total_sp)*100 | number:2"></span></div>
								@endverbatim
							</div>
						</div>
					</div>
				</div>

				<div class="col-lg-3">
					<div class="ibox">
						<div class="ibox-content border-0 py-1 px-1">
							<h5 class="m-b-md" style="cursor: pointer !important;">COMPLETED</h5>
							<h1 class="text-success">
								<i class="fa fa-play fa-rotate-270"></i> <span ng-bind="Completed"></span> SP's
							</h1>
							<h4 class="my-0 py-0"> <span class="font-weight-light">Percentage as to total SP's</h4>
							<div class="progress">
								@verbatim
									<div class="progress-bar progress-bar-striped progress-bar-animated bg-secondary" role="progressbar" style="width: {{Completed/(total_sp)*100 | number:2}}%;" aria-valuenow="{{Completed}}" aria-valuemin="0" aria-valuemax="{{Completed/(total_sp)*100 | number:2}}"><span ng-bind="Completed/(total_sp)*100 | number:2"></span></div>
								@endverbatim
							</div>
						</div>
					</div>
				</div>

				<div class="col-lg-3">
					<div class="ibox">
						<div class="ibox-content border-0 py-1 px-1">
							<h5 class="m-b-md" style="cursor: pointer !important;">CANCELLED</h5>
							<h1 class="text-danger">
								<i class="fa fa-play fa-rotate-270"></i> <span ng-bind="Cancelled"></span> SP's
							</h1>
							<h4 class="my-0 py-0"> <span class="font-weight-light">Percentage as to total SP's</h4>
							<div class="progress">
								@verbatim
									<div class="progress-bar progress-bar-striped progress-bar-animated bg-secondary" role="progressbar" style="width: {{Cancelled/(total_sp)*100 | number:2}}%;" aria-valuenow="{{Cancelled}}" aria-valuemin="0" aria-valuemax="{{Cancelled/(total_sp)*100 | number:2}}"><span ng-bind="Cancelled/(total_sp)*100 | number:2"></span></div>
								@endverbatim
							</div>
						</div>
					</div>
				</div>					    

				<div class="col-lg-3">
					<div class="row">
						<div class="col-lg-12">
							<div class="ibox">
								<div class="ibox-content pb-0">
									<h5 class="m-b-md">MODALITIES</h5>

									<div class="row" ng-repeat="(key, value) in groupby_modality">
										<div class="col-lg-3">
											<img ng-if="key == 4" class="text-center rounded-circle" src="https://image.flaticon.com/icons/svg/2510/2510283.svg" style="width: 40px; height: 40px; object-position: center; object-fit: contain; background-color: #f3f3f4;">
											<img ng-if="key == 1" class="text-center rounded-circle" src="https://image.flaticon.com/icons/svg/1312/1312285.svg" style="width: 40px; height: 40px; object-position: center; object-fit: contain; background-color: #f3f3f4;">
											<img ng-if="key == 2" class="text-center rounded-circle" src="https://image.flaticon.com/icons/svg/3050/3050525.svg" style="width: 40px; height: 40px; object-position: center; object-fit: contain; background-color: #f3f3f4;">
											<img ng-if="key == 6" class="text-center rounded-circle" src="https://image.flaticon.com/icons/svg/1312/1312307.svg" style="width: 40px; height: 40px; object-position: center; object-fit: contain; background-color: #f3f3f4;">
											<img ng-if="key == 5" class="text-center rounded-circle" src="https://image.flaticon.com/icons/svg/3313/3313557.svg" style="width: 40px; height: 40px; object-position: center; object-fit: contain; background-color: #f3f3f4;">
											<img ng-if="key == 3" class="text-center rounded-circle" src="https://image.flaticon.com/icons/svg/1373/1373259.svg" style="width: 40px; height: 40px; object-position: center; object-fit: contain; background-color: #f3f3f4;">
										</div>
										<div class="col-lg-9">
											<h3 class="mb-0" style="font-weight: bold;" ng-if="key == 4">IP CDD - <span ng-bind="value.length +' SPs' "></span></h3>
											<h3 class="mb-0" style="font-weight: bold;" ng-if="key == 1">KKB - <span ng-bind="value.length +' SPs' "></span></h3>
											<h3 class="mb-0" style="font-weight: bold;" ng-if="key == 2">MAKILAHOK - <span ng-bind="value.length +' SPs' "></span></h3>
											<h3 class="mb-0" style="font-weight: bold;" ng-if="key == 6">L & E - <span ng-bind="value.length +' SPs' "></span></h3>
											<h3 class="mb-0" style="font-weight: bold;" ng-if="key == 5">CCL - <span ng-bind="value.length +' SPs' "></span></h3>
											<h3 class="mb-0" style="font-weight: bold;" ng-if="key == 3">NCDDP - <span ng-bind="value.length +' SPs' "></span></h3>
										</div>
									</div>
								</div>
							</div>
						</div>	
						<div class="col-lg-12">
							<div class="ibox">
								<div class="ibox-content pb-0">
									<h5 class="m-b-md">WEIGHTED PERCENTAGE</h5>
									<h1 class="text-secondary">
										<i class="fa fa-play fa-rotate-270"></i> <span ng-bind="my_sp_actual_weighted | number:2"></span>%
									</h1>

									<div class="" style="height: 1rem;">
										<span><i> Weighted Percentage of ON-GOING </i></span>
									</div>
								</div>
							</div>
						</div>	
					</div>
				</div>
				
				<!-- Latest updated SP -->
				<div class="col-lg-9">
					<h5>LATEST UPDATED SP</h5>
					<div class="table-responsive">
						<table class="table table-bordered">
							<thead class="thead-dark">
								<tr>
									<th class="py-1">SP ID</th>
									<th class="py-1">TITLE</th>
									<th class="py-1">PROVINCE</th>
									<th class="py-1">MUNICIPALITY</th>
									<th class="py-1">BRGY</th>
								</tr>
							</thead>
							<tbody>
								<tr ng-show="$last" ng-repeat="data in sp_ongoing_all_sp_logs">
									<td ng-bind="data.sp[0].sp_id"></td>
									<td ng-bind="data.sp[0].sp_title"></td>
									<td ng-bind="data.sp[0].sp_province"></td>
									<td ng-bind="data.sp[0].sp_municipality"></td>
									<td ng-bind="data.sp[0].sp_brgy"></td>
								</tr>
							</tbody>
						</table>
					</div>
					@verbatim
					<div ng-init="chart_dashboard()" ng-cloak>
						<canvas id="myChart" style="width: 100%; height: 250px;"></canvas>
					</div>
					@endverbatim
				</div>
			</div>
		</div>
	</div>
</div>