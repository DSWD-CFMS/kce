<!-- COMPLETED -->
<div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
	<div class="row">
		<div class="col-lg-8 my-2">
			<label class="text-muted"><small size="1"><span ng-if="sp_per_modality_data_completed.from!=null" ng-bind="'Showing records '+sp_per_modality_data_completed.from+'-'+sp_per_modality_data_completed.to+' out of '+sp_per_modality_data_completed.total"></span></small></label>
			<!-- <label class="text-muted"><small> Displaying 10 out of 1080 items </small></label> -->
			  <ul class="pagination">

			  	  <!-- Pag previous sa page  -->
				<li class="page-item disabled" ng-if="sp_per_modality_data_completed.current_page == 1">
					<a style="text-transform: none;" class="page-link text-secondary" href="">Previous</a>
				</li>
				<li class="page-item" ng-if="sp_per_modality_data_completed.current_page!=1" ng-click="Previous_Pagination(sp_per_modality_data_completed.prev_page_url)"><a style="text-transform: none;" class="page-link text-secondary" href="">Previous</a></li>

				<!-- Pag adto sa first page -->
				<li class="page-item" ng-class="{'invisible' : sp_per_modality_data_completed.current_page == 1 || sp_per_modality_data_completed.current_page == 2 || sp_per_modality_data_completed.current_page == 3 || sp_per_modality_data_completed.last_page> 3 && sp_per_modality_data_completed.last_page < 6}" ng-click="Skip_To_Page(sp_per_modality_data_completed.path,1)">
				<a style="text-transform: none;" class="page-link text-secondary" href="">1</a>
				</li>

				<!-- Mag add ug (...) if ang current page is 4 pataas -->
				<li class="page-item disabled" ng-class="{'invisible' : sp_per_modality_data_completed.current_page == 1 || sp_per_modality_data_completed.current_page == 2 || sp_per_modality_data_completed.current_page == 3 ||sp_per_modality_data_completed.last_page>3&&sp_per_modality_data_completed.last_page<6}">
					<a style="text-transform: none;" class="page-link text-secondary" href="">...</a>
				</li>   

				<!-- Number of Pages -->
				<li ng-repeat="x in [].constructor(sp_per_modality_data_completed.last_page) track by $index" ng-click="Skip_To_Page(sp_per_modality_data_completed.path,$index+1)">
					<a style="text-transform: none;" ng-class="{'bg-success active text-light': $index+1 == sp_per_modality_data_completed.current_page, 'invisible' : sp_per_modality_data_completed.current_page+1 < $index && $index > 5 || sp_per_modality_data_completed.current_page - 5 >$index && $index <sp_per_modality_data_completed.last_page-5}"  class="page-link text-secondary" href="" ng-bind="$index+1"></a>
				</li>

				<!-- Pag add ug (...) -->
				<li class="page-item disabled" ng-class="{'invisible' : sp_per_modality_data_completed.current_page == sp_per_modality_data_completed.last_page || sp_per_modality_data_completed.current_page == sp_per_modality_data_completed.last_page-1 || sp_per_modality_data_completed.current_page == sp_per_modality_data_completed.last_page-2||sp_per_modality_data_completed.last_page>3&&sp_per_modality_data_completed.last_page<6}">
				<a style="text-transform: none;" class="page-link text-secondary" href="">...</a>
				</li>

				<!-- Pag adto sa last page last page -->
				<li class="page-item" ng-class="{'invisible' : sp_per_modality_data_completed.current_page == sp_per_modality_data_completed.last_page || sp_per_modality_data_completed.current_page == sp_per_modality_data_completed.last_page-1 || sp_per_modality_data_completed.current_page == sp_per_modality_data_completed.last_page-2 || sp_per_modality_data_completed.last_page>3&&sp_per_modality_data_completed.last_page<6}" ng-click="Skip_To_Page(sp_per_modality_data_completed.last_page)">
				<a style="text-transform: none;" class="page-link text-secondary" href="" ng-bind="sp_per_modality_data_completed.last_page"></a>
				</li>

				<!-- Pag Next sa Pages -->
				<li class="page-item disabled">
					<a style="text-transform: none;" class="page-link text-secondary" href="" ng-if="sp_per_modality_data_completed.current_page == sp_per_modality_data_completed.last_page">Next</a>
				</li>
				<li class="page-item">
					<a style="text-transform: none;" class="page-link text-secondary" href="" ng-if="sp_per_modality_data_completed.current_page != sp_per_modality_data_completed.last_page" ng-click="Next_Pagination(sp_per_modality_data_completed.next_page_url)">Next</a></li>
			  </ul>
		</div>
		<div class="col-lg-4 my-2">
			<label><small> Search Subproject <i class="fa fa-search"></i> </small></label>
			<input class="form-control nav-item nav-link" type="text" name="" placeholder="Search..." ng-model="search_data_modality_completed.$">			    
		</div>
	</div>
	<div class="row mt-2">
	<!-- <div class="col-lg-1"> <b style="font-size: .7em;">SP ID</b> <hr> </div> -->
	<div ng-class="{'col-lg-5' : sp_per_modality_data_completed.data[0].assigned_grouping == 4, 'col-lg-6' : sp_per_modality_data_completed.data[0].assigned_grouping != 4}"> <b style="font-size: .7em;">TITLE</b> <hr> </div>
	<!-- if naay cadt -->
	<div class="col-lg-1" ng-if="sp_per_modality_data_completed.data[0].assigned_grouping == 4"> <b style="font-size: .7em;">CADT</b> <hr> </div>
	<div class="col-lg-1"> <b style="font-size: .7em;">BARANGAY</b> <hr> </div>
	<div class="col-lg-1"> <b style="font-size: .7em;">PLANNED</b> <hr> </div>
	<div class="col-lg-1"> <b style="font-size: .7em;">ACTUAL</b> <hr> </div>
	<div class="col-lg-1"> <b style="font-size: .7em;">SLIPPAGE</b> <hr> </div>
	<div class="col-lg-1"> <b style="font-size: .7em;">DAC</b> <hr> </div>
	<div class="col-lg-1"> <b style="font-size: .7em;">ACTION</b> <hr> </div>
	</div>
	@verbatim
