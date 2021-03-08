@extends('layouts.admin_rcis_dashboard')

@section('content')
<style type="text/css">
  .card, .card .card-footer{
    border-radius: 0px;
  }

  .orange{
    color: #fdab14;
  }
</style>

<!-- SUMMARY -->
<div id="page-wrapper" class="gray-bg dashbard-1" ng-init="show_summary();show_profile()">
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
  
  <div class="row justify-content-end wrapper border-bottom white-bg page-heading animated fadeInRight" >
    <div class="col-lg-8">
          <h2> Summary </h2>
          <ol class="breadcrumb">
              <li class="breadcrumb-item">
                  <a href="{{ url('/home') }}" >Home</a>
              </li>
              <li class="breadcrumb-item">
                  <strong> Summary </strong>
              </li>
          </ol>
    </div>

    <div class="col-lg-4 text-center pt-5">
      <div class="input-group">
        <a class="btn btn-outline-secondary rounded-0" href="{{ url('/admin_rcis/routes/summary') }}"> <i class="fa fa-refresh"></i> </a>
        <div class="input-group-prepend">
          <button class="btn btn-outline-primary rounded-0" type="button" ng-click="export_to_pdf()"> Export Data <i class="fa fa-share"></i></button>
        </div>
          <button class="btn btn-outline-warning rounded-0" data-target="#datasets_modal" data-toggle="modal" type="button"> Choose Data Sets <i class="fa fa-database"></i></button>
      </div>
    </div>
  </div>

    <div class="wrapper wrapper-content animated fadeInRight ecommerce px-0 pb-0" id="exportthis">
    <div class="row">
            <div class="col-lg-8">
                <div class="table-responsive">
                  <table class="table table-bordered">
                    <thead class="thead-light">
                      <th>Jan</th>
                      <th>Feb</th>
                      <th>Mar</th>
                      <th>Apr</th>
                      <th>May</th>
                      <th>Jun</th>
                      <th>Jul</th>
                      <th>Aug</th>
                      <th>Sept</th>
                      <th>Oct</th>
                      <th>Nov</th>
                      <th>Dec</th>
                    </thead>
                    <tbody>
                      <tr class="bg-warning">
                        <th colspan="12" class="py-1">
                          <label class="font-weight-bold mb-0">Target Completion</label>
                        </th>
                      </tr>
                      <tr class="bg-warning">
                        <td ng-bind="target_per_month.January[0]"></td>
                        <td ng-bind="target_per_month.Feruary[0]"></td>
                        <td ng-bind="target_per_month.March[0]"></td>
                        <td ng-bind="target_per_month.April[0]"></td>
                        <td ng-bind="target_per_month.May[0]"></td>
                        <td ng-bind="target_per_month.June[0]"></td>
                        <td ng-bind="target_per_month.July[0]"></td>
                        <td ng-bind="target_per_month.August[0]"></td>
                        <td ng-bind="target_per_month.September[0]"></td>
                        <td ng-bind="target_per_month.October[0]"></td>
                        <td ng-bind="target_per_month.November[0]"></td>
                        <td ng-bind="target_per_month.December[0]"></td>
                      </tr>
                      <tr class="bg-primary text-light">
                        <th colspan="12" class="py-1">
                          <label class="font-weight-bold mb-0">Actual Completion</label>
                        </th>
                      </tr>
                      <tr class="bg-primary text-light">
                        <td ng-bind="actual_per_month.January[0]"></td>
                        <td ng-bind="actual_per_month.Feruary[0]"></td>
                        <td ng-bind="actual_per_month.March[0]"></td>
                        <td ng-bind="actual_per_month.April[0]"></td>
                        <td ng-bind="actual_per_month.May[0]"></td>
                        <td ng-bind="actual_per_month.June[0]"></td>
                        <td ng-bind="actual_per_month.July[0]"></td>
                        <td ng-bind="actual_per_month.August[0]"></td>
                        <td ng-bind="actual_per_month.September[0]"></td>
                        <td ng-bind="actual_per_month.October[0]"></td>
                        <td ng-bind="actual_per_month.November[0]"></td>
                        <td ng-bind="actual_per_month.December[0]"></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
            </div> <!-- col 6 -->

            <div class="col-lg-4">
                <div class="ibox ">
                    <div class="ibox-title">
                      Actual Completion Count / Month
                    </div>
                    <div class="ibox-content" id="highest_completion_month">
                      <h1 style="font-size:6vw;" class="font-weight-bold my-0 py-0" ng-bind="max_actual[0]">1,431</h1>

                      <h3 class="my-0 py-0" ng-bind="month_highest[0]"></h3>
                    </div>
                </div>
            </div> <!-- col 3 -->

            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h3 class="mb-0">Completed vs On-going vs NYS</h3>
                    </div>
                    <div class="ibox-content">
                      <div class="row">
                        <div class="col-lg-12">
                          <label> Completed </label>
                          <div class="row">
