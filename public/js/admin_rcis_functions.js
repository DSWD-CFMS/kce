
var app = angular.module('Admin_RCIS_Function', []);

app.directive('errSrc', function() {
  return {
    link: function(scope, element, attrs) {
      element.bind('error', function() {
        if (attrs.src != attrs.errSrc) {
          attrs.$set('src', attrs.errSrc);
        }
      });
      
      attrs.$observe('ngSrc', function(value) {
        if (!value && attrs.errSrc) {
          attrs.$set('src', attrs.errSrc);
        }
      });
    }
  }
});

app.controller('Admin_RCIS_Controller', function($scope,$http,$filter) {
	console.log('Admin_RCIS_Controller');

	$scope.myDefaultImage = 'https://image.flaticon.com/icons/svg/747/747376.svg';
                
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
    
	$.ajaxSetup({
	    headers: {
	        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	    }
	});

	$scope.mini_navbar = true;

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

	// DASHBOARD
	$scope.show_dashboard = function(){
		$http({
	      method : "GET",
	      url : 'routes/show_dashboard',
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
	    

	    }, function myError(response) {

	    });
	}

	$scope.show_profile = function(){
		$http({
	      method : "GET",
	      url : 'show_profile',
	    }).then(function mySuccess(response) {
	    	// console.log(response.data)
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
            window.location.href="/"+"admin_rcis/routes/profile";
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
          window.location.href="/"+"admin_rcis/routes/profile";
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

	$scope.show_summary = function(){
		$scope.summary_modal = false;
		$http({
	      method : "GET",
	      url : 'show_summary',
	    }).then(function mySuccess(response) {
	    	console.log(response.data);
	    	$scope.target_per_month = response.data[0];
	    	$scope.actual_per_month = response.data[1];
	    	$scope.max_actual = response.data[2];
	    	$scope.Completed_per_grouping = response.data[3];
	    	$scope.Ongoing_per_grouping = response.data[4];
	    	$scope.NYS_per_grouping = response.data[5];
	    	$scope.Chart_Sp_type = response.data[6];
	    	$scope.Chart_Sp_category = response.data[7];
	    	$scope.all_sp = response.data[8];
	    	$scope.Chart_Sp_type_Estimated_Duration = response.data[9];
	    	$scope.Chart_Sp_type_Actual_Duration = response.data[10];

			var value = $scope.actual_per_month;
			function push_sp_type(data){
			  var keys = Object.values(Object.values(data));
			  var yawa = [];
			  yawa.push(keys);

			  return yawa;
			}
			// console.log(push_sp_type($scope.Chart_Sp_type));

			function getKeysWithHighestValue(o, n){
			  var keys = Object.keys(o);
			  keys.sort(function(a,b){
			    return o[b] - o[a];
			  })
			  // console.log(keys);
			  return keys.slice(0,n);
			}

			$scope.month_highest = getKeysWithHighestValue(value, 1);

			$scope.render_charts_sp_type($scope.Chart_Sp_type);
			$scope.render_charts_sp_category($scope.Chart_Sp_category);

			$scope.Render_Chart_Sp_type_Duration($scope.Chart_Sp_type_Estimated_Duration,$scope.Chart_Sp_type_Actual_Duration);
			// $scope.Render_Chart_Sp_type_Duration(push_sp_type($scope.Chart_Sp_type_Estimated_Duration),push_sp_type($scope.Chart_Sp_type_Actual_Duration));

	    }, function myError(response) {

	    });
	}

	// $scope.render_charts_sp_type = function(data){
	// 	// SP type
	// 	console.log(data);

	// 	var ctx = document.getElementById("myChart1");
	// 	var data = {
	// 		labels: ["ROADS", "WATER SYSTEM", "BHS", "PATHWAY", "DRAINAGE", "EVACUATION CENTER", "FOOTBRIDGE", "SEA WALL", "MULTI PURPOSE BUILDING", "TRIBAL CENTER", "EPSL", "CULVERTS", "SPSL", "DCC", "FLOOD CONTROL", "CULVERTS", "LATRINE", "SCHOOL BUILDING", "WHARF", "RIVER DIKE", "RICE MILL", "SLOPE PROTECTION", "STAIRWAY", "BRIDGES", "RIVERBANK PROTECTION", "RWH", "SOLAR DRYER", "LEARNING CENTER", "OTHERS", "PROTECTION DIKE"],
	// 		datasets: [{
	// 		label: 'SP Count per SP Type',
	// 		data: [data[0][0][0],data[0][1][0],data[0][2][0],data[0][3][0],data[0][4][0],data[0][5][0],data[0][6][0],data[0][7][0],data[0][8][0],data[0][9][0],data[0][10][0],data[0][11][0],data[0][12][0],data[0][13][0],data[0][14][0],data[0][15][0],data[0][16][0],data[0][17][0],data[0][18][0],data[0][19][0],data[0][20][0],data[0][21][0],data[0][22][0],data[0][23][0],data[0][24][0],data[0][25][0],data[0][26][0],data[0][27][0],data[0][28][0]],
	// 	    backgroundColor: [
	// 	        '#5d5f61',
	// 	        '#5b80a5',
	// 	        '#7f7aad',
	// 	        '#3a3286',
	// 	        '#9526a9',
	// 	        '#580e65',
	// 	        '#cc1794',
	// 	        '#9d3644',
	// 	        '#c6172f',
	// 	        '#6b0816',
	// 	        '#359f39',
	// 	        '#6ec071',
	// 	        '#70be09',
	// 	        '#e1f919',
	// 	        '#b79a07',
	// 	        '#827639',
	// 	        '#c87c1e',
	// 	        '#78470a',
	// 	        '#e9860b',
	// 	        '#652f08',
	// 	        '#59402e',
	// 	        '#df660e',
	// 	        '#a33105',
	// 	        '#652107',
	// 	        '#ff4c08',
	// 	        '#f9bada',
	// 	        '#9b5666',
	// 	        '#134d76',
	// 	        '#0296ff',
	// 	    ]
	// 	  }]
	// 	}
	// 	var myChart1 = new Chart(ctx, {
	// 	  type: 'bar',
	// 	  data: data,
	// 	  options: {
	// 	    "hover": {
	// 	      "animationDuration": 0
	// 	    },
	// 	    "animation": {
	// 	      "duration": 1,
	// 	      "onComplete": function() {
	// 	        var chartInstance = this.chart,
	// 	          ctx = chartInstance.ctx;

	// 	        ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
		        
	// 	        ctx.textAlign = 'center';
	// 	        ctx.textBaseline = 'bottom';

	// 	        this.data.datasets.forEach(function(dataset, i) {
	// 	          var meta = chartInstance.controller.getDatasetMeta(i);
	// 	          meta.data.forEach(function(bar, index) {
	// 	            var data = dataset.data[index];
	// 	            ctx.fillText(data, bar._model.x, bar._model.y - 10);
	// 	          });
	// 	        });
	// 	      }
	// 	    },

	// 		responsive: true,
	// 	    scales: {
	// 	      xAxes: [{
	// 	        ticks: {
	// 	          // maxRotation: 90,
	// 	          minRotation: 90,
	// 	           fontSize: 9
	// 	        }
	// 	      }],
	// 	      yAxes: [{
	// 	        ticks: {
	// 	          beginAtZero: true
	// 	        }
	// 	      }]
	// 	    },
	// 	  }
	// 	});

	// 	myChart1.update();
	// }

	$scope.Render_Chart_Sp_type_Duration = function(data1,data2){
		// SP type
		console.log("data1");
		console.log(data1);
		console.log($scope.Obj_push_keys(data1));
 		console.log($scope.Obj_push_values(data1));
		console.log("data1");

		console.log("data2");
		console.log(data2);
		console.log($scope.Obj_push_keys(data2));
 		console.log($scope.Obj_push_values(data2));
		console.log("data2");

		var ctx = document.getElementById("ChartSptypeDuration");
		var data = {
			labels: $scope.Obj_push_keys(data1),
			datasets: [
				{
				label: 'Estimated',
				data: $scope.Obj_push_values(data1),
			    backgroundColor: [
			        '#5d5f61',
			        '#5b80a5',
			        '#7f7aad',
			        '#3a3286',
			        '#9526a9',
			        '#580e65',
			        '#cc1794',
			        '#9d3644',
			        '#c6172f',
			        '#6b0816',
			        '#359f39',
			        '#6ec071',
			        '#70be09',
			        '#e1f919',
			        '#b79a07',
			        '#827639',
			        '#c87c1e',
			        '#78470a',
			        '#e9860b',
			        '#652f08',
			        '#59402e',
			        '#df660e',
			        '#a33105',
			        '#652107',
			        '#ff4c08',
			        '#f9bada',
			        '#9b5666',
			        '#134d76',
			        '#0296ff',
			    ]
			  },

			  {
				label: 'Actual',
				data: $scope.Obj_push_values(data2),
			    backgroundColor: [
			        '#454647',
			        '#3c546b',
			        '#5c597d',
			        '#262159',
			        '#731d82',
			        '#3a0942',
			        '#9e1373',
			        '#702731',
			        '#9c1325',
			        '#40050d',
			        '#236b26',
			        '#549457',
			        '#5d9e08',
			        '#c6db16',
			        '#947d06',
			        '#5c5327',
			        '#a16418',
			        '#573307',
			        '#c4710a',
			        '#4f2506',
			        '#422f22',
			        '#c2580c',
			        '#8a2904',
			        '#571c05',
			        '#db4107',
			        '#b0869b',
			        '#824654',
			        '#104163',
			        '#0770ba',
			    ]
			  }
			]
		}
		var myChart1 = new Chart(ctx, {
		  type: 'bar',
		  data: data,
		  options: {
		    "hover": {
		      "animationDuration": 0
		    },
		    "animation": {
		      "duration": 1,
		      "onComplete": function() {
		        var chartInstance = this.chart,
		          ctx = chartInstance.ctx;

		        ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
		        
		        ctx.textAlign = 'center';
		        ctx.textBaseline = 'bottom';

		        this.data.datasets.forEach(function(dataset, i) {
		          var meta = chartInstance.controller.getDatasetMeta(i);
		          meta.data.forEach(function(bar, index) {
		            var data = dataset.data[index];
		            ctx.fillText(data, bar._model.x, bar._model.y - 10);
		          });
		        });
		      }
		    },

			responsive: true,
		    scales: {
		      xAxes: [{
		        ticks: {
		          // maxRotation: 90,
		          minRotation: 90,
		           fontSize: 9
		        }
		      }],
		      yAxes: [{
		        ticks: {
		          beginAtZero: true
		        }
		      }]
		    },
		  }
		});

		myChart1.update();
	}

	$scope.export_to_pdf = function(){
		$("#exportthis").printThis({
		    debug: false,               // show the iframe for debugging
		    importCSS: true,            // import parent page css
		    importStyle: true,         // import style tags
		    printContainer: true,       // print outer container/$.selector
		    loadCSS: '/rcis_styles/css/style.css',                // path to additional css file - use an array [] for multiple
		    pageTitle: "",              // add title to print page
		    removeInline: false,        // remove inline styles from print elements
		    removeInlineSelector: "*",  // custom selectors to filter inline styles. removeInline must be true
		    printDelay: 1000,            // variable print delay
		    header: null,               // prefix to html
		    footer: null,               // postfix to html
		    base: false,                // preserve the BASE tag or accept a string for the URL
		    formValues: true,           // preserve input/form values
		    canvas: true,              // copy canvas content
		    doctypeString: '',       // enter a different doctype for older markup
		    removeScripts: false,       // remove script tags from print content
		    copyTagClasses: false,      // copy classes from the html & body tag
		    beforePrintEvent: null,     // function for printEvent in iframe
		    beforePrint: null,          // function called before iframe is filled
		    afterPrint: null            // function called before iframe is removed
		});

    }

	$scope.summary_modal = false;
	$scope.show_modal_summary = function(search_modality,search_cadt,search_year,search_cycle,search_batch,province_data,municipality_data,brgy_data,search_title,search_sp_id){
		console.log('Search SP MODAL');
	    var datax = {
	        search_modality:search_modality,
	        search_cadt:search_cadt,
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
	        url : 'show_modal_summary',
	        data: datax,
	    }).then(function mySuccess(response) {
	        console.log(response.data);
	        $scope.summary_modal = true;

	    	$scope.target_per_month = response.data[0];
	    	$scope.actual_per_month = response.data[1];

	    	$scope.max_actual = response.data[2];
	    	$scope.Completed_per_grouping = response.data[3];
	    	$scope.Ongoing_per_grouping = response.data[4];
	    	$scope.NYS_per_grouping = response.data[5];
	    	$scope.Chart_Sp_type = response.data[6];
	    	$scope.Chart_Sp_category = response.data[7];
	    	$scope.all_sp = response.data[8];
	    	$scope.Chart_Sp_type_Estimated_Duration = response.data[9];
	    	$scope.Chart_Sp_type_Actual_Duration = response.data[10];

			var value = $scope.actual_per_month;
			function push_sp_type(data){
			  var keys = Object.values(Object.values(data));
			  var yawa = [];
			  yawa.push(keys);

			  return yawa;
			}

			function sasa(data){
			  var keys = Object.keys(data);
			  var yawa = [];	
			  yawa.push(keys);

			  return yawa;
			}

			function getKeysWithHighestValue(o, n){
			  var keys = Object.keys(o);
			  keys.sort(function(a,b){
			    return o[b] - o[a];
			  })
			  // console.log(keys);
			  return keys.slice(0,n);
			}
			$scope.month_highest = getKeysWithHighestValue(value, 1);

			$scope.render_charts_sp_type_summary_modal(push_sp_type($scope.Chart_Sp_type),sasa($scope.Chart_Sp_type));
			$scope.render_charts_sp_category_summary_modal(push_sp_type($scope.Chart_Sp_category),sasa($scope.Chart_Sp_category));
			$scope.render_chart_sp_type_duration_summary_modal($scope.Chart_Sp_type_Estimated_Duration,$scope.Chart_Sp_type_Actual_Duration,$scope.Chart_Sp_type_Estimated_Duration);
	    }, function myError(response) {
	      
	    });
	}

	$scope.render_charts_sp_type_summary_modal = function(data,keys){
		// SP type
		var yawa1 = [];
		var yawa2 = [];
		var yawa3 = [];

		var dynamicColors = function() {
			var r = Math.floor(Math.random() * 255);
			var g = Math.floor(Math.random() * 255);
			var b = Math.floor(Math.random() * 255);
			return "rgb(" + r + "," + g + "," + b + ")";
		};

		for(var x = 0; x < data.length; x++){
			for(var i = 0; i < data[x].length; i++){
			  yawa1.push(data[x][i][0]);
			  yawa3.push(dynamicColors());
			}
		}

		for(var x = 0; x < keys.length; x++){
			yawa2.push(keys[x]);
		}

		var ctx = document.getElementById("myChart1_type");
		var data = {
			labels: yawa2[0],
			datasets: [{
			label: 'SP Count per SP Type',
			data: yawa1,
			backgroundColor: yawa3,
		  }]
		}
		var myChart1 = new Chart(ctx, {
		  type: 'bar',
		  data: data,
		  options: {
		    "hover": {
		      "animationDuration": 0
		    },
			responsive: true,
		    scales: {
		      xAxes: [{
		        ticks: {
		          minRotation: 90,
		           fontSize: 9,
		        }
		      }],
		      yAxes: [{
				ticks: {
				    beginAtZero: true,
				    callback: function(value, index, values) {
				        if (Math.floor(value) === value) {
				            return value;
				        }
				    }
				}
		      }]
		    },
		  }
		});

		myChart1.update();
	}

	$scope.render_charts_sp_category_summary_modal = function(data,keys){
		// SP category
		console.log(data);
		console.log(keys);

		var yawa1 = [];
		var yawa2 = [];
		for(var x = 0; x < data.length; x++){
			for(var i = 0; i < data[x].length; i++){
			  yawa1.push(data[x][i][0]);
			}
		}

		for(var x = 0; x < keys.length; x++){
			yawa2.push(keys[x]);
		}

		var oilCanvas = document.getElementById("myChart2_category");
		Chart.defaults.global.defaultFontSize = 9;

		var oilData = {
		    labels: yawa2[0],
		    datasets: [
		        {
		            data: yawa1,
		            backgroundColor: [
		                "#44a0a9",
		                "#18b53a",
		                "#ff9e0d",
		                "#923408",
		            ],
	                options: {
				        responsive: true,
				        legend: {
				            position: 'top',
				        },
				        title: {
				            display: true,
				            text: 'Chart.js Doughnut Chart'
				        },
				        animation: {
				            animateScale: true,
				            animateRotate: true
				        }
				    }
		        }]
		};

		Chart.pluginService.register({
		    beforeRender: function (chart) {
		        if (chart.config.options.showAllTooltips) {
		            // create an array of tooltips
		            // we can't use the chart tooltip because there is only one tooltip per chart
		            chart.pluginTooltips = [];
		            chart.config.data.datasets.forEach(function (dataset, i) {
		                chart.getDatasetMeta(i).data.forEach(function (sector, j) {
		                    chart.pluginTooltips.push(new Chart.Tooltip({
		                        _chart: chart.chart,
		                        _chartInstance: chart,
		                        _data: chart.data,
		                        _options: chart.options.tooltips,
		                        _active: [sector]
		                    }, chart));
		                });
		            });

		            // turn off normal tooltips
		            chart.options.tooltips.enabled = false;
		        }
		    },
		    afterDraw: function (chart, easing) {
		        if (chart.config.options.showAllTooltips) {
		            // we don't want the permanent tooltips to animate, so don't do anything till the animation runs atleast once
		            if (!chart.allTooltipsOnce) {
		                if (easing !== 1)
		                    return;
		                chart.allTooltipsOnce = true;
		            }

		            // turn on tooltips
		            chart.options.tooltips.enabled = true;
		            Chart.helpers.each(chart.pluginTooltips, function (tooltip) {
		                tooltip.initialize();
		                tooltip.update();
		                // we don't actually need this since we are not animating tooltips
		                tooltip.pivot();
		                tooltip.transition(easing).draw();
		            });
		            chart.options.tooltips.enabled = false;
		        }
		    }
		});

		var pieChart = new Chart(oilCanvas, {
		  type: 'doughnut',
		  data: oilData,
			options: {
			    showAllTooltips: true,
				rotation: 1 * Math.PI,
				circumference: 1 * Math.PI,
				tooltips: {
					yAlign: 'bottom',
					yPadding: 10,
					backgroundColor: '#fbfbfb08',
					bodyFontColor: '#000000',
				}
			}
		});

		pieChart.update();

	}

	$scope.render_chart_sp_type_duration_summary_modal = function(data1,data2,data_lables){
		// SP type
		$scope.label_shit = Object.getOwnPropertyNames(data_lables);
		$scope.data1_shit = Object.values(data1);
		$scope.data2_shit = Object.values(data2);
		// console.log(data1.$scope.label_shit[0]);
		console.log($scope.label_shit);
		console.log($scope.data1_shit);
		console.log($scope.data2_shit);

		var ctx = document.getElementById("ChartSptypeDuration_summary");
		var data = {
			labels: $scope.label_shit,
			datasets: [
				{
				label: 'Estimated',
				data: $scope.data1_shit,
			    backgroundColor: [
			        '#5d5f61',
			        '#5b80a5',
			        '#7f7aad',
			        '#3a3286',
			        '#9526a9',
			        '#580e65',
			        '#cc1794',
			        '#9d3644',
			        '#c6172f',
			        '#6b0816',
			        '#359f39',
			        '#6ec071',
			        '#70be09',
			        '#e1f919',
			        '#b79a07',
			        '#827639',
			        '#c87c1e',
			        '#78470a',
			        '#e9860b',
			        '#652f08',
			        '#59402e',
			        '#df660e',
			        '#a33105',
			        '#652107',
			        '#ff4c08',
			        '#f9bada',
			        '#9b5666',
			        '#134d76',
			        '#0296ff',
			    ]
			  },

			  {
				label: 'Actual',
				data: $scope.data2_shit,
			    backgroundColor: [
			        '#454647',
			        '#3c546b',
			        '#5c597d',
			        '#262159',
			        '#731d82',
			        '#3a0942',
			        '#9e1373',
			        '#702731',
			        '#9c1325',
			        '#40050d',
			        '#236b26',
			        '#549457',
			        '#5d9e08',
			        '#c6db16',
			        '#947d06',
			        '#5c5327',
			        '#a16418',
			        '#573307',
			        '#c4710a',
			        '#4f2506',
			        '#422f22',
			        '#c2580c',
			        '#8a2904',
			        '#571c05',
			        '#db4107',
			        '#b0869b',
			        '#824654',
			        '#104163',
			        '#0770ba',
			    ]
			  }
			]
		}
		var myChart1 = new Chart(ctx, {
		  type: 'bar',
		  data: data,
		  options: {
		    "hover": {
		      "animationDuration": 0
		    },
		    "animation": {
		      "duration": 1,
		      "onComplete": function() {
		        var chartInstance = this.chart,
		          ctx = chartInstance.ctx;

		        ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
		        
		        ctx.textAlign = 'center';
		        ctx.textBaseline = 'bottom';

		        this.data.datasets.forEach(function(dataset, i) {
		          var meta = chartInstance.controller.getDatasetMeta(i);
		          meta.data.forEach(function(bar, index) {
		            var data = dataset.data[index];
		            ctx.fillText(data, bar._model.x, bar._model.y - 10);
		          });
		        });
		      }
		    },

			responsive: true,
		    scales: {
		      xAxes: [{
		        ticks: {
		          // maxRotation: 90,
		          minRotation: 90,
		           fontSize: 9
		        }
		      }],
		      yAxes: [{
		        ticks: {
		          beginAtZero: true
		        }
		      }]
		    },
		  }
		});

		myChart1.update();
	}


	var delayTimer;
	$scope.search_sp = function(params){
		if(params == ''){
			$scope.render_modalities_and_sp();
		}else{
		    clearTimeout(delayTimer);
		    delayTimer = setTimeout(function() {
				$scope.search_modal = true;
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
			        $scope.sp_per_modality_data_all_sp_logs = response.data[0];
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

			        $scope.search_modal_sp_for_export = response.data[1];
			        for(x = 0; x < $scope.search_modal_sp_for_export.length; x++){
			          $scope.search_modal_sp_for_export[x].sp[0].sp_rfr_first_tranche_date = $scope.parse_date($scope.search_modal_sp_for_export[x].sp[0].sp_rfr_first_tranche_date);
			          $scope.search_modal_sp_for_export[x].sp[0].sp_date_started = $scope.parse_date($scope.search_modal_sp_for_export[x].sp[0].sp_date_started);
			          $scope.search_modal_sp_for_export[x].sp[0].sp_date_of_turnover = $scope.parse_date($scope.search_modal_sp_for_export[x].sp[0].sp_date_of_turnover);
			          $scope.search_modal_sp_for_export[x].sp[0].sp_target_date_of_completion = $scope.parse_date($scope.search_modal_sp_for_export[x].sp[0].sp_target_date_of_completion);
			          $scope.search_modal_sp_for_export[x].sp[0].sp_actual_date_completed = $scope.parse_date($scope.search_modal_sp_for_export[x].sp[0].sp_actual_date_completed);

			          for(y = 0; y < $scope.search_modal_sp_for_export[x].sp[0].sp_logs.length; y++){
			            $scope.search_modal_sp_for_export[x].sp[0].sp_logs[y].updated_at = $scope.parse_date($scope.search_modal_sp_for_export[x].sp[0].sp_logs[y].updated_at);
			          }
			        }

			    }, function myError(response) {
			      
			    });
		    }, 1000); // Will do the ajax stuff after 1000 ms, or 1 s
		}
	}

	$scope.search_modal = false;
	$scope.search_data_modal = function(search_status,search_modality,search_year,search_cycle,search_batch,province_data,municipality_data,brgy_data,search_title,search_sp_id){
		console.log('Search SP MODAL');
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

	    console.log(datax);
	    $http({
	        method : "POST",
	        url : 'search_data_modal',
	        data: datax,
	    }).then(function mySuccess(response) {
	        console.log(response.data);
	        $scope.sp_per_modality_data_all_sp_logs = response.data[0];
	        $scope.search_modal = true;

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

	        $scope.search_modal_sp_for_export = response.data[1];

	        for(x = 0; x < $scope.search_modal_sp_for_export.length; x++){
	          $scope.search_modal_sp_for_export[x].sp[0].sp_rfr_first_tranche_date = $scope.parse_date($scope.search_modal_sp_for_export[x].sp[0].sp_rfr_first_tranche_date);
	          $scope.search_modal_sp_for_export[x].sp[0].sp_date_started = $scope.parse_date($scope.search_modal_sp_for_export[x].sp[0].sp_date_started);
	          $scope.search_modal_sp_for_export[x].sp[0].sp_date_of_turnover = $scope.parse_date($scope.search_modal_sp_for_export[x].sp[0].sp_date_of_turnover);
	          $scope.search_modal_sp_for_export[x].sp[0].sp_target_date_of_completion = $scope.parse_date($scope.search_modal_sp_for_export[x].sp[0].sp_target_date_of_completion);
	          $scope.search_modal_sp_for_export[x].sp[0].sp_actual_date_completed = $scope.parse_date($scope.search_modal_sp_for_export[x].sp[0].sp_actual_date_completed);

	          for(y = 0; y < $scope.search_modal_sp_for_export[x].sp[0].sp_logs.length; y++){
	            $scope.search_modal_sp_for_export[x].sp[0].sp_logs[y].updated_at = $scope.parse_date($scope.search_modal_sp_for_export[x].sp[0].sp_logs[y].updated_at);
	          }
	        }

			var value = $scope.actual_per_month;
			function push_sp_type(data){
			  var keys = Object.values(Object.values(data));
			  var yawa = [];
			  yawa.push(keys);

			  return yawa;
			}
			// console.log(push_sp_type($scope.Chart_Sp_type));

			function getKeysWithHighestValue(o, n){
			  var keys = Object.keys(o);
			  keys.sort(function(a,b){
			    return o[b] - o[a];
			  })
			  // console.log(keys);
			  return keys.slice(0,n);
			}

			$scope.month_highest = getKeysWithHighestValue(value, 1);

			$scope.render_charts_sp_type($scope.Chart_Sp_type);
			$scope.render_charts_sp_category($scope.Chart_Sp_category);

			$scope.Render_Chart_Sp_type_Duration($scope.Chart_Sp_type_Estimated_Duration,$scope.Chart_Sp_type_Actual_Duration);
			// $scope.Render_Chart_Sp_type_Duration(push_sp_type($scope.Chart_Sp_type_Estimated_Duration),push_sp_type($scope.Chart_Sp_type_Actual_Duration));

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
		// $scope.dashboard_div = false;
		// $scope.summary_div = false;
		// $scope.modality_div = true;
		// $scope.downloadables_div = false;
		// $scope.profile_div = false;
		
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

	$scope.planned_sched_div = false;
	$scope.render_specific_sp = function(data){
		console.log(data);
		$scope.specific_sp_data = data;

	    // BUB
	    if($scope.specific_sp_data.c_m_f_s_kalahi_2015__b_u_b__s_p != null){
	      $scope.paramObj = {
	        grant: $scope.specific_sp_data.c_m_f_s_kalahi_2015__b_u_b__s_p.grant,
	        contigency: $scope.specific_sp_data.c_m_f_s_kalahi_2015__b_u_b__s_p.contigency,
	        other_amount: $scope.specific_sp_data.c_m_f_s_kalahi_2015__b_u_b__s_p.other_amount,
	        lcc_community: $scope.specific_sp_data.c_m_f_s_kalahi_2015__b_u_b__s_p.lcc_community,
	        lcc_community_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2015__b_u_b__s_p.lcc_community_ik,
	        lcc_blgu: $scope.specific_sp_data.c_m_f_s_kalahi_2015__b_u_b__s_p.lcc_blgu,
	        lcc_blgu_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2015__b_u_b__s_p.lcc_blgu_ik,
	        lcc_mlgu: $scope.specific_sp_data.c_m_f_s_kalahi_2015__b_u_b__s_p.lcc_mlgu,
	        lcc_mlgu_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2015__b_u_b__s_p.lcc_mlgu_ik,
	        lcc_plgu: $scope.specific_sp_data.c_m_f_s_kalahi_2015__b_u_b__s_p.lcc_plgu,
	        lcc_plgu_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2015__b_u_b__s_p.lcc_plgu_ik,
	        lcc_others: $scope.specific_sp_data.c_m_f_s_kalahi_2015__b_u_b__s_p.lcc_others,
	        lcc_others_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2015__b_u_b__s_p.lcc_others_ik,
	        lcc_cash: $scope.specific_sp_data.c_m_f_s_kalahi_2015__b_u_b__s_p.lcc_cash,
	        lcc_in_kind: $scope.specific_sp_data.c_m_f_s_kalahi_2015__b_u_b__s_p.lcc_in_kind,
	      }
	      $scope.total_project_cost = $scope.get_total_project_cost($scope.paramObj); 
	    
	    }else if($scope.specific_sp_data.c_m_f_s_kalahi_2016__b_u_b__s_p != null){
	      $scope.paramObj = {
	        grant: $scope.specific_sp_data.c_m_f_s_kalahi_2016__b_u_b__s_p.grant,
	        contigency: $scope.specific_sp_data.c_m_f_s_kalahi_2016__b_u_b__s_p.contigency,
	        other_amount: $scope.specific_sp_data.c_m_f_s_kalahi_2016__b_u_b__s_p.other_amount,
	        lcc_community: $scope.specific_sp_data.c_m_f_s_kalahi_2016__b_u_b__s_p.lcc_community,
	        lcc_community_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2016__b_u_b__s_p.lcc_community_ik,
	        lcc_blgu: $scope.specific_sp_data.c_m_f_s_kalahi_2016__b_u_b__s_p.lcc_blgu,
	        lcc_blgu_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2016__b_u_b__s_p.lcc_blgu_ik,
	        lcc_mlgu: $scope.specific_sp_data.c_m_f_s_kalahi_2016__b_u_b__s_p.lcc_mlgu,
	        lcc_mlgu_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2016__b_u_b__s_p.lcc_mlgu_ik,
	        lcc_plgu: $scope.specific_sp_data.c_m_f_s_kalahi_2016__b_u_b__s_p.lcc_plgu,
	        lcc_plgu_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2016__b_u_b__s_p.lcc_plgu_ik,
	        lcc_others: $scope.specific_sp_data.c_m_f_s_kalahi_2016__b_u_b__s_p.lcc_others,
	        lcc_others_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2016__b_u_b__s_p.lcc_others_ik,
	        lcc_cash: $scope.specific_sp_data.c_m_f_s_kalahi_2016__b_u_b__s_p.lcc_cash,
	        lcc_in_kind: $scope.specific_sp_data.c_m_f_s_kalahi_2016__b_u_b__s_p.lcc_in_kind,
	      }
	      $scope.total_project_cost = $scope.get_total_project_cost($scope.paramObj); 
	    
	    }else if($scope.specific_sp_data.c_m_f_s_kalahi_2017__b_u_b__s_p != null){
	      $scope.paramObj = {
	        grant: $scope.specific_sp_data.c_m_f_s_kalahi_2017__b_u_b__s_p.grant,
	        contigency: $scope.specific_sp_data.c_m_f_s_kalahi_2017__b_u_b__s_p.contigency,
	        other_amount: $scope.specific_sp_data.c_m_f_s_kalahi_2017__b_u_b__s_p.other_amount,
	        lcc_community: $scope.specific_sp_data.c_m_f_s_kalahi_2017__b_u_b__s_p.lcc_community,
	        lcc_community_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2017__b_u_b__s_p.lcc_community_ik,
	        lcc_blgu: $scope.specific_sp_data.c_m_f_s_kalahi_2017__b_u_b__s_p.lcc_blgu,
	        lcc_blgu_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2017__b_u_b__s_p.lcc_blgu_ik,
	        lcc_mlgu: $scope.specific_sp_data.c_m_f_s_kalahi_2017__b_u_b__s_p.lcc_mlgu,
	        lcc_mlgu_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2017__b_u_b__s_p.lcc_mlgu_ik,
	        lcc_plgu: $scope.specific_sp_data.c_m_f_s_kalahi_2017__b_u_b__s_p.lcc_plgu,
	        lcc_plgu_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2017__b_u_b__s_p.lcc_plgu_ik,
	        lcc_others: $scope.specific_sp_data.c_m_f_s_kalahi_2017__b_u_b__s_p.lcc_others,
	        lcc_others_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2017__b_u_b__s_p.lcc_others_ik,
	        lcc_cash: $scope.specific_sp_data.c_m_f_s_kalahi_2017__b_u_b__s_p.lcc_cash,
	        lcc_in_kind: $scope.specific_sp_data.c_m_f_s_kalahi_2017__b_u_b__s_p.lcc_in_kind,
	      }
	      $scope.total_project_cost = $scope.get_total_project_cost($scope.paramObj); 

	    }else if($scope.specific_sp_data.c_m_f_s_kalahi_2018__b_u_b__s_p != null){
	      $scope.paramObj = {
	        grant: $scope.specific_sp_data.c_m_f_s_kalahi_2018__b_u_b__s_p.grant,
	        contigency: $scope.specific_sp_data.c_m_f_s_kalahi_2018__b_u_b__s_p.contigency,
	        other_amount: $scope.specific_sp_data.c_m_f_s_kalahi_2018__b_u_b__s_p.other_amount,
	        lcc_community: $scope.specific_sp_data.c_m_f_s_kalahi_2018__b_u_b__s_p.lcc_community,
	        lcc_community_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2018__b_u_b__s_p.lcc_community_ik,
	        lcc_blgu: $scope.specific_sp_data.c_m_f_s_kalahi_2018__b_u_b__s_p.lcc_blgu,
	        lcc_blgu_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2018__b_u_b__s_p.lcc_blgu_ik,
	        lcc_mlgu: $scope.specific_sp_data.c_m_f_s_kalahi_2018__b_u_b__s_p.lcc_mlgu,
	        lcc_mlgu_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2018__b_u_b__s_p.lcc_mlgu_ik,
	        lcc_plgu: $scope.specific_sp_data.c_m_f_s_kalahi_2018__b_u_b__s_p.lcc_plgu,
	        lcc_plgu_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2018__b_u_b__s_p.lcc_plgu_ik,
	        lcc_others: $scope.specific_sp_data.c_m_f_s_kalahi_2018__b_u_b__s_p.lcc_others,
	        lcc_others_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2018__b_u_b__s_p.lcc_others_ik,
	        lcc_cash: $scope.specific_sp_data.c_m_f_s_kalahi_2018__b_u_b__s_p.lcc_cash,
	        lcc_in_kind: $scope.specific_sp_data.c_m_f_s_kalahi_2018__b_u_b__s_p.lcc_in_kind,
	      }
	      $scope.total_project_cost = $scope.get_total_project_cost($scope.paramObj); 
	    
	    }else if($scope.specific_sp_data.c_m_f_s_kalahi_2020__b_u_b__s_p != null){
	      $scope.paramObj = {
	        grant: $scope.specific_sp_data.c_m_f_s_kalahi_2020__b_u_b__s_p.grant,
	        contigency: $scope.specific_sp_data.c_m_f_s_kalahi_2020__b_u_b__s_p.contigency,
	        other_amount: $scope.specific_sp_data.c_m_f_s_kalahi_2020__b_u_b__s_p.other_amount,
	        lcc_community: $scope.specific_sp_data.c_m_f_s_kalahi_2020__b_u_b__s_p.lcc_community,
	        lcc_community_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2020__b_u_b__s_p.lcc_community_ik,
	        lcc_blgu: $scope.specific_sp_data.c_m_f_s_kalahi_2020__b_u_b__s_p.lcc_blgu,
	        lcc_blgu_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2020__b_u_b__s_p.lcc_blgu_ik,
	        lcc_mlgu: $scope.specific_sp_data.c_m_f_s_kalahi_2020__b_u_b__s_p.lcc_mlgu,
	        lcc_mlgu_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2020__b_u_b__s_p.lcc_mlgu_ik,
	        lcc_plgu: $scope.specific_sp_data.c_m_f_s_kalahi_2020__b_u_b__s_p.lcc_plgu,
	        lcc_plgu_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2020__b_u_b__s_p.lcc_plgu_ik,
	        lcc_others: $scope.specific_sp_data.c_m_f_s_kalahi_2020__b_u_b__s_p.lcc_others,
	        lcc_others_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2020__b_u_b__s_p.lcc_others_ik,
	        lcc_cash: $scope.specific_sp_data.c_m_f_s_kalahi_2020__b_u_b__s_p.lcc_cash,
	        lcc_in_kind: $scope.specific_sp_data.c_m_f_s_kalahi_2020__b_u_b__s_p.lcc_in_kind,
	      }
	      $scope.total_project_cost = $scope.get_total_project_cost($scope.paramObj); 

	    }else;

	    // NCDDP

	    if($scope.specific_sp_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p != null){
	      $scope.paramObj = {
	        grant: $scope.specific_sp_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p.grant,
	        contigency: $scope.specific_sp_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p.contigency,
	        other_amount: $scope.specific_sp_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p.other_amount,
	        lcc_community: $scope.specific_sp_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p.lcc_community,
	        lcc_community_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p.lcc_community_ik,
	        lcc_blgu: $scope.specific_sp_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p.lcc_blgu,
	        lcc_blgu_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p.lcc_blgu_ik,
	        lcc_mlgu: $scope.specific_sp_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p.lcc_mlgu,
	        lcc_mlgu_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p.lcc_mlgu_ik,
	        lcc_plgu: $scope.specific_sp_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p.lcc_plgu,
	        lcc_plgu_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p.lcc_plgu_ik,
	        lcc_others: $scope.specific_sp_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p.lcc_others,
	        lcc_others_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p.lcc_others_ik,
	        lcc_cash: $scope.specific_sp_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p.lcc_cash,
	        lcc_in_kind: $scope.specific_sp_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p.lcc_in_kind,
	      }
	      $scope.total_project_cost = $scope.get_total_project_cost($scope.paramObj); 
	    
	    }else if($scope.specific_sp_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p != null){
	      $scope.paramObj = {
	        grant: $scope.specific_sp_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p.grant,
	        contigency: $scope.specific_sp_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p.contigency,
	        other_amount: $scope.specific_sp_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p.other_amount,
	        lcc_community: $scope.specific_sp_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p.lcc_community,
	        lcc_community_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p.lcc_community_ik,
	        lcc_blgu: $scope.specific_sp_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p.lcc_blgu,
	        lcc_blgu_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p.lcc_blgu_ik,
	        lcc_mlgu: $scope.specific_sp_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p.lcc_mlgu,
	        lcc_mlgu_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p.lcc_mlgu_ik,
	        lcc_plgu: $scope.specific_sp_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p.lcc_plgu,
	        lcc_plgu_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p.lcc_plgu_ik,
	        lcc_others: $scope.specific_sp_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p.lcc_others,
	        lcc_others_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p.lcc_others_ik,
	        lcc_cash: $scope.specific_sp_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p.lcc_cash,
	        lcc_in_kind: $scope.specific_sp_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p.lcc_in_kind,
	      }
	      $scope.total_project_cost = $scope.get_total_project_cost($scope.paramObj); 
	    
	    }else if($scope.specific_sp_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p != null){
	      $scope.paramObj = {
	        grant: $scope.specific_sp_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p.grant,
	        contigency: $scope.specific_sp_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p.contigency,
	        other_amount: $scope.specific_sp_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p.other_amount,
	        lcc_community: $scope.specific_sp_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p.lcc_community,
	        lcc_community_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p.lcc_community_ik,
	        lcc_blgu: $scope.specific_sp_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p.lcc_blgu,
	        lcc_blgu_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p.lcc_blgu_ik,
	        lcc_mlgu: $scope.specific_sp_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p.lcc_mlgu,
	        lcc_mlgu_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p.lcc_mlgu_ik,
	        lcc_plgu: $scope.specific_sp_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p.lcc_plgu,
	        lcc_plgu_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p.lcc_plgu_ik,
	        lcc_others: $scope.specific_sp_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p.lcc_others,
	        lcc_others_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p.lcc_others_ik,
	        lcc_cash: $scope.specific_sp_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p.lcc_cash,
	        lcc_in_kind: $scope.specific_sp_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p.lcc_in_kind,
	      }
	      $scope.total_project_cost = $scope.get_total_project_cost($scope.paramObj); 

	    }else if($scope.specific_sp_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p != null){
	      $scope.paramObj = {
	        grant: $scope.specific_sp_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p.grant,
	        contigency: $scope.specific_sp_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p.contigency,
	        other_amount: $scope.specific_sp_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p.other_amount,
	        lcc_community: $scope.specific_sp_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p.lcc_community,
	        lcc_community_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p.lcc_community_ik,
	        lcc_blgu: $scope.specific_sp_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p.lcc_blgu,
	        lcc_blgu_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p.lcc_blgu_ik,
	        lcc_mlgu: $scope.specific_sp_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p.lcc_mlgu,
	        lcc_mlgu_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p.lcc_mlgu_ik,
	        lcc_plgu: $scope.specific_sp_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p.lcc_plgu,
	        lcc_plgu_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p.lcc_plgu_ik,
	        lcc_others: $scope.specific_sp_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p.lcc_others,
	        lcc_others_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p.lcc_others_ik,
	        lcc_cash: $scope.specific_sp_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p.lcc_cash,
	        lcc_in_kind: $scope.specific_sp_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p.lcc_in_kind,
	      }
	      $scope.total_project_cost = $scope.get_total_project_cost($scope.paramObj); 
	    
	    }else if($scope.specific_sp_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p != null){
	      $scope.paramObj = {
	        grant: $scope.specific_sp_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p.grant,
	        contigency: $scope.specific_sp_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p.contigency,
	        other_amount: $scope.specific_sp_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p.other_amount,
	        lcc_community: $scope.specific_sp_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p.lcc_community,
	        lcc_community_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p.lcc_community_ik,
	        lcc_blgu: $scope.specific_sp_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p.lcc_blgu,
	        lcc_blgu_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p.lcc_blgu_ik,
	        lcc_mlgu: $scope.specific_sp_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p.lcc_mlgu,
	        lcc_mlgu_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p.lcc_mlgu_ik,
	        lcc_plgu: $scope.specific_sp_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p.lcc_plgu,
	        lcc_plgu_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p.lcc_plgu_ik,
	        lcc_others: $scope.specific_sp_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p.lcc_others,
	        lcc_others_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p.lcc_others_ik,
	        lcc_cash: $scope.specific_sp_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p.lcc_cash,
	        lcc_in_kind: $scope.specific_sp_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p.lcc_in_kind,
	      }
	      $scope.total_project_cost = $scope.get_total_project_cost($scope.paramObj); 
	    
	    }else if($scope.specific_sp_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p != null){
	      $scope.paramObj = {
	        grant: $scope.specific_sp_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p.grant,
	        contigency: $scope.specific_sp_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p.contigency,
	        other_amount: $scope.specific_sp_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p.other_amount,
	        lcc_community: $scope.specific_sp_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p.lcc_community,
	        lcc_community_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p.lcc_community_ik,
	        lcc_blgu: $scope.specific_sp_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p.lcc_blgu,
	        lcc_blgu_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p.lcc_blgu_ik,
	        lcc_mlgu: $scope.specific_sp_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p.lcc_mlgu,
	        lcc_mlgu_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p.lcc_mlgu_ik,
	        lcc_plgu: $scope.specific_sp_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p.lcc_plgu,
	        lcc_plgu_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p.lcc_plgu_ik,
	        lcc_others: $scope.specific_sp_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p.lcc_others,
	        lcc_others_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p.lcc_others_ik,
	        lcc_cash: $scope.specific_sp_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p.lcc_cash,
	        lcc_in_kind: $scope.specific_sp_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p.lcc_in_kind,
	      }
	      $scope.total_project_cost = $scope.get_total_project_cost($scope.paramObj); 
	    
	    }else;

		console.log($scope.specific_sp_data.sp_actual_date_completed);
		// for(x = 0; x < $scope.specific_sp_data.data.length; x++){
          $scope.specific_sp_data.sp_rfr_first_tranche_date = $scope.parse_date($scope.specific_sp_data.sp_rfr_first_tranche_date);
          $scope.specific_sp_data.sp_date_started = $scope.parse_date($scope.specific_sp_data.sp_date_started);
          $scope.specific_sp_data.sp_date_of_turnover = $scope.parse_date($scope.specific_sp_data.sp_date_of_turnover);
          $scope.specific_sp_data.sp_target_date_of_completion = $scope.parse_date($scope.specific_sp_data.sp_target_date_of_completion);
          $scope.specific_sp_data.sp_actual_date_completed = $scope.parse_date($scope.specific_sp_data.sp_actual_date_completed);

          for(y = 0; y < $scope.specific_sp_data.sp_logs.length; y++){
            $scope.specific_sp_data.sp_logs[y].updated_at = $scope.parse_date($scope.specific_sp_data.sp_logs[y].updated_at);
          }
        // }
	}
	
	$scope.back_to_render_specific_sp = function(){
		$scope.planned_sched_div = false;
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
	var myChart = new Chart(ctx, config);
	removeData(myChart);
	updateConfigAsNewObject(myChart);
	myChart.update();

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

	function removeData(chart) {
	    chart.data.labels.pop();
	    chart.data.datasets.forEach((dataset) => {
	        dataset.data.pop();
	    });
	    chart.update();
	}
	}
	$scope.verifier = [];
	$scope.fetch_all_for_export = function(){
	    $http({
	        method : "GET",
	        url : 'fetch_all_for_export',
	    }).then(function mySuccess(response) {
	        console.log(response.data);

	        $scope.sp_per_modality_data_all_sp_logs_for_export = response.data;
	        $scope.verifier.push($scope.sp_per_modality_data_all_sp_logs_for_export);

	        for(x = 0; x < $scope.sp_per_modality_data_all_sp_logs_for_export.length; x++){

	          $scope.sp_per_modality_data_all_sp_logs_for_export[x].sp_rfr_first_tranche_date = $scope.parse_date($scope.sp_per_modality_data_all_sp_logs_for_export[x].sp_rfr_first_tranche_date);
	          $scope.sp_per_modality_data_all_sp_logs_for_export[x].sp_date_started = $scope.parse_date($scope.sp_per_modality_data_all_sp_logs_for_export[x].sp_date_started);
	          $scope.sp_per_modality_data_all_sp_logs_for_export[x].sp_date_of_turnover = $scope.parse_date($scope.sp_per_modality_data_all_sp_logs_for_export[x].sp_date_of_turnover);
	          $scope.sp_per_modality_data_all_sp_logs_for_export[x].sp_target_date_of_completion = $scope.parse_date($scope.sp_per_modality_data_all_sp_logs_for_export[x].sp_target_date_of_completion);
	          $scope.sp_per_modality_data_all_sp_logs_for_export[x].sp_actual_date_completed = $scope.parse_date($scope.sp_per_modality_data_all_sp_logs_for_export[x].sp_actual_date_completed);

	          for(y = 0; y < $scope.sp_per_modality_data_all_sp_logs_for_export[x].sp_logs.length; y++){
	            $scope.sp_per_modality_data_all_sp_logs_for_export[x].sp_logs[y].updated_at = $scope.parse_date($scope.sp_per_modality_data_all_sp_logs_for_export[x].sp_logs[y].updated_at);
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
			alasql('SELECT * INTO XLS("Export_All_SP_Data.xls",{headers:true}) \
			            FROM HTML("#MyInquires",{headers:true})');

            $scope.show_modality();
		  }else{
            $scope.show_modality();
		  };
		});
	}

	$scope.Export_Modal_Data = function(){
		console.log('Export_Modal_Data');
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
			alasql('SELECT * INTO XLS("Export_SP_Data.xls",{headers:true}) \
			            FROM HTML("#MyInquires",{headers:true})');

            $scope.show_modality();
		  }else{
            $scope.show_modality();
		  };
		});
	}

	// PAGINTION
	$scope.Next_Pagination = function(url){
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

	$scope.Previous_Pagination = function (url){
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

	$scope.Skip_To_Page = function(path,Page_Number){
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

	$scope.Obj_push_keys = function(data){
	  var keys = Object.keys(data);
	  return keys;
	}

	$scope.Obj_push_values = function(data){
	  var keys = Object.values(data);
	  return keys;
	}

	$scope.render_charts_sp_type = function(data){
		// SP type
		var ctx = document.getElementById("myChart1");
		var data = {
			labels: $scope.Obj_push_keys(data),
			datasets: [{
			label: 'SP Count per SP Type',
			data: $scope.Obj_push_values(data),
		    backgroundColor: [
		        '#5d5f61',
		        '#5b80a5',
		        '#7f7aad',
		        '#3a3286',
		        '#9526a9',
		        '#580e65',
		        '#cc1794',
		        '#9d3644',
		        '#c6172f',
		        '#6b0816',
		        '#359f39',
		        '#6ec071',
		        '#70be09',
		        '#e1f919',
		        '#b79a07',
		        '#827639',
		        '#c87c1e',
		        '#78470a',
		        '#e9860b',
		        '#652f08',
		        '#59402e',
		        '#df660e',
		        '#a33105',
		        '#652107',
		        '#ff4c08',
		        '#f9bada',
		        '#9b5666',
		        '#134d76',
		        '#0296ff',
		    ]
		  }]
		}
		var myChart1 = new Chart(ctx, {
		  type: 'bar',
		  data: data,
		  options: {
		    "hover": {
		      "animationDuration": 0
		    },
		    "animation": {
		      "duration": 1,
		      "onComplete": function() {
		        var chartInstance = this.chart,
		          ctx = chartInstance.ctx;

		        ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
		        
		        ctx.textAlign = 'center';
		        ctx.textBaseline = 'bottom';

		        this.data.datasets.forEach(function(dataset, i) {
		          var meta = chartInstance.controller.getDatasetMeta(i);
		          meta.data.forEach(function(bar, index) {
		            var data = dataset.data[index];
		            ctx.fillText(data, bar._model.x, bar._model.y - 10);
		          });
		        });
		      }
		    },

			responsive: true,
		    scales: {
		      xAxes: [{
		        ticks: {
		          // maxRotation: 90,
		          minRotation: 90,
		           fontSize: 9
		        }
		      }],
		      yAxes: [{
		        ticks: {
		          beginAtZero: true
		        }
		      }]
		    },
		  }
		});

		myChart1.update();
	}


	$scope.render_charts_sp_category = function(data){
		// SP category
		var keys_Arr = [];
		for(var x = 0; x < $scope.Obj_push_keys(data).length; x++){
			if($scope.Obj_push_keys(data)[x] == "1"){
				keys_Arr.push("PUBLIC GOODS");
			}else if($scope.Obj_push_keys(data)[x] == "2"){
				keys_Arr.push("EPAC");
			}else if($scope.Obj_push_keys(data)[x] == "3"){
				keys_Arr.push("ENTERPRISE");
			}else if($scope.Obj_push_keys(data)[x] == "4"){
				keys_Arr.push("OTHERS");
			}else;
		}
		var oilCanvas = document.getElementById("myChart2");
		Chart.defaults.global.defaultFontSize = 9;

		var oilData = {
		    labels: keys_Arr,
		    datasets: [
		        {
		            data: $scope.Obj_push_values(data),
		            backgroundColor: [
		                "#44a0a9",
		                "#18b53a",
		                "#ff9e0d",
		                "#923408",
		            ],
	                options: {
				        responsive: true,
				        legend: {
				            position: 'top',
				        },
				        title: {
				            display: true,
				            text: 'Chart.js Doughnut Chart'
				        },
				        animation: {
				            animateScale: true,
				            animateRotate: true
				        }
				    }
		        }]
		};

		Chart.pluginService.register({
		    beforeRender: function (chart) {
		        if (chart.config.options.showAllTooltips) {
		            // create an array of tooltips
		            // we can't use the chart tooltip because there is only one tooltip per chart
		            chart.pluginTooltips = [];
		            chart.config.data.datasets.forEach(function (dataset, i) {
		                chart.getDatasetMeta(i).data.forEach(function (sector, j) {
		                    chart.pluginTooltips.push(new Chart.Tooltip({
		                        _chart: chart.chart,
		                        _chartInstance: chart,
		                        _data: chart.data,
		                        _options: chart.options.tooltips,
		                        _active: [sector]
		                    }, chart));
		                });
		            });

		            // turn off normal tooltips
		            chart.options.tooltips.enabled = false;
		        }
		    },
		    afterDraw: function (chart, easing) {
		        if (chart.config.options.showAllTooltips) {
		            // we don't want the permanent tooltips to animate, so don't do anything till the animation runs atleast once
		            if (!chart.allTooltipsOnce) {
		                if (easing !== 1)
		                    return;
		                chart.allTooltipsOnce = true;
		            }

		            // turn on tooltips
		            chart.options.tooltips.enabled = true;
		            Chart.helpers.each(chart.pluginTooltips, function (tooltip) {
		                tooltip.initialize();
		                tooltip.update();
		                // we don't actually need this since we are not animating tooltips
		                tooltip.pivot();
		                tooltip.transition(easing).draw();
		            });
		            chart.options.tooltips.enabled = false;
		        }
		    }
		});

		var pieChart = new Chart(oilCanvas, {
		  type: 'doughnut',
		  data: oilData,
			options: {
			    showAllTooltips: true,
				rotation: 1 * Math.PI,
				circumference: 1 * Math.PI,
				tooltips: {
					yAlign: 'bottom',
					yPadding: 10,
					backgroundColor: '#fbfbfb08',
					bodyFontColor: '#000000',
				}
			}
		});
	}

	$scope.download_chart_as_photo = function(params1,params2){
		console.log(params1);
		console.log(params2);
		/*Get image of canvas element*/
		var url_base64jp = document.getElementById(params1).toDataURL("image/jpg");
		/*get download button (tag: <a></a>) */
		var a =  document.getElementById(params2);
		/*insert chart image url to download button (tag: <a></a>) */
		a.href = url_base64jp;
		debugBase64(a.href);
		/**
		* Display a base64 URL inside an iframe in another window.
		*/
		function debugBase64(base64URL){
			var win = window.open();
			win.document.write('<iframe id="iframeshit" src="' + base64URL  + '" frameborder="0" style="border:0; top:0px; left:0px; bottom:0px; right:0px; width:100%; height:100%; background-color:#fff;" allowfullscreen></iframe>');
			win.document.close();
		}
	}

	$scope.show_downloadables = function(){
		$scope.dashboard_div = false;
		$scope.summary_div = false;
		$scope.modality_div = false;
		$scope.downloadables_div = true;
		$scope.profile_div = false;

		$scope.fetch_all_file();
		$scope.fetch_users_list();
	}

	$scope.my_files = false;
	$scope.show_my_files = function(){
		$scope.dashboard_div = false;
		$scope.summary_div = false;
		$scope.modality_div = false;
		$scope.profile_div = false;
		$scope.downloadables_div = true;
		$scope.my_files = true;
		$scope.fetch_my_all_file();
	}

	$scope.go_Back_to_all_files = function(){
		$scope.dashboard_div = false;
		$scope.summary_div = false;
		$scope.modality_div = false;
		$scope.profile_div = false;
		$scope.my_files = false;
		$scope.downloadables_div = true;
		$scope.fetch_my_all_file();
	}

	$scope.search_data = {};
	$scope.search_data_category = "$"
    $scope.fetch_my_all_file = function(){
		$http({
            method : "GET",
            url : 'fetch_my_all_file',
        }).then(function mySuccess(response) {
          	console.log(response.data);
          	$scope.all_my_file_data = response.data;

          	for(x = 0; x < $scope.all_my_file_data.length; x++){
          		$scope.all_my_file_data[x].updated_at = $scope.parse_date($scope.all_my_file_data[x].updated_at);
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
          	$scope.all_file = response.data;

          	for(x = 0; x < $scope.all_file.length; x++){
          		$scope.all_file[x].updated_at = $scope.parse_date($scope.all_file[x].updated_at);
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
				    $scope.fetch_my_all_file();
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


	$scope.rcis_dashboard = function(){
		$http({
		  method : "GET",
		  url : '/show_summary',
		}).then(function mySuccess(response) {
		  $scope.target_ncddp = response.data[0];
		  $scope.actual_ncddp = response.data[1];
		  $scope.target_ipcdd = response.data[2];
		  $scope.actual_ipcdd = response.data[3];
		  $scope.group_per_muni_ipccd = response.data[4];
		  $scope.group_per_muni_nccdp = response.data[5];
		  $scope.ncddp_per_cb = response.data[6];
		  $scope.ipcdd_per_cadt = response.data[7];

		  $scope.total_ipcddd = 0;
		  $scope.total_ncddp = 0;
		  angular.forEach($scope.group_per_muni_ipccd, function(data){
		    $scope.total_ipcddd += data.length;
		  });

		  angular.forEach($scope.group_per_muni_nccdp, function(data){
		    $scope.total_ncddp += data.length;
		  });

		  // console.log($scope.total_ipcddd);
		  // console.log($scope.total_ncddp);
		  
		  // console.log($scope.group_per_muni_ipccd);
		  // console.log($scope.group_per_muni_nccdp);
		  console.log($scope.ncddp_per_cb);
		  console.log($scope.ipcdd_per_cadt);      

		}, function myError(response) {

		});
	}

	$scope.get_total_level0 = function(classname_level){
		// $('.level0_class').text();
		var sum = 0;
		$.each($('.'+classname_level), function(){
		  // console.log(this);
		   sum += parseFloat($(this).text());
		});
		return sum;
	}

	// $scope.get_total_level0 = 0;
	$scope.level0 = function(val){
		$scope.level_0_count = 0;
		for(var x = 0; x < val.length; x++){
		  if(val[x].sp_logs_latest == null){
		    $scope.level_0_count++;
		  }
		}
		// $scope.get_total_level0+=$scope.level_0_count;
		return $scope.level_0_count;
	}

	$scope.level1 = function(val){
		$scope.level_1_count = 0;
		for(var x = 0; x < val.length; x++){
		  if(val[x].sp_logs_latest != null){
		    if(parseFloat(val[x].sp_logs_latest.sp_logs_actual) >= 0.00 && parseFloat(val[x].sp_logs_latest.sp_logs_actual) <= 59.99){
		      $scope.level_1_count++;
		    }else;
		  }
		}
		return $scope.level_1_count;
	}

	$scope.level2 = function(val){
		$scope.level_2_count = 0;
		for(var x = 0; x < val.length; x++){

		  if(val[x].sp_logs_latest != null){
		    if(parseFloat(val[x].sp_logs_latest.sp_logs_actual) >= 60 && parseFloat(val[x].sp_logs_latest.sp_logs_actual) <= 99.99){
		      $scope.level_2_count++;
		    }else;
		  }else;
		}
		return $scope.level_2_count;
	}

	$scope.level3 = function(val){
		$scope.level_3_count = 0;
		for(var x = 0; x < val.length; x++){

		  if(val[x].sp_logs_latest != null){

		    if(parseFloat(val[x].sp_logs_latest.sp_logs_actual) == 100.00){
		      $scope.level_3_count++;
		    }else;

		  }else;
		}
		return $scope.level_3_count;
	}

	function render_specific_sp(data){
		console.log(data);
		$scope.specific_sp_data = data;

	    // BUB
	    if($scope.specific_sp_data.c_m_f_s_kalahi_2015__b_u_b__s_p != null){
	      $scope.paramObj = {
	        grant: $scope.specific_sp_data.c_m_f_s_kalahi_2015__b_u_b__s_p.grant,
	        contigency: $scope.specific_sp_data.c_m_f_s_kalahi_2015__b_u_b__s_p.contigency,
	        other_amount: $scope.specific_sp_data.c_m_f_s_kalahi_2015__b_u_b__s_p.other_amount,
	        lcc_community: $scope.specific_sp_data.c_m_f_s_kalahi_2015__b_u_b__s_p.lcc_community,
	        lcc_community_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2015__b_u_b__s_p.lcc_community_ik,
	        lcc_blgu: $scope.specific_sp_data.c_m_f_s_kalahi_2015__b_u_b__s_p.lcc_blgu,
	        lcc_blgu_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2015__b_u_b__s_p.lcc_blgu_ik,
	        lcc_mlgu: $scope.specific_sp_data.c_m_f_s_kalahi_2015__b_u_b__s_p.lcc_mlgu,
	        lcc_mlgu_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2015__b_u_b__s_p.lcc_mlgu_ik,
	        lcc_plgu: $scope.specific_sp_data.c_m_f_s_kalahi_2015__b_u_b__s_p.lcc_plgu,
	        lcc_plgu_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2015__b_u_b__s_p.lcc_plgu_ik,
	        lcc_others: $scope.specific_sp_data.c_m_f_s_kalahi_2015__b_u_b__s_p.lcc_others,
	        lcc_others_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2015__b_u_b__s_p.lcc_others_ik,
	        lcc_cash: $scope.specific_sp_data.c_m_f_s_kalahi_2015__b_u_b__s_p.lcc_cash,
	        lcc_in_kind: $scope.specific_sp_data.c_m_f_s_kalahi_2015__b_u_b__s_p.lcc_in_kind,
	      }
	      $scope.total_project_cost = $scope.get_total_project_cost($scope.paramObj); 
	    
	    }else if($scope.specific_sp_data.c_m_f_s_kalahi_2016__b_u_b__s_p != null){
	      $scope.paramObj = {
	        grant: $scope.specific_sp_data.c_m_f_s_kalahi_2016__b_u_b__s_p.grant,
	        contigency: $scope.specific_sp_data.c_m_f_s_kalahi_2016__b_u_b__s_p.contigency,
	        other_amount: $scope.specific_sp_data.c_m_f_s_kalahi_2016__b_u_b__s_p.other_amount,
	        lcc_community: $scope.specific_sp_data.c_m_f_s_kalahi_2016__b_u_b__s_p.lcc_community,
	        lcc_community_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2016__b_u_b__s_p.lcc_community_ik,
	        lcc_blgu: $scope.specific_sp_data.c_m_f_s_kalahi_2016__b_u_b__s_p.lcc_blgu,
	        lcc_blgu_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2016__b_u_b__s_p.lcc_blgu_ik,
	        lcc_mlgu: $scope.specific_sp_data.c_m_f_s_kalahi_2016__b_u_b__s_p.lcc_mlgu,
	        lcc_mlgu_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2016__b_u_b__s_p.lcc_mlgu_ik,
	        lcc_plgu: $scope.specific_sp_data.c_m_f_s_kalahi_2016__b_u_b__s_p.lcc_plgu,
	        lcc_plgu_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2016__b_u_b__s_p.lcc_plgu_ik,
	        lcc_others: $scope.specific_sp_data.c_m_f_s_kalahi_2016__b_u_b__s_p.lcc_others,
	        lcc_others_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2016__b_u_b__s_p.lcc_others_ik,
	        lcc_cash: $scope.specific_sp_data.c_m_f_s_kalahi_2016__b_u_b__s_p.lcc_cash,
	        lcc_in_kind: $scope.specific_sp_data.c_m_f_s_kalahi_2016__b_u_b__s_p.lcc_in_kind,
	      }
	      $scope.total_project_cost = $scope.get_total_project_cost($scope.paramObj); 
	    
	    }else if($scope.specific_sp_data.c_m_f_s_kalahi_2017__b_u_b__s_p != null){
	      $scope.paramObj = {
	        grant: $scope.specific_sp_data.c_m_f_s_kalahi_2017__b_u_b__s_p.grant,
	        contigency: $scope.specific_sp_data.c_m_f_s_kalahi_2017__b_u_b__s_p.contigency,
	        other_amount: $scope.specific_sp_data.c_m_f_s_kalahi_2017__b_u_b__s_p.other_amount,
	        lcc_community: $scope.specific_sp_data.c_m_f_s_kalahi_2017__b_u_b__s_p.lcc_community,
	        lcc_community_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2017__b_u_b__s_p.lcc_community_ik,
	        lcc_blgu: $scope.specific_sp_data.c_m_f_s_kalahi_2017__b_u_b__s_p.lcc_blgu,
	        lcc_blgu_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2017__b_u_b__s_p.lcc_blgu_ik,
	        lcc_mlgu: $scope.specific_sp_data.c_m_f_s_kalahi_2017__b_u_b__s_p.lcc_mlgu,
	        lcc_mlgu_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2017__b_u_b__s_p.lcc_mlgu_ik,
	        lcc_plgu: $scope.specific_sp_data.c_m_f_s_kalahi_2017__b_u_b__s_p.lcc_plgu,
	        lcc_plgu_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2017__b_u_b__s_p.lcc_plgu_ik,
	        lcc_others: $scope.specific_sp_data.c_m_f_s_kalahi_2017__b_u_b__s_p.lcc_others,
	        lcc_others_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2017__b_u_b__s_p.lcc_others_ik,
	        lcc_cash: $scope.specific_sp_data.c_m_f_s_kalahi_2017__b_u_b__s_p.lcc_cash,
	        lcc_in_kind: $scope.specific_sp_data.c_m_f_s_kalahi_2017__b_u_b__s_p.lcc_in_kind,
	      }
	      $scope.total_project_cost = $scope.get_total_project_cost($scope.paramObj); 

	    }else if($scope.specific_sp_data.c_m_f_s_kalahi_2018__b_u_b__s_p != null){
	      $scope.paramObj = {
	        grant: $scope.specific_sp_data.c_m_f_s_kalahi_2018__b_u_b__s_p.grant,
	        contigency: $scope.specific_sp_data.c_m_f_s_kalahi_2018__b_u_b__s_p.contigency,
	        other_amount: $scope.specific_sp_data.c_m_f_s_kalahi_2018__b_u_b__s_p.other_amount,
	        lcc_community: $scope.specific_sp_data.c_m_f_s_kalahi_2018__b_u_b__s_p.lcc_community,
	        lcc_community_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2018__b_u_b__s_p.lcc_community_ik,
	        lcc_blgu: $scope.specific_sp_data.c_m_f_s_kalahi_2018__b_u_b__s_p.lcc_blgu,
	        lcc_blgu_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2018__b_u_b__s_p.lcc_blgu_ik,
	        lcc_mlgu: $scope.specific_sp_data.c_m_f_s_kalahi_2018__b_u_b__s_p.lcc_mlgu,
	        lcc_mlgu_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2018__b_u_b__s_p.lcc_mlgu_ik,
	        lcc_plgu: $scope.specific_sp_data.c_m_f_s_kalahi_2018__b_u_b__s_p.lcc_plgu,
	        lcc_plgu_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2018__b_u_b__s_p.lcc_plgu_ik,
	        lcc_others: $scope.specific_sp_data.c_m_f_s_kalahi_2018__b_u_b__s_p.lcc_others,
	        lcc_others_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2018__b_u_b__s_p.lcc_others_ik,
	        lcc_cash: $scope.specific_sp_data.c_m_f_s_kalahi_2018__b_u_b__s_p.lcc_cash,
	        lcc_in_kind: $scope.specific_sp_data.c_m_f_s_kalahi_2018__b_u_b__s_p.lcc_in_kind,
	      }
	      $scope.total_project_cost = $scope.get_total_project_cost($scope.paramObj); 
	    
	    }else if($scope.specific_sp_data.c_m_f_s_kalahi_2020__b_u_b__s_p != null){
	      $scope.paramObj = {
	        grant: $scope.specific_sp_data.c_m_f_s_kalahi_2020__b_u_b__s_p.grant,
	        contigency: $scope.specific_sp_data.c_m_f_s_kalahi_2020__b_u_b__s_p.contigency,
	        other_amount: $scope.specific_sp_data.c_m_f_s_kalahi_2020__b_u_b__s_p.other_amount,
	        lcc_community: $scope.specific_sp_data.c_m_f_s_kalahi_2020__b_u_b__s_p.lcc_community,
	        lcc_community_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2020__b_u_b__s_p.lcc_community_ik,
	        lcc_blgu: $scope.specific_sp_data.c_m_f_s_kalahi_2020__b_u_b__s_p.lcc_blgu,
	        lcc_blgu_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2020__b_u_b__s_p.lcc_blgu_ik,
	        lcc_mlgu: $scope.specific_sp_data.c_m_f_s_kalahi_2020__b_u_b__s_p.lcc_mlgu,
	        lcc_mlgu_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2020__b_u_b__s_p.lcc_mlgu_ik,
	        lcc_plgu: $scope.specific_sp_data.c_m_f_s_kalahi_2020__b_u_b__s_p.lcc_plgu,
	        lcc_plgu_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2020__b_u_b__s_p.lcc_plgu_ik,
	        lcc_others: $scope.specific_sp_data.c_m_f_s_kalahi_2020__b_u_b__s_p.lcc_others,
	        lcc_others_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2020__b_u_b__s_p.lcc_others_ik,
	        lcc_cash: $scope.specific_sp_data.c_m_f_s_kalahi_2020__b_u_b__s_p.lcc_cash,
	        lcc_in_kind: $scope.specific_sp_data.c_m_f_s_kalahi_2020__b_u_b__s_p.lcc_in_kind,
	      }
	      $scope.total_project_cost = $scope.get_total_project_cost($scope.paramObj); 

	    }else;

	    // NCDDP

	    if($scope.specific_sp_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p != null){
	      $scope.paramObj = {
	        grant: $scope.specific_sp_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p.grant,
	        contigency: $scope.specific_sp_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p.contigency,
	        other_amount: $scope.specific_sp_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p.other_amount,
	        lcc_community: $scope.specific_sp_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p.lcc_community,
	        lcc_community_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p.lcc_community_ik,
	        lcc_blgu: $scope.specific_sp_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p.lcc_blgu,
	        lcc_blgu_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p.lcc_blgu_ik,
	        lcc_mlgu: $scope.specific_sp_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p.lcc_mlgu,
	        lcc_mlgu_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p.lcc_mlgu_ik,
	        lcc_plgu: $scope.specific_sp_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p.lcc_plgu,
	        lcc_plgu_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p.lcc_plgu_ik,
	        lcc_others: $scope.specific_sp_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p.lcc_others,
	        lcc_others_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p.lcc_others_ik,
	        lcc_cash: $scope.specific_sp_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p.lcc_cash,
	        lcc_in_kind: $scope.specific_sp_data.c_m_f_s_kalahi_2015__n_c_d_d_p__s_p.lcc_in_kind,
	      }
	      $scope.total_project_cost = $scope.get_total_project_cost($scope.paramObj); 
	    
	    }else if($scope.specific_sp_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p != null){
	      $scope.paramObj = {
	        grant: $scope.specific_sp_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p.grant,
	        contigency: $scope.specific_sp_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p.contigency,
	        other_amount: $scope.specific_sp_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p.other_amount,
	        lcc_community: $scope.specific_sp_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p.lcc_community,
	        lcc_community_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p.lcc_community_ik,
	        lcc_blgu: $scope.specific_sp_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p.lcc_blgu,
	        lcc_blgu_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p.lcc_blgu_ik,
	        lcc_mlgu: $scope.specific_sp_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p.lcc_mlgu,
	        lcc_mlgu_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p.lcc_mlgu_ik,
	        lcc_plgu: $scope.specific_sp_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p.lcc_plgu,
	        lcc_plgu_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p.lcc_plgu_ik,
	        lcc_others: $scope.specific_sp_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p.lcc_others,
	        lcc_others_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p.lcc_others_ik,
	        lcc_cash: $scope.specific_sp_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p.lcc_cash,
	        lcc_in_kind: $scope.specific_sp_data.c_m_f_s_kalahi_2016__n_c_d_d_p__s_p.lcc_in_kind,
	      }
	      $scope.total_project_cost = $scope.get_total_project_cost($scope.paramObj); 
	    
	    }else if($scope.specific_sp_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p != null){
	      $scope.paramObj = {
	        grant: $scope.specific_sp_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p.grant,
	        contigency: $scope.specific_sp_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p.contigency,
	        other_amount: $scope.specific_sp_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p.other_amount,
	        lcc_community: $scope.specific_sp_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p.lcc_community,
	        lcc_community_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p.lcc_community_ik,
	        lcc_blgu: $scope.specific_sp_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p.lcc_blgu,
	        lcc_blgu_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p.lcc_blgu_ik,
	        lcc_mlgu: $scope.specific_sp_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p.lcc_mlgu,
	        lcc_mlgu_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p.lcc_mlgu_ik,
	        lcc_plgu: $scope.specific_sp_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p.lcc_plgu,
	        lcc_plgu_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p.lcc_plgu_ik,
	        lcc_others: $scope.specific_sp_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p.lcc_others,
	        lcc_others_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p.lcc_others_ik,
	        lcc_cash: $scope.specific_sp_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p.lcc_cash,
	        lcc_in_kind: $scope.specific_sp_data.c_m_f_s_kalahi_2017__n_c_d_d_p__s_p.lcc_in_kind,
	      }
	      $scope.total_project_cost = $scope.get_total_project_cost($scope.paramObj); 

	    }else if($scope.specific_sp_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p != null){
	      $scope.paramObj = {
	        grant: $scope.specific_sp_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p.grant,
	        contigency: $scope.specific_sp_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p.contigency,
	        other_amount: $scope.specific_sp_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p.other_amount,
	        lcc_community: $scope.specific_sp_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p.lcc_community,
	        lcc_community_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p.lcc_community_ik,
	        lcc_blgu: $scope.specific_sp_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p.lcc_blgu,
	        lcc_blgu_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p.lcc_blgu_ik,
	        lcc_mlgu: $scope.specific_sp_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p.lcc_mlgu,
	        lcc_mlgu_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p.lcc_mlgu_ik,
	        lcc_plgu: $scope.specific_sp_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p.lcc_plgu,
	        lcc_plgu_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p.lcc_plgu_ik,
	        lcc_others: $scope.specific_sp_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p.lcc_others,
	        lcc_others_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p.lcc_others_ik,
	        lcc_cash: $scope.specific_sp_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p.lcc_cash,
	        lcc_in_kind: $scope.specific_sp_data.c_m_f_s_kalahi_2018__n_c_d_d_p__s_p.lcc_in_kind,
	      }
	      $scope.total_project_cost = $scope.get_total_project_cost($scope.paramObj); 
	    
	    }else if($scope.specific_sp_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p != null){
	      $scope.paramObj = {
	        grant: $scope.specific_sp_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p.grant,
	        contigency: $scope.specific_sp_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p.contigency,
	        other_amount: $scope.specific_sp_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p.other_amount,
	        lcc_community: $scope.specific_sp_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p.lcc_community,
	        lcc_community_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p.lcc_community_ik,
	        lcc_blgu: $scope.specific_sp_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p.lcc_blgu,
	        lcc_blgu_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p.lcc_blgu_ik,
	        lcc_mlgu: $scope.specific_sp_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p.lcc_mlgu,
	        lcc_mlgu_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p.lcc_mlgu_ik,
	        lcc_plgu: $scope.specific_sp_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p.lcc_plgu,
	        lcc_plgu_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p.lcc_plgu_ik,
	        lcc_others: $scope.specific_sp_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p.lcc_others,
	        lcc_others_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p.lcc_others_ik,
	        lcc_cash: $scope.specific_sp_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p.lcc_cash,
	        lcc_in_kind: $scope.specific_sp_data.c_m_f_s_kalahi_2019__n_c_d_d_p__s_p.lcc_in_kind,
	      }
	      $scope.total_project_cost = $scope.get_total_project_cost($scope.paramObj); 
	    
	    }else if($scope.specific_sp_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p != null){
	      $scope.paramObj = {
	        grant: $scope.specific_sp_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p.grant,
	        contigency: $scope.specific_sp_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p.contigency,
	        other_amount: $scope.specific_sp_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p.other_amount,
	        lcc_community: $scope.specific_sp_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p.lcc_community,
	        lcc_community_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p.lcc_community_ik,
	        lcc_blgu: $scope.specific_sp_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p.lcc_blgu,
	        lcc_blgu_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p.lcc_blgu_ik,
	        lcc_mlgu: $scope.specific_sp_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p.lcc_mlgu,
	        lcc_mlgu_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p.lcc_mlgu_ik,
	        lcc_plgu: $scope.specific_sp_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p.lcc_plgu,
	        lcc_plgu_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p.lcc_plgu_ik,
	        lcc_others: $scope.specific_sp_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p.lcc_others,
	        lcc_others_ik: $scope.specific_sp_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p.lcc_others_ik,
	        lcc_cash: $scope.specific_sp_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p.lcc_cash,
	        lcc_in_kind: $scope.specific_sp_data.c_m_f_s_kalahi_2020__n_c_d_d_p__s_p.lcc_in_kind,
	      }
	      $scope.total_project_cost = $scope.get_total_project_cost($scope.paramObj); 
	    
	    }else;

		console.log($scope.specific_sp_data.sp_actual_date_completed);
		// for(x = 0; x < $scope.specific_sp_data.data.length; x++){
          $scope.specific_sp_data.sp_rfr_first_tranche_date = $scope.parse_date($scope.specific_sp_data.sp_rfr_first_tranche_date);
          $scope.specific_sp_data.sp_date_started = $scope.parse_date($scope.specific_sp_data.sp_date_started);
          $scope.specific_sp_data.sp_date_of_turnover = $scope.parse_date($scope.specific_sp_data.sp_date_of_turnover);
          $scope.specific_sp_data.sp_target_date_of_completion = $scope.parse_date($scope.specific_sp_data.sp_target_date_of_completion);
          $scope.specific_sp_data.sp_actual_date_completed = $scope.parse_date($scope.specific_sp_data.sp_actual_date_completed);

          for(y = 0; y < $scope.specific_sp_data.sp_logs.length; y++){
            $scope.specific_sp_data.sp_logs[y].updated_at = $scope.parse_date($scope.specific_sp_data.sp_logs[y].updated_at);
          }
        // }
	}
	
});