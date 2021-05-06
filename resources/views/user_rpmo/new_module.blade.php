<link href="{{ asset('dataTables/datatablesnew.min.css') }}" rel="stylesheet">
<link href="{{ asset('dataTables/w3.css') }}" rel="stylesheet">
<script type="text/javascript" src="{{ asset('js/admin_rcis_functions.js') }}" ></script>
<style>

.loading {
	animation: bounceIn 1300ms infinite
}

@keyframes bounceIn {
	from,20%,40%,60%,80%,
	to {animation-timing-function: cubic-bezier(0.215, 0.61, 0.355, 1);}
	0% {opacity: 0;transform: scale3d(0.3, 0.3, 0.3);}
	20% {transform: scale3d(1.1, 1.1, 1.1);}
	40% {transform: scale3d(0.9, 0.9, 0.9);}
	60% {opacity: 1;transform: scale3d(1.03, 1.03, 1.03);}
	80% {transform: scale3d(0.97, 0.97, 0.97);}
	to {opacity: 1;transform: scale3d(1, 1, 1);}
}
*{
	font-size: 12px
}

</style>
<div id='content' style='padding:20px;margin:5px;border:1px solid #f5f5f5;'>
<h4 class='text-center loading'><strong style="color:black;font-size: 20px;">Retrieving Data from the Server...</strong><br><br><i class="fa fa-database  fa-3x fa-fw" style="color:#86ebb8;font-size: 8x;"></i></h4>   
</div>

<div id="id01" class="x-modal">
	<div class="x-modal-content x-round-large">
		<div class="x-container x-padding">
			<span onclick="$ID('id01').style.display='none'"
			class="x-button x-display-topright x-round-large x-red">&times;</span>
			<h4 class="x-text-blue">Details for SP # : <b id="sp_id_v"></b></h4>
			<div class="x-row x-container">
				<div class="x-container x-col l4 s4 m4">
					<h4 class="x-row">Date Started</h4>
					<div class="x-row">
						<input type="date" class="x-col s7 m7 l7 x-input x-border" name="started_date" id="started_date">
						<button class="x-col s5 m5 l5 x-btn x-blue" onclick="set_start_date()">Set Date</button>
					</div>
				</div>
			</div>
			<hr>
			<div class="x-container x-padding x-row">
				<!-- <button class="x-btn x-orange">RFR Tracking</button> -->
				<!-- <button class="x-btn x-green">SPCR Tracking</button> -->
		      	<button type="button" style="border-radius: 100px;" class="btn btn-outline-primary mb-2" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#plan_history" ng-click="view_planned_sched($ID('sp_id_v').innerHTML)"> <i class="fa fa-history"></i> View Track history </button>
		      	<button data-backdrop="static" data-keyboard="false" data-target="#SpecificSP_Modal" data-toggle="modal" class="btn btn-outline-primary rounded-0 btn-block" ng-click="render_specific_sp(all_data)"> View <i class="fa fa-eye"></i>
                </button>
			</div>
		</div>
	</div>
</div>
<!-- ------------------ -->
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
<!-- ----------------------- -->
<script type="text/javascript" src="{{ asset('/dataTables/datatablesnew.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/dataTables/Brorn.min.js') }}"></script>
<script>


function init(){
	$.ajax({
		type:'GET',
		url:'new_module_content_table',
		success: function(data){
			$('#content').html(data);
			$('#table_details').DataTable({
				 'processing': true,
				 'dom': 'lBfrtip',
				 aLengthMenu: [
						[ 10, 25, 50, 100, 200, 500, 1000, -1],
						[ 10, 25, 50, 100, 200, 500, 1000, "All"]
					],
					iDisplayLength: 10,
				 'buttons': [
					{
						extend: 'collection',
						text: 'Export to...',
						buttons: [
							'copy',
							'excel',
							'csv',
							'pdf',
							'print'
						]
					}
				]
			});
		}
	});	
}

init();