<!--                             <div class="col">
                              <label> <small class="font-weight-bold" style="color:#1ab394;"> KKB </small> </label>
                              <br>
                              <b style="font-size:2em;" ng-bind="Completed_per_grouping[1][0] | number:0"></b> <b style="font-size:2em;" ng-if="Completed_per_grouping[1][0] == null"></b> <span>SUBPROJECTS</span>
                            </div> -->

<!--                             <div class="col">
                              <label> <small class="font-weight-bold" style="color:#1ab394;"> MAKILAHOK </small> </label>
                              <br>
                                        <b style="font-size:2em;" ng-bind="Completed_per_grouping[2][0] | number:0"></b> <b style="font-size:2em;" ng-if="Completed_per_grouping[2][0] == null"></b> <span>SUBPROJECTS</span>
                            </div> -->
                            <div class="col">
                              <label> <small class="font-weight-bold" style="color:#1ab394;"> NCDDP </small> </label>
                              <br>
                                        <b style="font-size:2em;" ng-bind="Completed_per_grouping[3][0] | number:0"></b>
                                        <b style="font-size:2em;" ng-if="Completed_per_grouping[3][0] == null">0</b>
                                        <span>SUBPROJECTS</span>
                            </div>
                            <div class="col">
                              <label> <small class="font-weight-bold" style="color:#1ab394;"> IP CDD </small> </label>
                              <br>
                                        <b style="font-size:2em;" ng-bind="Completed_per_grouping[4][0] | number:0"></b>
                                        <b style="font-size:2em;" ng-if="Completed_per_grouping[4][0] == null">0</b>
                                        <span>SUBPROJECTS</span>
                            </div>
<!--                             <div class="col">
                              <label> <small class="font-weight-bold" style="color:#1ab394;"> CCL </small> </label>
                              <br>
                                        <b style="font-size:2em;" ng-bind="Completed_per_grouping[5][0] | number:0"></b> <b style="font-size:2em;" ng-if="Completed_per_grouping[5][0] == null"></b> <span>SUBPROJECTS</span>
                            </div>
                            <div class="col">
                                <label> <small class="font-weight-bold" style="color:#1ab394;"> L&E </small> </label>
                                <br>
                                <b style="font-size:2em;" ng-bind="Completed_per_grouping[6][0] | number:0"></b> <b style="font-size:2em;" ng-if="Completed_per_grouping[6][0] == null"></b> <span>SUBPROJECTS</span>
                            </div> -->
                          </div>
                          <hr>
                        </div>
                        <div class="col-lg-12">
                          <label> On-going </label>
                                <div class="row">
<!--                                     <div class="col">
                                        <label> <small class="font-weight-bold" style="color:#1ab394;"> KKB </small> </label>
                                        <br>
                                        <b style="font-size:2em;" ng-bind="Ongoing_per_grouping[1][0] | number:0"></b> <b style="font-size:2em;" ng-if="Ongoing_per_grouping[1][0] == null">0</b> <span>SUBPROJECTS</span>
                                    </div> -->

<!--                                     <div class="col">
                                        <label> <small class="font-weight-bold" style="color:#1ab394;"> MAKILAHOK </small> </label>
                                        <br>
                                        <b style="font-size:2em;" ng-bind="Ongoing_per_grouping[2][0] | number:0"></b> <b style="font-size:2em;" ng-if="Ongoing_per_grouping[1][0] == null">0</b> <span>SUBPROJECTS</span>
                                    </div> -->
                                    <div class="col">
                                        <label> <small class="font-weight-bold" style="color:#1ab394;"> NCDDP </small> </label>
                                        <br>
                                        <b style="font-size:2em;" ng-bind="Ongoing_per_grouping[3][0] | number:0"></b>
                                        <b style="font-size:2em;" ng-if="Ongoing_per_grouping[3][0] == null">0</b>
                                        <span>SUBPROJECTS</span>
                                    </div>
                                    <div class="col">
                                        <label ng-if="summary_modal == false"> <small class="font-weight-bold" style="color:#1ab394;"> IP CDD (2018 & 2020) </small> </label>

                                        <label ng-if="summary_modal == true"> <small class="font-weight-bold" style="color:#1ab394;"> IP CDD </small> </label>
                                        <br>
                                        <b style="font-size:2em;" ng-bind="Ongoing_per_grouping[4][0] | number:0"></b> <b style="font-size:2em;" ng-if="Ongoing_per_grouping[4][0] == null">0</b> <span>SUBPROJECTS</span>
                                    </div>
