
<!-- FILTER MODAL -->
<div class="modal inmodal fade" id="filterModal" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header py-2 px-3 text-left">
              <span style="font-size: 1.3em;" class="py-0 my-0">
                Filter Modalities
              </span>
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            </div>
          <div class="modal-body" style="padding-top: 10px;padding-bottom: 10px;" ng-cloak>
            <div class="form-group mb-2">
              <label><small class="col-form-label"> <small class="font-weight-bold"> STATUS </small> </small></label>
              <select class="form-control" id="modality" ng-model="search_status">
                <option value="NYS" selected>NYS (NOT YET STARTED)</option>
                <option value="On-going">ON-GOING</option>
                <option value="Completed">COMPLETED</option>
              </select>
            </div>

            <div class="form-group mb-2">
              <label><small class="col-form-label"> <small class="font-weight-bold"> Modality </small> </small></label>
              <select class="form-control" id="modality" ng-model="search_modality">
                <option value="1" selected>KKB</option>
                <option value="2">MAKILAHOK</option>
                <option value="3">NCDDP</option>
                <option value="4">IP CDD</option>
                <option value="5">CCL</option>
                <option value="6">L&E</option>
              </select>
            </div>
        
            <div class="row">
              <div class="col-lg-4">
                <div class="form-group mb-2">
                  <label><small class="col-form-label"> <small class="font-weight-bold"> Year </small> </small></label>
                  <select class="form-control" id="year" ng-model="search_year">
                    <option value="2014" selected> 2014 </option>
                    <option value="2015"> 2015 </option>
                    <option value="2016"> 2016 </option>
                    <option value="2017"> 2017 </option>
                    <option value="2018"> 2018 </option>
                    <option value="2019"> 2019 </option>
                    <option value="2020"> 2020 </option>
                  </select>
                </div>
              </div>
              <div class="col-lg-4">
                <div class="form-group mb-2">
                  <label><small class="col-form-label"> <small class="font-weight-bold"> Cycle </small> </small></label>
                  <select class="form-control" id="cycle" ng-model="search_cycle">
                    <option value="1" selected> 1 </option>
                    <option value="2"> 2 </option>
                    <option value="3"> 3 </option>
                    <option value="4"> 4 </option>
                    <option value="5"> 5 </option>
                  </select>
                </div>
              </div>
              <div class="col-lg-4">
                <div class="form-group mb-2">
                  <label><small class="col-form-label"> <small class="font-weight-bold"> Batch </small> </small></label>
                  <select class="form-control" id="batch" ng-model="search_batch">
                    <option value="1" selected> 1 </option>
                    <option value="2"> 2 </option>
                    <option value="3"> 3 </option>
                    <option value="4"> 4 </option>
                    <option value="5"> 5 </option>
                  </select>
                </div>
              </div>
            </div>
            
            <div class="form-group mb-2">
              <label><small class="col-form-label"> <small class="font-weight-bold"> Province </small> </small></label>
              <select class="form-control" ng-model="province_data" ng-options="prov_data.name for prov_data in reg" ng-change="fetch_municipality(province_data.prov_code)">
              </select>
            </div>
            
            <div class="form-group mb-2">
              <label><small class="col-form-label"> <small class="font-weight-bold"> Municipality </small> </small></label>
              <select class="form-control" ng-model="municipality_data" ng-options="muni_data.name for muni_data in muni" ng-change="fetch_brgy(municipality_data.mun_code)">
              </select>
            </div>
            
            <div class="form-group mb-2">
              <label><small class="col-form-label"> <small class="font-weight-bold"> Brgy </small> </small></label>
              <select class="form-control" ng-model="brgy_data" ng-options="b_data.name for b_data in brgy">
              </select>
            </div>

            <div class="form-group mb-2">
              <label><small class="col-form-label"> <small class="font-weight-bold"> SP Title </small> </small></label>
              <input type="text" class="form-control" aria-describedby="emailHelp" placeholder="Ex. FISH CAGE CULTURE..." ng-model="search_title">
            </div>

            <div class="form-group mb-2">
              <label><small class="col-form-label"> <small class="font-weight-bold"> SP ID </small> </small></label>
              <input type="text" class="form-control" aria-describedby="emailHelp" placeholder="Ex. 201804000..." ng-model="search_sp_id">
            </div>
            </div>
          <div class="modal-footer">
        <button class="btn btn-primary" type="button" data-dismiss="modal" ng-click="search_data_modal(search_status,search_modality,search_year,search_cycle,search_batch,province_data,municipality_data,brgy_data,search_title,search_sp_id)">Generate <i class="fa fa-gears "></i></button>
        <button class="btn btn-white" type="button" data-dismiss="modal">Cancel <i class="fa fa-times"></i></button>
          </div>
        </div>
    </div>
