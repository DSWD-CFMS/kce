<!-- MODALITY -->
<div class="border-bottom dashboard-header animated fadeInRight" ng-init="fetch_modality(3,2020);show_profile()">
    <div class="row wrapper animated fadeInRight ecommerce px-0 pb-0 ">

      <div class="col-lg-8">
        <h2> Modality </h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
              <a href="{{ url('/admin_rcis/routes') }}" >Home</a>
            </li>
            <li class="breadcrumb-item">
                <strong> Modality </strong>
            </li>
        </ol>
      </div>

      <div class="col-lg-4">
        <label><small class="font-weight-bold text-secondary"> MODALITY & YEAR </small></label>
        <div class="input-group">
          <div class="input-group-prepend">
            <select class="form-control" id="modality" ng-model="search_modality">
              <option value="1" ng-selected>KKB</option>
              <option value="2">MAKILAHOK</option>
              <option value="3">NCDDP</option>
              <option value="4">IP CDD</option>
              <option value="5">CCL</option>
              <option value="6">L&E</option>
            </select>
          </div>
            <select class="form-control" id="year" ng-model="search_year">
              <option value="2015" ng-selected> 2015 </option>
              <option value="2016"> 2016 </option>
              <option value="2017"> 2017 </option>
              <option value="2018"> 2018 </option>
              <option value="2019"> 2019 </option>
              <option value="2020"> 2020 </option>
              <option value="2021"> 2021 </option>
            </select>
          <div class="input-group-prepend">
            <button class="btn btn-outline-primary rounded-0" ng-click="fetch_modality(search_modality,search_year);clear_filter()"> <i class="fa fa-search"></i> </button>
          </div>
        </div>
      </div>

      <div class="col-lg-4 my-2">
      	<span ng-bind="sp_per_modality.current_page"></span>
      	<span ng-bind="sp_per_modality.last_page"></span>
        <label><small> Search Subproject <i class="fa fa-search"></i> </small></label>
        <input class="form-control nav-item nav-link" type="text" name="" placeholder="Search..." ng-model="search_data_modality_nys.$">
      </div>
    </div>

    <div class="wrapper wrapperr-content animated fadeInRight ecommerce px-0 pb-0">
        <div class="ibox-content m-b-sm border-bottom white-bg">
          <div class="row">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>DATE</th>
                  <th>DAC</th>
                  <th>SP ID</th>
                  <th>SP TITLE</th>
                  <th ng-if="modality_type_no == 4">CADT</th>
                  <th>MUNICIPALITY</th>
                  <th>BARANGAY</th>
                  <th >STATUS</th>
                  <th >REMARKS</th>
                  <th>ACTION</th>
                </tr>
              </thead>
              <tbody>
                <tr ng-repeat="all_data in bars = (sp_per_modality | filter: search_data_modality_nys.$) track by $index">
                  <td ng-bind="all_data.date_encoded | date:'medium'">DATE</td>
                  <td>
                    <span ng-repeat="x in all_data.sp.assigned_sp">
                      <p class="mb-0" ng-bind="x.users[0].Fname +' '+ x.users[0].Lname"></p>
                    </span>
                  </td>
                  <td>
                    <span ng-if="modality_type_no == 3" ng-bind="all_data.sp_id"></span>
                    <span ng-if="modality_type_no == 4" ng-bind="all_data.id"></span>
                  </td>
                  <td ng-bind="all_data.sp_title">SP TITLE</td>
                  <td ng-if="modality_type_no == 4">
                    <span ng-bind="all_data.cadt"></span>
                  </td>
                  <td ng-bind="all_data.brgy.cities.city_name | uppercase">MUNICIPALITY</td>
                  <td ng-bind="all_data.brgy.brgy_name | uppercase">BARANGAY</td>

                  <td>
                    <span ng-if="all_data.cancelled == 0">
                      <span ng-class="{'text-green': all_data.sp.sp_status == 'Completed', 'text-warning': all_data.sp.sp_status == 'On-going'}" ng-bind="all_data.sp.sp_status"></span>
                    </span>                    
                    <span ng-if="all_data.cancelled == 1">
                      <span class="text-danger">Cancelled</span> <br>
                      <span ng-bind="all_data.cancelled_date"></span>
                    </span>
                  </td>

                  <td>
                    <span ng-if="all_data.cancelled == 0">
                      <span> NONE</span>
                    </span>
                    <span ng-if="all_data.cancelled > 0">
                      <span ng-bind="all_data.cancelled_remarks"></span>
                    </span>
                  </td>

                  <td>

                    <div class="input-group">
                      <div class="input-group-prepend">
<!--                         <button ng-if="all_data.sp == null" class="btn btn-outline-success btn-sm rounded-0" data-backdrop="static" data-keyboard="false" data-target="#encode_new_sp" data-toggle="modal" ng-click="Assigned_SP(all_data)" data-toggle="tooltip" data-placement="top" title="Add SP Plan">
                        <i class="fa fa-bookmark"></i>
                        </button> -->
                        ------
                        all_data.sp
                        ------
                        <button ng-if="all_data.sp != null" class="btn btn-outline-primary btn-sm rounded-0" data-backdrop="static" data-keyboard="false" data-target="#assign_dac_sp" data-toggle="modal" ng-click="Assigned_SP(all_data)" data-toggle="tooltip" data-placement="top" title="Assigned a DAC">
                          <i class="fa fa-street-view"></i>
                         </button>
                      </div>
                        <button ng-if="all_data.sp.sp_logs.length == 0 && all_data.cancelled != 1" class="btn btn-outline-warning btn-sm rounded-0" data-backdrop="static" data-keyboard="false" data-target="#planned_modal" data-toggle="modal" ng-click="view_specific_sp_data(all_data)" data-toggle="tooltip" data-placement="top" title="Add SP Plan">
                        <i class="fa fa-pencil-square-o"></i>
                        </button>
                      <div class="input-group-prepend">
                        <button ng-if="all_data.sp.sp_logs.length > 0 && all_data.cancelled != 1" class="btn btn-outline-danger btn-sm rounded-0" ng-click="delete_sp_plan(all_data.sp.sp_id,all_data.sp.sp_groupings,all_data.sp.sp_implementation)" data-toggle="tooltip" data-placement="top" title="Delete SP Plan">
                        <i class="fa fa-trash"></i>
                        </button>
                      </div>
                        <button ng-if="all_data.sp.sp_logs.length > 0 && all_data.cancelled != 1" class="btn btn-outline-info btn-sm rounded-0" data-backdrop="static" data-keyboard="false" data-target="#plan_history" data-toggle="modal" ng-click="view_planned_sched(all_data)" data-toggle="tooltip" data-placement="top" title="View SP History">
                          <i class="fa fa-eye"></i>
                         </button>
                    </div>

                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
    </div>
</div>
<!-- MODALITY -->

@include('user_admin.add_sp_modal')