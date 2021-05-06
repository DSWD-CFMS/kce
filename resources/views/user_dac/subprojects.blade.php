<div class="row wrapper animated fadeInRight ecommerce px-0 pb-0 " ng-init="my_subprojects()">
	<div class="col-lg-12 my-2">
		<label class="text-muted"><small size="1"><span ng-if="my_modality.from!=null" ng-bind="'Showing records '+my_modality.from+'-'+my_modality.to+' out of '+my_modality.total"></span></small></label>
		<!-- <label class="text-muted"><small> Displaying 10 out of 1080 items </small></label> -->
			<ul class="pagination">

					<!-- Pag previous sa page  -->
			<li class="page-item disabled" ng-if="my_modality.current_page == 1">
				<a style="text-transform: none;" class="page-link text-secondary" href="">Previous</a>
			</li>
			<li class="page-item" ng-if="my_modality.current_page!=1" ng-click="Previous_Pagination_SP(my_modality.prev_page_url)"><a style="text-transform: none;" class="page-link text-secondary" href="">Previous</a></li>

			<!-- Pag adto sa first page -->
			<li class="page-item" ng-class="{'invisible' : my_modality.current_page == 1 || my_modality.current_page == 2 || my_modality.current_page == 3 || my_modality.last_page> 3 && my_modality.last_page < 6}" ng-click="Skip_To_Page_SP(my_modality.path,1)">
			<a style="text-transform: none;" class="page-link text-secondary" href="">1</a>
			</li>

			<!-- Mag add ug (...) if ang current page is 4 pataas -->
			<li class="page-item disabled" ng-class="{'invisible' : my_modality.current_page == 1 || my_modality.current_page == 2 || my_modality.current_page == 3 ||my_modality.last_page>3&&my_modality.last_page<6}">
				<a style="text-transform: none;" class="page-link text-secondary" href="">...</a>
			</li>   

			<!-- Number of Pages -->
			<li ng-repeat="x in [].constructor(my_modality.last_page) track by $index" ng-click="Skip_To_Page_SP(my_modality.path,$index+1)">
				<a style="text-transform: none;" ng-class="{'bg-success active text-light': $index+1 == my_modality.current_page, 'invisible' : my_modality.current_page+1 < $index && $index > 5 || my_modality.current_page - 5 >$index && $index <my_modality.last_page-5}"  class="page-link text-secondary" href="" ng-bind="$index+1"></a>
			</li>

			<!-- Pag add ug (...) -->
			<li class="page-item disabled" ng-class="{'invisible' : my_modality.current_page == my_modality.last_page || my_modality.current_page == my_modality.last_page-1 || my_modality.current_page == my_modality.last_page-2||my_modality.last_page>3&&my_modality.last_page<6}">
			<a style="text-transform: none;" class="page-link text-secondary" href="">...</a>
			</li>

			<!-- Pag adto sa last page last page -->
			<li class="page-item" ng-class="{'invisible' : my_modality.current_page == my_modality.last_page || my_modality.current_page == my_modality.last_page-1 || my_modality.current_page == my_modality.last_page-2 || my_modality.last_page>3&&my_modality.last_page<6}" ng-click="Skip_To_Page_SP(my_modality.last_page)">
			<a style="text-transform: none;" class="page-link text-secondary" href="" ng-bind="my_modality.last_page"></a>
			</li>

			<!-- Pag Next sa Pages -->
			<li class="page-item">
				<a style="text-transform: none;" class="page-link text-secondary" href="" ng-click="Next_Pagination_SP(my_modality.next_page_url)">Next</a></li>
			</ul>
	</div>
</div>

