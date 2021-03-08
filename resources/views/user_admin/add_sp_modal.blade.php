<style type="text/css">
  select{
        border-radius: 0px !important;
        border-top: 0px !important;
        border-right: 0px !important;
        border-left: 0px !important;
        border-bottom: solid 3px #3490dc !important
        box-shadow: none !important;
        background-color: transparent;
  }

  /*fixed header*/
  tbody {
      display:block;
      height:700px;
      overflow:auto;
  }
  thead, tbody tr {
      display:table;
      width:100%;
      table-layout:fixed;
      font-size: .9em;
  }
  thead {
      width: calc( 100% - 1em )
  }
  /*fixed header*/

  tr:hover{
    cursor: pointer;
    border-left: 5px solid #007bff;
    background-color: rgba(0, 123, 255, .10);
    font-weight: bold;
  }

  .table td{
    border: 0px;
  }

  input[type="text"], 
  input[type="password"],
  input[type="email"]{
    border-radius: 0px !important;
    border-top: none;
    border-right: none;
    border-left: none;
    border-bottom: solid 2px #007bff;
    box-shadow: none !important;
    background-color: transparent;
  }

@media (min-width: 992px) {
  .modal-lg,
  .modal-xl {
    max-width: 800px;
  }
}

@media (min-width: 1200px) {
  .modal-xl {
    max-width: 1140px;
  }
}

body.modal-open {
  padding-right: 0 !important;
}

.modal{
  padding-right: 0px !important;
}

.modal-full {
    min-width: 100%;
    margin: 0;
}

.modal-full .modal-content {
    min-height: 100vh !important;
}

</style>