function det_modal(res){
	// render_specific_sp(all_data)
	$ID('sp_id_v').innerHTML = res
	$ID('id01').style.display='block'
	// $send({
	// 	action:'/rpmo/routes/get_sp_details',
	// 	data : $DATA({'data':res}),
	// 	method : POST,
	// 	_async : true,
	// 	headers : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
	// 	func : function(res){
	// 		$print(res)
	// 	}
	// })

}

function set_start_date(){
	var c = confirm('Are You Sure?');
	if(c){
		spid = $ID('sp_id_v').innerHTML;
		date_start = $ID('started_date').value;
		$print(date_start);
		$send({
			action:'/rpmo/routes/set_date_start',
			data : $DATA({
				'date':date_start,
				'id':spid,
				}),
			method : POST,
			_async : true,
			headers : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			func : function(res){
				// location.reload()
				// $print(res);
				// alert(res);
				init();
				$ID('id01').style.display='none';

			}
		})
	}
	
}


var app = angular.module('Admin_RCIS_Function', []);

app.directive('errSrc', function() {
  return {
    link: function(scope, element, attrs) {
      element.bind('error', function() {
        if (attrs.src != attrs.errSrc) {
          attrs.$set('src', attrs.errSrc);
        }
      });
      
      attrs.$observe('ngSrc', function(value) {
        if (!value && attrs.errSrc) {
          attrs.$set('src', attrs.errSrc);
        }
      });
    }
  }
});

