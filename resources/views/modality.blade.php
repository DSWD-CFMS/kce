@extends('layouts.app2')

@section('content')
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
</style>
<div class="container-fluid" style="padding-top: 100px;" ng-init="get_modalities_sp()">
    <section class="row justify-content-center">
        <div class="col-lg-6">
            <h1 class="font-weight-bold">Modalities</h1>
            <p class="font-weight-light"> These are on-going projects </p>
        </div>
        <div class="col-lg-2">
            <label><span class="font-weight-bold text-secondary"> Search </span></label>
            <input type="text" class="form-control" aria-describedby="search_employee" placeholder="Search..." ng-model="search_data_modality.$">
        </div>
        <div class="col-lg-2" style="align-self: center !important;">
            <button class="btn btn-light btn-block" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#filter_modal" style="border-radius:50px !important;"> <i class="fa fa-filter"></i> Filters </button>
        </div>
        <div class="col-lg-2" style="align-self: center !important;">
            <button class="btn btn-block btn-outline-primary btn-lg mx-1" type="button" ng-click="Export_Modality_Data()" style="border-radius: 26px !important;"> <i class="fa fa-share-square-o"></i> <span>Export</span> </button>
        </div>
        <div class="col-lg-12">
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
                    <tbody>
                        <tr style="font-size: 10px;" ng-repeat="all_data in bars = (get_modalities_sp_data | filter: search_data_modality.$ | filter: search_data_modality.sp_groupings.grouping | filter: search_data_modality.sp_category.category | filter:search_data_modality.sp_type.type | filter: search_data_modality.sp_cycle.cycle | filter:search_data_modality.sp_batch.batch | filter: province_data.name | filter: municipality_data.name | filter: brgy_data.name | filter: search_data_modality.sp_title | filter: search_data_modality.sp_id)">
                            <td>
                                <div ng-repeat="logs_planned in all_data.sp_logs track by $index">
                                    <span ng-if="$last" ng-bind="logs_planned.updated_at | date:'fullDate'" ></span>
                                </div>
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
                                <span class="pb-0 mb-0" ng-if="all_data.c_m_f_s_kalahi_2015__b_u_b__s_p != null">
                                    <span ng-bind="all_data.c_m_f_s_kalahi_2015__b_u_b__s_p.sp_title | uppercase"></span>
                                </span>
                                <span class="pb-0 mb-0" ng-if="all_data.c_m_f_s_kalahi_2016__b_u_b__s_p != null">
                                    <span ng-bind="all_data.c_m_f_s_kalahi_2016__b_u_b__s_p.sp_title | uppercase"></span>
                                </span>
                                <span class="pb-0 mb-0" ng-if="all_data.c_m_f_s_kalahi_2017__b_u_b__s_p != null">
                                    <span ng-bind="all_data.c_m_f_s_kalahi_2017__b_u_b__s_p.sp_title | uppercase"></span>
                                </span>
                                <span class="pb-0 mb-0" ng-if="all_data.c_m_f_s_kalahi_2018__b_u_b__s_p != null">
                                    <span ng-bind="all_data.c_m_f_s_kalahi_2018__b_u_b__s_p.sp_title | uppercase"></span>
                                </span>
                                <span class="pb-0 mb-0" ng-if="all_data.c_m_f_s_kalahi_2020__b_u_b__s_p != null">
                                    <span ng-bind="all_data.c_m_f_s_kalahi_2020__b_u_b__s_p.sp_title | uppercase"></span>
                                </span>

                                <span class="pb-0 mb-0" ng-if="all_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p != null">
                                    <span ng-bind="all_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p.sp_title | uppercase"></span>
                                </span>
                                <span class="pb-0 mb-0" ng-if="all_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p != null">
                                    <span ng-bind="all_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p.sp_title | uppercase"></span>
                                </span>
                                <span class="pb-0 mb-0" ng-if="all_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p != null">
                                    <span ng-bind="all_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p.sp_title | uppercase"></span>
                                </span>
                                <span class="pb-0 mb-0" ng-if="all_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p != null">
                                    <span ng-bind="all_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p.sp_title | uppercase"></span>
                                </span>
                                <span class="pb-0 mb-0" ng-if="all_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p != null">
                                    <span ng-bind="all_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p.sp_title | uppercase"></span>
                                </span>
                                <span class="pb-0 mb-0" ng-if="all_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p != null">
                                    <span ng-bind="all_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p.sp_title | uppercase"></span>
                                </span>
                            </td>

                            <td ng-bind="all_data.sp_province"></td>
                            <td ng-bind="all_data.sp_municipality"></td>
                            <td ng-bind="all_data.sp_brgy"></td>
                            
                            <td>
                                <div ng-repeat="logs_planned in all_data.sp_logs track by $index">
                                    <span class="text-warning" ng-if="$last" ng-bind="logs_planned.sp_logs_planned" ></span>
                                </div>
                            </td>
                            <td>
                                <div ng-repeat="logs_planned in all_data.sp_logs track by $index">
                                    <span class="text-success" ng-if="$last" ng-bind="logs_planned.sp_logs_actual" ></span>
                                </div>
                            </td>
                            <td>
                                <div ng-repeat="logs_planned in all_data.sp_logs track by $index">
                                    <span ng-if="logs_planned.sp_logs_slippage >= 0" class="text-green" ng-show="$last" ng-bind="(logs_planned.sp_logs_slippage) + '%'"></span>
                                    <span ng-if="logs_planned.sp_logs_slippage < 0" class="text-danger" ng-show="$last" ng-bind="(logs_planned.sp_logs_slippage) + '%'"></span>
                                </div>
                            </td>
                            <td ng-bind="all_data.sp_groupings.grouping"></td>
                            <td ng-bind="all_data.sp_cycle.cycle"></td>
                            <td ng-bind="all_data.sp_batch.batch">BATCH</td>
                            <td ng-bind="all_data.sp_category.category">CATEGORY</td>
                            <td ng-bind="all_data.sp_type.type">TYPE</td>
                            <!-- ng-bind="all_data.sp_project_cost | currency: '₱'" -->
                            <td ng-bind="all_data.sp_project_cost | currency: '₱'">TYPE</td>