<!-- ENCODE NEW SP -->
<div class="modal fade" id="encode_new_sp" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md rounded-0" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="font-weight-bold">
          <span ng-if="cmfs_sp_data.whatmodality == 1">
           SP ID: <b class="text-success" ng-bind="cmfs_sp_data.id"></b> | KKB
          </span>

          <span ng-if="cmfs_sp_data.whatmodality == 2">
           SP ID: <b class="text-success" ng-bind="cmfs_sp_data.id"></b> | MAKILAHOK
          </span>

          <span ng-if="cmfs_sp_data.whatmodality == 3">
           SP ID: <b class="text-success" ng-bind="cmfs_sp_data.sp_id"></b> | NCDDP
          </span>

          <span ng-if="cmfs_sp_data.whatmodality == 4">
            SP ID: <b class="text-success" ng-bind="cmfs_sp_data.id"></b> | IP CDD
          </span>

          <span ng-if="cmfs_sp_data.whatmodality == 5">
            SP ID: <b class="text-success" ng-bind="cmfs_sp_data.id"></b> | CCL
          </span>

          <span ng-if="cmfs_sp_data.whatmodality == 6">
            SP ID: <b class="text-success" ng-bind="cmfs_sp_data.id"></b> | L&E
          </span>
        </h3>
      </div>
      <div class="modal-body">
        <form name="myForm">
      	<div class="row">

        <div class="col-lg-6" ng-if="cmfs_sp_data.whatmodality == 4">
          <div class="form-group">
            <label><small class="font-weight-bold text-secondary"> Cycle </small></label>
            <select class="custom-select" ng-model="sp_cyle" name="sp_cyle" required>
            <option value="1" selected>1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
            </select>
          </div>
        </div>

        <div class="col-lg-6" ng-if="cmfs_sp_data.whatmodality == 4">
          <div class="form-group">
            <label><small class="font-weight-bold text-secondary"> Batch </small></label>
            <select class="custom-select" ng-model="sp_batch" name="sp_batch" required>
            <option value="1" selected>1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
            </select>
          </div>
        </div>

          <div class="col-lg-12">
            <div class="form-group">
              <label class="mt-2 mb-0"><small class="font-weight-bold">SP Title</small></label>
              <input type="text" class="form-control" ng-model="cmfs_sp_data.sp_title" placeholder="Enter SP Title..." readOnly>
            </div>
          </div>

      		<div class="col-lg-12">
            <div class="form-group">
              <label><small class="font-weight-bold text-secondary"> Province </small></label>
              <input type="text" class="form-control" ng-model="cmfs_sp_data.brgy.cities.provinces.prov_name" placeholder="Enter SP Title..." readOnly>
            </div>
            
            <div class="form-group">
              <label><small class="font-weight-bold text-secondary"> Municipality </small></label>
              <input type="text" class="form-control" ng-model="cmfs_sp_data.brgy.cities.city_name" placeholder="Enter SP Title..." readOnly>
            </div>
            
            <div class="form-group">
              <label><small class="font-weight-bold text-secondary"> Brgy </small></label>
              <input type="text" class="form-control" ng-model="cmfs_sp_data.brgy.brgy_name" placeholder="Enter SP Title..." readOnly>
            </div>
        		</div>

        		<div class="col-lg-6">
              <div class="form-group">
                <label><small class="font-weight-bold text-secondary">SP Category </small></label>
                <select class="custom-select" ng-model="sp_cat_data"  name="sp_cat_data" ng-options="sp_Cat.id as sp_Cat.category for sp_Cat in sp_category" readOnly></select>
              </div>

              <div class="form-group">
                <label><small class="font-weight-bold text-secondary">SP Type </small></label>
                <select class="custom-select" ng-model="sp_typ_data" name="sp_typ_data" ng-options="sp_Typ.id as sp_Typ.type for sp_Typ in sp_type" readOnly></select>
              </div>
      		  </div>

          <div class="col-lg-6" ng-show="cmfs_sp_data.whatmodality == 4">
            <div class="form-group">
              <label class="mt-2 mb-0"><small class="font-weight-bold">CADT</small></label>
              <input class="form-control" type="text" ng-model="cmfs_sp_data.cadt" readOnly>
            </div>
          </div>

          <div class="col-lg-6">
            <div class="form-group">
              <label><small class="font-weight-bold">Assigned DAC</small></label>
              <select class="custom-select" ng-model="assigned_dac" name="assigned_dac" ng-options="dac_acct.id as dac_acct.Fname + ' ' + dac_acct.Lname for dac_acct in dac" required></select>
            </div>

            <div class="form-group">
              <label><small class="font-weight-bold">Assigned RPMO</small></label>
              <select class="custom-select" ng-model="assigned_rpmo" name="assigned_rpmo" ng-options="rpmo_acct.id as rpmo_acct.Fname + ' ' + rpmo_acct.Lname for rpmo_acct in rpmo" required></select>
            </div>
          </div>
      	</div>
        </form>
      </div>
      <div class="modal-footer">
        <span ng-if="myForm.$valid == false"> <small>Please fill all the fields...</small> </span>
        <button ng-disabled="myForm.$valid == false" type="button" class="btn btn-success" style="border-radius: 100px;" ng-click="encode_SP(cmfs_sp_data)"> <i class="fa fa-paper-plane"></i> Submit</button>
        <button type="button" class="btn btn-secondary" style="border-radius: 100px;" data-dismiss="modal"> <i class="fa fa-times"></i> Close</button>
      </div>
    </div>
  </div>
</div>

