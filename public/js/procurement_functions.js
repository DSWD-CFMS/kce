var app = angular.module('Main_Function', []);

app.directive('price', [function () {
    return {
        require: 'ngModel',
        link: function (scope, element, attrs, ngModel) {
            attrs.$set('ngTrim', "false");

            var formatter = function(str, isNum) {
                str = String( Number(str || 0) / (isNum?1:100) );
                str = (str=='0'?'0.0':str).split('.');
                str[1] = str[1] || '0';
                return str[0].replace(/(\d)(?=(\d\d\d)+(?!\d))/g, '$1,') + '.' + (str[1].length==1?str[1]+'0':str[1]);
            }
            var updateView = function(val) {
                scope.$applyAsync(function () {
                    ngModel.$setViewValue(val || '');
                    ngModel.$render();
                });
            }
            var parseNumber = function(val) {
                var modelString = formatter(ngModel.$modelValue, true);
                var sign = {
                    pos: /[+]/.test(val),
                    neg: /[-]/.test(val)
                }
                sign.has = sign.pos || sign.neg;
                sign.both = sign.pos && sign.neg;

                if (!val || sign.has && val.length==1 || ngModel.$modelValue && Number(val)===0) {
                    var newVal = (!val || ngModel.$modelValue && Number()===0?'':val);
                    if (ngModel.$modelValue !== newVal)
                        updateView(newVal);

                    return '';
                }
                else {
                    var valString = String(val || '');
                    var newSign = (sign.both && ngModel.$modelValue>=0 || !sign.both && sign.neg?'-':'');
                    var newVal = valString.replace(/[^0-9]/g,'');
                    var viewVal = newSign + formatter(angular.copy(newVal));

                    if (modelString !== valString)
                        updateView(viewVal);

                    return (Number(newSign + newVal) / 100) || 0;
                }
            }
            var formatNumber = function(val) {
                if (val) {
                    var str = String(val).split('.');
                    str[1] = str[1] || '0';
                    val = str[0] + '.' + (str[1].length==1?str[1]+'0':str[1]);
                }
                return parseNumber(val);
            }

            ngModel.$parsers.push(parseNumber);
            ngModel.$formatters.push(formatNumber);
        }
    };
}]);

