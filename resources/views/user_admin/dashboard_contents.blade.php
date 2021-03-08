<!-- <div class="row  border-bottom white-bg dashboard-header">
    <div class="col-md-3">
        <h2>Hi {{Auth::user()->Fname}} {{Auth::user()->Lname}}</h2>
        <small>You have 42 messages and 6 notifications.</small>
        <ul class="list-group clear-list m-t">
            <li class="list-group-item fist-item">
                <span class="float-right">
                    09:00 pm
                </span>
                <span class="label label-success">1</span> Please contact me
            </li>
            <li class="list-group-item">
                <span class="float-right">
                    10:16 am
                </span>
                <span class="label label-info">2</span> Sign a contract
            </li>
            <li class="list-group-item">
                <span class="float-right">
                    08:22 pm
                </span>
                <span class="label label-primary">3</span> Open new shop
            </li>
            <li class="list-group-item">
                <span class="float-right">
                    11:06 pm
                </span>
                <span class="label label-default">4</span> Call back to Sylvia
            </li>
            <li class="list-group-item">
                <span class="float-right">
                    12:00 am
                </span>
                <span class="label label-primary">5</span> Write a letter to Sandra
            </li>
        </ul>
    </div>
    <div class="col-md-6">
        <div class="flot-chart dashboard-chart">
            <div class="flot-chart-content" id="flot-dashboard-chart"></div>
        </div>
        <div class="row text-left">
            <div class="col">
                <div class=" m-l-md">
                <span class="h5 font-bold m-t block">$ 406,100</span>
                <small class="text-muted m-b block">Sales marketing report</small>
                </div>
            </div>
            <div class="col">
                <span class="h5 font-bold m-t block">$ 150,401</span>
                <small class="text-muted m-b block">Annual sales revenue</small>
            </div>
            <div class="col">
                <span class="h5 font-bold m-t block">$ 16,822</span>
                <small class="text-muted m-b block">Half-year revenue margin</small>
            </div>

        </div>
    </div>
    <div class="col-md-3">
        <div class="statistic-box">
        <h4>
            Project Beta progress
        </h4>
        <p>
            You have two project with not compleated task.
        </p>
            <div class="row text-center">
                <div class="col-lg-6">
                    <canvas id="doughnutChart2" width="80" height="80" style="margin: 18px auto 0"></canvas>
                    <h5 >Kolter</h5>
                </div>
                <div class="col-lg-6">
                    <canvas id="doughnutChart" width="80" height="80" style="margin: 18px auto 0"></canvas>
                    <h5 >Maxtor</h5>
                </div>
            </div>
            <div class="m-t">
                <small>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</small>
            </div>

        </div>
    </div>

</div> -->


<style type="text/css">
  .card, .card .card-footer{
    border-radius: 0px;
  }

  .orange{
    color: #fdab14;
  }
</style>

