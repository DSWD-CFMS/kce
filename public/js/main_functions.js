var app = angular.module('Main_Function', []);

app.controller('Welcome_Controller', function($scope,$http,$filter) {
	console.log('Welcome_Controller');

	$.ajaxSetup({
	    headers: {
	        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	    }
	});

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

	$scope.get_sms_list = function(){
		$http({
      method : "GET",
      url : '/fetch_sms_list',
    }).then(function mySuccess(response) {
    	console.log(response.data);
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

  $scope.Initial_sp_data = function(){
    $http({
      method : "GET",
      url : '/Initial_sp_data',
    }).then(function mySuccess(response) {
      console.log(response.data);
      // $scope.users_list = response.data;
    }, function myError(response) {

    });
  }
    
  $scope.search_data_wabouts = {};
  $scope.search_data_wabouts_category = "$"
	$scope.get_whereabouts = function(){
		$http({
        method : "GET",
        url : '/fetch_whereabouts',
    }).then(function mySuccess(response) {
      	console.log(response.data);
        $scope.whereabouts_data = response.data;
        for(var x = 0; x < $scope.whereabouts_data.length; x++){
          $scope.whereabouts_data.dateFrom = $scope.parse_date($scope.whereabouts_data.dateFrom);
          $scope.whereabouts_data.dateTo = $scope.parse_date($scope.whereabouts_data.dateTo);
          $scope.whereabouts_data.dateApproved = $scope.parse_date($scope.whereabouts_data.dateApproved);
        }

    }, function myError(response) {
     
    });
	}

  $scope.search_data_modality = {};
  $scope.search_data_category_modality = "$"
  $scope.get_modalities_sp = function(){
    var header = document.querySelector( '.navbar-default' );
    $(header).addClass('navbar-scroll');

    $http({
        method : "GET",
        url : '/get_modalities_sp',
    }).then(function mySuccess(response) {
        console.log(response.data);
        $scope.get_modalities_sp_data = response.data;

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

            window.location.href = "http://kce_v2.caraga.dswd.gov.ph/modality";
      }else{
            window.location.href = "http://kce_v2.caraga.dswd.gov.ph/modality";
      };
    });
  }

	// Downloadables
	$scope.search_data = {};
	$scope.search_data_category = "$"
  $scope.fetch_my_all_file = function(){
	$http({
          method : "GET",
          url : 'downloadables/fetch_my_all_file',
      }).then(function mySuccess(response) {
        	console.log(response.data);
        	$scope.all_file_data = response.data;

        	for(x = 0; x < $scope.all_file_data.length; x++){
        		$scope.all_file_data[x].updated_at = $scope.parse_date($scope.all_file_data[x].updated_at);
        	}

      }, function myError(response) {
      });
  }

  // downloadables and modalities
  $scope.clearFilter = function() {
    $scope.search_data_modality = {};
	  $scope.search_data = {};
    $scope.province_data = "";
    $scope.municipality_data = "";
    $scope.brgy_data = "";

  };

  $scope.show_albums = function(){
    $http({
        method : "GET",
        url : '/fetch_gallery',
    }).then(function mySuccess(response) {
        console.log(response.data);
        $scope.gallery_data = response.data;
    }, function myError(response) {});
  }

  $scope.ViewSpecificAlbum = false;
  $scope.view_specific_album = function(data) {
    $scope.ViewSpecificAlbum = true;
    $scope.album_images = data;
    console.log($scope.album_images);

    $scope.album_images.created_at = $scope.parse_date($scope.album_images.created_at);
  }

  $scope.back_to_albums = function(data) {
    $scope.ViewSpecificAlbum = false;
  }

	// REGISTRATION
	$scope.Enroll_Personnel = function(){
		console.log('dsdsds');
		var data = {
      Fname : $scope.Fname,
			Mname : $scope.Mname,
			Lname : $scope.Lname,
			emp_id_no : $scope.emp_id_no,
			contact : $scope.contact,
			birthdate : js_yyyy_mm_dd_hh_mm_ss($scope.birthdate),
			email : $scope.email,
			username : $scope.username,
			password : $scope.password,
			role: $scope.role,
    }

        console.log(data);

        $http({
            method : "POST",
            url : '/register',
            data : data,
        }).then(function mySuccess(response){
            $scope.Sign_Up_Data = response.data;
        }, function myError(response){
        	console.log(response);
        });
	}

  // Start For Reports
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

  $scope.show_summary = function(){
    $http({
      method : "GET",
      url : '/show_summary',
    }).then(function mySuccess(response) {
      $scope.target_ncddp = response.data[0];
      $scope.actual_ncddp = response.data[1];
      $scope.target_ipcdd = response.data[2];
      $scope.actual_ipcdd = response.data[3];
      $scope.group_per_muni_ipccd = response.data[4];
      $scope.group_per_muni_ncddp = response.data[5];
      $scope.ncddp_per_cb = response.data[6];
      $scope.ipcdd_per_cadt = response.data[7];

      $scope.weighted_kkb_percetage = response.data[8];
      $scope.weighted_makilahok_percetage = response.data[9];
      $scope.weighted_ncddp_percetage = response.data[10];
      $scope.weighted_ipccdd_percetage = response.data[11];
      $scope.weighted_ccl_percetage = response.data[12];
      $scope.weighted_LandE_percetage = response.data[13];

      $scope.total_ipcddd = 0;
      $scope.total_ncddp = 0;
      angular.forEach($scope.group_per_muni_ipccd, function(data){
        $scope.total_ipcddd += data.length;
      });

      angular.forEach($scope.group_per_muni_ncddp, function(data){
        $scope.total_ncddp += data.length;
      });

      // console.log($scope.total_ipcddd);
      // console.log($scope.total_ncddp);
      
      // console.log($scope.group_per_muni_ipccd);
      // console.log($scope.group_per_muni_ncddp);
      console.log($scope.group_per_muni_ncddp);
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
      if(val[x].actual == null){
        $scope.level_0_count++;
      }
      // if(val[x].sp_logs_latest == null){
      //   $scope.level_0_count++;
      // }
    }
    // $scope.get_total_level0+=$scope.level_0_count;
    return $scope.level_0_count;
  }
  
  $scope.level1 = function(val){
  $scope.level_1_count = 0;
    for(var x = 0; x < val.length; x++){
      // if(val[x].sp_logs_latest != null){
      //   if(parseFloat(val[x].sp_logs_latest.sp_logs_actual) >= 0.00 && parseFloat(val[x].sp_logs_latest.sp_logs_actual) <= 59.99){
      //     $scope.level_1_count++;
      //   }else;
      // }
      if(val[x].actual != null){
        if(parseFloat(val[x].actual) >= 0.01 && parseFloat(val[x].actual) <= 59.99){
          $scope.level_1_count++;
        }else;
      }  
    }
    return $scope.level_1_count;
  }

  $scope.level2 = function(val){
  $scope.level_2_count = 0;
    for(var x = 0; x < val.length; x++){
      // if(val[x].sp_logs_latest != null){
      //   if(parseFloat(val[x].sp_logs_latest.sp_logs_actual) >= 60 && parseFloat(val[x].sp_logs_latest.sp_logs_actual) <= 99.99){
      //     $scope.level_2_count++;
      //   }else;
      // }else;
      if(val[x].actual != null){
        if(parseFloat(val[x].actual) >= 60.00 && parseFloat(val[x].actual) <= 99.99){
          $scope.level_2_count++;
        }else;
      }              
    }
    return $scope.level_2_count;
  }

  $scope.level3 = function(val){
  $scope.level_3_count = 0;
    for(var x = 0; x < val.length; x++){
      // if(val[x].sp_logs_latest != null){
      //   if(parseFloat(val[x].sp_logs_latest.sp_logs_actual) == 100.00){
      //     $scope.level_3_count++;
      //   }else;
      // }else;
      if(val[x].actual != null){
        if(parseFloat(val[x].actual) == 100.00){
          $scope.level_3_count++;
          // console.log(val[x].sp_id)
        }else;
      }else;                  
    }
    return $scope.level_3_count;
  }

// -----------------------------------------------------------------
  
  $scope.level0_ncddp = function(val){
    $scope.level_0_count = 0;
    for(var x = 0; x < val.length; x++){
      if(val[x].actual == null){
        $scope.level_0_count++;
      }
      // if(val[x].sp_logs_latest == null){
      //   $scope.level_0_count++;
      // }
    }
    return $scope.level_0_count;
  }
  
  $scope.level1_ncddp = function(val){
  $scope.level_1_count = 0;
    for(var x = 0; x < val.length; x++){
      if(val[x].actual != null){
        if(parseFloat(val[x].actual) >= 0.01 && parseFloat(val[x].actual) <= 59.99){
          $scope.level_1_count++;
        }else;
      }          
      // if(val[x].sp_logs_latest != null){
      //   if(parseFloat(val[x].sp_logs_latest.sp_logs_actual) >= 0.01 && parseFloat(val[x].sp_logs_latest.sp_logs_actual) <= 59.99){
      //     $scope.level_1_count++;
      //   }else;
      // }
    }
    return $scope.level_1_count;
  }

  $scope.level2_ncddp = function(val){
  $scope.level_2_count = 0;
    for(var x = 0; x < val.length; x++){
      if(val[x].actual != null){
        if(parseFloat(val[x].actual) >= 60.00 && parseFloat(val[x].actual) <= 99.99){
          $scope.level_2_count++;
        }else;
      }  

      // if(val[x].sp_logs_latest != null){
      //   if(parseFloat(val[x].sp_logs_latest.sp_logs_actual) >= 60.00 && parseFloat(val[x].sp_logs_latest.sp_logs_actual) <= 99.99){
      //     $scope.level_2_count++;
      //   }else;
      // }else;
    }
    return $scope.level_2_count;
  }

  $scope.level3_ncddp = function(val){
  $scope.level_3_count = 0;
    for(var x = 0; x < val.length; x++){

      if(val[x].actual != null){
        if(parseFloat(val[x].actual) == 100.00){
          $scope.level_3_count++;
          // console.log(val[x].sp_id)
        }else;
      }else;
    }
    return $scope.level_3_count;
  }

  $scope.zero_percent = function(modality,type){
    console.log(modality);
    console.log(type);
    $http({
      method : "GET",
      url : '/show_summary_percentages/'+modality+'/'+type,
    }).then(function mySuccess(response) {
      $scope.show_summary_percentages_data = response.data;
      console.log($scope.show_summary_percentages_data);
      
      if(type == 0){
        $scope.subhead = "SP's with 0% Actual Accomplishment";
      }else if(type == 1){
        $scope.subhead = "SP's with 0.01% - 59.99% Actual Accomplishment";
      }else if(type == 2){
        $scope.subhead = "SP's with 60.00% - 99.99% Actual Accomplishment";
      }else if(type == 3){
        $scope.subhead = "SP's with 100% Actual Accomplishment";
      }else;

      if(modality == 1){
        $scope.header = "KKB";
      }else if(modality == 2){
        $scope.header = "MAKILAHOK";
      }else if(modality == 3){
        $scope.header = "NCDDP";
      }else if(modality == 4){
        $scope.header = "IP CDD";
      }else if(modality == 5){
        $scope.header = "CCL";
      }else if(modality == 6){
        $scope.header = "L & E";
      }else;

      $('#summary_sp_modal').modal('show');
    }, function myError(response) {

    });
  }

  $scope.Export_Modality_Data_Summary = function(){
    $('#summary_sp_modal').modal('hide');

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
        setTimeout(() => { Swal.hideLoading() }, 4000)
      }
    }).then((result) => {
      if (result.value) {
            alasql('SELECT * INTO XLS("Modality_Exported_Data.xls",{headers:true}) \
            FROM HTML("#MyInquires",{headers:true})');

            window.location.href = "http://kce_v2.caraga.dswd.gov.ph/summary";
      }else{
            window.location.href = "http://kce_v2.caraga.dswd.gov.ph/summary";
      };
    });
  }

});
