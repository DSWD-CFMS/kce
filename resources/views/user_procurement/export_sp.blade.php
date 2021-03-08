<!-- For Exporting -->
<div class="wrapper wrapper-content" ng-if="show_wrapper_tbl_sp_all_data == true">
    <div class="ibox-content m-b-sm border-bottom white-bg">
        <div class="table-responsive">
            <table class="table" id="sp_table_all_data">
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
                        <th>IMPLEMENTATION YEAR</th>
                    </tr>
                </thead>    
                <tbody>
                    <tr ng-repeat="all_data in sp_per_modality_data_all_sp_logs_export_all track by $index" style="font-size: 10px;">
                        <td ng-bind="all_data.updated_at | date:'shortDate'"></td>
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

                        <!-- RFR -->
                        <td>
                            <span ng-if="all_data.sp_rfr_first_tranche_date == '0000-00-00 00:00:00'">
                                NO DATA
                            </span>

                            <span ng-if="all_data.sp_rfr_first_tranche_date != '0000-00-00 00:00:00'">
                                <span ng-bind="all_data.sp_rfr_first_tranche_date"></span>
                            </span>
                        </td>

                        <!-- DATE STARTED -->
                        <td>
                            <span ng-if="all_data.sp_date_started == '0000-00-00 00:00:00'">
                                NO DATA
                            </span>

                            <span ng-if="all_data.sp_date_started != '0000-00-00 00:00:00'">
                                <span ng-bind="all_data.sp_date_started"></span>
                            </span>
                        </td>

                        <td ng-bind="all_data.sp_estimated_duration">ESTIMATED DURATION</td>
                        <td ng-bind="all_data.sp_target_date_of_completion | date: 'shortDate'">TARGET COMPLETION DATE</td>

                        <!-- ACTUAL DATE COMPLETED -->
                        <td>
                            <span ng-if="all_data.sp_actual_date_completed == '0000-00-00 00:00:00'">
                                NO DATA
                            </span>

                            <span ng-if="all_data.sp_actual_date_completed != '0000-00-00 00:00:00'">
                                <span ng-bind="all_data.sp_actual_date_completed"></span>
                            </span>
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
                        <td ng-bind="all_data.sp_implementation"></td>
                    </tr>
                </tbody>
            </table>
        </div>  
    </div>
</div>