<!--                             <td>
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
                            </td> -->
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
                            <!-- <td>
                                <span ng-if="all_data.sp_building_permit == 0">NONE</span>
                                <span ng-if="all_data.sp_building_permit != 0">HAS BUILDING PERMIT</span>
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
                            </td> -->
                            <td>
                                <div ng-repeat="logs_planned in all_data.sp_logs track by $index">
                                    <span ng-if="$last">
                                        <span ng-if="logs_planned.sp_logs_issues == 0 || logs_planned.sp_logs_issues == null || logs_planned.sp_logs_issues == '' || logs_planned.sp_logs_issues == 'undefined'">NONE</span>
                                        <span ng-if="logs_planned.sp_logs_issues != 0" ng-bind="logs_planned.sp_logs_issues"></span>
                                    </span>
                                </div>
                            </td>
                            <td>
                                <div ng-repeat="logs_planned in all_data.sp_logs track by $index">
                                    <span ng-if="$last">
                                        <span ng-if="logs_planned.sp_logs_analysis == 0 || logs_planned.sp_logs_analysis == null || logs_planned.sp_logs_analysis == '' || logs_planned.sp_logs_analysis == 'undefined' || logs_planned.sp_logs_analysis == undefined">NONE</span>

                                        <span ng-if="logs_planned.sp_logs_analysis != 0" ng-bind="logs_planned.sp_logs_analysis"></span>
                                    </span>
                                </div>
                            </td>
                            <td>
                                <div ng-repeat="logs_planned in all_data.sp_logs track by $index">
                                    <span ng-if="$last">
                                        <span ng-if="logs_planned.sp_logs_remarks == 0 || logs_planned.sp_logs_remarks == null || logs_planned.sp_logs_remarks == '' || logs_planned.sp_logs_remarks == 'undefined' || logs_planned.sp_logs_remarks == undefined">NONE</span>
                                        <span ng-if="logs_planned.sp_logs_remarks != 0" ng-bind="logs_planned.sp_logs_remarks"></span>
                                    </span>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>  
        </div>

        <div class="col-lg-12 mb-3 mt-2">
            <div class="row justify-content-end">
                <div class="col-lg-2 text-right">
                    <button class="btn btn-block btn-outline-primary btn-lg mx-1" type="button" ng-click="Export_Modality_Data()" style="border-radius: 26px !important;"> <i class="fa fa-share-square-o"></i> <span>Export</span> </button>
                </div>
            </div>
            
        </div>
    </section>
</div>

