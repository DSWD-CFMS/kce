<div class="row wrapper page-heading justify-content-center animated fadeInRight">
    <!-- PAGINATION -->
    <div class="col-lg-12 my-2" ng-if="search_modal == false">
        <label class="text-muted"><small size="1"><span ng-if="sp_per_modality_data_all_sp_logs.from!=null" ng-bind="'Showing records '+sp_per_modality_data_all_sp_logs.from+'-'+sp_per_modality_data_all_sp_logs.to+' out of '+sp_per_modality_data_all_sp_logs.total"></span></small></label>
        <!-- <label class="text-muted"><small> Displaying 10 out of 1080 items </small></label> -->
          <ul class="pagination">
              <!-- Pag previous sa page  -->
            <li class="page-item disabled" ng-if="sp_per_modality_data_all_sp_logs.current_page == 1">
                <a style="text-transform: none;" class="page-link text-secondary" href="">Previous</a>
            </li>
            <li class="page-item" ng-if="sp_per_modality_data_all_sp_logs.current_page!=1" ng-click="Previous_Pagination_Reports(sp_per_modality_data_all_sp_logs.prev_page_url)"><a style="text-transform: none;" class="page-link text-secondary" href="">Previous</a></li>

            <!-- Pag adto sa first page -->
            <li class="page-item" ng-class="{'invisible' : sp_per_modality_data_all_sp_logs.current_page == 1 || sp_per_modality_data_all_sp_logs.current_page == 2 || sp_per_modality_data_all_sp_logs.current_page == 3 || sp_per_modality_data_all_sp_logs.last_page> 3 && sp_per_modality_data_all_sp_logs.last_page < 6}" ng-click="Skip_To_Page_Reports(sp_per_modality_data_all_sp_logs.path,1)">
            <a style="text-transform: none;" class="page-link text-secondary" href="">1</a>
            </li>

            <!-- Mag add ug (...) if ang current page is 4 pataas -->
            <li class="page-item disabled" ng-class="{'invisible' : sp_per_modality_data_all_sp_logs.current_page == 1 || sp_per_modality_data_all_sp_logs.current_page == 2 || sp_per_modality_data_all_sp_logs.current_page == 3 ||sp_per_modality_data_all_sp_logs.last_page>3&&sp_per_modality_data_all_sp_logs.last_page<6}">
                <a style="text-transform: none;" class="page-link text-secondary" href="">...</a>
            </li>   

            <!-- Number of Pages -->
            <li ng-repeat="x in [].constructor(sp_per_modality_data_all_sp_logs.last_page) track by $index" ng-click="Skip_To_Page_Reports(sp_per_modality_data_all_sp_logs.path,$index+1)">
                <a style="text-transform: none;" ng-class="{'bg-success active text-light': $index+1 == sp_per_modality_data_all_sp_logs.current_page, 'invisible' : sp_per_modality_data_all_sp_logs.current_page+1 < $index && $index > 5 || sp_per_modality_data_all_sp_logs.current_page - 5 >$index && $index <sp_per_modality_data_all_sp_logs.last_page-5}"  class="page-link text-secondary" href="" ng-bind="$index+1"></a>
            </li>

            <!-- Pag add ug (...) -->
            <li class="page-item disabled" ng-class="{'invisible' : sp_per_modality_data_all_sp_logs.current_page == sp_per_modality_data_all_sp_logs.last_page || sp_per_modality_data_all_sp_logs.current_page == sp_per_modality_data_all_sp_logs.last_page-1 || sp_per_modality_data_all_sp_logs.current_page == sp_per_modality_data_all_sp_logs.last_page-2||sp_per_modality_data_all_sp_logs.last_page>3&&sp_per_modality_data_all_sp_logs.last_page<6}">
            <a style="text-transform: none;" class="page-link text-secondary" href="">...</a>
            </li>

            <!-- Pag adto sa last page last page -->
            <li class="page-item" ng-class="{'invisible' : sp_per_modality_data_all_sp_logs.current_page == sp_per_modality_data_all_sp_logs.last_page || sp_per_modality_data_all_sp_logs.current_page == sp_per_modality_data_all_sp_logs.last_page-1 || sp_per_modality_data_all_sp_logs.current_page == sp_per_modality_data_all_sp_logs.last_page-2 || sp_per_modality_data_all_sp_logs.last_page>3&&sp_per_modality_data_all_sp_logs.last_page<6}" ng-click="Skip_To_Page_Reports(sp_per_modality_data_all_sp_logs.last_page)">
            <a style="text-transform: none;" class="page-link text-secondary" href="" ng-bind="sp_per_modality_data_all_sp_logs.last_page"></a>
            </li>

            <li class="page-item">
                <a style="text-transform: none;" class="page-link text-secondary" href="" ng-if="sp_per_modality_data_all_sp_logs.current_page < sp_per_modality_data_all_sp_logs.last_page" ng-click="Next_Pagination_Reports(sp_per_modality_data_all_sp_logs.next_page_url)">Next</a></li>
          </ul>
    </div>

    <!-- search_modal -->
    <div class="col-lg-12 my-2">
        <p ng-if="search_modal == true" class="text-muted">
        	<span ng-bind="'Total records obtained ' + search_modal_sp_for_export.length"></span>
        </p>
    </div>
    <!-- Paginated -->
    <div class="col-lg-12">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="MyInquires1">
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
                        <th>YEAR</th>
                    </tr>
                </thead>    
                <tbody style="min-height: 100px; overflow-y: auto;">
                    <!-- NORMAL DATA  -->
                    <tr ng-repeat="all_data in bars = (sp_per_modality_data_all_sp_logs.data)" ng-if="search_modal == false" style="font-size: 10px;">
                        <td>
                            <div ng-repeat="logs_planned in all_data.sp_logs track by $index">
                                <span ng-if="$last" ng-bind="logs_planned.updated_at | date:'shortDate'" ></span>
                            </div>
                        </td>

                        <td>
                            <div ng-repeat="dac in all_data.assigned_sp track by $index">
                                <span ng-bind="dac.users[0].Fname +' '+ dac.users[0].Lname" ></span>
                            </div>
                        </td>
                        <td>
                            <div ng-repeat="rpmo in all_data.assigned_grouping track by $index">
                                <span ng-bind="rpmo.users.Fname +' '+ rpmo.users.Lname +','" ></span>
                            </div>
                        </td>

                        <td ng-bind="all_data.sp_status"></td>
                        <td ng-bind="all_data.sp_id"></td>
                        <td ng-bind="all_data.sp_title | uppercase"></td>

                        <td ng-bind="all_data.sp_province | uppercase"></td>
                        <td ng-bind="all_data.sp_municipality | uppercase"></td>
                        <td ng-bind="all_data.sp_brgy | uppercase"></td>
                        
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
                        <td ng-bind="all_data.sp_type.type | uppercase">TYPE</td>
                        <td ng-bind="all_data.total_cost_ni | currency: '₱'">PROJECT COST</td>
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
                                <span ng-bind="all_data.sp_date_started | date:'shortDate'"></span>
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
                            <span ng-if="all_data.sp_building_permit != 0">HAS BUILDING PERMIT</span>
                        </td>
                        <td>
                            <div ng-repeat="logs_planned in all_data.sp_logs track by $index">
                                <span ng-if="$last">
                                    <span ng-if="logs_planned.sp_logs_variation_order == 0 || logs_planned.sp_logs_variation_order == null || logs_planned.sp_logs_variation_order == ''">NONE</span>
                                    <span ng-if="logs_planned.sp_logs_variation_order != 0 && logs_planned.sp_logs_variation_order != null">HAS VARIATION ORDER</span>
                                </span>
                            </div>
                        </td>
                        <td>
                            <div ng-repeat="logs_planned in all_data.sp_logs track by $index">
                                <span ng-if="$last">
                                    <span ng-if="logs_planned.sp_logs_spcr == 0 || logs_planned.sp_logs_spcr == null || logs_planned.sp_logs_spcr == '' || logs_planned.sp_logs_spcr == undefined">NONE</span>
                                    <span ng-if="logs_planned.sp_logs_spcr != 0">HAS SPCR</span>
                                </span>
                            </div>
                        </td>
                        <td>
                            <div ng-repeat="logs_planned in all_data.sp_logs track by $index">
                                <span ng-if="$last">
                                    <span ng-if="logs_planned.sp_logs_esmr == 0 || logs_planned.sp_logs_esmr == null || logs_planned.sp_logs_esmr == '' || logs_planned.sp_logs_esmr == undefined">NONE</span>
                                    <span ng-if="logs_planned.sp_logs_esmr != 0">HAS ESMR</span>
                                </span>
                            </div>
                        </td>
                        <td>
                            <div ng-repeat="logs_planned in all_data.sp_logs track by $index">
                                <span ng-if="$last">
                                    <span ng-if="logs_planned.sp_logs_csr == 0 || logs_planned.sp_logs_csr == null || logs_planned.sp_logs_csr == '' || logs_planned.sp_logs_csr == undefined">NONE</span>
                                    <span ng-if="logs_planned.sp_logs_csr != 0">HAS CSR</span>
                                </span>
                            </div>
                        </td>
                        <td>
                            <div ng-repeat="logs_planned in all_data.sp_logs track by $index">
                                <span ng-if="$last">
                                    <span ng-if="logs_planned.sp_logs_mt == 0 || logs_planned.sp_logs_mt == null || logs_planned.sp_logs_mt == '' || logs_planned.sp_logs_mt == undefined">NONE</span>
                                    <span ng-if="logs_planned.sp_logs_mt != 0 && logs_planned.sp_logs_mt != null">HAS MATERIAL TESTING</span>
                                </span>
                            </div>
                        </td>
                        <td ng-bind="all_data.issues | uppercase"></td>
                        <td ng-bind="all_data.analysis | uppercase"></td>
                        <td ng-bind="all_data.remarks | uppercase"></td>
                        <td ng-bind="all_data.sp_implementation"></td>
                    </tr>

                    <!-- MODAL DATA  -->
                    <tr ng-repeat="all_data in bars = (search_modal_sp_for_export)" ng-if="search_modal == true" style="font-size: 10px;">
                        <td>
                            <div ng-repeat="logs_planned in all_data.sp_logs track by $index">
                                <span ng-if="$last" ng-bind="logs_planned.updated_at | date:'shortDate'" ></span>
                            </div>
                        </td>
                        
                        <td>
                            <div ng-repeat="dac in all_data.assigned_sp track by $index">
                                <span ng-bind="dac.users[0].Fname +' '+ dac.users[0].Lname" ></span>
                            </div>
                        </td>
                        <td>
                            <div ng-repeat="rpmo in all_data.assigned_grouping track by $index">
                                <span ng-bind="rpmo.users.Fname +' '+ rpmo.users.Lname +','" ></span>
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
                                <span ng-bind="all_data.sp_date_started | date:'shortDate'"></span>
                            </span>
                        </td>

                        <td ng-bind="all_data.sp_estimated_duration">ESTIMATED DURATION</td>

                        <td>
                            <span ng-if="all_data.sp_target_date_of_completion == '0000-00-00 00:00:00' || all_data.sp_target_date_of_completion == NULL">
                                NO DATA
                            </span>

                            <span ng-if="all_data.sp_target_date_of_completion != '0000-00-00 00:00:00' || all_data.sp_target_date_of_completion != NULL">
                                <span ng-bind="all_data.sp_target_date_of_completion | date: 'shortDate'"></span>
                            </span>
                        </td>

                        <!-- ACTUAL DATE COMPLETED -->
                        <td>
                            <span ng-if="all_data.sp_actual_date_completed == '0000-00-00 00:00:00'">
                                NO DATA
                            </span>

                            <span ng-if="all_data.sp_actual_date_completed != '0000-00-00 00:00:00'">
                                <span ng-bind="all_data.sp_actual_date_completed | date: 'shortDate'"></span>
                            </span>
                        </td>

                        <td ng-bind="all_data.sp_physical_target">PHYSICAL TARGET</td>
                        <td>
                            <span ng-if="all_data.sp_building_permit == 0">NONE</span>
                            <span ng-if="all_data.sp_building_permit != 0">HAS BUILDING PERMIT</span>
                        </td>
                        <td>
                            <div ng-repeat="logs_planned in all_data.sp_logs track by $index">
                                <span ng-if="$last">
                                    <span ng-if="logs_planned.sp_logs_variation_order == 0 || logs_planned.sp_logs_variation_order == null || logs_planned.sp_logs_variation_order == ''">NONE</span>
                                    <span ng-if="logs_planned.sp_logs_variation_order != 0 && logs_planned.sp_logs_variation_order != null">HAS VARIATION ORDER</span>
                                </span>
                            </div>
                        </td>
                        <td>
                            <div ng-repeat="logs_planned in all_data.sp_logs track by $index">
                                <span ng-if="$last">
                                    <span ng-if="logs_planned.sp_logs_spcr == 0 || logs_planned.sp_logs_spcr == null || logs_planned.sp_logs_spcr == '' || logs_planned.sp_logs_spcr == undefined">NONE</span>
                                    <span ng-if="logs_planned.sp_logs_spcr != 0">HAS SPCR</span>
                                </span>
                            </div>
                        </td>
                        <td>
                            <div ng-repeat="logs_planned in all_data.sp_logs track by $index">
                                <span ng-if="$last">
                                    <span ng-if="logs_planned.sp_logs_esmr == 0 || logs_planned.sp_logs_esmr == null || logs_planned.sp_logs_esmr == '' || logs_planned.sp_logs_esmr == undefined">NONE</span>
                                    <span ng-if="logs_planned.sp_logs_esmr != 0">HAS ESMR</span>
                                </span>
                            </div>
                        </td>
                        <td>
                            <div ng-repeat="logs_planned in all_data.sp_logs track by $index">
                                <span ng-if="$last">
                                    <span ng-if="logs_planned.sp_logs_csr == 0 || logs_planned.sp_logs_csr == null || logs_planned.sp_logs_csr == '' || logs_planned.sp_logs_csr == undefined">NONE</span>
                                    <span ng-if="logs_planned.sp_logs_csr != 0">HAS CSR</span>
                                </span>
                            </div>
                        </td>
                        <td>
                            <div ng-repeat="logs_planned in all_data.sp_logs track by $index">
                                <span ng-if="$last">
                                    <span ng-if="logs_planned.sp_logs_mt == 0 || logs_planned.sp_logs_mt == null || logs_planned.sp_logs_mt == '' || logs_planned.sp_logs_mt == undefined">NONE</span>
                                    <span ng-if="logs_planned.sp_logs_mt != 0 && logs_planned.sp_logs_mt != null">HAS MATERIAL TESTING</span>
                                </span>
                            </div>
                        </td>

                        <td ng-bind="all_data.issues | uppercase"></td>
                        <td ng-bind="all_data.analysis | uppercase"></td>
                        <td ng-bind="all_data.remarks | uppercase"></td>
                        <td ng-bind="all_data.sp_implementation"></td>
                    </tr>
                </tbody>
            </table>
        </div>  
    </div>
    
    <!-- For Exporting -->
    <div class="col-lg-12" ng-if="search_modal == false"  hidden="true">
        <div class="wrapper wrapper-content" >
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
                            <th>YEAR</th>
                        </tr>
                    </thead>    
                    <tbody>
                        <tr ng-repeat="all_data in sp_per_modality_data_all_sp_logs track by $index" style="font-size: 10px;">
                            <td>
                                <div ng-repeat="logs_planned in all_data.sp_logs track by $index">
                                    <span ng-if="$last" ng-bind="logs_planned.updated_at | date:'shortDate'" ></span>
                                </div>
                            </td>
                            <td>
                                <div ng-repeat="dac in all_data.assigned_sp track by $index">
                                    <span ng-bind="dac.users[0].Fname +' '+ dac.users[0].Lname" ></span>
                                </div>
                            </td>
                            <td>
                                <div ng-repeat="rpmo in all_data.assigned_grouping track by $index">
                                    <span ng-bind="rpmo.users.Fname +' '+ rpmo.users.Lname +','" ></span>
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
                            <td ng-bind="all_data.issues | uppercase"></td>
                            <td ng-bind="all_data.analysis | uppercase"></td>
                            <td ng-bind="all_data.remarks | uppercase"></td>
                            <td ng-bind="all_data.sp_implementation"></td>
                        </tr>
                    </tbody>
                </table>
            </div>  
        </div>
        </div>
    </div>
</div>