<!-- FETCH SP NEW DATA FROM CMFS -->
<div class="modal fade" id="fetch_cmfs_sp" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
  <div class="modal-dialog modal-xl rounded-0" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="font-weight-light">
          <span ng-if="modality_type_no == 1">KKB</span>
          <span ng-if="modality_type_no == 2">MAKILAHOK</span>
          <span ng-if="modality_type_no == 3">NCDDP</span>
          <span ng-if="modality_type_no == 4">IP CDD</span>
          <span ng-if="modality_type_no == 5">CCL</span>
          <span ng-if="modality_type_no == 6">L&E</span>
        </h3>
      </div>

      <div class="modal-body">
        <div class="row" ng-repeat="data in cmfs_sp track by $index">
          <div class="col-sm-2">
            <label class="text-warning"> <small style="font-weight: bold;">SP ID</small> </label><br>
            <span ng-bind="data.id"></span>
          </div>

          <div class="col-sm-4">
            <label class="text-warning"> <small style="font-weight: bold;">SP TITLE</small> </label><br>
            <span ng-bind="data.sp_title"></span>
          </div>

          <div class="col-sm-2">
            <label class="text-warning"> <small style="font-weight: bold;">BRGY</small> </label><br>
            <span ng-bind="data.c_m_f_s_brgy.brgy_name"></span>
          </div>
          <div class="col-sm-2">
            <label class="text-warning"> <small style="font-weight: bold;">MUNICIPALITY</small> </label><br>
            <span ng-bind="data.c_m_f_s_brgy.c_m_f_s_muni.city_name"></span>
          </div>
          <div class="col-sm-2">
            <label class="text-warning"> <small style="font-weight: bold;">PROVINCE</small> </label><br>
            <span ng-bind="data.c_m_f_s_brgy.c_m_f_s_muni.c_m_f_s_prov.prov_name"></span>
          </div>

          <div class="col-sm-12 mb-2">
          </div>

          <div class="col-sm-2" >
            <label class="text-warning"> <small style="font-weight: bold;">TOTAL PROJECT COST</small> </label><br>
            <span ng-bind="(data.grant + data.lcc_cash + data.lcc_in_kind) | currency:'₱ '"></span>
          </div>
          <div class="col-sm-2">
            <label class="text-warning"> <small style="font-weight: bold;">ASSIGNED DAC</small> </label><br>
            <select class="custom-select" ng-model="assigned_dac" name="assigned_dac" ng-options="dac_acct.id as dac_acct.Fname + ' ' + dac_acct.Lname for dac_acct in dac" required></select>
          </div>

          <div class="col-sm-2">
            <label class="text-warning"> <small style="font-weight: bold;">ASSIGNED RPMO</small> </label><br>
            <select class="custom-select" ng-model="assigned_rpmo" name="assigned_rpmo" ng-options="rpmo_acct.id as rpmo_acct.Fname + ' ' + rpmo_acct.Lname for rpmo_acct in rpmo" required></select>
          </div>

          <div class="col-sm-2">
            <label class="text-warning"> <small style="font-weight: bold;">SP Category</small> </label><br>
            <select class="custom-select" ng-model="sp_cat_data"  name="sp_cat_data" ng-options="sp_Cat.id as sp_Cat.category for sp_Cat in sp_category" required></select>
          </div>

          <div class="col-sm-2">
            <label class="text-warning"> <small style="font-weight: bold;">SP Type</small> </label><br>
            <select class="custom-select" ng-model="sp_typ_data" name="sp_typ_data" ng-options="sp_Typ.id as sp_Typ.type for sp_Typ in sp_type" required></select>
          </div>

          <div class="col-sm-2">
            <label class="text-warning"> <small style="font-weight: bold;">CADT</small> </label><br>
            <span ng-bind="data.cadt"></span>
          </div>

          <div class="col-sm-4 my-2">
            <button type="button" class="btn btn-success" style="border-radius: 100px;" ng-click="encode_SP_CMFS(data.id,data.sp_title,data.c_m_f_s_brgy.brgy_name,data.c_m_f_s_brgy.c_m_f_s_muni.city_name,data.c_m_f_s_brgy.c_m_f_s_muni.c_m_f_s_prov.prov_name,data.grant,data.lcc_cash,data.lcc_in_kind,assigned_dac,assigned_rpmo,sp_cat_data,sp_typ_data,data.cadt,modality_type_no)"> <i class="fa fa-paper-plane"></i> Submit</button>
          </div>

          <div class="col-sm-12">
            <hr>
          </div>
        </div>
      </div>

      <div class="modal-footer">
        <!-- <button type="button" class="btn btn-success" style="border-radius: 100px;" ng-click="encode_SP_CMFS(myForm,modality_type_no)"> <i class="fa fa-paper-plane"></i> Submit</button> -->
        <button type="button" class="btn btn-secondary" style="border-radius: 100px;" data-dismiss="modal"> <i class="fa fa-times"></i> Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="add_modality" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content rounded-0">
      <div class="modal-header text-center">
        <h2 class="my-0 text-center"> Choose Modality </h2>
      </div>
      <div class="modal-body pb-0" style="padding: 16px !important;">
        <!-- File Type -->
        <div class="form-group shadow1">
          <label><small class="col-form-label"> <small class="font-weight-bold"> Modality </small> </small></label>
          <select class="form-control" id="modality" ng-model="modality">
            <option value="1" selected>KKB</option>
            <option value="2">MAKILAHOK</option>
            <option value="3">NCDDP</option>
            <option value="4">IP CDD</option>
            <option value="5">CCL</option>
            <option value="6">L&E</option>
          </select>
        </div>
      </div>

      <div class="modal-footer justify-content-between">
        <button class="btn btn-primary mr-auto" style="border-radius: 0px;" ng-disabled="modality == null || modality == ''" ng-click="assign_add_modality(modality,specific_user_data.id)"> <i class="fa fa-upload"></i> Add</button>
        <button type="button" style="border-radius: 0px;" class="btn btn-secondary" data-dismiss="modal"> <i class="fa fa-times-circle"></i>  Close</button>
      </div>
    </div>
    </div>
  </div>