<div id="accordion2">
  	<div class="row accordion_row remove_high_light" style="cursor: pointer; padding-top: 10px;padding-bottom:10px;" ng-repeat="all_data in bars = (sp_per_modality_data_completed.data | filter: search_data_modality_completed.$) track by $index">
  		<div ng-class="{'col-lg-5' : sp_per_modality_data_all_sp_logs.data[0].assigned_grouping == 4, 'col-lg-6' : sp_per_modality_data_all_sp_logs.data[0].assigned_grouping != 4}" ng-bind="all_data.sp[0].sp_title | uppercase"></div>
		<!-- if naay cadt -->
		<div class="col-lg-1" ng-if="sp_per_modality_data_all_sp_logs.data[0].assigned_grouping == 4">
			<span ng-bind="all_data.sp[0].cadt.cadt_no"></span>
		</div>
  		<div class="col-lg-1" style="font-size: .7em;" ng-bind="all_data.sp[0].sp_brgy | uppercase"></div>
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
		<div class="col-lg-1" style="font-size: .8em;">
				<span ng-bind="(all_data.users[0].Fname +' '+ all_data.users[0].Lname) | uppercase"></span>
			</div>
  		<div class="col-lg-1">
  			<a href="" class="btn btn-outline-primary rounded-0" style="text-decoration: none !important; text-transform: none !important;" data-toggle="collapse" data-target="#completed{{all_data.sp[0].sp_id}}" aria-expanded="true" aria-controls="completed{{all_data.sp[0].sp_id}}" ng-click="view_specific_sp_data(all_data)">
  				More...
  			</a>
  		</div>
  		<div class="col-lg-12">
			<div class="container-fluid collapse" aria-labelledby="completed{{all_data.sp[0].sp_id}}" id="completed{{all_data.sp[0].sp_id}}" data-parent="#accordion2" style="border-top: solid 3px #ff9c07; border-bottom: solid 3px #ff9c07; margin-bottom: 50px; padding: 0px !important;">
			<div class="row">
				<div class="col-lg-6">
					<div class="row">
						<div class="col-lg-3 my-1">
							<small> <b>Last updated on</b> </small> <br>
							<span ng-repeat="logs_planned in specific_sp_data.sp[0].sp_logs track by $index">
								<span ng-show="$last" ng-bind="logs_planned.updated_at "></span>
		  					</span>
						</div>

						<div class="col-lg-3 my-1">
							<small> <b>SP ID</b> </small> <br>
							<span ng-bind="specific_sp_data.sp[0].sp_id"></span>
						</div>

						<div class="col-lg-5 my-1">
							<small> <b>RFR 1st Tranch Date Downloaded & Amount	</b> </small> <br>
			        		<span class="pb-0 mb-0" ng-if="specific_sp_data.sp[0].c_m_f_s_kalahi_2015__b_u_b__r_f_r != null">
			        			<span ng-bind="specific_sp_data.sp[0].c_m_f_s_kalahi_2015__b_u_b__r_f_r.cash_date"></span>
			        			| 
			        			<span ng-bind="specific_sp_data.sp[0].c_m_f_s_kalahi_2015__b_u_b__r_f_r.amount | currency:'₱ '"></span>
			        		</span>
			        		<span class="pb-0 mb-0" ng-if="specific_sp_data.sp[0].c_m_f_s_kalahi_2016__b_u_b__r_f_r != null">
			        			<span ng-bind="specific_sp_data.sp[0].c_m_f_s_kalahi_2016__b_u_b__r_f_r.cash_date"></span>
			        			| 
			        			<span ng-bind="specific_sp_data.sp[0].c_m_f_s_kalahi_2016__b_u_b__r_f_r.amount | currency:'₱ '"></span>
			        		</span>
			        		<span class="pb-0 mb-0" ng-if="specific_sp_data.sp[0].c_m_f_s_kalahi_2017__b_u_b__r_f_r != null">
			        			<span ng-bind="specific_sp_data.sp[0].c_m_f_s_kalahi_2017__b_u_b__r_f_r.cash_date"></span>
			        			| 
			        			<span ng-bind="specific_sp_data.sp[0].c_m_f_s_kalahi_2017__b_u_b__r_f_r.amount | currency:'₱ '"></span>
			        		</span>
			        		<span class="pb-0 mb-0" ng-if="specific_sp_data.sp[0].c_m_f_s_kalahi_2018__b_u_b__r_f_r != null">
			        			<span ng-bind="specific_sp_data.sp[0].c_m_f_s_kalahi_2018__b_u_b__r_f_r.cash_date"></span>
			        			| 
			        			<span ng-bind="specific_sp_data.sp[0].c_m_f_s_kalahi_2018__b_u_b__r_f_r.amount | currency:'₱ '"></span>
			        		</span>
			        		<span class="pb-0 mb-0" ng-if="specific_sp_data.sp[0].c_m_f_s_kalahi_2020__b_u_b__r_f_r != null">
			        			<span ng-bind="specific_sp_data.sp[0].c_m_f_s_kalahi_2020__b_u_b__r_f_r.cash_date"></span>
			        			| 
			        			<span ng-bind="specific_sp_data.sp[0].c_m_f_s_kalahi_2020__b_u_b__r_f_r.amount | currency:'₱ '"></span>
			        		</span>

			        		<!-- NCDDP -->
			        		<span class="pb-0 mb-0" ng-if="specific_sp_data.sp[0].c_m_f_s_kalahi_2015__n_c_d_d_p__r_f_r != null">
			        			<span ng-bind="specific_sp_data.sp[0].c_m_f_s_kalahi_2015__n_c_d_d_p__r_f_r.cash_date"></span>
			        			| 
			        			<span ng-bind="specific_sp_data.sp[0].c_m_f_s_kalahi_2015__n_c_d_d_p__r_f_r.amount | currency: '₱ '"></span>
			        		</span>
			        		<span class="pb-0 mb-0" ng-if="specific_sp_data.sp[0].c_m_f_s_kalahi_2016__n_c_d_d_p__r_f_r != null">
			        			<span ng-bind="specific_sp_data.sp[0].c_m_f_s_kalahi_2016__n_c_d_d_p__r_f_r.cash_date"></span>
			        			| 
			        			<span ng-bind="specific_sp_data.sp[0].c_m_f_s_kalahi_2016__n_c_d_d_p__r_f_r.amount | currency: '₱ '"></span>
			        		</span>
			        		<span class="pb-0 mb-0" ng-if="specific_sp_data.sp[0].c_m_f_s_kalahi_2017__n_c_d_d_p__r_f_r != null">
			        			<span ng-bind="specific_sp_data.sp[0].c_m_f_s_kalahi_2017__n_c_d_d_p__r_f_r.cash_date"></span>
			        			| 
			        			<span ng-bind="specific_sp_data.sp[0].c_m_f_s_kalahi_2017__n_c_d_d_p__r_f_r.amount | currency: '₱ '"></span>
			        		</span>
			        		<span class="pb-0 mb-0" ng-if="specific_sp_data.sp[0].c_m_f_s_kalahi_2018__n_c_d_d_p__r_f_r != null">
			        			<span ng-bind="specific_sp_data.sp[0].c_m_f_s_kalahi_2018__n_c_d_d_p__r_f_r.cash_date"></span>
			        			| 
			        			<span ng-bind="specific_sp_data.sp[0].c_m_f_s_kalahi_2018__n_c_d_d_p__r_f_r.amount | currency: '₱ '"></span>
			        		</span>
			        		<span class="pb-0 mb-0" ng-if="specific_sp_data.sp[0].c_m_f_s_kalahi_2019__n_c_d_d_p__r_f_r != null">
			        			<span ng-bind="specific_sp_data.sp[0].c_m_f_s_kalahi_2019__n_c_d_d_p__r_f_r.cash_date"></span>
			        			| 
			        			<span ng-bind="specific_sp_data.sp[0].c_m_f_s_kalahi_2019__n_c_d_d_p__r_f_r.amount | currency: '₱ '"></span>
			        		</span>
			        		<span class="pb-0 mb-0" ng-if="specific_sp_data.sp[0].c_m_f_s_kalahi_2020__n_c_d_d_p__r_f_r != null">
			        			<span ng-bind="specific_sp_data.sp[0].c_m_f_s_kalahi_2020__n_c_d_d_p__r_f_r.cash_date"></span>
			        			| 
			        			<span ng-bind="specific_sp_data.sp[0].c_m_f_s_kalahi_2020__n_c_d_d_p__r_f_r.amount | currency: '₱ '"></span>
			        		</span>
						</div>
					</div>
				</div>
				<div class="col-lg-6"></div>

				<div class="col-lg-6">
					<div class="row">
						<div class="col-lg-3 hov">
							<small> <b>Groupings</b> </small>
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
							<small> <b>Province</b> </small>
			        		<p ng-bind="specific_sp_data.sp[0].sp_province">SURIGAO DEL SUR</p>
						</div>
						<div class="col-lg-3 hov">
							<small> <b>Municipality</b> </small>
			        		<p ng-bind="specific_sp_data.sp[0].sp_municipality">Marihatag</p>
						</div>
						<div class="col-lg-3 hov">
							<small> <b>Barangay</b> </small>
			        		<p ng-bind="specific_sp_data.sp[0].sp_brgy">AMONTAY</p> 
						</div>

						<div class="col-lg-3 hov">
							<small> <b>Sp Category</b> </small>
			        		<p ng-bind="specific_sp_data.sp[0].sp_category.category">Enterprise</p>
						</div>
						<div class="col-lg-3 hov">
							<small> <b>Sp Type</b> </small>
			        		<p ng-bind="specific_sp_data.sp[0].sp_type.type">Others</p>
						</div>
						<div class="col-lg-3 hov">
							<small> <b>Physical target</b> </small>
			        		<p ng-bind="specific_sp_data.sp[0].sp_physical_target">Others</p>
						</div>
						<div class="col-lg-3 hov">
							<small> <b>Total Project Cost</b> </small>
			        		<!-- <p ng-bind="specific_sp_data.sp[0].sp_project_cost | currency:'₱'">Others</p> -->
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
							<small> <b>Date started</b> </small>
	        				<p ng-bind="specific_sp_data.sp[0].sp_date_started | date:'fullDate'">0000-00-00</p>
	      				</div>
	      				<div class="col-lg-4 hov">
							<small> <b>Estimated duration</b> </small>
	        				<p ng-bind="specific_sp_data.sp[0].sp_estimated_duration + ' days'"></p>
	      				</div>
	      				<div class="col-lg-4 hov">
							<small> <b>Target date of completion</b> </small>
	        				<p ng-bind="specific_sp_data.sp[0].sp_target_date_of_completion | date:'fullDate'">0000-00-00</p>
	      				</div>
	      				<div class="col-lg-4 hov">
							<small> <b>Days suspended</b> </small>
							<p ng-bind="(specific_sp_data.sp[0].sp_days_suspended) + ' Days'"></p>
	      				</div>
	      				<div class="col-lg-4 hov">
							<small> <b>Actual date completed</b> </small>
	        				<p ng-bind="specific_sp_data.sp[0].sp_actual_date_completed | date:'fullDate'">0000-00-00</p>
	      				</div>
	      				<div class="col-lg-4 hov">
							<small> <b>Date of turn over</b> </small>
	        				<p ng-bind="specific_sp_data.sp[0].sp_date_of_turnover | date:'fullDate'">0000-00-00</p>
	      				</div>
					</div>
				</div>

	      		<div class="col-lg-12">
	      			<button type="button" style="border-radius: 100px;" class="btn btn-outline-primary mb-2" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#plan_history" ng-click="view_planned_sched(specific_sp_data.sp_id)"> <i class="fa fa-history"></i> View Track history </button>

					<button type="button" class="btn btn-outline-primary mb-2" style="border-radius: 100px;" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#rfr_tracking" ng-click="view_specific_sp_rfr_data(all_data.sp[0].sp_id,all_data.sp[0].sp_groupings.id)"> <i class="fa fa-money"></i> RFR Tracking </button>

	      			<button type="button" style="border-radius: 100px;" class="btn btn-outline-primary mb-2" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#spcr_tracking" ng-click="view_specific_sp_spcr_data(all_data.sp[0].sp_id,all_data.sp[0].sp_groupings.id)"> <i class="fa fa-paperclip"></i> SPCR Tracking </button>

					<button type="button" class="btn btn-secondary mb-2" style="border-radius: 100px;" data-toggle="collapse" data-target="#completed{{all_data.sp[0].sp_id}}" aria-expanded="true" aria-controls="completed{{all_data.sp[0].sp_id}}" > <i class="fa fa-times"></i> Close </button>
	      		</div>
			</div>
			</div>
  		</div>
  	</div>
</div>
@endverbatim
</div>