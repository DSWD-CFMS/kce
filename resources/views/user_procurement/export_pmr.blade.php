<!-- For Exporting   --> 
<div class="wrapper wrapper-content" id="wrapper_tbl_pmr_all_data" ng-if="show_wrapper_tbl_pmr_all_data == true">
  <div class="ibox-content m-b-sm border-bottom white-bg">
    <div class="table-responsive">
        <table class="table table-bordered" id="pmr_table_all_data">
          <thead>
            <tr>
              <th rowspan="2">STATUS</th>
              <th rowspan="2">MODALITY</th>
              <th rowspan="2">PROVINCE</th>
              <th rowspan="2">MUNICIPALITY</th>
              <th rowspan="2">CODE (PAP)</th>
              <th>PROCUREMENT PROJECT</th>
              <th>PMO/End-User</th>
              <th>Is this an Early Procurement Activity?</th>
              <th>Mode of Procurement</th>
              <th colspan="18">Actual Procurement Activity</th>
              <th>Source of Fund</th>
              <th colspan="3">ABC (Php)</th>
              <th colspan="3">Contract Cost (Php)</th>
              <th>List of Invited Observers</th>
              <th colspan="6">Date of Receipt of Invitation</th>
              <th rowspan="2">Remarks</th>
            </tr>
            <tr>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td colspan="1">Pre-Proc Conference</td>
              <td colspan="1">Ads/Post of IB</td>
              <td colspan="1">Pre-bid Conf</td>
              <td colspan="1">Eligibility Check</td>
              <td colspan="1">Sub/Open of Bids</td>
              <td colspan="1">Bid Evaluation</td>
              <td colspan="1">Post Qual</td>
              <td colspan="1">Date of BAC Resolution Recommending Award</td>
              <td colspan="1">Notice of Award</td>
              <td colspan="1">Contract Signing</td>
              <td colspan="1">Notice to Proceed</td>
              <td colspan="1">Date of Posting to PhilGEPS (NOA)</td>
              <td colspan="1">Date of Posting to PhilGEPS (PO/CONTRACT)</td>
              <td colspan="1">Contract Review Date</td>
              <td colspan="1">Target Date of Completion</td>
              <td colspan="1">Delivery/ Completion</td>
              <td colspan="1">Inspection & Acceptance</td>
              <td colspan="1">Date of Contractors Evaluation Conducted</td>
              <td></td>
              <th>Total</th>
              <th>MOOE</th>
              <th>CO</th>
              <th>Total</th>
              <th>MOOE</th>
              <th>CO</th>
              <td></td>
              <th>Pre-bid Conf </th>
              <th>Eligibility Check </th>
              <th>Sub/Open of Bids </th>
              <th>Bid Evaluation </th>
              <th>Post Qual </th>
              <th>Delivery/Completion/Acceptance (If applicable) </th>
            </tr>
          </thead>
          <tbody>
            <tr ng-repeat="all_data in sp_pmr track by $index">
              <td ng-bind="all_data.status | uppercase"></td>
              <td>
                <span ng-if="all_data.sp.sp_groupings == 1">KKB</span>
                <span ng-if="all_data.sp.sp_groupings == 2">MAKILAHOK</span>
                <span ng-if="all_data.sp.sp_groupings == 3">NCDDP</span>
                <span ng-if="all_data.sp.sp_groupings == 4">IP CDD</span>
                <span ng-if="all_data.sp.sp_groupings == 5">CCL</span>
                <span ng-if="all_data.sp.sp_groupings == 6">LandE</span>
              </td>
              <td ng-bind="all_data.sp.sp_province | uppercase"></td>
              <td ng-bind="all_data.sp.sp_municipality | uppercase"></td>
              <td ng-bind="all_data.code"></td>
              <td ng-bind="all_data.sp.sp_title | uppercase"></td>
              <td ng-bind="all_data.sp.sp_brgy | uppercase"></td>
              <td ng-bind="all_data.sp.early_procurement_activity | uppercase"></td>
              <td ng-bind="all_data.mode_of_procurement"></td>
              <td>
                <span ng-if="all_data.apa_pre_proc_con == null"></span>
                <span ng-if="all_data.apa_pre_proc_con != null">
                  <span ng-bind="all_data.apa_pre_proc_con | date:'dd/MM/yy'"></span>
                </span>
              </td>
              <td>
                <span ng-if="all_data.apa_ads == 'Invalid Date'"></span>
                <span ng-if="all_data.apa_ads != 'Invalid Date'">
                  <span ng-bind="all_data.apa_ads | date:'dd/MM/yy'"></span>
                </span>
              </td>
              <td>
                <span ng-if="all_data.apa_prebid_con == 'Invalid Date'"></span>
                <span ng-if="all_data.apa_prebid_con != 'Invalid Date'">
                  <span ng-bind="all_data.apa_prebid_con | date:'dd/MM/yy'"></span>
                </span>
              </td>
              <td>
                <span ng-if="all_data.apa_eligibility_check == 'Invalid Date'"></span>
                <span ng-if="all_data.apa_eligibility_check != 'Invalid Date'">
                  <span ng-bind="all_data.apa_eligibility_check | date:'dd/MM/yy'"></span>
                </span>
              </td>
              <td>
                <span ng-if="all_data.apa_open_of_bids == 'Invalid Date'"></span>
                <span ng-if="all_data.apa_open_of_bids != 'Invalid Date'">
                  <span ng-bind="all_data.apa_open_of_bids | date:'dd/MM/yy'"></span>
                </span>
              </td>
              <td>
                <span ng-if="all_data.apa_bid_eval == 'Invalid Date'"></span>
                <span ng-if="all_data.apa_bid_eval != 'Invalid Date'">
                  <span ng-bind="all_data.apa_bid_eval | date:'dd/MM/yy'"></span>
                </span>
              </td>
              <td>
                <span ng-if="all_data.apa_post_qual == 'Invalid Date'"></span>
                <span ng-if="all_data.apa_post_qual != 'Invalid Date'">
                  <span ng-bind="all_data.apa_post_qual | date:'dd/MM/yy'"></span>
                </span>
              </td>
              <td>
                <span ng-if="all_data.bac_reso_recom_award == 'Invalid Date'"></span>
                <span ng-if="all_data.bac_reso_recom_award != 'Invalid Date'">
                  <span ng-bind="all_data.bac_reso_recom_award | date:'dd/MM/yy'"></span>
                </span>
              </td>
              <td>
                <span ng-if="all_data.apa_notice_of_award == 'Invalid Date'"></span>
                <span ng-if="all_data.apa_notice_of_award != 'Invalid Date'">
                  <span ng-bind="all_data.apa_notice_of_award | date:'dd/MM/yy'"></span>
                </span>
              </td>
              <td>
                <span ng-if="all_data.apa_contract_signing == 'Invalid Date'"></span>
                <span ng-if="all_data.apa_contract_signing != 'Invalid Date'">
                  <span ng-bind="all_data.apa_contract_signing | date:'dd/MM/yy'"></span>
                </span>
              </td>
              <td>
                <span ng-if="all_data.apa_notice_to_proceed == 'Invalid Date'"></span>
                <span ng-if="all_data.apa_notice_to_proceed != 'Invalid Date'">
                  <span ng-bind="all_data.apa_notice_to_proceed | date:'dd/MM/yy'"></span>
                </span>
              </td>

              <td>
                <span ng-if="all_data.date_of_posting_philgeps_noa == 'Invalid Date' && all_data.philgeps == false">N/A</span>
                <span ng-if="all_data.date_of_posting_philgeps_noa != 'Invalid Date' && all_data.philgeps == true">
                  <span ng-bind="all_data.date_of_posting_philgeps_noa | date:'dd/MM/yy'"></span>
                </span>
              </td>
              <td>
                <span ng-if="all_data.date_of_posting_philgeps_po_contract == 'Invalid Date' && all_data.philgeps == false">N/A</span>
                <span ng-if="all_data.date_of_posting_philgeps_po_contract != 'Invalid Date' && all_data.philgeps == true">
                  <span ng-bind="all_data.date_of_posting_philgeps_po_contract | date:'dd/MM/yy'"></span>
                </span>
              </td>

              <td>
                <span ng-if="all_data.apa_contract_review_date == 'Invalid Date'"></span>
                <span ng-if="all_data.apa_contract_review_date != 'Invalid Date'">
                  <span ng-bind="all_data.apa_contract_review_date | date:'dd/MM/yy'"></span>
                </span>
              </td>
              <td>
                <span ng-if="all_data.apa_target_date_completion == 'Invalid Date'"></span>
                <span ng-if="all_data.apa_target_date_completion != 'Invalid Date'">
                  <span ng-bind="all_data.apa_target_date_completion | date:'dd/MM/yy'"></span>
                </span>
              </td>  
              <td>
                <span ng-if="all_data.apa_delivery == 'Invalid Date'"></span>
                <span ng-if="all_data.apa_delivery != 'Invalid Date'">
                  <span ng-bind="all_data.apa_delivery | date:'dd/MM/yy'"></span>
                </span>
              </td>
              <td>
                <span ng-if="all_data.apa_acceptance == 'Invalid Date'"></span>
                <span ng-if="all_data.apa_acceptance != 'Invalid Date'">
                  <span ng-bind="all_data.apa_acceptance | date:'dd/MM/yy'"></span>
                </span>
              </td>
              <td>
                <span ng-if="all_data.apa_contractors_eval_conducted == 'Invalid Date'"></span>
                <span ng-if="all_data.apa_contractors_eval_conducted != 'Invalid Date'">
                  <span ng-bind="all_data.apa_contractors_eval_conducted | date:'dd/MM/yy'"></span>
                </span>
              </td>
              <td ng-bind="all_data.fund_source"></td>
              <td ng-bind="all_data.abc_total"></td>
              <td ng-bind="all_data.abc_mooe"></td>
              <td ng-bind="all_data.abc_co"></td>
              <td ng-bind="all_data.contract_cost_total"></td>
              <td ng-bind="all_data.contract_cost_mooe"></td>
              <td ng-bind="all_data.contract_cost_co"></td>
              <td ng-bind="all_data.list_of_invited"></td>
              <td>
                <span ng-if="all_data.io_prebid_con == 'Invalid Date'"></span>
                <span ng-if="all_data.io_prebid_con != 'Invalid Date'">
                  <span ng-bind="all_data.io_prebid_con | date:'dd/MM/yy'"></span>
                </span>
              </td>
              <td>
                <span ng-if="all_data.io_eligibility_check == 'Invalid Date'"></span>
                <span ng-if="all_data.io_eligibility_check != 'Invalid Date'">
                  <span ng-bind="all_data.io_eligibility_check | date:'dd/MM/yy'"></span>
                </span>
              </td>
              <td>
                <span ng-if="all_data.io_open_of_bids == 'Invalid Date'"></span>
                <span ng-if="all_data.io_open_of_bids != 'Invalid Date'">
                  <span ng-bind="all_data.io_open_of_bids | date:'dd/MM/yy'"></span>
                </span>
              </td>
              <td>
                <span ng-if="all_data.io_bid_eval == 'Invalid Date'"></span>
                <span ng-if="all_data.io_bid_eval != 'Invalid Date'">
                  <span ng-bind="all_data.io_bid_eval | date:'dd/MM/yy'"></span>
                </span>
              </td>
              <td>
                <span ng-if="all_data.io_post_qual == 'Invalid Date'"></span>
                <span ng-if="all_data.io_post_qual != 'Invalid Date'">
                  <span ng-bind="all_data.io_post_qual | date:'dd/MM/yy'"></span>
                </span>
              </td>
              <td>
                <span ng-if="all_data.delivery == 'Invalid Date'"></span>
                <span ng-if="all_data.delivery != 'Invalid Date'">
                  <span ng-bind="all_data.delivery | date:'dd/MM/yy'"></span>
                </span>
              </td>
              <td ng-bind="all_data.remarks | uppercase"></td>
            </tr>
          </tbody>
        </table>
    </div>  
  </div>
