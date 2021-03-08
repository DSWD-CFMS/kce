<style type="text/css">
  body.modal-open {
    padding-right: 0 !important;
  }

  .modal{
    padding-right: 0px !important;
  }
  
  .modal-full {
      min-width: 100%;
      margin: 0 !important;
  }

  .modal-full .modal-content {
      min-height: 100vh !important;
  }
</style>


<div class="modal fade" id="summary_sp_modal" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-full" role="document">
		<div class="modal-content">
			<div class="modal-body">

            <div class="row">
                <div class="col-lg-10">
                    <h2 ng-bind="header"></h2>
                    <h6 ng-bind="subhead"></h6>
                </div>
                <div class="col-lg-2" style="align-self: center !important;">
                    <div class="input-group">
                        <div class="input-group-prepend">
                          <button class="btn btn-outline-primary btn-block rounded-0" type="button" ng-click="Export_Modality_Data_Summary()"> <i class="fa fa-share-square-o"></i> <span>Export</span> </button>
                        </div>
                        <div class="input-group-prepend">
                            <button type="button" class="btn btn-outline-secondary rounded-0" data-dismiss="modal">
                                <span> Close <i class="fa fa-times"></i> </span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- For Exporting -->
            <div class="table-responsive">
                <table class="table" id="MyInquires">
                    <thead class="thead-dark" style="font-size: 10px;">
                        <tr>
                            <th>LAST UPDATE</th>
                            <th>ASSIGNED DAC</th>
                            <th>ASSIGNED RPMO FOCAL</th>
                            <th>STATUS</th>
                            <th>SP ID</th>
                            <th>TITLE</th>
                            <th>PROVINCE</th>
                            <th>MUNICIPALITY</th>
                            <th>BARANGAY</th>
                            <th>PLANNED</th>
                            <th>ACTUAL</th>
                            <th>SLIPPAGE</th>
                            <th>MODALITY</th>
                            <th>CYCLE</th>
                            <th>BATCH</th>
                            <th>CATEGORY</th>
                            <th>TYPE</th>
                            <th>PROJECT COST</th>
                            <th>RFR FIRST TRANCH DATE</th>
                            <th>DATE STARTED</th>
                            <th>ESTIMATED DURATION (DAYS)</th>
                            <th>TARGET COMPLETION DATE</th>
                            <th>ACTUAL COMPLETION DATE</th>
                            <th>PHYSICAL TARGET</th>
                            <th>ISSUES</th>
                            <th>ANALYSIS</th>
                            <th>REMARKS</th>
                        </tr>
                    </thead>    
                    <tbody style="height: 100% !important;">
                        <tr style="font-size: 10px;" ng-repeat="all_data in bars = (show_summary_percentages_data | filter: search_data_modality.$ | filter: search_data_modality.sp_groupings.grouping | filter: search_data_modality.sp_category.category | filter:search_data_modality.sp_type.type | filter: search_data_modality.sp_cycle.cycle | filter:search_data_modality.sp_batch.batch | filter: province_data.name | filter: municipality_data.name | filter: brgy_data.name | filter: search_data_modality.sp_title | filter: search_data_modality.sp_id)">
                            <td>
								<span ng-bind="all_data.updated_at"></span>
                            </td>
                            <td>
                                <div ng-repeat="dac in all_data.assigned_sp track by $index">
                                    <span ng-bind="dac.users[0].Fname +' '+ dac.users[0].Lname" ></span>
                                </div>
                            </td>
                            <td>
                                <div ng-repeat="rpmo in all_data.assigned_grouping track by $index">
                                    <span ng-bind="rpmo.users.Fname +' '+ rpmo.users.Lname"></span> ,<br>
                                </div>
                            </td>

                            <td ng-bind="all_data.sp_status"></td>
                            <td ng-bind="all_data.sp_id"></td>
                             <!-- ng-bind="all_data.sp_title" -->
                            <td>
                                <span class="pb-0 mb-0">
                                    <span ng-bind="all_data.sp_title | uppercase"></span>
                                </span>
                            </td>

                            <td ng-bind="all_data.sp_province"></td>
                            <td ng-bind="all_data.sp_municipality"></td>
                            <td ng-bind="all_data.sp_brgy"></td>
                            
                            <td>
								<span class="text-warning" ng-bind="all_data.planned" ></span>
                            </td>
                            <td>
								<span class="text-warning" ng-bind="all_data.actual" ></span>
                            </td>
                            <td>
								<span class="text-warning" ng-bind="all_data.slippage" ></span>
                            </td>
                            <td ng-bind="all_data.sp_groupings.grouping"></td>
                            <td ng-bind="all_data.sp_cycle.cycle"></td>
                            <td ng-bind="all_data.sp_batch.batch">BATCH</td>
                            <td ng-bind="all_data.sp_category.category">CATEGORY</td>
                            <td ng-bind="all_data.sp_type.type">TYPE</td>
                            <!-- ng-bind="all_data.sp_project_cost | currency: '₱'" -->
                            <td>
                                <span class="pb-0 mb-0" ng-if="all_data.c_m_f_s_kalahi_2015__b_u_b__r_f_r != null">
                                    <span ng-bind="all_data.c_m_f_s_kalahi_2015__b_u_b__r_f_r.amount | currency:'₱ '"></span>
                                </span>
                                <span class="pb-0 mb-0" ng-if="all_data.c_m_f_s_kalahi_2016__b_u_b__r_f_r != null">
                                    <span ng-bind="all_data.c_m_f_s_kalahi_2016__b_u_b__r_f_r.amount | currency:'₱ '"></span>
                                </span>
                                <span class="pb-0 mb-0" ng-if="all_data.c_m_f_s_kalahi_2017__b_u_b__r_f_r != null">
                                    <span ng-bind="all_data.c_m_f_s_kalahi_2017__b_u_b__r_f_r.amount | currency:'₱ '"></span>
                                </span>
                                <span class="pb-0 mb-0" ng-if="all_data.c_m_f_s_kalahi_2018__b_u_b__r_f_r != null">
                                    <span ng-bind="all_data.c_m_f_s_kalahi_2018__b_u_b__r_f_r.amount | currency:'₱ '"></span>
                                </span>
                                <span class="pb-0 mb-0" ng-if="all_data.c_m_f_s_kalahi_2020__b_u_b__r_f_r != null">
                                    <span ng-bind="all_data.c_m_f_s_kalahi_2020__b_u_b__r_f_r.amount | currency:'₱ '"></span>
                                </span>

                                <span class="pb-0 mb-0" ng-if="all_data.c_m_f_s_kalahi_2015__n_c_d_d_p__r_f_r != null">
                                    <span ng-bind="all_data.c_m_f_s_kalahi_2015__n_c_d_d_p__r_f_r.amount | currency: '₱ '"></span>
                                </span>
                                <span class="pb-0 mb-0" ng-if="all_data.c_m_f_s_kalahi_2016__n_c_d_d_p__r_f_r != null">
                                    <span ng-bind="all_data.c_m_f_s_kalahi_2016__n_c_d_d_p__r_f_r.amount | currency: '₱ '"></span>
                                </span>
                                <span class="pb-0 mb-0" ng-if="all_data.c_m_f_s_kalahi_2017__n_c_d_d_p__r_f_r != null">
                                    <span ng-bind="all_data.c_m_f_s_kalahi_2017__n_c_d_d_p__r_f_r.amount | currency: '₱ '"></span>
                                </span>
                                <span class="pb-0 mb-0" ng-if="all_data.c_m_f_s_kalahi_2018__n_c_d_d_p__r_f_r != null">
                                    <span ng-bind="all_data.c_m_f_s_kalahi_2018__n_c_d_d_p__r_f_r.amount | currency: '₱ '"></span>
                                </span>
                                <span class="pb-0 mb-0" ng-if="all_data.c_m_f_s_kalahi_2019__n_c_d_d_p__r_f_r != null">
                                    <span ng-bind="all_data.c_m_f_s_kalahi_2019__n_c_d_d_p__r_f_r.amount | currency: '₱ '"></span>
                                </span>
                                <span class="pb-0 mb-0" ng-if="all_data.c_m_f_s_kalahi_2020__n_c_d_d_p__r_f_r != null">
                                    <span ng-bind="all_data.c_m_f_s_kalahi_2020__n_c_d_d_p__r_f_r.amount | currency: '₱ '"></span>
                                </span>
                            </td>
                            <td >
                                <span class="pb-0 mb-0" ng-if="all_data.c_m_f_s_kalahi_2015__b_u_b__r_f_r != null">
                                    <span ng-bind="all_data.c_m_f_s_kalahi_2015__b_u_b__r_f_r.cash_date"></span>
                                </span>
                                <span class="pb-0 mb-0" ng-if="all_data.c_m_f_s_kalahi_2016__b_u_b__r_f_r != null">
                                    <span ng-bind="all_data.c_m_f_s_kalahi_2016__b_u_b__r_f_r.cash_date"></span>
                                </span>
                                <span class="pb-0 mb-0" ng-if="all_data.c_m_f_s_kalahi_2017__b_u_b__r_f_r != null">
                                    <span ng-bind="all_data.c_m_f_s_kalahi_2017__b_u_b__r_f_r.cash_date"></span>
                                </span>
                                <span class="pb-0 mb-0" ng-if="all_data.c_m_f_s_kalahi_2018__b_u_b__r_f_r != null">
                                    <span ng-bind="all_data.c_m_f_s_kalahi_2018__b_u_b__r_f_r.cash_date"></span>
                                </span>
                                <span class="pb-0 mb-0" ng-if="all_data.c_m_f_s_kalahi_2020__b_u_b__r_f_r != null">
                                    <span ng-bind="all_data.c_m_f_s_kalahi_2020__b_u_b__r_f_r.cash_date"></span>
                                </span>

                                <span class="pb-0 mb-0" ng-if="all_data.c_m_f_s_kalahi_2015__n_c_d_d_p__r_f_r != null">
                                    <span ng-bind="all_data.c_m_f_s_kalahi_2015__n_c_d_d_p__r_f_r.cash_date"></span>
                                </span>
                                <span class="pb-0 mb-0" ng-if="all_data.c_m_f_s_kalahi_2016__n_c_d_d_p__r_f_r != null">
                                    <span ng-bind="all_data.c_m_f_s_kalahi_2016__n_c_d_d_p__r_f_r.cash_date"></span>
                                </span>
                                <span class="pb-0 mb-0" ng-if="all_data.c_m_f_s_kalahi_2017__n_c_d_d_p__r_f_r != null">
                                    <span ng-bind="all_data.c_m_f_s_kalahi_2017__n_c_d_d_p__r_f_r.cash_date"></span>
                                </span>
                                <span class="pb-0 mb-0" ng-if="all_data.c_m_f_s_kalahi_2018__n_c_d_d_p__r_f_r != null">
                                    <span ng-bind="all_data.c_m_f_s_kalahi_2018__n_c_d_d_p__r_f_r.cash_date"></span>
                                </span>
                                <span class="pb-0 mb-0" ng-if="all_data.c_m_f_s_kalahi_2019__n_c_d_d_p__r_f_r != null">
                                    <span ng-bind="all_data.c_m_f_s_kalahi_2019__n_c_d_d_p__r_f_r.cash_date"></span>
                                </span>
                                <span class="pb-0 mb-0" ng-if="all_data.c_m_f_s_kalahi_2020__n_c_d_d_p__r_f_r != null">
                                    <span ng-bind="all_data.c_m_f_s_kalahi_2020__n_c_d_d_p__r_f_r.cash_date"></span>
                                </span>
                            </td>
                            <td ng-bind="all_data.sp_date_started | date: 'fullDate'">DATE STARTED</td>
                            <td ng-bind="all_data.sp_estimated_duration">ESTIMATED DURATION</td>
                            <td ng-bind="all_data.sp_target_date_of_completion | date: 'fullDate'">TARGET COMPLETION DATE</td>
                            <td ng-bind="all_data.sp_actual_date_completed | date: 'fullDate'">
                            </td>
                            <td ng-bind="all_data.sp_physical_target">PHYSICAL TARGET</td>
                            <td>
                                <span ng-if="all_data.sp_logs_latest.sp_logs_issues == 0 || all_data.sp_logs_latest.sp_logs_issues == null || all_data.sp_logs_latest.sp_logs_issues == '' || all_data.sp_logs_latest.sp_logs_issues == 'undefined'">NONE</span>
                                <span ng-if="all_data.sp_logs_latest.sp_logs_issues != 0" ng-bind="all_data.sp_logs_latest.sp_logs_issues"></span>
                            </td>
                            <td>
                                <span ng-if="all_data.sp_logs_latest.sp_logs_analysis == 0 || all_data.sp_logs_latest.sp_logs_analysis == null || all_data.sp_logs_latest.sp_logs_analysis == '' || all_data.sp_logs_latest.sp_logs_analysis == 'undefined' || all_data.sp_logs_latest.sp_logs_analysis == undefined">NONE</span>

                                <span ng-if="all_data.sp_logs_latest.sp_logs_analysis != 0" ng-bind="all_data.sp_logs_latest.sp_logs_analysis"></span>
                            </td>
                            <td>
                                <span ng-if="all_data.sp_logs_latest.sp_logs_remarks == 0 || all_data.sp_logs_latest.sp_logs_remarks == null || all_data.sp_logs_latest.sp_logs_remarks == '' || all_data.sp_logs_latest.sp_logs_remarks == 'undefined' || all_data.sp_logs_latest.sp_logs_remarks == undefined">NONE</span>
                                <span ng-if="all_data.sp_logs_latest.sp_logs_remarks != 0" ng-bind="all_data.sp_logs_latest.sp_logs_remarks"></span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>  
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-outline-secondary rounded-0" data-dismiss="modal">
					<span> Close </span>
				</button>
			</div>			
		</div>
	</div>
</div>