app.controller('PROCUREMENT_Controller', function($scope,$http,$filter,$timeout) {
  console.log('PROCUREMENT_Controller');
  $scope.mini_navbar = true;
  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });

  $scope.clock = "loading clock..."; // initialise the time variable
  $scope.tickInterval = 1000 //ms

  var tick = function() {
      $scope.clock = Date.now() // get the current time
      $timeout(tick, $scope.tickInterval); // reset the timer
  }

  // Start the timer
  $timeout(tick, $scope.tickInterval);

  /** SOCKETS EVENTS **/
  var user_id = $('#user_id').html();

  // var socket = io.connect('http://localhost:3011');

  // socket.emit("New_User", user_id, function(user_id, callback){
  //     if (user_id) {
  //         console.log('Login');
  //     }else{
  //         console.log('Not Login');
  //     }
  // });
  /** SOCKETS EVENTS **/

  // DATE Format
  function js_yyyy_mm_dd_hh_mm_ss (input) {
    if(input == null){
      return null;
    }else{
      var now = new Date(input);
      year = "" + now.getFullYear();
      month = "" + (now.getMonth() + 1); if (month.length == 1) { month = "0" + month; }
      day = "" + now.getDate(); if (day.length == 1) { day = "0" + day; }
      hour = "" + now.getHours(); if (hour.length == 1) { hour = "0" + hour; }
      minute = "" + now.getMinutes(); if (minute.length == 1) { minute = "0" + minute; }
      second = "" + now.getSeconds(); if (second.length == 1) { second = "0" + second; }
      return year + "-" + month + "-" + day + " " + hour + ":" + minute + ":" + second;
    }
  }

  $scope.parse_date = function(date){
      date = new Date(Date.parse(date));
      return date;
  }

  $scope.fetch_procurement_dashboard_div = false;
  $scope.fetch_procurement_modality_div = false;
  $scope.fetch_procurement_ceac_div = false;
  $scope.fetch_procurement_upload_div = false;
  $scope.fetch_procurement_reports_div = false;

  // dashboard
  $scope.fetch_procurement_dashboard = function(){
      $scope.chart_slippage = [];
      $scope.chart_planned = [];
      $scope.chart_actual = [];
      $scope.chart_labels = [];
      $scope.sp_chart_data = [];

    $http({
        method : "GET",
        url : 'routes/fetch_modality_dashboard',
    }).then(function mySuccess(response) {
      console.log('dashboard');
      console.log(response.data);

      $scope.my_modality = response.data[0];
      $scope.my_sp = response.data[1];
      $scope.ongoing_count = response.data[2];
      $scope.completed_count = response.data[3];
      $scope.nys_count = response.data[4];
      $scope.pmr_approved = response.data[5];
      $scope.pmr_pending = response.data[6];
      $scope.pmr_for_update = response.data[7];
      $scope.approved_per_sp_groupings = response.data[8];
      $scope.pending_per_sp_groupings = response.data[9];
      $scope.forupdate_per_sp_groupings = response.data[10];
      $scope.latest_pmr = response.data[11];
      $scope.pmr_logs_events = response.data[12];

      console.log("MODALITY");
      console.log($scope.latest_pmr);
      console.log($scope.my_modality);

      for(var x = 0; x < $scope.pmr_logs_events.length; x++){
        $scope.pmr_logs_events[x].created_at = $scope.parse_date($scope.pmr_logs_events[x].created_at);
      }

      for(var x = 0; x < $scope.latest_pmr[0].sp_pmr_logs.length; x++){
        $scope.latest_pmr[0].sp_pmr_logs[x].updated_at = $scope.parse_date($scope.latest_pmr[0].sp_pmr_logs[x].updated_at);
        $scope.latest_pmr[0].sp_pmr_logs[x].created_at = $scope.parse_date($scope.latest_pmr[0].sp_pmr_logs[x].created_at);
      }

    }, function myError(response) {});
  }

  $scope.search_sp = function(params){
    if($scope.search_data_modality == ""){
      console.log($scope.search_data_modality);
      $scope.show_modality();
      $scope.clear_filter();
    }else{
      console.log('Search SP INPUT');
        var datax = {
            params:params
        }
        $http({
            method : "POST",
            url : 'fetch_search_modality_sp',
            data: datax,
        }).then(function mySuccess(response) {
            console.log(response.data);
            // $scope.sp_per_modality_data_on_going = response.data[0];
            // $scope.sp_per_modality_data_completed = response.data[1];
            $scope.sp_per_modality_data_all_sp_logs = response.data;

            for(var x = 0; x < $scope.sp_per_modality_data_all_sp_logs.length; x++){
              $scope.sp_per_modality_data_all_sp_logs[x].sp_rfr_first_tranche_date = $scope.parse_date($scope.sp_per_modality_data_all_sp_logs[x].sp_rfr_first_tranche_date);
              $scope.sp_per_modality_data_all_sp_logs[x].sp_date_started = $scope.parse_date($scope.sp_per_modality_data_all_sp_logs[x].sp_date_started);
              $scope.sp_per_modality_data_all_sp_logs[x].sp_date_of_turnover = $scope.parse_date($scope.sp_per_modality_data_all_sp_logs[x].sp_date_of_turnover);
              $scope.sp_per_modality_data_all_sp_logs[x].sp_target_date_of_completion = $scope.parse_date($scope.sp_per_modality_data_all_sp_logs[x].sp_target_date_of_completion);
              $scope.sp_per_modality_data_all_sp_logs[x].sp_actual_date_completed = $scope.parse_date($scope.sp_per_modality_data_all_sp_logs[x].sp_actual_date_completed);

              for(var y = 0; y < $scope.sp_per_modality_data_all_sp_logs[x].sp_logs.length; y++){
                $scope.sp_per_modality_data_all_sp_logs[x].sp_logs[y].updated_at = $scope.parse_date($scope.sp_per_modality_data_all_sp_logs[x].sp_logs[y].updated_at);
              }
            }

        }, function myError(response) {
          
        });
    }
  }

  $scope.search_modal = false;
  $scope.search_data_modal = function(search_modality,search_year,search_cycle,search_batch,province_data,municipality_data,brgy_data,search_title,search_sp_id){
    console.log('Search SP MODAL');
      var datax = {
          search_modality:search_modality,
          search_year:search_year,
          search_cycle:search_cycle,
          search_batch:search_batch,
          province_data:province_data,
          municipality_data:municipality_data,
          brgy_data:brgy_data,
          search_title:search_title,
          search_sp_id:search_sp_id,
      }

      console.log(datax);
      $http({
          method : "POST",
          url : 'search_data_modal',
          data: datax,
      }).then(function mySuccess(response) {

        $scope.sp_per_modality_data_all_sp_logs = response.data;
        console.log($scope.sp_per_modality_data_all_sp_logs.data.length);

        for(var x = 0; x < $scope.sp_per_modality_data_all_sp_logs.data.length; x++){
          $scope.sp_per_modality_data_all_sp_logs.data[x].sp_rfr_first_tranche_date = $scope.parse_date($scope.sp_per_modality_data_all_sp_logs.data[x].sp_rfr_first_tranche_date);
          $scope.sp_per_modality_data_all_sp_logs.data[x].sp_date_started = $scope.parse_date($scope.sp_per_modality_data_all_sp_logs.data[x].sp_date_started);
          $scope.sp_per_modality_data_all_sp_logs.data[x].sp_date_of_turnover = $scope.parse_date($scope.sp_per_modality_data_all_sp_logs.data[x].sp_date_of_turnover);
          $scope.sp_per_modality_data_all_sp_logs.data[x].sp_target_date_of_completion = $scope.parse_date($scope.sp_per_modality_data_all_sp_logs.data[x].sp_target_date_of_completion);
          $scope.sp_per_modality_data_all_sp_logs.data[x].sp_actual_date_completed = $scope.parse_date($scope.sp_per_modality_data_all_sp_logs.data[x].sp_actual_date_completed);

          for(var y = 0; y < $scope.sp_per_modality_data_all_sp_logs.data[x].sp_logs.length; y++){
            $scope.sp_per_modality_data_all_sp_logs.data[x].sp_logs[y].updated_at = $scope.parse_date($scope.sp_per_modality_data_all_sp_logs.data[x].sp_logs[y].updated_at);
          }
        }
          // console.log(response.data);
          // $scope.sp_per_modality_data_all_sp_logs = response.data[0];
          // $scope.search_modal = true;

          // for(x = 0; x < $scope.sp_per_modality_data_all_sp_logs.length; x++){
          //   $scope.sp_per_modality_data_all_sp_logs[x].sp[0].sp_rfr_first_tranche_date = $scope.parse_date($scope.sp_per_modality_data_all_sp_logs[x].sp[0].sp_rfr_first_tranche_date);
          //   $scope.sp_per_modality_data_all_sp_logs[x].sp[0].sp_date_started = $scope.parse_date($scope.sp_per_modality_data_all_sp_logs[x].sp[0].sp_date_started);
          //   $scope.sp_per_modality_data_all_sp_logs[x].sp[0].sp_date_of_turnover = $scope.parse_date($scope.sp_per_modality_data_all_sp_logs[x].sp[0].sp_date_of_turnover);
          //   $scope.sp_per_modality_data_all_sp_logs[x].sp[0].sp_target_date_of_completion = $scope.parse_date($scope.sp_per_modality_data_all_sp_logs[x].sp[0].sp_target_date_of_completion);
          //   $scope.sp_per_modality_data_all_sp_logs[x].sp[0].sp_actual_date_completed = $scope.parse_date($scope.sp_per_modality_data_all_sp_logs[x].sp[0].sp_actual_date_completed);

          //   for(y = 0; y < $scope.sp_per_modality_data_all_sp_logs[x].sp[0].sp_logs.length; y++){
          //     $scope.sp_per_modality_data_all_sp_logs[x].sp[0].sp_logs[y].updated_at = $scope.parse_date($scope.sp_per_modality_data_all_sp_logs[x].sp[0].sp_logs[y].updated_at);
          //   }
          // }

          // $scope.search_modal_sp_for_export = response.data[1];

          // for(x = 0; x < $scope.search_modal_sp_for_export.length; x++){
          //   $scope.search_modal_sp_for_export[x].sp[0].sp_rfr_first_tranche_date = $scope.parse_date($scope.search_modal_sp_for_export[x].sp[0].sp_rfr_first_tranche_date);
          //   $scope.search_modal_sp_for_export[x].sp[0].sp_date_started = $scope.parse_date($scope.search_modal_sp_for_export[x].sp[0].sp_date_started);
          //   $scope.search_modal_sp_for_export[x].sp[0].sp_date_of_turnover = $scope.parse_date($scope.search_modal_sp_for_export[x].sp[0].sp_date_of_turnover);
          //   $scope.search_modal_sp_for_export[x].sp[0].sp_target_date_of_completion = $scope.parse_date($scope.search_modal_sp_for_export[x].sp[0].sp_target_date_of_completion);
          //   $scope.search_modal_sp_for_export[x].sp[0].sp_actual_date_completed = $scope.parse_date($scope.search_modal_sp_for_export[x].sp[0].sp_actual_date_completed);

          //   for(y = 0; y < $scope.search_modal_sp_for_export[x].sp[0].sp_logs.length; y++){
          //     $scope.search_modal_sp_for_export[x].sp[0].sp_logs[y].updated_at = $scope.parse_date($scope.search_modal_sp_for_export[x].sp[0].sp_logs[y].updated_at);
          //   }
          // }

      }, function myError(response) {
        
      });
  }

  $scope.clear_filter = function(){
    // clear filter modal
    $scope.search_status = "";
    $scope.search_modality = "";
    $scope.search_year = "";
    $scope.search_cycle = "";
    $scope.search_batch = "";
    $scope.province_data = "";
    $scope.municipality_data = "";
    $scope.brgy_data = "";
    $scope.search_title = "";
    $scope.search_sp_id = "";
  }

  $scope.show_modality = function(){
    $scope.search_modal = false;
    $scope.render_modalities_and_sp();
  }

  $scope.render_modalities_and_sp = function(){
      $http({
          method : "GET",
          url : 'fetch_all_modality_sp',
      }).then(function mySuccess(response) {
          console.log(response.data);

          $scope.sp_per_modality_data_all_sp_logs = response.data;
          // $scope.sp_per_modality_data_all_sp_logs = response.data[0];
          console.log($scope.sp_per_modality_data_all_sp_logs.data.length);

          for(var x = 0; x < $scope.sp_per_modality_data_all_sp_logs.data.length; x++){
            $scope.sp_per_modality_data_all_sp_logs.data[x].sp_rfr_first_tranche_date = $scope.parse_date($scope.sp_per_modality_data_all_sp_logs.data[x].sp_rfr_first_tranche_date);
            $scope.sp_per_modality_data_all_sp_logs.data[x].sp_date_started = $scope.parse_date($scope.sp_per_modality_data_all_sp_logs.data[x].sp_date_started);
            $scope.sp_per_modality_data_all_sp_logs.data[x].sp_date_of_turnover = $scope.parse_date($scope.sp_per_modality_data_all_sp_logs.data[x].sp_date_of_turnover);
            $scope.sp_per_modality_data_all_sp_logs.data[x].sp_target_date_of_completion = $scope.parse_date($scope.sp_per_modality_data_all_sp_logs.data[x].sp_target_date_of_completion);
            $scope.sp_per_modality_data_all_sp_logs.data[x].sp_actual_date_completed = $scope.parse_date($scope.sp_per_modality_data_all_sp_logs.data[x].sp_actual_date_completed);

            for(var y = 0; y < $scope.sp_per_modality_data_all_sp_logs.data[x].sp_logs.length; y++){
              $scope.sp_per_modality_data_all_sp_logs.data[x].sp_logs[y].updated_at = $scope.parse_date($scope.sp_per_modality_data_all_sp_logs.data[x].sp_logs[y].updated_at);
            }
          }

          // $scope.sp_per_modality_data_all_sp_logs_export_all = response.data[1];

      }, function myError(response) {
        
      });
  }

  $scope.get_total_project_cost = function(paramObj){
    var sum = 0;
    for( var el in paramObj ) {
      if( paramObj.hasOwnProperty( el ) ) {
        // sum += parseFloat( paramObj[el] );
        // console.log("paramObj"+ paramObj[el]);
        if(paramObj[el] == null){
          paramObj[el] = 0;
        }else{
          paramObj[el] = paramObj[el];
        }
        sum += parseFloat( paramObj[el] );
      }
    }
    return sum;
  // return parseFloat(data1) + parseFloat(data2) + parseFloat(data3) + parseFloat(data4) + parseFloat(data5) + parseFloat(data6) + parseF loat(data7) + parseFloat(data8) + parseFloat(data9) + parseFloat(data10) + parseFloat(data11) + parseFloat(data12) + parseFloat(data13) + parseFloat(data14) + parseFloat(data15);
  }

  $scope.view_planned_sched = function(sp_id){
    $scope.planned_sched_div = true;
    console.log(sp_id);
    $http({
      method : "GET",
      url : 'view_planned_sched/'+sp_id,
    }).then(function mySuccess(response) {
      $scope.planned_sched = response.data;
      console.log(response.data);
    }, function myError(response) {

    });
  }

  $scope.verifier = [];
  $scope.fetch_all_for_export = function(type){
    if(type == 1){
      $http({
          method : "GET",
          url : 'fetch_all_for_export',
      }).then(function mySuccess(response) {
          console.log(response.data);

          $scope.sp_per_modality_data_all_sp_logs_export_all = response.data;
          $scope.verifier.push($scope.sp_per_modality_data_all_sp_logs_export_all);

          for(x = 0; x < $scope.sp_per_modality_data_all_sp_logs_export_all.length; x++){
            $scope.sp_per_modality_data_all_sp_logs_export_all[x].updated_at = $scope.parse_date($scope.sp_per_modality_data_all_sp_logs_export_all[x].updated_at);
            $scope.sp_per_modality_data_all_sp_logs_export_all[x].sp_rfr_first_tranche_date = $scope.parse_date($scope.sp_per_modality_data_all_sp_logs_export_all[x].sp_rfr_first_tranche_date);
            $scope.sp_per_modality_data_all_sp_logs_export_all[x].sp_date_started = $scope.parse_date($scope.sp_per_modality_data_all_sp_logs_export_all[x].sp_date_started);
            $scope.sp_per_modality_data_all_sp_logs_export_all[x].sp_date_of_turnover = $scope.parse_date($scope.sp_per_modality_data_all_sp_logs_export_all[x].sp_date_of_turnover);
            $scope.sp_per_modality_data_all_sp_logs_export_all[x].sp_target_date_of_completion = $scope.parse_date($scope.sp_per_modality_data_all_sp_logs_export_all[x].sp_target_date_of_completion);
            $scope.sp_per_modality_data_all_sp_logs_export_all[x].sp_actual_date_completed = $scope.parse_date($scope.sp_per_modality_data_all_sp_logs_export_all[x].sp_actual_date_completed);

            for(y = 0; y < $scope.sp_per_modality_data_all_sp_logs_export_all[x].sp_logs.length; y++){
              $scope.sp_per_modality_data_all_sp_logs_export_all[x].sp_logs[y].updated_at = $scope.parse_date($scope.sp_per_modality_data_all_sp_logs_export_all[x].sp_logs[y].updated_at);
            }
          }
      }, function myError(response) {});
    }else if(type == 2){
      $http({
          method : "GET",
          url : 'fetch_all_pmr',
      }).then(function mySuccess(response) {
          console.log(response.data);

          $scope.sp_pmr = response.data;
          $scope.verifier.push($scope.sp_pmr);

          for(var e = 0; e < $scope.sp_pmr.length; e++){
            $scope.sp_pmr[e].apa_acceptance = $scope.parse_date($scope.sp_pmr[e].apa_acceptance);
            $scope.sp_pmr[e].apa_ads = $scope.parse_date($scope.sp_pmr[e].apa_ads);
            $scope.sp_pmr[e].apa_bid_eval = $scope.parse_date($scope.sp_pmr[e].apa_bid_eval);
            $scope.sp_pmr[e].apa_contract_review_date = $scope.parse_date($scope.sp_pmr[e].apa_contract_review_date);
            $scope.sp_pmr[e].apa_contract_signing = $scope.parse_date($scope.sp_pmr[e].apa_contract_signing);
            $scope.sp_pmr[e].apa_delivery = $scope.parse_date($scope.sp_pmr[e].apa_delivery);
            $scope.sp_pmr[e].apa_eligibility_check = $scope.parse_date($scope.sp_pmr[e].apa_eligibility_check);
            $scope.sp_pmr[e].apa_notice_of_award = $scope.parse_date($scope.sp_pmr[e].apa_notice_of_award);
            $scope.sp_pmr[e].apa_notice_to_proceed = $scope.parse_date($scope.sp_pmr[e].apa_notice_to_proceed);
            $scope.sp_pmr[e].apa_open_of_bids = $scope.parse_date($scope.sp_pmr[e].apa_open_of_bids);
            $scope.sp_pmr[e].apa_post_qual = $scope.parse_date($scope.sp_pmr[e].apa_post_qual);
            $scope.sp_pmr[e].apa_pre_proc_con = $scope.parse_date($scope.sp_pmr[e].apa_pre_proc_con);
            $scope.sp_pmr[e].apa_prebid_con = $scope.parse_date($scope.sp_pmr[e].apa_prebid_con);
            $scope.sp_pmr[e].apa_target_date_of_completion = $scope.parse_date($scope.sp_pmr[e].apa_target_date_of_completion);
            $scope.sp_pmr[e].created_at = $scope.parse_date($scope.sp_pmr[e].created_at);
            $scope.sp_pmr[e].apa_contractors_eval_conducted = $scope.parse_date($scope.sp_pmr[e].apa_contractors_eval_conducted);
            $scope.sp_pmr[e].delivery = $scope.parse_date($scope.sp_pmr[e].delivery);
            $scope.sp_pmr[e].io_bid_eval = $scope.parse_date($scope.sp_pmr[e].io_bid_eval);
            $scope.sp_pmr[e].io_eligibility_check = $scope.parse_date($scope.sp_pmr[e].io_eligibility_check);
            $scope.sp_pmr[e].io_open_of_bids = $scope.parse_date($scope.sp_pmr[e].io_open_of_bids);
            $scope.sp_pmr[e].io_post_qual = $scope.parse_date($scope.sp_pmr[e].io_post_qual);
            $scope.sp_pmr[e].io_prebid_con = $scope.parse_date($scope.sp_pmr[e].io_prebid_con);
            $scope.sp_pmr[e].apa_target_date_completion = $scope.parse_date($scope.sp_pmr[e].apa_target_date_completion);
            $scope.sp_pmr[e].bac_reso_recom_award = $scope.parse_date($scope.sp_pmr[e].bac_reso_recom_award);

            if($scope.sp_pmr[e].abc_co >= 50000){
              $scope.sp_pmr[e].philgeps = true;
            }else{
              $scope.sp_pmr[e].philgeps = false;
            };
            
            $scope.sp_pmr[e].date_of_posting_philgeps_noa = $scope.parse_date($scope.sp_pmr[e].date_of_posting_philgeps_noa);
            $scope.sp_pmr[e].date_of_posting_philgeps_po_contract = $scope.parse_date($scope.sp_pmr[e].date_of_posting_philgeps_po_contract);
          }
      }, function myError(response) {});
    }else;
  }

  $scope.Export_All_Data = function(type){
    $scope.fetch_all_for_export(type);
    if(type == 1){
      $scope.show_wrapper_tbl_sp_all_data = true;
      Swal.fire({
        title: 'Are you sure?',
        text: "Do you want to export all Sub-project data?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#007bff',
        cancelButtonColor: '#dc3545',
        confirmButtonText: 'Yes, export it!',
        onOpen: () => {
          Swal.showLoading()
          setTimeout(() => { Swal.hideLoading() }, 8000)
        }
      }).then((result) => {
        if (result.value) {
              /* Defaults */
              $('#sp_table_all_data').tableExport({type:'excel'});
              // alasql('SELECT * INTO XLS("Exported-Data-Subproject-Data.xls",{headers:true}) \
              // FROM HTML("#sp_table_all_data",{headers:true})');

              $scope.show_modality();
        }else{
              $scope.show_modality();
        };
      });
    }else if(type == 2){
      $scope.show_wrapper_tbl_pmr_all_data = true;
      Swal.fire({
        title: 'Are you sure?',
        text: "Do you want to export all PMR data?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#007bff',
        cancelButtonColor: '#dc3545',
        confirmButtonText: 'Yes, export it!',
        onOpen: () => {
          Swal.showLoading()
          setTimeout(() => { Swal.hideLoading() }, 8000)
        }
      }).then((result) => {
        if (result.value) {
              $('#pmr_table_all_data').tableExport({type:'excel'});
              // alasql('SELECT * INTO XLS("Exported-Data-PMR-Data.xls",{headers:true}) \
              // FROM HTML("#pmr_table_all_data",{headers:true})');

              $scope.show_modality();
        }else{
              $scope.show_modality();
        };
      });

    }else;

  }

  // $scope.Export_Modal_Data = function(){
  //   Swal.fire({
  //     title: 'Are you sure?',
  //     text: "Do you want to export this data?",
  //     icon: 'question',
  //     showCancelButton: true,
  //     confirmButtonColor: '#007bff',
  //     cancelButtonColor: '#dc3545',
  //     confirmButtonText: 'Yes, export it!'
  //   }).then((result) => {
  //     if (result.value) {
  //           alasql('SELECT * INTO XLS("Modality_Exported_Data.xls",{headers:true}) \
  //           FROM HTML("#MyInquires",{headers:true})');

  //           $scope.show_modality();
  //     }else{
  //           $scope.show_modality();
  //     };
  //   });
  // }

  // PAGINTION
  $scope.Next_Pagination = function(url){
    $http({
          method : "GET",
          url : url,
      }).then(function mySuccess(response) {

      $scope.sp_per_modality_data_all_sp_logs = response.data;
      for(var x = 0; x < $scope.sp_per_modality_data_all_sp_logs.data.length; x++){
        $scope.sp_per_modality_data_all_sp_logs.data[x].sp_rfr_first_tranche_date = $scope.parse_date($scope.sp_per_modality_data_all_sp_logs.data[x].sp_rfr_first_tranche_date);
        $scope.sp_per_modality_data_all_sp_logs.data[x].sp_date_started = $scope.parse_date($scope.sp_per_modality_data_all_sp_logs.data[x].sp_date_started);
        $scope.sp_per_modality_data_all_sp_logs.data[x].sp_date_of_turnover = $scope.parse_date($scope.sp_per_modality_data_all_sp_logs.data[x].sp_date_of_turnover);
        $scope.sp_per_modality_data_all_sp_logs.data[x].sp_target_date_of_completion = $scope.parse_date($scope.sp_per_modality_data_all_sp_logs.data[x].sp_target_date_of_completion);
        $scope.sp_per_modality_data_all_sp_logs.data[x].sp_actual_date_completed = $scope.parse_date($scope.sp_per_modality_data_all_sp_logs.data[x].sp_actual_date_completed);

        for(var y = 0; y < $scope.sp_per_modality_data_all_sp_logs.data[x].sp_logs.length; y++){
          $scope.sp_per_modality_data_all_sp_logs.data[x].sp_logs[y].updated_at = $scope.parse_date($scope.sp_per_modality_data_all_sp_logs.data[x].sp_logs[y].updated_at);
        }
      }

      }, function myError(response) {
      
    });
  }

  $scope.Previous_Pagination = function (url){
    console.log(url);
    $http({
          method : "GET",
          url : url,
      }).then(function mySuccess(response) {

      $scope.sp_per_modality_data_all_sp_logs = response.data;
      for(var x = 0; x < $scope.sp_per_modality_data_all_sp_logs.data.length; x++){
        $scope.sp_per_modality_data_all_sp_logs.data[x].sp_rfr_first_tranche_date = $scope.parse_date($scope.sp_per_modality_data_all_sp_logs.data[x].sp_rfr_first_tranche_date);
        $scope.sp_per_modality_data_all_sp_logs.data[x].sp_date_started = $scope.parse_date($scope.sp_per_modality_data_all_sp_logs.data[x].sp_date_started);
        $scope.sp_per_modality_data_all_sp_logs.data[x].sp_date_of_turnover = $scope.parse_date($scope.sp_per_modality_data_all_sp_logs.data[x].sp_date_of_turnover);
        $scope.sp_per_modality_data_all_sp_logs.data[x].sp_target_date_of_completion = $scope.parse_date($scope.sp_per_modality_data_all_sp_logs.data[x].sp_target_date_of_completion);
        $scope.sp_per_modality_data_all_sp_logs.data[x].sp_actual_date_completed = $scope.parse_date($scope.sp_per_modality_data_all_sp_logs.data[x].sp_actual_date_completed);

        for(var y = 0; y < $scope.sp_per_modality_data_all_sp_logs.data[x].sp_logs.length; y++){
          $scope.sp_per_modality_data_all_sp_logs.data[x].sp_logs[y].updated_at = $scope.parse_date($scope.sp_per_modality_data_all_sp_logs.data[x].sp_logs[y].updated_at);
        }
      }

      }, function myError(response) {
      
    });
  }

  $scope.Skip_To_Page = function(path,Page_Number){
    console.log(path);
    console.log(Page_Number);
    $http({
      method : "GET",
      url: path+"?page="+Page_Number,
    }).then(function mySuccess(response) {

      $scope.sp_per_modality_data_all_sp_logs = response.data;
      for(var x = 0; x < $scope.sp_per_modality_data_all_sp_logs.data.length; x++){
        $scope.sp_per_modality_data_all_sp_logs.data[x].sp_rfr_first_tranche_date = $scope.parse_date($scope.sp_per_modality_data_all_sp_logs.data[x].sp_rfr_first_tranche_date);
        $scope.sp_per_modality_data_all_sp_logs.data[x].sp_date_started = $scope.parse_date($scope.sp_per_modality_data_all_sp_logs.data[x].sp_date_started);
        $scope.sp_per_modality_data_all_sp_logs.data[x].sp_date_of_turnover = $scope.parse_date($scope.sp_per_modality_data_all_sp_logs.data[x].sp_date_of_turnover);
        $scope.sp_per_modality_data_all_sp_logs.data[x].sp_target_date_of_completion = $scope.parse_date($scope.sp_per_modality_data_all_sp_logs.data[x].sp_target_date_of_completion);
        $scope.sp_per_modality_data_all_sp_logs.data[x].sp_actual_date_completed = $scope.parse_date($scope.sp_per_modality_data_all_sp_logs.data[x].sp_actual_date_completed);

        for(var y = 0; y < $scope.sp_per_modality_data_all_sp_logs.data[x].sp_logs.length; y++){
          $scope.sp_per_modality_data_all_sp_logs.data[x].sp_logs[y].updated_at = $scope.parse_date($scope.sp_per_modality_data_all_sp_logs.data[x].sp_logs[y].updated_at);
        }
      }

    }, function myError(response) {

    });
  }
  // PAGINTION

  // Show Profile
  $scope.show_profile = function(){
    $http({
        method : "GET",
        url : 'show_profile',
      }).then(function mySuccess(response) {
        console.log(response.data)
        $scope.Profile = response.data[0];
        $scope.DAC_count1 = response.data[1];
        $scope.RPMO_count1 = response.data[2];
        $scope.PhotoObj = response.data[3];
        $scope.my_modalities = response.data[4];
        $scope.modalities_obj = response.data[5];

      for(var x = 0; x < $scope.Profile.length; x++){
        $scope.Profile[x].created_at = $scope.parse_date($scope.Profile[x].created_at);
        }
      }, function myError(response) {

      });
  }

  $scope.show_profile_dashboard = function(){
    $http({
        method : "GET",
        url : 'routes/show_profile',
      }).then(function mySuccess(response) {
        console.log(response.data)
        // $scope.Profile = response.data[0];
        // $scope.DAC_count1 = response.data[1];
        // $scope.RPMO_count1 = response.data[2];
        $scope.PhotoObj = response.data[3];

      for(var x = 0; x < $scope.Profile.length; x++){
        $scope.Profile[x].created_at = $scope.parse_date($scope.Profile[x].created_at);
        }
      }, function myError(response) {

      });
  }

  $scope.pmr_history_modal_div = true;
  $scope.fetch_specific_pmr_data = function(data) {
    console.log(data);
    $('#pmr_history_modal').on('hidden.bs.modal', function () {
      // Load up a new modal...
      $('#pmr_modal').modal('show');
    })

    $scope.specific_pmr_data = data;
    console.log("fetch_specific_pmr_data");
    for(var y = 0; y < $scope.specific_pmr_data.sp_pmr_remarks_logs.length; y++){
      $scope.specific_pmr_data.sp_pmr_remarks_logs[y].created_at = $scope.parse_date($scope.specific_pmr_data.sp_pmr_remarks_logs[y].created_at);
      $scope.specific_pmr_data.sp_pmr_remarks_logs[y].updated_at = $scope.parse_date($scope.specific_pmr_data.sp_pmr_remarks_logs[y].updated_at);
    }
    console.log($scope.specific_pmr_data.abc_co);
    if($scope.specific_pmr_data.abc_co >= 50000){
      $scope.philgeps = true;
    }else{
      $scope.philgeps = false;
    };
    console.log($scope.philgeps);
    // $scope.specific_pmr_data.apa_acceptance = $scope.parse_date($scope.specific_pmr_data.apa_acceptance);
    // $scope.specific_pmr_data.apa_ads = $scope.parse_date($scope.specific_pmr_data.apa_ads);
    // $scope.specific_pmr_data.apa_bid_eval = $scope.parse_date($scope.specific_pmr_data.apa_bid_eval);
    // $scope.specific_pmr_data.apa_contract_review_date = $scope.parse_date($scope.specific_pmr_data.apa_contract_review_date);
    // $scope.specific_pmr_data.apa_contract_signing = $scope.parse_date($scope.specific_pmr_data.apa_contract_signing);
    // $scope.specific_pmr_data.apa_delivery = $scope.parse_date($scope.specific_pmr_data.apa_delivery);
    // $scope.specific_pmr_data.apa_eligibility_check = $scope.parse_date($scope.specific_pmr_data.apa_eligibility_check);
    // $scope.specific_pmr_data.apa_notice_of_award = $scope.parse_date($scope.specific_pmr_data.apa_notice_of_award);
    // $scope.specific_pmr_data.apa_notice_to_proceed = $scope.parse_date($scope.specific_pmr_data.apa_notice_to_proceed);
    // $scope.specific_pmr_data.apa_open_of_bids = $scope.parse_date($scope.specific_pmr_data.apa_open_of_bids);
    // $scope.specific_pmr_data.apa_post_qual = $scope.parse_date($scope.specific_pmr_data.apa_post_qual);
    // $scope.specific_pmr_data.apa_pre_proc_con = $scope.parse_date($scope.specific_pmr_data.apa_pre_proc_con);
    // $scope.specific_pmr_data.apa_prebid_con = $scope.parse_date($scope.specific_pmr_data.apa_prebid_con);
    // $scope.specific_pmr_data.apa_target_date_of_completion = $scope.parse_date($scope.specific_pmr_data.apa_target_date_of_completion);
    // $scope.specific_pmr_data.created_at = $scope.parse_date($scope.specific_pmr_data.created_at);
    // $scope.specific_pmr_data.apa_contractors_eval_conducted = $scope.parse_date($scope.specific_pmr_data.apa_contractors_eval_conducted);
    // $scope.specific_pmr_data.delivery = $scope.parse_date($scope.specific_pmr_data.delivery);
    // $scope.specific_pmr_data.io_bid_eval = $scope.parse_date($scope.specific_pmr_data.io_bid_eval);
    // $scope.specific_pmr_data.io_eligibility_check = $scope.parse_date($scope.specific_pmr_data.io_eligibility_check);
    // $scope.specific_pmr_data.io_open_of_bids = $scope.parse_date($scope.specific_pmr_data.io_open_of_bids);
    // $scope.specific_pmr_data.io_post_qual = $scope.parse_date($scope.specific_pmr_data.io_post_qual);
    // $scope.specific_pmr_data.io_prebid_con = $scope.parse_date($scope.specific_pmr_data.io_prebid_con);

    // var array = $scope.specific_pmr_data.list_of_invited.split(',');
    // $scope.list_of_invited_array = array;
    // console.log(array);
    // for(var x = 0; x < array.length; x++){
    //   $('.tagsinput').tagsinput('add', array[x]);
    // }
  }

  $scope.fileChanged_profile = function(element){
    $scope.file_upload = element.files
    $scope.uptfile = element.files
    $scope.$apply();        

    var name  = $scope.file_upload[0].name;
    var fileType = name.substr(name.indexOf(".")+1);
    var $preview = $('#preview').empty();
    if ($scope.file_upload) $.each($scope.file_upload, showFile);

    function showFile(i,input) {
      let file = input;
      $preview.append($("<span class='list-group-item'>"+file.name+"<span/>"));
    }
    console.log($scope.file_upload.length);
    console.log($scope.file_upload);
  }

  $scope.try_upload_file_btn = false;
  $scope.try_upload_file = function(){
    $scope.try_upload_file_btn = true;
  }


  $scope.upload_profile_picture = function(uploaded_category){
    // alert("Ssasa");
    Swal.fire({
      title: 'Are you sure?',
      text: "You want to upload this files?",
      icon: 'question',
      showCancelButton: true,
      confirmButtonColor: '#007bff',
      cancelButtonColor: '#dc3545',
      confirmButtonText: 'Yes, upload it!'
    }).then((result) => {
      if (result.value) {
            $http({
                method : "POST",
                url : 'update_profile_photo',
                data: {},
                headers: { 'Content-Type': undefined},
                transformRequest: function(data) {
                    var formData = new FormData();
                    formData.append("category", uploaded_category);
                    for (var i = 0; i < $scope.file_upload.length; i++) {
                        formData.append('file[' + i+']', $scope.file_upload[i]);
                      }
                    return formData;
                },
            }).then(function mySuccess(response) {
              console.log(response.data);
              if(response.data == 1 || response.data == "1"){
                window.location.href="/"+"procurement/routes/profile";
                $('#preview').empty();
                Swal.fire(
                  'Yahoo!',
                  'Your file has been uploaded.',
                  'success'
                );
              }else{

              }
            }, function myError(response) {
                console.log(response);
            });
      }
    });
  }

  $scope.try_update_profileinfo_btn = false;
  $scope.try_update_profileinfo = function(){
    $scope.try_update_profileinfo_btn = true;
  }

  $scope.cancel_update_profileinfo = function(){
    $scope.try_update_profileinfo_btn = false;
  }

  $scope.update_profileinfo = function(Fname,Mname,Lname,email,emp_id_no,contact){
    // alert("Ssasa");
    Swal.fire({
      title: 'Are you sure?',
      text: "You want to upload this files?",
      icon: 'question',
      showCancelButton: true,
      confirmButtonColor: '#007bff',
      cancelButtonColor: '#dc3545',
      confirmButtonText: 'Yes, upload it!'
    }).then((result) => {
      if (result.value) {

        var datax = {
        Fname:Fname,
        Mname:Mname,
        Lname:Lname,
        email:email,
        emp_id_no:emp_id_no,
        contact:contact,
        }

        $http({
            method : "POST",
            url : 'update_profile_info',
            data: datax,
        }).then(function mySuccess(response) {
            if(response.data == 1 || response.data == "1"){
          window.location.href="/"+"rpmo/routes/profile";
            $('#preview').empty();
            Swal.fire(
              'Yahoo!',
              'Your profile info has been uploaded.',
              'success'
            );
            }else{

            }
        }, function myError(response) {});
      }
    });
  }
  // Show Profile

  $scope.pmr_forupdate_comments_div = false;
  $scope.pmr_forupdate = function(status){
    if(status == 1){
      $scope.pmr_forupdate_comments_div = true;
      $scope.pmr_view_comments_div = false;
      $('.approve_pmr_btn').attr('hidden','true');
    }else{
      $scope.pmr_forupdate_comments_div = false;
      $scope.pmr_view_comments_div = false;
      $('#view_comments').removeAttr('hidden','hidden');
      $('.approve_pmr_btn').removeAttr('hidden','hidden');
    }
  }

  $scope.pmr_view_comments_div = false;
  $scope.pmr_view_comments = function(){
    $scope.pmr_view_comments_div = true;
    $scope.pmr_forupdate_comments_div = false;
    $('#view_comments').attr('hidden','true');
  }

  $scope.fetch_specific_sp_pmr_data = function(sp_id,sp_data,type){
      console.log("fetch_specific_sp_pmr_data");
      console.log(sp_data);
      $scope.specific_sp_data = sp_data;

    if(type == 1){     
      $http({
          method : "GET",
          url : 'fetch_specific_sp_pmr_data/'+sp_id,
      }).then(function mySuccess(response) {

          if(response.data[0].length == 0){
            Swal.fire(
              'Oppps!',
              'No PMR data',
              'info'
            );
          }else{
            $('#pmr_history_modal').modal('show');
          }
          $scope.pmr_data = response.data[0];
          $scope.pmr_comments_data_pending = response.data[1];
          $scope.pmr_comments_data_complied = response.data[2];
          console.log($scope.pmr_data);
          console.log($scope.pmr_comments_data_pending[0].sp_pmr_logs.length);
          console.log($scope.pmr_comments_data_complied[0].sp_pmr_logs.length);

          for(var x = 0; x < $scope.pmr_data.length; x++){
            $scope.pmr_data[x].created_at =  $scope.parse_date($scope.pmr_data[x].created_at);
            $scope.pmr_data[x].updated_at =  $scope.parse_date($scope.pmr_data[x].updated_at);

            for(var y = 0; y < $scope.pmr_data[x].sp_pmr_logs.length; y++){
              $scope.pmr_data[x].sp_pmr_logs[y].created_at =  $scope.parse_date($scope.pmr_data[x].sp_pmr_logs[y].created_at);
              $scope.pmr_data[x].sp_pmr_logs[y].updated_at =  $scope.parse_date($scope.pmr_data[x].sp_pmr_logs[y].updated_at);
            }

            for(var b = 0; b < $scope.pmr_data[x].sp_pmr_remarks_logs.length; b++){
              $scope.pmr_data[x].sp_pmr_remarks_logs[b].created_at =  $scope.parse_date($scope.pmr_data[x].sp_pmr_remarks_logs[b].created_at);
            }
          }

          // if($scope.pmr_data[0].status == 'Approved'){
          //   $('.approve_pmr_btn').attr('hidden','true');
          // }else{
          //   $('.approve_pmr_btn').removeAttr('hidden','hidden');
          // }

          var array = $scope.pmr_data[0].list_of_invited.split(',');
          $scope.list_of_invited_array = array;
          console.log(array);
      }, function myError(response) {});
    }else;

  }

  $scope.submit_pmr_focal_comments = function(id,sp_id,pmr_forupdate_comments){
    var data = {
      id:id,
      sp_id:sp_id,
      pmr_forupdate_comments:pmr_forupdate_comments,
    };
    console.log(data);

    $http({
        method : "POST",
        url : 'submit_pmr_focal_comments',
        data: data,
    }).then(function mySuccess(response) {
      if(response.data == 1 || response.data == "1"){
        $scope.pmr_forupdate_comments_div = false;
        $scope.pmr_forupdate_comments = "";
        Swal.fire(
          'Yahoo!',
          'Your comments has been saved.',
          'success'
        ).then(function(result){
          $scope.show_modality();
          $('#pmr_history_modal').modal('hide');
          $('#pmr_history_modal').modal('show');
        });

      }else{}

    }, function myError(response) {});
  }

  $scope.add_pmr = function(sp_id){

    var datax = {
      sp_id: sp_id,
      mode_of_procurement: $scope.mode_of_procurement,
      code: $scope.code,
      nature_of_procurement: $scope.nature_of_procurement,
      fund_source: $scope.fund_source,
      apa_pre_proc_con: js_yyyy_mm_dd_hh_mm_ss($scope.apa_pre_proc_con),
      apa_ads: js_yyyy_mm_dd_hh_mm_ss($scope.apa_ads),
      apa_prebid_con: js_yyyy_mm_dd_hh_mm_ss($scope.apa_prebid_con),
      apa_eligibility_check: js_yyyy_mm_dd_hh_mm_ss($scope.apa_eligibility_check),
      apa_open_of_bids: js_yyyy_mm_dd_hh_mm_ss($scope.apa_open_of_bids),
      apa_bid_eval: js_yyyy_mm_dd_hh_mm_ss($scope.apa_bid_eval),
      apa_post_qual: js_yyyy_mm_dd_hh_mm_ss($scope.apa_post_qual),
      bac_reso_recom_award: js_yyyy_mm_dd_hh_mm_ss($scope.bac_reso_recom_award),
      apa_notice_of_award: js_yyyy_mm_dd_hh_mm_ss($scope.apa_notice_of_award),
      apa_contract_signing: js_yyyy_mm_dd_hh_mm_ss($scope.apa_contract_signing),
      apa_notice_to_proceed: js_yyyy_mm_dd_hh_mm_ss($scope.apa_notice_to_proceed),
      apa_contract_review_date: js_yyyy_mm_dd_hh_mm_ss($scope.apa_contract_review_date),
      apa_target_date_completion: js_yyyy_mm_dd_hh_mm_ss($scope.apa_target_date_completion),
      apa_delivery: js_yyyy_mm_dd_hh_mm_ss($scope.apa_delivery),
      apa_acceptance: js_yyyy_mm_dd_hh_mm_ss($scope.apa_acceptance),
      apa_contractors_eval_conducted: js_yyyy_mm_dd_hh_mm_ss($scope.apa_contractors_eval_conducted),
      delivery_percentage: $scope.delivery_percentage,
      early_procurement_activity: $scope.early_procurement_activity,
      abc_total: parseFloat($scope.abc_co) + parseFloat($scope.abc_mooe),
      abc_mooe: $scope.abc_mooe,
      abc_co: $scope.abc_co,
      contract_cost_total: parseFloat($scope.contract_cost_mooe) + parseFloat($scope.contract_cost_co),
      contract_cost_mooe: $scope.contract_cost_mooe,
      contract_cost_co: $scope.contract_cost_co,
      list_of_invited: $scope.list_of_invited,
      io_prebid_con: js_yyyy_mm_dd_hh_mm_ss($scope.io_prebid_con),
      io_eligibility_check: js_yyyy_mm_dd_hh_mm_ss($scope.io_eligibility_check),
      io_open_of_bids: js_yyyy_mm_dd_hh_mm_ss($scope.io_open_of_bids),
      io_bid_eval: js_yyyy_mm_dd_hh_mm_ss($scope.io_bid_eval),
      io_post_qual: js_yyyy_mm_dd_hh_mm_ss($scope.io_post_qual),
      delivery: js_yyyy_mm_dd_hh_mm_ss($scope.delivery),
      remarks: $scope.remarks,
      date_of_posting_philgeps_noa: $scope.date_of_posting_philgeps_noa,
    }
    console.log(datax);

    $http({
        method : "POST",
        url : 'create_pmr',
        data : datax,
    }).then(function mySuccess(response) {
        console.log(response.data);
        $('#add_pmr_modal').modal('hide');

        if(response.data == 1){
          Swal.fire({
            title: 'Yahoooo!',
            text: "PMR successfuly created",
            icon: 'success',
          });
          $scope.show_modality();

          $scope.mode_of_procurement = "";
          $scope.nature_of_procurement = "";
          $scope.code = "";
          $scope.fund_source = "";
          $scope.apa_pre_proc_con = "";
          $scope.apa_ads = "";
          $scope.apa_prebid_con = "";
          $scope.apa_eligibility_check = "";
          $scope.apa_open_of_bids = "";
          $scope.apa_bid_eval = "";
          $scope.apa_post_qual = "";
          $scope.bac_reso_recom_award = "";
          $scope.apa_notice_of_award = "";
          $scope.apa_contract_signing = "";
          $scope.apa_notice_to_proceed = "";
          $scope.apa_contract_review_date = "";
          $scope.apa_target_date_completion = "";
          $scope.apa_delivery = "";
          $scope.apa_acceptance = "";
          $scope.abc_mooe = "";
          $scope.abc_co = "";
          $scope.contract_cost_mooe = "";
          $scope.contract_cost_co = "";
          $('.tagsinput').tagsinput('removeAll');
          $scope.io_prebid_con = "";
          $scope.io_eligibility_check = "";
          $scope.io_open_of_bids = "";
          $scope.io_bid_eval = "";
          $scope.io_post_qual = "";
          $scope.delivery = "";
          $scope.remarks = "";
          $scope.delivery_percentage = "";
          $scope.early_procurement_activity = "";
          $scope.date_of_posting_philgeps_noa = "";
          $scope.apa_contractors_eval_conducted = "";
        }else{
          Swal.fire({
            title: 'Oooops!',
            text: "There must be a problem",
            icon: 'error',
          });
        }
    }, function myError(response) {});

  }

  $scope.pmr_approve = function(id,sp_id){
    var data = {
      id:id,
      sp_id:sp_id,
      pmr_forupdate_comments:$scope.pmr_forupdate_comments,
    };
    $('#pmr_modal').modal('hide');

    $http({
        method : "POST",
        url : 'pmr_approve',
        data: data,
    }).then(function mySuccess(response) {
      if(response.data == 1 || response.data == "1"){
        $scope.pmr_forupdate_comments_div = false;
        $scope.pmr_forupdate_comments = "";
        $scope.show_modality();

        Swal.fire(
          'Yahoo!',
          'PMR has been approved.',
          'success'
        );
      }else{
        $('#pmr_modal').modal('show');
      }

    }, function myError(response) {});
  }

  $scope.pmr_delete_lot = function(id){
    var data = {
      id:id,
    };
    $('#pmr_history_modal').modal('hide');

    Swal.fire({
      title: 'Are you sure?',
      text: "You want to delete this PMR Lot?",
      icon: 'question',
      showCancelButton: true,
      confirmButtonColor: '#007bff',
      cancelButtonColor: '#dc3545',
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.value) {
        $http({
            method : "POST",
            url : 'pmr_delete_lot',
            data: data,
        }).then(function mySuccess(response) {
          if(response.data == 1 || response.data == "1"){
            $scope.show_modality();

            Swal.fire(
              'Yahoo!',
              'PMR Lot has been deleted.',
              'success'
            );
            
          }else{
            $('#pmr_history_modal').modal('show');
          }

        }, function myError(response) {});
      }else{
        $('#pmr_history_modal').modal('show');
      }
    });
  }

  $scope.set_pmr_comments_to_complied = function(id,sp_id){
    var data = {
      id:id,
      sp_id:sp_id
    };

    $http({
        method : "POST",
        url : 'set_pmr_comments_to_complied',
        data: data,
    }).then(function mySuccess(response) {
      if(response.data == 1 || response.data == "1"){
        $('#pmr_modal').modal('hide');
        $scope.fetch_specific_sp_pmr_data(sp_id);
        Swal.fire(
          'Yahoo!',
          'The comment has been set to "Complied" ',
          'success'
        );
      }else{
        $('#pmr_modal').modal('hide');
        $scope.fetch_specific_sp_pmr_data(sp_id);
        Swal.fire(
          'Ooops!',
          'Something went wrong',
          'error'
        );
      }

    }, function myError(response) {});
  }

  // Locations
  $scope.reg = Philippines.getProvincesByRegion("16");
  $scope.muni;
  $scope.brgy;

  console.log($scope.reg);
  $scope.fetch_municipality = function(prov_code){
    $scope.muni = Philippines.getCityMunByProvince(prov_code);
    console.log($scope.muni);
  }

  $scope.fetch_brgy = function(mun_code){
    $scope.brgy = Philippines.getBarangayByMun(mun_code);
    console.log($scope.brgy);
  }
// Locations
});
// end of PROCUREMENT Conroller