<div class="wrapper wrapperr-content animated fadeInRight ecommerce px-0 pb-0" id="accordion3">
	<div class="table-responsive" style="height: 35px;">
		<table class="table" style="margin-bottom: 0px !important;overflow: none !important;">
				<thead class="thead-dark">
					<tr style="font-size: 10px;">
						<th scope="col">SP TITLE</th>
						<th scope="col">MUNICIPALITY</th>
						<th scope="col">BARANGAY</th>
						<th scope="col">PLANNED</th>
						<th scope="col">ACTUAL</th>
						<th scope="col">SLIPPAGE</th>
						<th scope="col">STATUS</th>
						<th scope="col">ACTIONS</th>
					</tr>
				</thead>
				<tbody style="overflow: none !important;">
				</tbody>
		</table>
	</div>
	<div class="table-responsive" style="height: 400px;">
			<table class="table table-bordered1">
				<tbody style="overflow-y: auto !important; overflow-x: none !important;">
					<tr  ng-class="{'text-green' : all_data.status == 'Completed','text-yellow' : all_data.status == 'On-going'}" style="font-size: 11px;" ng-repeat="all_data in bars = (my_modality.data | filter:search_data_modality) track by $index">

						<td ng-class="{'text-green' : all_data.status == 'Completed'}" ng-bind="all_data.sp[0].sp_title"></td>
						<td ng-class="{'text-green' : all_data.status == 'Completed'}" ng-bind="all_data.sp[0].sp_municipality | uppercase"></td>
						<td ng-class="{'text-green' : all_data.status == 'Completed'}" ng-bind="all_data.sp[0].sp_brgy | uppercase"></td>
						<td>
							<div ng-if="all_data.sp[0].sp_logs.length > 0" ng-repeat="logs_planned in all_data.sp[0].sp_logs track by $index">
								<span ng-show="$last" ng-bind="(logs_planned.sp_logs_planned) + '%'" ></span>
							</div>
							<span ng-if="all_data.sp[0].sp_logs.length == 0" >NONE</span>
						</td>

						<td ng-class="{'text-green' : all_data.status == 'Completed'}">
							<div ng-if="all_data.sp[0].sp_logs.length > 0" ng-repeat="logs_planned in all_data.sp[0].sp_logs track by $index">
							<span ng-show="$last" ng-bind="(logs_planned.sp_logs_actual) + '%'"></span>
							</div>
							<span ng-if="all_data.sp[0].sp_logs.length == 0" >NONE</span>
						</td>

						<td>
							<div ng-if="all_data.sp[0].sp_logs.length > 0" ng-repeat="logs_planned in all_data.sp[0].sp_logs track by $index">
								<span ng-class="{'text-green' : all_data.status == 'Completed', 'text-green' : logs_planned.sp_logs_slippage >= 0, 'text-danger' : logs_planned.sp_logs_slippage < 0}" ng-show="$last" ng-bind="(logs_planned.sp_logs_slippage) + '%'"></span>
							</div>
							<span ng-if="all_data.sp[0].sp_logs.length == 0" >NONE</span>
						</td>

						<td ng-class="{'text-green' : all_data.status == 'Completed' | 'text-yellow' : all_data.status == 'On-going'}" ng-bind="all_data.status">---</td>
						@verbatim
						<td>
							<a href="" class="btn btn-outline-primary rounded-0 btn-block" style="text-decoration: none !important; text-transform: none !important;" data-toggle="collapse" data-target="#collapseExample{{all_data.sp[0].sp_id}}" aria-expanded="true" aria-controls="collapseExample{{all_data.sp[0].sp_id}}" ng-click="view_specific_sp_data(all_data)">
								More.....
							</a>
						</td>

						<td class="collapsed_td collapse" aria-labelledby="collapseExample{{all_data.sp[0].sp_id}}" id="collapseExample{{all_data.sp[0].sp_id}}" data-parent="#accordion3">

							<div class="row mt-2">
								<div class="col">
									<b>Last updated on: <span>
										<span ng-repeat="logs_planned in specific_sp_data.sp[0].sp_logs track by $index">
											<span ng-show="$last" ng-bind="logs_planned.updated_at "></span>
											</span>
									</span>
									</b>
									<p>SP ID: <span ng-bind="specific_sp_data.sp[0].sp_id"></span></p>  
								</div>
							</div>

							<div class="row">
								<div class="col-lg-6">
									<div class="row">
										<div class="col-lg-3 hov">
											<small class="text-label-blue"> <b>Groupings</b></small>
											<p>
												<span ng-if="specific_sp_data.sp[0].sp_groupings.id == 1">KKB</span>
												<span ng-if="specific_sp_data.sp[0].sp_groupings.id == 2">MAKILAHOK</span>
												<span ng-if="specific_sp_data.sp[0].sp_groupings.id == 3">NCDDP</span>
												<span ng-if="specific_sp_data.sp[0].sp_groupings.id == 4">IP CDD</span>
												<span ng-if="specific_sp_data.sp[0].sp_groupings.id == 5">CCL</span>
												<span ng-if="specific_sp_data.sp[0].sp_groupings.id == 6">L&E</span>
											</p>
										</div>

										<div class="col-lg-3 hov">
											<small class="text-label-blue"> <b>Province</b> </small>
											<p ng-bind="specific_sp_data.sp[0].sp_province">SURIGAO DEL SUR</p>
										</div>
										<div class="col-lg-3 hov">
											<small class="text-label-blue"> <b>Municipality</b> </small>
											<p ng-bind="specific_sp_data.sp[0].sp_municipality">Marihatag</p>
										</div>
										<div class="col-lg-3 hov">
											<small class="text-label-blue"> <b>Barangay</b> </small>
											<p ng-bind="specific_sp_data.sp[0].sp_brgy">AMONTAY</p> 
										</div>

										<div class="col-lg-3 hov">
											<small class="text-label-blue"> <b>Sp Category</b> </small>
											<p ng-bind="specific_sp_data.sp[0].sp_category.category">Enterprise</p>
										</div>
										<div class="col-lg-3 hov">
											<small class="text-label-blue"> <b>Sp Type</b> </small>
											<p ng-bind="specific_sp_data.sp[0].sp_type.type">Others</p>
										</div>
										<div class="col-lg-3 hov">
											<small class="text-label-blue"> <b>Physical target</b> </small>
											<p ng-if="specific_sp_data.sp[0].sp_physical_target != null || specific_sp_data.sp[0].sp_physical_target == ''" ng-bind="specific_sp_data.sp[0].sp_physical_target"></p>

											<p class="mb-0" ng-if="specific_sp_data.sp[0].sp_physical_target == null">
												<a href="" style="text-transform: none !important; font-size:1.1em; font-weight:bold;" class="text-warning" ng-click="updating_sp_data('sp_physical_target',specific_sp_data.sp[0].sp_id)"> <i class="fa fa-pencil-square-o"></i> Update </a>
											</p>
										</div>
										<div class="col-lg-3 hov">
											<small class="text-label-blue"> <b>Total Project Cost</b> </small>
											<span ng-bind="specific_sp_data.sp[0].sp_project_cost | currency:'₱'"></span>
												<!--<p ng-if="specific_sp_data.sp[0].c_m_f_s_kalahi_2015__b_u_b__s_p != null">
														<span ng-bind="total_project_cost | currency:'₱'"></span>
													</p>
													<p ng-if="specific_sp_data.sp[0].c_m_f_s_kalahi_2016__b_u_b__s_p != null">
														<span ng-bind="total_project_cost | currency:'₱'"></span>
													</p>
													<p ng-if="specific_sp_data.sp[0].c_m_f_s_kalahi_2017__b_u_b__s_p != null">
														<span ng-bind="total_project_cost | currency:'₱'"></span>
													</p>
													<p ng-if="specific_sp_data.sp[0].c_m_f_s_kalahi_2018__b_u_b__s_p != null">
														<span ng-bind="total_project_cost | currency:'₱'"></span>
													</p>
													<p ng-if="specific_sp_data.sp[0].c_m_f_s_kalahi_2020__b_u_b__s_p != null">
														<span ng-bind="total_project_cost | currency:'₱'"></span>
													</p> -->

													<!-- NCDDP -->
												<!--<p ng-if="specific_sp_data.sp[0].c_m_f_s_kalahi_2015__n_c_d_d_p__s_p != null">
														<span ng-bind="total_project_cost | currency:'₱'"></span>
													</p>
													<p ng-if="specific_sp_data.sp[0].c_m_f_s_kalahi_2016__n_c_d_d_p__s_p != null">
														<span ng-bind="total_project_cost | currency:'₱'"></span>
													</p>
													<p ng-if="specific_sp_data.sp[0].c_m_f_s_kalahi_2017__n_c_d_d_p__s_p != null">
														<span ng-bind="total_project_cost | currency:'₱'"></span>
													</p>
													<p ng-if="specific_sp_data.sp[0].c_m_f_s_kalahi_2018__n_c_d_d_p__s_p != null">
														<span ng-bind="total_project_cost | currency:'₱'"></span>
													</p>
													<p ng-if="specific_sp_data.sp[0].c_m_f_s_kalahi_2019__n_c_d_d_p__s_p != null">
														<span ng-bind="total_project_cost | currency:'₱'"></span>
													</p>
													<p ng-if="specific_sp_data.sp[0].c_m_f_s_kalahi_2020__n_c_d_d_p__s_p != null">
														<span ng-bind="total_project_cost | currency:'₱'"></span>
													</p> -->
										</div>
									</div>
								</div>

								<div class="col-lg-6">
									<div class="row">
										<div class="col-lg-4 hov">
											<small class="text-label-blue"> <b>Date started</b> </small>
											<p ng-bind="specific_sp_data.sp[0].sp_date_started | date:'fullDate'">0000-00-00</p>
										</div>
										<div class="col-lg-4 hov">
											<small class="text-label-blue"> <b>Estimated duration</b> </small>
											<p ng-if="specific_sp_data.sp[0].sp_estimated_duration != null" ng-bind="specific_sp_data.sp[0].sp_estimated_duration + ' days'"></p>
											<p class="mb-0" ng-if="specific_sp_data.sp[0].sp_estimated_duration == null">
												<a href="" style="text-transform: none !important; font-size:1.1em; font-weight:bold;" class="text-warning" ng-click="updating_sp_data('sp_estimated_duration',specific_sp_data.sp[0].sp_id)"> <i class="fa fa-pencil-square-o"></i> Update </a>
											</p>
										</div>
										<div class="col-lg-4 hov">
											<small class="text-label-blue"> <b>Target date of completion</b> </small><br>
											<span ng-attr-id="{{'date_'+specific_sp_data.sp[0].sp_id}}" ng-bind-html='maoni' ng-if="specific_sp_data.sp[0].sp_target_date_of_completion != null" ng-bind="specific_sp_data.sp[0].sp_target_date_of_completion | date:'fullDate' "></span><br>
												<a href="" style="text-transform: none !important; font-size:1.1em; font-weight:bold;" class="text-warning" ng-click="updating_sp_data('sp_target_date_of_completion',specific_sp_data.sp[0].sp_id)"><i class="fa fa-pencil-square-o"></i> Update </a>
											<br>
										</div>
										<div class="col-lg-4 hov">
											<small class="text-label-blue"> <b>Days suspended</b> </small>
											<p class="mb-0" ng-bind="(specific_sp_data.sp[0].sp_days_suspended) + ' Days'"></p>
											<p class="mb-0">
												<a href="" style="text-transform: none !important; font-size:1.1em; font-weight:bold;" class="text-warning" ng-click="updating_sp_data('sp_days_suspended',specific_sp_data.sp[0].sp_id)"> <i class="fa fa-pencil-square-o"></i> Update </a>
											</p>
										</div>

										<div class="col-lg-4 hov">
											<small class="text-label-blue"> <b>Actual date completed</b> </small>
											<p ng-if="specific_sp_data.sp[0].sp_actual_date_completed != null && specific_sp_data.sp[0].sp_actual_date_completed != '0000-00-00 00:00:00'" ng-bind="specific_sp_data.sp[0].sp_actual_date_completed | date:'fullDate'"></p>

											<p class="mb-0">
												<a href="" style="text-transform: none !important; font-size:1.1em; font-weight:bold;" class="text-warning" ng-click="updating_sp_data('sp_actual_date_completed',specific_sp_data.sp[0].sp_id)"> <i class="fa fa-pencil-square-o"></i> Update </a>
											</p>
										</div>

										<div class="col-lg-4 hov">
											<small class="text-label-blue"> <b>Date of turn over</b> </small>
											<p ng-if="specific_sp_data.sp[0].sp_date_of_turnover != null" ng-bind="specific_sp_data.sp[0].sp_date_of_turnover | date:'fullDate'"></p>

											<p class="mb-0" ng-if="specific_sp_data.sp[0].sp_date_of_turnover == null">
												<a href="" style="text-transform: none !important; font-size:1.1em; font-weight:bold;" class="text-warning" ng-click="updating_sp_data('sp_date_of_turnover',specific_sp_data.sp[0].sp_id)"> <i class="fa fa-pencil-square-o"></i> Update </a>
											</p>
										</div>
									</div>
								</div>

								<div class="col-lg-12">
									<hr>
									<div class="row">
										<div class="col hov">
											<small class="text-label-blue"> <b>RFR 1st Tranch Date Downloaded & Amount  </b> </small>
											<p ng-if="specific_sp_data.sp[0].c_m_f_s_kalahi_2015__b_u_b__r_f_r != null">
														<span ng-bind="specific_sp_data.sp[0].c_m_f_s_kalahi_2015__b_u_b__r_f_r.cash_date"></span>
														<br>
														<span ng-bind="specific_sp_data.sp[0].c_m_f_s_kalahi_2015__b_u_b__r_f_r.amount | currency:'₱ '"></span>
													</p>
													<p ng-if="specific_sp_data.sp[0].c_m_f_s_kalahi_2016__b_u_b__r_f_r != null">
														<span ng-bind="specific_sp_data.sp[0].c_m_f_s_kalahi_2016__b_u_b__r_f_r.cash_date"></span>
														<br>
														<span ng-bind="specific_sp_data.sp[0].c_m_f_s_kalahi_2016__b_u_b__r_f_r.amount | currency:'₱ '"></span>
													</p>
													<p ng-if="specific_sp_data.sp[0].c_m_f_s_kalahi_2017__b_u_b__r_f_r != null">
														<span ng-bind="specific_sp_data.sp[0].c_m_f_s_kalahi_2017__b_u_b__r_f_r.cash_date"></span>
														<br>
														<span ng-bind="specific_sp_data.sp[0].c_m_f_s_kalahi_2017__b_u_b__r_f_r.amount | currency:'₱ '"></span>
													</p>
													<p ng-if="specific_sp_data.sp[0].c_m_f_s_kalahi_2018__b_u_b__r_f_r != null">
														<span ng-bind="specific_sp_data.sp[0].c_m_f_s_kalahi_2018__b_u_b__r_f_r.cash_date"></span>
														<br>
														<span ng-bind="specific_sp_data.sp[0].c_m_f_s_kalahi_2018__b_u_b__r_f_r.amount | currency:'₱ '"></span>
													</p>
													<p ng-if="specific_sp_data.sp[0].c_m_f_s_kalahi_2020__b_u_b__r_f_r != null">
														<span ng-bind="specific_sp_data.sp[0].c_m_f_s_kalahi_2020__b_u_b__r_f_r.cash_date"></span>
														<br>
														<span ng-bind="specific_sp_data.sp[0].c_m_f_s_kalahi_2020__b_u_b__r_f_r.amount | currency:'₱ '"></span>
													</p>

													<!-- NCDDP -->
													<p ng-if="specific_sp_data.sp[0].c_m_f_s_kalahi_2015__n_c_d_d_p__r_f_r != null">
														<span ng-bind="specific_sp_data.sp[0].c_m_f_s_kalahi_2015__n_c_d_d_p__r_f_r.cash_date"></span>
														<br>
														<span ng-bind="specific_sp_data.sp[0].c_m_f_s_kalahi_2015__n_c_d_d_p__r_f_r.amount | currency: '₱ '"></span>
													</p>
													<p ng-if="specific_sp_data.sp[0].c_m_f_s_kalahi_2016__n_c_d_d_p__r_f_r != null">
														<span ng-bind="specific_sp_data.sp[0].c_m_f_s_kalahi_2016__n_c_d_d_p__r_f_r.cash_date"></span>
														<br>
														<span ng-bind="specific_sp_data.sp[0].c_m_f_s_kalahi_2016__n_c_d_d_p__r_f_r.amount | currency: '₱ '"></span>
													</p>
													<p ng-if="specific_sp_data.sp[0].c_m_f_s_kalahi_2017__n_c_d_d_p__r_f_r != null">
														<span ng-bind="specific_sp_data.sp[0].c_m_f_s_kalahi_2017__n_c_d_d_p__r_f_r.cash_date"></span>
														<br>
														<span ng-bind="specific_sp_data.sp[0].c_m_f_s_kalahi_2017__n_c_d_d_p__r_f_r.amount | currency: '₱ '"></span>
													</p>
													<p ng-if="specific_sp_data.sp[0].c_m_f_s_kalahi_2018__n_c_d_d_p__r_f_r != null">
														<span ng-bind="specific_sp_data.sp[0].c_m_f_s_kalahi_2018__n_c_d_d_p__r_f_r.cash_date"></span>
														<br>
														<span ng-bind="specific_sp_data.sp[0].c_m_f_s_kalahi_2018__n_c_d_d_p__r_f_r.amount | currency: '₱ '"></span>
													</p>
													<p ng-if="specific_sp_data.sp[0].c_m_f_s_kalahi_2019__n_c_d_d_p__r_f_r != null">
														<span ng-bind="specific_sp_data.sp[0].c_m_f_s_kalahi_2019__n_c_d_d_p__r_f_r.cash_date"></span>
														<br>
														<span ng-bind="specific_sp_data.sp[0].c_m_f_s_kalahi_2019__n_c_d_d_p__r_f_r.amount | currency: '₱ '"></span>
													</p>
													<p ng-if="specific_sp_data.sp[0].c_m_f_s_kalahi_2020__n_c_d_d_p__r_f_r != null">
														<span ng-bind="specific_sp_data.sp[0].c_m_f_s_kalahi_2020__n_c_d_d_p__r_f_r.cash_date"></span>
														<br>
														<span ng-bind="specific_sp_data.sp[0].c_m_f_s_kalahi_2020__n_c_d_d_p__r_f_r.amount | currency: '₱ '"></span>
													</p>
										</div>

										<!-- Planned -->
										<div class="col hov" ng-if="update_sp_data == false" ng-cloak>
											<small style="color: #fd7e14 !important;"> <b>Planned</b> </small>
											<div  ng-if="specific_sp_data.sp[0].sp_logs.length > 0 || specific_sp_logs_length.length > 0">
												<div ng-show="$first" ng-repeat="logs_planned in specific_sp_logs_length track by $index">
													<span ng-bind="(logs_planned.sp_logs_planned) +'%'" ></span> <br>
													<small ng-show="$first" class="text-label-blue">Deadline: </small><small ng-show="$first" ng-bind="logs_planned.sp_logs_planned_target_date | date:'fullDate'"></small> <br>
												</div>
												<a href="" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#plan_history" ng-click="view_planned_sched(specific_sp_data.sp_id)">View Track history</a>
											</div>

											<p ng-if="specific_sp_data.status == 'On-going' || specific_sp_data.status == 'On-Going'"> NOT APPLICABLE <br>
												<a href="" data-toggle="modal" data-target="#planned_modal" ng-click="planned(assigned_sp.sp[0].sp_id)" >Create SP plan <i class="fa fa-pencil-square-o"></i></a>
											</p>

											<p ng-if="specific_sp_data.sp[0].sp_logs.length == 0 && specific_sp_data.status != 'On-going'">
												NOT APPLICABLE 
											</p>
										</div>
										