<!-- DASHBOARD -->
<div class="row white-bg white-bg mt-3">
    <div class="col-lg-12">
        <div class="row">
          <div class="col-md-6">
            <h3 class="mb-0">Overall Weighted Percentage</h3>
            <ul class="list-group clear-list m-t">
              <li class="list-group-item">
                  <span> <span class="float-right text-danger" ng-if="weighted_ncddp_percetage == 0">NONE</span></span>
                  <span> <span class="float-right font-weight-bold" ng-if="weighted_ncddp_percetage > 0" ng-bind="weighted_ncddp_percetage + '%'"></span></span>
                  <span class="text-navy">
                      NCDDP
                  </span>
              </li>
              <li class="list-group-item">
                  <span> <span class="float-right text-danger" ng-if="weighted_ipccdd_percetage == 0">NONE</span></span>
                  <span> <span class="float-right font-weight-bold" ng-if="weighted_ipccdd_percetage > 0" ng-bind="weighted_ipccdd_percetage + '%'"></span></span>
                  <span class="text-navy">
                      IP CDD
                  </span>
              </li>
              <li class="list-group-item">
                  <span> <span class="float-right text-danger" ng-if="weighted_makilahok_percetage == 0">NONE</span></span>
                  <span> <span class="float-right font-weight-bold" ng-if="weighted_makilahok_percetage > 0" ng-bind="weighted_makilahok_percetage + '%'"></span></span>
                  <span class="text-navy">
                      MAKILAHOK
                  </span>
              </li>
               <li class="list-group-item">
                  <span> <span class="float-right text-danger" ng-if="weighted_kkb_percetage == 0">NONE</span></span>
                  <span> <span class="float-right font-weight-bold" ng-if="weighted_kkb_percetage > 0" ng-bind="weighted_kkb_percetage + '%'"></span></span>
                  <span class="text-navy">
                      KKB
                  </span>
              </li>
               <li class="list-group-item">
                  <span> <span class="float-right text-danger" ng-if="weighted_LandE_percetage == 0">NONE</span></span>
                  <span> <span class="float-right font-weight-bold" ng-if="weighted_LandE_percetage > 0" ng-bind="weighted_LandE_percetage + '%'"></span></span>
                  <span class="text-navy">
                      L&E
                  </span>
              </li>
              <li class="list-group-item">
                  <span> <span class="float-right text-danger" ng-if="weighted_ccl_percetage == 0">NONE</span></span>
                  <span> <span class="float-right font-weight-bold" ng-if="weighted_ccl_percetage > 0" ng-bind="weighted_ccl_percetage + '%'"></span></span>
                  <span class="text-navy">
                      CCL
                  </span>
              </li>
            </ul>
          </div>

          <hr>
          
          <div class="col-md-6 pt-2">
            <h3 class="font-weight-bold">Overall weighted Percentage Chart</h3>
            <canvas class="flot-chart-content" id="render_weighted_percentage_chart" style="height: 230px !important;"></canvas>
          </div>
        </div>
    </div>

    <div class="col-lg-12">
        <div class="row">
          <div class="col-lg-6">
            <h3 class="font-weight-bold">NYS vs On-going vs Completed</h3>
            <div class="table-responsive">
              <table class="table table-bordered table-sm">
                <thead style="cursor: pointer;">
                  <tr>
                    <th class="bg-danger">
                      <h4 class="text-light">MODALITY</h4>
                    </th>
                    <th class="bg-danger">
                      <h4 class="text-light">NYS</h4>
                    </th>
                    <th class="bg-warning">
                      <h4 class="text-light">On-going</h4>
                    </th>
                    <th class="bg-success">
                      <h4 class="text-light">Completed</h4>
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>NCDDP</td>
                    <td>
                      <span> <span class="float-right" ng-if="nys[3] == undefined">NONE</span></span>
                      <span> <span class="float-right font-weight-bold" ng-if="nys[3] != undefined" ng-bind="nys[3].length"></span></span>
                    </td>
                    <td>
                      <span> <span class="float-right" ng-if="ongoing[3] == undefined">NONE</span></span>
                      <span> <span class="float-right font-weight-bold" ng-if="ongoing[3] != undefined" ng-bind="ongoing[3].length"></span></span>
                    </td>
                    <td>
                      <span> <span class="float-right" ng-if="completed[3] == undefined">NONE</span></span>
                      <span> <span class="float-right font-weight-bold" ng-if="completed[3] != undefined" ng-bind="completed[3].length"></span></span>
                    </td>
                  </tr>
                  <tr>
                    <td>IP CDD</td>
                    <td>
                      <span> <span class="float-right" ng-if="nys[4] == undefined">NONE</span></span>
                      <span> <span class="float-right font-weight-bold" ng-if="nys[4] != undefined" ng-bind="nys[4].length"></span></span>
                    </td>
                    <td>
                      <span> <span class="float-right" ng-if="ongoing[4] == undefined">NONE</span></span>
                      <span> <span class="float-right font-weight-bold" ng-if="ongoing[4] != undefined" ng-bind="ongoing[4].length"></span></span>
                    </td>
                    <td>
                      <span> <span class="float-right" ng-if="completed[4] == undefined">NONE</span></span>
                      <span> <span class="float-right font-weight-bold" ng-if="completed[4] != undefined" ng-bind="completed[4].length"></span></span>
                    </td>
                  </tr>
                  <tr>
                    <td>MAKILAHOK</td>
                    <td>
                      <span> <span class="float-right" ng-if="nys[2] == undefined">NONE</span></span>
                      <span> <span class="float-right font-weight-bold" ng-if="nys[2] != undefined" ng-bind="nys[2].length"></span></span>
                    </td>
                    <td>
                      <span> <span class="float-right" ng-if="ongoing[2] == undefined">NONE</span></span>
                      <span> <span class="float-right font-weight-bold" ng-if="ongoing[2] != undefined" ng-bind="ongoing[2].length"></span></span>
                    </td>
                    <td>
                      <span> <span class="float-right" ng-if="completed[2] == undefined">NONE</span></span>
                      <span> <span class="float-right font-weight-bold" ng-if="completed[2] != undefined" ng-bind="completed[2].length"></span></span>
                    </td>
                  </tr>
                  <tr>
                    <td>KKB</td>
                    <td>
                      <span> <span class="float-right" ng-if="nys[1] == undefined">NONE</span></span>
                      <span> <span class="float-right font-weight-bold" ng-if="nys[1] != undefined" ng-bind="nys[1].length"></span></span>
                    </td>
                    <td>
                      <span> <span class="float-right" ng-if="ongoing[1] == undefined">NONE</span></span>
                      <span> <span class="float-right font-weight-bold" ng-if="ongoing[1] != undefined" ng-bind="ongoing[1].length"></span></span>
                    </td>
                    <td>
                      <span> <span class="float-right" ng-if="completed[1] == undefined">NONE</span></span>
                      <span> <span class="float-right font-weight-bold" ng-if="completed[1] != undefined" ng-bind="completed[1].length"></span></span>
                    </td>
                  </tr>
                  <tr>
                    <td>L&E</td>
                    <td>
                      <span> <span class="float-right" ng-if="nys[6] == undefined">NONE</span></span>
                      <span> <span class="float-right font-weight-bold" ng-if="nys[6] != undefined" ng-bind="nys[6].length"></span></span>
                    </td>
                    <td>
                      <span> <span class="float-right" ng-if="ongoing[6] == undefined">NONE</span></span>
                      <span> <span class="float-right font-weight-bold" ng-if="ongoing[6] != undefined" ng-bind="ongoing[6].length"></span></span>
                    </td>
                    <td>
                      <span> <span class="float-right" ng-if="completed[6] == undefined">NONE</span></span>
                      <span> <span class="float-right font-weight-bold" ng-if="completed[6] != undefined" ng-bind="completed[6].length"></span></span>
                    </td>
                  </tr> 
                  <tr>
                    <td>CCL</td>
                    <td>
                      <span> <span class="float-right" ng-if="nys[5] == undefined">NONE</span></span>
                      <span> <span class="float-right font-weight-bold" ng-if="nys[5] != undefined" ng-bind="nys[5].length"></span></span>
                    </td>
                    <td>
                      <span> <span class="float-right" ng-if="ongoing[5] == undefined">NONE</span></span>
                      <span> <span class="float-right font-weight-bold" ng-if="ongoing[5] != undefined" ng-bind="ongoing[5].length"></span></span>
                    </td>
                    <td>
                      <span> <span class="float-right" ng-if="completed[6] == undefined">NONE</span></span>
                      <span> <span class="float-right font-weight-bold" ng-if="completed[6] != undefined" ng-bind="completed[6].length"></span></span>
                    </td>
                  </tr>  
                </tbody>
              </table>
            </div>
          </div>

          <div class="col-md-6 pt-2">
            <canvas class="flot-chart-content" id="render_sp_status_data" style="height: 190px !important;"></canvas>
          </div>
        </div>
    </div>