</div>

<!-- For Exporting from MODAL DATa  -->
<div class="wrapper wrapper-content" ng-if="search_modal == true">
  <div class="ibox-content m-b-sm border-bottom white-bg">
    <div class="table-responsive">
        <table class="table table-bordered" id="pmr_table_filter_data">
          <thead>
            <tr>
              <th rowspan="2">STATUS</th>
              <th rowspan="2">MODALITY</th>
              <th rowspan="2">PROVINCE</th>
              <th rowspan="2">MUNICIPALITY</th>
              <th rowspan="2">CODE (PAP)</th>
              <th>PROCUREMENT PROJECT</th>
              <th>PMO/End-User</th>
              <th>Is this an Early Procurement Activity?</th>
              <th>Mode of Procurement</th>
              <th colspan="18">Actual Procurement Activity</th>
              <th>Source of Fund</th>
              <th colspan="3">ABC (Php)</th>
              <th colspan="3">Contract Cost (Php)</th>
              <th>List of Invited Observers</th>
              <th colspan="6">Date of Receipt of Invitation</th>
              <th rowspan="2">Remarks</th>
            </tr>
            <tr>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td colspan="1">Pre-Proc Conference</td>
              <td colspan="1">Ads/Post of IB</td>
              <td colspan="1">Pre-bid Conf</td>
              <td colspan="1">Eligibility Check</td>
              <td colspan="1">Sub/Open of Bids</td>
              <td colspan="1">Bid Evaluation</td>
              <td colspan="1">Post Qual</td>
              <td colspan="1">Date of BAC Resolution Recommending Award</td>
              <td colspan="1">Notice of Award</td>
              <td colspan="1">Contract Signing</td>
              <td colspan="1">Notice to Proceed</td>
              <td colspan="1">Date of Posting to PhilGEPS (NOA)</td>
              <td colspan="1">Date of Posting to PhilGEPS (PO/CONTRACT)</td>
              <td colspan="1">Contract Review Date</td>
              <td colspan="1">Target Date of Completion</td>
              <td colspan="1">Delivery/ Completion</td>
              <td colspan="1">Inspection & Acceptance</td>
              <td colspan="1">Date of Contractors Evaluation Conducted</td>
              <td></td>
              <th>Total</th>
              <th>MOOE</th>
              <th>CO</th>
              <th>Total</th>
              <th>MOOE</th>
              <th>CO</th>
              <td></td>
              <th>Pre-bid Conf </th>
              <th>Eligibility Check </th>
              <th>Sub/Open of Bids </th>
              <th>Bid Evaluation </th>
              <th>Post Qual </th>
              <th>Delivery/Completion/Acceptance (If applicable) </th>
            </tr>
          </thead>
          <tbody>
            <tr ng-repeat="all_data in sp_pmr track by $index">
              <td ng-bind="all_data.status | uppercase"></td>
              <td>
                <span ng-if="all_data.sp.sp_groupings == 1">KKB</span>
                <span ng-if="all_data.sp.sp_groupings == 2">MAKILAHOK</span>
                <span ng-if="all_data.sp.sp_groupings == 3">NCDDP</span>
                <span ng-if="all_data.sp.sp_groupings == 4">IP CDD</span>
                <span ng-if="all_data.sp.sp_groupings == 5">CCL</span>
                <span ng-if="all_data.sp.sp_groupings == 6">LandE</span>
              </td>
              <td ng-bind="all_data.sp.sp_province | uppercase"></td>
              <td ng-bind="all_data.sp.sp_municipality | uppercase"></td>
              <td ng-bind="all_data.code"></td>
              <td ng-bind="all_data.sp.sp_title | uppercase"></td>
              <td ng-bind="all_data.sp.sp_brgy | uppercase"></td>
              <td ng-bind="all_data.sp.early_procurement_activity | uppercase"></td>
              <td ng-bind="all_data.mode_of_procurement"></td>
              <td>
                <span ng-if="all_data.apa_pre_proc_con == null"></span>
                <span ng-if="all_data.apa_pre_proc_con != null">
                  <span ng-bind="all_data.apa_pre_proc_con | date:'dd/MM/yy'"></span>
                </span>
              </td>
              <td>
                <span ng-if="all_data.apa_ads == 'Invalid Date'"></span>
                <span ng-if="all_data.apa_ads != 'Invalid Date'">
                  <span ng-bind="all_data.apa_ads | date:'dd/MM/yy'"></span>
                </span>
              </td>
              <td>
                <span ng-if="all_data.apa_prebid_con == 'Invalid Date'"></span>
                <span ng-if="all_data.apa_prebid_con != 'Invalid Date'">
                  <span ng-bind="all_data.apa_prebid_con | date:'dd/MM/yy'"></span>
                </span>
              </td>
              <td>
                <span ng-if="all_data.apa_eligibility_check == 'Invalid Date'"></span>
                <span ng-if="all_data.apa_eligibility_check != 'Invalid Date'">
                  <span ng-bind="all_data.apa_eligibility_check | date:'dd/MM/yy'"></span>
                </span>
              </td>
              <td>
                <span ng-if="all_data.apa_open_of_bids == 'Invalid Date'"></span>
                <span ng-if="all_data.apa_open_of_bids != 'Invalid Date'">
                  <span ng-bind="all_data.apa_open_of_bids | date:'dd/MM/yy'"></span>
                </span>
              </td>
              <td>
                <span ng-if="all_data.apa_bid_eval == 'Invalid Date'"></span>
                <span ng-if="all_data.apa_bid_eval != 'Invalid Date'">
                  <span ng-bind="all_data.apa_bid_eval | date:'dd/MM/yy'"></span>
                </span>
              </td>
              <td>
                <span ng-if="all_data.apa_post_qual == 'Invalid Date'"></span>
                <span ng-if="all_data.apa_post_qual != 'Invalid Date'">
                  <span ng-bind="all_data.apa_post_qual | date:'dd/MM/yy'"></span>
                </span>
              </td>
              <td>
                <span ng-if="all_data.bac_reso_recom_award == 'Invalid Date'"></span>
                <span ng-if="all_data.bac_reso_recom_award != 'Invalid Date'">
                  <span ng-bind="all_data.bac_reso_recom_award | date:'dd/MM/yy'"></span>
                </span>
              </td>
              <td>
                <span ng-if="all_data.apa_notice_of_award == 'Invalid Date'"></span>
                <span ng-if="all_data.apa_notice_of_award != 'Invalid Date'">
                  <span ng-bind="all_data.apa_notice_of_award | date:'dd/MM/yy'"></span>
                </span>
              </td>
              <td>
                <span ng-if="all_data.apa_contract_signing == 'Invalid Date'"></span>
                <span ng-if="all_data.apa_contract_signing != 'Invalid Date'">
                  <span ng-bind="all_data.apa_contract_signing | date:'dd/MM/yy'"></span>
                </span>
              </td>
              <td>
                <span ng-if="all_data.apa_notice_to_proceed == 'Invalid Date'"></span>
                <span ng-if="all_data.apa_notice_to_proceed != 'Invalid Date'">
                  <span ng-bind="all_data.apa_notice_to_proceed | date:'dd/MM/yy'"></span>
                </span>
              </td>

              <td>
                <span ng-if="all_data.date_of_posting_philgeps_noa == 'Invalid Date' && all_data.philgeps == false">N/A</span>
                <span ng-if="all_data.date_of_posting_philgeps_noa != 'Invalid Date' && all_data.philgeps == true">
                  <span ng-bind="all_data.date_of_posting_philgeps_noa | date:'dd/MM/yy'"></span>
                </span>
              </td>
              <td>
                <span ng-if="all_data.date_of_posting_philgeps_po_contract == 'Invalid Date' && all_data.philgeps == false">N/A</span>
                <span ng-if="all_data.date_of_posting_philgeps_po_contract != 'Invalid Date' && all_data.philgeps == true">
                  <span ng-bind="all_data.date_of_posting_philgeps_po_contract | date:'dd/MM/yy'"></span>
                </span>
              </td>

              <td>
                <span ng-if="all_data.apa_contract_review_date == 'Invalid Date'"></span>
                <span ng-if="all_data.apa_contract_review_date != 'Invalid Date'">
                  <span ng-bind="all_data.apa_contract_review_date | date:'dd/MM/yy'"></span>
                </span>
              </td>
              <td>
                <span ng-if="all_data.apa_target_date_completion == 'Invalid Date'"></span>
                <span ng-if="all_data.apa_target_date_completion != 'Invalid Date'">
                  <span ng-bind="all_data.apa_target_date_completion | date:'dd/MM/yy'"></span>
                </span>
              </td>  
              <td>
                <span ng-if="all_data.apa_delivery == 'Invalid Date'"></span>
                <span ng-if="all_data.apa_delivery != 'Invalid Date'">
                  <span ng-bind="all_data.apa_delivery | date:'dd/MM/yy'"></span>
                </span>
              </td>
              <td>
                <span ng-if="all_data.apa_acceptance == 'Invalid Date'"></span>
                <span ng-if="all_data.apa_acceptance != 'Invalid Date'">
                  <span ng-bind="all_data.apa_acceptance | date:'dd/MM/yy'"></span>
                </span>
              </td>
              <td>
                <span ng-if="all_data.apa_contractors_eval_conducted == 'Invalid Date'"></span>
                <span ng-if="all_data.apa_contractors_eval_conducted != 'Invalid Date'">
                  <span ng-bind="all_data.apa_contractors_eval_conducted | date:'dd/MM/yy'"></span>
                </span>
              </td>
              <td ng-bind="all_data.fund_source"></td>
              <td ng-bind="all_data.abc_total"></td>
              <td ng-bind="all_data.abc_mooe"></td>
              <td ng-bind="all_data.abc_co"></td>
              <td ng-bind="all_data.contract_cost_total"></td>
              <td ng-bind="all_data.contract_cost_mooe"></td>
              <td ng-bind="all_data.contract_cost_co"></td>
              <td ng-bind="all_data.list_of_invited"></td>
              <td>
                <span ng-if="all_data.io_prebid_con == 'Invalid Date'"></span>
                <span ng-if="all_data.io_prebid_con != 'Invalid Date'">
                  <span ng-bind="all_data.io_prebid_con | date:'dd/MM/yy'"></span>
                </span>
              </td>
              <td>
                <span ng-if="all_data.io_eligibility_check == 'Invalid Date'"></span>
                <span ng-if="all_data.io_eligibility_check != 'Invalid Date'">
                  <span ng-bind="all_data.io_eligibility_check | date:'dd/MM/yy'"></span>
                </span>
              </td>
              <td>
                <span ng-if="all_data.io_open_of_bids == 'Invalid Date'"></span>
                <span ng-if="all_data.io_open_of_bids != 'Invalid Date'">
                  <span ng-bind="all_data.io_open_of_bids | date:'dd/MM/yy'"></span>
                </span>
              </td>
              <td>
                <span ng-if="all_data.io_bid_eval == 'Invalid Date'"></span>
                <span ng-if="all_data.io_bid_eval != 'Invalid Date'">
                  <span ng-bind="all_data.io_bid_eval | date:'dd/MM/yy'"></span>
                </span>
              </td>
              <td>
                <span ng-if="all_data.io_post_qual == 'Invalid Date'"></span>
                <span ng-if="all_data.io_post_qual != 'Invalid Date'">
                  <span ng-bind="all_data.io_post_qual | date:'dd/MM/yy'"></span>
                </span>
              </td>
              <td>
                <span ng-if="all_data.delivery == 'Invalid Date'"></span>
                <span ng-if="all_data.delivery != 'Invalid Date'">
                  <span ng-bind="all_data.delivery | date:'dd/MM/yy'"></span>
                </span>
              </td>
              <td ng-bind="all_data.remarks | uppercase"></td>
            </tr>
          </tbody>
        </table>
    </div>   
  </div>
</div>
<!-- For Exporting from MODAL DATa -->