app.controller('Admin_RCIS_Controller', function($scope,$http,$filter) {
		$scope.render_specific_sp = function(data){
		console.log(data);

		$scope.specific_sp_data = data;

		$send({
			action:'/rpmo/routes/set_date_start',
			data : $DATA({
				'id':$ID('sp_id_v').innerHTML = res
				}),
			method : POST,
			_async : true,
			headers : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			func : function(data){
				if($scope.specific_sp_data.c_m_f_s_kalahi_2015__b_u_b__s_p != null){
	      $scope.paramObj = {
	        grant: $scope.specific_sp_data.c_m_f_s_kalahi_2015__b_u_b__s_p.grant,
	        contigency: $scope.specific_sp_data.c_m_f_s_kalahi_2015__b_u_b__s_p.contigency,
	        other_amount: $scope.specific_sp_data.c_m_f_s_kalahi_2015__b_u_b__s_p.other_amount,
	        lcc_community: $scope.specific_sp_data.c_m_f_s_kalahi_2015__b_u_b__s_p.lcc_community,
	        lcc_community_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2015__b_u_b__s_p.lcc_community_ik,
	        lcc_blgu: $scope.specific_sp_data.c_m_f_s_kalahi_2015__b_u_b__s_p.lcc_blgu,
	        lcc_blgu_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2015__b_u_b__s_p.lcc_blgu_ik,
	        lcc_mlgu: $scope.specific_sp_data.c_m_f_s_kalahi_2015__b_u_b__s_p.lcc_mlgu,
	        lcc_mlgu_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2015__b_u_b__s_p.lcc_mlgu_ik,
	        lcc_plgu: $scope.specific_sp_data.c_m_f_s_kalahi_2015__b_u_b__s_p.lcc_plgu,
	        lcc_plgu_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2015__b_u_b__s_p.lcc_plgu_ik,
	        lcc_others: $scope.specific_sp_data.c_m_f_s_kalahi_2015__b_u_b__s_p.lcc_others,
	        lcc_others_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2015__b_u_b__s_p.lcc_others_ik,
	        lcc_cash: $scope.specific_sp_data.c_m_f_s_kalahi_2015__b_u_b__s_p.lcc_cash,
	        lcc_in_kind: $scope.specific_sp_data.c_m_f_s_kalahi_2015__b_u_b__s_p.lcc_in_kind,
	      }
	      $scope.total_project_cost = $scope.get_total_project_cost($scope.paramObj); 
	    
	    }else if($scope.specific_sp_data.c_m_f_s_kalahi_2016__b_u_b__s_p != null){
	      $scope.paramObj = {
	        grant: $scope.specific_sp_data.c_m_f_s_kalahi_2016__b_u_b__s_p.grant,
	        contigency: $scope.specific_sp_data.c_m_f_s_kalahi_2016__b_u_b__s_p.contigency,
	        other_amount: $scope.specific_sp_data.c_m_f_s_kalahi_2016__b_u_b__s_p.other_amount,
	        lcc_community: $scope.specific_sp_data.c_m_f_s_kalahi_2016__b_u_b__s_p.lcc_community,
	        lcc_community_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2016__b_u_b__s_p.lcc_community_ik,
	        lcc_blgu: $scope.specific_sp_data.c_m_f_s_kalahi_2016__b_u_b__s_p.lcc_blgu,
	        lcc_blgu_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2016__b_u_b__s_p.lcc_blgu_ik,
	        lcc_mlgu: $scope.specific_sp_data.c_m_f_s_kalahi_2016__b_u_b__s_p.lcc_mlgu,
	        lcc_mlgu_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2016__b_u_b__s_p.lcc_mlgu_ik,
	        lcc_plgu: $scope.specific_sp_data.c_m_f_s_kalahi_2016__b_u_b__s_p.lcc_plgu,
	        lcc_plgu_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2016__b_u_b__s_p.lcc_plgu_ik,
	        lcc_others: $scope.specific_sp_data.c_m_f_s_kalahi_2016__b_u_b__s_p.lcc_others,
	        lcc_others_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2016__b_u_b__s_p.lcc_others_ik,
	        lcc_cash: $scope.specific_sp_data.c_m_f_s_kalahi_2016__b_u_b__s_p.lcc_cash,
	        lcc_in_kind: $scope.specific_sp_data.c_m_f_s_kalahi_2016__b_u_b__s_p.lcc_in_kind,
	      }
	      $scope.total_project_cost = $scope.get_total_project_cost($scope.paramObj); 
	    
	    }else if($scope.specific_sp_data.c_m_f_s_kalahi_2017__b_u_b__s_p != null){
	      $scope.paramObj = {
	        grant: $scope.specific_sp_data.c_m_f_s_kalahi_2017__b_u_b__s_p.grant,
	        contigency: $scope.specific_sp_data.c_m_f_s_kalahi_2017__b_u_b__s_p.contigency,
	        other_amount: $scope.specific_sp_data.c_m_f_s_kalahi_2017__b_u_b__s_p.other_amount,
	        lcc_community: $scope.specific_sp_data.c_m_f_s_kalahi_2017__b_u_b__s_p.lcc_community,
	        lcc_community_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2017__b_u_b__s_p.lcc_community_ik,
	        lcc_blgu: $scope.specific_sp_data.c_m_f_s_kalahi_2017__b_u_b__s_p.lcc_blgu,
	        lcc_blgu_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2017__b_u_b__s_p.lcc_blgu_ik,
	        lcc_mlgu: $scope.specific_sp_data.c_m_f_s_kalahi_2017__b_u_b__s_p.lcc_mlgu,
	        lcc_mlgu_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2017__b_u_b__s_p.lcc_mlgu_ik,
	        lcc_plgu: $scope.specific_sp_data.c_m_f_s_kalahi_2017__b_u_b__s_p.lcc_plgu,
	        lcc_plgu_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2017__b_u_b__s_p.lcc_plgu_ik,
	        lcc_others: $scope.specific_sp_data.c_m_f_s_kalahi_2017__b_u_b__s_p.lcc_others,
	        lcc_others_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2017__b_u_b__s_p.lcc_others_ik,
	        lcc_cash: $scope.specific_sp_data.c_m_f_s_kalahi_2017__b_u_b__s_p.lcc_cash,
	        lcc_in_kind: $scope.specific_sp_data.c_m_f_s_kalahi_2017__b_u_b__s_p.lcc_in_kind,
	      }
	      $scope.total_project_cost = $scope.get_total_project_cost($scope.paramObj); 

	    }else if($scope.specific_sp_data.c_m_f_s_kalahi_2018__b_u_b__s_p != null){
	      $scope.paramObj = {
	        grant: $scope.specific_sp_data.c_m_f_s_kalahi_2018__b_u_b__s_p.grant,
	        contigency: $scope.specific_sp_data.c_m_f_s_kalahi_2018__b_u_b__s_p.contigency,
	        other_amount: $scope.specific_sp_data.c_m_f_s_kalahi_2018__b_u_b__s_p.other_amount,
	        lcc_community: $scope.specific_sp_data.c_m_f_s_kalahi_2018__b_u_b__s_p.lcc_community,
	        lcc_community_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2018__b_u_b__s_p.lcc_community_ik,
	        lcc_blgu: $scope.specific_sp_data.c_m_f_s_kalahi_2018__b_u_b__s_p.lcc_blgu,
	        lcc_blgu_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2018__b_u_b__s_p.lcc_blgu_ik,
	        lcc_mlgu: $scope.specific_sp_data.c_m_f_s_kalahi_2018__b_u_b__s_p.lcc_mlgu,
	        lcc_mlgu_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2018__b_u_b__s_p.lcc_mlgu_ik,
	        lcc_plgu: $scope.specific_sp_data.c_m_f_s_kalahi_2018__b_u_b__s_p.lcc_plgu,
	        lcc_plgu_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2018__b_u_b__s_p.lcc_plgu_ik,
	        lcc_others: $scope.specific_sp_data.c_m_f_s_kalahi_2018__b_u_b__s_p.lcc_others,
	        lcc_others_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2018__b_u_b__s_p.lcc_others_ik,
	        lcc_cash: $scope.specific_sp_data.c_m_f_s_kalahi_2018__b_u_b__s_p.lcc_cash,
	        lcc_in_kind: $scope.specific_sp_data.c_m_f_s_kalahi_2018__b_u_b__s_p.lcc_in_kind,
	      }
	      $scope.total_project_cost = $scope.get_total_project_cost($scope.paramObj); 
	    
	    }else if($scope.specific_sp_data.c_m_f_s_kalahi_2020__b_u_b__s_p != null){
	      $scope.paramObj = {
	        grant: $scope.specific_sp_data.c_m_f_s_kalahi_2020__b_u_b__s_p.grant,
	        contigency: $scope.specific_sp_data.c_m_f_s_kalahi_2020__b_u_b__s_p.contigency,
	        other_amount: $scope.specific_sp_data.c_m_f_s_kalahi_2020__b_u_b__s_p.other_amount,
	        lcc_community: $scope.specific_sp_data.c_m_f_s_kalahi_2020__b_u_b__s_p.lcc_community,
	        lcc_community_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2020__b_u_b__s_p.lcc_community_ik,
	        lcc_blgu: $scope.specific_sp_data.c_m_f_s_kalahi_2020__b_u_b__s_p.lcc_blgu,
	        lcc_blgu_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2020__b_u_b__s_p.lcc_blgu_ik,
	        lcc_mlgu: $scope.specific_sp_data.c_m_f_s_kalahi_2020__b_u_b__s_p.lcc_mlgu,
	        lcc_mlgu_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2020__b_u_b__s_p.lcc_mlgu_ik,
	        lcc_plgu: $scope.specific_sp_data.c_m_f_s_kalahi_2020__b_u_b__s_p.lcc_plgu,
	        lcc_plgu_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2020__b_u_b__s_p.lcc_plgu_ik,
	        lcc_others: $scope.specific_sp_data.c_m_f_s_kalahi_2020__b_u_b__s_p.lcc_others,
	        lcc_others_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2020__b_u_b__s_p.lcc_others_ik,
	        lcc_cash: $scope.specific_sp_data.c_m_f_s_kalahi_2020__b_u_b__s_p.lcc_cash,
	        lcc_in_kind: $scope.specific_sp_data.c_m_f_s_kalahi_2020__b_u_b__s_p.lcc_in_kind,
	      }
	      $scope.total_project_cost = $scope.get_total_project_cost($scope.paramObj); 

	    }else;

	    // NCDDP

	    if($scope.specific_sp_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p != null){
	      $scope.paramObj = {
	        grant: $scope.specific_sp_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p.grant,
	        contigency: $scope.specific_sp_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p.contigency,
	        other_amount: $scope.specific_sp_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p.other_amount,
	        lcc_community: $scope.specific_sp_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p.lcc_community,
	        lcc_community_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p.lcc_community_ik,
	        lcc_blgu: $scope.specific_sp_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p.lcc_blgu,
	        lcc_blgu_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p.lcc_blgu_ik,
	        lcc_mlgu: $scope.specific_sp_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p.lcc_mlgu,
	        lcc_mlgu_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p.lcc_mlgu_ik,
	        lcc_plgu: $scope.specific_sp_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p.lcc_plgu,
	        lcc_plgu_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p.lcc_plgu_ik,
	        lcc_others: $scope.specific_sp_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p.lcc_others,
	        lcc_others_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p.lcc_others_ik,
	        lcc_cash: $scope.specific_sp_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p.lcc_cash,
	        lcc_in_kind: $scope.specific_sp_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p.lcc_in_kind,
	      }
	      $scope.total_project_cost = $scope.get_total_project_cost($scope.paramObj); 
	    
	    }else if($scope.specific_sp_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p != null){
	      $scope.paramObj = {
	        grant: $scope.specific_sp_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p.grant,
	        contigency: $scope.specific_sp_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p.contigency,
	        other_amount: $scope.specific_sp_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p.other_amount,
	        lcc_community: $scope.specific_sp_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p.lcc_community,
	        lcc_community_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p.lcc_community_ik,
	        lcc_blgu: $scope.specific_sp_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p.lcc_blgu,
	        lcc_blgu_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p.lcc_blgu_ik,
	        lcc_mlgu: $scope.specific_sp_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p.lcc_mlgu,
	        lcc_mlgu_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p.lcc_mlgu_ik,
	        lcc_plgu: $scope.specific_sp_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p.lcc_plgu,
	        lcc_plgu_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p.lcc_plgu_ik,
	        lcc_others: $scope.specific_sp_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p.lcc_others,
	        lcc_others_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p.lcc_others_ik,
	        lcc_cash: $scope.specific_sp_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p.lcc_cash,
	        lcc_in_kind: $scope.specific_sp_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p.lcc_in_kind,
	      }
	      $scope.total_project_cost = $scope.get_total_project_cost($scope.paramObj); 
	    
	    }else if($scope.specific_sp_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p != null){
	      $scope.paramObj = {
	        grant: $scope.specific_sp_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p.grant,
	        contigency: $scope.specific_sp_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p.contigency,
	        other_amount: $scope.specific_sp_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p.other_amount,
	        lcc_community: $scope.specific_sp_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p.lcc_community,
	        lcc_community_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p.lcc_community_ik,
	        lcc_blgu: $scope.specific_sp_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p.lcc_blgu,
	        lcc_blgu_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p.lcc_blgu_ik,
	        lcc_mlgu: $scope.specific_sp_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p.lcc_mlgu,
	        lcc_mlgu_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p.lcc_mlgu_ik,
	        lcc_plgu: $scope.specific_sp_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p.lcc_plgu,
	        lcc_plgu_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p.lcc_plgu_ik,
	        lcc_others: $scope.specific_sp_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p.lcc_others,
	        lcc_others_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p.lcc_others_ik,
	        lcc_cash: $scope.specific_sp_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p.lcc_cash,
	        lcc_in_kind: $scope.specific_sp_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p.lcc_in_kind,
	      }
	      $scope.total_project_cost = $scope.get_total_project_cost($scope.paramObj); 

	    }else if($scope.specific_sp_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p != null){
	      $scope.paramObj = {
	        grant: $scope.specific_sp_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p.grant,
	        contigency: $scope.specific_sp_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p.contigency,
	        other_amount: $scope.specific_sp_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p.other_amount,
	        lcc_community: $scope.specific_sp_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p.lcc_community,
	        lcc_community_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p.lcc_community_ik,
	        lcc_blgu: $scope.specific_sp_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p.lcc_blgu,
	        lcc_blgu_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p.lcc_blgu_ik,
	        lcc_mlgu: $scope.specific_sp_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p.lcc_mlgu,
	        lcc_mlgu_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p.lcc_mlgu_ik,
	        lcc_plgu: $scope.specific_sp_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p.lcc_plgu,
	        lcc_plgu_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p.lcc_plgu_ik,
	        lcc_others: $scope.specific_sp_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p.lcc_others,
	        lcc_others_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p.lcc_others_ik,
	        lcc_cash: $scope.specific_sp_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p.lcc_cash,
	        lcc_in_kind: $scope.specific_sp_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p.lcc_in_kind,
	      }
	      $scope.total_project_cost = $scope.get_total_project_cost($scope.paramObj); 
	    
	    }else if($scope.specific_sp_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p != null){
	      $scope.paramObj = {
	        grant: $scope.specific_sp_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p.grant,
	        contigency: $scope.specific_sp_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p.contigency,
	        other_amount: $scope.specific_sp_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p.other_amount,
	        lcc_community: $scope.specific_sp_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p.lcc_community,
	        lcc_community_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p.lcc_community_ik,
	        lcc_blgu: $scope.specific_sp_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p.lcc_blgu,
	        lcc_blgu_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p.lcc_blgu_ik,
	        lcc_mlgu: $scope.specific_sp_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p.lcc_mlgu,
	        lcc_mlgu_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p.lcc_mlgu_ik,
	        lcc_plgu: $scope.specific_sp_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p.lcc_plgu,
	        lcc_plgu_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p.lcc_plgu_ik,
	        lcc_others: $scope.specific_sp_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p.lcc_others,
	        lcc_others_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p.lcc_others_ik,
	        lcc_cash: $scope.specific_sp_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p.lcc_cash,
	        lcc_in_kind: $scope.specific_sp_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p.lcc_in_kind,
	      }
	      $scope.total_project_cost = $scope.get_total_project_cost($scope.paramObj); 
	    
	    }else if($scope.specific_sp_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p != null){
	      $scope.paramObj = {
	        grant: $scope.specific_sp_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p.grant,
	        contigency: $scope.specific_sp_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p.contigency,
	        other_amount: $scope.specific_sp_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p.other_amount,
	        lcc_community: $scope.specific_sp_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p.lcc_community,
	        lcc_community_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p.lcc_community_ik,
	        lcc_blgu: $scope.specific_sp_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p.lcc_blgu,
	        lcc_blgu_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p.lcc_blgu_ik,
	        lcc_mlgu: $scope.specific_sp_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p.lcc_mlgu,
	        lcc_mlgu_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p.lcc_mlgu_ik,
	        lcc_plgu: $scope.specific_sp_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p.lcc_plgu,
	        lcc_plgu_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p.lcc_plgu_ik,
	        lcc_others: $scope.specific_sp_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p.lcc_others,
	        lcc_others_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p.lcc_others_ik,
	        lcc_cash: $scope.specific_sp_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p.lcc_cash,
	        lcc_in_kind: $scope.specific_sp_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p.lcc_in_kind,
	      }
	      $scope.total_project_cost = $scope.get_total_project_cost($scope.paramObj); 
	    
	    }else;

		console.log($scope.specific_sp_data.sp_actual_date_completed);
		// for(x = 0; x < $scope.specific_sp_data.data.length; x++){
          $scope.specific_sp_data.sp_rfr_first_tranche_date = $scope.parse_date($scope.specific_sp_data.sp_rfr_first_tranche_date);
          $scope.specific_sp_data.sp_date_started = $scope.parse_date($scope.specific_sp_data.sp_date_started);
          $scope.specific_sp_data.sp_date_of_turnover = $scope.parse_date($scope.specific_sp_data.sp_date_of_turnover);
          $scope.specific_sp_data.sp_target_date_of_completion = $scope.parse_date($scope.specific_sp_data.sp_target_date_of_completion);
          $scope.specific_sp_data.sp_actual_date_completed = $scope.parse_date($scope.specific_sp_data.sp_actual_date_completed);

          for(y = 0; y < $scope.specific_sp_data.sp_logs.length; y++){
            $scope.specific_sp_data.sp_logs[y].updated_at = $scope.parse_date($scope.specific_sp_data.sp_logs[y].updated_at);
          }
			}
		})
	    // BUB
	    
        // }
	}
});


</script>