var app = angular.module('Admin_Function', ['ngRoute']);

app.controller('Admin_Controller', function($scope,$http,$filter) {
	console.log('Admin_Controller');

  $scope.mini_navbar = true;
	$.ajaxSetup({
	    headers: {
	        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	    }
	});

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

  function js_yyyy_mm_dd_hh_mm_ss (input) {
      now = input;
      console.log(now);

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

  $scope.fetch_modality_div = false;
  $scope.fetch_dashboard_div = false;
  $scope.fetch_user_div = false;

	$scope.fetch_admin_dashboard = function(){
		$http({
      method : "GET",
      url : 'routes/fetch_admin_dashboard',
    }).then(function mySuccess(response) {
      console.log(response.data)
      $scope.weighted_kkb_percetage = response.data[0];
      $scope.weighted_makilahok_percetage = response.data[1];
      $scope.weighted_ncddp_percetage = response.data[2];
      $scope.weighted_ipccdd_percetage = response.data[3];
      $scope.weighted_ccl_percetage = response.data[4];
      $scope.weighted_LandE_percetage = response.data[5];
      $scope.Count_On_going_sp = response.data[6];
      $scope.Count_Completed_sp = response.data[7];
      $scope.Average_Est_Days_Completion = response.data[8];
      $scope.Average_Actual_Days_Completion = response.data[9];
      $scope.latest_sp = response.data[10];
      $scope.latest_sp.updated_at = $scope.parse_date($scope.latest_sp.updated_at);
      $scope.sp_logs = response.data[11];
      $scope.nys = response.data[12];
      $scope.ongoing = response.data[13];
      $scope.completed = response.data[14];
  
      $scope.render_charts_sp_latest($scope.latest_sp);
      $scope.render_weighted_percentage($scope.weighted_kkb_percetage,$scope.weighted_makilahok_percetage,$scope.weighted_ncddp_percetage,$scope.weighted_ipccdd_percetage,$scope.weighted_ccl_percetage,$scope.weighted_LandE_percetage);
      
      $scope.render_sp_status_data($scope.nys,$scope.ongoing,$scope.completed);
      }, function myError(response) {});
	}

  $scope.render_charts_sp_latest = function(data){
    // For SP
      $scope.chart_slippage = [];
      $scope.chart_planned = [];
      $scope.chart_actual = [];
      $scope.chart_labels = [];
      $scope.sp_chart_data = [];

      for(var x = 0; x < data.sp_logs.length; x++){
        console.log(data.sp_logs[x].sp_logs_slippage);
        $scope.chart_slippage.push(data.sp_logs[x].sp_logs_slippage);
        $scope.chart_planned.push(data.sp_logs[x].sp_logs_planned);
        $scope.chart_actual.push(data.sp_logs[x].sp_logs_actual);
        $scope.chart_labels.push(data.sp_logs[x].sp_logs_planned_target_date);
      }
    var ctx = document.getElementById("myChart").getContext('2d');

    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: $scope.chart_labels,
              datasets: [{
                  label: 'Planned',
                  data:  $scope.chart_planned, // Specify the data values array
                  fill: false,
                  borderColor: '#fd7e14',
                  backgroundColor: '#fd7e14',
                  borderWidth: 1
              },
          {
                  label: 'Actual',
                  data:  $scope.chart_actual, // Specify the data values array
                  fill: false,
                  borderColor: '#2196f3',
                  backgroundColor: '#2196f3',
                  borderWidth: 1
              },
          {
                  label: 'Slippage',
                  data:  $scope.chart_slippage, // Specify the data values array
                  fill: false,
                  borderColor: '#dc3545',
                  backgroundColor: '#dc3545',
                  borderWidth: 1
              },
            ]},
        options: {
          responsive: true,
          maintainAspectRatio: false,
          scales: {
            display: true,
            xAxes: [{
            ticks: {
                fontSize: 9,
            minRotation: 90
            }
          }],
        yAxes: [{
          display: true,
          ticks: {
            stepSize: 30 // <----- This prop sets the stepSize
          }
          }]
        },
        }
    });
  }

  $scope.render_weighted_percentage = function(weighted_kkb_percetage,weighted_makilahok_percetage,weighted_ncddp_percetage,weighted_ipccdd_percetage,weighted_ccl_percetage,weighted_LandE_percetage){
    // For SP
    var ctx = document.getElementById("render_weighted_percentage_chart").getContext('2d');

    var myChart = new Chart(ctx, {
      type: 'bar',
      data: {
      labels: ["NCDDP","IP CDD","MAKILAHOK","KKB","L&E","CCL"],
      datasets: [{
        data: [weighted_ncddp_percetage, weighted_ipccdd_percetage, weighted_makilahok_percetage, weighted_kkb_percetage, weighted_LandE_percetage, weighted_ccl_percetage],
        backgroundColor: [
          'rgba(255, 99, 132, 1)',
          'rgba(54, 162, 235, 1)',
          'rgba(255, 206, 86, 1)',
          'rgba(75, 192, 192, 1)',
          'rgba(153, 102, 255, 1)',
          'rgba(255, 159, 64, 1)'
        ],
        borderColor: [
          'rgba(255, 99, 132, 1)',
          'rgba(54, 162, 235, 1)',
          'rgba(255, 206, 86, 1)',
          'rgba(75, 192, 192, 1)',
          'rgba(153, 102, 255, 1)',
          'rgba(255, 159, 64, 1)'
        ],
        borderWidth: 1
      }]
      },
      options: {
      responsive: false,
        legend: {
            display: false
        },
      scales: {
        xAxes: [{
            gridLines: {
            offsetGridLines: true // à rajouter
          }
        },
        ],

      }
      }
    });
  }

  $scope.render_sp_status_data = function(nys,ongoing,completed){
    console.log(nys[3]);
    console.log(ongoing[3]);
    console.log(completed);

    // NCDDP
    if(nys[3] == undefined){
      $scope.nys_3 = 0;
    }else{
      $scope.nys_3 = nys[3].length;
    };

    if(ongoing[3] == undefined){
      $scope.ongoing_3 = 0;
    }else{
      $scope.ongoing_3 = ongoing[3].length;
    };

    if(completed[3] == undefined){
      $scope.completed_3 = 0;

    }else{
      $scope.completed_3 = completed[3].length;
    };

    // IPCDD
    if(nys[4] == undefined){
      $scope.nys_4 = 0;

    }else{
      $scope.nys_4 = nys[4].length;
    };

    if(ongoing[4] == undefined){
      $scope.ongoing_4 = 0;

    }else{
      $scope.ongoing_4 = ongoing[4].length;
    };

    if(completed[4] == undefined){
      $scope.completed_4 = 0;

    }else{
      $scope.completed_4 = completed[4].length;

    };

    // CLL
    if(nys[5] == undefined){
      $scope.nys_5 = 0;

    }else{
      $scope.nys_5 = nys[5].length;
    };

    if(ongoing[5] == undefined){
      $scope.ongoing_5 = 0;
    }else{
      $scope.ongoing_5 = ongoing[5].length;
    };

    if(completed[5] == undefined){
      $scope.completed_5 = 0;

    }else{
      $scope.completed_5 = completed[5].length;
    };

    // L&E
    if(nys[6] == undefined){
      $scope.nys_6 = 0;
    }else{
      $scope.nys_6 = nys[6].length;
    };

    if(ongoing[6] == undefined){
      $scope.ongoing_6 = 0;

    }else{
      $scope.ongoing_6 = ongoing[6].length;
    };

    if(completed[6] == undefined){
      $scope.completed_6 = 0;

    }else{
      $scope.completed_6 = completed[6].length;
    };

    //  KKB
    if(nys[1] == undefined){
      $scope.nys_1 = 0;
    }else{
      $scope.nys_1 = nys[1].length;
    };

    if(ongoing[1] == undefined){
      $scope.ongoing_1 = 0;
    }else{
      $scope.nys_1 = ongoing[1].length;
    };

    if(completed[1] == undefined){
      $scope.completed_1 = 0;
    }else{
      $scope.completed_1 = completed[1].length;
    };

    if(nys[2] == undefined){
      $scope.nys_2 = 0;

    }else{
      $scope.nys_2 = nys[2].length;
    };

    if(ongoing[2] == undefined){

      $scope.ongoing_2 = 0;
    }else{
      $scope.nys_2 = ongoing[2].length;
    };

    if(completed[2] == undefined){

      $scope.completed_2 = 0;
    }else{
      $scope.completed_v2 = completed[2].length;
    };

    var ctx = document.getElementById("render_sp_status_data").getContext('2d');
    var myChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: ["NYS","On-going","Completed"],
        datasets: [{
          label: 'NCDDP',
          backgroundColor: "#007bff",
          data: [$scope.nys_3, $scope.ongoing_3, $scope.completed_3],
        }, {
          label: 'IP CDD',
          backgroundColor: "#ec283c",
          data: [$scope.nys_4, $scope.ongoing_4, $scope.completed_4],
        }, {
          label: 'MAKILAHOK',
          backgroundColor: "#28a745",
          data: [$scope.nys_2, $scope.ongoing_2, $scope.completed_2],
        }, {
          label: 'KKB',
          backgroundColor: "#a7c333",
          data: [$scope.nys_1, $scope.ongoing_1, $scope.completed_1],
        }, {
          label: 'L&E',
          backgroundColor: "#6c757d",
          data: [$scope.nys_6, $scope.ongoing_6, $scope.completed_6],
        }, {
          label: 'CCL',
          backgroundColor: "#59e9f8",
          data: [$scope.nys_5, $scope.ongoing_5, $scope.completed_5],
        }],
      },
    options: {
        tooltips: {
          displayColors: true,
          callbacks:{
            mode: 'x',
          },
        },
        scales: {
          xAxes: [{
            stacked: true,
            gridLines: {
              display: false,
            }
          }],
          yAxes: [{
            stacked: true,
            ticks: {
              beginAtZero: true,
            },
            type: 'linear',
          }]
        },
        responsive: true,
        maintainAspectRatio: false,
        legend: { position: 'bottom' },
      }
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
  
  $scope.fetch_modality = function(modality_type,year){
    console.log(modality_type);
    $scope.fetch_dashboard_div = false;
    $scope.fetch_user_div = false;
    $scope.fetch_modality_div = true;

    $scope.modality_type_no = modality_type;
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
      url : 'fetch_modality/'+modality_type+'/'+year,
    }).then(function mySuccess(response) {
        console.log(response.data);
        $scope.sp_per_modality = response.data[0];
        $scope.sp_category = response.data[1];
        $scope.sp_type = response.data[2];
        $scope.dac = response.data[3];
        $scope.rpmo = response.data[4];

        for(var x = 0; x < $scope.sp_per_modality.length; x++){
          $scope.sp_per_modality[x].date_encoded = $scope.parse_date($scope.sp_per_modality[x].date_encoded);
          if($scope.sp_per_modality[x].hasOwnProperty('modality')){
            if($scope.sp_per_modality[x].modality == 'PAMANA'){
              $scope.sp_per_modality[x].whatmodality = 4;
            }
          }else{
              $scope.sp_per_modality[x].whatmodality = 3;
          }
        }

    }, function myError(response) {});
  }

  // $scope.fetch_SP = function(modality){
  //   console.log(modality);
  //   var data = {
  //     modality:modality,
  //   }
  //   $http({
  //     method : "POST",
  //     url : 'routes/fetch_SP',
  //     data: data,
  //   }).then(function mySuccess(response) {
  //       console.log(response.data[3]);
  //       $scope.cmfs_sp = response.data[0];
  //       $scope.sp_category = response.data[1];
  //       $scope.sp_type = response.data[2];
  //       $scope.dac = response.data[3];
  //       $scope.rpmo = response.data[4];

  //       for(var x = 0; x < $scope.cmfs_sp.length; x++){
  //         $scope.cmfs_sp[x].grant = parseFloat($scope.cmfs_sp[x].grant);
  //         $scope.cmfs_sp[x].lcc_cash = parseFloat($scope.cmfs_sp[x].lcc_cash);
  //         $scope.cmfs_sp[x].lcc_in_kind = parseFloat($scope.cmfs_sp[x].lcc_in_kind);
  //       }

  //     }, function myError(response) {});
  // }

  // $scope.new_SP = function(modality){
  //   $http({
  //     method : "GET",
  //     url : 'routes/new_SP',
  //   }).then(function mySuccess(response) {
  //       console.log(response.data);
  //       $scope.sp_category = response.data[0];
  //       $scope.sp_type = response.data[1];
  //       $scope.dac = response.data[2];
  //       $scope.rpmo = response.data[3];
  //     }, function myError(response) {});
  // }

  $scope.Assigned_SP = function(data){
    $scope.cmfs_sp_data = data;
    console.log($scope.cmfs_sp_data);
  }

  $scope.import_to_kce = function(datas){
    $send({
      action : "/admin/routes/import_kce",
      data: datas,
      headers : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      method : "POST",
      func : (res)=>{
        alert(res)
      }
    })
    // $scope.cmfs_sp_data = data;
    // console.log($scope.cmfs_sp_data);
  }

  $scope.encode_SP = function(data){
    $scope.data = data;
    $scope.data.sp_cat_data = $scope.sp_cat_data;
    $scope.data.sp_typ_data = $scope.sp_typ_data;
    $scope.data.assigned_dac = $scope.assigned_dac;
    $scope.data.assigned_rpmo = $scope.assigned_rpmo;
    $scope.data.sp_cyle = $scope.sp_cyle;
    $scope.data.sp_batch = $scope.sp_batch;

    $http({
      method : "POST",
      url : 'encode_SP',
      data: $scope.data,
    }).then(function mySuccess(response) {
      console.log(response.data);

      if(response.data == 1){
        Swal.fire({
          title: 'Yahoooo!',
          text: "SP successfuly encoded",
          icon: 'success',
        });

        $('#encode_new_sp').modal('hide');
        $scope.fetch_modality(3,2020);
      }else{
        Swal.fire({
          title: 'Oooops!',
          text: "There must be a problem",
          icon: 'error',
        });
      }
    }, function myError(response) {});
  }

  $scope.assign_SP = function(data){
    $scope.data = data;
    $scope.data.assigned_dac = document.getElementById('ass_dac').value.replace("number:","");
    console.log("--------------vvvv--------------");
    console.log(data);
    console.log("--------------^^^^^---------------");
    // return;
    $http({
      method : "POST",
      url : 'assign_SP',
      data: $scope.data,
    }).then(function mySuccess(response) {
      console.log(response.data);

      if(response.data == 1){
        Swal.fire({
          title: 'Yahoooo!',
          text: "SP successfuly assigned to a DAC",
          icon: 'success',
        });

        $('#assign_dac_sp').modal('hide');
        $scope.fetch_modality(3,2020);
      }else{
        Swal.fire({
          title: 'Oooops!',
          text: "There must be a problem",
          icon: 'error',
        });
      }
    }, function myError(response) {});
  }

  $scope.fetch_users = function(){
    $scope.fetch_dashboard_div = false;
    $scope.fetch_modality_div = false;
    $scope.fetch_user_div = true;
    
    $http({
      method : "GET",
      url : 'user_list',
    }).then(function mySuccess(response) {
        console.log(response.data);
        $scope.user_list = response.data;

        for(var i = 0; i < $scope.user_list.length; i++){
          $scope.user_list[i].birthdate = $scope.parse_date($scope.user_list[i].birthdate);
          $scope.user_list[i].created_at = $scope.parse_date($scope.user_list[i].created_at);
        }
      }, function myError(response) {});
  }

  $scope.enroll_user = function(data){
    console.log(data);
    var data_data = {
      user_modality: data.user_modality.$modelValue,
      fname: data.fname.$modelValue,
      mname: data.mname.$modelValue,
      lname: data.lname.$modelValue,
      emp_id_no: data.emp_id_no.$modelValue,
      bdate: js_yyyy_mm_dd_hh_mm_ss(data.bdate.$modelValue),
      email: data.email.$modelValue,
      contact: data.contact.$modelValue,
      username: data.username.$modelValue,
      password : data.password.$modelValue,
      user_role: data.user_role.$modelValue,
    }

    console.log(data_data);
    $http({
      method : "POST",
      url : 'enroll_user',
      data: data_data,
    }).then(function mySuccess(response) {
        console.log(response.data);

        if(response.data == 1){
          Swal.fire({
            title: 'Yahoooo!',
            text: "User successfuly enrolled",
            icon: 'success',
          });

          $scope.fetch_users();

          $scope.user_modality = "";
          $scope.fname = "";
          $scope.mname = "";
          $scope.lname = "";
          $scope.emp_id_no = "";
          $scope.bdate = "";
          $scope.email = "";
          $scope.contact = "";
          $scope.username = "";
          $scope.password = "";
          $scope.user_role = "";
          $('#enroll_new_user').modal('hide');

        }else{
          Swal.fire({
            title: 'Oooops!',
            text: "There must be a problem",
            icon: 'error',
          });
        }

      }, function myError(response) {});
  }