<!--                     <div class="col hov" ng-show="update_sp_data == true" ng-cloak>
											<div class="form-group">
												<label><small style="color: #fd7e14 !important;"> <b>Planned</b> </small></label>
												<div ng-show="$first" ng-repeat="logs_planned in specific_sp_logs_length track by $index">
													<span ng-bind="logs_planned.sp_logs_planned +'%' "></span> <br>
													<small class="text-label-blue">Deadline: </small><small ng-bind="logs_planned.sp_logs_planned_target_date | date:'fullDate'"></small> <br>
												</div>
												<a href="" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#plan_history" ng-click="view_planned_sched(specific_sp_data.sp_id)">View Track history</a>
											</div>
										</div> -->
										<!-- Planned -->
										
										<!-- Actual -->
										<div class="col hov" ng-if="update_sp_data == false" ng-cloak>
											<small style="color: #2196f3 !important;"> <b>Actual</b> </small>
												<div ng-if="specific_sp_data.sp[0].sp_logs.length > 0" ng-show="$last" ng-repeat="logs_planned in specific_sp_data.sp[0].sp_logs track by $index">
													<span ng-bind="logs_planned.sp_logs_actual"></span>
												</div>

												<p ng-if="specific_sp_data.sp[0].sp_logs.length == 0"> NOT APPLICABLE </p>

												<a ng-if="specific_sp_data.status == 'On-going' || specific_sp_data.status == 'On-Going' && specific_sp_logs_length.length > 0" class="text-warning" style="text-transform: none; font-size:1.1em; font-weight:bold;" href="" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#update_Sp" > <i class="fa fa-pencil-square-o"></i> Update</a>
										</div>