</div>

<!-- Averages -->
<div class="row white-bg">
    <div class="col-lg-3 my-5">
        <h5>Total On-going Subprojects</h5>
        <h1 class="no-margins"> <span ng-bind="Count_On_going_sp | number:0"></span> <span> SP's</span> </h1>
    </div>

    <div class="col-lg-3 my-5">
        <h5>Total Completed Subprojects (2020)</h5>
        <h1 class="no-margins"> <span ng-bind="Count_Completed_sp | number:0"></span> <span> SP's</span> </h1>
    </div>

    <div class="col-lg-3 my-5">
        <h5>Avg. Actual Days of Completion (2020)</h5>
        <h1 class="no-margins"> <span ng-bind="Average_Actual_Days_Completion | number:0"></span> <span> Days</span> </h1>
    </div>

    <div class="col-lg-3 my-5">
        <h5>Avg. Estimated Days of Completion (2020)</h5>
        <h1 class="no-margins"> <span ng-bind="Average_Est_Days_Completion | number:0"></span> <span> Days</span> </h1>
    </div>
</div>

<div class="row white-bg dashboard-header">
    <div class="col-md-9 pl-0" >
      <h3 class="mb-0">Latest updated subproject</h3>
      <p class="mt-0 py-0" style="font-size: .8em;" ng-bind="latest_sp.updated_at | date:'fullDate'" ></p>        
      <div class="flot-chart dashboard-chart">
          <canvas class="flot-chart-content" id="myChart"></canvas>
      </div>
      <div class="row text-left">
          <div class="col" style="color: #fd7e14;">
              <span ng-show="$last" ng-repeat="data in sp_logs.sp_logs track by $index" ng-bind="data.sp_logs_planned" class="h5 font-bold block">100.00%</span>
              <small class="text-muted m-b block">Plan (Current)</small>
          </div>            
          <div class="col" style="color: #2196f3;">
              <span ng-show="$last" ng-repeat="data in sp_logs.sp_logs track by $index" ng-bind="data.sp_logs_actual" class="h5 font-bold block">100.00%</span>
              <small class="text-muted m-b block">Actual (Current)</small>
          </div>
          <div class="col" style="color: #dc3545;">
              <span ng-show="$last" ng-repeat="data in sp_logs.sp_logs track by $index" ng-bind="data.sp_logs_slippage" class="h5 font-bold block">0.00%</span>
              <small class="text-muted m-b block">Slippage (Current)</small>
          </div>
      </div>
    </div>
    <div class="col-md-3 pl-0">
        <div class="statistic-box">
          <label class="text-navy" style="margin-bottom: 0px;"> <small class="font-weight-bold">SP Title</small> </label>
          <p ng-bind="latest_sp.sp_title"> </p>
          <label class="text-navy" style="margin-bottom: 0px;"> <small class="font-weight-bold">MODALITY | Assigned Focal</small> </label>
          <p> <span ng-bind="latest_sp.sp_groupings.grouping">IP CDD</span> : 
            <span ng-repeat="x in latest_sp.sp_groupings.assigned_grouping">
              <span ng-bind="x.users.Fname +' '+ x.users.Lname"></span>,
            </span>
          </p>
          <label class="text-navy" style="margin-bottom: 0px;"> <small class="font-weight-bold">Assigned DAC</small> </label>
          <p>
            <span ng-repeat="x in latest_sp.assigned_sp">
              <span ng-bind="x.users[0].Fname +' '+ x.users[0].Lname"></span>,
            </span>
          </p>
          <label class="text-navy" style="margin-bottom: 0px;"> <small class="font-weight-bold">PMR LOTS</small> </label>
          <p ng-bind="latest_sp.sp_pmr.length"></p>
        </div>
    </div>
</div>

