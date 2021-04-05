var app = angular.module('Main_Function', ['ngRoute']);

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

app.directive('showDuringResolve', function($rootScope) {
    return {
     link: function(scope, element) {

          element.addClass('ng-hide');
          $rootScope.statechange =  true;

         var unregister = $rootScope.$on('$routeChangeStart', function() {
            element.removeClass('ng-hide');
               $rootScope.statechange =  false;
        });

        scope.$on('$destroy', unregister);
      }
    };
});

app.controller('DAC_Controller', function($scope,$http,$filter,$timeout) {
	console.log('DAC_Controller');
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

  //   socket.on("DAC_Updates", function(data){
		// console.log(data);
  //   });
    /** SOCKETS EVENTS **/

  $scope.parse_date = function(date){
      date = new Date(Date.parse(date));
      return date;
  }

  $scope.animal = function(){
    console.log("animal");
  }

	$scope.get_whereabouts = function(){
		$http({
            method : "GET",
            url : '/fetch_whereabouts',
        }).then(function mySuccess(response) {
          	console.log(response.data);
          	$scope.whereabouts_data = response.data;
        }, function myError(response) {
         
        });
	}

  $scope.fetch_users_list = function(){
    $http({
      method : "GET",
      url : '/fetch_users_list',
    }).then(function mySuccess(response) {
      console.log(response.data);
      $scope.users_list = response.data;
    }, function myError(response) {

    });
  }

	// Start For Reports
	$scope.reg = Philippines.getProvincesByRegion("16");
	$scope.muni;
	console.log($scope.reg);
	$scope.fetch_municipality = function(prov_code){
		$scope.muni = Philippines.getCityMunByProvince(prov_code);
    console.log($scope.muni);
	}

	$scope.fetch_brgy = function(mun_code){
		$scope.brgy = Philippines.getBarangayByMun(mun_code);
		console.log($scope.brgy);
	}
	// End For Reports

	// init values
	// $scope.fetch_dac_dashboard_div = false;
	// $scope.fetch_dac_modality_div = false;
 //  $scope.fetch_dac_ceac_div = false;
 //  $scope.fetch_dac_upload_div = false;
	// $scope.fetch_dac_reports_div = false;

  $scope.fetch_dac_dashboard = function(){

    console.log("fetch_dac_dashboard");
    // $scope.fetch_dac_dashboard_div = true;
    // $scope.fetch_dac_modality_div = false;
    // $scope.fetch_dac_ceac_div = false;
    // $scope.fetch_dac_upload_div = false;
    // $scope.fetch_dac_reports_div = false;

    $scope.chart_slippage = [];
    $scope.chart_planned = [];
    $scope.chart_actual = [];
    $scope.chart_labels = [];
    $scope.sp_chart_data = [];

    $http({
        method : "GET",
        url : 'routes/fetch_modality',
    }).then(function mySuccess(response) {
        $scope.my_modality = response.data[0];
        $scope.grouped_status = response.data[1];

        if(typeof $scope.grouped_status['Cancelled'] == 'undefined'){
          $scope.Cancelled = 0;
        }else{
          $scope.Cancelled = $scope.grouped_status['Cancelled'].length;
        };

        if(typeof $scope.grouped_status['On-going'] == 'undefined'){
          $scope.Ongoing = 0;
        }else{
          $scope.Ongoing = $scope.grouped_status['On-going'].length;
        };

        if(typeof $scope.grouped_status['NYS'] == 'undefined'){
          $scope.NYS = 0;
        }else{
          $scope.NYS = $scope.grouped_status['NYS'].length;
        };

        if(typeof $scope.grouped_status['Completed'] == 'undefined'){
          $scope.Completed = 0;
        }else{
          $scope.Completed = $scope.grouped_status['Completed'].length;
        };

        $scope.total_sp = ($scope.Cancelled + $scope.Ongoing + $scope.NYS + $scope.Completed);
        $scope.sp_ongoing_all_sp_logs = response.data[2];
        $scope.my_sp_actual_weighted = response.data[3];
        $scope.groupby_modality = response.data[4];

        console.log(response.data);

        $scope.chart_slippage = [];
        $scope.chart_planned = [];
        $scope.chart_actual = [];
        $scope.chart_labels = [];
        $scope.sp_chart_data = [];

        for(var x = 0; x < $scope.sp_ongoing_all_sp_logs[0].sp[0].sp_logs.length; x++){
          $scope.chart_slippage.push($scope.sp_ongoing_all_sp_logs[0].sp[0].sp_logs[x].sp_logs_slippage);
          $scope.chart_planned.push($scope.sp_ongoing_all_sp_logs[0].sp[0].sp_logs[x].sp_logs_planned);
          $scope.chart_actual.push($scope.sp_ongoing_all_sp_logs[0].sp[0].sp_logs[x].sp_logs_actual);
          $scope.chart_labels.push($scope.sp_ongoing_all_sp_logs[0].sp[0].sp_logs[x].sp_logs_planned_target_date);
        }
        // console.log($scope.chart_slippage);
        // console.log($scope.chart_planned);
        // console.log($scope.chart_actual);
        // console.log($scope.chart_labels);
        $scope.chart_dashboard($scope.chart_slippage,$scope.chart_planned,$scope.chart_actual,$scope.chart_labels);

    }, function myError(response) {});
  }
  
  $scope.my_subprojects = function(){
    $http({
        method : "GET",
        url : 'fetch_subprojects',
    }).then(function mySuccess(response) {
        $scope.my_modality = response.data;
        console.log("MODALITY");
        console.log($scope.my_modality);
    }, function myError(response) {});
  }

  // E-hide and collapse once mag search
  $scope.hideCollapse = function(){
    $('#accordion3 .collapsed_td').collapse('hide');
  }

  // PAGINTION
  $scope.Next_Pagination_SP = function(url){
    $http({
          method : "GET",
          url : url,
      }).then(function mySuccess(response) {
        $scope.my_modality = response.data;
      }, function myError(response) {
      
    });
  }

  $scope.Previous_Pagination_SP = function (url){
    console.log(url);
    $http({
          method : "GET",
          url : url,
      }).then(function mySuccess(response) {
        $scope.my_modality = response.data;
      }, function myError(response) {
      
    });
  }

  $scope.Skip_To_Page_SP = function(path,Page_Number){
    console.log(path);
    console.log(Page_Number);
    $http({
      method : "GET",
      url: path+"?page="+Page_Number,
    }).then(function mySuccess(response) {
        $scope.my_modality = response.data;
    }, function myError(response) {

    });
  }
  // PAGINTION

  $scope.fetch_dac_dashboard_modalities = function(){
    $scope.fetch_dac_dashboard_div = true;
    $scope.fetch_dac_modality_div = false;
    $scope.fetch_dac_ceac_div = false;
    $scope.fetch_dac_upload_div = false;
    $scope.fetch_dac_reports_div = false;

    $scope.chart_slippage = [];
    $scope.chart_planned = [];
    $scope.chart_actual = [];
    $scope.chart_labels = [];
    $scope.sp_chart_data = [];

  	$http({
        method : "GET",
        url : 'fetch_modality',
    }).then(function mySuccess(response) {
      	$scope.my_modality = response.data[0];
        $scope.my_sp = response.data[1];
      	$scope.sp_ongoing_all_sp_logs = response.data[2];
        $scope.my_completed_sp = response.data[3];
      	console.log("MODALITY");
      	console.log($scope.my_modality);
      	console.log("SP");
        console.log($scope.my_sp);
        console.log("sp_ongoing_all_sp_logs");
      	console.log($scope.sp_ongoing_all_sp_logs);

        for(var x = 0; x < $scope.my_sp[0].sp[0].sp_logs.length; x++){
          $scope.chart_slippage.push($scope.my_sp[0].sp[0].sp_logs[x].sp_logs_slippage);
          $scope.chart_planned.push($scope.my_sp[0].sp[0].sp_logs[x].sp_logs_planned);
          $scope.chart_actual.push($scope.my_sp[0].sp[0].sp_logs[x].sp_logs_actual);
          $scope.chart_labels.push($scope.my_sp[0].sp[0].sp_logs[x].sp_logs_planned_target_date);
        }

        $scope.chart_slippage = [];
        $scope.chart_planned = [];
        $scope.chart_actual = [];
        $scope.chart_labels = [];
        $scope.sp_chart_data = [];

        for(var x = 0; x < $scope.sp_ongoing_all_sp_logs[0].sp[0].sp_logs.length; x++){
          $scope.chart_slippage.push($scope.sp_ongoing_all_sp_logs[0].sp[0].sp_logs[x].sp_logs_slippage);
          $scope.chart_planned.push($scope.sp_ongoing_all_sp_logs[0].sp[0].sp_logs[x].sp_logs_planned);
          $scope.chart_actual.push($scope.sp_ongoing_all_sp_logs[0].sp[0].sp_logs[x].sp_logs_actual);
          $scope.chart_labels.push($scope.sp_ongoing_all_sp_logs[0].sp[0].sp_logs[x].sp_logs_planned_target_date);
        }

        $scope.chart_dashboard($scope.chart_slippage,$scope.chart_planned,$scope.chart_actual,$scope.chart_labels);

    }, function myError(response) {});
  }

  $scope.fetch_dac_upload = function(){
    $scope.fetch_dac_reports_div = false;
    $scope.fetch_dac_ceac_div = false;
    $scope.fetch_dac_dashboard_div = false;
    $scope.fetch_dac_modality_div = false;
    $scope.fetch_dac_upload_div = true;
  }

  $scope.fetch_dac_ceac = function(){
    $scope.fetch_dac_ceac_div = true;
    $scope.fetch_dac_dashboard_div = false;
    $scope.fetch_dac_modality_div = false;
    $scope.fetch_dac_upload_div = false;
    $scope.fetch_dac_reports_div = false;

    Swal.fire({
      title: 'Sorry',
      text: "This module still a work in progress, this will be updated soon.",
      icon: 'info',
      showCancelButton: false,
      confirmButtonColor: '#007bff',
      confirmButtonText: 'Redirect to my dashboard...'
    }).then((result) => {
      if (result.value) {
        $scope.fetch_dac_dashboard();
      }else;
    });


  }

  $scope.fetch_dac_reports = function(){
		$scope.fetch_dac_ceac_div = false;
		$scope.fetch_dac_dashboard_div = false;
    $scope.fetch_dac_modality_div = false;
    $scope.fetch_dac_upload_div = false;
    $scope.fetch_dac_reports_div = true;
    $http({
        method : "GET",
        url : 'routes/fetch_reports_modality',
    }).then(function mySuccess(response) {
        $scope.reports_data = response.data;
        // $scope.reports_modality = response.data[1];
        console.log($scope.reports_modality);
    }, function myError(response) {});
  }

  $scope.Export_Modality_Data = function(){
    Swal.fire({
      title: 'Are you sure?',
      text: "Do you want to export this data?",
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
            alasql('SELECT * INTO XLS("Modality_Exported_Data.xls",{headers:true}) \
            FROM HTML("#MyInquires",{headers:true})');

            // window.location.href = "http://kce_v2.caraga.dswd.gov.ph/modality";
            $scope.fetch_dac_reports();
      }else{
            $scope.fetch_dac_reports();
            // window.location.href = "http://kce_v2.caraga.dswd.gov.ph/modality";
      };
    });
  }

  $scope.fetch_dac_modality_sp = function(modality_type){
    console.log(modality_type);

    $scope.fetch_dac_reports_div = false;
		$scope.fetch_dac_dashboard_div = false;
		$scope.fetch_dac_ceac_div = false;
    $scope.fetch_dac_upload_div = false;
    $scope.fetch_dac_modality_div = true;

  	if(modality_type == 1){
  		$scope.modality_type = 'KKB';
  	}else if(modality_type == 2){
  		$scope.modality_type = 'MAKILAHOK';
  	}else if(modality_type == 3){
  		$scope.modality_type = 'NCDDP';
  	}else if(modality_type == 4){
  		$scope.modality_type = 'IP CDD';
  	}else if(modality_type == 5){
  		$scope.modality_type = 'CCL';
  	}else if(modality_type == 6){
  		$scope.modality_type = 'L&E';
  	}

		$http({
        method : "GET",
        url : 'fetch_dac_modality_sp/'+modality_type,
    }).then(function mySuccess(response) {
      	console.log(response.data);

        $scope.sp_per_modality_data_on_going = response.data[0];
        $scope.sp_per_modality_data_completed = response.data[1];
        $scope.sp_per_modality_data_all_sp_logs = response.data[2];
        $scope.sp_per_modality_data_nys = response.data[3];

      	for(x = 0; x < $scope.sp_per_modality_data_on_going.length; x++){
      		$scope.sp_per_modality_data_on_going[x].sp[0].sp_rfr_first_tranche_date = $scope.parse_date($scope.sp_per_modality_data_on_going[x].sp[0].sp_rfr_first_tranche_date);
      		$scope.sp_per_modality_data_on_going[x].sp[0].sp_date_started = $scope.parse_date($scope.sp_per_modality_data_on_going[x].sp[0].sp_date_started);
      		$scope.sp_per_modality_data_on_going[x].sp[0].sp_date_of_turnover = $scope.parse_date($scope.sp_per_modality_data_on_going[x].sp[0].sp_date_of_turnover);
      		$scope.sp_per_modality_data_on_going[x].sp[0].sp_target_date_of_completion = $scope.parse_date($scope.sp_per_modality_data_on_going[x].sp[0].sp_target_date_of_completion);
      		$scope.sp_per_modality_data_on_going[x].sp[0].sp_actual_date_completed = $scope.parse_date($scope.sp_per_modality_data_on_going[x].sp[0].sp_actual_date_completed);

          for(y = 0; y < $scope.sp_per_modality_data_on_going[x].sp[0].sp_logs.length; y++){
            $scope.sp_per_modality_data_on_going[x].sp[0].sp_logs[y].updated_at = $scope.parse_date($scope.sp_per_modality_data_on_going[x].sp[0].sp_logs[y].updated_at);
          }
      	}

        for(x = 0; x < $scope.sp_per_modality_data_nys.length; x++){
          $scope.sp_per_modality_data_nys[x].sp[0].sp_rfr_first_tranche_date = $scope.parse_date($scope.sp_per_modality_data_nys[x].sp[0].sp_rfr_first_tranche_date);
          $scope.sp_per_modality_data_nys[x].sp[0].sp_date_started = $scope.parse_date($scope.sp_per_modality_data_nys[x].sp[0].sp_date_started);
          $scope.sp_per_modality_data_nys[x].sp[0].sp_date_of_turnover = $scope.parse_date($scope.sp_per_modality_data_nys[x].sp[0].sp_date_of_turnover);
          $scope.sp_per_modality_data_nys[x].sp[0].sp_target_date_of_completion = $scope.parse_date($scope.sp_per_modality_data_nys[x].sp[0].sp_target_date_of_completion);
          $scope.sp_per_modality_data_nys[x].sp[0].sp_actual_date_completed = $scope.parse_date($scope.sp_per_modality_data_nys[x].sp[0].sp_actual_date_completed);

          for(y = 0; y < $scope.sp_per_modality_data_nys[x].sp[0].sp_logs.length; y++){
            $scope.sp_per_modality_data_nys[x].sp[0].sp_logs[y].updated_at = $scope.parse_date($scope.sp_per_modality_data_nys[x].sp[0].sp_logs[y].updated_at);
          }
        }

        for(x = 0; x < $scope.sp_per_modality_data_completed.length; x++){
          // $scope.sp_per_modality_data_completed[x].sp[0].sp_rfr_first_tranche_date = $scope.parse_date($scope.sp_per_modality_data_completed[x].sp[0].sp_rfr_first_tranche_date);
          $scope.sp_per_modality_data_completed[x].sp[0].sp_date_started = $scope.parse_date($scope.sp_per_modality_data_completed[x].sp[0].sp_date_started);
          $scope.sp_per_modality_data_completed[x].sp[0].sp_date_of_turnover = $scope.parse_date($scope.sp_per_modality_data_completed[x].sp[0].sp_date_of_turnover);
          $scope.sp_per_modality_data_completed[x].sp[0].sp_target_date_of_completion = $scope.parse_date($scope.sp_per_modality_data_completed[x].sp[0].sp_target_date_of_completion);
          $scope.sp_per_modality_data_completed[x].sp[0].sp_actual_date_completed = $scope.parse_date($scope.sp_per_modality_data_completed[x].sp[0].sp_actual_date_completed);
          // console.log($scope.sp_per_modality_data_completed[x].sp_rfr_first_tranche_date);
        }

        $scope.for_charts_data($scope.sp_per_modality_data_all_sp_logs);
    }, function myError(response) {
    	
    });
  }

  $scope.view_specific_sp_rfr_data = function(sp_id,sp_groupings){
    console.log(sp_id);
    console.log(sp_groupings);

    $http({
        method : "GET",
        url : '/fetch_rfr/'+sp_id+'/'+sp_groupings,
    }).then(function mySuccess(response) {
        console.log(response.data);
        $scope.rfr_data = response.data[0];
        $scope.rfr_data_findings = response.data[1];
        console.log("rfr_data");
        console.log($scope.rfr_data);

            // BUB
            if($scope.rfr_data.c_m_f_s_kalahi_2015__b_u_b__s_p != null){
              $scope.rfr_data.c_m_f_s_kalahi_2015__b_u_b__r_f_r.received_rpmo = $scope.parse_date($scope.rfr_data.c_m_f_s_kalahi_2015__b_u_b__r_f_r.received_rpmo);
              $scope.rfr_data.c_m_f_s_kalahi_2015__b_u_b__r_f_r.received_socials = $scope.parse_date($scope.rfr_data.c_m_f_s_kalahi_2015__b_u_b__r_f_r.received_socials);
              $scope.rfr_data.c_m_f_s_kalahi_2015__b_u_b__r_f_r.received_engineering = $scope.parse_date($scope.rfr_data.c_m_f_s_kalahi_2015__b_u_b__r_f_r.received_engineering);
              $scope.rfr_data.c_m_f_s_kalahi_2015__b_u_b__r_f_r.received_finance = $scope.parse_date($scope.rfr_data.c_m_f_s_kalahi_2015__b_u_b__r_f_r.received_finance);
              $scope.rfr_data.c_m_f_s_kalahi_2015__b_u_b__r_f_r.received_npmo = $scope.parse_date($scope.rfr_data.c_m_f_s_kalahi_2015__b_u_b__r_f_r.received_npmo);
              $scope.rfr_data.c_m_f_s_kalahi_2015__b_u_b__r_f_r.date_encoded = $scope.parse_date($scope.rfr_data.c_m_f_s_kalahi_2015__b_u_b__r_f_r.date_encoded);
              $scope.rfr_data.c_m_f_s_kalahi_2015__b_u_b__r_f_r.incoming_date = $scope.parse_date($scope.rfr_data.c_m_f_s_kalahi_2015__b_u_b__r_f_r.incoming_date);
              $scope.rfr_data.c_m_f_s_kalahi_2015__b_u_b__r_f_r.obligation_date = $scope.parse_date($scope.rfr_data.c_m_f_s_kalahi_2015__b_u_b__r_f_r.obligation_date);
              $scope.rfr_data.c_m_f_s_kalahi_2015__b_u_b__r_f_r.cash_date = $scope.parse_date($scope.rfr_data.c_m_f_s_kalahi_2015__b_u_b__r_f_r.cash_date);

              $scope.paramObj = {
                grant: $scope.rfr_data.c_m_f_s_kalahi_2015__b_u_b__s_p.grant,
                other_amount: $scope.rfr_data.c_m_f_s_kalahi_2015__b_u_b__s_p.other_amount,
                lcc_community: $scope.rfr_data.c_m_f_s_kalahi_2015__b_u_b__s_p.lcc_community,
                lcc_community_ik: $scope.rfr_data.c_m_f_s_kalahi_2015__b_u_b__s_p.lcc_community_ik,
                lcc_blgu: $scope.rfr_data.c_m_f_s_kalahi_2015__b_u_b__s_p.lcc_blgu,
                lcc_blgu_ik: $scope.rfr_data.c_m_f_s_kalahi_2015__b_u_b__s_p.lcc_blgu_ik,
                lcc_mlgu: $scope.rfr_data.c_m_f_s_kalahi_2015__b_u_b__s_p.lcc_mlgu,
                lcc_mlgu_ik: $scope.rfr_data.c_m_f_s_kalahi_2015__b_u_b__s_p.lcc_mlgu_ik,
                lcc_plgu: $scope.rfr_data.c_m_f_s_kalahi_2015__b_u_b__s_p.lcc_plgu,
                lcc_plgu_ik: $scope.rfr_data.c_m_f_s_kalahi_2015__b_u_b__s_p.lcc_plgu_ik,
                lcc_others: $scope.rfr_data.c_m_f_s_kalahi_2015__b_u_b__s_p.lcc_others,
                lcc_others_ik: $scope.rfr_data.c_m_f_s_kalahi_2015__b_u_b__s_p.lcc_others_ik,
                lcc_cash: $scope.rfr_data.c_m_f_s_kalahi_2015__b_u_b__s_p.lcc_cash,
                lcc_in_kind: $scope.rfr_data.c_m_f_s_kalahi_2015__b_u_b__s_p.lcc_in_kind,
              }

              $scope.all_lcc = {
                other_amount: $scope.rfr_data.c_m_f_s_kalahi_2015__b_u_b__s_p.other_amount,
                lcc_community: $scope.rfr_data.c_m_f_s_kalahi_2015__b_u_b__s_p.lcc_community,
                lcc_community_ik: $scope.rfr_data.c_m_f_s_kalahi_2015__b_u_b__s_p.lcc_community_ik,
                lcc_blgu: $scope.rfr_data.c_m_f_s_kalahi_2015__b_u_b__s_p.lcc_blgu,
                lcc_blgu_ik: $scope.rfr_data.c_m_f_s_kalahi_2015__b_u_b__s_p.lcc_blgu_ik,
                lcc_mlgu: $scope.rfr_data.c_m_f_s_kalahi_2015__b_u_b__s_p.lcc_mlgu,
                lcc_mlgu_ik: $scope.rfr_data.c_m_f_s_kalahi_2015__b_u_b__s_p.lcc_mlgu_ik,
                lcc_plgu: $scope.rfr_data.c_m_f_s_kalahi_2015__b_u_b__s_p.lcc_plgu,
                lcc_plgu_ik: $scope.rfr_data.c_m_f_s_kalahi_2015__b_u_b__s_p.lcc_plgu_ik,
                lcc_others: $scope.rfr_data.c_m_f_s_kalahi_2015__b_u_b__s_p.lcc_others,
                lcc_others_ik: $scope.rfr_data.c_m_f_s_kalahi_2015__b_u_b__s_p.lcc_others_ik,
                lcc_cash: $scope.rfr_data.c_m_f_s_kalahi_2015__b_u_b__s_p.lcc_cash,
                lcc_in_kind: $scope.rfr_data.c_m_f_s_kalahi_2015__b_u_b__s_p.lcc_in_kind,
              }

              $scope.rfr_data.total_LCC = $scope.get_total_project_cost($scope.all_lcc); 
              $scope.rfr_data.total_cost_ni = $scope.get_total_project_cost($scope.paramObj); 
            
            }else if($scope.rfr_data.c_m_f_s_kalahi_2016__b_u_b__s_p != null){
              $scope.rfr_data.c_m_f_s_kalahi_2016__b_u_b__r_f_r.received_rpmo = $scope.parse_date($scope.rfr_data.c_m_f_s_kalahi_2016__b_u_b__r_f_r.received_rpmo);
              $scope.rfr_data.c_m_f_s_kalahi_2016__b_u_b__r_f_r.received_socials = $scope.parse_date($scope.rfr_data.c_m_f_s_kalahi_2016__b_u_b__r_f_r.received_socials);
              $scope.rfr_data.c_m_f_s_kalahi_2016__b_u_b__r_f_r.received_engineering = $scope.parse_date($scope.rfr_data.c_m_f_s_kalahi_2016__b_u_b__r_f_r.received_engineering);
              $scope.rfr_data.c_m_f_s_kalahi_2016__b_u_b__r_f_r.received_finance = $scope.parse_date($scope.rfr_data.c_m_f_s_kalahi_2016__b_u_b__r_f_r.received_finance);
              $scope.rfr_data.c_m_f_s_kalahi_2016__b_u_b__r_f_r.received_npmo = $scope.parse_date($scope.rfr_data.c_m_f_s_kalahi_2016__b_u_b__r_f_r.received_npmo);
              $scope.rfr_data.c_m_f_s_kalahi_2016__b_u_b__r_f_r.date_encoded = $scope.parse_date($scope.rfr_data.c_m_f_s_kalahi_2016__b_u_b__r_f_r.date_encoded);
              $scope.rfr_data.c_m_f_s_kalahi_2016__b_u_b__r_f_r.incoming_date = $scope.parse_date($scope.rfr_data.c_m_f_s_kalahi_2016__b_u_b__r_f_r.incoming_date);
              $scope.rfr_data.c_m_f_s_kalahi_2016__b_u_b__r_f_r.obligation_date = $scope.parse_date($scope.rfr_data.c_m_f_s_kalahi_2016__b_u_b__r_f_r.obligation_date);
              $scope.rfr_data.c_m_f_s_kalahi_2016__b_u_b__r_f_r.cash_date = $scope.parse_date($scope.rfr_data.c_m_f_s_kalahi_2016__b_u_b__r_f_r.cash_date);

              $scope.paramObj = {
                grant: $scope.rfr_data.c_m_f_s_kalahi_2016__b_u_b__s_p.grant,
                other_amount: $scope.rfr_data.c_m_f_s_kalahi_2016__b_u_b__s_p.other_amount,
                lcc_community: $scope.rfr_data.c_m_f_s_kalahi_2016__b_u_b__s_p.lcc_community,
                lcc_community_ik: $scope.rfr_data.c_m_f_s_kalahi_2016__b_u_b__s_p.lcc_community_ik,
                lcc_blgu: $scope.rfr_data.c_m_f_s_kalahi_2016__b_u_b__s_p.lcc_blgu,
                lcc_blgu_ik: $scope.rfr_data.c_m_f_s_kalahi_2016__b_u_b__s_p.lcc_blgu_ik,
                lcc_mlgu: $scope.rfr_data.c_m_f_s_kalahi_2016__b_u_b__s_p.lcc_mlgu,
                lcc_mlgu_ik: $scope.rfr_data.c_m_f_s_kalahi_2016__b_u_b__s_p.lcc_mlgu_ik,
                lcc_plgu: $scope.rfr_data.c_m_f_s_kalahi_2016__b_u_b__s_p.lcc_plgu,
                lcc_plgu_ik: $scope.rfr_data.c_m_f_s_kalahi_2016__b_u_b__s_p.lcc_plgu_ik,
                lcc_others: $scope.rfr_data.c_m_f_s_kalahi_2016__b_u_b__s_p.lcc_others,
                lcc_others_ik: $scope.rfr_data.c_m_f_s_kalahi_2016__b_u_b__s_p.lcc_others_ik,
                lcc_cash: $scope.rfr_data.c_m_f_s_kalahi_2016__b_u_b__s_p.lcc_cash,
                lcc_in_kind: $scope.rfr_data.c_m_f_s_kalahi_2016__b_u_b__s_p.lcc_in_kind,
              }

              $scope.all_lcc = {
                other_amount: $scope.rfr_data.c_m_f_s_kalahi_2016__b_u_b__s_p.other_amount,
                lcc_community: $scope.rfr_data.c_m_f_s_kalahi_2016__b_u_b__s_p.lcc_community,
                lcc_community_ik: $scope.rfr_data.c_m_f_s_kalahi_2016__b_u_b__s_p.lcc_community_ik,
                lcc_blgu: $scope.rfr_data.c_m_f_s_kalahi_2016__b_u_b__s_p.lcc_blgu,
                lcc_blgu_ik: $scope.rfr_data.c_m_f_s_kalahi_2016__b_u_b__s_p.lcc_blgu_ik,
                lcc_mlgu: $scope.rfr_data.c_m_f_s_kalahi_2016__b_u_b__s_p.lcc_mlgu,
                lcc_mlgu_ik: $scope.rfr_data.c_m_f_s_kalahi_2016__b_u_b__s_p.lcc_mlgu_ik,
                lcc_plgu: $scope.rfr_data.c_m_f_s_kalahi_2016__b_u_b__s_p.lcc_plgu,
                lcc_plgu_ik: $scope.rfr_data.c_m_f_s_kalahi_2016__b_u_b__s_p.lcc_plgu_ik,
                lcc_others: $scope.rfr_data.c_m_f_s_kalahi_2016__b_u_b__s_p.lcc_others,
                lcc_others_ik: $scope.rfr_data.c_m_f_s_kalahi_2016__b_u_b__s_p.lcc_others_ik,
                lcc_cash: $scope.rfr_data.c_m_f_s_kalahi_2016__b_u_b__s_p.lcc_cash,
                lcc_in_kind: $scope.rfr_data.c_m_f_s_kalahi_2016__b_u_b__s_p.lcc_in_kind,
              }

              $scope.rfr_data.total_LCC = $scope.get_total_project_cost($scope.all_lcc); 
              $scope.rfr_data.total_cost_ni = $scope.get_total_project_cost($scope.paramObj); 
            
            }else if($scope.rfr_data.c_m_f_s_kalahi_2017__b_u_b__s_p != null){
              $scope.rfr_data.c_m_f_s_kalahi_2017__b_u_b__r_f_r.received_rpmo = $scope.parse_date($scope.rfr_data.c_m_f_s_kalahi_2017__b_u_b__r_f_r.received_rpmo);
              $scope.rfr_data.c_m_f_s_kalahi_2017__b_u_b__r_f_r.received_socials = $scope.parse_date($scope.rfr_data.c_m_f_s_kalahi_2017__b_u_b__r_f_r.received_socials);
              $scope.rfr_data.c_m_f_s_kalahi_2017__b_u_b__r_f_r.received_engineering = $scope.parse_date($scope.rfr_data.c_m_f_s_kalahi_2017__b_u_b__r_f_r.received_engineering);
              $scope.rfr_data.c_m_f_s_kalahi_2017__b_u_b__r_f_r.received_finance = $scope.parse_date($scope.rfr_data.c_m_f_s_kalahi_2017__b_u_b__r_f_r.received_finance);
              $scope.rfr_data.c_m_f_s_kalahi_2017__b_u_b__r_f_r.received_npmo = $scope.parse_date($scope.rfr_data.c_m_f_s_kalahi_2017__b_u_b__r_f_r.received_npmo);
              $scope.rfr_data.c_m_f_s_kalahi_2017__b_u_b__r_f_r.date_encoded = $scope.parse_date($scope.rfr_data.c_m_f_s_kalahi_2017__b_u_b__r_f_r.date_encoded);
              $scope.rfr_data.c_m_f_s_kalahi_2017__b_u_b__r_f_r.incoming_date = $scope.parse_date($scope.rfr_data.c_m_f_s_kalahi_2017__b_u_b__r_f_r.incoming_date);
              $scope.rfr_data.c_m_f_s_kalahi_2017__b_u_b__r_f_r.obligation_date = $scope.parse_date($scope.rfr_data.c_m_f_s_kalahi_2017__b_u_b__r_f_r.obligation_date);
              $scope.rfr_data.c_m_f_s_kalahi_2017__b_u_b__r_f_r.cash_date = $scope.parse_date($scope.rfr_data.c_m_f_s_kalahi_2017__b_u_b__r_f_r.cash_date);

              $scope.paramObj = {
                grant: $scope.rfr_data.c_m_f_s_kalahi_2017__b_u_b__s_p.grant,
                other_amount: $scope.rfr_data.c_m_f_s_kalahi_2017__b_u_b__s_p.other_amount,
                lcc_community: $scope.rfr_data.c_m_f_s_kalahi_2017__b_u_b__s_p.lcc_community,
                lcc_community_ik: $scope.rfr_data.c_m_f_s_kalahi_2017__b_u_b__s_p.lcc_community_ik,
                lcc_blgu: $scope.rfr_data.c_m_f_s_kalahi_2017__b_u_b__s_p.lcc_blgu,
                lcc_blgu_ik: $scope.rfr_data.c_m_f_s_kalahi_2017__b_u_b__s_p.lcc_blgu_ik,
                lcc_mlgu: $scope.rfr_data.c_m_f_s_kalahi_2017__b_u_b__s_p.lcc_mlgu,
                lcc_mlgu_ik: $scope.rfr_data.c_m_f_s_kalahi_2017__b_u_b__s_p.lcc_mlgu_ik,
                lcc_plgu: $scope.rfr_data.c_m_f_s_kalahi_2017__b_u_b__s_p.lcc_plgu,
                lcc_plgu_ik: $scope.rfr_data.c_m_f_s_kalahi_2017__b_u_b__s_p.lcc_plgu_ik,
                lcc_others: $scope.rfr_data.c_m_f_s_kalahi_2017__b_u_b__s_p.lcc_others,
                lcc_others_ik: $scope.rfr_data.c_m_f_s_kalahi_2017__b_u_b__s_p.lcc_others_ik,
                lcc_cash: $scope.rfr_data.c_m_f_s_kalahi_2017__b_u_b__s_p.lcc_cash,
                lcc_in_kind: $scope.rfr_data.c_m_f_s_kalahi_2017__b_u_b__s_p.lcc_in_kind,
              }
              $scope.all_lcc = {
                other_amount: $scope.rfr_data.c_m_f_s_kalahi_2017__b_u_b__s_p.other_amount,
                lcc_community: $scope.rfr_data.c_m_f_s_kalahi_2017__b_u_b__s_p.lcc_community,
                lcc_community_ik: $scope.rfr_data.c_m_f_s_kalahi_2017__b_u_b__s_p.lcc_community_ik,
                lcc_blgu: $scope.rfr_data.c_m_f_s_kalahi_2017__b_u_b__s_p.lcc_blgu,
                lcc_blgu_ik: $scope.rfr_data.c_m_f_s_kalahi_2017__b_u_b__s_p.lcc_blgu_ik,
                lcc_mlgu: $scope.rfr_data.c_m_f_s_kalahi_2017__b_u_b__s_p.lcc_mlgu,
                lcc_mlgu_ik: $scope.rfr_data.c_m_f_s_kalahi_2017__b_u_b__s_p.lcc_mlgu_ik,
                lcc_plgu: $scope.rfr_data.c_m_f_s_kalahi_2017__b_u_b__s_p.lcc_plgu,
                lcc_plgu_ik: $scope.rfr_data.c_m_f_s_kalahi_2017__b_u_b__s_p.lcc_plgu_ik,
                lcc_others: $scope.rfr_data.c_m_f_s_kalahi_2017__b_u_b__s_p.lcc_others,
                lcc_others_ik: $scope.rfr_data.c_m_f_s_kalahi_2017__b_u_b__s_p.lcc_others_ik,
                lcc_cash: $scope.rfr_data.c_m_f_s_kalahi_2017__b_u_b__s_p.lcc_cash,
                lcc_in_kind: $scope.rfr_data.c_m_f_s_kalahi_2017__b_u_b__s_p.lcc_in_kind,
              }

              $scope.rfr_data.total_LCC = $scope.get_total_project_cost($scope.all_lcc); 
              $scope.rfr_data.total_cost_ni = $scope.get_total_project_cost($scope.paramObj); 

            }else if($scope.rfr_data.c_m_f_s_kalahi_2018__b_u_b__s_p != null){
              $scope.rfr_data.c_m_f_s_kalahi_2018__b_u_b__r_f_r.received_rpmo = $scope.parse_date($scope.rfr_data.c_m_f_s_kalahi_2018__b_u_b__r_f_r.received_rpmo);
              $scope.rfr_data.c_m_f_s_kalahi_2018__b_u_b__r_f_r.received_socials = $scope.parse_date($scope.rfr_data.c_m_f_s_kalahi_2018__b_u_b__r_f_r.received_socials);
              $scope.rfr_data.c_m_f_s_kalahi_2018__b_u_b__r_f_r.received_engineering = $scope.parse_date($scope.rfr_data.c_m_f_s_kalahi_2018__b_u_b__r_f_r.received_engineering);
              $scope.rfr_data.c_m_f_s_kalahi_2018__b_u_b__r_f_r.received_finance = $scope.parse_date($scope.rfr_data.c_m_f_s_kalahi_2018__b_u_b__r_f_r.received_finance);
              $scope.rfr_data.c_m_f_s_kalahi_2018__b_u_b__r_f_r.received_npmo = $scope.parse_date($scope.rfr_data.c_m_f_s_kalahi_2018__b_u_b__r_f_r.received_npmo);
              $scope.rfr_data.c_m_f_s_kalahi_2018__b_u_b__r_f_r.date_encoded = $scope.parse_date($scope.rfr_data.c_m_f_s_kalahi_2018__b_u_b__r_f_r.date_encoded);
              $scope.rfr_data.c_m_f_s_kalahi_2018__b_u_b__r_f_r.incoming_date = $scope.parse_date($scope.rfr_data.c_m_f_s_kalahi_2018__b_u_b__r_f_r.incoming_date);
              $scope.rfr_data.c_m_f_s_kalahi_2018__b_u_b__r_f_r.obligation_date = $scope.parse_date($scope.rfr_data.c_m_f_s_kalahi_2018__b_u_b__r_f_r.obligation_date);
              $scope.rfr_data.c_m_f_s_kalahi_2018__b_u_b__r_f_r.cash_date = $scope.parse_date($scope.rfr_data.c_m_f_s_kalahi_2018__b_u_b__r_f_r.cash_date);

              $scope.paramObj = {
                grant: $scope.rfr_data.c_m_f_s_kalahi_2018__b_u_b__s_p.grant,
                other_amount: $scope.rfr_data.c_m_f_s_kalahi_2018__b_u_b__s_p.other_amount,
                lcc_community: $scope.rfr_data.c_m_f_s_kalahi_2018__b_u_b__s_p.lcc_community,
                lcc_community_ik: $scope.rfr_data.c_m_f_s_kalahi_2018__b_u_b__s_p.lcc_community_ik,
                lcc_blgu: $scope.rfr_data.c_m_f_s_kalahi_2018__b_u_b__s_p.lcc_blgu,
                lcc_blgu_ik: $scope.rfr_data.c_m_f_s_kalahi_2018__b_u_b__s_p.lcc_blgu_ik,
                lcc_mlgu: $scope.rfr_data.c_m_f_s_kalahi_2018__b_u_b__s_p.lcc_mlgu,
                lcc_mlgu_ik: $scope.rfr_data.c_m_f_s_kalahi_2018__b_u_b__s_p.lcc_mlgu_ik,
                lcc_plgu: $scope.rfr_data.c_m_f_s_kalahi_2018__b_u_b__s_p.lcc_plgu,
                lcc_plgu_ik: $scope.rfr_data.c_m_f_s_kalahi_2018__b_u_b__s_p.lcc_plgu_ik,
                lcc_others: $scope.rfr_data.c_m_f_s_kalahi_2018__b_u_b__s_p.lcc_others,
                lcc_others_ik: $scope.rfr_data.c_m_f_s_kalahi_2018__b_u_b__s_p.lcc_others_ik,
                lcc_cash: $scope.rfr_data.c_m_f_s_kalahi_2018__b_u_b__s_p.lcc_cash,
                lcc_in_kind: $scope.rfr_data.c_m_f_s_kalahi_2018__b_u_b__s_p.lcc_in_kind,
              }
              $scope.all_lcc = {
                other_amount: $scope.rfr_data.c_m_f_s_kalahi_2018__b_u_b__s_p.other_amount,
                lcc_community: $scope.rfr_data.c_m_f_s_kalahi_2018__b_u_b__s_p.lcc_community,
                lcc_community_ik: $scope.rfr_data.c_m_f_s_kalahi_2018__b_u_b__s_p.lcc_community_ik,
                lcc_blgu: $scope.rfr_data.c_m_f_s_kalahi_2018__b_u_b__s_p.lcc_blgu,
                lcc_blgu_ik: $scope.rfr_data.c_m_f_s_kalahi_2018__b_u_b__s_p.lcc_blgu_ik,
                lcc_mlgu: $scope.rfr_data.c_m_f_s_kalahi_2018__b_u_b__s_p.lcc_mlgu,
                lcc_mlgu_ik: $scope.rfr_data.c_m_f_s_kalahi_2018__b_u_b__s_p.lcc_mlgu_ik,
                lcc_plgu: $scope.rfr_data.c_m_f_s_kalahi_2018__b_u_b__s_p.lcc_plgu,
                lcc_plgu_ik: $scope.rfr_data.c_m_f_s_kalahi_2018__b_u_b__s_p.lcc_plgu_ik,
                lcc_others: $scope.rfr_data.c_m_f_s_kalahi_2018__b_u_b__s_p.lcc_others,
                lcc_others_ik: $scope.rfr_data.c_m_f_s_kalahi_2018__b_u_b__s_p.lcc_others_ik,
                lcc_cash: $scope.rfr_data.c_m_f_s_kalahi_2018__b_u_b__s_p.lcc_cash,
                lcc_in_kind: $scope.rfr_data.c_m_f_s_kalahi_2018__b_u_b__s_p.lcc_in_kind,
              }

              $scope.rfr_data.total_LCC = $scope.get_total_project_cost($scope.all_lcc); 
              $scope.rfr_data.total_cost_ni = $scope.get_total_project_cost($scope.paramObj); 
            
            }else if($scope.rfr_data.c_m_f_s_kalahi_2020__b_u_b__s_p != null){
              $scope.rfr_data.c_m_f_s_kalahi_2020__b_u_b__r_f_r.received_rpmo = $scope.parse_date($scope.rfr_data.c_m_f_s_kalahi_2020__b_u_b__r_f_r.received_rpmo);
              $scope.rfr_data.c_m_f_s_kalahi_2020__b_u_b__r_f_r.received_socials = $scope.parse_date($scope.rfr_data.c_m_f_s_kalahi_2020__b_u_b__r_f_r.received_socials);
              $scope.rfr_data.c_m_f_s_kalahi_2020__b_u_b__r_f_r.received_engineering = $scope.parse_date($scope.rfr_data.c_m_f_s_kalahi_2020__b_u_b__r_f_r.received_engineering);
              $scope.rfr_data.c_m_f_s_kalahi_2020__b_u_b__r_f_r.received_finance = $scope.parse_date($scope.rfr_data.c_m_f_s_kalahi_2020__b_u_b__r_f_r.received_finance);
              $scope.rfr_data.c_m_f_s_kalahi_2020__b_u_b__r_f_r.received_npmo = $scope.parse_date($scope.rfr_data.c_m_f_s_kalahi_2020__b_u_b__r_f_r.received_npmo);
              $scope.rfr_data.c_m_f_s_kalahi_2020__b_u_b__r_f_r.date_encoded = $scope.parse_date($scope.rfr_data.c_m_f_s_kalahi_2020__b_u_b__r_f_r.date_encoded);
              $scope.rfr_data.c_m_f_s_kalahi_2020__b_u_b__r_f_r.incoming_date = $scope.parse_date($scope.rfr_data.c_m_f_s_kalahi_2020__b_u_b__r_f_r.incoming_date);
              $scope.rfr_data.c_m_f_s_kalahi_2020__b_u_b__r_f_r.obligation_date = $scope.parse_date($scope.rfr_data.c_m_f_s_kalahi_2020__b_u_b__r_f_r.obligation_date);
              $scope.rfr_data.c_m_f_s_kalahi_2020__b_u_b__r_f_r.cash_date = $scope.parse_date($scope.rfr_data.c_m_f_s_kalahi_2020__b_u_b__r_f_r.cash_date);

              $scope.paramObj = {
                grant: $scope.rfr_data.c_m_f_s_kalahi_2020__b_u_b__s_p.grant,
                other_amount: $scope.rfr_data.c_m_f_s_kalahi_2020__b_u_b__s_p.other_amount,
                lcc_community: $scope.rfr_data.c_m_f_s_kalahi_2020__b_u_b__s_p.lcc_community,
                lcc_community_ik: $scope.rfr_data.c_m_f_s_kalahi_2020__b_u_b__s_p.lcc_community_ik,
                lcc_blgu: $scope.rfr_data.c_m_f_s_kalahi_2020__b_u_b__s_p.lcc_blgu,
                lcc_blgu_ik: $scope.rfr_data.c_m_f_s_kalahi_2020__b_u_b__s_p.lcc_blgu_ik,
                lcc_mlgu: $scope.rfr_data.c_m_f_s_kalahi_2020__b_u_b__s_p.lcc_mlgu,
                lcc_mlgu_ik: $scope.rfr_data.c_m_f_s_kalahi_2020__b_u_b__s_p.lcc_mlgu_ik,
                lcc_plgu: $scope.rfr_data.c_m_f_s_kalahi_2020__b_u_b__s_p.lcc_plgu,
                lcc_plgu_ik: $scope.rfr_data.c_m_f_s_kalahi_2020__b_u_b__s_p.lcc_plgu_ik,
                lcc_others: $scope.rfr_data.c_m_f_s_kalahi_2020__b_u_b__s_p.lcc_others,
                lcc_others_ik: $scope.rfr_data.c_m_f_s_kalahi_2020__b_u_b__s_p.lcc_others_ik,
                lcc_cash: $scope.rfr_data.c_m_f_s_kalahi_2020__b_u_b__s_p.lcc_cash,
                lcc_in_kind: $scope.rfr_data.c_m_f_s_kalahi_2020__b_u_b__s_p.lcc_in_kind,
              }
              $scope.all_lcc = {
                other_amount: $scope.rfr_data.c_m_f_s_kalahi_2020__b_u_b__s_p.other_amount,
                lcc_community: $scope.rfr_data.c_m_f_s_kalahi_2020__b_u_b__s_p.lcc_community,
                lcc_community_ik: $scope.rfr_data.c_m_f_s_kalahi_2020__b_u_b__s_p.lcc_community_ik,
                lcc_blgu: $scope.rfr_data.c_m_f_s_kalahi_2020__b_u_b__s_p.lcc_blgu,
                lcc_blgu_ik: $scope.rfr_data.c_m_f_s_kalahi_2020__b_u_b__s_p.lcc_blgu_ik,
                lcc_mlgu: $scope.rfr_data.c_m_f_s_kalahi_2020__b_u_b__s_p.lcc_mlgu,
                lcc_mlgu_ik: $scope.rfr_data.c_m_f_s_kalahi_2020__b_u_b__s_p.lcc_mlgu_ik,
                lcc_plgu: $scope.rfr_data.c_m_f_s_kalahi_2020__b_u_b__s_p.lcc_plgu,
                lcc_plgu_ik: $scope.rfr_data.c_m_f_s_kalahi_2020__b_u_b__s_p.lcc_plgu_ik,
                lcc_others: $scope.rfr_data.c_m_f_s_kalahi_2020__b_u_b__s_p.lcc_others,
                lcc_others_ik: $scope.rfr_data.c_m_f_s_kalahi_2020__b_u_b__s_p.lcc_others_ik,
                lcc_cash: $scope.rfr_data.c_m_f_s_kalahi_2020__b_u_b__s_p.lcc_cash,
                lcc_in_kind: $scope.rfr_data.c_m_f_s_kalahi_2020__b_u_b__s_p.lcc_in_kind,
              }

              $scope.rfr_data.total_LCC = $scope.get_total_project_cost($scope.all_lcc); 
              $scope.rfr_data.total_cost_ni = $scope.get_total_project_cost($scope.paramObj); 

            }else;

            // NCDDP

            if($scope.rfr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p != null){
              $scope.rfr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__r_f_r.received_rpmo = $scope.parse_date($scope.rfr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__r_f_r.received_rpmo);
              $scope.rfr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__r_f_r.received_socials = $scope.parse_date($scope.rfr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__r_f_r.received_socials);
              $scope.rfr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__r_f_r.received_engineering = $scope.parse_date($scope.rfr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__r_f_r.received_engineering);
              $scope.rfr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__r_f_r.received_finance = $scope.parse_date($scope.rfr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__r_f_r.received_finance);
              $scope.rfr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__r_f_r.received_npmo = $scope.parse_date($scope.rfr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__r_f_r.received_npmo);
              $scope.rfr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__r_f_r.date_encoded = $scope.parse_date($scope.rfr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__r_f_r.date_encoded);
              $scope.rfr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__r_f_r.incoming_date = $scope.parse_date($scope.rfr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__r_f_r.incoming_date);
              $scope.rfr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__r_f_r.obligation_date = $scope.parse_date($scope.rfr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__r_f_r.obligation_date);
              $scope.rfr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__r_f_r.cash_date = $scope.parse_date($scope.rfr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__r_f_r.cash_date);

              $scope.paramObj = {
                grant: $scope.rfr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p.grant,
                other_amount: $scope.rfr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p.other_amount,
                lcc_community: $scope.rfr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p.lcc_community,
                lcc_community_ik: $scope.rfr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p.lcc_community_ik,
                lcc_blgu: $scope.rfr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p.lcc_blgu,
                lcc_blgu_ik: $scope.rfr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p.lcc_blgu_ik,
                lcc_mlgu: $scope.rfr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p.lcc_mlgu,
                lcc_mlgu_ik: $scope.rfr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p.lcc_mlgu_ik,
                lcc_plgu: $scope.rfr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p.lcc_plgu,
                lcc_plgu_ik: $scope.rfr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p.lcc_plgu_ik,
                lcc_others: $scope.rfr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p.lcc_others,
                lcc_others_ik: $scope.rfr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p.lcc_others_ik,
                lcc_cash: $scope.rfr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p.lcc_cash,
                lcc_in_kind: $scope.rfr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p.lcc_in_kind,
              }
              $scope.all_lcc = {
                other_amount: $scope.rfr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p.other_amount,
                lcc_community: $scope.rfr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p.lcc_community,
                lcc_community_ik: $scope.rfr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p.lcc_community_ik,
                lcc_blgu: $scope.rfr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p.lcc_blgu,
                lcc_blgu_ik: $scope.rfr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p.lcc_blgu_ik,
                lcc_mlgu: $scope.rfr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p.lcc_mlgu,
                lcc_mlgu_ik: $scope.rfr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p.lcc_mlgu_ik,
                lcc_plgu: $scope.rfr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p.lcc_plgu,
                lcc_plgu_ik: $scope.rfr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p.lcc_plgu_ik,
                lcc_others: $scope.rfr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p.lcc_others,
                lcc_others_ik: $scope.rfr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p.lcc_others_ik,
                lcc_cash: $scope.rfr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p.lcc_cash,
                lcc_in_kind: $scope.rfr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p.lcc_in_kind,
              }

              $scope.rfr_data.total_LCC = $scope.get_total_project_cost($scope.all_lcc); 
              $scope.rfr_data.total_cost_ni = $scope.get_total_project_cost($scope.paramObj); 
            
            }else if($scope.rfr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p != null){
              $scope.rfr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__r_f_r.received_rpmo = $scope.parse_date($scope.rfr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__r_f_r.received_rpmo);
              $scope.rfr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__r_f_r.received_socials = $scope.parse_date($scope.rfr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__r_f_r.received_socials);
              $scope.rfr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__r_f_r.received_engineering = $scope.parse_date($scope.rfr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__r_f_r.received_engineering);
              $scope.rfr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__r_f_r.received_finance = $scope.parse_date($scope.rfr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__r_f_r.received_finance);
              $scope.rfr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__r_f_r.received_npmo = $scope.parse_date($scope.rfr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__r_f_r.received_npmo);
              $scope.rfr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__r_f_r.date_encoded = $scope.parse_date($scope.rfr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__r_f_r.date_encoded);
              $scope.rfr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__r_f_r.incoming_date = $scope.parse_date($scope.rfr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__r_f_r.incoming_date);
              $scope.rfr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__r_f_r.obligation_date = $scope.parse_date($scope.rfr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__r_f_r.obligation_date);
              $scope.rfr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__r_f_r.cash_date = $scope.parse_date($scope.rfr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__r_f_r.cash_date);

              $scope.paramObj = {
                grant: $scope.rfr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p.grant,
                other_amount: $scope.rfr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p.other_amount,
                lcc_community: $scope.rfr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p.lcc_community,
                lcc_community_ik: $scope.rfr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p.lcc_community_ik,
                lcc_blgu: $scope.rfr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p.lcc_blgu,
                lcc_blgu_ik: $scope.rfr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p.lcc_blgu_ik,
                lcc_mlgu: $scope.rfr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p.lcc_mlgu,
                lcc_mlgu_ik: $scope.rfr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p.lcc_mlgu_ik,
                lcc_plgu: $scope.rfr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p.lcc_plgu,
                lcc_plgu_ik: $scope.rfr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p.lcc_plgu_ik,
                lcc_others: $scope.rfr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p.lcc_others,
                lcc_others_ik: $scope.rfr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p.lcc_others_ik,
                lcc_cash: $scope.rfr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p.lcc_cash,
                lcc_in_kind: $scope.rfr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p.lcc_in_kind,
              }
              $scope.all_lcc = {
                other_amount: $scope.rfr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p.other_amount,
                lcc_community: $scope.rfr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p.lcc_community,
                lcc_community_ik: $scope.rfr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p.lcc_community_ik,
                lcc_blgu: $scope.rfr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p.lcc_blgu,
                lcc_blgu_ik: $scope.rfr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p.lcc_blgu_ik,
                lcc_mlgu: $scope.rfr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p.lcc_mlgu,
                lcc_mlgu_ik: $scope.rfr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p.lcc_mlgu_ik,
                lcc_plgu: $scope.rfr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p.lcc_plgu,
                lcc_plgu_ik: $scope.rfr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p.lcc_plgu_ik,
                lcc_others: $scope.rfr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p.lcc_others,
                lcc_others_ik: $scope.rfr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p.lcc_others_ik,
                lcc_cash: $scope.rfr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p.lcc_cash,
                lcc_in_kind: $scope.rfr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p.lcc_in_kind,
              }

              $scope.rfr_data.total_LCC = $scope.get_total_project_cost($scope.all_lcc); 
              $scope.rfr_data.total_cost_ni = $scope.get_total_project_cost($scope.paramObj); 
            
            }else if($scope.rfr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p != null){
              $scope.rfr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__r_f_r.received_rpmo = $scope.parse_date($scope.rfr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__r_f_r.received_rpmo);
              $scope.rfr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__r_f_r.received_socials = $scope.parse_date($scope.rfr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__r_f_r.received_socials);
              $scope.rfr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__r_f_r.received_engineering = $scope.parse_date($scope.rfr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__r_f_r.received_engineering);
              $scope.rfr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__r_f_r.received_finance = $scope.parse_date($scope.rfr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__r_f_r.received_finance);
              $scope.rfr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__r_f_r.received_npmo = $scope.parse_date($scope.rfr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__r_f_r.received_npmo);
              $scope.rfr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__r_f_r.date_encoded = $scope.parse_date($scope.rfr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__r_f_r.date_encoded);
              $scope.rfr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__r_f_r.incoming_date = $scope.parse_date($scope.rfr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__r_f_r.incoming_date);
              $scope.rfr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__r_f_r.obligation_date = $scope.parse_date($scope.rfr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__r_f_r.obligation_date);
              $scope.rfr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__r_f_r.cash_date = $scope.parse_date($scope.rfr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__r_f_r.cash_date);

              $scope.paramObj = {
                grant: $scope.rfr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p.grant,
                other_amount: $scope.rfr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p.other_amount,
                lcc_community: $scope.rfr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p.lcc_community,
                lcc_community_ik: $scope.rfr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p.lcc_community_ik,
                lcc_blgu: $scope.rfr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p.lcc_blgu,
                lcc_blgu_ik: $scope.rfr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p.lcc_blgu_ik,
                lcc_mlgu: $scope.rfr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p.lcc_mlgu,
                lcc_mlgu_ik: $scope.rfr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p.lcc_mlgu_ik,
                lcc_plgu: $scope.rfr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p.lcc_plgu,
                lcc_plgu_ik: $scope.rfr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p.lcc_plgu_ik,
                lcc_others: $scope.rfr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p.lcc_others,
                lcc_others_ik: $scope.rfr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p.lcc_others_ik,
                lcc_cash: $scope.rfr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p.lcc_cash,
                lcc_in_kind: $scope.rfr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p.lcc_in_kind,
              }
              $scope.all_lcc = {
                other_amount: $scope.rfr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p.other_amount,
                lcc_community: $scope.rfr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p.lcc_community,
                lcc_community_ik: $scope.rfr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p.lcc_community_ik,
                lcc_blgu: $scope.rfr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p.lcc_blgu,
                lcc_blgu_ik: $scope.rfr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p.lcc_blgu_ik,
                lcc_mlgu: $scope.rfr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p.lcc_mlgu,
                lcc_mlgu_ik: $scope.rfr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p.lcc_mlgu_ik,
                lcc_plgu: $scope.rfr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p.lcc_plgu,
                lcc_plgu_ik: $scope.rfr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p.lcc_plgu_ik,
                lcc_others: $scope.rfr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p.lcc_others,
                lcc_others_ik: $scope.rfr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p.lcc_others_ik,
                lcc_cash: $scope.rfr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p.lcc_cash,
                lcc_in_kind: $scope.rfr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p.lcc_in_kind,
              }

              $scope.rfr_data.total_LCC = $scope.get_total_project_cost($scope.all_lcc); 
              $scope.rfr_data.total_cost_ni = $scope.get_total_project_cost($scope.paramObj); 

            }else if($scope.rfr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p != null){
              $scope.rfr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__r_f_r.received_rpmo = $scope.parse_date($scope.rfr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__r_f_r.received_rpmo);
              $scope.rfr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__r_f_r.received_socials = $scope.parse_date($scope.rfr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__r_f_r.received_socials);
              $scope.rfr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__r_f_r.received_engineering = $scope.parse_date($scope.rfr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__r_f_r.received_engineering);
              $scope.rfr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__r_f_r.received_finance = $scope.parse_date($scope.rfr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__r_f_r.received_finance);
              $scope.rfr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__r_f_r.received_npmo = $scope.parse_date($scope.rfr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__r_f_r.received_npmo);
              $scope.rfr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__r_f_r.date_encoded = $scope.parse_date($scope.rfr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__r_f_r.date_encoded);
              $scope.rfr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__r_f_r.incoming_date = $scope.parse_date($scope.rfr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__r_f_r.incoming_date);
              $scope.rfr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__r_f_r.obligation_date = $scope.parse_date($scope.rfr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__r_f_r.obligation_date);
              $scope.rfr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__r_f_r.cash_date = $scope.parse_date($scope.rfr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__r_f_r.cash_date);

              $scope.paramObj = {
                grant: $scope.rfr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p.grant,
                other_amount: $scope.rfr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p.other_amount,
                lcc_community: $scope.rfr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p.lcc_community,
                lcc_community_ik: $scope.rfr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p.lcc_community_ik,
                lcc_blgu: $scope.rfr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p.lcc_blgu,
                lcc_blgu_ik: $scope.rfr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p.lcc_blgu_ik,
                lcc_mlgu: $scope.rfr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p.lcc_mlgu,
                lcc_mlgu_ik: $scope.rfr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p.lcc_mlgu_ik,
                lcc_plgu: $scope.rfr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p.lcc_plgu,
                lcc_plgu_ik: $scope.rfr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p.lcc_plgu_ik,
                lcc_others: $scope.rfr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p.lcc_others,
                lcc_others_ik: $scope.rfr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p.lcc_others_ik,
                lcc_cash: $scope.rfr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p.lcc_cash,
                lcc_in_kind: $scope.rfr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p.lcc_in_kind,
              }
              $scope.all_lcc = {
                other_amount: $scope.rfr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p.other_amount,
                lcc_community: $scope.rfr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p.lcc_community,
                lcc_community_ik: $scope.rfr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p.lcc_community_ik,
                lcc_blgu: $scope.rfr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p.lcc_blgu,
                lcc_blgu_ik: $scope.rfr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p.lcc_blgu_ik,
                lcc_mlgu: $scope.rfr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p.lcc_mlgu,
                lcc_mlgu_ik: $scope.rfr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p.lcc_mlgu_ik,
                lcc_plgu: $scope.rfr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p.lcc_plgu,
                lcc_plgu_ik: $scope.rfr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p.lcc_plgu_ik,
                lcc_others: $scope.rfr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p.lcc_others,
                lcc_others_ik: $scope.rfr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p.lcc_others_ik,
                lcc_cash: $scope.rfr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p.lcc_cash,
                lcc_in_kind: $scope.rfr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p.lcc_in_kind,
              }

              $scope.rfr_data.total_LCC = $scope.get_total_project_cost($scope.all_lcc); 
              $scope.rfr_data.total_cost_ni = $scope.get_total_project_cost($scope.paramObj); 
            
            }else if($scope.rfr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p != null){
              $scope.rfr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__r_f_r.received_rpmo = $scope.parse_date($scope.rfr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__r_f_r.received_rpmo);
              $scope.rfr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__r_f_r.received_socials = $scope.parse_date($scope.rfr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__r_f_r.received_socials);
              $scope.rfr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__r_f_r.received_engineering = $scope.parse_date($scope.rfr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__r_f_r.received_engineering);
              $scope.rfr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__r_f_r.received_finance = $scope.parse_date($scope.rfr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__r_f_r.received_finance);
              $scope.rfr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__r_f_r.received_npmo = $scope.parse_date($scope.rfr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__r_f_r.received_npmo);
              $scope.rfr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__r_f_r.date_encoded = $scope.parse_date($scope.rfr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__r_f_r.date_encoded);
              $scope.rfr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__r_f_r.incoming_date = $scope.parse_date($scope.rfr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__r_f_r.incoming_date);
              $scope.rfr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__r_f_r.obligation_date = $scope.parse_date($scope.rfr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__r_f_r.obligation_date);
              $scope.rfr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__r_f_r.cash_date = $scope.parse_date($scope.rfr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__r_f_r.cash_date);

              $scope.paramObj = {
                grant: $scope.rfr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p.grant,
                other_amount: $scope.rfr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p.other_amount,
                lcc_community: $scope.rfr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p.lcc_community,
                lcc_community_ik: $scope.rfr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p.lcc_community_ik,
                lcc_blgu: $scope.rfr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p.lcc_blgu,
                lcc_blgu_ik: $scope.rfr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p.lcc_blgu_ik,
                lcc_mlgu: $scope.rfr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p.lcc_mlgu,
                lcc_mlgu_ik: $scope.rfr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p.lcc_mlgu_ik,
                lcc_plgu: $scope.rfr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p.lcc_plgu,
                lcc_plgu_ik: $scope.rfr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p.lcc_plgu_ik,
                lcc_others: $scope.rfr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p.lcc_others,
                lcc_others_ik: $scope.rfr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p.lcc_others_ik,
                lcc_cash: $scope.rfr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p.lcc_cash,
                lcc_in_kind: $scope.rfr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p.lcc_in_kind,
              }
              $scope.all_lcc = {
                other_amount: $scope.rfr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p.other_amount,
                lcc_community: $scope.rfr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p.lcc_community,
                lcc_community_ik: $scope.rfr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p.lcc_community_ik,
                lcc_blgu: $scope.rfr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p.lcc_blgu,
                lcc_blgu_ik: $scope.rfr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p.lcc_blgu_ik,
                lcc_mlgu: $scope.rfr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p.lcc_mlgu,
                lcc_mlgu_ik: $scope.rfr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p.lcc_mlgu_ik,
                lcc_plgu: $scope.rfr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p.lcc_plgu,
                lcc_plgu_ik: $scope.rfr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p.lcc_plgu_ik,
                lcc_others: $scope.rfr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p.lcc_others,
                lcc_others_ik: $scope.rfr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p.lcc_others_ik,
                lcc_cash: $scope.rfr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p.lcc_cash,
                lcc_in_kind: $scope.rfr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p.lcc_in_kind,
              }

              $scope.rfr_data.total_LCC = $scope.get_total_project_cost($scope.all_lcc); 
              $scope.rfr_data.total_cost_ni = $scope.get_total_project_cost($scope.paramObj); 
            
            }else if($scope.rfr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p != null){
              $scope.rfr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__r_f_r.received_rpmo = $scope.parse_date($scope.rfr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__r_f_r.received_rpmo);
              $scope.rfr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__r_f_r.received_socials = $scope.parse_date($scope.rfr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__r_f_r.received_socials);
              $scope.rfr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__r_f_r.received_engineering = $scope.parse_date($scope.rfr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__r_f_r.received_engineering);
              $scope.rfr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__r_f_r.received_finance = $scope.parse_date($scope.rfr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__r_f_r.received_finance);
              $scope.rfr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__r_f_r.received_npmo = $scope.parse_date($scope.rfr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__r_f_r.received_npmo);
              $scope.rfr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__r_f_r.date_encoded = $scope.parse_date($scope.rfr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__r_f_r.date_encoded);
              $scope.rfr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__r_f_r.incoming_date = $scope.parse_date($scope.rfr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__r_f_r.incoming_date);
              $scope.rfr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__r_f_r.obligation_date = $scope.parse_date($scope.rfr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__r_f_r.obligation_date);
              $scope.rfr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__r_f_r.cash_date = $scope.parse_date($scope.rfr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__r_f_r.cash_date);

              $scope.paramObj = {
                grant: $scope.rfr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p.grant,
                other_amount: $scope.rfr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p.other_amount,
                lcc_community: $scope.rfr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p.lcc_community,
                lcc_community_ik: $scope.rfr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p.lcc_community_ik,
                lcc_blgu: $scope.rfr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p.lcc_blgu,
                lcc_blgu_ik: $scope.rfr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p.lcc_blgu_ik,
                lcc_mlgu: $scope.rfr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p.lcc_mlgu,
                lcc_mlgu_ik: $scope.rfr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p.lcc_mlgu_ik,
                lcc_plgu: $scope.rfr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p.lcc_plgu,
                lcc_plgu_ik: $scope.rfr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p.lcc_plgu_ik,
                lcc_others: $scope.rfr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p.lcc_others,
                lcc_others_ik: $scope.rfr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p.lcc_others_ik,
                lcc_cash: $scope.rfr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p.lcc_cash,
                lcc_in_kind: $scope.rfr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p.lcc_in_kind,
              }
              $scope.all_lcc = {
                other_amount: $scope.rfr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p.other_amount,
                lcc_community: $scope.rfr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p.lcc_community,
                lcc_community_ik: $scope.rfr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p.lcc_community_ik,
                lcc_blgu: $scope.rfr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p.lcc_blgu,
                lcc_blgu_ik: $scope.rfr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p.lcc_blgu_ik,
                lcc_mlgu: $scope.rfr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p.lcc_mlgu,
                lcc_mlgu_ik: $scope.rfr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p.lcc_mlgu_ik,
                lcc_plgu: $scope.rfr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p.lcc_plgu,
                lcc_plgu_ik: $scope.rfr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p.lcc_plgu_ik,
                lcc_others: $scope.rfr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p.lcc_others,
                lcc_others_ik: $scope.rfr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p.lcc_others_ik,
                lcc_cash: $scope.rfr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p.lcc_cash,
                lcc_in_kind: $scope.rfr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p.lcc_in_kind,
              }

              $scope.rfr_data.total_LCC = $scope.get_total_project_cost($scope.all_lcc); 
              $scope.rfr_data.total_cost_ni = $scope.get_total_project_cost($scope.paramObj); 
            
            }else;


    }, function myError(response) {});
  }

  $scope.days = function(received,encoded) {
    if(received == null){
      var date1 = new Date("0000-00-00");
    }else{
      var date1 = new Date(received);
    }
    var date2 = new Date(encoded);
    var timeDiff = Math.abs(date2.getTime() - date1.getTime());
    $scope.dayDifference = Math.ceil(timeDiff / (1000 * 3600 * 24));

    if(isNaN($scope.dayDifference) == true){
      return "0";
    }else{
      return $scope.dayDifference;
    }
  }

  $scope.check_isDate = function(date){
    if(date == "Invalid Date"){
      return false;
    }else{
      return true;
    }
  }
  // // PAGINTION
  // $scope.Next_Pagination = function(url){
  //   $http({
  //         method : "GET",
  //         url : url,
  //     }).then(function mySuccess(response) {
  //       console.log(response.data[1].data);
  //       $scope.sp_per_modality_data_on_going = response.data[0];
  //       $scope.sp_per_modality_data_completed = response.data[1];
  //       $scope.sp_per_modality_data_all_sp_logs = response.data[2];
  //       $scope.sp_per_modality_data_nys = response.data[3];

  //       for(x = 0; x < $scope.sp_per_modality_data_on_going.length; x++){
  //         $scope.sp_per_modality_data_on_going[x].sp[0].sp_rfr_first_tranche_date = $scope.parse_date($scope.sp_per_modality_data_on_going[x].sp[0].sp_rfr_first_tranche_date);
  //         $scope.sp_per_modality_data_on_going[x].sp[0].sp_date_started = $scope.parse_date($scope.sp_per_modality_data_on_going[x].sp[0].sp_date_started);
  //         $scope.sp_per_modality_data_on_going[x].sp[0].sp_date_of_turnover = $scope.parse_date($scope.sp_per_modality_data_on_going[x].sp[0].sp_date_of_turnover);
  //         $scope.sp_per_modality_data_on_going[x].sp[0].sp_target_date_of_completion = $scope.parse_date($scope.sp_per_modality_data_on_going[x].sp[0].sp_target_date_of_completion);
  //         $scope.sp_per_modality_data_on_going[x].sp[0].sp_actual_date_completed = $scope.parse_date($scope.sp_per_modality_data_on_going[x].sp[0].sp_actual_date_completed);

  //         for(y = 0; y < $scope.sp_per_modality_data_on_going[x].sp[0].sp_logs.length; y++){
  //           $scope.sp_per_modality_data_on_going[x].sp[0].sp_logs[y].updated_at = $scope.parse_date($scope.sp_per_modality_data_on_going[x].sp[0].sp_logs[y].updated_at);
  //         }
  //       }

  //       for(x = 0; x < $scope.sp_per_modality_data_nys.length; x++){
  //         $scope.sp_per_modality_data_nys[x].sp[0].sp_rfr_first_tranche_date = $scope.parse_date($scope.sp_per_modality_data_nys[x].sp[0].sp_rfr_first_tranche_date);
  //         $scope.sp_per_modality_data_nys[x].sp[0].sp_date_started = $scope.parse_date($scope.sp_per_modality_data_nys[x].sp[0].sp_date_started);
  //         $scope.sp_per_modality_data_nys[x].sp[0].sp_date_of_turnover = $scope.parse_date($scope.sp_per_modality_data_nys[x].sp[0].sp_date_of_turnover);
  //         $scope.sp_per_modality_data_nys[x].sp[0].sp_target_date_of_completion = $scope.parse_date($scope.sp_per_modality_data_nys[x].sp[0].sp_target_date_of_completion);
  //         $scope.sp_per_modality_data_nys[x].sp[0].sp_actual_date_completed = $scope.parse_date($scope.sp_per_modality_data_nys[x].sp[0].sp_actual_date_completed);

  //         for(y = 0; y < $scope.sp_per_modality_data_nys[x].sp[0].sp_logs.length; y++){
  //           $scope.sp_per_modality_data_nys[x].sp[0].sp_logs[y].updated_at = $scope.parse_date($scope.sp_per_modality_data_nys[x].sp[0].sp_logs[y].updated_at);
  //         }
  //       }

  //       for(x = 0; x < $scope.sp_per_modality_data_completed.length; x++){
  //         // $scope.sp_per_modality_data_completed[x].sp[0].sp_rfr_first_tranche_date = $scope.parse_date($scope.sp_per_modality_data_completed[x].sp[0].sp_rfr_first_tranche_date);
  //         $scope.sp_per_modality_data_completed[x].sp[0].sp_date_started = $scope.parse_date($scope.sp_per_modality_data_completed[x].sp[0].sp_date_started);
  //         $scope.sp_per_modality_data_completed[x].sp[0].sp_date_of_turnover = $scope.parse_date($scope.sp_per_modality_data_completed[x].sp[0].sp_date_of_turnover);
  //         $scope.sp_per_modality_data_completed[x].sp[0].sp_target_date_of_completion = $scope.parse_date($scope.sp_per_modality_data_completed[x].sp[0].sp_target_date_of_completion);
  //         $scope.sp_per_modality_data_completed[x].sp[0].sp_actual_date_completed = $scope.parse_date($scope.sp_per_modality_data_completed[x].sp[0].sp_actual_date_completed);
  //         // console.log($scope.sp_per_modality_data_completed[x].sp_rfr_first_tranche_date);
  //       }
  //     }, function myError(response) {
      
  //   });
  // }

  // $scope.Previous_Pagination = function (url){
  //   console.log(url);
  //   $http({
  //         method : "GET",
  //         url : url,
  //     }).then(function mySuccess(response) {
  //     console.log(response.data[1].data);
  //       $scope.sp_per_modality_data_on_going = response.data[0];
  //       $scope.sp_per_modality_data_completed = response.data[1];
  //       $scope.sp_per_modality_data_all_sp_logs = response.data[2];
  //       $scope.sp_per_modality_data_nys = response.data[3];

  //       for(x = 0; x < $scope.sp_per_modality_data_on_going.length; x++){
  //         $scope.sp_per_modality_data_on_going[x].sp[0].sp_rfr_first_tranche_date = $scope.parse_date($scope.sp_per_modality_data_on_going[x].sp[0].sp_rfr_first_tranche_date);
  //         $scope.sp_per_modality_data_on_going[x].sp[0].sp_date_started = $scope.parse_date($scope.sp_per_modality_data_on_going[x].sp[0].sp_date_started);
  //         $scope.sp_per_modality_data_on_going[x].sp[0].sp_date_of_turnover = $scope.parse_date($scope.sp_per_modality_data_on_going[x].sp[0].sp_date_of_turnover);
  //         $scope.sp_per_modality_data_on_going[x].sp[0].sp_target_date_of_completion = $scope.parse_date($scope.sp_per_modality_data_on_going[x].sp[0].sp_target_date_of_completion);
  //         $scope.sp_per_modality_data_on_going[x].sp[0].sp_actual_date_completed = $scope.parse_date($scope.sp_per_modality_data_on_going[x].sp[0].sp_actual_date_completed);

  //         for(y = 0; y < $scope.sp_per_modality_data_on_going[x].sp[0].sp_logs.length; y++){
  //           $scope.sp_per_modality_data_on_going[x].sp[0].sp_logs[y].updated_at = $scope.parse_date($scope.sp_per_modality_data_on_going[x].sp[0].sp_logs[y].updated_at);
  //         }
  //       }

  //       for(x = 0; x < $scope.sp_per_modality_data_nys.length; x++){
  //         $scope.sp_per_modality_data_nys[x].sp[0].sp_rfr_first_tranche_date = $scope.parse_date($scope.sp_per_modality_data_nys[x].sp[0].sp_rfr_first_tranche_date);
  //         $scope.sp_per_modality_data_nys[x].sp[0].sp_date_started = $scope.parse_date($scope.sp_per_modality_data_nys[x].sp[0].sp_date_started);
  //         $scope.sp_per_modality_data_nys[x].sp[0].sp_date_of_turnover = $scope.parse_date($scope.sp_per_modality_data_nys[x].sp[0].sp_date_of_turnover);
  //         $scope.sp_per_modality_data_nys[x].sp[0].sp_target_date_of_completion = $scope.parse_date($scope.sp_per_modality_data_nys[x].sp[0].sp_target_date_of_completion);
  //         $scope.sp_per_modality_data_nys[x].sp[0].sp_actual_date_completed = $scope.parse_date($scope.sp_per_modality_data_nys[x].sp[0].sp_actual_date_completed);

  //         for(y = 0; y < $scope.sp_per_modality_data_nys[x].sp[0].sp_logs.length; y++){
  //           $scope.sp_per_modality_data_nys[x].sp[0].sp_logs[y].updated_at = $scope.parse_date($scope.sp_per_modality_data_nys[x].sp[0].sp_logs[y].updated_at);
  //         }
  //       }

  //       for(x = 0; x < $scope.sp_per_modality_data_completed.length; x++){
  //         // $scope.sp_per_modality_data_completed[x].sp[0].sp_rfr_first_tranche_date = $scope.parse_date($scope.sp_per_modality_data_completed[x].sp[0].sp_rfr_first_tranche_date);
  //         $scope.sp_per_modality_data_completed[x].sp[0].sp_date_started = $scope.parse_date($scope.sp_per_modality_data_completed[x].sp[0].sp_date_started);
  //         $scope.sp_per_modality_data_completed[x].sp[0].sp_date_of_turnover = $scope.parse_date($scope.sp_per_modality_data_completed[x].sp[0].sp_date_of_turnover);
  //         $scope.sp_per_modality_data_completed[x].sp[0].sp_target_date_of_completion = $scope.parse_date($scope.sp_per_modality_data_completed[x].sp[0].sp_target_date_of_completion);
  //         $scope.sp_per_modality_data_completed[x].sp[0].sp_actual_date_completed = $scope.parse_date($scope.sp_per_modality_data_completed[x].sp[0].sp_actual_date_completed);
  //         // console.log($scope.sp_per_modality_data_completed[x].sp_rfr_first_tranche_date);
  //       }

  //     }, function myError(response) {
      
  //   });
  // }

  // $scope.Skip_To_Page = function(path,Page_Number){
  //   console.log(path);
  //   console.log(Page_Number);
  //   $http({
  //     method : "GET",
  //     url: path+"?page="+Page_Number,
  //   }).then(function mySuccess(response) {
  //       $scope.sp_per_modality_data_on_going = response.data[0];
  //       $scope.sp_per_modality_data_completed = response.data[1];
  //       $scope.sp_per_modality_data_all_sp_logs = response.data[2];
  //       $scope.sp_per_modality_data_nys = response.data[3];

  //       for(x = 0; x < $scope.sp_per_modality_data_on_going.length; x++){
  //         $scope.sp_per_modality_data_on_going[x].sp[0].sp_rfr_first_tranche_date = $scope.parse_date($scope.sp_per_modality_data_on_going[x].sp[0].sp_rfr_first_tranche_date);
  //         $scope.sp_per_modality_data_on_going[x].sp[0].sp_date_started = $scope.parse_date($scope.sp_per_modality_data_on_going[x].sp[0].sp_date_started);
  //         $scope.sp_per_modality_data_on_going[x].sp[0].sp_date_of_turnover = $scope.parse_date($scope.sp_per_modality_data_on_going[x].sp[0].sp_date_of_turnover);
  //         $scope.sp_per_modality_data_on_going[x].sp[0].sp_target_date_of_completion = $scope.parse_date($scope.sp_per_modality_data_on_going[x].sp[0].sp_target_date_of_completion);
  //         $scope.sp_per_modality_data_on_going[x].sp[0].sp_actual_date_completed = $scope.parse_date($scope.sp_per_modality_data_on_going[x].sp[0].sp_actual_date_completed);

  //         for(y = 0; y < $scope.sp_per_modality_data_on_going[x].sp[0].sp_logs.length; y++){
  //           $scope.sp_per_modality_data_on_going[x].sp[0].sp_logs[y].updated_at = $scope.parse_date($scope.sp_per_modality_data_on_going[x].sp[0].sp_logs[y].updated_at);
  //         }
  //       }

  //       for(x = 0; x < $scope.sp_per_modality_data_nys.length; x++){
  //         $scope.sp_per_modality_data_nys[x].sp[0].sp_rfr_first_tranche_date = $scope.parse_date($scope.sp_per_modality_data_nys[x].sp[0].sp_rfr_first_tranche_date);
  //         $scope.sp_per_modality_data_nys[x].sp[0].sp_date_started = $scope.parse_date($scope.sp_per_modality_data_nys[x].sp[0].sp_date_started);
  //         $scope.sp_per_modality_data_nys[x].sp[0].sp_date_of_turnover = $scope.parse_date($scope.sp_per_modality_data_nys[x].sp[0].sp_date_of_turnover);
  //         $scope.sp_per_modality_data_nys[x].sp[0].sp_target_date_of_completion = $scope.parse_date($scope.sp_per_modality_data_nys[x].sp[0].sp_target_date_of_completion);
  //         $scope.sp_per_modality_data_nys[x].sp[0].sp_actual_date_completed = $scope.parse_date($scope.sp_per_modality_data_nys[x].sp[0].sp_actual_date_completed);

  //         for(y = 0; y < $scope.sp_per_modality_data_nys[x].sp[0].sp_logs.length; y++){
  //           $scope.sp_per_modality_data_nys[x].sp[0].sp_logs[y].updated_at = $scope.parse_date($scope.sp_per_modality_data_nys[x].sp[0].sp_logs[y].updated_at);
  //         }
  //       }
        
  //       for(x = 0; x < $scope.sp_per_modality_data_completed.length; x++){
  //         // $scope.sp_per_modality_data_completed[x].sp[0].sp_rfr_first_tranche_date = $scope.parse_date($scope.sp_per_modality_data_completed[x].sp[0].sp_rfr_first_tranche_date);
  //         $scope.sp_per_modality_data_completed[x].sp[0].sp_date_started = $scope.parse_date($scope.sp_per_modality_data_completed[x].sp[0].sp_date_started);
  //         $scope.sp_per_modality_data_completed[x].sp[0].sp_date_of_turnover = $scope.parse_date($scope.sp_per_modality_data_completed[x].sp[0].sp_date_of_turnover);
  //         $scope.sp_per_modality_data_completed[x].sp[0].sp_target_date_of_completion = $scope.parse_date($scope.sp_per_modality_data_completed[x].sp[0].sp_target_date_of_completion);
  //         $scope.sp_per_modality_data_completed[x].sp[0].sp_actual_date_completed = $scope.parse_date($scope.sp_per_modality_data_completed[x].sp[0].sp_actual_date_completed);
  //         // console.log($scope.sp_per_modality_data_completed[x].sp_rfr_first_tranche_date);
  //       }

  //   }, function myError(response) {

  //   });
  // }
  // // PAGINTION

  $scope.for_charts_data = function(data){
    console.log(data);
    // for(var i = 0; i < data.length; i++){

    // }

    $scope.chart_slippage = [];
    $scope.chart_planned = [];
    $scope.chart_actual = [];
    $scope.chart_labels = [];
    $scope.sp_chart_data = [];

    for(var x = 0; x < data.length; x++){
      console.log(data[x].sp[0]);
      for(var y = 0; y < data[x].sp[0].sp_logs.length; y++){
        console.log(data[x].sp[y].sp_logs[y]);
      }
      // $scope.chart_slippage.push(data[x].sp[0].sp_logs[x].sp_logs_slippage);
      // $scope.chart_planned.push(data[x].sp[0].sp_logs[x].sp_logs_planned);
      // $scope.chart_actual.push(data[x].sp[0].sp_logs[x].sp_logs_actual);
      // $scope.chart_labels.push(data[x].sp[0].sp_logs[x].sp_logs_planned_target_date);
    }

    // console.log($scope.chart_slippage);
    // console.log($scope.chart_planned);
    // console.log($scope.chart_actual);
    // console.log($scope.chart_labels);

  }

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

  function js_yyyy_mm_dd (input) {
    if(input == null){
        return null;
    }else{
      var now =  new Date(input);
      year = "" + now.getFullYear();
      month = "" + (now.getMonth() + 1); if (month.length == 1) { month = "0" + month; }
      day = "" + now.getDate(); if (day.length == 1) { day = "0" + day; }
      hour = "" + now.getHours(); if (hour.length == 1) { hour = "0" + hour; }
      minute = "" + now.getMinutes(); if (minute.length == 1) { minute = "0" + minute; }
      second = "" + now.getSeconds(); if (second.length == 1) { second = "0" + second; }
      return year + "-" + month + "-" + day;
    }
  }

  // PLANNED
  // $scope.planned = function(id) {
  //   $scope.collapse_id = id;
  //   console.log($scope.collapse_id);
  // }

  $scope.create_planned_logs = function(data,sp_id){
    $scope.datashit = data;
    for(var i = 0; i < $scope.datashit.length; i++){
      $scope.datashit[i].target_date =  new Date(js_yyyy_mm_dd($scope.datashit[i].target_date));
      console.log($scope.datashit[i].target_date);
    }

    console.log("DATASHIT");
    console.log($scope.datashit);

    var datax = {
        obj:$scope.datashit,
        sp_id:sp_id,
    }

    $http({
        method : "POST",
        url : 'create_planned_logs',
        data : datax,
    }).then(function mySuccess(response) {
        console.log(response.data);

        if(response.data == 1){
          Swal.fire({
            title: 'Yahoooo!',
            text: "SP Plans successfuly encoded",
            icon: 'success',
          }).then(function() {
            // window.location.href="/"+"dac/routes/show_modality";
            $('#collapseExample'+sp_id).collapse('hide');
            $scope.my_subprojects();
          });

        }else{
          Swal.fire({
            title: 'Oooops!',
            text: "There must be a problem",
            icon: 'error',
          }).then(function() {
            // window.location.href="/"+"dac/routes/show_modality";
            $('#collapseExample'+sp_id).collapse('hide');
            $scope.my_subprojects();
          });
        }
    }, function myError(response) {
      
    });
  }

  $scope.planned_data = [];
  $scope.add_planned = function() {
    var newUser = {};
    $scope.planned_data.push(newUser);
    console.log($scope.planned_data);
  }

  $scope.remove_planned = function(user) {
    var index = $scope.planned_data.indexOf(user);
    $scope.planned_data.splice(index,1);
  }

  $scope.curr_date = new Date();
  $scope.curr_date = js_yyyy_mm_dd($scope.curr_date);

  // PLANNED

  $scope.view_specific_sp_data = function(data){
    console.log("view_specific_sp_data");
    console.log(data.sp[0].sp_logs);
  	$scope.specific_sp_data = data;

    for(var y = 0; y < $scope.specific_sp_data.sp[0].sp_pmr.length; y++){
      $scope.specific_sp_data.sp[0].sp_pmr[y].created_at = $scope.parse_date($scope.specific_sp_data.sp[0].sp_pmr[y].created_at);
    }

    // BUB
    if($scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2015__b_u_b__s_p != null){
      $scope.paramObj = {
        grant: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2015__b_u_b__s_p.grant,
        contigency: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2015__b_u_b__s_p.contigency,
        other_amount: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2015__b_u_b__s_p.other_amount,
        lcc_community: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2015__b_u_b__s_p.lcc_community,
        lcc_community_ik: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2015__b_u_b__s_p.lcc_community_ik,
        lcc_blgu: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2015__b_u_b__s_p.lcc_blgu,
        lcc_blgu_ik: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2015__b_u_b__s_p.lcc_blgu_ik,
        lcc_mlgu: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2015__b_u_b__s_p.lcc_mlgu,
        lcc_mlgu_ik: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2015__b_u_b__s_p.lcc_mlgu_ik,
        lcc_plgu: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2015__b_u_b__s_p.lcc_plgu,
        lcc_plgu_ik: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2015__b_u_b__s_p.lcc_plgu_ik,
        lcc_others: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2015__b_u_b__s_p.lcc_others,
        lcc_others_ik: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2015__b_u_b__s_p.lcc_others_ik,
        lcc_cash: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2015__b_u_b__s_p.lcc_cash,
        lcc_in_kind: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2015__b_u_b__s_p.lcc_in_kind,
      }
      $scope.total_project_cost = $scope.get_total_project_cost($scope.paramObj); 
    
    }else if($scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2016__b_u_b__s_p != null){
      $scope.paramObj = {
        grant: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2016__b_u_b__s_p.grant,
        contigency: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2016__b_u_b__s_p.contigency,
        other_amount: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2016__b_u_b__s_p.other_amount,
        lcc_community: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2016__b_u_b__s_p.lcc_community,
        lcc_community_ik: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2016__b_u_b__s_p.lcc_community_ik,
        lcc_blgu: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2016__b_u_b__s_p.lcc_blgu,
        lcc_blgu_ik: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2016__b_u_b__s_p.lcc_blgu_ik,
        lcc_mlgu: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2016__b_u_b__s_p.lcc_mlgu,
        lcc_mlgu_ik: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2016__b_u_b__s_p.lcc_mlgu_ik,
        lcc_plgu: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2016__b_u_b__s_p.lcc_plgu,
        lcc_plgu_ik: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2016__b_u_b__s_p.lcc_plgu_ik,
        lcc_others: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2016__b_u_b__s_p.lcc_others,
        lcc_others_ik: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2016__b_u_b__s_p.lcc_others_ik,
        lcc_cash: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2016__b_u_b__s_p.lcc_cash,
        lcc_in_kind: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2016__b_u_b__s_p.lcc_in_kind,
      }
      $scope.total_project_cost = $scope.get_total_project_cost($scope.paramObj); 
    
    }else if($scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2017__b_u_b__s_p != null){
      $scope.paramObj = {
        grant: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2017__b_u_b__s_p.grant,
        contigency: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2017__b_u_b__s_p.contigency,
        other_amount: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2017__b_u_b__s_p.other_amount,
        lcc_community: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2017__b_u_b__s_p.lcc_community,
        lcc_community_ik: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2017__b_u_b__s_p.lcc_community_ik,
        lcc_blgu: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2017__b_u_b__s_p.lcc_blgu,
        lcc_blgu_ik: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2017__b_u_b__s_p.lcc_blgu_ik,
        lcc_mlgu: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2017__b_u_b__s_p.lcc_mlgu,
        lcc_mlgu_ik: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2017__b_u_b__s_p.lcc_mlgu_ik,
        lcc_plgu: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2017__b_u_b__s_p.lcc_plgu,
        lcc_plgu_ik: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2017__b_u_b__s_p.lcc_plgu_ik,
        lcc_others: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2017__b_u_b__s_p.lcc_others,
        lcc_others_ik: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2017__b_u_b__s_p.lcc_others_ik,
        lcc_cash: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2017__b_u_b__s_p.lcc_cash,
        lcc_in_kind: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2017__b_u_b__s_p.lcc_in_kind,
      }
      $scope.total_project_cost = $scope.get_total_project_cost($scope.paramObj); 

    }else if($scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2018__b_u_b__s_p != null){
      $scope.paramObj = {
        grant: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2018__b_u_b__s_p.grant,
        contigency: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2018__b_u_b__s_p.contigency,
        other_amount: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2018__b_u_b__s_p.other_amount,
        lcc_community: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2018__b_u_b__s_p.lcc_community,
        lcc_community_ik: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2018__b_u_b__s_p.lcc_community_ik,
        lcc_blgu: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2018__b_u_b__s_p.lcc_blgu,
        lcc_blgu_ik: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2018__b_u_b__s_p.lcc_blgu_ik,
        lcc_mlgu: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2018__b_u_b__s_p.lcc_mlgu,
        lcc_mlgu_ik: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2018__b_u_b__s_p.lcc_mlgu_ik,
        lcc_plgu: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2018__b_u_b__s_p.lcc_plgu,
        lcc_plgu_ik: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2018__b_u_b__s_p.lcc_plgu_ik,
        lcc_others: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2018__b_u_b__s_p.lcc_others,
        lcc_others_ik: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2018__b_u_b__s_p.lcc_others_ik,
        lcc_cash: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2018__b_u_b__s_p.lcc_cash,
        lcc_in_kind: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2018__b_u_b__s_p.lcc_in_kind,
      }
      $scope.total_project_cost = $scope.get_total_project_cost($scope.paramObj); 
    
    }else if($scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2020__b_u_b__s_p != null){
      $scope.paramObj = {
        grant: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2020__b_u_b__s_p.grant,
        contigency: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2020__b_u_b__s_p.contigency,
        other_amount: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2020__b_u_b__s_p.other_amount,
        lcc_community: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2020__b_u_b__s_p.lcc_community,
        lcc_community_ik: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2020__b_u_b__s_p.lcc_community_ik,
        lcc_blgu: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2020__b_u_b__s_p.lcc_blgu,
        lcc_blgu_ik: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2020__b_u_b__s_p.lcc_blgu_ik,
        lcc_mlgu: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2020__b_u_b__s_p.lcc_mlgu,
        lcc_mlgu_ik: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2020__b_u_b__s_p.lcc_mlgu_ik,
        lcc_plgu: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2020__b_u_b__s_p.lcc_plgu,
        lcc_plgu_ik: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2020__b_u_b__s_p.lcc_plgu_ik,
        lcc_others: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2020__b_u_b__s_p.lcc_others,
        lcc_others_ik: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2020__b_u_b__s_p.lcc_others_ik,
        lcc_cash: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2020__b_u_b__s_p.lcc_cash,
        lcc_in_kind: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2020__b_u_b__s_p.lcc_in_kind,
      }
      $scope.total_project_cost = $scope.get_total_project_cost($scope.paramObj); 

    }else;

    // NCDDP

    if($scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2015__n_c_d_d_p__s_p != null){
      $scope.paramObj = {
        grant: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2015__n_c_d_d_p__s_p.grant,
        contigency: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2015__n_c_d_d_p__s_p.contigency,
        other_amount: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2015__n_c_d_d_p__s_p.other_amount,
        lcc_community: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2015__n_c_d_d_p__s_p.lcc_community,
        lcc_community_ik: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2015__n_c_d_d_p__s_p.lcc_community_ik,
        lcc_blgu: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2015__n_c_d_d_p__s_p.lcc_blgu,
        lcc_blgu_ik: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2015__n_c_d_d_p__s_p.lcc_blgu_ik,
        lcc_mlgu: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2015__n_c_d_d_p__s_p.lcc_mlgu,
        lcc_mlgu_ik: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2015__n_c_d_d_p__s_p.lcc_mlgu_ik,
        lcc_plgu: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2015__n_c_d_d_p__s_p.lcc_plgu,
        lcc_plgu_ik: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2015__n_c_d_d_p__s_p.lcc_plgu_ik,
        lcc_others: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2015__n_c_d_d_p__s_p.lcc_others,
        lcc_others_ik: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2015__n_c_d_d_p__s_p.lcc_others_ik,
        lcc_cash: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2015__n_c_d_d_p__s_p.lcc_cash,
        lcc_in_kind: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2015__n_c_d_d_p__s_p.lcc_in_kind,
      }
      $scope.total_project_cost = $scope.get_total_project_cost($scope.paramObj); 
    
    }else if($scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2016__n_c_d_d_p__s_p != null){
      $scope.paramObj = {
        grant: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2016__n_c_d_d_p__s_p.grant,
        contigency: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2016__n_c_d_d_p__s_p.contigency,
        other_amount: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2016__n_c_d_d_p__s_p.other_amount,
        lcc_community: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2016__n_c_d_d_p__s_p.lcc_community,
        lcc_community_ik: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2016__n_c_d_d_p__s_p.lcc_community_ik,
        lcc_blgu: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2016__n_c_d_d_p__s_p.lcc_blgu,
        lcc_blgu_ik: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2016__n_c_d_d_p__s_p.lcc_blgu_ik,
        lcc_mlgu: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2016__n_c_d_d_p__s_p.lcc_mlgu,
        lcc_mlgu_ik: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2016__n_c_d_d_p__s_p.lcc_mlgu_ik,
        lcc_plgu: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2016__n_c_d_d_p__s_p.lcc_plgu,
        lcc_plgu_ik: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2016__n_c_d_d_p__s_p.lcc_plgu_ik,
        lcc_others: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2016__n_c_d_d_p__s_p.lcc_others,
        lcc_others_ik: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2016__n_c_d_d_p__s_p.lcc_others_ik,
        lcc_cash: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2016__n_c_d_d_p__s_p.lcc_cash,
        lcc_in_kind: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2016__n_c_d_d_p__s_p.lcc_in_kind,
      }
      $scope.total_project_cost = $scope.get_total_project_cost($scope.paramObj); 
    
    }else if($scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2017__n_c_d_d_p__s_p != null){
      $scope.paramObj = {
        grant: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2017__n_c_d_d_p__s_p.grant,
        contigency: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2017__n_c_d_d_p__s_p.contigency,
        other_amount: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2017__n_c_d_d_p__s_p.other_amount,
        lcc_community: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2017__n_c_d_d_p__s_p.lcc_community,
        lcc_community_ik: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2017__n_c_d_d_p__s_p.lcc_community_ik,
        lcc_blgu: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2017__n_c_d_d_p__s_p.lcc_blgu,
        lcc_blgu_ik: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2017__n_c_d_d_p__s_p.lcc_blgu_ik,
        lcc_mlgu: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2017__n_c_d_d_p__s_p.lcc_mlgu,
        lcc_mlgu_ik: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2017__n_c_d_d_p__s_p.lcc_mlgu_ik,
        lcc_plgu: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2017__n_c_d_d_p__s_p.lcc_plgu,
        lcc_plgu_ik: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2017__n_c_d_d_p__s_p.lcc_plgu_ik,
        lcc_others: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2017__n_c_d_d_p__s_p.lcc_others,
        lcc_others_ik: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2017__n_c_d_d_p__s_p.lcc_others_ik,
        lcc_cash: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2017__n_c_d_d_p__s_p.lcc_cash,
        lcc_in_kind: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2017__n_c_d_d_p__s_p.lcc_in_kind,
      }
      $scope.total_project_cost = $scope.get_total_project_cost($scope.paramObj); 

    }else if($scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2018__n_c_d_d_p__s_p != null){
      $scope.paramObj = {
        grant: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2018__n_c_d_d_p__s_p.grant,
        contigency: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2018__n_c_d_d_p__s_p.contigency,
        other_amount: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2018__n_c_d_d_p__s_p.other_amount,
        lcc_community: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2018__n_c_d_d_p__s_p.lcc_community,
        lcc_community_ik: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2018__n_c_d_d_p__s_p.lcc_community_ik,
        lcc_blgu: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2018__n_c_d_d_p__s_p.lcc_blgu,
        lcc_blgu_ik: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2018__n_c_d_d_p__s_p.lcc_blgu_ik,
        lcc_mlgu: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2018__n_c_d_d_p__s_p.lcc_mlgu,
        lcc_mlgu_ik: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2018__n_c_d_d_p__s_p.lcc_mlgu_ik,
        lcc_plgu: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2018__n_c_d_d_p__s_p.lcc_plgu,
        lcc_plgu_ik: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2018__n_c_d_d_p__s_p.lcc_plgu_ik,
        lcc_others: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2018__n_c_d_d_p__s_p.lcc_others,
        lcc_others_ik: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2018__n_c_d_d_p__s_p.lcc_others_ik,
        lcc_cash: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2018__n_c_d_d_p__s_p.lcc_cash,
        lcc_in_kind: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2018__n_c_d_d_p__s_p.lcc_in_kind,
      }
      $scope.total_project_cost = $scope.get_total_project_cost($scope.paramObj); 
    
    }else if($scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2019__n_c_d_d_p__s_p != null){
      $scope.paramObj = {
        grant: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2019__n_c_d_d_p__s_p.grant,
        contigency: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2019__n_c_d_d_p__s_p.contigency,
        other_amount: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2019__n_c_d_d_p__s_p.other_amount,
        lcc_community: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2019__n_c_d_d_p__s_p.lcc_community,
        lcc_community_ik: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2019__n_c_d_d_p__s_p.lcc_community_ik,
        lcc_blgu: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2019__n_c_d_d_p__s_p.lcc_blgu,
        lcc_blgu_ik: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2019__n_c_d_d_p__s_p.lcc_blgu_ik,
        lcc_mlgu: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2019__n_c_d_d_p__s_p.lcc_mlgu,
        lcc_mlgu_ik: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2019__n_c_d_d_p__s_p.lcc_mlgu_ik,
        lcc_plgu: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2019__n_c_d_d_p__s_p.lcc_plgu,
        lcc_plgu_ik: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2019__n_c_d_d_p__s_p.lcc_plgu_ik,
        lcc_others: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2019__n_c_d_d_p__s_p.lcc_others,
        lcc_others_ik: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2019__n_c_d_d_p__s_p.lcc_others_ik,
        lcc_cash: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2019__n_c_d_d_p__s_p.lcc_cash,
        lcc_in_kind: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2019__n_c_d_d_p__s_p.lcc_in_kind,
      }
      $scope.total_project_cost = $scope.get_total_project_cost($scope.paramObj); 
    
    }else if($scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2020__n_c_d_d_p__s_p != null){
      $scope.paramObj = {
        grant: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2020__n_c_d_d_p__s_p.grant,
        contigency: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2020__n_c_d_d_p__s_p.contigency,
        other_amount: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2020__n_c_d_d_p__s_p.other_amount,
        lcc_community: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2020__n_c_d_d_p__s_p.lcc_community,
        lcc_community_ik: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2020__n_c_d_d_p__s_p.lcc_community_ik,
        lcc_blgu: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2020__n_c_d_d_p__s_p.lcc_blgu,
        lcc_blgu_ik: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2020__n_c_d_d_p__s_p.lcc_blgu_ik,
        lcc_mlgu: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2020__n_c_d_d_p__s_p.lcc_mlgu,
        lcc_mlgu_ik: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2020__n_c_d_d_p__s_p.lcc_mlgu_ik,
        lcc_plgu: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2020__n_c_d_d_p__s_p.lcc_plgu,
        lcc_plgu_ik: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2020__n_c_d_d_p__s_p.lcc_plgu_ik,
        lcc_others: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2020__n_c_d_d_p__s_p.lcc_others,
        lcc_others_ik: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2020__n_c_d_d_p__s_p.lcc_others_ik,
        lcc_cash: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2020__n_c_d_d_p__s_p.lcc_cash,
        lcc_in_kind: $scope.specific_sp_data.sp[0].c_m_f_s_kalahi_2020__n_c_d_d_p__s_p.lcc_in_kind,
      }
      $scope.total_project_cost = $scope.get_total_project_cost($scope.paramObj); 
    
    }else;

    $http({
        method : "GET",
        url : 'fetch_specific_modality_sp_logs_length/'+$scope.specific_sp_data.sp[0].sp_id,
    }).then(function mySuccess(response) {
        console.log('fetch_specific_modality_sp_logs_length');
        console.log(response.data);
        $scope.specific_sp_logs_length = response.data;
        console.log($scope.specific_sp_logs_length.length);

    }, function myError(response) {});
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

  $scope.myChart_div = false;
  $scope.view_specific_sp_data_dashboard = function(my_sp){
    $scope.myChart_div = true;

    $scope.specific_chart_sp = my_sp;
    console.log($scope.specific_chart_sp);

    $scope.chart_slippage = [];
    $scope.chart_planned = [];
    $scope.chart_actual = [];
    $scope.chart_labels = [];
    $scope.sp_chart_data = [];

    for(var x = 0; x < $scope.specific_chart_sp.sp[0].sp_logs.length; x++){
      $scope.chart_slippage.push($scope.specific_chart_sp.sp[0].sp_logs[x].sp_logs_slippage);
      $scope.chart_planned.push($scope.specific_chart_sp.sp[0].sp_logs[x].sp_logs_planned);
      $scope.chart_actual.push($scope.specific_chart_sp.sp[0].sp_logs[x].sp_logs_actual);
      $scope.chart_labels.push($scope.specific_chart_sp.sp[0].sp_logs[x].sp_logs_planned_target_date);
    }
    // console.log($scope.chart_slippage);
    // console.log($scope.chart_planned);
    // console.log($scope.chart_actual);
    // console.log($scope.chart_labels);

    $scope.chart_dashboard($scope.chart_slippage,$scope.chart_planned,$scope.chart_actual,$scope.chart_labels);
    ////////////// CHARTS
  }

  $scope.chart_dashboard = function(chart_slippage,chart_planned,chart_actual,chart_labels){
    ////////////// CHARTS
    var ctx = document.getElementById("myChart").getContext('2d');
    var config = {
        type: 'line',
        data: {
            labels: chart_labels,
            datasets: [
            {
                label: 'Slippage', // Name the series
                data: chart_slippage, // Specify the data values array
                fill: false,
                borderColor: '#dc3545', // Add custom color border (Line)
                backgroundColor: '#dc3545', // Add custom color background (Points and Fill)
                borderWidth: 1, // Specify bar border width,
                lineTension: 0,
                pointRadius: 5,
                pointHitRadius: 10,
            },
            {
                label: 'Planned', // Name the series
                data: chart_planned, // Specify the data values array
                fill: false,
                borderColor: '#fd7e14', // Add custom color border (Line)
                backgroundColor: '#fd7e14', // Add custom color background (Points and Fill)
                borderWidth: 1, // Specify bar border width,
                lineTension: 0,
                pointRadius: 5,
                pointHitRadius: 10,
            },
            {
                label: 'Actual', // Name the series
                data: chart_actual, // Specify the data values array
                fill: false,
                borderColor: '#2196f3', // Add custom color border (Line)
                backgroundColor: '#2196f3', // Add custom color background (Points and Fill)
                borderWidth: 1, // Specify bar border width,
                lineTension: 0,
                pointRadius: 5,
                pointHitRadius: 10,
            },
        ]},
        options: {
          responsive: true, // Instruct chart js to respond nicely.
          maintainAspectRatio: false, // Add to prevent default behaviour of full-width/height 
          scales: {
              yAxes: [{
                  ticks: {
                      beginAtZero: false,
                      stepSize: 10,
                  }
              }]
          },
          tooltips: {
            mode: 'index',
            intersect: false,
            position: 'nearest',
          },
          hover: {
            mode: 'index',
            intersect: true
          }
        }
    };
    var myChart = new Chart(ctx, config);
    myChart.update();
  }

  $scope.Slippage_data = "";
  $scope.calc_slippage = function(act,pln){
    var actual = parseFloat(act);
    var planned = parseFloat(pln);
    $scope.Slippage_data = (actual - planned) / 100 * 100;
    // console.log(typeof actual);
    // console.log(typeof planned);
    // console.log($scope.Slippage_data);
  }

  $scope.update_sp_data = false;
  $scope.saveBtn = false;
  $scope.updateBtn = true;

  $scope.sum_pmr_fields = function(type,field1,field2){
    if(type == 1){
      console.log(field1);
      console.log(field2);

      // $scope.abc_total = field1+field2;
      // console.log($scope.abc_total);
    }else{
      $scope.contract_cost_total = field1+field2;
      // console.log($scope.contract_cost_total);
    }
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
        $('#pmr_modal').modal('hide');

        if(response.data == 1){
          Swal.fire({
            title: 'Yahoooo!',
            text: "PMR successfuly created",
            icon: 'success',
          }).then(function() {
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
            
            window.location.href="/"+"dac/routes/show_modality";
          });
          // $scope.fetch_dac_modality_sp();
        }else{
          Swal.fire({
            title: 'Oooops!',
            text: "There must be a problem",
            icon: 'error',
          });
        }
    }, function myError(response) {});

  }

  $scope.fetch_specific_pmr_data = function(data) {
    console.log(data);
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

    // for(var x = 0; x < $scope.specific_pmr_data.sp_pmr_logs.length; x++){
    //   $scope.specific_pmr_data.sp_pmr_logs[x].created_at = $scope.parse_date($scope.specific_pmr_data.sp_pmr_logs[x].created_at);
    //   $scope.specific_pmr_data.sp_pmr_logs[x].updated_at = $scope.parse_date($scope.specific_pmr_data.sp_pmr_logs[x].updated_at);
    // }
    // push
    $scope.specific_pmr_data.apa_acceptance = $scope.parse_date($scope.specific_pmr_data.apa_acceptance);
    $scope.specific_pmr_data.apa_ads = $scope.parse_date($scope.specific_pmr_data.apa_ads);
    
    $scope.specific_pmr_data.bac_reso_recom_award = $scope.parse_date($scope.specific_pmr_data.bac_reso_recom_award);
    $scope.specific_pmr_data.apa_contract_review_date = $scope.parse_date($scope.specific_pmr_data.apa_contract_review_date);
    $scope.specific_pmr_data.apa_target_date_completion = $scope.parse_date($scope.specific_pmr_data.apa_target_date_completion);

    $scope.specific_pmr_data.apa_bid_eval = $scope.parse_date($scope.specific_pmr_data.apa_bid_eval);
    $scope.specific_pmr_data.apa_contract_review_date = $scope.parse_date($scope.specific_pmr_data.apa_contract_review_date);
    $scope.specific_pmr_data.apa_contract_signing = $scope.parse_date($scope.specific_pmr_data.apa_contract_signing);
    $scope.specific_pmr_data.apa_delivery = $scope.parse_date($scope.specific_pmr_data.apa_delivery);
    $scope.specific_pmr_data.apa_eligibility_check = $scope.parse_date($scope.specific_pmr_data.apa_eligibility_check);
    $scope.specific_pmr_data.apa_notice_of_award = $scope.parse_date($scope.specific_pmr_data.apa_notice_of_award);
    $scope.specific_pmr_data.apa_notice_to_proceed = $scope.parse_date($scope.specific_pmr_data.apa_notice_to_proceed);
    $scope.specific_pmr_data.apa_open_of_bids = $scope.parse_date($scope.specific_pmr_data.apa_open_of_bids);
    $scope.specific_pmr_data.apa_post_qual = $scope.parse_date($scope.specific_pmr_data.apa_post_qual);
    $scope.specific_pmr_data.apa_pre_proc_con = $scope.parse_date($scope.specific_pmr_data.apa_pre_proc_con);
    $scope.specific_pmr_data.apa_prebid_con = $scope.parse_date($scope.specific_pmr_data.apa_prebid_con);
    $scope.specific_pmr_data.apa_target_date_of_completion = $scope.parse_date($scope.specific_pmr_data.apa_target_date_of_completion);
    $scope.specific_pmr_data.created_at = $scope.parse_date($scope.specific_pmr_data.created_at);
    $scope.specific_pmr_data.date_contractors_eval_conducted = $scope.parse_date($scope.specific_pmr_data_for_update_data.date_contractors_eval_conducted);
    $scope.specific_pmr_data.delivery = $scope.parse_date($scope.specific_pmr_data.delivery);
    $scope.specific_pmr_data.io_bid_eval = $scope.parse_date($scope.specific_pmr_data.io_bid_eval);
    $scope.specific_pmr_data.io_eligibility_check = $scope.parse_date($scope.specific_pmr_data.io_eligibility_check);
    $scope.specific_pmr_data.io_open_of_bids = $scope.parse_date($scope.specific_pmr_data.io_open_of_bids);
    $scope.specific_pmr_data.io_post_qual = $scope.parse_date($scope.specific_pmr_data.io_post_qual);
    $scope.specific_pmr_data.io_prebid_con = $scope.parse_date($scope.specific_pmr_data.io_prebid_con);

    $scope.specific_pmr_data.date_of_posting_philgeps_noa = $scope.parse_date($scope.specific_pmr_data.date_of_posting_philgeps_noa);
    console.log($scope.specific_pmr_data.mode_of_procurement);
    
    var array = $scope.specific_pmr_data.list_of_invited.split(',');
    $scope.list_of_invited_array = array;
    console.log(array);
    for(var x = 0; x < array.length; x++){
      $('.tagsinput').tagsinput('add', array[x]);
    }
  }

  $scope.pmr_update_inputs = false;
  $scope.pmr_update = function(params,data){
    $scope.orig_data = data;

    if(params == 1){
    $scope.pmr_update_inputs = true;
    // copy
    $scope.specific_pmr_data_for_update = angular.copy(data);
    }else{
    $scope.pmr_update_inputs = false;
    }
  }
  

  $scope.pmr_update_data = function(id,mode_of_procurement,code,fund_source,abc_total,abc_mooe,abc_co,contract_cost_total,contract_cost_mooe,contract_cost_co){
    var datax = {
      id:id,
      mode_of_procurement:mode_of_procurement,
      code:code,
      fund_source:fund_source,
      abc_total:abc_total,
      abc_mooe:abc_mooe,
      abc_co:abc_co,
      contract_cost_total:contract_cost_total,
      contract_cost_mooe:contract_cost_mooe,
      contract_cost_co:contract_cost_co
    }

    $http({
        method : "POST",
        url : 'update_pmr',
        data : datax,
    }).then(function mySuccess(response) {
        console.log(response.data);
        $('#pmr_history_modal').modal('hide');

        if(response.data == 1){
          Swal.fire({
            title: 'Yahoooo!',
            text: "PMR successfuly updated",
            icon: 'success',
          }).then((result) => {
            // get all modality sp
          });

        }else{
          Swal.fire({
            title: 'Oooops!',
            text: "There must be a problem",
            icon: 'error',
          });
        }
    }, function myError(response) {});

  }
  
  $scope.pmr_update_single_data = function(updated_field,id){

    $('#pmr_history_modal').modal('hide');

    Swal.fire({
      html:'<small style="float:left;font-weight:bold;">Date of the event occured</small>' +'<br>'+ '<input type="date" id="pmr_event_date" class="form-control" autofocus>' + '<br>' +
      '<small style="float:left;font-weight:bold;">Remarks</small>' +'<br>'+ '<textarea id="pmr_event_remarks" maxlength="2500" rows="10" cols="50" class="form-control" style="resize: none;"></textarea>' + '<br>' +
      '<small style="float:left;font-weight:bold;">Materials Delivery Percentage</small>' +'<br>'+ '<input type="text" id="delivery_percentage" class="form-control">',
      inputAttributes: {
        autocapitalize: 'off'
      },
      showCancelButton: true,
      confirmButtonColor: '#007bff',
      cancelButtonColor: '#dc3545',      
      confirmButtonText: 'Update',
      showLoaderOnConfirm: true,
      allowOutsideClick: false,
      preConfirm: () => {
        return new Promise((resolve) => {
          setTimeout(() => {
             // || $('#pmr_event_remarks').val() == "" || $('#delivery_percentage').val() == ""
            // if($('#pmr_event_date').val() == ""){
            //   Swal.showValidationMessage(
            //     'Please fill up the fields'
            //   )
            // }
            resolve()
          }, 2000)
        })
      }
    }).then((result) => {
      if (result.value) {
        var datax = {
          id:id,
          updated_field:updated_field,
          date:$('#pmr_event_date').val(),
          remarks:$('#pmr_event_remarks').val(),
          delivery_percentage:$('#delivery_percentage').val(),
        }
        console.log(datax);

        $http({
            method : "POST",
            url : 'pmr_update_single_data',
            data : datax,
        }).then(function mySuccess(response) {
          console.log(response.data);
          $('#pmr_modal').modal('hide');

          if(response.data == 1){
            Swal.fire({
              title: 'Yahoooo!',
              text: "PMR successfuly created",
              icon: 'success',
            }).then(function() {
               window.location.href="/"+"dac/routes/show_modality";
              $scope.my_subprojects();
            });
          }else;
        }, function myError(response) {});

      }else{
        Swal.fire({
          title: 'Cancelled!',
          text: "PMR updating has been cancelled",
          icon: 'error',
        }).then(function() {
            window.location.href="/"+"dac/routes/show_modality";
            $scope.my_subprojects();
        });
      }
    })
  }
  
  $scope.update_sp_Btns = function(){
    $scope.saveBtn = true;
    $scope.updateBtn = false;
    $scope.update_sp_data = true;
  }

  $scope.fileChanged_csr = function(element){
    $scope.file_upload_csr = element.files
    $scope.uptfile = element.files
    $scope.$apply();        

    var name  = $scope.file_upload_csr[0].name;
    var fileType = name.substr(name.indexOf(".")+1);
  }

  $scope.fileChanged_mt = function(element){
    $scope.file_upload_mt = element.files
    $scope.uptfile = element.files
    $scope.$apply();        

    var name  = $scope.file_upload_mt[0].name;
    var fileType = name.substr(name.indexOf(".")+1);
  }

  $scope.fileChanged_spcr = function(element){
    $scope.file_upload_spcr = element.files
    $scope.uptfile = element.files
    $scope.$apply();

    var name  = $scope.file_upload_spcr[0].name;
    var fileType = name.substr(name.indexOf(".")+1);
  }

  $scope.fileChanged_esmr = function(element){
    $scope.file_upload_esmr = element.files
    $scope.uptfile = element.files
    $scope.$apply();

    var name  = $scope.file_upload_esmr[0].name;
    var fileType = name.substr(name.indexOf(".")+1);
  }

  $scope.fileChanged_fullblown = function(element){
    $scope.file_upload_fullblown = element.files
    $scope.uptfile = element.files
    $scope.$apply();        

    var name  = $scope.file_upload_fullblown[0].name;
    var fileType = name.substr(name.indexOf(".")+1);
  }

  $scope.fileChanged_var_order = function(element){
    $scope.file_upload_var_order = element.files
    $scope.uptfile = element.files
    $scope.$apply();        

    var name  = $scope.file_upload_var_order[0].name;
    var fileType = name.substr(name.indexOf(".")+1);
  }

  $scope.fileChanged_build_perm = function(element){
    $scope.file_upload_build_perm = element.files
    $scope.uptfile = element.files
    $scope.$apply();        

    var name  = $scope.file_upload_build_perm[0].name;
    var fileType = name.substr(name.indexOf(".")+1);
  }

	$scope.update_sp = function(logs_id,act,slippage,iss_prob,analysis,remarks,sp_id){

    console.log(logs_id);
    console.log(act);
    console.log(slippage);
    console.log(iss_prob);
    console.log(analysis);
    console.log(remarks);
    console.log(sp_id);

    if(iss_prob == undefined){
      iss_prob = 0;
    };
    if(analysis == undefined){
      analysis = 0;
    };
    if(remarks == undefined){
      remarks = 0;
    };

    var datax = {
        logs_id:logs_id,
        act:act,
        slippage:slippage,
        iss_prob:iss_prob,
        analysis:analysis,
        remarks:remarks,
        sp_id:sp_id,
    }

    $http({
        method : "POST",
        url : 'update_subproject_data',
        data : datax,
    }).then(function mySuccess(response) {
        console.log(response.data);
        if(response.data == 1){
          Swal.fire({
            title: 'Yahoooo!',
            text: "Successfuly updated",
            icon: 'success',
          }).then(function() {
            // window.location.href="/"+"dac/routes/show_modality";
            $('#collapseExample'+sp_id).collapse('hide');
            $scope.my_subprojects();
          });

        }else{
          Swal.fire({
            title: 'Ooopssie!',
            text: "There some problem! Please contact your IT personnel",
            icon: 'error',
          }).then(function() {
            // window.location.href="/"+"dac/routes/show_modality";
            $('#collapseExample'+sp_id).collapse('hide');
            $scope.my_subprojects();
          });
        }
    }, function myError(response) {
      
    });
	}

  $scope.updating_sp_data = function(type,sp_id){
    // console.log(id_btn)
    // return 0
    if(type == 'sp_estimated_duration' || type == 'sp_days_suspended' || type == 'sp_physical_target'){

      if(type == 'sp_estimated_duration'){
        $scope.label = 'Estimated Duration (Days)';
      };

      if(type == 'sp_days_suspended'){
        $scope.label = 'Days Suspended (Days)';
      };

      if(type == 'sp_physical_target'){
        $scope.label = 'Physical Target: "ex. 5800 Sq. ft" ';
      };

      Swal.fire({
        html:'<small style="float:left;font-weight:bold;">'+ $scope.label +'</small>' +'<br>'+ '<input type="text" id="'+type+'" class="form-control" autofocus>',
        inputAttributes: {
          autocapitalize: 'off'
        },
        showCancelButton: true,
        confirmButtonColor: '#007bff',
        cancelButtonColor: '#dc3545',      
        confirmButtonText: 'Update',
        showLoaderOnConfirm: true,
        allowOutsideClick: false,
        preConfirm: () => {
          return new Promise((resolve) => {
            setTimeout(() => {
              if($("#"+type).val() == ""){
                Swal.showValidationMessage(
                  'Please fill up the fields'
                )
              }
              resolve()
            }, 2000)
          })
        }
      }).then((result) => {
        if (result.value) {
          var datax = {
            sp_id:sp_id,
            updated_field:type,
            updated_field_value:$("#"+type).val(),
          }
          console.log(datax);

          $http({
              method : "POST",
              url : 'updating_sp_single_data',
              data : datax,
          }).then(function mySuccess(response) {
            console.log(response.data);
            if(response.data == 1){
              Swal.fire({
                title: 'Yahoooo!',
                text: "Subproject Data successfuly updated",
                icon: 'success',
              }).then(function() {
                 // window.location.href="/"+"dac/routes/show_modality";
                angular.element( document.querySelector("#date_"+sp_id)).innerHTML=$("#"+type).val();
                 date = nedate

              });
            }else;
          }, function myError(response) {});

        }else{
          Swal.fire({
            title: 'Cancelled!',
            text: "Subproject updating has been cancelled",
            icon: 'error',
          });
        }
      })

    }else if(type == 'sp_target_date_of_completion' || type == 'sp_actual_date_completed' || type == 'sp_date_of_turnover'){
      if(type == 'sp_target_date_of_completion'){
        $scope.label = 'Target Date Completion';
      };

      if(type == 'sp_actual_date_completed'){
        $scope.label = 'Actual Date Completed';
      };

      if(type == 'sp_date_of_turnover'){
        $scope.label = 'Date of Turnover';
      };

      Swal.fire({
        html:'<small style="float:left;font-weight:bold;">'+ $scope.label +'</small>' +'<br>'+ '<input type="date" id="'+type+'" class="form-control" autofocus>' + '<br>',
        inputAttributes: {
          autocapitalize: 'off'
        },
        showCancelButton: true,
        confirmButtonColor: '#007bff',
        cancelButtonColor: '#dc3545',      
        confirmButtonText: 'Update',
        showLoaderOnConfirm: true,
        allowOutsideClick: false,
        preConfirm: () => {
          return new Promise((resolve) => {
            setTimeout(() => {
              if($("#"+type).val() == ""){
                Swal.showValidationMessage(
                  'Please fill up the fields'
                )
              }
              resolve()
            }, 2000)
          })
        }
      }).then((result) => {
        if (result.value) {
          var datax = {
            sp_id:sp_id,
            updated_field:type,
            updated_field_value: new Date(js_yyyy_mm_dd($("#"+type).val())),
          }
          console.log(datax);

          $http({
              method : "POST",
              url : 'updating_sp_single_data',
              data : datax,
          }).then(function mySuccess(response) {
            console.log(response.data);
            if(response.data == 1){
              Swal.fire({
                title: 'Yahoooo!',
                text: "Subproject Data successfuly updated",
                icon: 'success',
              }).then(function() {
                 // window.location.href="/"+"dac/routes/show_modality";
                angular.element( document.querySelector("#date_"+sp_id)).innerText=$("#"+datax.updated_field_value);

              });
            }else;
          }, function myError(response) {});

        }else{
          Swal.fire({
            title: 'Cancelled!',
            text: "Subproject updating has been cancelled",
            icon: 'error',
          });
        }
      });
      
    }else;
  }

  $scope.view_planned_sched = function(sp_id){
    console.log(sp_id);
    $http({
      method : "GET",
      url : 'view_planned_sched/'+sp_id,
    }).then(function mySuccess(response) {
      $scope.planned_sched = response.data;
      console.log("view_planned_sched");
      console.log(response.data);

      // $scope.myChart_div = true;
      $scope.chart_slippage = [];
      $scope.chart_planned = [];
      $scope.chart_actual = [];
      $scope.chart_labels = [];
      $scope.sp_chart_data = [];

      for(var x = 0; x < $scope.planned_sched.length; x++){
        $scope.chart_slippage.push($scope.planned_sched[x].sp_logs_slippage);
        $scope.chart_planned.push($scope.planned_sched[x].sp_logs_planned);
        $scope.chart_actual.push($scope.planned_sched[x].sp_logs_actual);
        $scope.chart_labels.push($scope.planned_sched[x].sp_logs_planned_target_date);
      }


      console.log($scope.chart_slippage);
      console.log($scope.chart_planned);
      console.log($scope.chart_actual);
      console.log($scope.chart_labels);

      $scope.chart_planned_sched($scope.chart_slippage,$scope.chart_planned,$scope.chart_actual,$scope.chart_labels);
    }, function myError(response) {

    });
  }

  $scope.chart_planned_sched = function(chart_slippage,chart_planned,chart_actual,chart_labels){
    ////////////// CHARTS
    var ctx = document.getElementById("myChart").getContext('2d');
    var config = {
        type: 'line',
        data: {
            labels: chart_labels,
            datasets: [
            {
                label: 'Slippage', // Name the series
                data: chart_slippage, // Specify the data values array
                fill: false,
                borderColor: '#dc3545', // Add custom color border (Line)
                backgroundColor: '#dc3545', // Add custom color background (Points and Fill)
                borderWidth: 1, // Specify bar border width,
                lineTension: 0,
                pointRadius: 5,
                pointHitRadius: 10,
            },
            {
                label: 'Planned', // Name the series
                data: chart_planned, // Specify the data values array
                fill: false,
                borderColor: '#fd7e14', // Add custom color border (Line)
                backgroundColor: '#fd7e14', // Add custom color background (Points and Fill)
                borderWidth: 1, // Specify bar border width,
                lineTension: 0,
                pointRadius: 5,
                pointHitRadius: 10,
            },
            {
                label: 'Actual', // Name the series
                data: chart_actual, // Specify the data values array
                fill: false,
                borderColor: '#2196f3', // Add custom color border (Line)
                backgroundColor: '#2196f3', // Add custom color background (Points and Fill)
                borderWidth: 1, // Specify bar border width,
                lineTension: 0,
                pointRadius: 5,
                pointHitRadius: 10,
            },
        ]},
        options: {
          // responsive: true, // Instruct chart js to respond nicely.
          // maintainAspectRatio: false, // Add to prevent default behaviour of full-width/height 
          // scales: {
          //     yAxes: [{
          //         ticks: {
          //             beginAtZero: false,
          //             stepSize: 10,
          //         }
          //     }]
          // },
          // tooltips: {
          //   mode: 'index',
          //   intersect: false,
          //   position: 'nearest',
          // },
          // hover: {
          //   mode: 'index',
          //   intersect: true
          // }
        }
    };

    if (window.MyChart != undefined)
    {
        window.MyChart.destroy();
    }
    window.MyChart = new Chart(ctx, config);
    updateConfigAsNewObject(window.MyChart);
    window.MyChart.update();

    function updateConfigAsNewObject(chart) {
        chart.options = {
            responsive: true,
            title: {
                display: true,
                text: 'TRACK HISTORY'
            },
            scales: {
                xAxes: [{
                    display: true
                }],
                yAxes: [{
                    display: true
                }]
            }
        };
        chart.update();
    }

    // function removeData(chart) {
    //     chart.data.labels.pop();
    //     chart.data.datasets.forEach((dataset) => {
    //         dataset.data.pop();
    //     });
    //     chart.update();
    // }
  }

	$scope.cancel_update_sp = function(){
    $scope.update_sp_data = false;
		$scope.saveBtn = false;
		$scope.updateBtn = true;
	}

  $scope.fileChanged = function(element){
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


	$scope.uploads = function(modality_type){
    console.log(modality_type);
    $scope.fetch_dac_dashboard_div = false;
    $scope.fetch_dac_modality_div = true;
  }

  $scope.nulldata = null;
  $scope.upload_file = function(uploaded_category,file_sp_id){
    console.log(uploaded_category);
    console.log(file_sp_id);

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
		            url : 'upload_file',
		            data: {},
		            headers: { 'Content-Type': undefined},
		            transformRequest: function(data) {
		                var formData = new FormData();
                    formData.append("category", uploaded_category);
		                formData.append("sp_id", file_sp_id);
		                for (var i = 0; i < $scope.file_upload.length; i++) {
		                    formData.append('file[' + i+']', $scope.file_upload[i]);
		                  }
		                return formData;
		            },
		        }).then(function mySuccess(response) {
		        	console.log(response.data);
		        	if(response.data == 1){
    				    $scope.fetch_my_latest_file();
    				    $scope.fetch_my_all_file();
    				    $('#preview').empty();
                Swal.fire(
                  'Yahoo!',
                  'Your file has been uploaded.',
                  'success'
                );

                window.location.href="/"+"dac/routes/files";
		        	}else{
                Swal.fire({
                  title: 'Ooopssie!',
                  text: "There some problem! Please contact your IT personnel",
                  icon: 'error',
                });
		        	}
		        }, function myError(response) {
		            console.log(response);
		        });
		  }else{
        $scope.filetype = null;
        $('#preview').empty();
        $('#add_files').modal('show');
      }
		});
  }

  $scope.upload_file_per_sp = function(uploaded_category,sp_id){
    console.log(uploaded_category);
    console.log(sp_id);

    $('#add_files').modal('hide');
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
                url : 'upload_file',
                data: {},
                headers: { 'Content-Type': undefined},
                transformRequest: function(data) {
                    var formData = new FormData();
                    formData.append("category", uploaded_category);
                    formData.append("sp_id", sp_id);
                    for (var i = 0; i < $scope.file_upload.length; i++) {
                        formData.append('file[' + i+']', $scope.file_upload[i]);
                      }
                    return formData;
                },
            }).then(function mySuccess(response) {
              console.log(response.data);
              if(response.data == 1){
                $scope.fetch_my_latest_file();
                $scope.fetch_my_all_file();
                $('#preview').empty();
                Swal.fire(
                  'Yahoo!',
                  'Your file has been uploaded.',
                  'success'
                );

                window.location.href="/"+"dac/routes/show_modality";
              }else{
                Swal.fire({
                  title: 'Ooopssie!',
                  text: "There some problem! Please contact your IT personnel",
                  icon: 'error',
                });
              }
            }, function myError(response) {
                console.log(response);
            });
      }else{
        $scope.filetype = null;
        $('#preview').empty();
        $('#add_files').modal('show');
      }
    });
  }

  $scope.download_file = function(file_id){
    $http({
            method : "GET",
            url : 'download/'+file_id,
        }).then(function mySuccess(response) {
            console.log(response.data);
            // window.open(response.data, "_blank"); 
        }, function myError(response) {
          
        });
  }

  $scope.delete_file = function(file_id){

      Swal.fire({
        title: 'Are you sure?',
        text: "Do you want to delete this file?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#007bff',
        cancelButtonColor: '#dc3545',
        confirmButtonText: 'Yes, delete it!',
      }).then((result) => {
        // http request for delete

      if (result.value) {

          var data = {
            file_id:file_id
          }
          console.log(data);
          $http({
              method : "POST",
              url : 'delete_file',
              data : data,
          }).then(function mySuccess(response){

            if(response.data == "1" || response.data == 1){
              Swal.fire({
                title: 'Success!',
                text: "File successfuly deleted",
                icon: 'success',
              }).then(function(){
                // window.location.href="/"+"dac/routes/show_file";
                $scope.fetch_my_all_file();
              });

            }else{
              Swal.fire({
                title: 'Ooopssie!',
                text: "Problem occured. Please try refreshing the page ",
                icon: 'error',
              });
            }

          }, function myError(response){
            console.log(response);
          });

      } else if (result.dismiss === Swal.DismissReason.cancel) {
        Swal.fire({
          title: 'Cancelled',
          text: "File is safe",
          icon: 'error',
        });
      }
      });
  }

  $scope.fetch_my_latest_file = function(){
    $http({
        method : "GET",
        url : 'fetch_my_latest_file',
    }).then(function mySuccess(response) {
      	console.log(response.data);
      	$scope.file_data = response.data;

      	for(x = 0; x < $scope.file_data.length; x++){
      		$scope.file_data[x].updated_at = $scope.parse_date($scope.file_data[x].updated_at);
      	}

    }, function myError(response) {
    	
    });
  }

	$scope.search_data = {};
	$scope.search_data_category = "$"
    $scope.fetch_my_all_file = function(){
		$http({
            method : "GET",
            url : 'fetch_my_all_file',
        }).then(function mySuccess(response) {
          	console.log(response.data);
          	$scope.my_all_file_data = response.data;

          	for(x = 0; x < $scope.my_all_file_data.length; x++){
          		$scope.my_all_file_data[x].updated_at = $scope.parse_date($scope.my_all_file_data[x].updated_at);
          	}

        }, function myError(response) {
        });
    }

  // Downloadables
  $scope.search_data = {};
  $scope.search_data_category = "$"
  $scope.fetch_all_file = function(){
  $http({
          method : "GET",
          url : 'fetch_all_file',
      }).then(function mySuccess(response) {
          console.log(response.data);
          $scope.all_file_data = response.data;

          for(x = 0; x < $scope.all_file_data.length; x++){
            $scope.all_file_data[x].updated_at = $scope.parse_date($scope.all_file_data[x].updated_at);
          }

      }, function myError(response) {
      });
  }

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
              window.location.href="/"+"dac/routes/profile";
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
          window.location.href="/"+"dac/routes/profile";
            $('#preview').empty();
            Swal.fire(
              'Yahoo!',
              'Your profile info has been uploaded.',
              'success'
            );
            }else{

            }
        }, function myError(response) {
          
        });
      }
    });
  }

});