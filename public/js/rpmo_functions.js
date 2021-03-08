var app = angular.module('Main_Function', ['ngRoute']);

app.controller('RPMO_Controller', function($scope,$http,$filter,$timeout) {
	console.log('RPMO_Controller');
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
    console.log(input);
    now = input;

    year = "" + now.getFullYear();
    month = "" + (now.getMonth() + 1); if (month.length == 1) { month = "0" + month; }
    day = "" + now.getDate(); if (day.length == 1) { day = "0" + day; }
    hour = "" + now.getHours(); if (hour.length == 1) { hour = "0" + hour; }
    minute = "" + now.getMinutes(); if (minute.length == 1) { minute = "0" + minute; }
    second = "" + now.getSeconds(); if (second.length == 1) { second = "0" + second; }
    return year + "-" + month + "-" + day + " " + hour + ":" + minute + ":" + second;
  }

  $scope.parse_date = function(date){
      date = new Date(Date.parse(date));
      return date;
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

  // For Nav sa app.blade
  $('.dropdown').on('show.bs.dropdown', function(e){
    $(this).find('.dropdown-menu').first().stop(true, true).slideDown(300);
  });

  $('.dropdown').on('hide.bs.dropdown', function(e){
    $(this).find('.dropdown-menu').first().stop(true, true).slideUp(200);
  });

  // init values
  $scope.fetch_rpmo_dashboard_div = false;
  $scope.fetch_rpmo_modality_div = false;
  $scope.fetch_rpmo_ceac_div = false;
  $scope.fetch_rpmo_upload_div = false;
  $scope.fetch_rpmo_reports_div = false;

  $scope.fetch_rpmo_dashboard = function(){
    $scope.fetch_rpmo_dashboard_div = true;
    $scope.fetch_rpmo_modality_div = false;
    $scope.fetch_rpmo_ceac_div = false;
    $scope.fetch_rpmo_upload_div = false;
    $scope.fetch_rpmo_reports_div = false;

    // $scope.chart_slippage = [];

      console.log($scope.fetch_rpmo_dashboard_div);
      $scope.chart_slippage = [];
      $scope.chart_planned = [];
      $scope.chart_actual = [];
      $scope.chart_labels = [];
      $scope.sp_chart_data = [];

    $http({
        method : "GET",
        url : 'routes/fetch_modality',
    }).then(function mySuccess(response) {
      console.log('dashboard');
      console.log(response);
        $scope.my_modality = response.data[0];
        $scope.my_sp = response.data[1];
        $scope.ongoing_count = response.data[2];
        $scope.completed_count = response.data[3];
        $scope.actual_weighted = response.data[4];
        $scope.nys_count = response.data[5];

        console.log("MODALITY");
        console.log($scope.my_modality);

        // CHECK IF EMPTY ANG SP OBJECT
        $scope.my_sp_data = [];
        for(var e = 0; e < $scope.my_sp.length; e++){
          if($scope.my_sp[e].sp.length > 0){
            $scope.my_sp_data.push($scope.my_sp[e].sp[0])
          }else;  
        }
        console.log("SP");
        console.log($scope.my_sp_data);

      for(var x = 0; x < $scope.my_sp_data[0].sp_logs.length; x++){
        $scope.chart_slippage.push($scope.my_sp_data[0].sp_logs[x].sp_logs_slippage);
        $scope.chart_planned.push($scope.my_sp_data[0].sp_logs[x].sp_logs_planned);
        $scope.chart_actual.push($scope.my_sp_data[0].sp_logs[x].sp_logs_actual);
        $scope.chart_labels.push($scope.my_sp_data[0].sp_logs[x].sp_logs_planned_target_date);
      }

        $scope.chart_dashboard($scope.chart_slippage,$scope.chart_planned,$scope.chart_actual,$scope.chart_labels);
    }, function myError(response) {});
  }

  $scope.fetch_my_modalities = function(){
    $http({
        method : "GET",
        url : 'fetch_modality',
    }).then(function mySuccess(response) {
        $scope.my_modality = response.data[0];
    }, function myError(response) {});
  }

  $scope.fetch_rpmo_sps = function(){
    $http({
        method : "GET",
        url : 'fetch_rpmo_sps',
    }).then(function mySuccess(response) {
        $scope.sp_per_modality_data_all_sp_logs = response.data;
        console.log($scope.sp_per_modality_data_all_sp_logs);
    }, function myError(response) {});
  }


  $scope.chart_dashboard = function(chart_slippage,chart_planned,chart_actual,chart_labels){
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
  }

  $scope.Slippage_data = "";
  $scope.calc_slippage = function(act,pln){
    $scope.Slippage_data = act - pln / 100 * 100;
  }

  $scope.update_sp_data = false;
  $scope.saveBtn = false;
  $scope.updateBtn = true;

  $scope.update_sp_Btns = function(){
    $scope.saveBtn = true;
    $scope.updateBtn = false;
    $scope.update_sp_data = true;
      
    // upload image with preview
    var fullblown_id = new FileUploadWithPreview('fullblown_id', {
      showDeleteButtonOnImages: true,
      text: {
        chooseFile: 'Choose file...',
        browse: 'Browse',
        selectedCount: 'Files Selected',
      }
    });

    var var_order = new FileUploadWithPreview('var_order', {
      showDeleteButtonOnImages: true,
      text: {
        chooseFile: 'Choose file...',
        browse: 'Browse',
        selectedCount: 'Files Selected',
      }
    });

    var esmr = new FileUploadWithPreview('esmr_id', {
      showDeleteButtonOnImages: true,
      text: {
        chooseFile: 'Choose file...',
        browse: 'Browse',
        selectedCount: 'Files Selected',
      }
    });

    var spcr = new FileUploadWithPreview('spcr_id', {
      showDeleteButtonOnImages: true,
      text: {
        chooseFile: 'Choose file...',
        browse: 'Browse',
        selectedCount: 'Files Selected',
      }
    });

    var csr = new FileUploadWithPreview('csr_id', {
      showDeleteButtonOnImages: true,
      text: {
        chooseFile: 'Choose file...',
        browse: 'Browse',
        selectedCount: 'Files Selected',
      }
    });

    var buildingpermit = new FileUploadWithPreview('buildingpermit_id', {
      showDeleteButtonOnImages: true,
      text: {
        chooseFile: 'Choose file...',
        browse: 'Browse',
        selectedCount: 'Files Selected',
      }
    });
  }

  $scope.fileChanged_csr = function(element){
    $scope.file_upload_csr = element.files
    $scope.uptfile = element.files
    $scope.$apply();        

    var name  = $scope.file_upload_csr[0].name;
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

  $scope.search_data = {};
  $scope.search_data_category = "$";
  $scope.fetch_rpmo_modality = function(modality_type){
    console.log(modality_type);
    $scope.fetch_rpmo_reports_div = false;
    $scope.fetch_rpmo_dashboard_div = false;
    $scope.fetch_rpmo_ceac_div = false;
    $scope.fetch_rpmo_upload_div = false;
    $scope.fetch_rpmo_modality_div = true;

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
        url : 'fetch_rpmo_modality_sp/'+modality_type,
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

    }, function myError(response) {
      
    });
  }
  
  // PAGINTION
  $scope.Next_Pagination = function(url){
    $http({
          method : "GET",
          url : url,
      }).then(function mySuccess(response) {
        console.log(response.data[1].data);
        $scope.sp_per_modality_data_all_sp_logs = response.data;
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
    }, function myError(response) {

    });
  }
  // PAGINTION

  $scope.check_if_completed = function(data){
    console.log(data.sp[0].sp_logs);
    $scope.if_completed = data.sp[0].sp_logs;
    $scope.x = [];
    // get all logs actual
    for (var i =0; i < $scope.if_completed.length; i++) {
      // console.log($scope.if_completed[i].sp_logs_actual);
      $scope.x.push(parseInt($scope.if_completed[i].sp_logs_actual));
    }
    // push to array
    $scope.if_to_be_completed = Math.max.apply(Math, $scope.x);
    console.log($scope.if_to_be_completed);
  }

  function js_yyyy_mm_dd (input) {

      var now = new Date(input);

      year = "" + now.getFullYear();
      month = "" + (now.getMonth() + 1); if (month.length == 1) { month = "0" + month; }
      day = "" + now.getDate(); if (day.length == 1) { day = "0" + day; }
      hour = "" + now.getHours(); if (hour.length == 1) { hour = "0" + hour; }
      minute = "" + now.getMinutes(); if (minute.length == 1) { minute = "0" + minute; }
      second = "" + now.getSeconds(); if (second.length == 1) { second = "0" + second; }
      return year + "-" + month + "-" + day;
  }

  $scope.Update_Sp_Status = function(type,sp_id){
    console.log(type);
    console.log(sp_id);
    
    const swalWithBootstrapButtons = Swal.mixin({
      customClass: {
        confirmButton: 'btn btn-success',
        cancelButton: 'btn btn-danger'
      },
      buttonsStyling: false
    })

    Swal.fire({
      title: 'Are you sure?',
      text: "Update the subproject status to "+type+'?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes, update it!',
      cancelButtonText: 'No!',
      reverseButtons: true
    }).then((result) => {
      if (result.value) {
        if(type == 'Completed'){
          Swal.fire({
            title: 'Date of Completion',
            html:
              '<input type="date" id="swal-input1" class="form-control" ng-model="date_of_completion">',
            showCancelButton: true,
            inputValidator: (value) => {
              if (!value) {
                return 'Please input the date of completion!'
              }
            }
          }).then((result) => {
            // console.log($('#swal-input1').val());
            if(result.value){
              var xx = $('#swal-input1').val();
              var date_of_completion = js_yyyy_mm_dd(xx);

              var datax = {
                  type:type,
                  date_of_completion:date_of_completion,
                  sp_id:sp_id,
              }

              $http({
                  method : "POST",
                  url : 'update_sp_status',
                  data: datax,
              }).then(function mySuccess(response) {
                  console.log(response.data);
                  if(response.data==1 || response.data=="1"){
                    Swal.fire(
                      'Yahoo!',
                      'SP Status has been updated',
                      'success'
                    );
                  }else{
                    Swal.fire(
                      'Cancelled',
                      'Subproject was not updated, Check Network Connection',
                      'error'
                    )
                  }
              }, function myError(response) {});
            }else if (result.dismiss === Swal.DismissReason.cancel) {
              Swal.fire(
                'Cancelled',
                'Subproject was not updated',
                'error'
              )
            }

          });

        }else if(type == 'On-going'){

          Swal.fire({
            title: 'Date Started',
            html:
              '<input type="date" id="swal-input2" class="form-control" ng-model="date_started">',
            showCancelButton: true,
            inputValidator: (value) => {
              if (!value) {
                return 'Please input the date of completion!'
              }
            }
          }).then((result) => {

            if(result.value){
              var xx = $('#swal-input2').val();
              var date_started = js_yyyy_mm_dd(xx);

              var datax = {
                  type:type,
                  date_started:date_started,
                  sp_id:sp_id,
              }

              $http({
                  method : "POST",
                  url : 'update_sp_status',
                  data: datax,
              }).then(function mySuccess(response) {
                  console.log(response.data);
                  if(response.data==1 || response.data=="1"){
                    Swal.fire(
                      'Yahoo!',
                      'SP Status has been updated',
                      'success'
                    );
                    $scope.fetch_rpmo_sps();
                  }else{
                    Swal.fire(
                      'Cancelled',
                      'Subproject was not updated, Check Network Connection',
                      'error'
                    )
                  }
              }, function myError(response) {});

            }else if (result.dismiss === Swal.DismissReason.cancel) {
              Swal.fire(
                'Cancelled',
                'Subproject was not updated',
                'error'
              )
            }

          });
        
        }else;

      } else if (result.dismiss === Swal.DismissReason.cancel) {
        Swal.fire(
          'Cancelled',
          'Subproject was not updated',
          'error'
        )
      }
    })
  }

  $scope.view_specific_sp_data = function(data){
    console.log(data);
    $('.remove_high_light').toggleClass('accordion_row');
    $scope.specific_sp_data = data;
    if($scope.specific_sp_data.sp_rfr_first_tranche_date != null){
      $scope.specific_sp_data.sp_rfr_first_tranche_date = $scope.parse_date($scope.specific_sp_data.sp_rfr_first_tranche_date);
    }else;

    $('.forcollapse'+data.sp_id).find('i').toggleClass('fa fa-folder-open fa fa-folder');
    console.log($('.forcollapse'+data.sp_id).find('span').html());

    if($('.forcollapse'+data.sp_id).find('span').html() == "More"){
      $('.forcollapse'+data.sp_id+ ' span').html("Close");
      // console.log($('.forcollapse'+data.sp_id+ ' span'));
    }else{
      $('.forcollapse'+data.sp_id+ ' span').html("More");
    }
    // $http({
    //     method : "GET",
    //     url : 'fetch_specific_modality_sp_logs_length/'+$scope.specific_sp_data.sp_id,
    // }).then(function mySuccess(response) {
    //     console.log(response.data);
    //     $scope.specific_sp_logs_length = response.data[0];
    // }, function myError(response) {});
  }

  $scope.view_planned_sched = function(sp_id){
    console.log(sp_id);
    $http({
      method : "GET",
      url : 'view_planned_sched/'+sp_id,
    }).then(function mySuccess(response) {
      $scope.planned_sched = response.data;
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
  
  $scope.fetch_rpmo_upload = function(){
    $scope.fetch_rpmo_reports_div = false;
    $scope.fetch_rpmo_ceac_div = false;
    $scope.fetch_rpmo_dashboard_div = false;
    $scope.fetch_rpmo_modality_div = false;
    $scope.fetch_rpmo_upload_div = true;
    }

  $scope.fetch_rpmo_ceac = function(){
    $scope.fetch_rpmo_ceac_div = true;
    $scope.fetch_rpmo_dashboard_div = false;
    $scope.fetch_rpmo_modality_div = false;
    $scope.fetch_rpmo_upload_div = false;
    $scope.fetch_rpmo_reports_div = false;

    Swal.fire({
      title: 'Sorry',
      text: "This module still a work in progress, this will be updated soon.",
      icon: 'info',
      showCancelButton: false,
      confirmButtonColor: '#007bff',
      confirmButtonText: 'Redirect to my dashboard...'
    }).then((result) => {
      if (result.value) {
        $scope.fetch_rpmo_dashboard();
      }else;
    });
  }

    $scope.search_data = {};
    $scope.search_data_category = "$"
    $scope.search_modal = false;
  $scope.fetch_rpmo_reports = function(){
    $scope.fetch_rpmo_ceac_div = false;
    $scope.fetch_rpmo_dashboard_div = false;
    $scope.fetch_rpmo_modality_div = false;
    $scope.fetch_rpmo_upload_div = false;
    $scope.fetch_rpmo_reports_div = true;

      $http({
          method : "GET",
          url : 'fetch_reports_modality',
      }).then(function mySuccess(response) {
          $scope.sp_per_modality_data_all_sp_logs = response.data[0];
          $scope.reports_modality = response.data[1];
          // REPORTS
          console.log($scope.sp_per_modality_data_all_sp_logs);
          // REPORTS MODALITY
          console.log($scope.reports_modality);

          for(x = 0; x < $scope.sp_per_modality_data_all_sp_logs.data.length; x++){
            $scope.sp_per_modality_data_all_sp_logs.data[x].sp_rfr_first_tranche_date = $scope.parse_date($scope.sp_per_modality_data_all_sp_logs.data[x].sp_rfr_first_tranche_date);
            $scope.sp_per_modality_data_all_sp_logs.data[x].sp_date_started = $scope.parse_date($scope.sp_per_modality_data_all_sp_logs.data[x].sp_date_started);
            $scope.sp_per_modality_data_all_sp_logs.data[x].sp_date_of_turnover = $scope.parse_date($scope.sp_per_modality_data_all_sp_logs.data[x].sp_date_of_turnover);
            $scope.sp_per_modality_data_all_sp_logs.data[x].sp_target_date_of_completion = $scope.parse_date($scope.sp_per_modality_data_all_sp_logs.data[x].sp_target_date_of_completion);
            // $scope.sp_per_modality_data_all_sp_logs.data[x].sp_actual_date_completed = $scope.parse_date($scope.sp_per_modality_data_all_sp_logs.data[x].sp_actual_date_completed);

            // BUB
            if($scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2015__b_u_b__s_p != null){
              $scope.paramObj = {
                grant: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2015__b_u_b__s_p.grant,
                other_amount: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2015__b_u_b__s_p.other_amount,
                lcc_community: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2015__b_u_b__s_p.lcc_community,
                lcc_community_ik: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2015__b_u_b__s_p.lcc_community_ik,
                lcc_blgu: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2015__b_u_b__s_p.lcc_blgu,
                lcc_blgu_ik: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2015__b_u_b__s_p.lcc_blgu_ik,
                lcc_mlgu: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2015__b_u_b__s_p.lcc_mlgu,
                lcc_mlgu_ik: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2015__b_u_b__s_p.lcc_mlgu_ik,
                lcc_plgu: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2015__b_u_b__s_p.lcc_plgu,
                lcc_plgu_ik: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2015__b_u_b__s_p.lcc_plgu_ik,
                lcc_others: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2015__b_u_b__s_p.lcc_others,
                lcc_others_ik: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2015__b_u_b__s_p.lcc_others_ik,
                lcc_cash: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2015__b_u_b__s_p.lcc_cash,
                lcc_in_kind: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2015__b_u_b__s_p.lcc_in_kind,
              }
              $scope.sp_per_modality_data_all_sp_logs.data[x].total_cost_ni = $scope.get_total_project_cost($scope.paramObj); 
            
            }else if($scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2016__b_u_b__s_p != null){
              $scope.paramObj = {
                grant: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2016__b_u_b__s_p.grant,
                other_amount: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2016__b_u_b__s_p.other_amount,
                lcc_community: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2016__b_u_b__s_p.lcc_community,
                lcc_community_ik: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2016__b_u_b__s_p.lcc_community_ik,
                lcc_blgu: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2016__b_u_b__s_p.lcc_blgu,
                lcc_blgu_ik: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2016__b_u_b__s_p.lcc_blgu_ik,
                lcc_mlgu: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2016__b_u_b__s_p.lcc_mlgu,
                lcc_mlgu_ik: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2016__b_u_b__s_p.lcc_mlgu_ik,
                lcc_plgu: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2016__b_u_b__s_p.lcc_plgu,
                lcc_plgu_ik: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2016__b_u_b__s_p.lcc_plgu_ik,
                lcc_others: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2016__b_u_b__s_p.lcc_others,
                lcc_others_ik: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2016__b_u_b__s_p.lcc_others_ik,
                lcc_cash: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2016__b_u_b__s_p.lcc_cash,
                lcc_in_kind: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2016__b_u_b__s_p.lcc_in_kind,
              }
              $scope.sp_per_modality_data_all_sp_logs.data[x].total_cost_ni = $scope.get_total_project_cost($scope.paramObj); 
            
            }else if($scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2017__b_u_b__s_p != null){
              $scope.paramObj = {
                grant: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2017__b_u_b__s_p.grant,
                other_amount: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2017__b_u_b__s_p.other_amount,
                lcc_community: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2017__b_u_b__s_p.lcc_community,
                lcc_community_ik: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2017__b_u_b__s_p.lcc_community_ik,
                lcc_blgu: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2017__b_u_b__s_p.lcc_blgu,
                lcc_blgu_ik: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2017__b_u_b__s_p.lcc_blgu_ik,
                lcc_mlgu: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2017__b_u_b__s_p.lcc_mlgu,
                lcc_mlgu_ik: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2017__b_u_b__s_p.lcc_mlgu_ik,
                lcc_plgu: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2017__b_u_b__s_p.lcc_plgu,
                lcc_plgu_ik: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2017__b_u_b__s_p.lcc_plgu_ik,
                lcc_others: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2017__b_u_b__s_p.lcc_others,
                lcc_others_ik: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2017__b_u_b__s_p.lcc_others_ik,
                lcc_cash: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2017__b_u_b__s_p.lcc_cash,
                lcc_in_kind: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2017__b_u_b__s_p.lcc_in_kind,
              }
              $scope.sp_per_modality_data_all_sp_logs.data[x].total_cost_ni = $scope.get_total_project_cost($scope.paramObj); 

            }else if($scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2018__b_u_b__s_p != null){
              $scope.paramObj = {
                grant: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2018__b_u_b__s_p.grant,
                other_amount: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2018__b_u_b__s_p.other_amount,
                lcc_community: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2018__b_u_b__s_p.lcc_community,
                lcc_community_ik: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2018__b_u_b__s_p.lcc_community_ik,
                lcc_blgu: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2018__b_u_b__s_p.lcc_blgu,
                lcc_blgu_ik: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2018__b_u_b__s_p.lcc_blgu_ik,
                lcc_mlgu: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2018__b_u_b__s_p.lcc_mlgu,
                lcc_mlgu_ik: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2018__b_u_b__s_p.lcc_mlgu_ik,
                lcc_plgu: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2018__b_u_b__s_p.lcc_plgu,
                lcc_plgu_ik: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2018__b_u_b__s_p.lcc_plgu_ik,
                lcc_others: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2018__b_u_b__s_p.lcc_others,
                lcc_others_ik: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2018__b_u_b__s_p.lcc_others_ik,
                lcc_cash: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2018__b_u_b__s_p.lcc_cash,
                lcc_in_kind: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2018__b_u_b__s_p.lcc_in_kind,
              }
              $scope.sp_per_modality_data_all_sp_logs.data[x].total_cost_ni = $scope.get_total_project_cost($scope.paramObj); 
            
            }else if($scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2020__b_u_b__s_p != null){
              $scope.paramObj = {
                grant: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2020__b_u_b__s_p.grant,
                other_amount: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2020__b_u_b__s_p.other_amount,
                lcc_community: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2020__b_u_b__s_p.lcc_community,
                lcc_community_ik: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2020__b_u_b__s_p.lcc_community_ik,
                lcc_blgu: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2020__b_u_b__s_p.lcc_blgu,
                lcc_blgu_ik: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2020__b_u_b__s_p.lcc_blgu_ik,
                lcc_mlgu: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2020__b_u_b__s_p.lcc_mlgu,
                lcc_mlgu_ik: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2020__b_u_b__s_p.lcc_mlgu_ik,
                lcc_plgu: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2020__b_u_b__s_p.lcc_plgu,
                lcc_plgu_ik: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2020__b_u_b__s_p.lcc_plgu_ik,
                lcc_others: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2020__b_u_b__s_p.lcc_others,
                lcc_others_ik: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2020__b_u_b__s_p.lcc_others_ik,
                lcc_cash: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2020__b_u_b__s_p.lcc_cash,
                lcc_in_kind: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2020__b_u_b__s_p.lcc_in_kind,
              }
              $scope.sp_per_modality_data_all_sp_logs.data[x].total_cost_ni = $scope.get_total_project_cost($scope.paramObj); 

            }else;

            // NCDDP

            if($scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2015__n_c_d_d_p__s_p != null){
              $scope.paramObj = {
                grant: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2015__n_c_d_d_p__s_p.grant,
                other_amount: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2015__n_c_d_d_p__s_p.other_amount,
                lcc_community: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2015__n_c_d_d_p__s_p.lcc_community,
                lcc_community_ik: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2015__n_c_d_d_p__s_p.lcc_community_ik,
                lcc_blgu: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2015__n_c_d_d_p__s_p.lcc_blgu,
                lcc_blgu_ik: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2015__n_c_d_d_p__s_p.lcc_blgu_ik,
                lcc_mlgu: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2015__n_c_d_d_p__s_p.lcc_mlgu,
                lcc_mlgu_ik: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2015__n_c_d_d_p__s_p.lcc_mlgu_ik,
                lcc_plgu: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2015__n_c_d_d_p__s_p.lcc_plgu,
                lcc_plgu_ik: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2015__n_c_d_d_p__s_p.lcc_plgu_ik,
                lcc_others: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2015__n_c_d_d_p__s_p.lcc_others,
                lcc_others_ik: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2015__n_c_d_d_p__s_p.lcc_others_ik,
                lcc_cash: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2015__n_c_d_d_p__s_p.lcc_cash,
                lcc_in_kind: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2015__n_c_d_d_p__s_p.lcc_in_kind,
              }
              $scope.sp_per_modality_data_all_sp_logs.data[x].total_cost_ni = $scope.get_total_project_cost($scope.paramObj); 
            
            }else if($scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2016__n_c_d_d_p__s_p != null){
              $scope.paramObj = {
                grant: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2016__n_c_d_d_p__s_p.grant,
                other_amount: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2016__n_c_d_d_p__s_p.other_amount,
                lcc_community: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2016__n_c_d_d_p__s_p.lcc_community,
                lcc_community_ik: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2016__n_c_d_d_p__s_p.lcc_community_ik,
                lcc_blgu: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2016__n_c_d_d_p__s_p.lcc_blgu,
                lcc_blgu_ik: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2016__n_c_d_d_p__s_p.lcc_blgu_ik,
                lcc_mlgu: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2016__n_c_d_d_p__s_p.lcc_mlgu,
                lcc_mlgu_ik: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2016__n_c_d_d_p__s_p.lcc_mlgu_ik,
                lcc_plgu: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2016__n_c_d_d_p__s_p.lcc_plgu,
                lcc_plgu_ik: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2016__n_c_d_d_p__s_p.lcc_plgu_ik,
                lcc_others: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2016__n_c_d_d_p__s_p.lcc_others,
                lcc_others_ik: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2016__n_c_d_d_p__s_p.lcc_others_ik,
                lcc_cash: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2016__n_c_d_d_p__s_p.lcc_cash,
                lcc_in_kind: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2016__n_c_d_d_p__s_p.lcc_in_kind,
              }
              $scope.sp_per_modality_data_all_sp_logs.data[x].total_cost_ni = $scope.get_total_project_cost($scope.paramObj); 
            
            }else if($scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2017__n_c_d_d_p__s_p != null){
              $scope.paramObj = {
                grant: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2017__n_c_d_d_p__s_p.grant,
                other_amount: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2017__n_c_d_d_p__s_p.other_amount,
                lcc_community: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2017__n_c_d_d_p__s_p.lcc_community,
                lcc_community_ik: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2017__n_c_d_d_p__s_p.lcc_community_ik,
                lcc_blgu: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2017__n_c_d_d_p__s_p.lcc_blgu,
                lcc_blgu_ik: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2017__n_c_d_d_p__s_p.lcc_blgu_ik,
                lcc_mlgu: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2017__n_c_d_d_p__s_p.lcc_mlgu,
                lcc_mlgu_ik: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2017__n_c_d_d_p__s_p.lcc_mlgu_ik,
                lcc_plgu: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2017__n_c_d_d_p__s_p.lcc_plgu,
                lcc_plgu_ik: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2017__n_c_d_d_p__s_p.lcc_plgu_ik,
                lcc_others: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2017__n_c_d_d_p__s_p.lcc_others,
                lcc_others_ik: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2017__n_c_d_d_p__s_p.lcc_others_ik,
                lcc_cash: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2017__n_c_d_d_p__s_p.lcc_cash,
                lcc_in_kind: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2017__n_c_d_d_p__s_p.lcc_in_kind,
              }
              $scope.sp_per_modality_data_all_sp_logs.data[x].total_cost_ni = $scope.get_total_project_cost($scope.paramObj); 

            }else if($scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2018__n_c_d_d_p__s_p != null){
              $scope.paramObj = {
                grant: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2018__n_c_d_d_p__s_p.grant,
                other_amount: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2018__n_c_d_d_p__s_p.other_amount,
                lcc_community: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2018__n_c_d_d_p__s_p.lcc_community,
                lcc_community_ik: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2018__n_c_d_d_p__s_p.lcc_community_ik,
                lcc_blgu: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2018__n_c_d_d_p__s_p.lcc_blgu,
                lcc_blgu_ik: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2018__n_c_d_d_p__s_p.lcc_blgu_ik,
                lcc_mlgu: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2018__n_c_d_d_p__s_p.lcc_mlgu,
                lcc_mlgu_ik: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2018__n_c_d_d_p__s_p.lcc_mlgu_ik,
                lcc_plgu: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2018__n_c_d_d_p__s_p.lcc_plgu,
                lcc_plgu_ik: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2018__n_c_d_d_p__s_p.lcc_plgu_ik,
                lcc_others: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2018__n_c_d_d_p__s_p.lcc_others,
                lcc_others_ik: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2018__n_c_d_d_p__s_p.lcc_others_ik,
                lcc_cash: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2018__n_c_d_d_p__s_p.lcc_cash,
                lcc_in_kind: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2018__n_c_d_d_p__s_p.lcc_in_kind,
              }
              $scope.sp_per_modality_data_all_sp_logs.data[x].total_cost_ni = $scope.get_total_project_cost($scope.paramObj); 
            
            }else if($scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2019__n_c_d_d_p__s_p != null){
              $scope.paramObj = {
                grant: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2019__n_c_d_d_p__s_p.grant,
                other_amount: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2019__n_c_d_d_p__s_p.other_amount,
                lcc_community: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2019__n_c_d_d_p__s_p.lcc_community,
                lcc_community_ik: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2019__n_c_d_d_p__s_p.lcc_community_ik,
                lcc_blgu: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2019__n_c_d_d_p__s_p.lcc_blgu,
                lcc_blgu_ik: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2019__n_c_d_d_p__s_p.lcc_blgu_ik,
                lcc_mlgu: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2019__n_c_d_d_p__s_p.lcc_mlgu,
                lcc_mlgu_ik: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2019__n_c_d_d_p__s_p.lcc_mlgu_ik,
                lcc_plgu: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2019__n_c_d_d_p__s_p.lcc_plgu,
                lcc_plgu_ik: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2019__n_c_d_d_p__s_p.lcc_plgu_ik,
                lcc_others: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2019__n_c_d_d_p__s_p.lcc_others,
                lcc_others_ik: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2019__n_c_d_d_p__s_p.lcc_others_ik,
                lcc_cash: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2019__n_c_d_d_p__s_p.lcc_cash,
                lcc_in_kind: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2019__n_c_d_d_p__s_p.lcc_in_kind,
              }
              $scope.sp_per_modality_data_all_sp_logs.data[x].total_cost_ni = $scope.get_total_project_cost($scope.paramObj); 
            
            }else if($scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2020__n_c_d_d_p__s_p != null){
              $scope.paramObj = {
                grant: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2020__n_c_d_d_p__s_p.grant,
                other_amount: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2020__n_c_d_d_p__s_p.other_amount,
                lcc_community: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2020__n_c_d_d_p__s_p.lcc_community,
                lcc_community_ik: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2020__n_c_d_d_p__s_p.lcc_community_ik,
                lcc_blgu: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2020__n_c_d_d_p__s_p.lcc_blgu,
                lcc_blgu_ik: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2020__n_c_d_d_p__s_p.lcc_blgu_ik,
                lcc_mlgu: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2020__n_c_d_d_p__s_p.lcc_mlgu,
                lcc_mlgu_ik: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2020__n_c_d_d_p__s_p.lcc_mlgu_ik,
                lcc_plgu: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2020__n_c_d_d_p__s_p.lcc_plgu,
                lcc_plgu_ik: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2020__n_c_d_d_p__s_p.lcc_plgu_ik,
                lcc_others: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2020__n_c_d_d_p__s_p.lcc_others,
                lcc_others_ik: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2020__n_c_d_d_p__s_p.lcc_others_ik,
                lcc_cash: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2020__n_c_d_d_p__s_p.lcc_cash,
                lcc_in_kind: $scope.sp_per_modality_data_all_sp_logs.data[x].c_m_f_s_kalahi_2020__n_c_d_d_p__s_p.lcc_in_kind,
              }
              $scope.sp_per_modality_data_all_sp_logs.data[x].total_cost_ni = $scope.get_total_project_cost($scope.paramObj); 
            
            }else;

            for(y = 0; y < $scope.sp_per_modality_data_all_sp_logs.data[x].sp_logs.length; y++){
              $scope.sp_per_modality_data_all_sp_logs.data[x].sp_logs[y].updated_at = $scope.parse_date($scope.sp_per_modality_data_all_sp_logs.data[x].sp_logs[y].updated_at);
            }
          }
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

  // PAGINTION
  $scope.Next_Pagination_Reports = function(url){
    $http({
          method : "GET",
          url : url,
      }).then(function mySuccess(response) {
          $scope.sp_per_modality_data_all_sp_logs = response.data[0];
          $scope.reports_modality = response.data[1];
          console.log($scope.reports_modality);

          for(x = 0; x < $scope.sp_per_modality_data_all_sp_logs.data.length; x++){
            $scope.sp_per_modality_data_all_sp_logs.data[x].sp_rfr_first_tranche_date = $scope.parse_date($scope.sp_per_modality_data_all_sp_logs.data[x].sp_rfr_first_tranche_date);
            $scope.sp_per_modality_data_all_sp_logs.data[x].sp_date_started = $scope.parse_date($scope.sp_per_modality_data_all_sp_logs.data[x].sp_date_started);
            $scope.sp_per_modality_data_all_sp_logs.data[x].sp_date_of_turnover = $scope.parse_date($scope.sp_per_modality_data_all_sp_logs.data[x].sp_date_of_turnover);
            $scope.sp_per_modality_data_all_sp_logs.data[x].sp_target_date_of_completion = $scope.parse_date($scope.sp_per_modality_data_all_sp_logs.data[x].sp_target_date_of_completion);
            $scope.sp_per_modality_data_all_sp_logs.data[x].sp_actual_date_completed = $scope.parse_date($scope.sp_per_modality_data_all_sp_logs.data[x].sp_actual_date_completed);

            for(y = 0; y < $scope.sp_per_modality_data_all_sp_logs.data[x].sp_logs.length; y++){
              $scope.sp_per_modality_data_all_sp_logs.data[x].sp_logs[y].updated_at = $scope.parse_date($scope.sp_per_modality_data_all_sp_logs.data[x].sp_logs[y].updated_at);
            }
          }


      }, function myError(response) {
      
    });
  }

  $scope.Previous_Pagination_Reports = function (url){
    console.log(url);
    $http({
          method : "GET",
          url : url,
      }).then(function mySuccess(response) {
          $scope.sp_per_modality_data_all_sp_logs = response.data[0];
          $scope.reports_modality = response.data[1];
          console.log($scope.reports_modality);

          for(x = 0; x < $scope.sp_per_modality_data_all_sp_logs.data.length; x++){
            $scope.sp_per_modality_data_all_sp_logs.data[x].sp_rfr_first_tranche_date = $scope.parse_date($scope.sp_per_modality_data_all_sp_logs.data[x].sp_rfr_first_tranche_date);
            $scope.sp_per_modality_data_all_sp_logs.data[x].sp_date_started = $scope.parse_date($scope.sp_per_modality_data_all_sp_logs.data[x].sp_date_started);
            $scope.sp_per_modality_data_all_sp_logs.data[x].sp_date_of_turnover = $scope.parse_date($scope.sp_per_modality_data_all_sp_logs.data[x].sp_date_of_turnover);
            $scope.sp_per_modality_data_all_sp_logs.data[x].sp_target_date_of_completion = $scope.parse_date($scope.sp_per_modality_data_all_sp_logs.data[x].sp_target_date_of_completion);
            $scope.sp_per_modality_data_all_sp_logs.data[x].sp_actual_date_completed = $scope.parse_date($scope.sp_per_modality_data_all_sp_logs.data[x].sp_actual_date_completed);

            for(y = 0; y < $scope.sp_per_modality_data_all_sp_logs.data[x].sp_logs.length; y++){
              $scope.sp_per_modality_data_all_sp_logs.data[x].sp_logs[y].updated_at = $scope.parse_date($scope.sp_per_modality_data_all_sp_logs.data[x].sp_logs[y].updated_at);
            }
          }
      }, function myError(response) {
      
    });
  }

  $scope.Skip_To_Page_Reports = function(path,Page_Number){
    console.log(path);
    console.log(Page_Number);
    $http({
      method : "GET",
      url: path+"?page="+Page_Number,
    }).then(function mySuccess(response) {
          $scope.sp_per_modality_data_all_sp_logs = response.data[0];
          $scope.reports_modality = response.data[1];
          console.log($scope.reports_modality);
          console.log($scope.sp_per_modality_data_all_sp_logs);

          for(x = 0; x < $scope.sp_per_modality_data_all_sp_logs.data.length; x++){
            $scope.sp_per_modality_data_all_sp_logs.data[x].sp_rfr_first_tranche_date = $scope.parse_date($scope.sp_per_modality_data_all_sp_logs.data[x].sp_rfr_first_tranche_date);
            $scope.sp_per_modality_data_all_sp_logs.data[x].sp_date_started = $scope.parse_date($scope.sp_per_modality_data_all_sp_logs.data[x].sp_date_started);
            $scope.sp_per_modality_data_all_sp_logs.data[x].sp_date_of_turnover = $scope.parse_date($scope.sp_per_modality_data_all_sp_logs.data[x].sp_date_of_turnover);
            $scope.sp_per_modality_data_all_sp_logs.data[x].sp_target_date_of_completion = $scope.parse_date($scope.sp_per_modality_data_all_sp_logs.data[x].sp_target_date_of_completion);
            $scope.sp_per_modality_data_all_sp_logs.data[x].sp_actual_date_completed = $scope.parse_date($scope.sp_per_modality_data_all_sp_logs.data[x].sp_actual_date_completed);

            for(y = 0; y < $scope.sp_per_modality_data_all_sp_logs.data[x].sp_logs.length; y++){
              $scope.sp_per_modality_data_all_sp_logs.data[x].sp_logs[y].updated_at = $scope.parse_date($scope.sp_per_modality_data_all_sp_logs.data[x].sp_logs[y].updated_at);
            }
          }
    }, function myError(response) {

    });
  }
  // PAGINTION

  $scope.clearFilter = function() {
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

    $scope.search_modal = false;
  };

  $scope.verifier = [];
  $scope.fetch_all_for_export = function(){
      $http({
          method : "GET",
          url : 'fetch_all_for_export',
      }).then(function mySuccess(response) {
          console.log(response.data);

          $scope.sp_per_modality_data_all_sp_logs = response.data;
          $scope.verifier.push($scope.sp_per_modality_data_all_sp_logs);

          for(x = 0; x < $scope.sp_per_modality_data_all_sp_logs.length; x++){

            $scope.sp_per_modality_data_all_sp_logs[x].sp_rfr_first_tranche_date = $scope.parse_date($scope.sp_per_modality_data_all_sp_logs[x].sp_rfr_first_tranche_date);
            $scope.sp_per_modality_data_all_sp_logs[x].sp_date_started = $scope.parse_date($scope.sp_per_modality_data_all_sp_logs[x].sp_date_started);
            $scope.sp_per_modality_data_all_sp_logs[x].sp_date_of_turnover = $scope.parse_date($scope.sp_per_modality_data_all_sp_logs[x].sp_date_of_turnover);
            $scope.sp_per_modality_data_all_sp_logs[x].sp_target_date_of_completion = $scope.parse_date($scope.sp_per_modality_data_all_sp_logs[x].sp_target_date_of_completion);
            $scope.sp_per_modality_data_all_sp_logs[x].sp_actual_date_completed = $scope.parse_date($scope.sp_per_modality_data_all_sp_logs[x].sp_actual_date_completed);

            for(y = 0; y < $scope.sp_per_modality_data_all_sp_logs[x].sp_logs.length; y++){
              $scope.sp_per_modality_data_all_sp_logs[x].sp_logs[y].updated_at = $scope.parse_date($scope.sp_per_modality_data_all_sp_logs[x].sp_logs[y].updated_at);
            }
          }

      }, function myError(response) {
        
      });
  }

  $scope.Export_All_Data = function(){
    $scope.fetch_all_for_export();
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
            $scope.fetch_rpmo_reports();
      }else{
            $scope.fetch_rpmo_reports();
            // window.location.href = "http://kce_v2.caraga.dswd.gov.ph/modality";
      };
    });
  }

  $scope.Export_Modal_Data = function(){
    Swal.fire({
      title: 'Are you sure?',
      text: "Do you want to export this data?",
      icon: 'question',
      showCancelButton: true,
      confirmButtonColor: '#007bff',
      cancelButtonColor: '#dc3545',
      confirmButtonText: 'Yes, export it!'
    }).then((result) => {
      if (result.value) {
            alasql('SELECT * INTO XLS("Modality_Exported_Data.xls",{headers:true}) \
            FROM HTML("#MyInquires1",{headers:true})');
      }else;
    });
  }

  $scope.search_data_modal = function(search_status,search_modality,search_year,search_cycle,search_batch,province_data,municipality_data,brgy_data,search_title,search_sp_id){
    // if(province_data != null){
    //   var prov = province_data.name;
    // }else{
    //   var prov = undefined;
    // };

    // if(municipality_data != null){
    //   var muni = municipality_data.name;
    // }else{
    //   var muni = undefined;
    // };

    // if(brgy_data != null){
    //   var brgy = brgy_data.name;
    // }else{
    //   var brgy = undefined;
    // };

      var datax = {
          search_status:search_status,
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

      // params: {
      //     search_status:search_status,
      //     search_modality:search_modality,
      //     search_year:search_year,
      //     search_cycle:search_cycle,
      //     search_batch:search_batch,
      //     province_data:prov,
      //     municipality_data:muni,
      //     brgy_data:brgy,
      //     search_title:search_title,
      //     search_sp_id:search_sp_id,
      // },

      $http({
          method : "POST",
          url : 'search_data_modal',
          data:datax,
      }).then(function mySuccess(response) {
          // console.log(response.data);
          // $scope.sp_modal_data_reports = response.data[0];
          // console.log($scope.sp_modal_data_reports.data);

          $scope.search_modal = true;

          // for(x = 0; x < $scope.sp_modal_data_reports.data.length; x++){

          //   $scope.sp_modal_data_reports.data[x].sp_rfr_first_tranche_date = $scope.parse_date($scope.sp_modal_data_reports.data[x].sp_rfr_first_tranche_date);
          //   $scope.sp_modal_data_reports.data[x].sp_date_started = $scope.parse_date($scope.sp_modal_data_reports.data[x].sp_date_started);
          //   $scope.sp_modal_data_reports.data[x].sp_date_of_turnover = $scope.parse_date($scope.sp_modal_data_reports.data[x].sp_date_of_turnover);
          //   $scope.sp_modal_data_reports.data[x].sp_target_date_of_completion = $scope.parse_date($scope.sp_modal_data_reports.data[x].sp_target_date_of_completion);
          //   $scope.sp_modal_data_reports.data[x].sp_actual_date_completed = $scope.parse_date($scope.sp_modal_data_reports.data[x].sp_actual_date_completed);
          
          //   for(y = 0; y < $scope.sp_modal_data_reports.data[x].sp_logs.length; y++){
          //     $scope.sp_modal_data_reports.data[x].sp_logs[y].updated_at = $scope.parse_date($scope.sp_modal_data_reports.data[x].sp_logs[y].updated_at);
          //   }
          // }

          $scope.search_modal_sp_for_export = response.data;
          console.log($scope.search_modal_sp_for_export);

          for(x = 0; x < $scope.search_modal_sp_for_export.length; x++){

            $scope.search_modal_sp_for_export[x].sp_rfr_first_tranche_date = $scope.parse_date($scope.search_modal_sp_for_export[x].sp_rfr_first_tranche_date);
            $scope.search_modal_sp_for_export[x].sp_date_started = $scope.parse_date($scope.search_modal_sp_for_export[x].sp_date_started);
            $scope.search_modal_sp_for_export[x].sp_date_of_turnover = $scope.parse_date($scope.search_modal_sp_for_export[x].sp_date_of_turnover);
            $scope.search_modal_sp_for_export[x].sp_target_date_of_completion = $scope.parse_date($scope.search_modal_sp_for_export[x].sp_target_date_of_completion);
            $scope.search_modal_sp_for_export[x].sp_actual_date_completed = $scope.parse_date($scope.search_modal_sp_for_export[x].sp_actual_date_completed);

            for(y = 0; y < $scope.search_modal_sp_for_export[x].sp_logs.length; y++){
              $scope.search_modal_sp_for_export[x].sp_logs[y].updated_at = $scope.parse_date($scope.search_modal_sp_for_export[x].sp_logs[y].updated_at);
            }
          }

      }, function myError(response) {
        
      });
  }

  // PAGINTION MODAL DATA
  $scope.Next_Pagination_Reports_Modal = function(url){
    $http({
          method : "GET",
          url : url,
      }).then(function mySuccess(response) {

        $scope.sp_modal_data_reports = response.data[0];
          console.log($scope.sp_modal_data_reports.data);

          $scope.search_modal = true;

          for(x = 0; x < $scope.sp_modal_data_reports.data.length; x++){

            $scope.sp_modal_data_reports.data[x].sp_rfr_first_tranche_date = $scope.parse_date($scope.sp_modal_data_reports.data[x].sp_rfr_first_tranche_date);
            $scope.sp_modal_data_reports.data[x].sp_date_started = $scope.parse_date($scope.sp_modal_data_reports.data[x].sp_date_started);
            $scope.sp_modal_data_reports.data[x].sp_date_of_turnover = $scope.parse_date($scope.sp_modal_data_reports.data[x].sp_date_of_turnover);
            $scope.sp_modal_data_reports.data[x].sp_target_date_of_completion = $scope.parse_date($scope.sp_modal_data_reports.data[x].sp_target_date_of_completion);
            $scope.sp_modal_data_reports.data[x].sp_actual_date_completed = $scope.parse_date($scope.sp_modal_data_reports.data[x].sp_actual_date_completed);

            for(y = 0; y < $scope.sp_modal_data_reports.data[x].sp_logs.length; y++){
              $scope.sp_modal_data_reports.data[x].sp_logs[y].updated_at = $scope.parse_date($scope.sp_modal_data_reports.data[x].sp_logs[y].updated_at);
            }
          }

          $scope.search_modal_sp_for_export = response.data[1];

          for(x = 0; x < $scope.search_modal_sp_for_export.length; x++){

            $scope.search_modal_sp_for_export[x].sp_rfr_first_tranche_date = $scope.parse_date($scope.search_modal_sp_for_export[x].sp_rfr_first_tranche_date);
            $scope.search_modal_sp_for_export[x].sp_date_started = $scope.parse_date($scope.search_modal_sp_for_export[x].sp_date_started);
            $scope.search_modal_sp_for_export[x].sp_date_of_turnover = $scope.parse_date($scope.search_modal_sp_for_export[x].sp_date_of_turnover);
            $scope.search_modal_sp_for_export[x].sp_target_date_of_completion = $scope.parse_date($scope.search_modal_sp_for_export[x].sp_target_date_of_completion);
            $scope.search_modal_sp_for_export[x].sp_actual_date_completed = $scope.parse_date($scope.search_modal_sp_for_export[x].sp_actual_date_completed);

            for(y = 0; y < $scope.search_modal_sp_for_export[x].sp_logs.length; y++){
              $scope.search_modal_sp_for_export[x].sp_logs[y].updated_at = $scope.parse_date($scope.search_modal_sp_for_export[x].sp_logs[y].updated_at);
            }
          }

      }, function myError(response) {
      
    });
  }

  $scope.Previous_Pagination_Reports_Modal = function (url){
    console.log(url);
    $http({
          method : "GET",
          url : url,
      }).then(function mySuccess(response) {
        $scope.sp_modal_data_reports = response.data[0];
          console.log($scope.sp_modal_data_reports.data);

          $scope.search_modal = true;

          for(x = 0; x < $scope.sp_modal_data_reports.data.length; x++){

            $scope.sp_modal_data_reports.data[x].sp_rfr_first_tranche_date = $scope.parse_date($scope.sp_modal_data_reports.data[x].sp_rfr_first_tranche_date);
            $scope.sp_modal_data_reports.data[x].sp_date_started = $scope.parse_date($scope.sp_modal_data_reports.data[x].sp_date_started);
            $scope.sp_modal_data_reports.data[x].sp_date_of_turnover = $scope.parse_date($scope.sp_modal_data_reports.data[x].sp_date_of_turnover);
            $scope.sp_modal_data_reports.data[x].sp_target_date_of_completion = $scope.parse_date($scope.sp_modal_data_reports.data[x].sp_target_date_of_completion);
            $scope.sp_modal_data_reports.data[x].sp_actual_date_completed = $scope.parse_date($scope.sp_modal_data_reports.data[x].sp_actual_date_completed);

            for(y = 0; y < $scope.sp_modal_data_reports.data[x].sp_logs.length; y++){
              $scope.sp_modal_data_reports.data[x].sp_logs[y].updated_at = $scope.parse_date($scope.sp_modal_data_reports.data[x].sp_logs[y].updated_at);
            }
          }

          $scope.search_modal_sp_for_export = response.data[1];

          for(x = 0; x < $scope.search_modal_sp_for_export.length; x++){

            $scope.search_modal_sp_for_export[x].sp_rfr_first_tranche_date = $scope.parse_date($scope.search_modal_sp_for_export[x].sp_rfr_first_tranche_date);
            $scope.search_modal_sp_for_export[x].sp_date_started = $scope.parse_date($scope.search_modal_sp_for_export[x].sp_date_started);
            $scope.search_modal_sp_for_export[x].sp_date_of_turnover = $scope.parse_date($scope.search_modal_sp_for_export[x].sp_date_of_turnover);
            $scope.search_modal_sp_for_export[x].sp_target_date_of_completion = $scope.parse_date($scope.search_modal_sp_for_export[x].sp_target_date_of_completion);
            $scope.search_modal_sp_for_export[x].sp_actual_date_completed = $scope.parse_date($scope.search_modal_sp_for_export[x].sp_actual_date_completed);

            for(y = 0; y < $scope.search_modal_sp_for_export[x].sp_logs.length; y++){
              $scope.search_modal_sp_for_export[x].sp_logs[y].updated_at = $scope.parse_date($scope.search_modal_sp_for_export[x].sp_logs[y].updated_at);
            }
          }
      }, function myError(response) {
      
    });
  }

  $scope.Skip_To_Page_Reports_Modal = function(path,Page_Number){
    console.log(path);
    console.log(Page_Number);
    $http({
      method : "GET",
      url: path+"?page="+Page_Number,
    }).then(function mySuccess(response) {
        $scope.sp_modal_data_reports = response.data[0];
          console.log($scope.sp_modal_data_reports.data);

          $scope.search_modal = true;

          for(x = 0; x < $scope.sp_modal_data_reports.data.length; x++){

            $scope.sp_modal_data_reports.data[x].sp_rfr_first_tranche_date = $scope.parse_date($scope.sp_modal_data_reports.data[x].sp_rfr_first_tranche_date);
            $scope.sp_modal_data_reports.data[x].sp_date_started = $scope.parse_date($scope.sp_modal_data_reports.data[x].sp_date_started);
            $scope.sp_modal_data_reports.data[x].sp_date_of_turnover = $scope.parse_date($scope.sp_modal_data_reports.data[x].sp_date_of_turnover);
            $scope.sp_modal_data_reports.data[x].sp_target_date_of_completion = $scope.parse_date($scope.sp_modal_data_reports.data[x].sp_target_date_of_completion);
            $scope.sp_modal_data_reports.data[x].sp_actual_date_completed = $scope.parse_date($scope.sp_modal_data_reports.data[x].sp_actual_date_completed);

            for(y = 0; y < $scope.sp_modal_data_reports.data[x].sp_logs.length; y++){
              $scope.sp_modal_data_reports.data[x].sp_logs[y].updated_at = $scope.parse_date($scope.sp_modal_data_reports.data[x].sp_logs[y].updated_at);
            }
          }

          $scope.search_modal_sp_for_export = response.data[1];

          for(x = 0; x < $scope.search_modal_sp_for_export.length; x++){

            $scope.search_modal_sp_for_export[x].sp_rfr_first_tranche_date = $scope.parse_date($scope.search_modal_sp_for_export[x].sp_rfr_first_tranche_date);
            $scope.search_modal_sp_for_export[x].sp_date_started = $scope.parse_date($scope.search_modal_sp_for_export[x].sp_date_started);
            $scope.search_modal_sp_for_export[x].sp_date_of_turnover = $scope.parse_date($scope.search_modal_sp_for_export[x].sp_date_of_turnover);
            $scope.search_modal_sp_for_export[x].sp_target_date_of_completion = $scope.parse_date($scope.search_modal_sp_for_export[x].sp_target_date_of_completion);
            $scope.search_modal_sp_for_export[x].sp_actual_date_completed = $scope.parse_date($scope.search_modal_sp_for_export[x].sp_actual_date_completed);

            for(y = 0; y < $scope.search_modal_sp_for_export[x].sp_logs.length; y++){
              $scope.search_modal_sp_for_export[x].sp_logs[y].updated_at = $scope.parse_date($scope.search_modal_sp_for_export[x].sp_logs[y].updated_at);
            }
          }
    }, function myError(response) {

    });
  }
  // PAGINTION MODAL DATA

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

  $scope.upload_file = function(uploaded_category){
    console.log("response");
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
                    for (var i = 0; i < $scope.file_upload.length; i++) {
                        formData.append('file[' + i+']', $scope.file_upload[i]);
                      }
                    return formData;
                },
            }).then(function mySuccess(response) {
              console.log(response.data);
              if(response.data == "success"){
                $('#preview').empty();
                  Swal.fire(
                  'Yahoo!',
                  'Your file has been uploaded.',
                  'success'
                );
                window.location.href="/"+"rpmo/routes/files";
              }else{
                Swal.fire({
                  title: 'Oooops!',
                  text: "There must be a problem",
                  icon: 'error',
                });
              }
            }, function myError(response) {
                console.log(response);
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
            window.location.href="/"+"rpmo/routes/profile";
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
        }, function myError(response) {
          
        });
      }
    });
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

  $scope.submit_rfr_findings = function(data,rfr_id,modality,year,days){
    $scope.datashit = data;
    console.log("DATASHIT");

    var datax = {
        obj:$scope.datashit,
        rfr_id:rfr_id,
        modality: modality,
        year: year
    }
    console.log(datax);

    $http({
        method : "POST",
        url : '/submit_rfr_findings',
        data : datax,
    }).then(function mySuccess(response) {
        console.log(response.data);

        if(response.data == 1){
          $('#rfr_tracking').modal('hide');
          Swal.fire({
            title: 'Yahoooo!',
            text: "RFR findings successfuly submitted",
            icon: 'success',
          });
          window.location.href="/"+"rpmo/routes/show_modality";
        }else{
          $('#rfr_tracking').modal('hide');
          Swal.fire({
            title: 'Oooops!',
            text: "There must be a problem",
            icon: 'error',
          });
        }
    }, function myError(response) {
      
    });
  }

  $scope.set_findings_complied = function(findings_id,rfr_id,modality,year,set_findings_date_complied){
    var datax = {
        findings_id:findings_id,
        rfr_id:rfr_id,
        modality: modality,
        year: year,
        set_findings_date_complied:set_findings_date_complied
    }
    console.log(datax);

    $http({
        method : "POST",
        url : '/set_findings_complied',
        data : datax,
    }).then(function mySuccess(response) {
        console.log(response.data);

        if(response.data == 1){
          $('#rfr_tracking').modal('hide');
          Swal.fire({
            title: 'Yahoooo!',
            text: "RFR findings successfuly set to complied",
            icon: 'success',
          });
          window.location.href="/"+"rpmo/routes/show_modality";
        }else{
          $('#rfr_tracking').modal('hide');
          Swal.fire({
            title: 'Oooops!',
            text: "There must be a problem",
            icon: 'error',
          });
        }
    }, function myError(response) {
      
    });
  }

  $scope.update_findings_complied = function(findings_id,rfr_id,modality,year,edited_rfr_eng_findings){
    var datax = {
        findings_id:findings_id,
        rfr_id:rfr_id,
        modality: modality,
        year: year,
        edited_rfr_eng_findings:edited_rfr_eng_findings
    }
    console.log(datax);

    $http({
        method : "POST",
        url : '/update_findings_complied',
        data : datax,
    }).then(function mySuccess(response) {
        console.log(response.data);

        if(response.data == 1){
          $('#rfr_tracking').modal('hide');
          Swal.fire({
            title: 'Yahoooo!',
            text: "RFR findings successfuly updated",
            icon: 'success',
          });
          window.location.href="/"+"rpmo/routes/show_modality";
        }else{
          $('#rfr_tracking').modal('hide');
          Swal.fire({
            title: 'Oooops!',
            text: "There must be a problem",
            icon: 'error',
          });
        }
    }, function myError(response) {
      
    });
  }

  $scope.rfr_findings = [];
  $scope.add_rfr_findings = function() {
    var newRFR = {};
    $scope.rfr_findings.push(newRFR);
    console.log($scope.rfr_findings);
  }

  $scope.remove_add_rfr_findings = function(user) {
    var index = $scope.rfr_findings.indexOf(user);
    $scope.rfr_findings.splice(index,1);
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


  $scope.view_specific_sp_spcr_data = function(sp_id,sp_groupings){
    console.log(sp_id);
    console.log(sp_groupings);

    $http({
        method : "GET",
        url : '/fetch_spcr/'+sp_id+'/'+sp_groupings,
    }).then(function mySuccess(response) {
        console.log(response.data);
        $scope.spcr_data = response.data[0];
        $scope.spcr_data_findings = response.data[1];

            // BUB
            if($scope.spcr_data.c_m_f_s_kalahi_2015__b_u_b__s_p != null){
              $scope.spcr_data.c_m_f_s_kalahi_2015__b_u_b__s_p_c_r.received_rpmo = $scope.parse_date($scope.spcr_data.c_m_f_s_kalahi_2015__b_u_b__s_p_c_r.received_rpmo);
              $scope.spcr_data.c_m_f_s_kalahi_2015__b_u_b__s_p_c_r.received_socials = $scope.parse_date($scope.spcr_data.c_m_f_s_kalahi_2015__b_u_b__s_p_c_r.received_socials);
              $scope.spcr_data.c_m_f_s_kalahi_2015__b_u_b__s_p_c_r.received_engineering = $scope.parse_date($scope.spcr_data.c_m_f_s_kalahi_2015__b_u_b__s_p_c_r.received_engineering);
              $scope.spcr_data.c_m_f_s_kalahi_2015__b_u_b__s_p_c_r.received_finance = $scope.parse_date($scope.spcr_data.c_m_f_s_kalahi_2015__b_u_b__s_p_c_r.received_finance);
              $scope.spcr_data.c_m_f_s_kalahi_2015__b_u_b__s_p_c_r.received_npmo = $scope.parse_date($scope.spcr_data.c_m_f_s_kalahi_2015__b_u_b__s_p_c_r.received_npmo);
              $scope.spcr_data.c_m_f_s_kalahi_2015__b_u_b__s_p_c_r.date_encoded = $scope.parse_date($scope.spcr_data.c_m_f_s_kalahi_2015__b_u_b__s_p_c_r.date_encoded);
              $scope.spcr_data.c_m_f_s_kalahi_2015__b_u_b__s_p_c_r.incoming_date = $scope.parse_date($scope.spcr_data.c_m_f_s_kalahi_2015__b_u_b__s_p_c_r.incoming_date);
              $scope.spcr_data.c_m_f_s_kalahi_2015__b_u_b__s_p_c_r.obligation_date = $scope.parse_date($scope.spcr_data.c_m_f_s_kalahi_2015__b_u_b__s_p_c_r.obligation_date);
              $scope.spcr_data.c_m_f_s_kalahi_2015__b_u_b__s_p_c_r.cash_date = $scope.parse_date($scope.spcr_data.c_m_f_s_kalahi_2015__b_u_b__s_p_c_r.cash_date);

              $scope.paramObj = {
                grant: $scope.spcr_data.c_m_f_s_kalahi_2015__b_u_b__s_p.grant,
                other_amount: $scope.spcr_data.c_m_f_s_kalahi_2015__b_u_b__s_p.other_amount,
                lcc_community: $scope.spcr_data.c_m_f_s_kalahi_2015__b_u_b__s_p.lcc_community,
                lcc_community_ik: $scope.spcr_data.c_m_f_s_kalahi_2015__b_u_b__s_p.lcc_community_ik,
                lcc_blgu: $scope.spcr_data.c_m_f_s_kalahi_2015__b_u_b__s_p.lcc_blgu,
                lcc_blgu_ik: $scope.spcr_data.c_m_f_s_kalahi_2015__b_u_b__s_p.lcc_blgu_ik,
                lcc_mlgu: $scope.spcr_data.c_m_f_s_kalahi_2015__b_u_b__s_p.lcc_mlgu,
                lcc_mlgu_ik: $scope.spcr_data.c_m_f_s_kalahi_2015__b_u_b__s_p.lcc_mlgu_ik,
                lcc_plgu: $scope.spcr_data.c_m_f_s_kalahi_2015__b_u_b__s_p.lcc_plgu,
                lcc_plgu_ik: $scope.spcr_data.c_m_f_s_kalahi_2015__b_u_b__s_p.lcc_plgu_ik,
                lcc_others: $scope.spcr_data.c_m_f_s_kalahi_2015__b_u_b__s_p.lcc_others,
                lcc_others_ik: $scope.spcr_data.c_m_f_s_kalahi_2015__b_u_b__s_p.lcc_others_ik,
                lcc_cash: $scope.spcr_data.c_m_f_s_kalahi_2015__b_u_b__s_p.lcc_cash,
                lcc_in_kind: $scope.spcr_data.c_m_f_s_kalahi_2015__b_u_b__s_p.lcc_in_kind,
              }

              $scope.all_lcc = {
                other_amount: $scope.spcr_data.c_m_f_s_kalahi_2015__b_u_b__s_p.other_amount,
                lcc_community: $scope.spcr_data.c_m_f_s_kalahi_2015__b_u_b__s_p.lcc_community,
                lcc_community_ik: $scope.spcr_data.c_m_f_s_kalahi_2015__b_u_b__s_p.lcc_community_ik,
                lcc_blgu: $scope.spcr_data.c_m_f_s_kalahi_2015__b_u_b__s_p.lcc_blgu,
                lcc_blgu_ik: $scope.spcr_data.c_m_f_s_kalahi_2015__b_u_b__s_p.lcc_blgu_ik,
                lcc_mlgu: $scope.spcr_data.c_m_f_s_kalahi_2015__b_u_b__s_p.lcc_mlgu,
                lcc_mlgu_ik: $scope.spcr_data.c_m_f_s_kalahi_2015__b_u_b__s_p.lcc_mlgu_ik,
                lcc_plgu: $scope.spcr_data.c_m_f_s_kalahi_2015__b_u_b__s_p.lcc_plgu,
                lcc_plgu_ik: $scope.spcr_data.c_m_f_s_kalahi_2015__b_u_b__s_p.lcc_plgu_ik,
                lcc_others: $scope.spcr_data.c_m_f_s_kalahi_2015__b_u_b__s_p.lcc_others,
                lcc_others_ik: $scope.spcr_data.c_m_f_s_kalahi_2015__b_u_b__s_p.lcc_others_ik,
                lcc_cash: $scope.spcr_data.c_m_f_s_kalahi_2015__b_u_b__s_p.lcc_cash,
                lcc_in_kind: $scope.spcr_data.c_m_f_s_kalahi_2015__b_u_b__s_p.lcc_in_kind,
              }

              $scope.spcr_data.total_LCC = $scope.get_total_project_cost($scope.all_lcc); 
              $scope.spcr_data.total_cost_ni = $scope.get_total_project_cost($scope.paramObj); 
            
            }else if($scope.spcr_data.c_m_f_s_kalahi_2016__b_u_b__s_p != null){
              $scope.spcr_data.c_m_f_s_kalahi_2016__b_u_b__s_p_c_r.received_rpmo = $scope.parse_date($scope.spcr_data.c_m_f_s_kalahi_2016__b_u_b__s_p_c_r.received_rpmo);
              $scope.spcr_data.c_m_f_s_kalahi_2016__b_u_b__s_p_c_r.received_socials = $scope.parse_date($scope.spcr_data.c_m_f_s_kalahi_2016__b_u_b__s_p_c_r.received_socials);
              $scope.spcr_data.c_m_f_s_kalahi_2016__b_u_b__s_p_c_r.received_engineering = $scope.parse_date($scope.spcr_data.c_m_f_s_kalahi_2016__b_u_b__s_p_c_r.received_engineering);
              $scope.spcr_data.c_m_f_s_kalahi_2016__b_u_b__s_p_c_r.received_finance = $scope.parse_date($scope.spcr_data.c_m_f_s_kalahi_2016__b_u_b__s_p_c_r.received_finance);
              $scope.spcr_data.c_m_f_s_kalahi_2016__b_u_b__s_p_c_r.received_npmo = $scope.parse_date($scope.spcr_data.c_m_f_s_kalahi_2016__b_u_b__s_p_c_r.received_npmo);
              $scope.spcr_data.c_m_f_s_kalahi_2016__b_u_b__s_p_c_r.date_encoded = $scope.parse_date($scope.spcr_data.c_m_f_s_kalahi_2016__b_u_b__s_p_c_r.date_encoded);
              $scope.spcr_data.c_m_f_s_kalahi_2016__b_u_b__s_p_c_r.incoming_date = $scope.parse_date($scope.spcr_data.c_m_f_s_kalahi_2016__b_u_b__s_p_c_r.incoming_date);
              $scope.spcr_data.c_m_f_s_kalahi_2016__b_u_b__s_p_c_r.obligation_date = $scope.parse_date($scope.spcr_data.c_m_f_s_kalahi_2016__b_u_b__s_p_c_r.obligation_date);
              $scope.spcr_data.c_m_f_s_kalahi_2016__b_u_b__s_p_c_r.cash_date = $scope.parse_date($scope.spcr_data.c_m_f_s_kalahi_2016__b_u_b__s_p_c_r.cash_date);

              $scope.paramObj = {
                grant: $scope.spcr_data.c_m_f_s_kalahi_2016__b_u_b__s_p.grant,
                other_amount: $scope.spcr_data.c_m_f_s_kalahi_2016__b_u_b__s_p.other_amount,
                lcc_community: $scope.spcr_data.c_m_f_s_kalahi_2016__b_u_b__s_p.lcc_community,
                lcc_community_ik: $scope.spcr_data.c_m_f_s_kalahi_2016__b_u_b__s_p.lcc_community_ik,
                lcc_blgu: $scope.spcr_data.c_m_f_s_kalahi_2016__b_u_b__s_p.lcc_blgu,
                lcc_blgu_ik: $scope.spcr_data.c_m_f_s_kalahi_2016__b_u_b__s_p.lcc_blgu_ik,
                lcc_mlgu: $scope.spcr_data.c_m_f_s_kalahi_2016__b_u_b__s_p.lcc_mlgu,
                lcc_mlgu_ik: $scope.spcr_data.c_m_f_s_kalahi_2016__b_u_b__s_p.lcc_mlgu_ik,
                lcc_plgu: $scope.spcr_data.c_m_f_s_kalahi_2016__b_u_b__s_p.lcc_plgu,
                lcc_plgu_ik: $scope.spcr_data.c_m_f_s_kalahi_2016__b_u_b__s_p.lcc_plgu_ik,
                lcc_others: $scope.spcr_data.c_m_f_s_kalahi_2016__b_u_b__s_p.lcc_others,
                lcc_others_ik: $scope.spcr_data.c_m_f_s_kalahi_2016__b_u_b__s_p.lcc_others_ik,
                lcc_cash: $scope.spcr_data.c_m_f_s_kalahi_2016__b_u_b__s_p.lcc_cash,
                lcc_in_kind: $scope.spcr_data.c_m_f_s_kalahi_2016__b_u_b__s_p.lcc_in_kind,
              }

              $scope.all_lcc = {
                other_amount: $scope.spcr_data.c_m_f_s_kalahi_2016__b_u_b__s_p.other_amount,
                lcc_community: $scope.spcr_data.c_m_f_s_kalahi_2016__b_u_b__s_p.lcc_community,
                lcc_community_ik: $scope.spcr_data.c_m_f_s_kalahi_2016__b_u_b__s_p.lcc_community_ik,
                lcc_blgu: $scope.spcr_data.c_m_f_s_kalahi_2016__b_u_b__s_p.lcc_blgu,
                lcc_blgu_ik: $scope.spcr_data.c_m_f_s_kalahi_2016__b_u_b__s_p.lcc_blgu_ik,
                lcc_mlgu: $scope.spcr_data.c_m_f_s_kalahi_2016__b_u_b__s_p.lcc_mlgu,
                lcc_mlgu_ik: $scope.spcr_data.c_m_f_s_kalahi_2016__b_u_b__s_p.lcc_mlgu_ik,
                lcc_plgu: $scope.spcr_data.c_m_f_s_kalahi_2016__b_u_b__s_p.lcc_plgu,
                lcc_plgu_ik: $scope.spcr_data.c_m_f_s_kalahi_2016__b_u_b__s_p.lcc_plgu_ik,
                lcc_others: $scope.spcr_data.c_m_f_s_kalahi_2016__b_u_b__s_p.lcc_others,
                lcc_others_ik: $scope.spcr_data.c_m_f_s_kalahi_2016__b_u_b__s_p.lcc_others_ik,
                lcc_cash: $scope.spcr_data.c_m_f_s_kalahi_2016__b_u_b__s_p.lcc_cash,
                lcc_in_kind: $scope.spcr_data.c_m_f_s_kalahi_2016__b_u_b__s_p.lcc_in_kind,
              }

              $scope.spcr_data.total_LCC = $scope.get_total_project_cost($scope.all_lcc); 
              $scope.spcr_data.total_cost_ni = $scope.get_total_project_cost($scope.paramObj); 
            
            }else if($scope.spcr_data.c_m_f_s_kalahi_2017__b_u_b__s_p != null){
              $scope.spcr_data.c_m_f_s_kalahi_2017__b_u_b__s_p_c_r.received_rpmo = $scope.parse_date($scope.spcr_data.c_m_f_s_kalahi_2017__b_u_b__s_p_c_r.received_rpmo);
              $scope.spcr_data.c_m_f_s_kalahi_2017__b_u_b__s_p_c_r.received_socials = $scope.parse_date($scope.spcr_data.c_m_f_s_kalahi_2017__b_u_b__s_p_c_r.received_socials);
              $scope.spcr_data.c_m_f_s_kalahi_2017__b_u_b__s_p_c_r.received_engineering = $scope.parse_date($scope.spcr_data.c_m_f_s_kalahi_2017__b_u_b__s_p_c_r.received_engineering);
              $scope.spcr_data.c_m_f_s_kalahi_2017__b_u_b__s_p_c_r.received_finance = $scope.parse_date($scope.spcr_data.c_m_f_s_kalahi_2017__b_u_b__s_p_c_r.received_finance);
              $scope.spcr_data.c_m_f_s_kalahi_2017__b_u_b__s_p_c_r.received_npmo = $scope.parse_date($scope.spcr_data.c_m_f_s_kalahi_2017__b_u_b__s_p_c_r.received_npmo);
              $scope.spcr_data.c_m_f_s_kalahi_2017__b_u_b__s_p_c_r.date_encoded = $scope.parse_date($scope.spcr_data.c_m_f_s_kalahi_2017__b_u_b__s_p_c_r.date_encoded);
              $scope.spcr_data.c_m_f_s_kalahi_2017__b_u_b__s_p_c_r.incoming_date = $scope.parse_date($scope.spcr_data.c_m_f_s_kalahi_2017__b_u_b__s_p_c_r.incoming_date);
              $scope.spcr_data.c_m_f_s_kalahi_2017__b_u_b__s_p_c_r.obligation_date = $scope.parse_date($scope.spcr_data.c_m_f_s_kalahi_2017__b_u_b__s_p_c_r.obligation_date);
              $scope.spcr_data.c_m_f_s_kalahi_2017__b_u_b__s_p_c_r.cash_date = $scope.parse_date($scope.spcr_data.c_m_f_s_kalahi_2017__b_u_b__s_p_c_r.cash_date);

              $scope.paramObj = {
                grant: $scope.spcr_data.c_m_f_s_kalahi_2017__b_u_b__s_p.grant,
                other_amount: $scope.spcr_data.c_m_f_s_kalahi_2017__b_u_b__s_p.other_amount,
                lcc_community: $scope.spcr_data.c_m_f_s_kalahi_2017__b_u_b__s_p.lcc_community,
                lcc_community_ik: $scope.spcr_data.c_m_f_s_kalahi_2017__b_u_b__s_p.lcc_community_ik,
                lcc_blgu: $scope.spcr_data.c_m_f_s_kalahi_2017__b_u_b__s_p.lcc_blgu,
                lcc_blgu_ik: $scope.spcr_data.c_m_f_s_kalahi_2017__b_u_b__s_p.lcc_blgu_ik,
                lcc_mlgu: $scope.spcr_data.c_m_f_s_kalahi_2017__b_u_b__s_p.lcc_mlgu,
                lcc_mlgu_ik: $scope.spcr_data.c_m_f_s_kalahi_2017__b_u_b__s_p.lcc_mlgu_ik,
                lcc_plgu: $scope.spcr_data.c_m_f_s_kalahi_2017__b_u_b__s_p.lcc_plgu,
                lcc_plgu_ik: $scope.spcr_data.c_m_f_s_kalahi_2017__b_u_b__s_p.lcc_plgu_ik,
                lcc_others: $scope.spcr_data.c_m_f_s_kalahi_2017__b_u_b__s_p.lcc_others,
                lcc_others_ik: $scope.spcr_data.c_m_f_s_kalahi_2017__b_u_b__s_p.lcc_others_ik,
                lcc_cash: $scope.spcr_data.c_m_f_s_kalahi_2017__b_u_b__s_p.lcc_cash,
                lcc_in_kind: $scope.spcr_data.c_m_f_s_kalahi_2017__b_u_b__s_p.lcc_in_kind,
              }
              $scope.all_lcc = {
                other_amount: $scope.spcr_data.c_m_f_s_kalahi_2017__b_u_b__s_p.other_amount,
                lcc_community: $scope.spcr_data.c_m_f_s_kalahi_2017__b_u_b__s_p.lcc_community,
                lcc_community_ik: $scope.spcr_data.c_m_f_s_kalahi_2017__b_u_b__s_p.lcc_community_ik,
                lcc_blgu: $scope.spcr_data.c_m_f_s_kalahi_2017__b_u_b__s_p.lcc_blgu,
                lcc_blgu_ik: $scope.spcr_data.c_m_f_s_kalahi_2017__b_u_b__s_p.lcc_blgu_ik,
                lcc_mlgu: $scope.spcr_data.c_m_f_s_kalahi_2017__b_u_b__s_p.lcc_mlgu,
                lcc_mlgu_ik: $scope.spcr_data.c_m_f_s_kalahi_2017__b_u_b__s_p.lcc_mlgu_ik,
                lcc_plgu: $scope.spcr_data.c_m_f_s_kalahi_2017__b_u_b__s_p.lcc_plgu,
                lcc_plgu_ik: $scope.spcr_data.c_m_f_s_kalahi_2017__b_u_b__s_p.lcc_plgu_ik,
                lcc_others: $scope.spcr_data.c_m_f_s_kalahi_2017__b_u_b__s_p.lcc_others,
                lcc_others_ik: $scope.spcr_data.c_m_f_s_kalahi_2017__b_u_b__s_p.lcc_others_ik,
                lcc_cash: $scope.spcr_data.c_m_f_s_kalahi_2017__b_u_b__s_p.lcc_cash,
                lcc_in_kind: $scope.spcr_data.c_m_f_s_kalahi_2017__b_u_b__s_p.lcc_in_kind,
              }

              $scope.spcr_data.total_LCC = $scope.get_total_project_cost($scope.all_lcc); 
              $scope.spcr_data.total_cost_ni = $scope.get_total_project_cost($scope.paramObj); 

            }else if($scope.spcr_data.c_m_f_s_kalahi_2018__b_u_b__s_p != null){
              $scope.spcr_data.c_m_f_s_kalahi_2018__b_u_b__s_p_c_r.received_rpmo = $scope.parse_date($scope.spcr_data.c_m_f_s_kalahi_2018__b_u_b__s_p_c_r.received_rpmo);
              $scope.spcr_data.c_m_f_s_kalahi_2018__b_u_b__s_p_c_r.received_socials = $scope.parse_date($scope.spcr_data.c_m_f_s_kalahi_2018__b_u_b__s_p_c_r.received_socials);
              $scope.spcr_data.c_m_f_s_kalahi_2018__b_u_b__s_p_c_r.received_engineering = $scope.parse_date($scope.spcr_data.c_m_f_s_kalahi_2018__b_u_b__s_p_c_r.received_engineering);
              $scope.spcr_data.c_m_f_s_kalahi_2018__b_u_b__s_p_c_r.received_finance = $scope.parse_date($scope.spcr_data.c_m_f_s_kalahi_2018__b_u_b__s_p_c_r.received_finance);
              $scope.spcr_data.c_m_f_s_kalahi_2018__b_u_b__s_p_c_r.received_npmo = $scope.parse_date($scope.spcr_data.c_m_f_s_kalahi_2018__b_u_b__s_p_c_r.received_npmo);
              $scope.spcr_data.c_m_f_s_kalahi_2018__b_u_b__s_p_c_r.date_encoded = $scope.parse_date($scope.spcr_data.c_m_f_s_kalahi_2018__b_u_b__s_p_c_r.date_encoded);
              $scope.spcr_data.c_m_f_s_kalahi_2018__b_u_b__s_p_c_r.incoming_date = $scope.parse_date($scope.spcr_data.c_m_f_s_kalahi_2018__b_u_b__s_p_c_r.incoming_date);
              $scope.spcr_data.c_m_f_s_kalahi_2018__b_u_b__s_p_c_r.obligation_date = $scope.parse_date($scope.spcr_data.c_m_f_s_kalahi_2018__b_u_b__s_p_c_r.obligation_date);
              $scope.spcr_data.c_m_f_s_kalahi_2018__b_u_b__s_p_c_r.cash_date = $scope.parse_date($scope.spcr_data.c_m_f_s_kalahi_2018__b_u_b__s_p_c_r.cash_date);

              $scope.paramObj = {
                grant: $scope.spcr_data.c_m_f_s_kalahi_2018__b_u_b__s_p.grant,
                other_amount: $scope.spcr_data.c_m_f_s_kalahi_2018__b_u_b__s_p.other_amount,
                lcc_community: $scope.spcr_data.c_m_f_s_kalahi_2018__b_u_b__s_p.lcc_community,
                lcc_community_ik: $scope.spcr_data.c_m_f_s_kalahi_2018__b_u_b__s_p.lcc_community_ik,
                lcc_blgu: $scope.spcr_data.c_m_f_s_kalahi_2018__b_u_b__s_p.lcc_blgu,
                lcc_blgu_ik: $scope.spcr_data.c_m_f_s_kalahi_2018__b_u_b__s_p.lcc_blgu_ik,
                lcc_mlgu: $scope.spcr_data.c_m_f_s_kalahi_2018__b_u_b__s_p.lcc_mlgu,
                lcc_mlgu_ik: $scope.spcr_data.c_m_f_s_kalahi_2018__b_u_b__s_p.lcc_mlgu_ik,
                lcc_plgu: $scope.spcr_data.c_m_f_s_kalahi_2018__b_u_b__s_p.lcc_plgu,
                lcc_plgu_ik: $scope.spcr_data.c_m_f_s_kalahi_2018__b_u_b__s_p.lcc_plgu_ik,
                lcc_others: $scope.spcr_data.c_m_f_s_kalahi_2018__b_u_b__s_p.lcc_others,
                lcc_others_ik: $scope.spcr_data.c_m_f_s_kalahi_2018__b_u_b__s_p.lcc_others_ik,
                lcc_cash: $scope.spcr_data.c_m_f_s_kalahi_2018__b_u_b__s_p.lcc_cash,
                lcc_in_kind: $scope.spcr_data.c_m_f_s_kalahi_2018__b_u_b__s_p.lcc_in_kind,
              }
              $scope.all_lcc = {
                other_amount: $scope.spcr_data.c_m_f_s_kalahi_2018__b_u_b__s_p.other_amount,
                lcc_community: $scope.spcr_data.c_m_f_s_kalahi_2018__b_u_b__s_p.lcc_community,
                lcc_community_ik: $scope.spcr_data.c_m_f_s_kalahi_2018__b_u_b__s_p.lcc_community_ik,
                lcc_blgu: $scope.spcr_data.c_m_f_s_kalahi_2018__b_u_b__s_p.lcc_blgu,
                lcc_blgu_ik: $scope.spcr_data.c_m_f_s_kalahi_2018__b_u_b__s_p.lcc_blgu_ik,
                lcc_mlgu: $scope.spcr_data.c_m_f_s_kalahi_2018__b_u_b__s_p.lcc_mlgu,
                lcc_mlgu_ik: $scope.spcr_data.c_m_f_s_kalahi_2018__b_u_b__s_p.lcc_mlgu_ik,
                lcc_plgu: $scope.spcr_data.c_m_f_s_kalahi_2018__b_u_b__s_p.lcc_plgu,
                lcc_plgu_ik: $scope.spcr_data.c_m_f_s_kalahi_2018__b_u_b__s_p.lcc_plgu_ik,
                lcc_others: $scope.spcr_data.c_m_f_s_kalahi_2018__b_u_b__s_p.lcc_others,
                lcc_others_ik: $scope.spcr_data.c_m_f_s_kalahi_2018__b_u_b__s_p.lcc_others_ik,
                lcc_cash: $scope.spcr_data.c_m_f_s_kalahi_2018__b_u_b__s_p.lcc_cash,
                lcc_in_kind: $scope.spcr_data.c_m_f_s_kalahi_2018__b_u_b__s_p.lcc_in_kind,
              }

              $scope.spcr_data.total_LCC = $scope.get_total_project_cost($scope.all_lcc); 
              $scope.spcr_data.total_cost_ni = $scope.get_total_project_cost($scope.paramObj); 
            
            }else if($scope.spcr_data.c_m_f_s_kalahi_2020__b_u_b__s_p != null){
              $scope.spcr_data.c_m_f_s_kalahi_2020__b_u_b__s_p_c_r.received_rpmo = $scope.parse_date($scope.spcr_data.c_m_f_s_kalahi_2020__b_u_b__s_p_c_r.received_rpmo);
              $scope.spcr_data.c_m_f_s_kalahi_2020__b_u_b__s_p_c_r.received_socials = $scope.parse_date($scope.spcr_data.c_m_f_s_kalahi_2020__b_u_b__s_p_c_r.received_socials);
              $scope.spcr_data.c_m_f_s_kalahi_2020__b_u_b__s_p_c_r.received_engineering = $scope.parse_date($scope.spcr_data.c_m_f_s_kalahi_2020__b_u_b__s_p_c_r.received_engineering);
              $scope.spcr_data.c_m_f_s_kalahi_2020__b_u_b__s_p_c_r.received_finance = $scope.parse_date($scope.spcr_data.c_m_f_s_kalahi_2020__b_u_b__s_p_c_r.received_finance);
              $scope.spcr_data.c_m_f_s_kalahi_2020__b_u_b__s_p_c_r.received_npmo = $scope.parse_date($scope.spcr_data.c_m_f_s_kalahi_2020__b_u_b__s_p_c_r.received_npmo);
              $scope.spcr_data.c_m_f_s_kalahi_2020__b_u_b__s_p_c_r.date_encoded = $scope.parse_date($scope.spcr_data.c_m_f_s_kalahi_2020__b_u_b__s_p_c_r.date_encoded);
              $scope.spcr_data.c_m_f_s_kalahi_2020__b_u_b__s_p_c_r.incoming_date = $scope.parse_date($scope.spcr_data.c_m_f_s_kalahi_2020__b_u_b__s_p_c_r.incoming_date);
              $scope.spcr_data.c_m_f_s_kalahi_2020__b_u_b__s_p_c_r.obligation_date = $scope.parse_date($scope.spcr_data.c_m_f_s_kalahi_2020__b_u_b__s_p_c_r.obligation_date);
              $scope.spcr_data.c_m_f_s_kalahi_2020__b_u_b__s_p_c_r.cash_date = $scope.parse_date($scope.spcr_data.c_m_f_s_kalahi_2020__b_u_b__s_p_c_r.cash_date);

              $scope.paramObj = {
                grant: $scope.spcr_data.c_m_f_s_kalahi_2020__b_u_b__s_p.grant,
                other_amount: $scope.spcr_data.c_m_f_s_kalahi_2020__b_u_b__s_p.other_amount,
                lcc_community: $scope.spcr_data.c_m_f_s_kalahi_2020__b_u_b__s_p.lcc_community,
                lcc_community_ik: $scope.spcr_data.c_m_f_s_kalahi_2020__b_u_b__s_p.lcc_community_ik,
                lcc_blgu: $scope.spcr_data.c_m_f_s_kalahi_2020__b_u_b__s_p.lcc_blgu,
                lcc_blgu_ik: $scope.spcr_data.c_m_f_s_kalahi_2020__b_u_b__s_p.lcc_blgu_ik,
                lcc_mlgu: $scope.spcr_data.c_m_f_s_kalahi_2020__b_u_b__s_p.lcc_mlgu,
                lcc_mlgu_ik: $scope.spcr_data.c_m_f_s_kalahi_2020__b_u_b__s_p.lcc_mlgu_ik,
                lcc_plgu: $scope.spcr_data.c_m_f_s_kalahi_2020__b_u_b__s_p.lcc_plgu,
                lcc_plgu_ik: $scope.spcr_data.c_m_f_s_kalahi_2020__b_u_b__s_p.lcc_plgu_ik,
                lcc_others: $scope.spcr_data.c_m_f_s_kalahi_2020__b_u_b__s_p.lcc_others,
                lcc_others_ik: $scope.spcr_data.c_m_f_s_kalahi_2020__b_u_b__s_p.lcc_others_ik,
                lcc_cash: $scope.spcr_data.c_m_f_s_kalahi_2020__b_u_b__s_p.lcc_cash,
                lcc_in_kind: $scope.spcr_data.c_m_f_s_kalahi_2020__b_u_b__s_p.lcc_in_kind,
              }
              $scope.all_lcc = {
                other_amount: $scope.spcr_data.c_m_f_s_kalahi_2020__b_u_b__s_p.other_amount,
                lcc_community: $scope.spcr_data.c_m_f_s_kalahi_2020__b_u_b__s_p.lcc_community,
                lcc_community_ik: $scope.spcr_data.c_m_f_s_kalahi_2020__b_u_b__s_p.lcc_community_ik,
                lcc_blgu: $scope.spcr_data.c_m_f_s_kalahi_2020__b_u_b__s_p.lcc_blgu,
                lcc_blgu_ik: $scope.spcr_data.c_m_f_s_kalahi_2020__b_u_b__s_p.lcc_blgu_ik,
                lcc_mlgu: $scope.spcr_data.c_m_f_s_kalahi_2020__b_u_b__s_p.lcc_mlgu,
                lcc_mlgu_ik: $scope.spcr_data.c_m_f_s_kalahi_2020__b_u_b__s_p.lcc_mlgu_ik,
                lcc_plgu: $scope.spcr_data.c_m_f_s_kalahi_2020__b_u_b__s_p.lcc_plgu,
                lcc_plgu_ik: $scope.spcr_data.c_m_f_s_kalahi_2020__b_u_b__s_p.lcc_plgu_ik,
                lcc_others: $scope.spcr_data.c_m_f_s_kalahi_2020__b_u_b__s_p.lcc_others,
                lcc_others_ik: $scope.spcr_data.c_m_f_s_kalahi_2020__b_u_b__s_p.lcc_others_ik,
                lcc_cash: $scope.spcr_data.c_m_f_s_kalahi_2020__b_u_b__s_p.lcc_cash,
                lcc_in_kind: $scope.spcr_data.c_m_f_s_kalahi_2020__b_u_b__s_p.lcc_in_kind,
              }

              $scope.spcr_data.total_LCC = $scope.get_total_project_cost($scope.all_lcc); 
              $scope.spcr_data.total_cost_ni = $scope.get_total_project_cost($scope.paramObj); 

            }else;

            // NCDDP

            if($scope.spcr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p != null){
              $scope.spcr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p_c_r.received_rpmo = $scope.parse_date($scope.spcr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p_c_r.received_rpmo);
              $scope.spcr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p_c_r.received_socials = $scope.parse_date($scope.spcr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p_c_r.received_socials);
              $scope.spcr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p_c_r.received_engineering = $scope.parse_date($scope.spcr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p_c_r.received_engineering);
              $scope.spcr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p_c_r.received_finance = $scope.parse_date($scope.spcr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p_c_r.received_finance);
              $scope.spcr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p_c_r.received_npmo = $scope.parse_date($scope.spcr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p_c_r.received_npmo);
              $scope.spcr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p_c_r.date_encoded = $scope.parse_date($scope.spcr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p_c_r.date_encoded);
              $scope.spcr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p_c_r.incoming_date = $scope.parse_date($scope.spcr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p_c_r.incoming_date);
              $scope.spcr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p_c_r.obligation_date = $scope.parse_date($scope.spcr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p_c_r.obligation_date);
              $scope.spcr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p_c_r.cash_date = $scope.parse_date($scope.spcr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p_c_r.cash_date);

              $scope.paramObj = {
                grant: $scope.spcr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p.grant,
                other_amount: $scope.spcr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p.other_amount,
                lcc_community: $scope.spcr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p.lcc_community,
                lcc_community_ik: $scope.spcr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p.lcc_community_ik,
                lcc_blgu: $scope.spcr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p.lcc_blgu,
                lcc_blgu_ik: $scope.spcr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p.lcc_blgu_ik,
                lcc_mlgu: $scope.spcr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p.lcc_mlgu,
                lcc_mlgu_ik: $scope.spcr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p.lcc_mlgu_ik,
                lcc_plgu: $scope.spcr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p.lcc_plgu,
                lcc_plgu_ik: $scope.spcr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p.lcc_plgu_ik,
                lcc_others: $scope.spcr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p.lcc_others,
                lcc_others_ik: $scope.spcr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p.lcc_others_ik,
                lcc_cash: $scope.spcr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p.lcc_cash,
                lcc_in_kind: $scope.spcr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p.lcc_in_kind,
              }
              $scope.all_lcc = {
                other_amount: $scope.spcr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p.other_amount,
                lcc_community: $scope.spcr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p.lcc_community,
                lcc_community_ik: $scope.spcr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p.lcc_community_ik,
                lcc_blgu: $scope.spcr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p.lcc_blgu,
                lcc_blgu_ik: $scope.spcr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p.lcc_blgu_ik,
                lcc_mlgu: $scope.spcr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p.lcc_mlgu,
                lcc_mlgu_ik: $scope.spcr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p.lcc_mlgu_ik,
                lcc_plgu: $scope.spcr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p.lcc_plgu,
                lcc_plgu_ik: $scope.spcr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p.lcc_plgu_ik,
                lcc_others: $scope.spcr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p.lcc_others,
                lcc_others_ik: $scope.spcr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p.lcc_others_ik,
                lcc_cash: $scope.spcr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p.lcc_cash,
                lcc_in_kind: $scope.spcr_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p.lcc_in_kind,
              }

              $scope.spcr_data.total_LCC = $scope.get_total_project_cost($scope.all_lcc); 
              $scope.spcr_data.total_cost_ni = $scope.get_total_project_cost($scope.paramObj); 
            
            }else if($scope.spcr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p != null){
              $scope.spcr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p_c_r.received_rpmo = $scope.parse_date($scope.spcr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p_c_r.received_rpmo);
              $scope.spcr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p_c_r.received_socials = $scope.parse_date($scope.spcr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p_c_r.received_socials);
              $scope.spcr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p_c_r.received_engineering = $scope.parse_date($scope.spcr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p_c_r.received_engineering);
              $scope.spcr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p_c_r.received_finance = $scope.parse_date($scope.spcr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p_c_r.received_finance);
              $scope.spcr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p_c_r.received_npmo = $scope.parse_date($scope.spcr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p_c_r.received_npmo);
              $scope.spcr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p_c_r.date_encoded = $scope.parse_date($scope.spcr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p_c_r.date_encoded);
              $scope.spcr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p_c_r.incoming_date = $scope.parse_date($scope.spcr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p_c_r.incoming_date);
              $scope.spcr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p_c_r.obligation_date = $scope.parse_date($scope.spcr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p_c_r.obligation_date);
              $scope.spcr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p_c_r.cash_date = $scope.parse_date($scope.spcr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p_c_r.cash_date);

              $scope.paramObj = {
                grant: $scope.spcr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p.grant,
                other_amount: $scope.spcr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p.other_amount,
                lcc_community: $scope.spcr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p.lcc_community,
                lcc_community_ik: $scope.spcr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p.lcc_community_ik,
                lcc_blgu: $scope.spcr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p.lcc_blgu,
                lcc_blgu_ik: $scope.spcr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p.lcc_blgu_ik,
                lcc_mlgu: $scope.spcr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p.lcc_mlgu,
                lcc_mlgu_ik: $scope.spcr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p.lcc_mlgu_ik,
                lcc_plgu: $scope.spcr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p.lcc_plgu,
                lcc_plgu_ik: $scope.spcr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p.lcc_plgu_ik,
                lcc_others: $scope.spcr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p.lcc_others,
                lcc_others_ik: $scope.spcr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p.lcc_others_ik,
                lcc_cash: $scope.spcr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p.lcc_cash,
                lcc_in_kind: $scope.spcr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p.lcc_in_kind,
              }
              $scope.all_lcc = {
                other_amount: $scope.spcr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p.other_amount,
                lcc_community: $scope.spcr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p.lcc_community,
                lcc_community_ik: $scope.spcr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p.lcc_community_ik,
                lcc_blgu: $scope.spcr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p.lcc_blgu,
                lcc_blgu_ik: $scope.spcr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p.lcc_blgu_ik,
                lcc_mlgu: $scope.spcr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p.lcc_mlgu,
                lcc_mlgu_ik: $scope.spcr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p.lcc_mlgu_ik,
                lcc_plgu: $scope.spcr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p.lcc_plgu,
                lcc_plgu_ik: $scope.spcr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p.lcc_plgu_ik,
                lcc_others: $scope.spcr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p.lcc_others,
                lcc_others_ik: $scope.spcr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p.lcc_others_ik,
                lcc_cash: $scope.spcr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p.lcc_cash,
                lcc_in_kind: $scope.spcr_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p.lcc_in_kind,
              }

              $scope.spcr_data.total_LCC = $scope.get_total_project_cost($scope.all_lcc); 
              $scope.spcr_data.total_cost_ni = $scope.get_total_project_cost($scope.paramObj); 
            
            }else if($scope.spcr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p != null){
              $scope.spcr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p_c_r.received_rpmo = $scope.parse_date($scope.spcr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p_c_r.received_rpmo);
              $scope.spcr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p_c_r.received_socials = $scope.parse_date($scope.spcr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p_c_r.received_socials);
              $scope.spcr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p_c_r.received_engineering = $scope.parse_date($scope.spcr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p_c_r.received_engineering);
              $scope.spcr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p_c_r.received_finance = $scope.parse_date($scope.spcr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p_c_r.received_finance);
              $scope.spcr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p_c_r.received_npmo = $scope.parse_date($scope.spcr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p_c_r.received_npmo);
              $scope.spcr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p_c_r.date_encoded = $scope.parse_date($scope.spcr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p_c_r.date_encoded);
              $scope.spcr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p_c_r.incoming_date = $scope.parse_date($scope.spcr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p_c_r.incoming_date);
              $scope.spcr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p_c_r.obligation_date = $scope.parse_date($scope.spcr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p_c_r.obligation_date);
              $scope.spcr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p_c_r.cash_date = $scope.parse_date($scope.spcr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p_c_r.cash_date);

              $scope.paramObj = {
                grant: $scope.spcr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p.grant,
                other_amount: $scope.spcr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p.other_amount,
                lcc_community: $scope.spcr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p.lcc_community,
                lcc_community_ik: $scope.spcr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p.lcc_community_ik,
                lcc_blgu: $scope.spcr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p.lcc_blgu,
                lcc_blgu_ik: $scope.spcr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p.lcc_blgu_ik,
                lcc_mlgu: $scope.spcr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p.lcc_mlgu,
                lcc_mlgu_ik: $scope.spcr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p.lcc_mlgu_ik,
                lcc_plgu: $scope.spcr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p.lcc_plgu,
                lcc_plgu_ik: $scope.spcr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p.lcc_plgu_ik,
                lcc_others: $scope.spcr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p.lcc_others,
                lcc_others_ik: $scope.spcr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p.lcc_others_ik,
                lcc_cash: $scope.spcr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p.lcc_cash,
                lcc_in_kind: $scope.spcr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p.lcc_in_kind,
              }
              $scope.all_lcc = {
                other_amount: $scope.spcr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p.other_amount,
                lcc_community: $scope.spcr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p.lcc_community,
                lcc_community_ik: $scope.spcr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p.lcc_community_ik,
                lcc_blgu: $scope.spcr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p.lcc_blgu,
                lcc_blgu_ik: $scope.spcr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p.lcc_blgu_ik,
                lcc_mlgu: $scope.spcr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p.lcc_mlgu,
                lcc_mlgu_ik: $scope.spcr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p.lcc_mlgu_ik,
                lcc_plgu: $scope.spcr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p.lcc_plgu,
                lcc_plgu_ik: $scope.spcr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p.lcc_plgu_ik,
                lcc_others: $scope.spcr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p.lcc_others,
                lcc_others_ik: $scope.spcr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p.lcc_others_ik,
                lcc_cash: $scope.spcr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p.lcc_cash,
                lcc_in_kind: $scope.spcr_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p.lcc_in_kind,
              }

              $scope.spcr_data.total_LCC = $scope.get_total_project_cost($scope.all_lcc); 
              $scope.spcr_data.total_cost_ni = $scope.get_total_project_cost($scope.paramObj); 

            }else if($scope.spcr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p != null){
              $scope.spcr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p_c_r.received_rpmo = $scope.parse_date($scope.spcr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p_c_r.received_rpmo);
              $scope.spcr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p_c_r.received_socials = $scope.parse_date($scope.spcr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p_c_r.received_socials);
              $scope.spcr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p_c_r.received_engineering = $scope.parse_date($scope.spcr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p_c_r.received_engineering);
              $scope.spcr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p_c_r.received_finance = $scope.parse_date($scope.spcr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p_c_r.received_finance);
              $scope.spcr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p_c_r.received_npmo = $scope.parse_date($scope.spcr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p_c_r.received_npmo);
              $scope.spcr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p_c_r.date_encoded = $scope.parse_date($scope.spcr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p_c_r.date_encoded);
              $scope.spcr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p_c_r.incoming_date = $scope.parse_date($scope.spcr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p_c_r.incoming_date);
              $scope.spcr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p_c_r.obligation_date = $scope.parse_date($scope.spcr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p_c_r.obligation_date);
              $scope.spcr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p_c_r.cash_date = $scope.parse_date($scope.spcr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p_c_r.cash_date);

              $scope.paramObj = {
                grant: $scope.spcr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p.grant,
                other_amount: $scope.spcr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p.other_amount,
                lcc_community: $scope.spcr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p.lcc_community,
                lcc_community_ik: $scope.spcr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p.lcc_community_ik,
                lcc_blgu: $scope.spcr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p.lcc_blgu,
                lcc_blgu_ik: $scope.spcr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p.lcc_blgu_ik,
                lcc_mlgu: $scope.spcr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p.lcc_mlgu,
                lcc_mlgu_ik: $scope.spcr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p.lcc_mlgu_ik,
                lcc_plgu: $scope.spcr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p.lcc_plgu,
                lcc_plgu_ik: $scope.spcr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p.lcc_plgu_ik,
                lcc_others: $scope.spcr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p.lcc_others,
                lcc_others_ik: $scope.spcr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p.lcc_others_ik,
                lcc_cash: $scope.spcr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p.lcc_cash,
                lcc_in_kind: $scope.spcr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p.lcc_in_kind,
              }
              $scope.all_lcc = {
                other_amount: $scope.spcr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p.other_amount,
                lcc_community: $scope.spcr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p.lcc_community,
                lcc_community_ik: $scope.spcr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p.lcc_community_ik,
                lcc_blgu: $scope.spcr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p.lcc_blgu,
                lcc_blgu_ik: $scope.spcr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p.lcc_blgu_ik,
                lcc_mlgu: $scope.spcr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p.lcc_mlgu,
                lcc_mlgu_ik: $scope.spcr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p.lcc_mlgu_ik,
                lcc_plgu: $scope.spcr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p.lcc_plgu,
                lcc_plgu_ik: $scope.spcr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p.lcc_plgu_ik,
                lcc_others: $scope.spcr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p.lcc_others,
                lcc_others_ik: $scope.spcr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p.lcc_others_ik,
                lcc_cash: $scope.spcr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p.lcc_cash,
                lcc_in_kind: $scope.spcr_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p.lcc_in_kind,
              }

              $scope.spcr_data.total_LCC = $scope.get_total_project_cost($scope.all_lcc); 
              $scope.spcr_data.total_cost_ni = $scope.get_total_project_cost($scope.paramObj); 
            
            }else if($scope.spcr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p != null){
              $scope.spcr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p_c_r.received_rpmo = $scope.parse_date($scope.spcr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p_c_r.received_rpmo);
              $scope.spcr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p_c_r.received_socials = $scope.parse_date($scope.spcr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p_c_r.received_socials);
              $scope.spcr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p_c_r.received_engineering = $scope.parse_date($scope.spcr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p_c_r.received_engineering);
              $scope.spcr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p_c_r.received_finance = $scope.parse_date($scope.spcr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p_c_r.received_finance);
              $scope.spcr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p_c_r.received_npmo = $scope.parse_date($scope.spcr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p_c_r.received_npmo);
              $scope.spcr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p_c_r.date_encoded = $scope.parse_date($scope.spcr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p_c_r.date_encoded);
              $scope.spcr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p_c_r.incoming_date = $scope.parse_date($scope.spcr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p_c_r.incoming_date);
              $scope.spcr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p_c_r.obligation_date = $scope.parse_date($scope.spcr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p_c_r.obligation_date);
              $scope.spcr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p_c_r.cash_date = $scope.parse_date($scope.spcr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p_c_r.cash_date);

              $scope.paramObj = {
                grant: $scope.spcr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p.grant,
                other_amount: $scope.spcr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p.other_amount,
                lcc_community: $scope.spcr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p.lcc_community,
                lcc_community_ik: $scope.spcr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p.lcc_community_ik,
                lcc_blgu: $scope.spcr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p.lcc_blgu,
                lcc_blgu_ik: $scope.spcr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p.lcc_blgu_ik,
                lcc_mlgu: $scope.spcr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p.lcc_mlgu,
                lcc_mlgu_ik: $scope.spcr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p.lcc_mlgu_ik,
                lcc_plgu: $scope.spcr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p.lcc_plgu,
                lcc_plgu_ik: $scope.spcr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p.lcc_plgu_ik,
                lcc_others: $scope.spcr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p.lcc_others,
                lcc_others_ik: $scope.spcr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p.lcc_others_ik,
                lcc_cash: $scope.spcr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p.lcc_cash,
                lcc_in_kind: $scope.spcr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p.lcc_in_kind,
              }
              $scope.all_lcc = {
                other_amount: $scope.spcr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p.other_amount,
                lcc_community: $scope.spcr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p.lcc_community,
                lcc_community_ik: $scope.spcr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p.lcc_community_ik,
                lcc_blgu: $scope.spcr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p.lcc_blgu,
                lcc_blgu_ik: $scope.spcr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p.lcc_blgu_ik,
                lcc_mlgu: $scope.spcr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p.lcc_mlgu,
                lcc_mlgu_ik: $scope.spcr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p.lcc_mlgu_ik,
                lcc_plgu: $scope.spcr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p.lcc_plgu,
                lcc_plgu_ik: $scope.spcr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p.lcc_plgu_ik,
                lcc_others: $scope.spcr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p.lcc_others,
                lcc_others_ik: $scope.spcr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p.lcc_others_ik,
                lcc_cash: $scope.spcr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p.lcc_cash,
                lcc_in_kind: $scope.spcr_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p.lcc_in_kind,
              }

              $scope.spcr_data.total_LCC = $scope.get_total_project_cost($scope.all_lcc); 
              $scope.spcr_data.total_cost_ni = $scope.get_total_project_cost($scope.paramObj); 
            
            }else if($scope.spcr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p != null){
              $scope.spcr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p_c_r.received_rpmo = $scope.parse_date($scope.spcr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p_c_r.received_rpmo);
              $scope.spcr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p_c_r.received_socials = $scope.parse_date($scope.spcr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p_c_r.received_socials);
              $scope.spcr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p_c_r.received_engineering = $scope.parse_date($scope.spcr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p_c_r.received_engineering);
              $scope.spcr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p_c_r.received_finance = $scope.parse_date($scope.spcr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p_c_r.received_finance);
              $scope.spcr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p_c_r.received_npmo = $scope.parse_date($scope.spcr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p_c_r.received_npmo);
              $scope.spcr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p_c_r.date_encoded = $scope.parse_date($scope.spcr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p_c_r.date_encoded);
              $scope.spcr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p_c_r.incoming_date = $scope.parse_date($scope.spcr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p_c_r.incoming_date);
              $scope.spcr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p_c_r.obligation_date = $scope.parse_date($scope.spcr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p_c_r.obligation_date);
              $scope.spcr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p_c_r.cash_date = $scope.parse_date($scope.spcr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p_c_r.cash_date);

              $scope.paramObj = {
                grant: $scope.spcr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p.grant,
                other_amount: $scope.spcr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p.other_amount,
                lcc_community: $scope.spcr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p.lcc_community,
                lcc_community_ik: $scope.spcr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p.lcc_community_ik,
                lcc_blgu: $scope.spcr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p.lcc_blgu,
                lcc_blgu_ik: $scope.spcr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p.lcc_blgu_ik,
                lcc_mlgu: $scope.spcr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p.lcc_mlgu,
                lcc_mlgu_ik: $scope.spcr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p.lcc_mlgu_ik,
                lcc_plgu: $scope.spcr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p.lcc_plgu,
                lcc_plgu_ik: $scope.spcr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p.lcc_plgu_ik,
                lcc_others: $scope.spcr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p.lcc_others,
                lcc_others_ik: $scope.spcr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p.lcc_others_ik,
                lcc_cash: $scope.spcr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p.lcc_cash,
                lcc_in_kind: $scope.spcr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p.lcc_in_kind,
              }
              $scope.all_lcc = {
                other_amount: $scope.spcr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p.other_amount,
                lcc_community: $scope.spcr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p.lcc_community,
                lcc_community_ik: $scope.spcr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p.lcc_community_ik,
                lcc_blgu: $scope.spcr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p.lcc_blgu,
                lcc_blgu_ik: $scope.spcr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p.lcc_blgu_ik,
                lcc_mlgu: $scope.spcr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p.lcc_mlgu,
                lcc_mlgu_ik: $scope.spcr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p.lcc_mlgu_ik,
                lcc_plgu: $scope.spcr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p.lcc_plgu,
                lcc_plgu_ik: $scope.spcr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p.lcc_plgu_ik,
                lcc_others: $scope.spcr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p.lcc_others,
                lcc_others_ik: $scope.spcr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p.lcc_others_ik,
                lcc_cash: $scope.spcr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p.lcc_cash,
                lcc_in_kind: $scope.spcr_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p.lcc_in_kind,
              }

              $scope.spcr_data.total_LCC = $scope.get_total_project_cost($scope.all_lcc); 
              $scope.spcr_data.total_cost_ni = $scope.get_total_project_cost($scope.paramObj); 
            
            }else;

    }, function myError(response) {});

  }

  $scope.submit_spcr_findings = function(data,spcr_id,modality,year,days){
    $scope.datashit = data;
    console.log("DATASHIT");

    var datax = {
        obj:$scope.datashit,
        spcr_id:spcr_id,
        modality: modality,
        year: year
    }
    console.log(datax);

    $http({
        method : "POST",
        url : '/submit_spcr_findings',
        data : datax,
    }).then(function mySuccess(response) {
        console.log(response.data);

        if(response.data == 1){
          $('#spcr_tracking').modal('hide');
          Swal.fire({
            title: 'Yahoooo!',
            text: "SPCR findings successfuly submitted",
            icon: 'success',
          });
          window.location.href="/"+"rpmo/routes/show_modality";
        }else{
          $('#spcr_tracking').modal('hide');
          Swal.fire({
            title: 'Oooops!',
            text: "There must be a problem",
            icon: 'error',
          });
        }
    }, function myError(response) {
      
    });
  }

  $scope.set_findings_complied_spcr = function(findings_id,spcr_id,modality,year,set_findings_date_complied){
    var datax = {
        findings_id:findings_id,
        spcr_id:spcr_id,
        modality: modality,
        year: year,
        set_findings_date_complied:set_findings_date_complied
    }
    console.log(datax);

    $http({
        method : "POST",
        url : '/set_findings_complied_spcr',
        data : datax,
    }).then(function mySuccess(response) {
        console.log(response.data);

        if(response.data == 1){
          $('#spcr_tracking').modal('hide');
          Swal.fire({
            title: 'Yahoooo!',
            text: "SPCR findings successfuly set to complied",
            icon: 'success',
          });
          window.location.href="/"+"rpmo/routes/show_modality";
        }else{
          $('#spcr_tracking').modal('hide');
          Swal.fire({
            title: 'Oooops!',
            text: "There must be a problem",
            icon: 'error',
          });
        }
    }, function myError(response) {
      
    });
  }

  $scope.update_findings_complied_spcr = function(findings_id,spcr_id,modality,year,edited_rfr_eng_findings){
    var datax = {
        findings_id:findings_id,
        spcr_id:spcr_id,
        modality: modality,
        year: year,
        edited_rfr_eng_findings:edited_rfr_eng_findings
    }
    console.log(datax);

    $http({
        method : "POST",
        url : '/update_findings_complied_spcr',
        data : datax,
    }).then(function mySuccess(response) {
        console.log(response.data);

        if(response.data == 1){
          $('#spcr_tracking').modal('hide');
          Swal.fire({
            title: 'Yahoooo!',
            text: "SPCR findings successfuly updated",
            icon: 'success',
          });
          window.location.href="/"+"rpmo/routes/show_modality";
        }else{
          $('#spcr_tracking').modal('hide');
          Swal.fire({
            title: 'Oooops!',
            text: "There must be a problem",
            icon: 'error',
          });
        }
    }, function myError(response) {
      
    });
  }

  $scope.spcr_findings = [];
  $scope.add_spcr_findings = function() {
    var newSPCR = {};
    $scope.spcr_findings.push(newSPCR);
    console.log($scope.spcr_findings);
  }

  $scope.remove_add_spcr_findings = function(user) {
    var index = $scope.spcr_findings.indexOf(user);
    $scope.spcr_findings.splice(index,1);
  }

});
// end of RPMO Conroller