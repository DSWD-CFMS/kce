@extends('layouts.dashboard')

@section('content')
<style type="text/css">
  .card, .card .card-footer{
    border-radius: 0px;
  }

  .orange{
    color: #fdab14;
  }

/*uploads css*/
input[type=file] {
  cursor: pointer;
  width: 100%;
  height: 42px;
  overflow: hidden;
  color:transparent;
}

input[type=file]:before {
  width: 100%;
  height: 42px;
  font-size: 16px;
  color:#007bff;
  line-height: 32px;
  content: 'Select files to be uploaded';
  display: inline-block;
  background: white;
  border: 2px solid #007bff;
  border-radius: 26px;
  text-align: center;
  font-family: Helvetica, Arial, sans-serif;
}

input[type=file]::-webkit-file-upload-button {
  visibility: hidden !important;
}

.bd-placeholder-img{
  object-fit: cover;
}


</style>

<div id="page-wrapper" class="gray-bg dashbard-1" ng-init="fetch_procurement_dashboard()">
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
    </nav>
  </div>

  <!-- DASHBOARD -->
  <div class="wrapper wrapper-content">
    <div class="row">
      <div class="col-lg-3">
          <div class="ibox shadow-sm">
              <div class="ibox-title">
                  <span class="label label-success float-right">ON-GOING</span>
                  <h6 class="font-weight-bold">PMR</h6>
              </div>
              <div class="ibox-content">
                  <h1 class="no-margins" ng-bind="pmr_pending">40 886,200</h1>
                  @verbatim
                  <div class="stat-percent font-bold text-success">
                    {{pmr_pending/(pmr_pending+pmr_for_update+pmr_approved)*100 | number:2}}%
                  </div>
                  @endverbatim
                  <small>On-going PMR's</small>
              </div>
          </div>
      </div>
      <div class="col-lg-3">
          <div class="ibox shadow-sm">
              <div class="ibox-title">
                  <span class="label label-info float-right">COMPLETED</span>
                  <h6 class="font-weight-bold">PMR</h6>
              </div>
              <div class="ibox-content">
                  <h1 class="no-margins" ng-bind="pmr_approved">275,800</h1>
                  @verbatim
                  <div class="stat-percent font-bold text-info">
                    {{pmr_approved/(pmr_pending+pmr_for_update+pmr_approved)*100 | number:2}}%
                  </div>
                  @endverbatim
                  <small>Completed PMR's</small>
              </div>
          </div>
      </div>
      <div class="col-lg-3">
          <div class="ibox shadow-sm">
              <div class="ibox-title">
                  <span class="label label-primary float-right">FOR UPDATE</span>
                  <h6 class="font-weight-bold">PMR</h6>
              </div>
              <div class="ibox-content">
                  <h1 class="no-margins" ng-bind="pmr_for_update">106,120</h1>
                  @verbatim
                  <div class="stat-percent font-bold text-navy">
                    {{pmr_for_update/(pmr_pending+pmr_for_update+pmr_approved)*100 | number:2}}%
                  </div>
                  @endverbatim
                  <small>For Updates PMR's</small>
              </div>
          </div>
      </div>
      <div class="col-lg-3">
          <div class="ibox shadow-sm">
              <div class="ibox-title">
                  <span class="label label-danger float-right">TOTAL PMR (LOTs)</span>
                  <h5>PMR</h5>
              </div>
              <div class="ibox-content">
                  <h1 class="no-margins" ng-bind="(pmr_pending+pmr_for_update+pmr_approved)">80,600</h1>
                  @verbatim
                  <div class="stat-percent font-bold text-danger">
                    {{(pmr_pending+pmr_for_update+pmr_approved)/(pmr_pending+pmr_for_update+pmr_approved)*100 | number:2}}%
                  </div>
                  @endverbatim
                  <small>Total PMR's</small>
              </div>
          </div>
      </div>
    </div>  

    <div class="row">

      <div class="col-lg-5">
          <div class="ibox shadow-sm">
            <div class="ibox-title">
                <span class="label label-success float-right">LATEST UPDATED</span>
                <h6 class="font-weight-bold">PMR</h6>
            </div>
            <div class="ibox-content">
              <div ng-if="latest_pmr.length == 0" class="row" ng-cloak>
                <div class="col">
                  <div class="row">
                    <div class="col">
                      <h5 class="font-weight-bold"> <span class="text-warning">SP ID</span></h5>
                        <p class="text-danger">No data found</p>
                    </div>
                    <div class="col">
                      <h5 class="font-weight-bold"> <span class="text-warning">Status</span></h5>
                        <p class="text-danger">No data found</p>
                    </div>
                  </div>
                      <h5 class="font-weight-bold"> <span class="text-warning">Title</span></h5>
                        <p class="text-danger">No data found</p>

                  <div class="row mb-3">
                    <div class="col-lg-6">
                      <h5 class="font-weight-bold text-warning"> Mode of Procurement </h5>
                        <p class="text-danger">No data found</p>
                    </div>
                    <div class="col-lg-6">
                      <h5 class="font-weight-bold text-warning"> Nature of Procurement </h5>
                        <p class="text-danger">No data found</p>
                    </div>
                    <div class="col-lg-6">
                      <h5 class="font-weight-bold text-warning"> Code </h5>
                        <p class="text-danger">No data found</p>
                    </div>
                    <div class="col-lg-6">
                      <h5 class="font-weight-bold text-warning"> Mode of Procurement </h5>
                        <p class="text-danger">No data found</p>
                    </div>
                  </div>
                  
                  <hr>

                  <h5 class="font-weight-bold text-warning"> Latest Comments </h5>
                  <p class="text-danger">No Comments</p>
                  <div class="row" ng-repeat="data in latest_pmr[0].sp_pmr_logs" ng-if="latest_pmr[0].sp_pmr_logs.length > 0">
                    <div class="col-lg-10 border-bottom py-1" ng-bind="data.pmr_comments"></div>
                    <div class="col-lg-2 border-bottom py-1" ng-class="{'text-green' : data.status == 'Complied', 'text-warning': data.status == 'For Update', 'text-info' : data.status == 'Pending'}" ng-bind="data.status"></div>
                  </div>
                </div>
              </div>
              <div ng-if="latest_pmr.length > 0" class="row" ng-cloak>
                <div class="col">
                  <div class="row">
                    <div class="col">
                      <h5 class="font-weight-bold"> <span class="text-warning">SP ID</span></h5>
                      <span ng-bind="latest_pmr[0].sp_id"></span>
                    </div>
                    <div class="col">
                      <h5 class="font-weight-bold"> <span class="text-warning">Status</span></h5>
                      <span ng-bind="latest_pmr[0].status"></span>
                    </div>
                  </div>
                      <h5 class="font-weight-bold"> <span class="text-warning">Title</span></h5>
                  <h3 class="font-weight-normal" ng-bind="latest_pmr[0].sp.sp_title">Product Development and Marketing of Rattan Handicrafts</h3>

                  <div class="row mb-3">
                    <div class="col-lg-6">
                      <h5 class="font-weight-bold text-warning"> Mode of Procurement </h5>
                      <p class="my-0" ng-bind="latest_pmr[0].mode_of_procurement"> PUBLIC BIDDING FOR GOODS </p>
                    </div>
                    <div class="col-lg-6">
                      <h5 class="font-weight-bold text-warning"> Nature of Procurement </h5>
                      <p class="my-0" ng-bind="latest_pmr[0].nature_of_procurement"> PUBLIC BIDDING FOR GOODS </p>
                    </div>
                    <div class="col-lg-6">
                      <h5 class="font-weight-bold text-warning"> Code </h5>
                      <p class="my-0" ng-bind="latest_pmr[0].code"> Lot 2 </p>
                    </div>
                    <div class="col-lg-6">
                      <h5 class="font-weight-bold text-warning"> Mode of Procurement </h5>
                      <p class="my-0" ng-bind="latest_pmr[0].mode_of_procurement"> PUBLIC BIDDING FOR GOODS </p>
                    </div>
                  </div>
                  
                  <hr>

                  <h5 class="font-weight-bold text-warning"> Latest Comments </h5>
                  <p class="text-danger">No Comments</p>
                  <div class="row" ng-repeat="data in latest_pmr[0].sp_pmr_logs" ng-if="latest_pmr[0].sp_pmr_logs.length > 0">
                    <div class="col-lg-10 border-bottom py-1" ng-bind="data.pmr_comments"></div>
                    <div class="col-lg-2 border-bottom py-1" ng-class="{'text-green' : data.status == 'Complied', 'text-warning': data.status == 'For Update', 'text-info' : data.status == 'Pending'}" ng-bind="data.status"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
      </div>

      <div class="col-lg-4">
          <div class="ibox shadow-sm">
            <div class="ibox-title">
                <!-- <span class="label label-success float-right">LATEST EVENTS</span> -->
                <h6 class="font-weight-bold">LATEST EVENTS CONDUCTED</h6>
            </div>
            <div class="ibox-content">
              <div class="row" ng-if="pmr_logs_events.length == 0" style="height: 295px; overflow:auto;">
                <div class="col">
                  <p class="text-danger">No data found</p>
                </div>
              </div>

              <div class="row" style="height: 295px; overflow:auto;">
                <table class="table table-bordered">
                 <thead class="thead-dark">
                   <tr>
                     <th>Date</th>
                     <th>Event</th>
                   </tr>
                 </thead>
                  <tbody>
                    <tr ng-repeat="data in pmr_logs_events">
                      <td ng-bind="data.created_at | date:'short'"></td>
                      <!-- <td ng-bind="data.updated_field"> -->
                      <td>
                        <small ng-if="data.updated_field == 'apa_bid_eval'">
                          ACTUAL PROCUREMENT ACTIVITY - BID EVALUATION
                        </small>

                        <small ng-if="data.updated_field == 'apa_ads'">
                          ACTUAL PROCUREMENT ACTIVITY - ADS/POST OF IB
                        </small>

                        <small ng-if="data.updated_field == 'apa_target_date_completion'">
                          ACTUAL PROCUREMENT ACTIVITY - TARGET OF DATE COMPLETION
                        </small>

                        <small ng-if="data.updated_field == 'apa_acceptance'">
                          ACTUAL PROCUREMENT ACTIVITY - INSPECTION AND ACCEPTANCE
                        </small>

                        <small ng-if="data.updated_field == 'apa_contractors_eval_conducted'">
                          ACTUAL PROCUREMENT ACTIVITY - CONTRACTORS EVAILUATION CONDUCTED
                        </small>

                        <small ng-if="data.updated_field == 'bac_reso_recom_award'">
                          ACTUAL PROCUREMENT ACTIVITY - BAC RESOLUTION RECOMMENDING AWARD
                        </small>

                        <small ng-if="data.updated_field == 'apa_contract_review_date'">
                          ACTUAL PROCUREMENT ACTIVITY - CONTRACT REVIEW
                        </small>
                        <small ng-if="data.updated_field == 'apa_contract_signing'">
                          ACTUAL PROCUREMENT ACTIVITY - CONTRACT SIGNING
                        </small>
                        <small ng-if="data.updated_field == 'apa_delivery'">
                          ACTUAL PROCUREMENT ACTIVITY - DELIVERY/COMPLETION
                        </small>
                        <small ng-if="data.updated_field == 'apa_eligibility_check'">
                          ACTUAL PROCUREMENT ACTIVITY - ELIGIBILITY CHECK
                        </small>
                        <small ng-if="data.updated_field == 'apa_notice_of_award'">
                          ACTUAL PROCUREMENT ACTIVITY - NOTICE OF AWARD
                        </small>
                        <small ng-if="data.updated_field == 'apa_notice_to_proceed'">
                          ACTUAL PROCUREMENT ACTIVITY - NOTICE TO PROCEED
                        </small>
                        <small ng-if="data.updated_field == 'apa_open_of_bids'">
                          ACTUAL PROCUREMENT ACTIVITY - OPEN OF BIDS
                        </small>
                        <small ng-if="data.updated_field == 'apa_post_qual'">
                          ACTUAL PROCUREMENT ACTIVITY - POST QUAL
                        </small>
                        <small ng-if="data.updated_field == 'apa_pre_proc_con'">
                          ACTUAL PROCUREMENT ACTIVITY - PRE-PROC CONFERENCE
                        </small>
                        <small ng-if="data.updated_field == 'apa_prebid_con'">
                          ACTUAL PROCUREMENT ACTIVITY - PRE-BID CONFERENCE
                        </small>
                        <small ng-if="data.updated_field == 'apa_target_date_of_completion'">
                          ACTUAL PROCUREMENT ACTIVITY - TARGET DATE OF COMPLETION
                        </small>
                        <small ng-if="data.updated_field == 'date_contractors_eval_conducted'">
                          ACTUAL PROCUREMENT ACTIVITY - CONTRACTORS EVALUATION CONDUCTED
                        </small>
                        <small ng-if="data.updated_field == 'delivery'">
                          INVITATION OF OBSERVERS - DELIVERY/COMPLETION
                        </small>
                        <small ng-if="data.updated_field == 'io_bid_eval'">
                          INVITATION OF OBSERVERS - BID EVALUATION
                        </small>
                        <small ng-if="data.updated_field == 'io_eligibility_check'">
                          INVITATION OF OBSERVERS - ELIGIBILITY CHECK
                        </small>
                        <small ng-if="data.updated_field == 'io_open_of_bids'">
                          INVITATION OF OBSERVERS - OPEN OF BIDS
                        </small>
                        <small ng-if="data.updated_field == 'io_post_qual'">
                          INVITATION OF OBSERVERS - POST QUAL
                        </small>
                        <small ng-if="data.updated_field == 'io_prebid_con'">
                          INVITATION OF OBSERVERS - BPRE-BID CONFERENCE
                        </small>
                      </td>
                    </tr>                    
                  </tbody>
                </table>
              </div>
            </div>
          </div>
      </div>
      
      <div class="col-lg-3">
          <div class="ibox shadow-sm">
            <div class="ibox-title">
                <!-- <span class="label label-success float-right">LATEST UPDATED</span> -->
                <h6 class="font-weight-bold">SUB-PROJECT IMPLEMENTATION | (NCDDP,IP CDD)</h6>
            </div>
            
            <div class="ibox-content" style="height: 350px !important;">
              <div class="row">
                <div class="col-lg-12 border-bottom">
                  <div class="widget rounded-0">
                      <div class="row">
                          <div class="col-4">
                              <i class="fa fa-clipboard fa-3x"></i>
                          </div>
                          <div class="col-8 text-right">
                              <small> NYS </small>
                              <h3 class="font-bold" ng-bind="nys_count"></h3>
                          </div>
                      </div>
                  </div>
                </div>

                <div class="col-lg-12 border-bottom">
                  <div class="widget rounded-0">
                      <div class="row">
                          <div class="col-4">
                              <i class="fa fa-spinner fa-3x"></i>
                          </div>
                          <div class="col-8 text-right">
                              <small> ON-GOING </small>
                              <h3 class="font-bold" ng-bind="ongoing_count"></h3>
                          </div>
                      </div>
                  </div>
                </div>

                <div class="col-lg-12">
                  <div class="widget rounded-0">
                      <div class="row">
                          <div class="col-4">
                              <i class="fa fa-certificate fa-3x"></i>
                          </div>
                          <div class="col-8 text-right">
                              <small> COMPLETED </small>
                              <h3 class="font-bold" ng-bind="completed_count"></h3>
                          </div>
                      </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
      </div>

    </div>  
</div>

<div class="modal inmodal fade" id="exampleModal" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header py-2 px-3">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            </div>
      		<div class="modal-body">
        		<p class="modal-title" id="exampleModalLabel">Ready to Leave?</p>
      			<h5>
      				Select "Sign out" below if you are ready to end your current session.
      			</h5>
      		</div>
	      <div class="modal-footer">
			<button class="btn btn-white" type="button" data-dismiss="modal">Cancel</button>
	        <a class="btn btn-primary" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"> Sign out</a>
	    	<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
	      		@csrf
	    	</form>
	      </div>
        </div>
    </div>
</div>
@endsection