<!--                                     <div class="col">
                                        <label> <small class="font-weight-bold" style="color:#1ab394;"> CCL </small> </label>
                                        <br>
                                        <b style="font-size:2em;" ng-bind="Ongoing_per_grouping[5][0] | number:0"></b> <b style="font-size:2em;" ng-if="Ongoing_per_grouping[1][0] == null">0</b> <span>SUBPROJECTS</span>
                                    </div>
                                    <div class="col">
                                        <label> <small class="font-weight-bold" style="color:#1ab394;"> L&E </small> </label>
                                        <br>
                                        <b style="font-size:2em;" ng-bind="Ongoing_per_grouping[6][0] | number:0"></b> <b style="font-size:2em;" ng-if="Ongoing_per_grouping[1][0] == null">0</b> <span>SUBPROJECTS</span>
                                    </div> -->
                                </div>
                          <hr>
                        </div>
                        <div class="col-lg-12">
                          <label> NYS </label>
                                <div class="row">
<!--                                     <div class="col">
                                        <label> <small class="font-weight-bold" style="color:#1ab394;"> KKB </small> </label>
                                        <br>
                                        <b style="font-size:2em;" ng-bind="NYS_per_grouping[1][0] | number:0"></b> <b style="font-size:2em;" ng-if="NYS_per_grouping[1][0] == null">0</b> <span>SUBPROJECTS</span>
                                    </div> -->
<!--                                     <div class="col">
                                        <label> <small class="font-weight-bold" style="color:#1ab394;"> MAKILAHOK </small> </label>
                                        <br>
                                        <b style="font-size:2em;" ng-bind="NYS_per_grouping[2][0] | number:0"></b> <b style="font-size:2em;" ng-if="NYS_per_grouping[2][0] == null">0</b> <span>SUBPROJECTS</span>
                                    </div> -->
                                    <div class="col">
                                        <label> <small class="font-weight-bold" style="color:#1ab394;"> NCDDP </small> </label>
                                        <br>
                                        <b style="font-size:2em;" ng-bind="NYS_per_grouping[3][0] | number:0"></b> <b style="font-size:2em;" ng-if="NYS_per_grouping[3][0] == null">0</b> <span>SUBPROJECTS</span>
                                    </div>
                                    <div class="col">
                                        <label> <small class="font-weight-bold" style="color:#1ab394;"> IP CDD </small> </label>
                                        <br>
                                        <b style="font-size:2em;" ng-bind="NYS_per_grouping[4][0] | number:0"></b> <b style="font-size:2em;" ng-if="NYS_per_grouping[4][0] == null">0</b> <span>SUBPROJECTS</span>
                                    </div>
