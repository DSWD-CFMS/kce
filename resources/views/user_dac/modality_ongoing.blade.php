<!-- ON GOING -->
<div class="tab-pane fade" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
	<div class="row">
		<div class="col-lg-8 my-2">
			<label class="text-muted"><small size="1"><span ng-if="sp_per_modality_data_all_sp_logs.from!=null" ng-bind="'Showing records '+sp_per_modality_data_all_sp_logs.from+'-'+sp_per_modality_data_all_sp_logs.to+' out of '+sp_per_modality_data_all_sp_logs.total"></span></small></label>
			<!-- <label class="text-muted"><small> Displaying 10 out of 1080 items </small></label> -->
			  <ul class="pagination">

			  	  <!-- Pag previous sa page  -->
				<li class="page-item disabled" ng-if="sp_per_modality_data_all_sp_logs.current_page == 1">
					<a style="text-transform: none;" class="page-link text-secondary" href="">Previous</a>
				</li>
				<li class="page-item" ng-if="sp_per_modality_data_all_sp_logs.current_page!=1" ng-click="Previous_Pagination(sp_per_modality_data_all_sp_logs.prev_page_url)"><a style="text-transform: none;" class="page-link text-secondary" href="">Previous</a></li>

				<!-- Pag adto sa first page -->
				<li class="page-item" ng-class="{'invisible' : sp_per_modality_data_all_sp_logs.current_page == 1 || sp_per_modality_data_all_sp_logs.current_page == 2 || sp_per_modality_data_all_sp_logs.current_page == 3 || sp_per_modality_data_all_sp_logs.last_page> 3 && sp_per_modality_data_all_sp_logs.last_page < 6}" ng-click="Skip_To_Page(sp_per_modality_data_all_sp_logs.path,1)">
				<a style="text-transform: none;" class="page-link text-secondary" href="">1</a>
				</li>

				<!-- Mag add ug (...) if ang current page is 4 pataas -->
				<li class="page-item disabled" ng-class="{'invisible' : sp_per_modality_data_all_sp_logs.current_page == 1 || sp_per_modality_data_all_sp_logs.current_page == 2 || sp_per_modality_data_all_sp_logs.current_page == 3 ||sp_per_modality_data_all_sp_logs.last_page>3&&sp_per_modality_data_all_sp_logs.last_page<6}">
					<a style="text-transform: none;" class="page-link text-secondary" href="">...</a>
				</li>   

				<!-- Number of Pages -->
				<li ng-repeat="x in [].constructor(sp_per_modality_data_all_sp_logs.last_page) track by $index" ng-click="Skip_To_Page(sp_per_modality_data_all_sp_logs.path,$index+1)">
					<a style="text-transform: none;" ng-class="{'bg-success active text-light': $index+1 == sp_per_modality_data_all_sp_logs.current_page, 'invisible' : sp_per_modality_data_all_sp_logs.current_page+1 < $index && $index > 5 || sp_per_modality_data_all_sp_logs.current_page - 5 >$index && $index <sp_per_modality_data_all_sp_logs.last_page-5}"  class="page-link text-secondary" href="" ng-bind="$index+1"></a>
				</li>

				<!-- Pag add ug (...) -->
				<li class="page-item disabled" ng-class="{'invisible' : sp_per_modality_data_all_sp_logs.current_page == sp_per_modality_data_all_sp_logs.last_page || sp_per_modality_data_all_sp_logs.current_page == sp_per_modality_data_all_sp_logs.last_page-1 || sp_per_modality_data_all_sp_logs.current_page == sp_per_modality_data_all_sp_logs.last_page-2||sp_per_modality_data_all_sp_logs.last_page>3&&sp_per_modality_data_all_sp_logs.last_page<6}">
				<a style="text-transform: none;" class="page-link text-secondary" href="">...</a>
				</li>

				<!-- Pag adto sa last page last page -->
				<li class="page-item" ng-class="{'invisible' : sp_per_modality_data_all_sp_logs.current_page == sp_per_modality_data_all_sp_logs.last_page || sp_per_modality_data_all_sp_logs.current_page == sp_per_modality_data_all_sp_logs.last_page-1 || sp_per_modality_data_all_sp_logs.current_page == sp_per_modality_data_all_sp_logs.last_page-2 || sp_per_modality_data_all_sp_logs.last_page>3&&sp_per_modality_data_all_sp_logs.last_page<6}" ng-click="Skip_To_Page(sp_per_modality_data_all_sp_logs.last_page)">
				<a style="text-transform: none;" class="page-link text-secondary" href="" ng-bind="sp_per_modality_data_all_sp_logs.last_page"></a>
				</li>

				<!-- Pag Next sa Pages -->
				<li class="page-item disabled">
					<a style="text-transform: none;" class="page-link text-secondary" href="" ng-if="sp_per_modality_data_all_sp_logs.current_page == sp_per_modality_data_all_sp_logs.last_page">Next</a>
				</li>
				<li class="page-item">
					<a style="text-transform: none;" class="page-link text-secondary" href="" ng-if="sp_per_modality_data_all_sp_logs.current_page != sp_per_modality_data_all_sp_logs.last_page" ng-click="Next_Pagination(sp_per_modality_data_all_sp_logs.next_page_url)">Next</a></li>
			  </ul>
		</div>
		<div class="col-lg-4 my-2">
			<label><small> Search Subproject <i class="fa fa-search"></i> </small></label>
			<input class="form-control nav-item nav-link" type="text" name="" placeholder="Search..." ng-model="search_data_modality.$">			    
		</div>
	</div>

	<div class="row mt-2">
		<div class="col-lg-6"> <b style="font-size: .7em;">SP TITLE</b> <hr> </div>
		<div class="col-lg-2"> <b style="font-size: .7em;">BARANGAY</b> <hr> </div>
		<div class="col-lg-1"> <b style="font-size: .7em;">PLANNED</b> <hr> </div>
		<div class="col-lg-1"> <b style="font-size: .7em;">ACTUAL</b> <hr> </div>
		<div class="col-lg-1"> <b style="font-size: .7em;">SLIPPAGE</b> <hr> </div>
		<div class="col-lg-1"> <b style="font-size: .7em;">ACTION</b> <hr> </div>
	</div>
	@verbatim