</div>


<!-- ENCODE NEW SP -->
<div class="modal fade" id="assign_dac_sp" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md rounded-0" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="font-weight-bold">
          <span ng-if="cmfs_sp_data.whatmodality == 1">
           SP ID: <b class="text-success" ng-bind="cmfs_sp_data.id"></b> | KKB
          </span>

          <span ng-if="cmfs_sp_data.whatmodality == 2">
           SP ID: <b class="text-success" ng-bind="cmfs_sp_data.id"></b> | MAKILAHOK
          </span>

          <span ng-if="cmfs_sp_data.whatmodality == 3">
           SP ID: <b class="text-success" ng-bind="cmfs_sp_data.sp_id"></b> | NCDDP
          </span>

          <span ng-if="cmfs_sp_data.whatmodality == 4">
            SP ID: <b class="text-success" ng-bind="cmfs_sp_data.id"></b> | IP CDD
          </span>

          <span ng-if="cmfs_sp_data.whatmodality == 5">
            SP ID: <b class="text-success" ng-bind="cmfs_sp_data.id"></b> | CCL
          </span>

          <span ng-if="cmfs_sp_data.whatmodality == 6">
            SP ID: <b class="text-success" ng-bind="cmfs_sp_data.id"></b> | L&E
          </span>
        </h3>
      </div>
      <div class="modal-body">
        <form name="myForm">
        <div class="row">

          <div class="col-lg-12">
            <div class="form-group">
              <label class="mt-2 mb-0"><small class="font-weight-bold">SP Title</small></label>
              <input type="text" class="form-control" ng-model="cmfs_sp_data.sp_title" placeholder="Enter SP Title..." readOnly>
            </div>
          </div>

          <div class="col-lg-12">
            <div class="form-group">
              <label><small class="font-weight-bold text-secondary"> Province </small></label>
              <input type="text" class="form-control" ng-model="cmfs_sp_data.brgy.cities.provinces.prov_name" placeholder="Enter SP Title..." readOnly>
            </div>
            
            <div class="form-group">
              <label><small class="font-weight-bold text-secondary"> Municipality </small></label>
              <input type="text" class="form-control" ng-model="cmfs_sp_data.brgy.cities.city_name" placeholder="Enter SP Title..." readOnly>
            </div>
            
            <div class="form-group">
              <label><small class="font-weight-bold text-secondary"> Brgy </small></label>
              <input type="text" class="form-control" ng-model="cmfs_sp_data.brgy.brgy_name" placeholder="Enter SP Title..." readOnly>
            </div>
            </div>

          <div class="col-lg-12">
            <div class="form-group">
              <label><small class="font-weight-bold">Assigned DAC</small></label>
              <select class="custom-select" ng-model="assigned_dac" name="assigned_dac" ng-options="dac_acct.id as dac_acct.Fname + ' ' + dac_acct.Lname for dac_acct in dac" required></select>
            </div>
          </div>
        </div>
        </form>
      </div>
      <div class="modal-footer">
        <span ng-if="myForm.$valid == false"> <small>Please fill all the fields...</small> </span>
        <button ng-disabled="myForm.$valid == false" type="button" class="btn btn-success" style="border-radius: 100px;" ng-click="assign_SP(cmfs_sp_data)"> <i class="fa fa-paper-plane"></i> Submit</button>
        <button type="button" class="btn btn-secondary" style="border-radius: 100px;" data-dismiss="modal"> <i class="fa fa-times"></i> Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Planned -->