<!-- FILTER MODAL -->
<div class="modal inmodal fade" id="filter_modal" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header py-2 px-3 text-left">
                <span style="font-size: 1.3em;" class="py-0 my-0">
                    Filter Modalities
                </span>
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            </div>
            <div class="modal-body" style="padding-top: 10px;padding-bottom: 10px;">
              <div class="form-group mb-2">
                    <label><small class="col-form-label"> <small class="font-weight-bold"> Modality </small> </small></label>
                    <select class="custom-select" id="modality" ng-model="search_data_modality.sp_groupings.grouping">
                        <option value="KKB" selected>KKB</option>
                        <option value="MAKILAHOK">MAKILAHOK</option>
                        <option value="NCDDP">NCDDP</option>
                        <option value="IP CDD">IP CDD</option>
                        <option value="CCL">CCL</option>
                        <option value="L&E">L&E</option>
                    </select>
                </div>
                
                <div class="row">

                    <div class="col-lg-6">
                        <div class="form-group">
                            <label><span class="font-weight-bold text-secondary"> Category </span></label>
                            <select class="custom-select" id="cycle" ng-model="search_data_modality.sp_category.category">
                                <option value="PUBLIC GOODS" selected> PUBLIC GOODS </option>
                                <option value="ENVIRONMENTAL PROTECTION AND CONSERVATION"> ENVIRONMENTAL PROTECTION AND CONSERVATION </option>
                                <option value="ENTERPRISE"> ENTERPRISE </option>
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="form-group">
                            <label><span class="font-weight-bold text-secondary"> Type </span></label>
                            <select class="custom-select" id="cycle" ng-model="search_data_modality.sp_type.type">
                                <option value="ROADS" selected> ROADS </option>
                                <option value="WATER SYSTEM"> WATER SYSTEM </option>
                                <option value="BHS"> BHS </option>
                                <option value="PATHWAY"> PATHWAY </option>
                                <option value="DRAINAGE"> DRAINAGE </option>
                                <option value="EVACUATION CENTER"> EVACUATION CENTER </option>
                                <option value="FOOTBRIDGE"> FOOTBRIDGE </option>
                                <option value="SEAWALL"> SEAWALL </option>
                                <option value="MULTIPURPOSE BUILDING"> MULTIPURPOSE BUILDING </option>
                                <option value="TRIBAL CENTER"> TRIBAL CENTER </option>
                                <option value="EPSL"> EPSL </option>
                                <option value="SCHOOL BUILDING"> SCHOOL BUILDING </option>
                                <option value="CULVERTS"> CULVERTS </option>
                                <option value="SPSL"> SPSL </option>
                                <option value="CDC"> CDC </option>
                                <option value="FLOOD CONTROL"> FLOOD CONTROL </option>
                                <option value="LATRINE"> LATRINE </option>
                                <option value="WHARF"> WHARF </option>
                                <option value="RIVERDIKE"> RIVER DIKE </option>
                                <option value="RICEMILL"> RICEMILL </option>
                                <option value="SLOPE PROTECTION"> SLOPE PROTECTION </option>
                                <option value="STAIRWAY"> STAIRWAY </option>
                                <option value="BRIDGES"> BRIDGES </option>
                                <option value="RIVERBANK PROTECTION"> RIVERBANK PROTECTION </option>
                                <option value="RWH"> RWH </option>
                                <option value="SOLAR DRYER"> SOLAR DRYER </option>
                                <option value="LEARNING CENTER"> LEARNING CENTER </option>
                                <option value="OTHERS"> OTHERS </option>
                                <option value="PROTECTION DIKE"> PROTECTION DIKE </option>
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="form-group mb-2">
                            <label><small class="col-form-label"> <small class="font-weight-bold"> Year </small> </small></label>
                            <select class="form-control" id="year" >
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
                            <label><span class="font-weight-bold text-secondary"> Cycle </span></label>
                            <select class="custom-select" id="cycle" ng-model="search_data_modality.sp_cycle.cycle">
                                <option value="CYCLE 1" selected> 1 </option>
                                <option value="CYCLE 2"> 2 </option>
                                <option value="CYCLE 3"> 3 </option>
                                <option value="CYCLE 4"> 4 </option>
                                <option value="CYCLE 5"> 5 </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group mb-2">
                            <label><span class="font-weight-bold text-secondary"> Batch </span></label>
                            <select class="custom-select" id="batch" ng-model="search_data_modality.sp_batch.batch">
                                <option value="BATCH 1" selected> 1 </option>
                                <option value="BATCH 2"> 2 </option>
                                <option value="BATCH 3"> 3 </option>
                                <option value="BATCH 4"> 4 </option>
                                <option value="BATCH 5"> 5 </option>
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
                    <input type="text" class="form-control" aria-describedby="emailHelp" ng-model="search_data_modality.sp_title" placeholder="Ex. FISH CAGE CULTURE..." >
                </div>

                <div class="form-group mb-2">
                    <label><small class="col-form-label"> <small class="font-weight-bold"> SP ID </small> </small></label>
                    <input type="text" class="form-control" aria-describedby="emailHelp" ng-model="search_data_modality.sp_id" placeholder="Ex. 201804000..." >
                </div>
                </div>
              <div class="modal-footer">
                <button class="btn btn-primary" type="button" data-dismiss="modal" ng-click="search_data_modal(search_modality,search_year,search_cycle,search_batch,province_data,municipality_data,brgy_data,search_title,search_sp_id)">Generate <i class="fa fa-gears   "></i></button>
                <a class="btn btn-white" type="button"  href="{{ route('modality') }}">Cancel <i class="fa fa-times"></i></a>
              </div>
        </div>
    </div>
</div>
@endsection