</div>


<!-- SpecificSP MODAL -->
<div class="modal fade" id="SpecificSP_Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg rounded-0" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"> <span ng-bind="specific_sp_data.sp_title"></span> <br>
          <span class="font-weight-light" style="font-size: 18px;">SP ID:</span> <span class="font-weight-light text-primary" style="font-size: 18px;" ng-bind="specific_sp_data.sp_id"> </span>
        </h5>
        <p>Last updated on: Monday Sept 28, 2019</p>

      </div>
      <div class="modal-body">
        <div style="padding-top: 10px;padding-bottom: 10px;" ng-show="planned_sched_div == false" ng-cloak>
          <div class="row">

            <div class="col-lg-4">
              <small> <b>Groupings</b> </small>
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

            <div class="col-lg-4">
              <small> <b>Province</b> </small>
              <p ng-bind="specific_sp_data.sp_province">SURIGAO DEL SUR</p>
            </div>
            <div class="col-lg-4">
              <small> <b>Municipality</b> </small>
              <p ng-bind="specific_sp_data.sp_municipality">Marihatag</p>
            </div>


            <div class="col-lg-4">
              <small> <b>Barangay</b> </small>
              <p ng-bind="specific_sp_data.sp_brgy">AMONTAY</p>
            </div>

            <div class="col-lg-4">
              <small> <b>RFR 1st Tranch Date Downloaded </b> </small>
              <p ng-if="specific_sp_data.c_m_f_s_kalahi_2015__b_u_b__r_f_r != null">
                <span ng-bind="specific_sp_data.c_m_f_s_kalahi_2015__b_u_b__r_f_r.cash_date"></span>
                <br>
                <span ng-bind="specific_sp_data.c_m_f_s_kalahi_2015__b_u_b__r_f_r.amount | currency:'₱ '"></span>
              </p>
              <p ng-if="specific_sp_data.c_m_f_s_kalahi_2016__b_u_b__r_f_r != null">
                <span ng-bind="specific_sp_data.c_m_f_s_kalahi_2016__b_u_b__r_f_r.cash_date"></span>
                <br>
                <span ng-bind="specific_sp_data.c_m_f_s_kalahi_2016__b_u_b__r_f_r.amount | currency:'₱ '"></span>
              </p>
              <p ng-if="specific_sp_data.c_m_f_s_kalahi_2017__b_u_b__r_f_r != null">
                <span ng-bind="specific_sp_data.c_m_f_s_kalahi_2017__b_u_b__r_f_r.cash_date"></span>
                <br>
                <span ng-bind="specific_sp_data.c_m_f_s_kalahi_2017__b_u_b__r_f_r.amount | currency:'₱ '"></span>
              </p>
              <p ng-if="specific_sp_data.c_m_f_s_kalahi_2018__b_u_b__r_f_r != null">
                <span ng-bind="specific_sp_data.c_m_f_s_kalahi_2018__b_u_b__r_f_r.cash_date"></span>
                <br>
                <span ng-bind="specific_sp_data.c_m_f_s_kalahi_2018__b_u_b__r_f_r.amount | currency:'₱ '"></span>
              </p>
              <p ng-if="specific_sp_data.c_m_f_s_kalahi_2020__b_u_b__r_f_r != null">
                <span ng-bind="specific_sp_data.c_m_f_s_kalahi_2020__b_u_b__r_f_r.cash_date"></span>
                <br>
                <span ng-bind="specific_sp_data.c_m_f_s_kalahi_2020__b_u_b__r_f_r.amount | currency:'₱ '"></span>
              </p>

              <!-- NCDDP -->
              <p ng-if="specific_sp_data.c_m_f_s_kalahi_2015__n_c_d_d_p__r_f_r != null">
                <span ng-bind="specific_sp_data.c_m_f_s_kalahi_2015__n_c_d_d_p__r_f_r.cash_date"></span>
                <br>
                <span ng-bind="specific_sp_data.c_m_f_s_kalahi_2015__n_c_d_d_p__r_f_r.amount | currency: '₱ '"></span>
              </p>
              <p ng-if="specific_sp_data.c_m_f_s_kalahi_2016__n_c_d_d_p__r_f_r != null">
                <span ng-bind="specific_sp_data.c_m_f_s_kalahi_2016__n_c_d_d_p__r_f_r.cash_date"></span>
                <br>
                <span ng-bind="specific_sp_data.c_m_f_s_kalahi_2016__n_c_d_d_p__r_f_r.amount | currency: '₱ '"></span>
              </p>
              <p ng-if="specific_sp_data.c_m_f_s_kalahi_2017__n_c_d_d_p__r_f_r != null">
                <span ng-bind="specific_sp_data.c_m_f_s_kalahi_2017__n_c_d_d_p__r_f_r.cash_date"></span>
                <br>
                <span ng-bind="specific_sp_data.c_m_f_s_kalahi_2017__n_c_d_d_p__r_f_r.amount | currency: '₱ '"></span>
              </p>
              <p ng-if="specific_sp_data.c_m_f_s_kalahi_2018__n_c_d_d_p__r_f_r != null">
                <span ng-bind="specific_sp_data.c_m_f_s_kalahi_2018__n_c_d_d_p__r_f_r.cash_date"></span>
                <br>
                <span ng-bind="specific_sp_data.c_m_f_s_kalahi_2018__n_c_d_d_p__r_f_r.amount | currency: '₱ '"></span>
              </p>
              <p ng-if="specific_sp_data.c_m_f_s_kalahi_2019__n_c_d_d_p__r_f_r != null">
                <span ng-bind="specific_sp_data.c_m_f_s_kalahi_2019__n_c_d_d_p__r_f_r.cash_date"></span>
                <br>
                <span ng-bind="specific_sp_data.c_m_f_s_kalahi_2019__n_c_d_d_p__r_f_r.amount | currency: '₱ '"></span>
              </p>
              <p ng-if="specific_sp_data.c_m_f_s_kalahi_2020__n_c_d_d_p__r_f_r != null">
                <span ng-bind="specific_sp_data.c_m_f_s_kalahi_2020__n_c_d_d_p__r_f_r.cash_date"></span>
                <br>
                <span ng-bind="specific_sp_data.c_m_f_s_kalahi_2020__n_c_d_d_p__r_f_r.amount | currency: '₱ '"></span>
              </p>
            </div>

            <div class="col-lg-4">
              <small> <b>Sp Category</b> </small>
              <p ng-bind="specific_sp_data.sp_category.category">Enterprise</p>
            </div>

            <div class="col-lg-4">
              <small> <b>Sp Type</b> </small>
              <p ng-bind="specific_sp_data.sp_type.type">Others</p>
            </div>

            <div class="col-lg-4">
              <small> <b>Physical target</b> </small>
              <p ng-if="specific_sp_data.sp_physical_target != null" ng-bind="specific_sp_data.sp_physical_target">Others</p>
              <p ng-if="specific_sp_data.sp_physical_target == null">NOT APPLICABLE</p>
            </div>

            <div class="col-lg-4">
              <small> <b>Total Project Cost</b> </small>
              <p ng-if="specific_sp_data.c_m_f_s_kalahi_2015__b_u_b__s_p != null">
                <span ng-bind="total_project_cost | currency:'₱'"></span>
              </p>
              <p ng-if="specific_sp_data.c_m_f_s_kalahi_2016__b_u_b__s_p != null">
                <span ng-bind="total_project_cost | currency:'₱'"></span>
              </p>
              <p ng-if="specific_sp_data.c_m_f_s_kalahi_2017__b_u_b__s_p != null">
                <span ng-bind="total_project_cost | currency:'₱'"></span>
              </p>
              <p ng-if="specific_sp_data.c_m_f_s_kalahi_2018__b_u_b__s_p != null">
                <span ng-bind="total_project_cost | currency:'₱'"></span>
              </p>
              <p ng-if="specific_sp_data.c_m_f_s_kalahi_2020__b_u_b__s_p != null">
                <span ng-bind="total_project_cost | currency:'₱'"></span>
              </p>
              <!-- NCDDP -->
              <p ng-if="specific_sp_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p != null">
                <span ng-bind="total_project_cost | currency:'₱'"></span>
              </p>
              <p ng-if="specific_sp_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p != null">
                <span ng-bind="total_project_cost | currency:'₱'"></span>
              </p>
              <p ng-if="specific_sp_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p != null">
                <span ng-bind="total_project_cost | currency:'₱'"></span>
              </p>
              <p ng-if="specific_sp_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p != null">
                <span ng-bind="total_project_cost | currency:'₱'"></span>
              </p>
              <p ng-if="specific_sp_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p != null">
                <span ng-bind="total_project_cost | currency:'₱'"></span>
              </p>
              <p ng-if="specific_sp_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p != null">
                <span ng-bind="total_project_cost | currency:'₱'"></span>
              </p>
            </div>

            <div class="col-lg-4">
              <small> <b>Date started</b> </small>
              <p ng-bind="specific_sp_data.sp_date_started | date:'fullDate'">0000-00-00</p>
            </div>
            <div class="col-lg-4">
              <small> <b>Estimated duration</b> </small>
              <p ng-bind="(specific_sp_data.sp_estimated_duration) + ' Days'"></p>
            </div>
            <div class="col-lg-4">
              <small> <b>Target date of completion</b> </small>
              <p ng-bind="specific_sp_data.sp_target_date_of_completion | date:'fullDate'">0000-00-00</p>
            </div>
            <div class="col-lg-4">
              <small> <b>Days suspended</b> </small>
              <p ng-bind="(specific_sp_data.sp_days_suspended) + ' Days'"></p>
            </div>
            <div class="col-lg-4">
              <small> <b>Actual date completed</b> </small>
              <p ng-if="specific_sp_data.sp_actual_date_completed != null && specific_sp_data.sp_actual_date_completed != 'Invalid Date'" ng-bind="specific_sp_data.sp_actual_date_completed | date:'fullDate'"></p>
              <p ng-if="specific_sp_data.sp_actual_date_completed == 'Invalid Date'"> 0000-00-00 </p>
            </div>
            <div class="col-lg-4">
              <small> <b>Date of turn over</b> </small>
              <p ng-if="specific_sp_data.sp_date_of_turnover != null && specific_sp_data.sp_date_of_turnover != 'Invalid Date'" ng-bind="specific_sp_data.sp_date_of_turnover | date:'fullDate'"></p>
              <p ng-if="specific_sp_data.sp_date_of_turnover == 'Invalid Date'"> 0000-00-00 </p>
            </div>

            <div class="col-lg-12">
              <hr>
              <div class="row">
				<div class="col-lg-4" ng-cloak>
					<small><b>Planned</b></small>
				  <div ng-repeat="logs_planned in specific_sp_data.sp_logs  track by $index">
				    <span ng-show="$last" ng-bind="(logs_planned.sp_logs_planned) + '%'" ></span>
				  </div>
				</div>
				<div class="col-lg-4" ng-cloak>
					<small><b>Actual</b></small>
				  <div ng-repeat="logs_planned in specific_sp_data.sp_logs  track by $index">
				    <span ng-show="$last" ng-bind="(logs_planned.sp_logs_actual) + '%'"></span>
				  </div>
				</div>
				<div class="col-lg-4" ng-cloak>
					<small><b>Slippage</b></small>
				  <div ng-repeat="logs_planned in specific_sp_data.sp_logs  track by $index">
				    <span ng-if="logs_planned.sp_logs_slippage >= 0" class="text-success" ng-show="$last" ng-bind="(logs_planned.sp_logs_slippage) + '%'"></span>
				    <span ng-if="logs_planned.sp_logs_slippage < 0" class="text-danger" ng-show="$last" ng-bind="(logs_planned.sp_logs_slippage) + '%'"></span>
				  </div>
				</div>
              </div>
            </div>

          </div>
        </div>
        <!-- End of Specific -->
        
        <!-- PLANNED SCHED -->
        <div style="padding-top: 10px;padding-bottom: 10px;" ng-show="planned_sched_div == true" ng-cloak>
        	<canvas id="myChart" style="width: 100%;"></canvas>
        	<br>
          <div class="row" ng-repeat="p_data in planned_sched track by $index">          	

        <div class="col-lg-12">
          <small>Target Date</small> <br>
          <span style="font-weight: bold;" class="text-primary" id="target_date" ng-bind="p_data.sp_logs_planned_target_date | date: 'fullDate'"></span>
        </div>

        <div class="col-lg-12 mb-2"></div>

        <div class="col-lg-4">
          <small>Planned (Week <span ng-bind="$index + 1 +')'"></span> </small> <br>
          <span style="font-weight: bold;" class="text-primary" id="percentage" ng-bind="(p_data.sp_logs_planned) + '%'"></span>
        </div>

        <div class="col-lg-4">
          <small>Actual</small> <br>
          <span style="font-weight: bold;" class="text-primary" id="target_date" ng-if="p_data.sp_logs_actual == null">
            NOT APPLICABLE
          </span>
          <span style="font-weight: bold;" class="text-primary" id="target_date" ng-if="p_data.sp_logs_actual != null" ng-bind="(p_data.sp_logs_actual) + '%'"></span>
        </div>

        <div class="col-lg-4">
          <small>Slippage</small> <br>
          <span style="font-weight: bold;" class="text-primary" id="target_date" ng-if="p_data.sp_logs_slippage == null">
            NOT APPLICABLE
          </span>
          <span style="font-weight: bold;" class="text-success" id="target_date" ng-if="p_data.sp_logs_slippage >= 0 && p_data.sp_logs_slippage != null" ng-bind="(p_data.sp_logs_slippage) + '%'"></span>
          <span style="font-weight: bold;" class="text-danger" id="target_date" ng-if="p_data.sp_logs_slippage < 0 && p_data.sp_logs_slippage != null" ng-bind="(p_data.sp_logs_slippage) + '%'"></span>
        </div>

        <div class="col-lg-12 mb-2"></div>
        
        @verbatim
        <div class="col-lg-3">
          <small>Variation order</small> <br>
          <span style="font-weight: bold;" ng-if="p_data.sp_logs_variation_order == 0 || p_data.sp_logs_variation_order == '0'" class="text-primary pulsate" id="target_date"> NOT APPLICABLE </span>
          <a style="font-weight: bold;" ng-if="p_data.sp_logs_variation_order != 0 || p_data.sp_logs_variation_order != '0'" href="http://kce_v2.caraga.dswd.gov.ph/admin_rcis/routes/downloadables">Go to downloadables <i class="fa fa-download"></i></a>
        </div>

        <div class="col-lg-3">
          <small>ESMR</small> <br>
          <span style="font-weight: bold;" ng-if="p_data.sp_logs_variation_order == 0 || p_data.sp_logs_variation_order == '0' " class="text-primary pulsate" id="target_date"> NOT APPLICABLE </span>
          <a style="font-weight: bold;" ng-if="p_data.sp_logs_esmr != 0 || p_data.sp_logs_esmr != '0'" href="http://kce_v2.caraga.dswd.gov.ph/admin_rcis/routes/downloadables">Go to downloadables <i class="fa fa-download"></i></a>
        </div>

        <div class="col-lg-3">
          <small>CSR</small> <br>
          <span style="font-weight: bold;" class="text-primary pulsate" id="target_date" ng-if="p_data.sp_logs_csr == 0 || p_data.sp_logs_csr == '0' ">NOT APPLICABLE</span>
          <a style="font-weight: bold;" ng-if="p_data.sp_logs_csr != 0 || p_data.sp_logs_csr != '0'"  href="http://kce_v2.caraga.dswd.gov.ph/admin_rcis/routes/downloadables">Go to downloadables <i class="fa fa-download"></i></a>
        </div>

            <div class="col-lg-3">
              <small>MATERIALS TESTING</small> <br>

              <span style="font-weight: bold;" class="text-primary pulsate" id="target_date" ng-if="p_data.sp_logs_mt == '0' || p_data.sp_logs_mt == 0">NOT APPLICABLE</span>
              <a style="font-weight: bold;" ng-if="p_data.sp_logs_mt != '0' || p_data.sp_logs_mt != 0"  href="http://kce_v2.caraga.dswd.gov.ph/admin_rcis/routes/downloadables">Go to downloadables <i class="fa fa-download"></i></a>
            </div>
            @endverbatim

        <div class="col-lg-12 mb-2"></div>

            <div class="col-lg-3">
              <small> Issues/Problem Encountered </small>
              <br>
              <span style="font-weight: bold;" ng-if="p_data.sp_logs_issues != '0' && p_data.sp_logs_issues != 0" class="text-primary" ng-bind="p_data.sp_logs_issues"></span>
              <span style="font-weight: bold;" ng-if="p_data.sp_logs_issues == '0' || p_data.sp_logs_issues == 0" class="text-primary pulsate">NOT APPLICABLE</span>
            </div>

            <div class="col-lg-3">
              <small> Analysis </small>
              <br>
              <span style="font-weight: bold;" class="text-primary" ng-if="p_data.sp_logs_analysis != '0' && p_data.sp_logs_analysis != 0" class="text-primary" ng-bind="p_data.sp_logs_analysis"></span>
              <span style="font-weight: bold;" class="text-primary pulsate" ng-if="p_data.sp_logs_analysis == '0' || p_data.sp_logs_analysis == 0">NOT APPLICABLE</span>
                </div>

            <div class="col-lg-3">
              <small> Remarks </small>
              <br>
              <span style="font-weight: bold;" ng-if="p_data.sp_logs_remarks != '0' && p_data.sp_logs_remarks != 0" class="text-primary" ng-bind="p_data.sp_logs_remarks"></span>
              <span style="font-weight: bold;" ng-if="p_data.sp_logs_remarks == '0' || p_data.sp_logs_remarks == 0" class="text-primary pulsate">NOT APPLICABLE</span>
            </div>

        <div class="col-lg-12 mb-2"></div>
        <div class="col-lg-12"> <hr> </div>
      </div>
        </div>
        <!-- End of planned sched -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary rounded-0" ng-show="planned_sched_div == false" ng-click="view_planned_sched(specific_sp_data.sp_id)"> <i class="fa fa-list-alt"></i> View Track History</button>
        <button type="button" class="btn btn-secondary rounded-0" ng-show="planned_sched_div == true" ng-click="back_to_render_specific_sp()"> <i class="fa fa-chevron-left"></i> Back</button>
        <button type="button" class="btn btn-secondary rounded-0" data-dismiss="modal" ng-click="back_to_render_specific_sp()"> <i class="fa fa-times"></i> Close</button>
      </div>
    </div>
  </div>
</div>