$scope.specific_user = function(data){
  $scope.specific_user_data = data;
}

$scope.delete_user = function(user_id){
  Swal.fire({
    title: 'Are you sure?',
    text: "You want to delete this user?",
    icon: 'question',
    showCancelButton: true,
    confirmButtonColor: '#007bff',
    cancelButtonColor: '#dc3545',
    confirmButtonText: 'Yes, delete it!'
  }).then((result) => {
    if (result.value) {

    $http({
    method : "GET",
    url : 'delete_user/'+user_id,
    }).then(function mySuccess(response) {
        if(response.data == 1){
          Swal.fire({
            title: 'Yahoooo!',
            text: "Successfuly deleted a user",
            icon: 'success',
          });
          $scope.fetch_users();
        }else{
          Swal.fire({
            title: 'Oooops!',
            text: "There must be a problem",
            icon: 'error',
          });
        }
    }, function myError(response) {});
    }
  });
}

$scope.assign_add_modality = function(modality,id){
    $http({
    method : "GET",
    url : 'assign_add_modality/'+modality+'/'+id,
    }).then(function mySuccess(response) {
        if(response.data == 1){
          Swal.fire({
            title: 'Yahoooo!',
            text: "Successfuly assigned a modality",
            icon: 'success',
          });
          $scope.fetch_users();

          $('#add_modality').modal('hide');

        }else{
          Swal.fire({
            title: 'Oooops!',
            text: "There must be a problem",
            icon: 'error',
          });
        }
    }, function myError(response) {});
  }
  // for locations
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
                $('#preview').empty();
                Swal.fire(
                  'Yahoo!',
                  'Your file has been uploaded.',
                  'success'
                );

                window.location.href="/"+"admin/routes/files/myfiles";
              }else{
                $('#preview').empty();
                Swal.fire({
                  title: 'Ooopssie!',
                  text: "There some problem! Please contact your IT personnel",
                  icon: 'error',
                });

                window.location.href="/"+"admin/routes/files";
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

  // PLANNED LOGS
  $scope.create_planned_logs = function(data,sp_id,modality,year){
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
            $('#collapseExample'+sp_id).collapse('hide');
            $scope.fetch_modality(modality,year);
          });

        }else{
          Swal.fire({
            title: 'Oooops!',
            text: "There must be a problem",
            icon: 'error',
          }).then(function() {
            $('#collapseExample'+sp_id).collapse('hide');
            $scope.fetch_modality(modality,year);
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

  // PLANNED LOGS
  $scope.delete_sp_plan = function(sp_id,modality,year){

    Swal.fire({
      title: 'Are you sure?',
      text: "You want to delete Plan for this SP with SP ID "+sp_id,
      icon: 'question',
      showCancelButton: true,
      confirmButtonColor: '#007bff',
      cancelButtonColor: '#dc3545',
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.value) {

        $http({
          method : "GET",
          url : 'delete_sp_plan/'+sp_id,
        }).then(function mySuccess(response) {
          if(response.data == 1){
            Swal.fire({
              title: 'Yahoooo!',
              text: "SP Plans successfuly encoded",
              icon: 'success',
            }).then(function() {
              $scope.fetch_modality(modality,year);
            });

          }else{
            Swal.fire({
              title: 'Oooops!',
              text: "There must be a problem",
              icon: 'error',
            }).then(function() {
              $scope.fetch_modality(modality,year);
            });
          }
        }, function myError(response) {
        });

      }else if (result.dismiss === Swal.DismissReason.cancel) {
        Swal.fire({
          title: 'Cancelled',
          text: "Plan not deleted",
          icon: 'error',
        });
      }

    });
  }

  $scope.view_specific_sp_data = function(data){
    console.log("view_specific_sp_data");
    console.log(data);
    $scope.specific_sp_data = data;
  }

  $scope.view_planned_sched = function(data){
    console.log(data.sp.sp_id);
    $scope.specific_sp_data = data;
    $http({
      method : "GET",
      url : 'view_planned_sched/'+data.sp.sp_id,
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
    }, function myError(response) {});
  }

  $scope.chart_planned_sched = function(chart_slippage,chart_planned,chart_actual,chart_labels){
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


  $scope.search_modal = false;
  $scope.fetch_admin_reports = function(){
    $scope.search_modal = false;
    $http({
        method : "GET",
        url : 'fetch_reports_modality',
    }).then(function mySuccess(response) {
        $scope.sp_per_modality_data_all_sp_logs = response.data;
        // REPORTS
        console.log($scope.sp_per_modality_data_all_sp_logs);

    }, function myError(response) {});
  }

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
            $scope.fetch_admin_reports();
      }else{
            $scope.fetch_admin_reports();
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

  // PAGINTION
  $scope.Next_Pagination_Reports = function(url){
    $http({
          method : "GET",
          url : url,
      }).then(function mySuccess(response) {
          $scope.sp_per_modality_data_all_sp_logs = response.data;

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
          $scope.sp_per_modality_data_all_sp_logs = response.data;

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
          $scope.sp_per_modality_data_all_sp_logs = response.data;

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

  $scope.search_data_modal = function(search_status,search_modality,search_year,search_cycle,search_batch,province_data,municipality_data,brgy_data,search_title,search_sp_id){
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

      $http({
          method : "POST",
          url : 'search_data_modal',
          data:datax,
      }).then(function mySuccess(response) {
          $scope.search_modal = true;
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
});