<div id="accordion1">
  	<div class="row accordion_row remove_high_light" id="collapse{{all_data.sp_id}}" style="cursor: pointer; padding-top: 10px;padding-bottom:10px;" ng-repeat="all_data in bars = (sp_per_modality_data_all_sp_logs.data | filter: search_data_modality.$) track by $index">
  		<div class="col-lg-6">
  			<span ng-bind="all_data.sp[0].sp_title | uppercase"></span>
  		</div>
  		<div class="col-lg-2" ng-bind="all_data.sp[0].sp_brgy | uppercase"></div>
  		<div class="col-lg-1">
  			<div ng-repeat="logs_planned in all_data.sp[0].sp_logs track by $index">
				<span ng-show="$last" ng-bind="(logs_planned.sp_logs_planned) + '%'" ></span>
  			</div>
  		</div>
  		<div class="col-lg-1">
  			<div ng-repeat="logs_planned in all_data.sp[0].sp_logs track by $index">
				<span ng-show="$last" ng-bind="(logs_planned.sp_logs_actual) + '%'"></span>
  			</div>
  		</div>
  		<div class="col-lg-1">
  			<div ng-repeat="logs_planned in all_data.sp[0].sp_logs track by $index">
				<span ng-if="logs_planned.sp_logs_slippage >= 0" class="text-success" ng-show="$last" ng-bind="(logs_planned.sp_logs_slippage) + '%'"></span>
				<span ng-if="logs_planned.sp_logs_slippage < 0" class="text-danger" ng-show="$last" ng-bind="(logs_planned.sp_logs_slippage) + '%'"></span>
  			</div>
  		</div>

  		<div class="col-lg-1">
  			<a href="" class="btn btn-outline-primary rounded-0" style="text-decoration: none !important; text-transform: none !important;" data-toggle="collapse" data-target="#collapseExample{{all_data.sp[0].sp_id}}" aria-expanded="true" aria-controls="collapseExample{{all_data.sp[0].sp_id}}" ng-click="view_specific_sp_data(sp_per_modality_data_on_going.data[$index]);cancel_update_sp();view_planned_sched(all_data.sp[0].sp_id)">
  				More...
  			</a>

  		</div>
  		<div class="col-lg-12">
			<div class="container-fluid collapse" aria-labelledby="collapseExample{{all_data.sp[0].sp_id}}" id="collapseExample{{all_data.sp[0].sp_id}}" data-parent="#accordion1"  style="border-bottom: solid 3px #007bff; margin-bottom: 50px; padding: 0px !important;">
				<br>
				<small class="text-label-blue">Last updated on: <span>
					<span ng-repeat="logs_planned in specific_sp_data.sp[0].sp_logs track by $index">
						<span ng-show="$last" ng-bind="logs_planned.updated_at "></span>
  					</span>
				</span>
				</small>
				<p>SP ID: <span ng-bind="specific_sp_data.sp[0].sp_id"></span></p>						
				<div class="row">
					<div class="col-lg-6">
						<div class="row">
							<div class="col-lg-3 hov">
								<small class="text-label-blue"> <b>Groupings</b> </small>
				        		<p>
				        			<span ng-if="specific_sp_data.sp[0].sp_groupings.id == 1">
				        				KKB
				        			</span>

				        			<span ng-if="specific_sp_data.sp[0].sp_groupings.id == 2">
				        				MAKILAHOK
				        			</span>

				        			<span ng-if="specific_sp_data.sp[0].sp_groupings.id == 3">
				        				NCDDP
				        			</span>

				        			<span ng-if="specific_sp_data.sp[0].sp_groupings.id == 4">
				        				IP CDD
				        			</span>

				        			<span ng-if="specific_sp_data.sp[0].sp_groupings.id == 5">
				        				CCL
				        			</span>

				        			<span ng-if="specific_sp_data.sp[0].sp_groupings.id == 6">
				        				L&E
				        			</span>
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
				        		<p ng-bind="specific_sp_data.sp[0].sp_physical_target">Others</p>
							</div>
							<div class="col-lg-3 hov">
								<small class="text-label-blue"> <b>Total Project Cost</b> </small>
				        		<p ng-if="specific_sp_data.sp[0].c_m_f_s_kalahi_2015__b_u_b__s_p != null">
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
				        		</p>

				        		<!-- NCDDP -->
				        		<p ng-if="specific_sp_data.sp[0].c_m_f_s_kalahi_2015__n_c_d_d_p__s_p != null">
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
				        		</p>
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
		        				<p ng-bind="specific_sp_data.sp[0].sp_estimated_duration + ' days'"></p>
		      				</div>
		      				<div class="col-lg-4 hov">
								<small class="text-label-blue"> <b>Target date of completion</b> </small>
		        				<p ng-bind="specific_sp_data.sp[0].sp_target_date_of_completion | date:'fullDate'">0000-00-00</p>
		      				</div>
		      				<div class="col-lg-4 hov">
								<small class="text-label-blue"> <b>Days suspended</b> </small>
								<p ng-bind="(specific_sp_data.sp[0].sp_days_suspended) + ' Days'"></p>
		      				</div>
		      				<div class="col-lg-4 hov">
								<small class="text-label-blue"> <b>Actual date completed</b> </small>
		        				<p ng-bind="specific_sp_data.sp[0].sp_actual_date_completed | date:'fullDate'">0000-00-00</p>
		      				</div>
		      				<div class="col-lg-4 hov">
								<small class="text-label-blue"> <b>Date of turn over</b> </small>
		        				<p ng-bind="specific_sp_data.sp[0].sp_date_of_turnover | date:'fullDate'">0000-00-00</p>
		      				</div>
						</div>
					</div>

					<div class="col-lg-12">
						<hr>
						<div class="row">
							<div class="col hov">
								<small class="text-label-blue"> <b>RFR 1st Tranch Date Downloaded & Amount	</b> </small>
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
							<div class="col hov" ng-if="update_sp_data == false" ng-cloak>
								<small class="text-label-blue"> <b>Planned</b> </small>
		              			<div  ng-if="specific_sp_logs_length > 0">
		              				<div ng-show="$first" ng-repeat="logs_planned in specific_sp_data.sp[0].sp_logs track by $index">
										<span ng-show="$first" ng-bind="(logs_planned.sp_logs_planned) +'%'" ></span> <br>
										<small ng-show="$first" class="text-label-blue">Deadline: </small><small ng-show="$first" ng-bind="logs_planned.sp_logs_planned_target_date | date:'fullDate'"></small> <br>
		              				</div>
									<a href="" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#plan_history" ng-click="view_planned_sched(specific_sp_data.sp_id)">View Track history</a>
		              			</div>

								<p ng-if="specific_sp_logs_length == 0"> NOT APPLICABLE <br>
									<a href="" data-toggle="modal" data-target="#planned_modal" ng-click="planned(assigned_sp.sp[0].sp_id)" >Create SP plan <i class="fa fa-pencil-square-o"></i></a>
								</p>
				      		</div>
							
							<div class="col hov" ng-show="update_sp_data == true" ng-cloak>
								<div class="form-group">
									<label><small class="text-label-blue"> <b>Planned</b> </small></label>

		              			<div ng-if="specific_sp_data.sp[0].sp_logs.length > 0 "  ng-show="$first" ng-repeat="logs_planned in specific_sp_data.sp[0].sp_logs track by $index">
									<span ng-show="$first" ng-bind="logs_planned.sp_logs_planned +'%' "></span> <br>
									<small ng-show="$first" class="text-label-blue">Deadline: </small><small ng-show="$first" ng-bind="logs_planned.sp_logs_planned_target_date | date:'fullDate'"></small> <br>
		              			</div>
								<a href="" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#plan_history" ng-click="view_planned_sched(specific_sp_data.sp_id)">View Track history</a>
								</div>
							</div>
							
							<div class="col hov" ng-if="update_sp_data == false" ng-cloak>
								<small class="text-label-blue"> <b>Actual</b> </small>
		              			<div ng-if="specific_sp_data.sp[0].sp_logs.length > 0" ng-repeat="logs_planned in specific_sp_data.sp[0].sp_logs track by $index">
									<span ng-show="$last" ng-bind="logs_planned.sp_logs_actual"></span>
		              			</div>
								<p ng-if="specific_sp_data.sp[0].sp_logs.length == 0"> NOT APPLICABLE </p>
				      		</div>

							<div class="col hov" ng-show="update_sp_data == true" ng-cloak>
								<div class="form-group">
									<label><small class="text-label-blue"> <b>Actual</b> </small></label>
									<input type="text" class="form-control" ng-model="actual_shit" ng-change="calc_slippage(actual_shit,specific_sp_data.sp[0].sp_logs[0].sp_logs_planned)">
								</div>
							</div>

							<div class="col hov" ng-if="update_sp_data == false" ng-cloak>
								<small class="text-label-blue"> <b>Slippage</b> </small>
		              			<div ng-if="specific_sp_data.sp[0].sp_logs.length > 0" ng-repeat="logs_planned in specific_sp_data.sp[0].sp_logs track by $index">
									<span ng-show="$last" ng-bind="logs_planned.sp_logs_slippage"></span>
		              			</div>
								<p ng-if="specific_sp_data.sp[0].sp_logs.length == 0"> NOT APPLICABLE </p>
				      		</div>

							<div class="col hov" ng-show="update_sp_data == true" ng-cloak>
								<div class="form-group">
									<label><small class="text-label-blue"> <b>Slippage</b> </small></label>
									<input type="text" class="form-control" ng-model="Slippage_data" disabled>
								</div>
							</div>

						</div>
					</div>

					<div class="col-lg-12" ng-if="update_sp_data == false">
						<hr>
						<div class="row">
							<div class="col-lg-6 hov">
								<small class="text-label-blue"> <b>Building Permit</b> </small> <br>
									<p class="pulsate" ng-if="specific_sp_data.sp[0].sp_building_permit == 0">
					        			<span>NOT YET UPLOADED</span>
					        		</p>
  								
  									<button ng-if="specific_sp_data.sp[0].sp_building_permit != 0" class="btn btn-light" style="border-radius: 26px;"> <i class="fa fa-download"></i> <a class="text-secondary" href="/download/{{specific_sp_data.sp[0].sp_building_permit}}"> Click to download file </a> </button>
								<hr>
							</div>


							<div class="col-lg-6 hov">
								<small class="text-label-blue"> <b>Fullblown Proposal</b> </small> <br>
									<p class="pulsate" ng-if="specific_sp_data.sp[0].sp_fullblown_proposal == 0">
					        			<span>NOT YET UPLOADED</span>
					        		</p>

  									<button ng-if="specific_sp_data.sp[0].sp_fullblown_proposal != 0" class="btn btn-light" style="border-radius: 26px;"> <i class="fa fa-download"></i> <a class="text-secondary" href="/download/{{specific_sp_data.sp[0].sp_fullblown_proposal}}"> Click to download file </a> </button>
								<hr>
							</div>

							<div class="col-lg-6 hov">
								<small class="text-label-blue"> <b>SPCR Submission (30 Days)</b> </small> <br>
									<p class="pulsate" ng-if="specific_sp_data.sp[0].sp_spcr == 0">
					        			<span>NOT YET UPLOADED</span>
				        			</p>

  									<button ng-if="specific_sp_data.sp[0].sp_spcr != 0" class="btn btn-light" style="border-radius: 26px;"> <i class="fa fa-download"></i> <a class="text-secondary" href="/download/{{specific_sp_data.sp[0].sp_spcr}}"> Click to download file </a> </button>
								<hr>
				      		</div>

							<div class="col-lg-6 hov">
								<small class="text-label-blue"> <b>Variation order</b> </small> <br>
									<p class="pulsate" ng-if="specific_sp_data.sp[0].sp_variation_order == 0">
					        			<span>NOT YET UPLOADED</span>
				        			</p>
  									<button ng-if="specific_sp_data.sp[0].sp_variation_order != 0" class="btn btn-light" style="border-radius: 26px;"> <i class="fa fa-download"></i> <a class="text-secondary" href="/download/{{specific_sp_data.sp[0].sp_variation_order}}"> Click to download file </a> </button>
								<hr>
							</div>

							<div class="col-lg-4 hov">
								<small class="text-label-blue"> <b>ESMR</b> </small> <br>
									<p class="pulsate" ng-if="specific_sp_data.sp[0].sp_esmr == 0">
					        			<span>NOT YET UPLOADED</span>
				        			</p>

  									<button ng-if="specific_sp_data.sp[0].sp_esmr != 0" class="btn btn-light" style="border-radius: 26px;"> <i class="fa fa-download"></i> <a class="text-secondary" href="/download/{{specific_sp_data.sp[0].sp_esmr}}"> Click to download file </a> </button>
				      		</div>

							<div class="col-lg-4 hov">
								<small class="text-label-blue"> <b>CSR</b> </small> <br>
									<p class="pulsate" ng-if="specific_sp_data.sp[0].sp_csr == 0">
					        			<span>NOT YET UPLOADED</span>
					        		</p>

	  								<button ng-if="specific_sp_data.sp[0].sp_csr != 0" class="btn btn-light" style="border-radius: 26px;"> <i class="fa fa-download"></i> <a class="text-secondary" href="/download/{{specific_sp_data.sp[0].sp_csr}}"> Click to download file </a> </button>

				      		</div>

							<div class="col-lg-4 hov">
								<small class="text-label-blue"> <b>MATERIALS TESTING</b> </small> <br>
			          			<!-- <div ng-if="update_sp_data == false"> -->
									<p class="pulsate" ng-if="specific_sp_data.sp[0].sp_mt == 0">
					        			<span>NOT YET UPLOADED</span>
				        			</p>

  									<button ng-if="specific_sp_data.sp[0].sp_mt != 0" class="btn btn-light" style="border-radius: 26px;"> <i class="fa fa-download"></i> <a class="text-secondary" href="/download/{{specific_sp_data.sp[0].sp_mt}}"> Click to download file </a> </button>
				      		</div>

							<div class="col-lg-12" >
								<h4 class="font-weight-bold">PMR History</h4>
								<p class="text-danger" ng-if="specific_sp_data.sp[0].sp_pmr.length == 0"> No PMR data </p>
								<table class="table table-hover" ng-if="specific_sp_data.sp[0].sp_pmr.length > 0">
									<thead>
										<tr>
										<th scope="col">Date</th>
										<th scope="col">Code</th>
										<th scope="col">Mode of Procurement</th>
										<th scope="col">Source of Fund</th>
										<th scope="col">Status</th>
										</tr>
									</thead>
									<tbody>
										<tr ng-repeat="data in specific_sp_data.sp[0].sp_pmr track by $index" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#pmr_history_modal" ng-click="fetch_specific_pmr_data(data)">
											<th scope="row" ng-bind="data.created_at | date:'medium'"></th>
											<th scope="row" ng-bind="data.code"></th>
											<td ng-bind="data.mode_of_procurement"></td>
											<td ng-bind="data.fund_source"></td>
											<td ng-class="{'text-success' : data.status == 'Approved'}" ng-bind="data.status"></td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					
					<div class="col-lg-12">
						<hr>
					</div>

		      		<div class="col-lg-4 hov" ng-show="update_sp_data == true">
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
		      		</div>

		      		<div class="col-lg-12">
		      			<!-- <button type="button" class="btn btn-warning mb-2" style="border-radius: 100px;" ng-if="updateBtn == true && specific_sp_data.sp[0].sp_logs.length > 0	" ng-click="update_sp_Btns()"> <i class="fa fa-pencil"></i> Update </button> -->
		      			<button type="button" class="btn btn-warning mb-2" style="border-radius: 100px;" ng-if="updateBtn == true && planned_sched.length > 0" ng-click="update_sp_Btns()"> <i class="fa fa-pencil"></i> Update </button>

						<button type="button" class="btn btn-outline-secondary mb-2" style="border-radius: 100px;" ng-if="saveBtn == true" ng-click="cancel_update_sp()"> <i class="fa fa-times"></i> Cancel changes</button>
				        <button type="button" class="btn btn-primary mb-2" style="border-radius: 100px;" ng-if="saveBtn == true" ng-click="update_sp(specific_sp_data.sp[0].sp_logs[0].id,actual_shit,Slippage_data,iss_prob,analyis,remarks,specific_sp_data.sp_id)"> <i class="fa fa-clipboard"></i> Save changes</button>

						<button type="button" class="btn btn-outline-info mb-2" style="border-radius: 100px;" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#add_files"> <i class="fa fa-paperclip"></i> Attach a file </button>

						<button type="button" class="btn btn-outline-success mb-2" style="border-radius: 100px;" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#pmr_modal"> <i class="fa fa-file-excel-o"></i> Create PMR </button>

		      			<button type="button" class="btn btn-outline-secondary mb-2" style="border-radius: 100px;" data-toggle="collapse" data-target="#collapseExample{{all_data.sp[0].sp_id}}" aria-expanded="true" aria-controls="collapseExample{{all_data.sp[0].sp_id}}" ng-click="cancel_update_sp()" ng-if="updateBtn == true"> <i class="fa fa-times"></i> Close </button>
		      		</div>
				</div>
			</div>
  		</div>
  	</div>
</div>
	@endverbatim
</div>
<!-- ON GOING -->