<!--                     <div class="col hov" ng-show="update_sp_data == true" ng-cloak>
											<div class="form-group">
												<label><small style="color: #2196f3 !important;"> <b>Actual</b> </small></label>
												<input type="text" class="form-control" ng-model="actual_shit" ng-change="calc_slippage(actual_shit,specific_sp_logs_length[0].sp_logs_planned)"  onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57" price>
											</div>
										</div> -->
										<!-- Actual -->

										<!-- Slippage -->
										<div class="col hov" ng-if="update_sp_data == false" ng-cloak>
											<small style="color: #dc3545 !important;"> <b>Slippage</b> </small>
												<div ng-if="specific_sp_data.sp[0].sp_logs.length > 0" ng-show="$last" ng-repeat="logs_planned in specific_sp_data.sp[0].sp_logs track by $index">
													<span ng-bind="logs_planned.sp_logs_slippage"></span>
												</div>
													<p ng-if="specific_sp_data.sp[0].sp_logs.length == 0"> NOT APPLICABLE </p>
										</div>

<!--                     <div class="col hov" ng-show="update_sp_data == true" ng-cloak>
											<div class="form-group">
												<label><small style="color: #dc3545 !important;"> <b>Slippage</b> </small></label>
												<input type="text" class="form-control" ng-model="Slippage_data" disabled>
											</div>
										</div> -->
										<!-- Slippage -->
										<div class="col hov" ng-bind="" ng-bind="specific_sp_data" ng-cloak>
										</div>
									</div>
								</div>

								<!-- FILES -->
								<div class="col-lg-12">
									<hr>
									<div class="row">
										<div class="col-lg-3 hov">
											<small> <b>Building Permit</b> </small> <br>
														<div>
												<p class="pulsate" ng-if="specific_sp_data.sp[0].sp_building_permit == 0">
															<span>NOT APPLICABLE</span>
														</p>

													<button ng-if="specific_sp_data.sp[0].sp_building_permit != 0" class="btn btn-light" style="border-radius: 26px;"> <i class="fa fa-download"></i> <a class="text-secondary" href="/download/{{specific_sp_data.sp[0].sp_building_permit}}" target="_blank"> Download </a> </button>
														</div>
										</div>

										<div class="col-lg-3 hov">
											<small> <b>Variation order</b> </small>
														<div>
												<p class="pulsate" ng-if="specific_sp_data.sp[0].sp_variation_order == 0">
															<span>NOT APPLICABLE</span>
														</p>

													<button ng-if="specific_sp_data.sp[0].sp_variation_order != 0" class="btn btn-light" style="border-radius: 26px;"> <i class="fa fa-download"></i> <a class="text-secondary" href="/download/{{specific_sp_data.sp[0].sp_variation_order}}" target="_blank"> Download </a> </button>
														</div>
										</div>

										<div class="col-lg-3 hov">
											<small> <b>Fullblown Proposal</b> </small><br>
														<div>
												<p class="pulsate" ng-if="specific_sp_data.sp[0].sp_fullblown_proposal == 0">
															<span>NOT APPLICABLE</span>
														</p>

													<button ng-if="specific_sp_data.sp[0].sp_fullblown_proposal != 0" class="btn btn-light" style="border-radius: 26px;"> <i class="fa fa-download"></i> <a class="text-secondary" href="/download/{{specific_sp_data.sp[0].sp_fullblown_proposal}}" target="_blank"> Download </a> </button>
														</div>
										</div>

										<div class="col-lg-3 hov">
											<small> <b>Materials Testing</b> </small> <br>
														<div>
												<p class="pulsate" ng-if="specific_sp_data.sp[0].sp_mt == 0">
															<span>NOT APPLICABLE</span>
														</p>

													<button ng-if="specific_sp_data.sp[0].sp_mt != 0" class="btn btn-light" style="border-radius: 26px;"> <i class="fa fa-download"></i> <a class="text-secondary" href="/download/{{specific_sp_data.sp[0].sp_mt}}" target="_blank"> Download </a> </button>
														</div>
										</div>

										<div class="col-lg-3 hov">
											<small> <b>ESMR</b> </small> <br>
														<div>
												<p class="pulsate" ng-if="specific_sp_data.sp[0].sp_esmr == 0">
															<span>NOT APPLICABLE</span>
														</p>

													<button ng-if="specific_sp_data.sp[0].sp_esmr != 0" class="btn btn-light" style="border-radius: 26px;"> <i class="fa fa-download"></i> <a class="text-secondary" href="/download/{{specific_sp_data.sp[0].sp_esmr}}" target="_blank"> Download </a> </button>
														</div>
												</div>

										<div class="col-lg-3 hov">
											<small> <b>SPCR Submission (30 Days)</b> </small> <br>
														<div>
												<p class="pulsate" ng-if="specific_sp_data.sp[0].sp_spcr == 0">
															<span>NOT APPLICABLE</span>
														</p>

													<button ng-if="specific_sp_data.sp[0].sp_spcr != 0" class="btn btn-light" style="border-radius: 26px;"> <i class="fa fa-download"></i> <a class="text-secondary" href="/download/{{specific_sp_data.sp[0].sp_spcr}}" target="_blank"> Download </a> </button>
														</div>
												</div>



										<div class="col-lg-3 hov">
											<small> <b>CSR</b> </small> <br>
														<div>
												<p class="pulsate" ng-if="specific_sp_data.sp[0].sp_csr == 0">
															<span>NOT APPLICABLE</span>
														</p>

													<button ng-if="specific_sp_data.sp[0].sp_csr != 0" class="btn btn-light" style="border-radius: 26px;"> <i class="fa fa-download"></i> <a class="text-secondary" href="/download/{{specific_sp_data.sp[0].sp_csr}}" target="_blank"> Download </a> </button>
														</div>
										</div>
									</div>
								</div>
								<!-- FILES -->
								
								<div class="col-lg-12">
									<hr>
								</div>