<!--                                     <div class="col">
                                        <label> <small class="font-weight-bold" style="color:#1ab394;"> CCL </small> </label>
                                        <br>
                                        <b style="font-size:2em;" ng-bind="NYS_per_grouping[5][0] | number:0"></b> <b style="font-size:2em;" ng-if="NYS_per_grouping[5][0] == null">0</b> <span>SUBPROJECTS</span>
                                    </div>
                                    <div class="col">
                                        <label> <small class="font-weight-bold" style="color:#1ab394;"> L&E </small> </label>
                                        <br>
                                        <b style="font-size:2em;" ng-bind="NYS_per_grouping[6][0] | number:0"></b> <b style="font-size:2em;" ng-if="NYS_per_grouping[6][0] == null">0</b> <span>SUBPROJECTS</span>
                                    </div> -->
                                </div>
                        </div>
                      </div>
            </div>
                </div>
            </div> <!-- col 3 -->

            <div class="col-lg-12">
              <div class="ibox ">
                  <div class="ibox-title">
                    <h3 class="mb-0">Subproject Count per SP Type</h3>
                      <div class="ibox-tools">
                        <a class="btn btn-primary btn-sm mb-1 collapse-link" href="" id="download1" ng-click="download_chart_as_photo('myChart1','download1')">
                            <i class="fa fa-download"></i>
                        </a>
                      </div>
                  </div>
                  <div class="ibox-content">
                      <canvas ng-show="summary_modal == true" style="position: relative; height:60vh; width:100%;" class="flot-chart-content" id="myChart1_type"></canvas>
                    <canvas ng-show="summary_modal == false" style="position: relative; height:60vh; width:100%;" class="flot-chart-content" id="myChart1"></canvas>
                  </div>
                </div>
            </div>

            <div class="col-lg-12">
              <div class="ibox ">
                  <div class="ibox-title">
                      <h3 class="mb-0">Subproject Count per SP Category</h3>
                      <div class="ibox-tools">
                        <a class="btn btn-primary btn-sm mb-1 collapse-link" href="" id="download2" ng-click="download_chart_as_photo('myChart2','download2')">
                            <i class="fa fa-download"></i>
                        </a>
                      </div>
                  </div>
                  <div class="ibox-content">
                      <canvas ng-show="summary_modal == true" style="position: relative; height:60vh; width:100%;" class="flot-chart-content" id="myChart2_category"></canvas>
                    <canvas ng-show="summary_modal == false" style="position: relative; height:60vh; width:100%;" class="flot-chart-content" id="myChart2"></canvas>
                  </div>
                </div>
            </div>


            <div class="col-lg-12">
              <div class="ibox ">
                  <div class="ibox-title">
                      <h3 class="mb-0">Average Duration (Days) of Subproject per SP Type : ESTIMATED vs ACTUAL</h3>
                      <div class="ibox-tools">
                        <a class="btn btn-primary btn-sm mb-1 collapse-link" href="" id="download2" ng-click="download_chart_as_photo('render_charts_sp_type_estimated_duration','download2')">
                            <i class="fa fa-download"></i>
                        </a>
                      </div>
                  </div>
                  <div class="ibox-content">
                      <canvas ng-show="summary_modal == true" style="position: relative; height:60vh; width:100%;" class="flot-chart-content" id="ChartSptypeDuration_summary"></canvas>
                    <canvas ng-show="summary_modal == false" style="position: relative; height:60vh; width:100%;" class="flot-chart-content" id="ChartSptypeDuration"></canvas>
                  </div>
                </div>
            </div>

    </div>

    </div>
</div>

<!-- Data sets for summary -->
<div class="modal inmodal fade" id="datasets_modal" tabindex="-1" role="dialog"  aria-hidden="true">
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
              <select class="form-control" id="modality" ng-model="set_modality">
                <option value="" selected></option>
                <option value="1">KKB</option>
                <option value="2">MAKILAHOK</option>
                <option value="3">NCDDP</option>
                <option value="4">IP CDD</option>
                <option value="5">CCL</option>
                <option value="6">L&E</option>
              </select>
            </div>

            <div class="form-group mb-2" ng-show="set_modality == 'IP CDD'">
              <label><small class="col-form-label"> <small class="font-weight-bold"> CADT Number </small> </small></label>
              <select class="form-control" id="cadt" ng-model="set_cadt">
                <option value="089" selected>089</option>
                <option value="134">134</option>
                <option value="048">048</option>
                <option value="117">117</option>
                <option value="093">093</option>
                <option value="078">078</option>
              </select>
            </div>
            
            <div class="row">
              <div class="col-lg-4">
                <div class="form-group mb-2">
                  <label><small class="col-form-label"> <small class="font-weight-bold"> Year of Implementation </small> </small></label>
                  <select class="form-control" id="year" ng-model="set_year">
                    <option value="2014" selected> 2014 </option>
                    <option value="2015"> 2015 </option>
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
                  <label><small class="col-form-label"> <small class="font-weight-bold"> Cycle </small> </small></label>
                  <select class="form-control" id="cycle" ng-model="set_cycle">
                    <option value="1" selected> 1 </option>
                    <option value="2"> 2 </option>
                    <option value="3"> 3 </option>
                    <option value="4"> 4 </option>
                    <option value="5"> 5 </option>
                  </select>
                </div>
              </div>
              <div class="col-lg-4">
                <div class="form-group mb-2">
                  <label><small class="col-form-label"> <small class="font-weight-bold"> Batch </small> </small></label>
                  <select class="form-control" id="batch" ng-model="set_batch">
                    <option value="1" selected> 1 </option>
                    <option value="2"> 2 </option>
                    <option value="3"> 3 </option>
                    <option value="4"> 4 </option>
                    <option value="5"> 5 </option>
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

            </div>
          <div class="modal-footer">
          <button class="btn btn-primary" type="button" data-dismiss="modal" ng-click="show_modal_summary(set_modality,set_cadt,set_year,set_cycle,set_batch,province_data,municipality_data,brgy_data,search_title,search_sp_id)">Generate <i class="fa fa-gears"></i></button>

          <button class="btn btn-white" type="button" data-dismiss="modal">Cancel <i class="fa fa-times"></i></button>
          </div>
        </div>
    </div>
</div>
@endsection