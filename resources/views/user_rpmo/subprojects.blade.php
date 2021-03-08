<style type="text/css">
	.accordion .forcollapseeee:after {
	    /*font-family: 'FontAwesome';  */
	    /*content: "\f068";*/
	    content: "ddsds";
	}
	.accordion .forcollapseeee. collapsed:after {
	    /* symbol for "collapsed" panels */
	    content: "Close"; 
	}
</style>

<div class="row" ng-init="fetch_rpmo_sps()">
	<div class="col-lg-8 my-2">
		<label class="text-muted"><span size="1"><span ng-if="sp_per_modality_data_all_sp_logs.from!=null" ng-bind="'Showing records '+sp_per_modality_data_all_sp_logs.from+'-'+sp_per_modality_data_all_sp_logs.to+' out of '+sp_per_modality_data_all_sp_logs.total"></span></span></label>
		<!-- <label class="text-muted"><span> Displaying 10 out of 1080 items </span></label> -->
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
</div>

<div class="wrapper wrapperr-content animated fadeInRight ecommerce px-0 pb-0" id="accordion3">
	<div class="table-responsive" style="height: 35px;">
		<table class="table table-bordered1" style="margin-bottom: 0px !important;overflow: none !important;">
		    <thead class="thead-dark">
		      <tr style="font-size: 10px;">
		        <th scope="col">TITLE</th>
		        <th scope="col">BARANGAY</th>
		        <th scope="col">PLANNED</th>
		        <th scope="col">ACTUAL</th>
		        <th scope="col">SLIPPAGE</th>
		        <th scope="col">DAC</th>
		        <th scope="col">STATUS</th>
		        <th scope="col">ACTION</th>
		      </tr>
		    </thead>
		    <tbody style="overflow: none !important; display: none !important;">
		    </tbody>
		</table>
	</div>
	<div class="table-responsive" style="height: 400px;">
		<table class="table table-bordered1" style="margin-bottom: 0px !important;overflow: none !important;">
		    <tbody style="overflow-y: auto !important; overflow-x: none !important;">
                <tr ng-repeat="all_data in bars = (sp_per_modality_data_all_sp_logs.data | filter:search_data_modality)" style="font-size: 10px;">
                    <td ng-bind="all_data.sp_title | uppercase"></td>
                    <td ng-bind="all_data.sp_brgy | uppercase"></td>

		            <td>
						<span ng-bind="all_data.planned"></span>
						<span ng-if="all_data.planned == NULL" >NONE</span>
		            </td>

		            <td ng-class="{'text-green' : all_data.status == 'Completed'}">
						<span ng-bind="all_data.actual"></span>
						<span ng-if="all_data.actual == NULL" >NONE</span>
		            </td>

		            <td>
		            	<span ng-if="all_data.slippage != NULL" ng-class="{'text-green' : all_data.status == 'Completed', 'text-green' : all_data.slippage >= 0, 'text-danger' : all_data.slippage < 0}" ng-bind="(all_data.slippage) + '%'"></span>
						<span ng-if="all_data.slippage == NULL" >NONE</span>
		            </td>

                    <td>
  						<span ng-bind="(all_data.assigned_sp[0].users[0].Fname +' '+ all_data.assigned_sp[0].users[0].Lname) | uppercase"></span>
                    </td>
                    
                    <td ng-class="{'text-danger': all_data.sp_status == 'NYS', 'text-green': all_data.sp_status == 'Completed', 'text-warning' : all_data.sp_status == 'On-going'}">
                    	<span ng-bind="all_data.sp_status | uppercase"></span>
                    </td>
                    <td>
                    	@verbatim
						<a href="" class="btn btn-outline-primary rounded-0 btn-block forcollapse{{all_data.sp_id}}" style="text-decoration: none !important; text-transform: none !important;" data-toggle="collapse" data-target="#collapseExample{{all_data.sp_id}}" aria-expanded="true" aria-controls="collapseExample{{all_data.sp_id}}" ng-click="view_specific_sp_data(all_data)">
							<span>More</span> <i class="fa fa-folder"></i> 
						</a>
                    </td>

					<td class="collapsed_td collapse" aria-labelledby="collapseExample{{all_data.sp_id}}" id="collapseExample{{all_data.sp_id}}" data-parent="#accordion3">
						<div class="row">
							<div class="col-lg-6">
								<div class="row">
									<div class="col-lg-3 my-1">
										<span class="text-success"> <b>Last updated on</b> </span> <br>
										<span ng-if="specific_sp_data.sp_logs.length == 0">Not yet updated</span>
										<span ng-repeat="logs_planned in specific_sp_data.sp_logs track by $index">
											<span ng-show="$last" ng-bind="logs_planned.updated_at "></span>
					  					</span>
									</div>

									<div class="col-lg-3 my-1">
										<span class="text-success"> <b>SP ID</b> </span> <br>
										<span ng-bind="specific_sp_data.sp_id"></span>
									</div>

									<div class="col-lg-5 my-1">
										<span class="text-success"> <b>RFR 1st Tranch Date Downloaded & Amount	</b> </span> <br>
						        		<span class="pb-0 mb-0" ng-if="specific_sp_data.c_m_f_s_kalahi_2015__b_u_b__r_f_r != null">
						        			<span ng-bind="specific_sp_data.c_m_f_s_kalahi_2015__b_u_b__r_f_r.cash_date"></span>
						        			| 
						        			<span ng-bind="specific_sp_data.c_m_f_s_kalahi_2015__b_u_b__r_f_r.amount | currency:'₱ '"></span>
						        		</span>
						        		<span class="pb-0 mb-0" ng-if="specific_sp_data.c_m_f_s_kalahi_2016__b_u_b__r_f_r != null">
						        			<span ng-bind="specific_sp_data.c_m_f_s_kalahi_2016__b_u_b__r_f_r.cash_date"></span>
						        			| 
						        			<span ng-bind="specific_sp_data.c_m_f_s_kalahi_2016__b_u_b__r_f_r.amount | currency:'₱ '"></span>
						        		</span>
						        		<span class="pb-0 mb-0" ng-if="specific_sp_data.c_m_f_s_kalahi_2017__b_u_b__r_f_r != null">
						        			<span ng-bind="specific_sp_data.c_m_f_s_kalahi_2017__b_u_b__r_f_r.cash_date"></span>
						        			| 
						        			<span ng-bind="specific_sp_data.c_m_f_s_kalahi_2017__b_u_b__r_f_r.amount | currency:'₱ '"></span>
						        		</span>
						        		<span class="pb-0 mb-0" ng-if="specific_sp_data.c_m_f_s_kalahi_2018__b_u_b__r_f_r != null">
						        			<span ng-bind="specific_sp_data.c_m_f_s_kalahi_2018__b_u_b__r_f_r.cash_date"></span>
						        			| 
						        			<span ng-bind="specific_sp_data.c_m_f_s_kalahi_2018__b_u_b__r_f_r.amount | currency:'₱ '"></span>
						        		</span>
						        		<span class="pb-0 mb-0" ng-if="specific_sp_data.c_m_f_s_kalahi_2020__b_u_b__r_f_r != null">
						        			<span ng-bind="specific_sp_data.c_m_f_s_kalahi_2020__b_u_b__r_f_r.cash_date"></span>
						        			| 
						        			<span ng-bind="specific_sp_data.c_m_f_s_kalahi_2020__b_u_b__r_f_r.amount | currency:'₱ '"></span>
						        		</span>

						        		<!-- NCDDP -->
						        		<span class="pb-0 mb-0" ng-if="specific_sp_data.c_m_f_s_kalahi_2015__n_c_d_d_p__r_f_r != null">
						        			<span ng-bind="specific_sp_data.c_m_f_s_kalahi_2015__n_c_d_d_p__r_f_r.cash_date"></span>
						        			| 
						        			<span ng-bind="specific_sp_data.c_m_f_s_kalahi_2015__n_c_d_d_p__r_f_r.amount | currency: '₱ '"></span>
						        		</span>
						        		<span class="pb-0 mb-0" ng-if="specific_sp_data.c_m_f_s_kalahi_2016__n_c_d_d_p__r_f_r != null">
						        			<span ng-bind="specific_sp_data.c_m_f_s_kalahi_2016__n_c_d_d_p__r_f_r.cash_date"></span>
						        			| 
						        			<span ng-bind="specific_sp_data.c_m_f_s_kalahi_2016__n_c_d_d_p__r_f_r.amount | currency: '₱ '"></span>
						        		</span>
						        		<span class="pb-0 mb-0" ng-if="specific_sp_data.c_m_f_s_kalahi_2017__n_c_d_d_p__r_f_r != null">
						        			<span ng-bind="specific_sp_data.c_m_f_s_kalahi_2017__n_c_d_d_p__r_f_r.cash_date"></span>
						        			| 
						        			<span ng-bind="specific_sp_data.c_m_f_s_kalahi_2017__n_c_d_d_p__r_f_r.amount | currency: '₱ '"></span>
						        		</span>
						        		<span class="pb-0 mb-0" ng-if="specific_sp_data.c_m_f_s_kalahi_2018__n_c_d_d_p__r_f_r != null">
						        			<span ng-bind="specific_sp_data.c_m_f_s_kalahi_2018__n_c_d_d_p__r_f_r.cash_date"></span>
						        			| 
						        			<span ng-bind="specific_sp_data.c_m_f_s_kalahi_2018__n_c_d_d_p__r_f_r.amount | currency: '₱ '"></span>
						        		</span>
						        		<span class="pb-0 mb-0" ng-if="specific_sp_data.c_m_f_s_kalahi_2019__n_c_d_d_p__r_f_r != null">
						        			<span ng-bind="specific_sp_data.c_m_f_s_kalahi_2019__n_c_d_d_p__r_f_r.cash_date"></span>
						        			| 
						        			<span ng-bind="specific_sp_data.c_m_f_s_kalahi_2019__n_c_d_d_p__r_f_r.amount | currency: '₱ '"></span>
						        		</span>
						        		<span class="pb-0 mb-0" ng-if="specific_sp_data.c_m_f_s_kalahi_2020__n_c_d_d_p__r_f_r != null">
						        			<span ng-bind="specific_sp_data.c_m_f_s_kalahi_2020__n_c_d_d_p__r_f_r.cash_date"></span>
						        			| 
						        			<span ng-bind="specific_sp_data.c_m_f_s_kalahi_2020__n_c_d_d_p__r_f_r.amount | currency: '₱ '"></span>
						        		</span>
									</div>
								</div>
							</div>
							<div class="col-lg-6"></div>

							<div class="col-lg-6">
								<div class="row">
									<div class="col-lg-3 hov">
										<span class="text-success"> <b>Groupings</b> </span>
						        		<p>
						        			<span ng-if="specific_sp_data.sp_groupings.id == 1">
						        				KKB
						        			</span>

						        			<span ng-if="specific_sp_data.sp_groupings.id == 2">
						        				MAKILAHOK
						        			</span>

						        			<span ng-if="specific_sp_data.sp_groupings.id == 3">
						        				NCDDP
						        			</span>

						        			<span ng-if="specific_sp_data.sp_groupings.id == 4">
						        				IP CDD
						        			</span>

						        			<span ng-if="specific_sp_data.sp_groupings.id == 5">
						        				CCL
						        			</span>

						        			<span ng-if="specific_sp_data.sp_groupings.id == 6">
						        				L&E
						        			</span>
						        		</p>
									</div>

									<div class="col-lg-3 hov">
										<span class="text-success"> <b>Province</b> </span>
						        		<p ng-bind="specific_sp_data.sp_province">SURIGAO DEL SUR</p>
									</div>
									<div class="col-lg-3 hov">
										<span class="text-success"> <b>Municipality</b> </span>
						        		<p ng-bind="specific_sp_data.sp_municipality">Marihatag</p>
									</div>
									<div class="col-lg-3 hov">
										<span class="text-success"> <b>Barangay</b> </span>
						        		<p ng-bind="specific_sp_data.sp_brgy">AMONTAY</p> 
									</div>

									<div class="col-lg-3 hov">
										<span class="text-success"> <b>Sp Category</b> </span>
						        		<p ng-bind="specific_sp_data.sp_category.category">Enterprise</p>
									</div>
									<div class="col-lg-3 hov">
										<span class="text-success"> <b>Sp Type</b> </span>
						        		<p ng-bind="specific_sp_data.sp_type.type">Others</p>
									</div>
									<div class="col-lg-3 hov">
										<span class="text-success"> <b>Physical target</b> </span>
						        		<p ng-bind="specific_sp_data.sp_physical_target">Others</p>
									</div>
									<div class="col-lg-3 hov">
										<span class="text-success"> <b>Total Project Cost</b> </span>
						        		<p ng-bind="specific_sp_data.sp_project_cost | currency:'₱'">Others</p>
									</div>
								</div>
							</div>

							<div class="col-lg-6">
								<div class="row">
				      				<div class="col-lg-4 hov">
										<span class="text-success"> <b>Date started</b> </span>
				        				<p ng-if="specific_sp_data.sp_date_started != null" ng-bind="specific_sp_data.sp_date_started | date:'fullDate'">0000-00-00</p>
				        				<p ng-if="specific_sp_data.sp_date_started == null">NOT APPLICABLE</p>
				      				</div>
				      				<div class="col-lg-4 hov">
										<span class="text-success"> <b>Estimated duration</b> </span>
				        				<p ng-if="specific_sp_data.sp_estimated_duration != null" ng-bind="specific_sp_data.sp_estimated_duration + ' days'"></p>
				        				<p ng-if="specific_sp_data.sp_estimated_duration == null">NOT APPLICABLE</p>
				      				</div>
				      				<div class="col-lg-4 hov">
										<span class="text-success"> <b>Target date of completion</b> </span>
				        				<p ng-if="specific_sp_data.sp_target_date_of_completion != null" ng-bind="specific_sp_data.sp_target_date_of_completion | date:'fullDate'">0000-00-00</p>
				        				<p ng-if="specific_sp_data.sp_estimated_duration == null">NOT APPLICABLE</p>
				      				</div>
				      				<div class="col-lg-4 hov">
										<span class="text-success"> <b>Days suspended</b> </span>
										<p ng-bind="(specific_sp_data.sp_days_suspended) + ' Days'"></p>
				      				</div>
				      				<div class="col-lg-4 hov">
										<span class="text-success"> <b>Actual date completed</b> </span>
				        				<p ng-if="specific_sp_data.sp_actual_date_completed != null" ng-bind="specific_sp_data.sp_actual_date_completed | date:'fullDate'">0000-00-00</p>
				        				<p ng-if="specific_sp_data.sp_actual_date_completed == null">NOT APPLICABLE</p>
				      				</div>
				      				<div class="col-lg-4 hov">
										<span class="text-success"> <b>Date of turn over</b> </span>
				        				<p ng-if="specific_sp_data.sp_date_of_turnover != null" ng-bind="specific_sp_data.sp_date_of_turnover | date:'fullDate'">0000-00-00</p>
				        				<p ng-if="specific_sp_data.sp_date_of_turnover == null">NOT APPLICABLE</p>
				      				</div>
								</div>
							</div>

				      		<div class="col-lg-12">
								<button ng-if="all_data.sp_status == 'NYS'" type="button" class="btn btn-outline-success mb-2" style="border-radius: 100px;" ng-click="Update_Sp_Status('On-going',all_data.sp_id)"> <i class="fa fa-calendar"></i> Set to "On-going" </button>

								<button type="button" class="btn btn-outline-warning mb-2" style="border-radius: 100px;" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#rfr_tracking" ng-click="view_specific_sp_rfr_data(all_data.sp_id,all_data.sp_groupings.id)"> <i class="fa fa-money"></i> RFR Tracking </button>

				      			<button ng-if="all_data.actual != NULL" type="button" style="border-radius: 100px;" class="btn btn-outline-primary mb-2" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#plan_history" ng-click="view_planned_sched(specific_sp_data.sp_id)"> <i class="fa fa-history"></i> View Track history </button>

	      						<button ng-if="all_data.sp_status == 'Completed'" type="button" style="border-radius: 100px;" class="btn btn-outline-danger mb-2" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#spcr_tracking" ng-click="view_specific_sp_spcr_data(all_data.sp_id,all_data.sp_groupings.id)"> <i class="fa fa-paperclip"></i> SPCR Tracking </button>

								<button type="button" class="btn btn-secondary mb-2" style="border-radius: 100px;" data-toggle="collapse" data-target="#collapseExample{{all_data.sp_id}}" aria-expanded="true" aria-controls="collapseExample{{all_data.sp_id}}" > <i class="fa fa-times"></i> Close </button>
				      		</div>
						</div>
					</td>
					@endverbatim
                </tr>
		    </tbody>
		</table>
	</div>	
</div>
@include('user_rpmo.modality_modal')