<!--                 <div class="col-lg-4 hov" ng-show="update_sp_data == true">
									<small class="text-label-blue"> <b> Issues/Problem Encountered </b> </small>
									<textarea class="form-control text_area" id="msg" rows="8" maxlength="255" style="resize: none;overflow-x: auto;" ng-model="$parent.iss_prob" ng-if="update_sp_data == true"></textarea>
									<br>
								</div>

								<div class="col-lg-4 hov" ng-show="update_sp_data == true">
									<small class="text-label-blue"> <b> Analysis </b> </small>
									<textarea class="form-control text_area" id="msg" rows="8" maxlength="255" style="resize: none;overflow-x: auto;" ng-model="$parent.analyis" ng-if="update_sp_data == true"></textarea>
									<br>
								</div>

								<div class="col-lg-4 hov" ng-show="update_sp_data == true">
									<small class="text-label-blue"> <b> Remarks </b> </small>
									<textarea class="form-control text_area" id="msg" rows="8" maxlength="255" style="resize: none;overflow-x: auto;" ng-model="$parent.remarks" ng-if="update_sp_data == true"></textarea>
									<br>
								</div> -->

								<div class="col-lg-12" ng-show="update_sp_data == false">
									<h4 class="font-weight-bold">PMR History</h4>
									<p class="text-danger" ng-if="specific_sp_data.sp[0].sp_pmr.length == 0"> No PMR data </p>
									<table class="table" ng-if="specific_sp_data.sp[0].sp_pmr.length > 0">
										<thead class="thead-light">
											<tr style="border: none !important;">
											<th scope="col">Date</th>
											<th scope="col">Code</th>
											<th scope="col">Mode of Procurement</th>
											<th scope="col">Source of Fund</th>
											<th scope="col">Status</th>
											</tr>
										</thead>
										<tbody>
											<tr ng-class="{'text-green' : data.status == 'Reviewed'}" ng-repeat="data in specific_sp_data.sp[0].sp_pmr track by $index" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#pmr_history_modal" ng-click="fetch_specific_pmr_data(data)">
												<th scope="row" ng-bind="data.created_at | date:'medium'"></th>
												<th scope="row" ng-bind="data.code"></th>
												<td ng-bind="data.mode_of_procurement"></td>
												<td ng-bind="data.fund_source"></td>
												<td ng-bind="data.status"></td>
											</tr>
										</tbody>
									</table>
								</div>

								<div class="col-lg-12">
									<button ng-if="specific_sp_data.status == 'Completed' || specific_sp_data.status == 'On-going' || specific_sp_data.status == 'On-Going'" type="button" style="border-radius: 100px;" class="btn btn-outline-primary mb-2" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#plan_history" ng-click="view_planned_sched(specific_sp_data.sp_id)"> <i class="fa fa-pencil"></i> View Track history </button>

									<button type="button" class="btn btn-outline-info mb-2" style="border-radius: 100px;" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#add_files"> <i class="fa fa-paperclip"></i> Attach a file </button>

									<button type="button" class="btn btn-outline-warning mb-2" style="border-radius: 100px;" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#pmr_modal"> <i class="fa fa-file-excel-o"></i> Create PMR </button>

									<!-- <button type="button" class="btn btn-outline-primary mb-2" style="border-radius: 100px;" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#rfr_tracking" ng-click="view_specific_sp_rfr_data(all_data.sp[0].sp_id,all_data.sp[0].sp_groupings.id)"> <i class="fa fa-money"></i> RFR Tracking </button> -->

									<!-- UPDATE -->
									<!-- <button ng-if="specific_sp_data.status == 'On-going' && update_sp_data == false" type="button" class="btn btn-outline-success mb-2" style="border-radius: 100px;" ng-if="updateBtn == true && planned_sched.length > 0" ng-click="update_sp_Btns()"> <i class="fa fa-pencil"></i> Update </button>

									<button ng-if="specific_sp_data.status == 'On-going' && update_sp_data == true" type="button" class="btn btn-outline-danger mb-2" style="border-radius: 100px;" ng-if="saveBtn == true" ng-click="cancel_update_sp()"> <i class="fa fa-times"></i> Cancel changes</button> -->

									<button ng-if="specific_sp_data.status == 'On-going' && update_sp_data == true" type="button" class="btn btn-outline-success mb-2" style="border-radius: 100px;" ng-if="saveBtn == true" ng-click="update_sp(specific_sp_logs_length[0].id,actual_shit,Slippage_data,iss_prob,analyis,remarks,specific_sp_data.sp_id)"> <i class="fa fa-clipboard"></i> Save changes</button>
									<!-- UPDATE -->

									<button ng-if="update_sp_data == false" type="button" class="btn btn-outline-secondary mb-2" style="border-radius: 100px;" data-toggle="collapse" data-target="#collapseExample{{all_data.sp[0].sp_id}}" aria-expanded="true" aria-controls="collapseExample{{all_data.sp[0].sp_id}}" > <i class="fa fa-times"></i> Close </button>
								</div>
							</div>

						</td>
						@endverbatim
					</tr>
				</tbody>
			</table>
	</div>
</div>