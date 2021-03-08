@extends('layouts.admin_rcis_dashboard')

@section('content')
<style type="text/css">
  .card, .card .card-footer{
    border-radius: 0px;
  }

  .orange{
    color: #fdab14;
  }

  .pulsate {
      -webkit-animation: pulsate 3s ease-out;
      -webkit-animation-iteration-count: infinite; 
      opacity: 0.5;
  }
  @-webkit-keyframes pulsate {
      0% { 
          opacity: 0.5;
        color: #676a6c;
      }
      50% { 
          opacity: 1.0;
        color: #f8ac59;
      }
      100% { 
          opacity: 0.5;
        color: #f48c19;
      }
  }

  .table-bordered1 tr {
    border-top: .1px solid #000 !important;
  }

  .table-bordered1 tr {
    display:flex;
    flex-wrap:wrap; /* allow to wrap on multiple rows */
  }
  .table-bordered1 td, .table-bordered1 th {
    display:block;
    flex:1 /* to evenly distributs flex elements */
  }  
</style>

<!-- MODALITY -->
<div id="page-wrapper" class="gray-bg dashbard-1" ng-init="show_modality();show_profile()">
  <div class="row border-bottom">
    <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
      <div class="navbar-header">
          <a class="navbar-minimalize minimalize-styl-2 py-0 text-secondary" style="text-transform: none !important; text-decoration: none !important; border-radius: 100px;" href="" ng-click="mini_navbar = !mini_navbar">
            
            <i ng-class="{'fa fa-chevron-circle-right fa-2x': mini_navbar == true, 'fa fa-chevron-circle-left fa-2x': mini_navbar == false}"></i>
          </a>
          <h4 class="minimalize-styl-2 mx-0 px-0 pb-0 mb-0" href="#">
            KCE WebApp v2.0
          </h4>
      </div>
      <ul class="nav navbar-top-links navbar-right">
          <li>
              <a href="#exampleModal" data-toggle="modal">
                  <i class="fa fa-sign-out"></i> Sign out
              </a>
          </li>
      </ul>
      @include('user_admin_rcis.logout_modal')
    </nav>
  </div>

    <div class="row wrapper border-bottom white-bg page-heading justify-content-end animated fadeInRight">
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

      <div class="col-lg-4" style="margin-top: 40px;">
        <div class="input-group">
          <div class="input-group-prepend">
            <button class="btn btn-outline-secondary rounded-0" ng-click="show_modality();clear_filter()"> <i class="fa fa-eraser"></i> </button>
          </div>
            <button class="btn btn-primary rounded-0" data-backdrop="static" data-keyboard="false" data-target="#filterModal" data-toggle="modal"> <i class="fa fa-filter"></i> </button>
            <input class="form-control nav-item nav-link" style="border: 1px solid;" type="text" name="" placeholder="Search..." ng-model="search_data_modality" ng-change="search_sp(search_data_modality)">
          <div class="input-group-prepend">
            <button class="btn btn-primary rounded-0" ng-if="search_modal == false" ng-click="Export_All_Data()"> Export <i class="fa fa-external-link"></i> </button>
            <button class="btn btn-primary rounded-0" ng-if="search_modal == true" ng-click="Export_Modal_Data()"> Export <i class="fa fa-external-link"></i> </button>
          </div>
        </div>
      </div>
    </div>

    <div class="row wrapper animated fadeInRight ecommerce px-0 pb-0 ">
      <div class="col-lg-12 my-2">
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
    </div>

    <div class="wrapper wrapperr-content animated fadeInRight ecommerce px-0 pb-0">
      <div class="table-responsive" style="height: 30px;">
        <table class="table table-bordered1" style="font-size: 9px;"> 
          <thead class="thead-dark">
            <tr>
              <th scope="col">MODALITY</th>
              <th scope="col">SP TITLE</th>
              <th scope="col">PROVINCE</th>
              <th scope="col">MUNICIPALITY</th>
              <th scope="col">BARANGAY</th>
              <th scope="col">IMPLEMENTATION</th>
              <th scope="col">STATUS</th>
              <th scope="col">ACTION</th>
            </tr>
          </thead>
        </table>
      </div>
      <div class="table-responsive" style="height: 400px;">
        <table class="table table-bordered1" style="font-size: 9px;"> 
          <tbody style="overflow-y: auto !important;">
            <tr ng-repeat="all_data in bars = (sp_per_modality_data_all_sp_logs.data) track by $index" >
              <td ng-bind="all_data.sp_groupings.grouping"></td>
              <td ng-bind="all_data.sp_title"></td>
              <td ng-bind="all_data.sp_province | uppercase"></td>
              <td ng-bind="all_data.sp_municipality | uppercase"></td>
              <td ng-bind="all_data.sp_brgy | uppercase"></td>
              <td ng-bind="all_data.sp_implementation"></td>
              <td ng-bind="all_data.sp_status | uppercase"></td>
              <td>
                <button data-backdrop="static" data-keyboard="false" data-target="#SpecificSP_Modal" data-toggle="modal" class="btn btn-outline-primary rounded-0 btn-block" ng-click="render_specific_sp(all_data)"> View <i class="fa fa-eye"></i>
                </button>
              </td>
            </tr>
          </tbody>
        </table>

        <h3 class="text-center text-danger" ng-if="sp_per_modality_data_all_sp_logs.data.length == 0">There was no data found!</h3>
      </div>
    </div>
    
    <!-- For Exporting -->
    <div class="wrapper wrapper-content" ng-if="search_modal == false" hidden="true">
      <div class="ibox-content m-b-sm border-bottom white-bg">
          <div class="table-responsive">
                <table class="table" id="MyInquires">
                <thead>
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
                    <th>ESTIMATED DURATION</th>
                    <th>TARGET COMPLETION DATE</th>
                    <th>ACTUAL COMPLETION DATE</th>
                    <th>PHYSICAL TARGET</th>
                    <th>BUILDING PERMIT</th>
                    <th>VARIATION ORDER</th>
                    <th>SPCR</th>
                    <th>ESMR</th>
                    <th>CSR</th>
                    <th>MATERIALS TESTING</th>
                    <th>ISSUES</th>
                    <th>ANALYSIS</th>
                    <th>REMARKS</th>
                    <th>SP IMPLEMENTATION (YEAR)</th>
                  </tr>
                </thead>  
                <tbody>
                  <tr ng-repeat="all_data in sp_per_modality_data_all_sp_logs_for_export track by $index" ng-click="render_specific_sp(all_data)">
                    <td>
                      <div ng-repeat="logs_planned in all_data.sp_logs track by $index">
                        <span ng-if="$last" ng-bind="logs_planned.updated_at | date:'fullDate'" ></span>
                      <d/div>
                    </t>
                    <td>
                        <div ng-repeat="dac in all_data.assigned_sp track by $index">
                            <span ng-bind="dac.users[0].Fname +' '+ dac.users[0].Lname"></span>
                        </div>
                    </td>
                    <td>
                        <div ng-repeat="rpmo in all_data.assigned_grouping track by $index">
                            <p ng-bind="rpmo.users.Fname +' '+ rpmo.users.Lname"></p>
                        </div>
                    </td>
                    <td ng-bind="all_data.sp_status"></td>
                    <td ng-bind="all_data.sp_id"></td>
                    <td ng-bind="all_data.sp_title"></td>

                    <td ng-bind="all_data.sp_province"></td>
                    <td ng-bind="all_data.sp_municipality"></td>
                    <td ng-bind="all_data.sp_brgy"></td>
                    
                    <td>
                    <div ng-repeat="logs_planned in all_data.sp_logs track by $index">
                      <span ng-if="$last" ng-bind="logs_planned.sp_logs_planned" ></span>
                      </div>
                    </td>
                    <td>
                    <div ng-repeat="logs_planned in all_data.sp_logs track by $index">
                      <span ng-if="$last" ng-bind="logs_planned.sp_logs_actual" ></span>
                      </div>
                    </td>
                    <td>
                    <div ng-repeat="logs_planned in all_data.sp_logs track by $index">
                      <span ng-if="$last" ng-bind="logs_planned.sp_logs_slippage" ></span>
                      </div>
                    </td>
                    <td ng-bind="all_data.sp_groupings.grouping"></td>
                    <td ng-bind="all_data.sp_cycle.cycle"></td>
                    <td ng-bind="all_data.sp_batch.batch">BATCH</td>
                    <td ng-bind="all_data.sp_category.category">CATEGORY</td>
                    <td ng-bind="all_data.sp_type.type">TYPE</td>
                    <td ng-bind="all_data.sp_project_cost | currency: '₱'">PROJECT COST</td>
                    <td >
                      <span ng-if="all_data.sp_rfr_first_tranche_date == null || all_data.sp_rfr_first_tranche_date == ''">
                        NO DATA
                      </span>
                      <span ng-if="all_data.sp_rfr_first_tranche_date != null" ng-bind="all_data.sp_rfr_first_tranche_date | date: 'fullDate'"></span>
                    </td>
                    <td ng-bind="all_data.sp_date_started | date: 'fullDate'">DATE STARTED</td>
                    <td ng-bind="all_data.sp_estimated_duration">ESTIMATED DURATION</td>
                    <td ng-bind="all_data.sp_target_date_of_completion | date: 'fullDate'">TARGET COMPLETION DATE</td>
                    <td ng-bind="all_data.sp_actual_date_completed | date: 'fullDate'">
                    </td>
                    <td ng-bind="all_data.sp_physical_target">PHYSICAL TARGET</td>
                    <td>
                      <span ng-if="all_data.sp_building_permit == 0">NONE</span>
                      <span ng-if="all_data.sp_building_permit == 1">HAS BUILDING PERMIT</span>
                    </td>
                    <td>
                    <div ng-repeat="logs_planned in all_data.sp_logs track by $index">
                      <span ng-if="$last">
                        <span ng-if="logs_planned.sp_logs_variation_order == 0 || logs_planned.sp_logs_variation_order == null || logs_planned.sp_logs_variation_order == ''">NONE</span>
                          <span ng-if="logs_planned.sp_logs_variation_order == 1">HAS VARIATION ORDER</span>
                      </span>
                      </div>
                    </td>
                    <td>
                    <div ng-repeat="logs_planned in all_data.sp_logs track by $index">
                      <span ng-if="$last">
                        <span ng-if="logs_planned.sp_logs_spcr == 0 || logs_planned.sp_logs_spcr == null || logs_planned.sp_logs_spcr == '' || logs_planned.sp_logs_spcr == undefined">NONE</span>
                          <span ng-if="logs_planned.sp_logs_spcr == 1">HAS SPCR</span>
                      </span>
                      </div>
                    </td>
                    <td>
                    <div ng-repeat="logs_planned in all_data.sp_logs track by $index">
                      <span ng-if="$last">
                        <span ng-if="logs_planned.sp_logs_esmr == 0 || logs_planned.sp_logs_esmr == null || logs_planned.sp_logs_esmr == '' || logs_planned.sp_logs_esmr == undefined">NONE</span>
                          <span ng-if="logs_planned.sp_logs_esmr == 1">HAS ESMR</span>
                      </span>
                      </div>
                    </td>
                    <td>
                    <div ng-repeat="logs_planned in all_data.sp_logs track by $index">
                      <span ng-if="$last">
                        <span ng-if="logs_planned.sp_logs_csr == 0 || logs_planned.sp_logs_csr == null || logs_planned.sp_logs_csr == '' || logs_planned.sp_logs_csr == undefined">NONE</span>
                          <span ng-if="logs_planned.sp_logs_csr == 1">HAS CSR</span>
                      </span>
                      </div>
                    </td>
                    <td>
                    <div ng-repeat="logs_planned in all_data.sp_logs track by $index">
                      <span ng-if="$last">
                        <span ng-if="logs_planned.sp_logs_mt == 0 || logs_planned.sp_logs_mt == null || logs_planned.sp_logs_mt == '' || logs_planned.sp_logs_mt == undefined">NONE</span>
                          <span ng-if="logs_planned.sp_logs_mt == 1">HAS CSR</span>
                      </span>
                      </div>
                    </td>
                    <td>
                    <div ng-repeat="logs_planned in all_data.sp_logs track by $index">
                      <span ng-if="$last">
                          <span ng-if="logs_planned.sp_logs_issues == 0 || logs_planned.sp_logs_issues == null || logs_planned.sp_logs_issues == '' || logs_planned.sp_logs_issues == 'undefined'">NONE</span>
                        <span ng-bind="logs_planned.sp_logs_issues" ng-if="logs_planned.sp_logs_issues != 0 && logs_planned.sp_logs_issues != null && logs_planned.sp_logs_issues != '' && logs_planned.sp_logs_issues != undefined && logs_planned.sp_logs_issues != 'undefined'"></span>
                      </span>
                      </div>
                    </td>
                    <td>
                    <div ng-repeat="logs_planned in all_data.sp_logs track by $index">
                      <span ng-if="$last">
                        <span ng-if="logs_planned.sp_logs_analysis == 0 || logs_planned.sp_logs_analysis == null || logs_planned.sp_logs_analysis == '' || logs_planned.sp_logs_analysis == 'undefined' || logs_planned.sp_logs_analysis == undefined">NONE</span>
                        <span ng-bind="logs_planned.sp_logs_analysis" ng-if="logs_planned.sp_logs_analysis != null && logs_planned.sp_logs_analysis != '' && logs_planned.sp_logs_analysis != 'undefined' && logs_planned.sp_logs_analysis == undefined"></span>
                      </span>
                      </div>
                    </td>
                    <td>
                    <div ng-repeat="logs_planned in all_data.sp_logs track by $index">
                      <span ng-if="$last">
                        <span ng-if="logs_planned.sp_logs_remarks == 0 || logs_planned.sp_logs_remarks == null || logs_planned.sp_logs_remarks == '' || logs_planned.sp_logs_remarks == 'undefined' || logs_planned.sp_logs_remarks == undefined">NONE</span>
                        <span ng-bind="logs_planned.sp_logs_remarks" ng-if="logs_planned.sp_logs_remarks != 0 && logs_planned.sp_logs_remarks != null && logs_planned.sp_logs_remarks != '' && logs_planned.sp_logs_remarks != 'undefined' && logs_planned.sp_logs_remarks == undefined"></span>
                      </span>
                      </div>
                    </td>
                    <td>
                      <span ng-bind="all_data.sp_implementation"></span>
                    </td>
                  </tr>
                </tbody>
              </table>
          </div>  
      </div>
    </div>

    <!-- For Exporting from MODAL DATa -->
    <div class="wrapper wrapper-content" ng-if="search_modal == true" hidden="true">
      <div class="ibox-content m-b-sm border-bottom white-bg">
          <div class="table-responsive">
                <table class="table" id="MyInquires">
                <thead>
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
                    <th>ESTIMATED DURATION</th>
                    <th>TARGET COMPLETION DATE</th>
                    <th>ACTUAL COMPLETION DATE</th>
                    <th>PHYSICAL TARGET</th>
                    <th>BUILDING PERMIT</th>
                    <th>VARIATION ORDER</th>
                    <th>SPCR</th>
                    <th>ESMR</th>
                    <th>CSR</th>
                    <th>MATERIALS TESTING</th>
                    <th>ISSUES</th>
                    <th>ANALYSIS</th>
                    <th>REMARKS</th>
                    <th>SP IMPLEMENTATION (YEAR)</th>
                  </tr>
                </thead>  
                <tbody>
                  <tr ng-repeat="all_data in search_modal_sp_for_export track by $index" ng-click="render_specific_sp(all_data)">
                    <td>
                      <div ng-repeat="logs_planned in all_data.sp_logs track by $index">
                        <span ng-if="$last" ng-bind="logs_planned.updated_at | date:'fullDate'" ></span>
                      </div>
                    </td>
                    <td>
                        <div ng-repeat="dac in all_data.assigned_sp track by $index">
                            <span ng-bind="dac.users[0].Fname +' '+ dac.users[0].Lname"></span>
                        </div>
                    </td>
                    <td>
                        <div ng-repeat="rpmo in all_data.assigned_grouping track by $index">
                            <p ng-bind="rpmo.users.Fname +' '+ rpmo.users.Lname"></p>
                        </div>
                    </td>

                    <td ng-bind="all_data.sp_status"></td>
                    <td ng-bind="all_data.sp_id"></td>
                    <td ng-bind="all_data.sp_title"></td>

                    <td ng-bind="all_data.sp_province"></td>
                    <td ng-bind="all_data.sp_municipality"></td>
                    <td ng-bind="all_data.sp_brgy"></td>
                    
                    <td>
                    <div ng-repeat="logs_planned in all_data.sp_logs track by $index">
                      <span ng-if="$last" ng-bind="logs_planned.sp_logs_planned" ></span>
                      </div>
                    </td>
                    <td>
                    <div ng-repeat="logs_planned in all_data.sp_logs track by $index">
                      <span ng-if="$last" ng-bind="logs_planned.sp_logs_actual" ></span>
                      </div>
                    </td>
                    <td>
                    <div ng-repeat="logs_planned in all_data.sp_logs track by $index">
                      <span ng-if="$last" ng-bind="logs_planned.sp_logs_slippage" ></span>
                      </div>
                    </td>
                    <td ng-bind="all_data.sp_groupings.grouping"></td>
                    <td ng-bind="all_data.sp_cycle.cycle"></td>
                    <td ng-bind="all_data.sp_batch.batch">BATCH</td>
                    <td ng-bind="all_data.sp_category.category">CATEGORY</td>
                    <td ng-bind="all_data.sp_type.type">TYPE</td>
                    <td ng-bind="all_data.sp_project_cost | currency: '₱'">PROJECT COST</td>
                    <td >
                      <span ng-if="all_data.sp_rfr_first_tranche_date == null || all_data.sp_rfr_first_tranche_date == ''">
                        NO DATA
                      </span>
                      <span ng-if="all_data.sp_rfr_first_tranche_date != null" ng-bind="all_data.sp_rfr_first_tranche_date | date: 'fullDate'"></span>
                    </td>
                    <td ng-bind="all_data.sp_date_started | date: 'fullDate'">DATE STARTED</td>
                    <td ng-bind="all_data.sp_estimated_duration">ESTIMATED DURATION</td>
                    <td ng-bind="all_data.sp_target_date_of_completion | date: 'fullDate'">TARGET COMPLETION DATE</td>
                    <td ng-bind="all_data.sp_actual_date_completed | date: 'fullDate'">
                    </td>
                    <td ng-bind="all_data.sp_physical_target">PHYSICAL TARGET</td>
                    <td>
                      <span ng-if="all_data.sp_building_permit == 0">NONE</span>
                      <span ng-if="all_data.sp_building_permit == 1">HAS BUILDING PERMIT</span>
                    </td>
                    <td>
                    <div ng-repeat="logs_planned in all_data.sp_logs track by $index">
                      <span ng-if="$last">
                        <span ng-if="logs_planned.sp_logs_variation_order == 0 || logs_planned.sp_logs_variation_order == null || logs_planned.sp_logs_variation_order == ''">NONE</span>
                          <span ng-if="logs_planned.sp_logs_variation_order == 1">HAS VARIATION ORDER</span>
                      </span>
                      </div>
                    </td>
                    <td>
                    <div ng-repeat="logs_planned in all_data.sp_logs track by $index">
                      <span ng-if="$last">
                        <span ng-if="logs_planned.sp_logs_spcr == 0 || logs_planned.sp_logs_spcr == null || logs_planned.sp_logs_spcr == '' || logs_planned.sp_logs_spcr == undefined">NONE</span>
                          <span ng-if="logs_planned.sp_logs_spcr == 1">HAS SPCR</span>
                      </span>
                      </div>
                    </td>
                    <td>
                    <div ng-repeat="logs_planned in all_data.sp_logs track by $index">
                      <span ng-if="$last">
                        <span ng-if="logs_planned.sp_logs_esmr == 0 || logs_planned.sp_logs_esmr == null || logs_planned.sp_logs_esmr == '' || logs_planned.sp_logs_esmr == undefined">NONE</span>
                          <span ng-if="logs_planned.sp_logs_esmr == 1">HAS ESMR</span>
                      </span>
                      </div>
                    </td>
                    <td>
                    <div ng-repeat="logs_planned in all_data.sp_logs track by $index">
                      <span ng-if="$last">
                        <span ng-if="logs_planned.sp_logs_csr == 0 || logs_planned.sp_logs_csr == null || logs_planned.sp_logs_csr == '' || logs_planned.sp_logs_csr == undefined">NONE</span>
                          <span ng-if="logs_planned.sp_logs_csr == 1">HAS CSR</span>
                      </span>
                      </div>
                    </td>
                    <td>
                    <div ng-repeat="logs_planned in all_data.sp_logs track by $index">
                      <span ng-if="$last">
                        <span ng-if="logs_planned.sp_logs_mt == 0 || logs_planned.sp_logs_mt == null || logs_planned.sp_logs_mt == '' || logs_planned.sp_logs_mt == undefined">NONE</span>
                          <span ng-if="logs_planned.sp_logs_mt == 1">HAS CSR</span>
                      </span>
                      </div>
                    </td>
                    <td>
                    <div ng-repeat="logs_planned in all_data.sp_logs track by $index">
                      <span ng-if="$last">
                          <span ng-if="logs_planned.sp_logs_issues == 0 || logs_planned.sp_logs_issues == null || logs_planned.sp_logs_issues == '' || logs_planned.sp_logs_issues == 'undefined'">NONE</span>
                        <span ng-bind="logs_planned.sp_logs_issues" ng-if="logs_planned.sp_logs_issues != 0 && logs_planned.sp_logs_issues != null && logs_planned.sp_logs_issues != '' && logs_planned.sp_logs_issues != undefined && logs_planned.sp_logs_issues != 'undefined'"></span>
                      </span>
                      </div>
                    </td>
                    <td>
                    <div ng-repeat="logs_planned in all_data.sp_logs track by $index">
                      <span ng-if="$last">
                        <span ng-if="logs_planned.sp_logs_analysis == 0 || logs_planned.sp_logs_analysis == null || logs_planned.sp_logs_analysis == '' || logs_planned.sp_logs_analysis == 'undefined' || logs_planned.sp_logs_analysis == undefined">NONE</span>
                        <span ng-bind="logs_planned.sp_logs_analysis" ng-if="logs_planned.sp_logs_analysis != null && logs_planned.sp_logs_analysis != '' && logs_planned.sp_logs_analysis != 'undefined' && logs_planned.sp_logs_analysis == undefined"></span>
                      </span>
                      </div>
                    </td>
                    <td>
                    <div ng-repeat="logs_planned in all_data.sp_logs track by $index">
                      <span ng-if="$last">
                        <span ng-if="logs_planned.sp_logs_remarks == 0 || logs_planned.sp_logs_remarks == null || logs_planned.sp_logs_remarks == '' || logs_planned.sp_logs_remarks == 'undefined' || logs_planned.sp_logs_remarks == undefined">NONE</span>
                        <span ng-bind="logs_planned.sp_logs_remarks" ng-if="logs_planned.sp_logs_remarks != 0 && logs_planned.sp_logs_remarks != null && logs_planned.sp_logs_remarks != '' && logs_planned.sp_logs_remarks != 'undefined' && logs_planned.sp_logs_remarks == undefined"></span>
                      </span>
                      </div>
                    </td>
                    <td>
                      <span ng-bind="all_data.sp_implementation"></span>
                    </td>
                  </tr>
                </tbody>
              </table>
          </div>  
        </div>
      </div>
        <!-- For Exporting from MODAL DATa -->
    </div>

  @include('user_admin_rcis.modality_modal')
@endsection