<div class="modal fade" id="planned_modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Planned Schedule for SP ID: <span ng-bind="specific_sp_data.sp.sp_id"></span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        @verbatim
    <div class="row" ng-repeat="p_data in planned_data track by $index">
      <div class="col">
        <small>Planned Percentage (Week <span ng-bind="$index + 1"></span>)</small> <br>
        <input id="percentage" type="text" class="form-control" ng-model="p_data.percentage">
      </div>
      <div class="col">
        <small>Target Date</small> <br>
        <input id="target_date" type="date" class="form-control" ng-model="p_data.target_date">
      </div>
    </div>
    <hr>
    <div class="row">
      <div class="col">
        <button type="button" class="btn btn-success btn-block" ng-click="add_planned()"> Add </button>
      </div>
      <div class="col">
        <button type="button" class="btn btn-secondary btn-block" ng-click="remove_planned()"> Remove </button>
      </div>
    </div>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-primary mr-auto" data-dismiss="modal" data-toggle="collapse" data-target="#collapseExample{{collapse_id}}" ng-click="create_planned_logs(planned_data,specific_sp_data.sp.sp_id,specific_sp_data.sp.sp_groupings,specific_sp_data.sp.sp_implementation)">Save changes</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        @endverbatim
      </div>
    </div>
  </div>
</div>


<!-- Plan history -->
<div class="modal fade" id="plan_history" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-full" role="document">
    <div class="modal-content">
      <div class="modal-header border-0">
        <h3 class="modal-title"><span ng-bind="(specific_sp_data.sp.sp_title) +' - '+ (specific_sp_data.sp.sp_brgy) +', '+ (specific_sp_data.sp.sp_municipality)"></span></h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body py-0">
        <canvas id="myChart" style="width: 100%; height: 200px !important;"></canvas>
        <div class="table-responsive" style="height: 35px;">
          <table class="table" style="margin-bottom: 0px !important;overflow: none !important;">
              <thead class="thead-dark">
                <tr style="font-size: 10px;">
                  <th scope="col" style="">DATE</th>
                  <th scope="col" style="">STATS</th>
                  <th scope="col">ISSUES/PROBLEM</th>
                  <th scope="col">ANALYSIS</th>
                  <th scope="col">REMARKS</th>
                </tr>
              </thead>
              <tbody style="overflow: none !important;">
              </tbody>
          </table>
        </div>

        <div class="table-responsive">
          <table class="table" style="margin-bottom: 0px !important;overflow: none !important;">
              <tbody style="overflow: auto !important;">
                <tr ng-repeat="p_data in planned_sched track by $index">
                  <td>
                    <small class="text-dark font-weight-bold">Target Date</small> <br>
                    <small style="font-weight: bold;" class="text-primary" id="target_date" ng-bind="p_data.sp_logs_planned_target_date | date: 'yyyy/MM/dd'"></small>
                  </td>
                  <td>
                    <small>
                      <span> PLANNED: </span> <b style="color: #fd7e14;" ng-bind="p_data.sp_logs_planned + '%'"></b> <br>
                      <span> ACTUAL: </span> <b ng-if="p_data.sp_logs_actual != null" style="color: #007bff;" ng-bind="p_data.sp_logs_actual + '%'"></b> <br>
                      <span> SLIPPAGE: </span> <b ng-if="p_data.sp_logs_slippage != null" style="color: #dc3545;" ng-bind="p_data.sp_logs_slippage"></b>
                    </small>
                  </td>
                  <td>
                    <small style="font-weight: bold;" ng-if="p_data.sp_logs_issues != '0' && p_data.sp_logs_issues != 0" class="text-success" ng-bind="p_data.sp_logs_issues"></small>
                    <small style="font-weight: bold;" ng-if="p_data.sp_logs_issues == '0' || p_data.sp_logs_issues == 0" class="text-yellow pulsate">NOT APPLICABLE</small>
                  </td>
                  <td>
                    <small style="font-weight: bold;" class="text-success" ng-if="p_data.sp_logs_analysis != '0' && p_data.sp_logs_analysis != 0" ng-bind="p_data.sp_logs_analysis"></small>
                    <small style="font-weight: bold;" class="text-yellow pulsate" ng-if="p_data.sp_logs_analysis == '0' || p_data.sp_logs_analysis == 0">NOT APPLICABLE</small>
                  </td>
                  <td>
                    <small style="font-weight: bold;" ng-if="p_data.sp_logs_remarks != '0' && p_data.sp_logs_remarks != 0" class="text-success" ng-bind="p_data.sp_logs_remarks"></small>
                    <small style="font-weight: bold;" ng-if="p_data.sp_logs_remarks == '0' || p_data.sp_logs_remarks == 0" class="text-yellow pulsate">NOT APPLICABLE</small>
                  </td>
                </tr>
              </tbody>
          </table>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close <i class="fa fa-times-circle"></i></button>
      </div>
    </div>
  </div>
</div>