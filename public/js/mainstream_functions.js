var app = angular.module('Main_Function', []);

app.controller('MAINSTREAM_Controller', function($scope,$http,$filter,$timeout) {
  console.log('MAINSTREAM_Controller');
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

  // init values
  $scope.fetch_mainstream_dashboard_div = false;
  $scope.fetch_mainstream_spcrs_div = false;
  $scope.fetch_mainstream_upload_div = false;

  $scope.fetch_mainstream_dashboard = function(){
    $scope.fetch_mainstream_dashboard_div = true;
    $scope.fetch_mainstream_spcrs_div = false;
    $scope.fetch_mainstream_upload_div = false;
  }

  $scope.fetch_mainstream_spcr = function(){
    $scope.fetch_mainstream_spcrs_div = true;
    $scope.fetch_mainstream_dashboard_div = false;
    $scope.fetch_mainstream_upload_div = false;

    $http({
        method : "GET",
        url : 'routes/get_spcr_tracks',
    }).then(function mySuccess(response) {
        $scope.spcr_list = response.data;
        console.log($scope.spcr_list);

        for(var x=0; x < $scope.spcr_list.data.length; x++){
          $scope.spcr_list.data[x].updated_at = $scope.parse_date($scope.spcr_list.data[x].updated_at);

          $scope.spcr_list.data[x].received_srpmo = $scope.parse_date($scope.spcr_list.data[x].received_srpmo);
          $scope.spcr_list.data[x].received_srpmo_socials = $scope.parse_date($scope.spcr_list.data[x].received_srpmo_socials);
          $scope.spcr_list.data[x].received_srpmo_finance = $scope.parse_date($scope.spcr_list.data[x].received_srpmo_finance);
          $scope.spcr_list.data[x].received_srpmo_engineering = $scope.parse_date($scope.spcr_list.data[x].received_srpmo_engineering);
          $scope.spcr_list.data[x].received_rpmo = $scope.parse_date($scope.spcr_list.data[x].received_rpmo);
          $scope.spcr_list.data[x].received_socials = $scope.parse_date($scope.spcr_list.data[x].received_socials);
          $scope.spcr_list.data[x].received_finance = $scope.parse_date($scope.spcr_list.data[x].received_finance);
          $scope.spcr_list.data[x].received_engineering = $scope.parse_date($scope.spcr_list.data[x].received_engineering);
        }
        
    }, function myError(response) {});

  }

  $scope.fetch_mainstream_upload = function(){
    $scope.fetch_mainstream_upload_div = true;
    $scope.fetch_mainstream_spcrs_div = false;
    $scope.fetch_mainstream_dashboard_div = false;
  }

  // PAGINTION
  $scope.Next_Pagination = function(url){
    $http({
          method : "GET",
          url : url,
      }).then(function mySuccess(response) {
        console.log(response.data[1].data);
        $scope.spcr_list = response.data;
      }, function myError(response) {
      
    });
  }

  $scope.Previous_Pagination = function (url){
    console.log(url);
    $http({
          method : "GET",
          url : url,
      }).then(function mySuccess(response) {
      console.log(response.data[1].data);
        $scope.spcr_list = response.data;
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
        $scope.spcr_list = response.data;
    }, function myError(response) {

    });
  }
  // PAGINTION

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
// end of MAINSTREAM Conroller