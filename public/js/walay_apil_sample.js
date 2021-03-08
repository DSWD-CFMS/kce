var app = angular.module('Main_Function', ["ui.bootstrap"]);
// app.controller('Home_Controller', function($scope,$http) {
//     var pathname = window.location.pathname;
//     console.log(pathname);
//     $scope.path = pathname;

//         $scope.Customer_Requests = function(){
//         $scope.custom_requests = true;
//         console.log('pathname');

//     }
// });

app.filter("startFrom", function(){
    return function(data, start){
        // if(!data || !data.length){
        //     return;
        // }
        start = +start; //parse to int
        return data.slice(start);
    };
});

app.controller('Farmer_Controller', function($scope,$http) {
    console.log("Farmer_Controller");
    toastr.options = {
      "debug": false,
      "newestOnTop": true,
      "progressBar": true,
      "preventDuplicates": false,
      "positionClass": "toast-bottom-right",
      "onclick": null,
      "fadeIn": 8000,
      "fadeOut": 8000,
      "timeOut": 8000,
      "extendedTimeOut": 8000
    }

    // Native JQUERY FUNCTIONS
    $(window).on('load resize', function(){
       if ($('.page-wrapper').width() < 767 ){
            $scope.closeNav();
       }else{
            $scope.openNav();
       };
    });

    $scope.openNav = function(){
      $(".page-wrapper").addClass("toggled");
    }

    $scope.closeNav = function(){
      $(".page-wrapper").removeClass("toggled");
    }

    /** /* NAVIGATION PANE **/
    $(".sidebar-dropdown > a").click(function() {
      $(".sidebar-submenu").slideUp(200);
      if ( $(this).parent().hasClass("active") ) {
        $(".sidebar-dropdown").removeClass("active");
        $(this)
          .parent()
          .removeClass("active");
      } else {
        $(".sidebar-dropdown").removeClass("active");
        $(this)
          .next(".sidebar-submenu")
          .slideDown(200);
        $(this)
          .parent()
          .addClass("active");
      }

    });

    $(".sidebar-submenu > ul > li > a").click(function(){
      $(".sidebar-dropdown").removeClass("active");
      $(".sidebar-submenu").slideUp(200);
    });
    /** /* END NAVIGATION PANE **/

    /** SOCKETS EVENTS **/
    var user_id = $('#user_id').html();

    var socket = io.connect('http://localhost:3001');

    socket.emit("NewFarmer", user_id, function(user_id, callback){
        if (user_id) {
            console.log('true');
        }else{
            console.log('false');
        }
    });

    socket.on("New_Posted_Product", function(data){
        console.log('New_Posted_Product');
    });

    socket.on("Accepted_Farmer_Bid", function(data){
        // console.log(data);
        // console.log(data.event);
        // console.log(data.event[0]);
        // console.log(data.event[1][0].Requested_Product_Name);
        // console.log(data.event[1][0].buyer_info.F_Name);
        toastr.info("Accepted your bid on <br/> <b class='text-success'> <i class='fa fa-thumbs-o-up'></i> "+data.event[1][0].Requested_Product_Name+"<b>", data.event[1][0].buyer_info.F_Name +' '+data.event[1][0].buyer_info.L_Name);
        $scope.Get_My_Notification();
    });

    socket.on("Order_A_Product", function(data){
        // console.log(data);
        // console.log(data.event);
        // console.log(data.event[0]);
        // console.log(data.event[1][0].posted_product[0].Product_Name);
        // console.log(data.event[2][0].F_Name);
        // console.log(data.event[2][0].L_Name);
        toastr.info("<b>"+data.event[2][0].F_Name +' '+data.event[2][0].L_Name+"</b> <br/> Ordered your product <br/> <b class='text-success'>"+data.event[1][0].posted_product[0].Product_Name+"<b>", "<h6 class='text-success'>New Order!</h6>");
        $scope.Get_My_Notification();
    });

    socket.on("Issue_An_Official_Receipt", function(data){
        $scope.Get_Delivered_Product_Orders();
    });

    $scope.Get_Delivered_Product_Orders = function(){
        $http({
            method : "GET",
            url : 'routes/Get_Delivered_Product_Orders',
        }).then(function mySuccess(response) {
             console.log(response.data);
             $scope.Delivered_Product_Orders = response.data;
            
            if($scope.Delivered_Product_Orders.length > 0){
                for(var x = 0; x < $scope.Delivered_Product_Orders.length; x++){
                    $scope.Delivered_Product_Orders[x].updated_at = $scope.parse_date($scope.Delivered_Product_Orders[x].updated_at);
                }
                $('.modal#Delivered_Product_Orders_Modal').modal({backdrop: 'static', keyboard:false});
            }else;

        }, function myError(response) {
         
        });
    }
    $scope.Get_Delivered_Product_Orders();

    $scope.Confirm_Delivered_Product_Orders = function(items){

        var data = {
            items:items,
        }

        $http({
            method : "POST",
            url : 'routes/Confirm_Delivered_Product_Orders',
            data : data
        }).then(function mySuccess(response) {
             console.log(response.data);
            if(response.data == "success"){
                $('.modal#Delivered_Product_Orders_Modal').modal('hide');

                swal({
                    title: "Thank you!",
                    text: "Your products have been successfuly delivered.",
                    icon: "success",
                    buttons: {
                        cancel: "Okay",
                    },
                }).then(function(){
                    $scope.My_Products();
                });
            }else;

        }, function myError(response) {
         
        });
    }
    /** END SOCKETS EVENTS **/

    $scope.initialized_values = function(){
        $scope.View_List_Of_Products();
        $scope.View_Bids_To_Request();
        $scope.All_Deliverable_List();
    }

    $scope.parse_date = function(date){
        date = new Date(Date.parse(date));
        return date;
    }

    // Retrieving profile info
    $scope.Get_Profile = function(user_id){
        $http({
            method : "GET",
            url : 'routes/Get_Profile/'+user_id,
        }).then(function mySuccess(response) {
            console.log(response.data);
            $scope.profile_F_Name = response.data[0].F_Name;
            $scope.profile_M_Name = response.data[0].M_Name;
            $scope.profile_L_Name = response.data[0].L_Name;
            $scope.profile_Email = response.data[0].Email;
            $scope.profile_Contact_Number = response.data[0].Contact_Number;
        }, function myError(response) {

        });
    }
    $scope.Get_Profile(user_id);

    $scope.Get_My_Notification = function(){
        $http({
            method : "GET",
            url : 'routes/Get_Notification',
        }).then(function mySuccess(response) {
            console.log(response.data);
            $scope.notif_count_bid = response.data.length;
        }, function myError(response) {
        });
    }
    $scope.Get_My_Notification();

    $scope.Update_My_Notifications = function(){
        $http({
            method : "GET",
            url : 'routes/Update_Event',
        }).then(function mySuccess(response) {
            $scope.Get_My_Notification();
        }, function myError(response) {

        });
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

    // INITIALIZE VARIABLES
    $scope.If_Dashboard = true;
    $scope.make_bid_checkbox = false;
    $scope.If_Customer_Requests = false;
    $scope.If_Market_Statistics = false;
    $scope.If_My_Products = false;
    $scope.If_View_My_Mroduct_Orders = false;
    // $scope.If_Make_Bid = false;
    $scope.If_To_Shrink = false;
    $scope.If_Make_Bid_checkbox = false;
    $scope.If_Bids_Requests = false;
    $scope.If_Accepted_Bids = false;
    $scope.If_Calendar = false;

    // INITIALIZE VARIABLES
    $scope.View_Calendar = function(){
    $scope.If_Dashboard = false;
    $scope.make_bid_checkbox = false;
    $scope.If_Customer_Requests = false;
    $scope.If_Market_Statistics = false;
    $scope.If_My_Products = false;
    $scope.If_View_My_Mroduct_Orders = false;
    // $scope.If_Make_Bid = false;
    $scope.If_To_Shrink = false;
    $scope.If_Make_Bid_checkbox = false;
    $scope.If_Bids_Requests = false;
    $scope.If_Accepted_Bids = false;
    
    $scope.If_Calendar = true;

    }

    //Viewing sa Costumer Requests -- Start
    $scope.Customer_Requests = function(){
        // RE INITIALIZED OTHER VARIABLES
        $scope.If_Dashboard = false;
        $scope.If_Calendar = false;
        $scope.If_Market_Statistics = false;
        $scope.If_My_Products = false;
        $scope.If_View_My_Mroduct_Orders = false;
        $scope.If_Make_Bid = false;
        $scope.If_Bids_Requests = false;
        $scope.If_Accepted_Bids = false;
        // RE INITIALIZED OTHER VARIABLES
        $scope.If_Customer_Requests = true;

        console.log("test");

        $http({
            method : "GET",
            url : 'routes/Customer_Requests_List',
        }).then(function mySuccess(response) {
            console.log(response.data);
            $scope.Customer_Requests_List = response.data;

            for(var x = 0; x < $scope.Customer_Requests_List.length; x++){
                $scope.Customer_Requests_List[x].Requested_Product_Prefered_Delivery_Date = $scope.parse_date($scope.Customer_Requests_List[x].Requested_Product_Prefered_Delivery_Date);
                $scope.Customer_Requests_List[x].created_at = $scope.parse_date($scope.Customer_Requests_List[x].created_at);
            }
        }, function myError(response) {
         
        });
    }

    $scope.View_Specific_Request_Detail = function(List){
        $scope.Specific_Request_Detail = List;
        console.log(List);
        $scope.Make_Bid();
    }
    //END

    //Bidding sa Costumer Request -- Start
    $scope.Submit_Bid = function(id){
       var date = js_yyyy_mm_dd_hh_mm_ss($scope.Specific_Request_Detail.Farmer_Delivery_Date);

        var data = {
            Farmer_Bid_Details:$scope.Specific_Request_Detail.Farmer_Bid_Details,
            Farmer_Bid_Price:$scope.Specific_Request_Detail.Farmer_Bid_Price,
            Farmer_Delivery_Date:date,
            Requested_Product_Id:id,
            Farmer_Bid_Total_Amount:$scope.Specific_Request_Detail.Farmer_Bid_Price * $scope.Specific_Request_Detail.Requested_Quantity,
        }

         $http({
                method : "POST",
                url : 'routes/Bid_On_Request',
                data: data,
            }).then(function mySuccess(response) {
                $('.modal').modal('hide');
                console.log(response.data);
                if(response.data == "bid_submitted"){
                    swal({
                        title: "Yahoo!",
                        text: "You have successfuly bid to request!",
                        icon: "success",
                        buttons: {
                            cancel: "Okay",
                        },
                    }).then(function(){
                        $scope.Bids_To_Requests();
                    });
                }else;
                
            }, function myError(response) {
                    
             
            });
    }
    //END

    //Viewing sa mga Bids
    $scope.Bids_To_Requests = function(){
        // RE INITIALIZED OTHER VARIABLES
        $scope.If_Dashboard = false;
        $scope.If_Calendar = false;
        $scope.If_Customer_Requests = false;
        $scope.If_Market_Statistics = false;
        $scope.If_My_Products = false;
        $scope.If_View_My_Mroduct_Orders = false;
        $scope.If_Make_Bid = false;
        $scope.If_To_Shrink = false;
        $scope.If_Make_Bid_checkbox = false;
        $scope.If_Accepted_Bids = false;
        // RE INITIALIZED OTHER VARIABLES
        $scope.If_Bids_Requests = true;

        $scope.View_Bids_To_Request();
    }

    $scope.View_Bids_To_Request = function(){
        $http({
            method : "GET",
            url : 'routes/Farmer_Bid_List',
        }).then(function mySuccess(response) {
            console.log(response.data);
            $scope.Farmer_Bid_List = response.data;
            $scope.Bid_Count = $scope.Farmer_Bid_List.length;

            for(var x = 0; x < $scope.Farmer_Bid_List.length; x++){
                $scope.Farmer_Bid_List[x].created_at = $scope.parse_date($scope.Farmer_Bid_List[x].created_at);
                $scope.Farmer_Bid_List[x].requested_products.created_at = $scope.parse_date($scope.Farmer_Bid_List[x].requested_products.created_at);
            }
        }, function myError(response) {
         
        });
    }

    $scope.View_Specific_Bid_Detail = function(List){
        $scope.Specific_Bid_Detail = List;
        console.log($scope.Specific_Bid_Detail);
        console.log($scope.Specific_Bid_Detail.requested_products);
        $scope.Specific_Bid_Detail.Farmer_Delivery_Date = $scope.parse_date($scope.Specific_Bid_Detail.Farmer_Delivery_Date);
        $scope.Specific_Bid_Detail.requested_products.created_at = $scope.parse_date($scope.Specific_Bid_Detail.requested_products.created_at);
    }

    //END
    $scope.deliverable_type = '1';
    $scope.View_Deliverables = function(){
        // RE INITIALIZED OTHER VARIABLES
        $scope.If_Dashboard = false;
        $scope.If_Calendar = false;
        $scope.If_Customer_Requests = false;
        $scope.If_Market_Statistics = false;
        $scope.If_My_Products = false;
        $scope.If_View_My_Mroduct_Orders = false;
        $scope.If_Make_Bid = false;
        $scope.If_To_Shrink = false;
        $scope.If_Make_Bid = false;
        $scope.If_Make_Bid_checkbox = false;
        $scope.If_Bids_Requests = false;
        // RE INITIALIZED OTHER VARIABLES

        $scope.If_Accepted_Bids = true;
        $scope.View_List_Of_Deliverables();
    }

    $scope.View_List_Of_Deliverables = function(deliverable_type){
        // $scope.deliverable_type = deliverable_type;
        if(deliverable_type == '1'){
            // console.log('1');
            $http({
                method : "GET",
                url : 'routes/View_All_Deliverables/'+deliverable_type,
            }).then(function mySuccess(response) {
                console.log(response.data);
                    $scope.Deliverable_List = response.data;
                    for(var x = 0; x < $scope.Deliverable_List.length; x++){
                        $scope.Deliverable_List[x].created_at = $scope.parse_date($scope.Deliverable_List[x].created_at);
                    }

            }, function myError(response) {});
            
        }else if(deliverable_type == '2'){
            $http({
                method : "GET",
                url : 'routes/View_All_Deliverables/'+deliverable_type,
            }).then(function mySuccess(response) {
                console.log(response.data);

                $scope.Deliverable_List = response.data;

                for(var x = 0; x < $scope.Deliverable_List.length; x++){
                    $scope.Deliverable_List[x].Farmer_Delivery_Date = $scope.parse_date($scope.Deliverable_List[x].Farmer_Delivery_Date);
                    $scope.Deliverable_List[x].requested_products.updated_at = $scope.parse_date($scope.Deliverable_List[x].requested_products.updated_at);
                }
                $scope.Get_My_Notification();
            }, function myError(response) {});
        }else;

    }

    $scope.All_Deliverable_List = function(){
        $http({
            method : "GET",
            url : 'routes/All_Deliverable_List',
        }).then(function mySuccess(response) {
            $scope.All_Deliverable_List_Count_Orders = response.data[0].length;
            $scope.All_Deliverable_List_Count_Accepted_Bids = response.data[1].length;
        }, function myError(response) {});
    }

    $scope.View_List_Of_Specific_Deliverables = function(List){
        $scope.Specific_Deliverable_Details = List;
        console.log($scope.Specific_Deliverable_Details);
        $scope.Specific_Deliverable_Details.updated_at = $scope.parse_date($scope.Specific_Deliverable_Details.updated_at);
    }

    $scope.Market_Statistics = function(){
        // RE INITIALIZED OTHER VARIABLES
        $scope.If_Dashboard = false;
        $scope.If_Calendar = false;
        $scope.If_Customer_Requests = false;
        $scope.If_My_Products = false;
        $scope.If_View_My_Mroduct_Orders = false;
        $scope.If_Make_Bid = false;
        $scope.If_Bids_Requests = false;
        $scope.If_Accepted_Bids = false;
        // RE INITIALIZED OTHER VARIABLES

        $scope.market_statistics = true;
        //Top Priced Product Per Category
        $http({
            method : "GET",
            url : 'routes/Top_Priced_Product',
        }).then(function mySuccess(response) {
            $scope.top_priced_products = response.data
            var Top = response.data;
            var s = Top.length;
            // console.log(s);
            var i=0;
            for(i=0;i<s;i++){
                if(Top[i] == null){
                    Top.splice(i);
                    
                }
            }
            $scope.top_priced_products = Top;
            // console.log($scope.top_priced_products);
        }, function myError(response) {
         
        });

        $scope.If_Market_Statistics = true;
        //End of Top Priced Product Per Category

        //Top Priced Product Per Category Chart
        $http({
            method : "GET",
            url : 'routes/Top_Priced_Product_Chart',
        }).then(function mySuccess(response) {
            console.log(response.data[0]);
            console.log(response.data[1]);
            var top_priced_category_name = response.data[0];
            var top_priced_category_price = response.data[1];

        var Top_Priced_Product_Chart_Canvas = document.getElementById("pie_chart");

        var Top_Priced_Product_Chart = {
            label: "Price Chart",
            data: top_priced_category_price,
            borderColor: '#4086bc',
            fill: true,
            pointBorderWidth: 2,
            pointBorderColor: '#4086bc',
            pointBackgroundColor: '#fff',
            pointRadius: 4,
            lineTension: 0,
        };

        var Top_Priced_Product_Chart_Canvas_Data = {
            labels: top_priced_category_name,
            datasets: [Top_Priced_Product_Chart]
        };

        var chartOptions = {
        scaleShowGridLines : true,
        scaleGridLineColor : "rgba(0,0,0,.05)",
        scaleGridLineWidth : 1,
        scaleShowHorizontalLines: true,
        scaleShowVerticalLines: true,
        pointDot : true,
        pointDotRadius : 4,
        pointDotStrokeWidth : 1,
        pointHitDetectionRadius : 20,
        datasetStroke : true,
        datasetStrokeWidth : 2,
        datasetFill : true,
        legendTemplate : "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].strokeColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>",
         tooltips: {
            mode: 'index',
            intersect: false
         },
         hover: {
            mode: 'index',
            intersect: false
         }
        };

        var lineChart = new Chart(Top_Priced_Product_Chart_Canvas, {
        type: 'line',
        data: Top_Priced_Product_Chart_Canvas_Data,
        options: chartOptions
        });

        }, function myError(response) {
            console.log(response.data);
        });

        //End of Top Priced Product Per Category Chart

        //Top Quantity of Products Per Category with Chart

        $http({
            method : "GET",
            url : 'routes/Top_Quantity_Category_Product',
        }).then(function mySuccess(response) {
            top_quantity_category_product = response.data[0];
            top_quantity_category_quantity = response.data[1];
            console.log(top_quantity_category_product,top_quantity_category_quantity);

        var Top_Produce_Product_Chart_Canvas = document.getElementById("pie_chart1");

        var Top_Priced_Product_Chart = {
            label: "Top Produce per Category Chart",
            data: top_quantity_category_quantity,
            borderColor: '#ad8b34',
            fill: true,
            pointBorderWidth: 2,
            pointBorderColor: '#ad8b34',
            pointBackgroundColor: '#fff',
            pointRadius: 4,
            lineTension: 0,
        };

        var Top_Produce_Product_Chart_Canvas_Data = {
            labels: top_quantity_category_product,
            datasets: [Top_Priced_Product_Chart]
        };

        var chartOptions = {
            scaleShowGridLines : true,
            scaleGridLineColor : "rgba(0,0,0,.05)",
            scaleGridLineWidth : 1,
            scaleShowHorizontalLines: true,
            scaleShowVerticalLines: true,
            pointDot : true,
            pointDotRadius : 4,
            pointDotStrokeWidth : 1,
            pointHitDetectionRadius : 20,
            datasetStroke : true,
            datasetStrokeWidth : 2,
            datasetFill : true,
            legendTemplate : "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].strokeColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>",
             tooltips: {
                mode: 'index',
                intersect: false
             },
             hover: {
                mode: 'index',
                intersect: false
             }
        };

        var lineChart = new Chart(Top_Produce_Product_Chart_Canvas, {
            type: 'line',
            data: Top_Produce_Product_Chart_Canvas_Data,
            options: chartOptions
        });

        var size = top_quantity_category_quantity.length;
        var i=0;
        var a=0;
        for(i=0;i<size;i++){
            var temp =0;
            var name;
            for(a=i+1;a<size;a++){
                if(top_quantity_category_quantity[i]<=top_quantity_category_quantity[a]){
                    temp = top_quantity_category_quantity[i];
                    name = top_quantity_category_product[i];
                    
                    top_quantity_category_quantity[i] = top_quantity_category_quantity[a];
                    top_quantity_category_product[i] = top_quantity_category_product[a];

                    top_quantity_category_product[a] = name;
                    top_quantity_category_quantity[a] = temp;
                }
            }
        }

        $scope.top_quantity_category_product = top_quantity_category_product;
        $scope.top_quantity_category_quantity = top_quantity_category_quantity;
            console.log($scope.top_quantity_category_product);
        }, function myError(response) {
         
        });
        //End of Top Quantity of Products Per Category with chart


       
       

        // Chart for Top Requested Products with Display
        $http({
            method : "GET",
            url : 'routes/Top_Requested_Products_Chart',
        }).then(function mySuccess(response) {

            // console.log(response.data);
            var requested_product_name = response.data[0];
            var requested_product_quantity = response.data[1];
            console.log(requested_product_name,requested_product_quantity);

            $(function () {
            // START FOR CHART.JS

        var Top_Produce_Product_Chart_Canvas = document.getElementById("doughnut_chart");

        var Top_Priced_Product_Chart = {
            label: "Top Produce per Category Chart",
            data: requested_product_quantity,
            borderColor: '#af4528',
            fill: true,
            pointBorderWidth: 2,
            pointBorderColor: '#af4528',
            pointBackgroundColor: '#fff',
            pointRadius: 4,
            lineTension: 0,
        };

        var Top_Produce_Product_Chart_Canvas_Data = {
            labels: requested_product_name,
            datasets: [Top_Priced_Product_Chart]
        };

        var chartOptions = {
            scaleShowGridLines : true,
            scaleGridLineColor : "rgba(0,0,0,.05)",
            scaleGridLineWidth : 1,
            scaleShowHorizontalLines: true,
            scaleShowVerticalLines: true,
            pointDot : true,
            pointDotRadius : 4,
            pointDotStrokeWidth : 1,
            pointHitDetectionRadius : 20,
            datasetStroke : true,
            datasetStrokeWidth : 2,
            datasetFill : true,
            legendTemplate : "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].strokeColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>",
             tooltips: {
                mode: 'index',
                intersect: false
             },
             hover: {
                mode: 'index',
                intersect: false
             }
        };

        var lineChart = new Chart(Top_Produce_Product_Chart_Canvas, {
            type: 'line',
            data: Top_Produce_Product_Chart_Canvas_Data,
            options: chartOptions
        });

            // END FOR CHART.JS
        });
            // console.log(requested_product_name,requested_product_quantity);
            var size = requested_product_quantity.length;
            var i=0;
            var a=0;
            for(i=0;i<size;i++){
                var temp =0;
                var name;
                for(a=i+1;a<size;a++){
                    if(requested_product_quantity[i]<=requested_product_quantity[a]){
                        temp = requested_product_quantity[i];
                        name = requested_product_name[i];
                        
                        requested_product_quantity[i] = requested_product_quantity[a];
                        requested_product_name[i] = requested_product_name[a];

                        requested_product_name[a] = name;
                        requested_product_quantity[a] = temp;
                    }
                }
            }
            console.log(requested_product_name,requested_product_quantity);
            $scope.requested_product_name = requested_product_name;
            $scope.requested_product_quantity = requested_product_quantity;

        }, function myError(response) {
         
        });

    //End of Chart for Top Requested Product with Display
    }

    $scope.My_Products = function(){
        // RE INITIALIZED OTHER VARIABLES
        $scope.If_Dashboard = false;
        $scope.If_Customer_Requests = false;
        $scope.If_Market_Statistics = false;
        $scope.If_View_My_Mroduct_Orders = false;
        $scope.If_Make_Bid = false;
        $scope.If_Bids_Requests = false;
        $scope.If_Accepted_Bids = false;
        $scope.If_Calendar = false;
        // RE INITIALIZED OTHER VARIABLES
        
        $scope.If_My_Products = true;
        $scope.View_List_Of_Products();
    }

    $scope.View_My_Product_Orders = function(Posted_Product_Id){

        console.log(Posted_Product_Id);
        // RE INITIALIZED OTHER VARIABLES
        $scope.If_Dashboard = false;
        $scope.If_Calendar = false;
        $scope.If_Customer_Requests = false;
        $scope.If_Market_Statistics = false;
        $scope.If_My_Products = false;
        $scope.If_Make_Bid = false;
        $scope.If_Bids_Requests = false;
        $scope.If_Accepted_Bids = false;
        // RE INITIALIZED OTHER VARIABLES
        
        $scope.If_View_My_Mroduct_Orders = true;

        $http({
            method : "GET",
            url : 'routes/Get_View_Product_Orders_With_Receipt/'+Posted_Product_Id,
        }).then(function mySuccess(response) {
             console.log(response.data);
             $scope.Product_Orders_With_Receipt = response.data;

            for(var x = 0; x < $scope.Product_Orders_With_Receipt[0].purchased_products.length; x++){
                $scope.Product_Orders_With_Receipt[0].purchased_products[x].updated_at = $scope.parse_date($scope.Product_Orders_With_Receipt[0].purchased_products[x].updated_at);
            }
        }, function myError(response) {
         
        });
    }

    $scope.Make_Bid = function(){
        // RE INITIALIZED OTHER VARIABLES
        $scope.If_To_Shrink = true;

        $( ".img_div" ).animate({
            opacity: 0.8,
            height: 200,
        }, 500, function() {
            
            $('.to_be_shrink').addClass('shrink');
        // Animation complete.
        });
        $scope.If_Make_Bid = true;
    }

    $scope.Make_Bid_Back_Btn = function(){
        $scope.If_Make_Bid = false;
        $scope.If_To_Shrink = false;

        $( ".img_div" ).animate({
            opacity: 0.8,
            height: 276,
        }, 800, function() {
            console.log('s');
            $('.to_be_shrink').addClass('shrink');
        // Animation complete.
        });
    }

    $scope.Make_Bid_Close_Btn = function(){
        // $scope.If_Dashboard = false;
        // $scope.If_Market_Statistics = false;
        // $scope.If_My_Products = false;
        // $scope.If_View_My_Mroduct_Orders = false;
        // $scope.If_Make_Bid = false;
        // $scope.If_Make_Bid_checkbox = false;
        // $scope.If_Bids_Requests = false;
        // $scope.If_Accepted_Bids = false;
    }

    // PRODUCT PICTURE
    $scope.fileChanged = function(element){
        console.log(index);
        $scope.product_pictures = element.files
        $scope.uptfile = element.files
        $scope.$apply();        
        
        var validCVFiles = ["png","jpeg","jpg",];
        var name  = $scope.file[0].name;
        var fileType = name.substr(name.indexOf(".")+1)

        console.log($scope.file);
    }
    /** upload multiple files using FILEPOND -JP **/

    // First register any plugins
    $.fn.filepond.registerPlugin(
        // encodes the file as base64 data
        FilePondPluginFileEncode,

        FilePondPluginFileValidateSize,

        // corrects mobile image orientation
        FilePondPluginImageExifOrientation,

        // previews dropped images
        FilePondPluginImagePreview
    );

    $.fn.filepond.setDefaults({
        maxFileSize: '3MB',
    });

    // Turn input element into a pond
    $('.my-pond').filepond();

    $('.my-pond').filepond({
        labelIdle: "Drag & Drop your files or <span class='filepond--label-action'> Browse </span> <br> <span class='text-info'>Note: Only a maximum of 3 images are to be uploaded.</span>",
        maxFiles: 3,
    })

    // Set allowMultiple property to true
    $('.my-pond').filepond('allowMultiple', true);
    $scope.product_pictures = [];
    // $scope.counter = 0;
    $('.my-pond').on('FilePond:addfile', function(e) {
        $scope.product_pictures.push(e.detail.file.file);
        
    });

    $('.my-pond').on('FilePond:removefile', function(e) {
        $scope.product_pictures.splice(0,1);
        console.log('REMOVED', e.detail.file.file);
    });
    /** upload multiple files using FILEPOND -JP **/

    // PRODUCT PICTURE

    //Post Product
    $scope.getTotal = function(){
        $scope.Posted_Farmer_Product_Total = $scope.Posted_Farmer_Product_Price * $scope.Posted_Farmer_Product_Volume;
    }
    $scope.Selected_Volume_Type = function(type){
        if(type==1){
            $scope.Selected_Type = "Tons";
        }
        else if(type==2){
             $scope.Selected_Type = "Kilo";
        }
        else if(type==3){
             $scope.Selected_Type = "Piece";
        }else if(type==4){
             $scope.Selected_Type = "Bundle";
        }
    }

    //Post Product
    $scope.Post_Product = function(){
        if($scope.Posted_Product_Harvest_Type == 1){
            $http({
                method : "POST",
                url : '/farmer/routes/Post_Product',
                data: {},
                headers: { 'Content-Type': undefined},
                transformRequest: function(data) {
                    var formData = new FormData();
                    formData.append("Posted_Product_Harvest_Type", $scope.Posted_Product_Harvest_Type);
                    formData.append("Posted_Farmer_Product_Category", $scope.Posted_Farmer_Product_Category);
                    formData.append("Posted_Farmer_Product_Name", $scope.Posted_Farmer_Product_Name);
                    formData.append("Posted_Farmer_Description", $scope.Posted_Farmer_Description);
                    formData.append("Posted_Farmer_Product_Deadline", $scope.Posted_Farmer_Product_Deadline);
                    formData.append("Posted_Farmer_Product_Volume", $scope.Posted_Farmer_Product_Volume);
                    formData.append("Posted_Farmer_Product_Volume_Type", $scope.Posted_Farmer_Product_Volume_Type);
                    formData.append("Posted_Farmer_Product_Price", $scope.Posted_Farmer_Product_Price);
                    formData.append("Posted_Farmer_Product_Total", $scope.Posted_Farmer_Product_Total);
                    formData.append("Minimum_Order_Quantity", $scope.Minimum_Order_Quantity);
                    for (var i = 0; i < $scope.product_pictures.length; i++) {
                        formData.append('file[' + i+']', $scope.product_pictures[i]);
                        // console.log($scope.file_dr)
                      }
                    return formData;
                },
            }).then(function mySuccess(response) {
                    $scope.Posted_Product_Harvest_Type = "";
                    $scope.Posted_Farmer_Product_Category = "";
                    $scope.Posted_Farmer_Product_Name = "";
                    $scope.Posted_Farmer_Description = "";
                    $scope.Posted_Farmer_Product_Deadline = "";
                    $scope.Posted_Farmer_Product_Volume = "";
                    $scope.Posted_Farmer_Product_Volume_Type = "";
                    $scope.Posted_Farmer_Product_Price = "";
                    $scope.Posted_Farmer_Product_Total = "";
                    $scope.Minimum_Order_Quantity = "";

                if(response.data == "success"){
                    $('.modal').modal('hide');
                    swal({
                        title: "Yahoo!",
                        text: "You have successfuly posted a product!",
                        icon: "success",
                        buttons: {
                            cancel: "Okay",
                        },
                    }).then(function(){
                        $scope.View_List_Of_Products();
                        $('.my-pond').removefile();
                        // $scope.product_pictures = [];
                        // $scope.product_pictures.length = 0;
                    });
                }else
                    swal({
                        title: "Sorry!",
                        text: "An error has occured, Please try adding a product again.",
                        icon: "error",
                        buttons: {
                            cancel: "Okay",
                        },
                    }).then(function(){
                    });
                ;

            }, function myError(response) {
                console.log(response);
            });
        }else if($scope.Posted_Product_Harvest_Type == 2){

            var Date1 = js_yyyy_mm_dd_hh_mm_ss($scope.Date1);
            var Date2 = js_yyyy_mm_dd_hh_mm_ss($scope.Date2);

            console.log(Date1);
            console.log(Date2);

            $http({
                method : "POST",
                url : '/farmer/routes/Post_Product',
                data: {},
                headers: { 'Content-Type': undefined},
                transformRequest: function(data) {
                    var formData = new FormData();
                    formData.append("Posted_Product_Harvest_Type", $scope.Posted_Product_Harvest_Type);
                    formData.append("Posted_Farmer_Product_Category", $scope.Posted_Farmer_Product_Category);
                    formData.append("Posted_Farmer_Product_Name", $scope.Posted_Farmer_Product_Name);
                    formData.append("Posted_Farmer_Description", $scope.Posted_Farmer_Description);
                    formData.append("Expected_Deadline_From", Date1);
                    formData.append("Expected_Deadline_To", Date2);
                    formData.append("Posted_Farmer_Product_Volume", $scope.Posted_Farmer_Product_Volume);
                    formData.append("Posted_Farmer_Product_Volume_Type", $scope.Posted_Farmer_Product_Volume_Type);
                    formData.append("Posted_Farmer_Product_Price", $scope.Posted_Farmer_Product_Price);
                    formData.append("Posted_Farmer_Product_Total", $scope.Posted_Farmer_Product_Total);
                    formData.append("Minimum_Order_Quantity", $scope.Minimum_Order_Quantity);
                    for (var i = 0; i < $scope.product_pictures.length; i++) {
                        formData.append('file[' + i+']', $scope.product_pictures[i]);
                        // console.log($scope.file_dr)
                      }
                    return formData;
                },
            }).then(function mySuccess(response) {
                    $scope.Posted_Product_Harvest_Type = "";
                    $scope.Posted_Farmer_Product_Category = "";
                    $scope.Posted_Farmer_Product_Name = "";
                    $scope.Posted_Farmer_Description = "";
                    $scope.Posted_Farmer_Product_Deadline = "";
                    $scope.Posted_Farmer_Product_Volume = "";
                    $scope.Posted_Farmer_Product_Volume_Type = "";
                    $scope.Posted_Farmer_Product_Price = "";
                    $scope.Posted_Farmer_Product_Total = "";
                    $scope.Minimum_Order_Quantity = "";

                if(response.data == "success"){
                    $('.modal').modal('hide');
                    swal({
                        title: "Yahoo!",
                        text: "You have successfuly posted a product!",
                        icon: "success",
                        buttons: {
                            cancel: "Okay",
                        },
                    }).then(function(){
                        $scope.View_List_Of_Products();
                        $('.my-pond').removefile();
                        // $scope.product_pictures = [];
                        // $scope.product_pictures.length = 0;
                    });
                }else
                    swal({
                        title: "Sorry!",
                        text: "An error has occured, Please try adding a product again.",
                        icon: "error",
                        buttons: {
                            cancel: "Okay",
                        },
                    }).then(function(){
                    });
                ;

            }, function myError(response) {
                console.log(response);
            });
        }else;
    }

    // Viewing of Products List
    $scope.list_prompt = false;
    $scope.pageSize = 3;
    $scope.gap = 3;
    $scope.currentPage = 0;

    $scope.View_List_Of_Products = function(){

        $http({
            method : "GET",
            url : 'routes/Product_Farmer_List',
        }).then(function mySuccess(response) {
            console.log(response.data);
            $scope.Product_Farmer_List = response.data;
            $scope.Product_Count = $scope.Product_Farmer_List.length;

            if($scope.Product_Farmer_List.length > 0){
                $scope.list_prompt = true;
            }else;

            for(var x = 0; x < $scope.Product_Farmer_List.length; x++){
                $scope.Product_Farmer_List[x].created_at = $scope.parse_date($scope.Product_Farmer_List[x].created_at);
            }

        }, function myError(response) {
         
        });
    }

    $scope.View_Specific_Product_Detail = function(List){
        console.log(List);
        $scope.Specific_Product_Detail = List;
    }

    //View of Products List


});


app.controller('Consumer_Controller', function($scope,$http) {
    console.log("Consumer_Controller");
    // INITIALIZE VARIABLES
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "preventDuplicates": false,
        "positionClass": "toast-bottom-left",
        "onclick": null,
        "fadeIn": 5000,
        "fadeOut": 5000,
        "timeOut": 5000,
        "extendedTimeOut": 5000
    }

    var user_id = $('#user_id').html();
    $scope.user_id = $('#user_id').html();
    var socket = io.connect('http://localhost:3001');

    socket.emit("NewConsumer", user_id, function(user_id, callback){
        if (user_id) {
            console.log('true');
        }else{
            console.log('false');
        }
    });

    socket.on("Making_A_Bid_To_Consumer_Request", function(data){
        console.log(data.event[1][0].Requested_Product_Name);
        console.log(data.event[2][0].F_Name);
        toastr.info("Submitted a bid to your request <br/> <b class='text-success'> <i class='fa fa-bullhorn'></i> "+data.event[1][0].Requested_Product_Name+"<b>", data.event[2][0].F_Name +' '+data.event[2][0].L_Name);
        
        $scope.Get_My_Notification();
    });

    socket.on("Issue_An_Official_Receipt", function(data){
        // receiver will be buyer user_id
        console.log(data.event[0][0].User_Id);
        // Envolved_Table_Id_Receiver
        console.log(data.event[2][0].Purchase_Product_Id);
        $scope.Get_Confirm_Item_Delivery();
        // $scope.Get_My_Notification();
    });

    $scope.If_Dashboard = true;
    $scope.If_Market_Place = false;
    $scope.If_Approved_Requests = false;
    $scope.If_My_Requests = false;
    $scope.If_View_All_Bidders_In_Request = false;
    $scope.If_Confirm_Checkbox = false;
    $scope.If_View_My_Cart = false;
    $scope.If_Payment_Method;
    // INITIALIZE VARIABLES

    $scope.parse_date = function(date){
        date = new Date(Date.parse(date));
        return date;
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

    // Retrieving profile info
    $scope.Get_Profile = function(user_id){
        $http({
            method : "GET",
            url : 'routes/Get_Profile/'+user_id,
        }).then(function mySuccess(response) {
            console.log(response.data);
            $scope.profile_F_Name = response.data[0].F_Name;
            $scope.profile_M_Name = response.data[0].M_Name;
            $scope.profile_L_Name = response.data[0].L_Name;
            $scope.profile_Email = response.data[0].Email;
            $scope.profile_Contact_Number = response.data[0].Contact_Number;
        }, function myError(response) {

        });
    }
    $scope.Get_Profile(user_id);

    $scope.Get_Best_Sellers = function(){
        $http({
            method : "GET",
            url : 'routes/Get_Best_Sellers',
        }).then(function mySuccess(response) {
            console.log(response.data);
            $scope.Best_Sellers = response.data;

            for(var x = 0; x < $scope.Best_Sellers.length; x++){
                $scope.Best_Sellers[x].harvest_span.Expected_Deadline_From = $scope.parse_date($scope.Best_Sellers[x].harvest_span.Expected_Deadline_From);
                $scope.Best_Sellers[x].harvest_span.Expected_Deadline_To = $scope.parse_date($scope.Best_Sellers[x].harvest_span.Expected_Deadline_To);
            }
        }, function myError(response) {
            $scope.Get_Best_Sellers();
        });
    }
    $scope.Get_Best_Sellers();

    $scope.Get_Fresh_Vegetables = function(){
        $http({
            method : "GET",
            url : 'routes/Get_Fresh_Vegetables',
        }).then(function mySuccess(response) {
            console.log(response.data);
            $scope.Fresh_Vegetables = response.data;

            for(var x = 0; x < $scope.Fresh_Vegetables.length; x++){
                $scope.Fresh_Vegetables[x].harvest_span.Expected_Deadline_From = $scope.parse_date($scope.Fresh_Vegetables[x].harvest_span.Expected_Deadline_From);
                $scope.Fresh_Vegetables[x].harvest_span.Expected_Deadline_To = $scope.parse_date($scope.Fresh_Vegetables[x].harvest_span.Expected_Deadline_To);
            }

        }, function myError(response) {
            $scope.Get_Fresh_Vegetables();
        });
    }
    $scope.Get_Fresh_Vegetables();

    $scope.Get_Fresh_Fruits = function(){
        $http({
            method : "GET",
            url : 'routes/Get_Fresh_Fruits',
        }).then(function mySuccess(response) {
            console.log(response.data);
            $scope.Fresh_Fruits = response.data;

            for(var x = 0; x < $scope.Fresh_Fruits.length; x++){
                $scope.Fresh_Fruits[x].harvest_span.Expected_Deadline_From = $scope.parse_date($scope.Fresh_Fruits[x].harvest_span.Expected_Deadline_From);
                $scope.Fresh_Fruits[x].harvest_span.Expected_Deadline_To = $scope.parse_date($scope.Fresh_Fruits[x].harvest_span.Expected_Deadline_To);
            }

        }, function myError(response) {
            $scope.Get_Fresh_Fruits();
        });
    }
    $scope.Get_Fresh_Fruits();

    $scope.Get_My_Notification = function(){
        $http({
            method : "GET",
            url : 'routes/Get_Notification',
        }).then(function mySuccess(response) {
            console.log(response.data);
            $scope.notif_data = response.data;
            $scope.notif_length = 0;
            for(var x = 0; x < $scope.notif_data.length; x++){
                $scope.notif_length = $scope.notif_length + $scope.notif_data[x].saved_events.length;
            }
            console.log($scope.notif_length);
            $scope.Call_List_Of_Requests();
        }, function myError(response) {
            $scope.Get_My_Notification();
        });
    }
    $scope.Get_My_Notification();

    $scope.Update_My_Notifications = function(ID){
        console.log(ID);
        $http({
            method : "GET",
            url : 'routes/Update_Event/'+ID,
        }).then(function mySuccess(response) {
            $scope.Get_My_Notification();
        }, function myError(response) {

        });
    }

    // Native JQUERY FUNCTIONS
    $(window).on('load resize', function(){
      if($('.navbar-toggler').is(':visible')){
         // hide search
         $('input#search').attr('hidden','hidden');
         $('input#search2').removeAttr('hidden','hidden');
         $('.navbar-brand').css('border-right','none');
         $('.sidenav').css('z-index','1');
         $('#everyones_footer').css('z-index','2');
         $('#everyones_footer').css('margin-left','0px');
         $scope.closeNav();
      }else{
         $('.navbar-brand').css('border-right','solid 2px #28a745');
         $('input#search').removeAttr('hidden','hidden');
         $('input#search2').attr('hidden','hidden');
         $('input#search2').css('width','100%');
         $scope.openNav();
      };
    });


    $scope.collapse_button_1 = function(){
      $('#collapse_button_1').attr('hidden','hidden');
      $('#collapse_button_2').removeAttr('hidden','hidden');
       $scope.openNav();
    }

    $scope.collapse_button_2 = function(){
      $('#collapse_button_1').removeAttr('hidden','hidden');
      $('#collapse_button_2').attr('hidden','hidden');
      $('#everyones_footer').css('margin-left','0px');
       $scope.closeNav();
    }

    $scope.openNav = function(){
      $('.sidenav').css('overflow','visible');
      $("#mySidenav").css('width', '150px');
      $(".main_dashboard_and_market").css('margin-left', '150px');
      $('#everyones_footer').css('margin-left','150px');
    }
    $scope.openNav();

    $scope.closeNav = function(){
      $('.sidenav').css('overflow','hidden');
      $("#mySidenav").css('width', '0');
      $(".main_dashboard_and_market").css('margin-left', '0');
      $('#everyones_footer').css('margin-left','0px');
    }
    // Native JQUERY FUNCTIONS

    $scope.My_Requests = function(){
    // // Close Navbar
    // $(".collapse").collapse('hide');
    //     $scope.If_Market_Place = false;
    //     $scope.If_Approved_Requests = false;
    //     $scope.If_View_All_Bidders_In_Request = false;
    //     $scope.If_View_My_Cart = false;
    //     $scope.If_Dashboard = false;

    //     $scope.If_My_Requests = true;
    //     $scope.View_List_Of_Request();
    }

    $scope.View_All_Bidders_In_Request = function(product,qty,uom,bidders){
        $scope.closeNav();

        $scope.If_Market_Place = false;
        $scope.If_Approved_Requests = false;
        $scope.If_My_Requests = false;
        $scope.If_View_My_Cart = false;
        $scope.If_Dashboard = false;

        $scope.If_View_All_Bidders_In_Request = true;
        $scope.List_Of_Bidders = bidders;

        $scope.List_Of_Bidders_product = product;
        $scope.List_Of_Bidders_qty = qty;
        $scope.List_Of_Bidders_uom = uom;
        for(var x = 0; x < $scope.List_Of_Bidders.length; x++){
            $scope.List_Of_Bidders[x].created_at = $scope.parse_date($scope.List_Of_Bidders[x].created_at);
        }

        // console.log($scope.List_Of_Bidders[0].farmer_info.profile_picture.Profile_Picture_Id);
    }

    $scope.View_Specific_Bidders_In_Request= function(bidders,List_Of_Bidders_qty,List_Of_Bidders_uom){
        console.log(bidders);
        $scope.bidders_detail = bidders;
        // console.log($scope.bidders_Total_Ammount);

        $scope.bidders_detail.Farmer_Delivery_Date = $scope.parse_date($scope.bidders_detail.Farmer_Delivery_Date);

        $scope.List_Of_Specific_Bidders_qty = List_Of_Bidders_qty;
        $scope.List_Of_Specific_Bidders_uom = List_Of_Bidders_uom;
    }

    // Accept bids
    $scope.Accept_A_Bid = function(Farmer_Bids_Id,Requested_Product_Id){
        var data = {
            Farmer_Bids_Id:Farmer_Bids_Id,
            Requested_Product_Id:Requested_Product_Id,
        }

        $http({
            method : "POST",
            url : 'routes/Accept_Bid',
            data: data,
        }).then(function mySuccess(response) {
            console.log(response.data);

            if(response.data == "bid_accepted"){
                swal({
                    title: "Yahoo!",
                    text: "You have successfuly accepted a bid!",
                    icon: "success",
                    buttons: {
                        cancel: "View Details",
                    },
                }).then(function(){
                    $('.modal').modal('hide');
                    $scope.Recievables();
                });
            }else;
        }, function myError(response) {
         
        });

    }
    
    //Displaying Products in the market place
    $scope.Market_Place = function(category){
    $scope.If_Approved_Requests = false;
    $scope.If_My_Requests = false;
    $scope.If_View_All_Bidders_In_Request = false;
    $scope.If_View_My_Cart = false;
    $scope.If_Dashboard = false;

    $scope.If_Market_Place = true;

    $('html,body').animate({ scrollTop: 0}, 'slow');
    
    //Get Categories BY Category
    $http.get('routes/Get_Product_Categories/'+category,{})
    .then(function mySuccess(response) {
        console.log(response.data);
        $scope.Market_Place_List = response.data;

        for(var x = 0; x < $scope.Market_Place_List.length; x++){
            if($scope.Market_Place_List[x].harvest_span != null){
                $scope.Market_Place_List[x].harvest_span.Expected_Deadline_From = $scope.parse_date($scope.Market_Place_List[x].harvest_span.Expected_Deadline_From);
                $scope.Market_Place_List[x].harvest_span.Expected_Deadline_To = $scope.parse_date($scope.Market_Place_List[x].harvest_span.Expected_Deadline_To);
            }else;
        }

        if($('.navbar-toggler').is(':visible')){
            $scope.collapse_button_2();
        }else{
            $('.main_dashboard_and_market').css('margin-left','150px');
        };

    }, function myError(response) {

    });

    }

    $scope.Specific_Product_Detail = function (List){
        $scope.Product_Detail = List;
        console.log($scope.Product_Detail);
    }
    //END

    $scope.Recievables = function(){
    // Close Navbar
    $(".collapse").collapse('hide');
    $scope.If_Market_Place = false;
    $scope.If_My_Requests = false;
    $scope.If_View_All_Bidders_In_Request = false;
    $scope.If_View_My_Cart = false;
    $scope.If_Dashboard = false;
    
    $scope.If_Approved_Requests = true;

    $scope.View_All_Recievables('1');

    }

    $scope.View_All_Recievables = function(recievable_type){
        $http({
            method : "GET",
            url : 'routes/View_All_Recievables/'+'1',
        }).then(function mySuccess(response) {                
            $('html,body').animate({ scrollTop: 0}, 'slow');
            if($('.navbar-toggler').is(':visible')){
                $scope.collapse_button_2();
            }else{
                $scope.openNav();
                $('.main_dashboard_and_market').css('margin-left','150px');
            };
            $scope.Ordered_Products_Count_Array = [];
            $scope.Ordered_Products_History = [];

            $scope.Recievable_List_Ordered_Products = response.data;
            console.log($scope.Recievable_List_Ordered_Products);
            for(var x = 0; x < $scope.Recievable_List_Ordered_Products.length; x++){
                for(var y = 0; y < $scope.Recievable_List_Ordered_Products[x].purchased_products.length; y++){
                    $scope.Ordered_Products_History.push($scope.Recievable_List_Ordered_Products[x].purchased_products[y])

                    if($scope.Recievable_List_Ordered_Products[x].purchased_products[y].official_receipt == null){
                        $scope.Ordered_Products_Count_Array.push($scope.Recievable_List_Ordered_Products[x].purchased_products[y].official_receipt)
                    }else;

                }
            }

            $scope.Ordered_Products_Count = $scope.Ordered_Products_Count_Array.length;

        }, function myError(response) {
         
        });
    }
    $scope.View_All_Recievables('1');

    $scope.View_Specific_Recievables = function(Specific_Recievable_Detail){
        console.log(Specific_Recievable_Detail);
        $scope.Specific_Recievable_Detail = Specific_Recievable_Detail;
        $scope.Specific_Recievable_Detail.farmer_bids[0].Farmer_Delivery_Date = $scope.parse_date($scope.Specific_Recievable_Detail.farmer_bids[0].Farmer_Delivery_Date);
    }

    $scope.View_Specific_Recievables_Ordered = function(Specific_Recievables_Ordered){
        $scope.Specific_Recievables_Ordered = Specific_Recievables_Ordered;
        console.log($scope.Specific_Recievables_Ordered);
        console.log($scope.Specific_Recievables_Ordered.posted_product[0].farmer_info.F_Name);
        console.log($scope.Specific_Recievables_Ordered.posted_product[0].product_image);
    }

    //Post Requests
    $scope.Post_Request = function(){
        console.log($scope.region);

       var date = js_yyyy_mm_dd_hh_mm_ss($scope.Requested_Product_Prefered_Delivery_Date);

        var data = {
            Region_Id:$scope.region,
            Province_Id:$scope.province,
            Municipal_Id:$scope.city_municipality,
            Brgy_Id: $scope.brgy,
            Purok: $scope.purok,
            Specific_Address: $scope.specific_address,
            Requested_Product_Category:$scope.Requested_Product_Category,
            Requested_Product_Name:$scope.Requested_Product_Name,
            Requested_Product_Volume:$scope.Requested_Product_Volume,
            Posted_Farmer_Product_Volume_Type:$scope.Posted_Farmer_Product_Volume_Type,
            Requested_Product_Prefered_Starting_Price:$scope.Requested_Product_Prefered_Starting_Price,
            Requested_Product_Amount_Payable:$scope.Requested_Product_Amount_Payable,
            Requested_Product_Prefered_Delivery_Date:date,
        }
        console.log(data);

        $http({
            method : "POST",
            url : 'routes/Post_Request',
            data: data,
        }).then(function mySuccess(response) {
            console.log(response.data);
            $scope.Requested_Product_Category = "";
            $scope.Requested_Product_Name = "";
            $scope.Requested_Product_Volume = "";
            $scope.Posted_Farmer_Product_Volume_Type = "";
            $scope.Requested_Product_Prefered_Starting_Price = "";
            $scope.Requested_Product_Amount_Payable = "";
            $scope.Requested_Product_Prefered_Delivery_Date = "";
            $scope.region = "";
            $scope.province = "";
            $scope.city_municipality = "";
            $scope.brgy = "";
            $scope.purok = "";
            $scope.specific_address = "";

            swal({
                title: "Yahoo!",
                text: "You have successfuly posted a request!",
                icon: "success",
                    buttons: {
                    cancel: "Okay",
                },
            }).then(function(){
                $('.modal').modal('hide');
                $scope.View_List_Of_Request();
            });
        }, function myError(response) {
         
        });
    }

    $scope.getTotal = function(){
        $scope.Requested_Product_Amount_Payable = $scope.Requested_Product_Prefered_Starting_Price * $scope.Requested_Product_Volume;
    }
    //Post Request

    //Viewing of Requests
    $scope.View_List_Of_Request = function(){
        // $http({
        //     method : "GET",
        //     url : 'routes/Request_Buyer_List',
        // }).then(function mySuccess(response) {
        //     console.log(response.data);

        //     $('html,body').animate({ scrollTop: 0}, 'slow');

        //     if($('.navbar-toggler').is(':visible')){
        //         $scope.collapse_button_2();
        //     }else{
        //         $scope.openNav();
        //         $('.main_dashboard_and_market').css('margin-left','150px');
        //     };

        //     $scope.Request_Buyer_List = response.data;

        //     for(var x = 0; x < $scope.Request_Buyer_List.length; x++){
        //         $scope.Request_Buyer_List[x].created_at = $scope.parse_date($scope.Request_Buyer_List[x].created_at);
        //     }

        //     $scope.Get_My_Notification();
        // }, function myError(response) {
         
        // });
    }

    $scope.View_Specific_Request_Detail = function(List){
        $scope.Specific_Request_Detail = List;
    }
    //Viewing of Requests

    // Tawagon ni $scope.Get_My_Notification para ma update ang values sa nag bids sa specific nga request
    // PS SAME OF FUNCTION SA $scope.View_List_Of_Request
    $scope.Call_List_Of_Requests = function(){
        $http({
            method : "GET",
            url : 'routes/Request_Buyer_List',
        }).then(function mySuccess(response) {
            $scope.Request_Buyer_List = response.data;
            for(var x = 0; x < $scope.Request_Buyer_List.length; x++){
                $scope.Request_Buyer_List[x].created_at = $scope.parse_date($scope.Request_Buyer_List[x].created_at);
            }
        }, function myError(response) {});
    }

    //Auto Fill
    $scope.Auto_Search = function(category,product){
        console.log(category,product);
        $scope.suggestion_product = false;
        if(product == ''){
            $scope.suggestion_product = true;
        }
        var data={
            Product_Category_Id:category,Product_Name:product
        }
        $http({
            method :"POST",
            url : 'routes/Auto_Search_Product',
            data: data
        }).then(function mySuccess(response) {
            $scope.filter_product = response.data;
            console.log($scope.filter_product);

        }, function myError(response) {});

    }

        //Display sa Suggestions
        $scope.Suggestions = function(){

    }
    //END Auto Fill

    //Display sa Suggestions
        $scope.Suggestions = function(category,product){

            $scope.suggestion_product = false;
            $scope.filter_product = "";
            var data={
            Product_Category_Id:category,Product_Name:product
        }
        $http({
            method :"POST",
            url : 'routes/Auto_Search_Product',
            data: data
        }).then(function mySuccess(response) {
            $scope.filter_product = response.data;
            console.log($scope.filter_product);
        }, function myError(response) {
            
        });

        }

    //END Display sa Suggestions

    ///Search from Suggestions
    $scope.Fill_Search_Box = function(suggest_product,category){
        $scope.replace_search = suggest_product;
        $scope.suggestion_product = true;

        console.log($scope.search_bar);
        $scope.Search_Product(category,suggest_product);
    }

    ///END Search from Suggestions


    //Search Products
    $scope.Search_Product = function(category,product){
        console.log(category,product);
        var data={
            Product_Category_Id:category,Product_Name:product
        }
        $http({
            method :"POST",
            url : 'routes/Search_Product',
            data: data
        }).then(function mySuccess(response) {
            $scope.Market_Place_List = response.data;
        }, function myError(response) {
            // console.log(response);
        });

    }

    ///Display By Category
    $scope.Sort_Category = function (category){
        //Add Condition For Viewing All Products Category
        if(category == 0){
            $scope.Market_Place();

        }
        else{
            var data= {
                    Product_Category_Id:category
                }
            $http({
                method :"POST",
                url : 'routes/Sort_Category',
                data: data
            }).then(function mySuccess(response) {
                $scope.Market_Place_List = response.data;
                console.log(response.data);
                $scope.suggestion_product = true;
            }, function myError(response) {
                // console.log(response);
            });
        }
    }
    //END Search Products
    ///Display By Category

    // Adding to Cart
    $scope.Add_To_Cart = function(Product_Detail){
        console.log(Product_Detail.Posted_Product_Id);
        
        var data = {
            Product_Id:Product_Detail.Posted_Product_Id,
            Qty_Purchased:Product_Detail.Minimum_Order_Qty,
        }
        swal({
            title: "You are adding this product to cart!",
            text: "Please click confirm to add this product to your cart",
            icon: "info",
          buttons: {
            cancel: true,
            confirm: "Confirm",
          },
          closeOnClickOutside: false,
        }).then(function(isConfirm){
            if(isConfirm){
                $http({
                method :"POST",
                url : 'routes/Add_To_Cart',
                data: data
                }).then(function mySuccess(response) {
                    // $scope.Market_Place_List = response.data;
                    // $scope.moda = true;
                    $scope.My_Cart();
                    $('.modal').modal('hide');
                }, function myError(response) {
                    // console.log(response);
                });
            }
            else{
                console.log("cancel");
            }
        });
    }
    
    // Viewing Cart
    $scope.View_My_Cart = function(){
        // Close Navbar
        $(".collapse").collapse('hide');
        // INITIALIZE VARIABLES
        $scope.If_Market_Place = false;
        $scope.If_Approved_Requests = false;
        $scope.If_My_Requests = false;
        $scope.If_View_All_Bidders_In_Request = false;
        $scope.If_Confirm_Checkbox = false;
        $scope.If_Dashboard = false;
        // INITIALIZE VARIABLES
        $scope.If_View_My_Cart = true;

        $scope.My_Cart();
    }
    //END

    $scope.My_Cart = function(){
        $http({
            method : "GET",
            url : 'routes/View_My_Cart',
        }).then(function mySuccess(response) {
            console.log(response.data);
            $scope.Item_Count = response.data[1];
            $scope.My_Shopping_Cart_List = response.data[0];
            console.log($scope.My_Shopping_Cart_List);
            $scope.Total_Checkout_Amount = 0;
            for(var x = 0; x < $scope.My_Shopping_Cart_List.length; x++){
                $scope.Total_Checkout_Amount = $scope.Total_Checkout_Amount + $scope.My_Shopping_Cart_List[x].Total_Price;
                $scope.max = $scope.My_Shopping_Cart_List[x].posted_product.Product_Quantity.toString();
                // console.log($scope.max);
            }
            if($('.navbar-toggler').is(':visible')){
                $scope.collapse_button_2();
            }else{
                $scope.openNav();
                $('.main_dashboard_and_market').css('margin-left','150px');
            };

        }, function myError(response) {
         
        });
    }

    $scope.My_Cart_Add_Qty = function(Shopping_Cart_Id,qty,Product_Price){
        var data = {
            Shopping_Cart_Id:Shopping_Cart_Id,
            qty:qty,
            Product_Price:Product_Price,
        }
        console.log(data);

        $http({
            method : "POST",
            url : 'routes/My_Cart_Add_Qty',
            data: data
        }).then(function mySuccess(response) {
            $scope.My_Cart();
        }, function myError(response) {
         
        });
    }

    $scope.Specific_Cart_Items = function(Product_Detail){
        $scope.Specific_Product_Detail = Product_Detail;
        console.log($scope.Specific_Product_Detail);
    }

    //Removing Items in Shopping Cart
    $scope.Remove_Item = function(id){
        console.log(id);

        swal({
            title: "Remove this item?",
            icon: "warning",
          buttons: {
            cancel: true,
            confirm: "Yes, I want to delete this item.",
          },
          closeOnClickOutside: false,
        }).then(function(isConfirm){
            if(isConfirm){
                $http({
                    method : "POST",
                    url : 'routes/Delete_Item_In_Cart',
                    data: {id:id}
                }).then(function mySuccess(response) {
                     $scope.View_My_Cart();
                }, function myError(response) {
                 
                });
            }
            else{
                console.log("cancel");
            }
        });

    }
    
    $scope.Procceed_To_CheckOut = function(Items,Total_Checkout_Amount){
        $scope.Ordered_Products = Items;
        $scope.Total_Checked_out_Amount = Total_Checkout_Amount;
        console.log(Items);
        console.log($scope.Total_Checked_out_Amount);
    }

    $scope.Place_Order = function(){
        // console.log($scope.Ordered_Products);

        // $('#id').addClass('overlay');
        // $scope.isloader = true;
        var Delivery_Information = {
            region:$scope.Ordered_Products.region,
            province:$scope.Ordered_Products.province,
            city_municipality:$scope.Ordered_Products.city_municipality,
            brgy:$scope.Ordered_Products.brgy,
            purok:$scope.Ordered_Products.purok,
            recieving_personnel:$scope.Ordered_Products.recieving_personnel,
            specific_address:$scope.Ordered_Products.specific_address,
        }
        console.log(Delivery_Information);

        $http({
            method : "POST",
            url : 'routes/Place_Order',
            data: {Order_Information:$scope.Ordered_Products,Delivery_Information:Delivery_Information,Total_Checked_out_Amount:$scope.Total_Checked_out_Amount}
        }).then(function mySuccess(response) {
             console.log(response.data);
            if(response.data == "success"){
                swal({
                    title: "Yahoo!",
                    text: "You have successfuly bought a product!",
                    icon: "success",
                    buttons: {
                        cancel: "Okay",
                    },
                }).then(function(){
                    $('.modal').modal('hide');
                    $scope.Recievables();
                });
            }else;

        }, function myError(response) {
         
        })
        .then(function(){
            $scope.My_Cart();
        });
    }

    $scope.Confirm_Delivery = false;
    $scope.Get_Confirm_Item_Delivery = function(){
        $http({
            method : "GET",
            url : 'routes/Get_Confirm_Item_Delivery',
        }).then(function mySuccess(response) {
             console.log(response.data);
             $scope.Confirm_Items_Delivered = response.data;
            
            if($scope.Confirm_Items_Delivered.length > 0){
                for(var x = 0; x < $scope.Confirm_Items_Delivered.length; x++){
                    $scope.Confirm_Items_Delivered[x].updated_at = $scope.parse_date($scope.Confirm_Items_Delivered[x].updated_at);
                }
                $scope.Confirm_Delivery = false;
                $('.modal#Consumer_Transaction_Official_Receipt').modal({backdrop: 'static', keyboard:false});
            }else;

        }, function myError(response) {
         
        });
    }
    $scope.Get_Confirm_Item_Delivery();

    $scope.Confirm_Item_Delivery = function(items){

        var data = {
            items:items,
        }

        $http({
            method : "POST",
            url : 'routes/Confirm_Item_Delivery',
            data : data
        }).then(function mySuccess(response) {
             console.log(response.data);
            if(response.data == "success"){
                $('.modal#Consumer_Transaction_Official_Receipt').modal('hide');

                swal({
                    title: "Thank you!",
                    text: "You have successfuly received and confirmed the items that have been delivered.",
                    icon: "success",
                    buttons: {
                        cancel: "Okay",
                    },
                }).then(function(){
                    $scope.View_All_Recievables('1');
                });
            }else;

        }, function myError(response) {
         
        });
    }

///END Display By Category

//Close Suggestion in Input
$scope.Close_Suggestion = function(){
    $scope.suggestion_product = true;
}
//End Close Suggestion in Input
 
     $scope.Get_Region = function(){
        $http({
            method : "GET",
            url : 'routes/Get_Region',
            data: {},
        }).then(function mySuccess(response){
            $scope.Regions = response.data;
        }, function myError(response){
            console.log(response);
        });
    }

    $scope.Get_Provinces = function (region_code){
        var data = {
            region_code : region_code
        }
        $http({
            method : "POST",
            url : 'routes/Get_Province',
            data : data,
        }).then(function mySuccess(response){
            $scope.Provinces = response.data;
        }, function myError(response){

        });
    }

    $scope.Get_City = function (province_code){
        var data = {
            province_code : province_code
        }
        $http({
            method : "POST",
            url : 'routes/Get_City',
            data : data,
        }).then(function mySuccess(response){
            $scope.Cities = response.data;
        }, function myError(response){

        });
    }

    $scope.Get_Brgy = function (city_code){
        var data = {
            city_code : city_code
        }
        $http({
            method : "POST",
            url : 'routes/Get_Brgy',
            data : data,
        }).then(function mySuccess(response){
            $scope.Brgy = response.data;
        }, function myError(response){

        });
    }
    $scope.Get_Region();

});

app.controller('Super_Admin_Controller', function($scope,$http) {
    console.log("Super_Admin_Controller");
    
    var user_id = $('#user_id').html();
    $scope.user_id = $('#user_id').html();

    var socket = io.connect('http://localhost:3001');

    // Socket Event
    socket.on("Newly_Registered", function(data){
        console.log(data['user_type']);
        $scope.User_Count(data['user_type']);
    });

    socket.emit("Admin", user_id, function(user_id, callback){
        if (user_id) {
            console.log('true');
        }else{
            console.log('false');
        };
    });

    socket.on("Order_A_Product", function(data){
        // Everytime naay order e-update ang deliverables
        $scope.Logistics_Deliverables();
    });

    socket.on("Accepted_Farmer_Bid", function(data){
        // Everytime naay order e-update ang deliverables
        $scope.Logistics_Deliverables();
    });
    // Socket Event

    // Native JQUERY FUNCTIONS
    $(window).on('load resize', function(){
       if ($('.page-wrapper').width() < 767 ){
            $scope.closeNav();
       }else{
            $scope.openNav();
       };
    });

    $scope.openNav = function(){
      $(".page-wrapper").addClass("toggled");
    }

    $scope.closeNav = function(){
      $(".page-wrapper").removeClass("toggled");
    }
    // Native JQUERY FUNCTIONS

    /** /* NAVIGATION PANE **/
    $(".sidebar-dropdown > a").click(function() {
      $(".sidebar-submenu").slideUp(200);
      if ( $(this).parent().hasClass("active") ) {
        $(".sidebar-dropdown").removeClass("active");
        $(this)
          .parent()
          .removeClass("active");
      } else {
        $(".sidebar-dropdown").removeClass("active");
        $(this)
          .next(".sidebar-submenu")
          .slideDown(200);
        $(this)
          .parent()
          .addClass("active");
      }

    });

    $(".sidebar-submenu > ul > li > a").click(function(){
      $(".sidebar-dropdown").removeClass("active");
      $(".sidebar-submenu").slideUp(200);
    });
    /** /* END NAVIGATION PANE **/

    // INITIALIZED VALUES
    $scope.If_Dashboard = true;
    $scope.If_Deliverables = false;
    $scope.If_Statistics = false;
    $scope.If_Tasks = false;

    $scope.pageSize = 10;
    $scope.gap = 10;
    $scope.currentPage = 0;

    $scope.initialized_values = function(){
        $scope.User_Count('Farmer');
        $scope.User_Count('Consumer');
        $scope.User_Count('Investor');
        $scope.Stats();
        $scope.Render_Chart();
    }

    $scope.parse_date = function(date){
        date = new Date(Date.parse(date));
        return date;
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

    $scope.Stats = function(){
        var Sales_Transactions = document.getElementById("sales_transactions");
        
        var Sales_Data_array = [];
        var month = 31;
        var addval = 1000;
        for(var x=1; x < month; x++){
            addval = x+addval;
            Sales_Data_array.push(addval.toString());
        }
        // console.log(Sales_Data_array);

        var Sales_Data = {
            label: "Monthly Sales",
            data: Sales_Data_array,
            borderColor: '#28a745',
            fill: true,
            backgroundColor: 'rgba(40, 167, 69, 0.2)',
            pointBorderWidth: 4,
            pointBorderColor: '#28a745',
            pointBackgroundColor: '#fff',
            pointRadius: 6,
            lineTension: 0,
        };

        var Transactions_Data_array = [];
        var month = 31;
        var addval1 = 103;
        for(var x=1; x < month; x++){
            addval1 = x+addval1;
            Transactions_Data_array.push(addval1.toString());
        }
        // console.log(Transactions_Data_array);

        var Transactions_Data = {
            label: "Monthly Transactions",
            data: Transactions_Data_array,
            borderColor: '#ffaf36',
            fill: true,
            backgroundColor: 'rgb(255, 175, 54, 0.4)',
            pointBorderWidth: 4,
            pointBorderColor: '#ffaf36',
            pointBackgroundColor: '#fff',
            pointRadius: 6,
            lineTension: 0,
        };

        console.log(Transactions_Data);

        var labelsshit = [];
        for(var x=1; x < 31; x++){
            labelsshit.push(x.toString());
        }
        // console.log(labelsshit);

        var Sales_Transactions_Canvas_Data = {
            labels: labelsshit,
            datasets: [Sales_Data,Transactions_Data],
        };

        var chartOptions = {
            scaleShowGridLines : true,
            scaleGridLineColor : "rgba(0,0,0,.05)",
            scaleGridLineWidth : 1,
            scaleShowHorizontalLines: true,
            scaleShowVerticalLines: true,
            pointDot : true,
            pointDotRadius : 4,
            pointDotStrokeWidth : 1,
            pointHitDetectionRadius : 20,
            datasetStroke : true,
            datasetStrokeWidth : 2,
            datasetFill : true,
            tooltips: {
                mode: 'index',
                intersect: false
             },
             hover: {
                mode: 'index',
                intersect: false
             }
        };

        var lineChart = new Chart(Sales_Transactions, {
            type: 'line',
            data: Sales_Transactions_Canvas_Data,
            options: chartOptions
        });
    }

    $scope.User_Count = function(user_type){
        var data = {
            user_type:user_type,
        }

        $http({
            method : "POST",
            url : 'routes/User_Count',
            data: data
        }).then(function mySuccess(response) {
            // console.log(response.data);
            if(response.data[1] == "Farmer"){
                $scope.User_Count_Type_Farmer = response.data[0];
            }else if(response.data[1] == "Consumer"){
                $scope.User_Count_Type_Consumer = response.data[0];
            }else if(response.data[1] == "Investor"){
                $scope.User_Count_Type_Investor = response.data[0];
            };
        }, function myError(response) {
         
        });
    }

    $scope.View_Deliverables = function(user_type){
        $scope.If_Statistics = false;
        $scope.If_Tasks = false;
        $scope.If_Dashboard = false;

        $scope.If_Deliverables = true;

        $scope.Logistics_Deliverables();
    }

    // $scope.transaction_type;
    $scope.Logistics_Deliverables = function(){
        $http({
            method : "GET",
            url : 'routes/Logistics_Deliverables',
        }).then(function mySuccess(response) {
            $scope.Logistics_Deliverables_List = response.data[0];
            $scope.Total_Orders_Revenue = 0;
            $scope.Total_Bids_Revenue = 0;

             $scope.curr_date = $scope.parse_date(response.data[1].date);

            for(var count = 0; count < $scope.Logistics_Deliverables_List.length; count++){
                // console.log(Object.keys($scope.Logistics_Deliverables_List[count]));
                if($scope.Logistics_Deliverables_List[count].hasOwnProperty('Farmer_Bids_Id') == false){
                    $scope.Total_Orders_Revenue = $scope.Total_Orders_Revenue + $scope.Logistics_Deliverables_List[count].posted_product[0].Product_Markup_Value;
                // console.log($scope.Logistics_Deliverables_List[count].official_receipt);
                    
                }else{
                    $scope.Total_Bids_Revenue = $scope.Total_Bids_Revenue + $scope.Logistics_Deliverables_List[count].Bid_Markup_Value;
                };

                $scope.Logistics_Deliverables_List[count].updated_at = $scope.parse_date($scope.Logistics_Deliverables_List[count].updated_at);
            }
        // console.log($scope.Total_Orders_Revenue);
        
        }, function myError(response) {
         
        }).then(function(){
           $scope.Render_Chart(); 
        });
    };

    $scope.Render_Chart = function(){
        $http({
            method : "GET",
            url : 'routes/Render_Chart',
        }).then(function mySuccess(response) {
            var d = new Date();
            console.log(d.getDate());

            $scope.Sales_For_Current_Day = response.data[0][d.getDate()];
            $scope.Average_Sales_For_Current_Day = response.data[1];
            $scope.Sales_Per_Day = response.data[2];
            $scope.Average_Sales_Per_Day = response.data[3];
            $scope.Sales_Per_Week = response.data[4];
            $scope.Average_Sales_Per_Week = response.data[5];
            $scope.Sales_Per_Month = response.data[6];
            $scope.Average_Sales_Per_Month = response.data[7];
            $scope.bids = response.data[8];

            console.log($scope.Transactions_per_week);
            // $scope.Orders = response.data[0];
            // $scope.Bids = response.data[1];
            for (var property in $scope.Transactions_current_day) {
                $scope.Transactions_current_day_data = $scope.Transactions_current_day[property];
            }

            console.log($scope.Transactions_current_day_data);

            $scope.Sorted_Orders_Data = Object.values($scope.Orders);
            $scope.Sorted_Orders_Label = Object.keys($scope.Orders);

            $scope.Orders_Data_label = [];
            $scope.Charts_Data_Orders = [];

                for(var x=0; x < $scope.Sorted_Orders_Label.length; x++){
                    $scope.Orders_Data_label.push($scope.Sorted_Orders_Label[x]);
                }

                for(var x=0; x < $scope.Sorted_Orders_Data.length; x++){
                    $scope.Charts_Data_Orders.push($scope.Sorted_Orders_Data[x]);
                }
            
            console.log($scope.Charts_Data_Orders);

            $scope.Sorted_Bids_Data = Object.keys($scope.Bids);
            $scope.Bids_Data_label = [];
            $scope.Charts_Data_Bids = [];

            for(var x=0; x < $scope.Sorted_Bids_Data.length; x++){
                for(var i = 0; i < $scope.Bids[$scope.Sorted_Bids_Data[x]].length; i++){
                    var label = i + 1;
                    $scope.Bids_Data_label.push(label.toString());
                    $scope.Charts_Data_Bids.push($scope.Bids[$scope.Sorted_Bids_Data[x]][i].Amount.toString());
                }
            }

        // var Orders_Data_Transactions_Deliverables = document.getElementById("Orders_Data_Transactions_Deliverables");
        // var Bids_Data_Transactions_Deliverables = document.getElementById("Bids_Data_Transactions_Deliverables");
        
        // var Orders_Data = {
        //     label: "Orders Transactions",
        //     data: $scope.Charts_Data_Orders,
        //     borderColor: '#28a745',
        //     fill: true,
        //     backgroundColor: 'rgba(40, 167, 69, 0.2)',
        //     pointBorderWidth: 4,
        //     pointBorderColor: '#28a745',
        //     pointBackgroundColor: '#fff',
        //     pointRadius: 6,
        //     lineTension: 0,
        // };

        // var Bid = {
        //     label: "Bid Transactions",
        //     data: $scope.Charts_Data_Bids,
        //     borderColor: '#ffaf36',
        //     fill: true,
        //     backgroundColor: 'rgb(255, 175, 54, 0.4)',
        //     pointBorderWidth: 4,
        //     pointBorderColor: '#ffaf36',
        //     pointBackgroundColor: '#fff',
        //     pointRadius: 6,
        //     lineTension: 0,
        // };

        // var Orders_Transactions_Canvas_Data = {
        //     labels: $scope.Orders_Data_label,
        //     datasets: [Orders_Data],
        // };

        // var Bids_Transactions_Canvas_Data = {
        //     labels: $scope.Bids_Data_label,
        //     datasets: [Bid],
        // };

        // var chartOptions = {
        //     scaleShowGridLines : true,
        //     scaleGridLineColor : "rgba(0,0,0,.05)",
        //     scaleGridLineWidth : 1,
        //     scaleShowHorizontalLines: true,
        //     scaleShowVerticalLines: true,
        //     pointDot : true,
        //     pointDotRadius : 4,
        //     pointDotStrokeWidth : 1,
        //     pointHitDetectionRadius : 20,
        //     datasetStroke : true,
        //     datasetStrokeWidth : 2,
        //     datasetFill : true,
        //     tooltips: {
        //         mode: 'index',
        //         intersect: false
        //      },
        //      hover: {
        //         mode: 'index',
        //         intersect: false
        //      },
        // };

        // var lineChart = new Chart(Orders_Data_Transactions_Deliverables, {
        //     type: 'line',
        //     data: Orders_Transactions_Canvas_Data,
        //     options: chartOptions
        // });

        // var lineChart1 = new Chart(Bids_Data_Transactions_Deliverables, {
        //     type: 'line',
        //     data: Bids_Transactions_Canvas_Data,
        //     options: chartOptions
        // });

        }, function myError(response) {
         
        });
    }

    $scope.Confirm_Issue_Receipt = false;
    $scope.Issuance_Of_Official_Receipt = function(List){
        console.log(List);
        $scope.Receipt_List = List;
    }

    $scope.Issue_Official_Receipt = function(Posted_Product_Id,Buyer_Info_Id,Farmer_Info_Id,Purchase_Product_Id){
        var data = {
            Posted_Product_Id:Posted_Product_Id,
            Buyer_Info_Id:Buyer_Info_Id,
            Farmer_Info_Id:Farmer_Info_Id,
            Purchase_Product_Id:Purchase_Product_Id,
        }
        console.log(data);
        $http({
            method :"POST",
            url : 'routes/Issue_Official_Receipt',
            data: data
        }).then(function mySuccess(response) {
            $('.modal').modal('hide');
            swal({
                title: "Yahoo",
                text: "Issued receipt sucessfuly",
                icon: "success",
                buttons: {
                    cancel: "Okay",
                },
            }).then(function(){
                $scope.View_Deliverables();
            });
        }, function myError(response) {

        });
    }

});

app.controller('Login_Controller', function($scope,$http) {
    console.log("login");
    var pathname = window.location.pathname;
    console.log(pathname);

    $scope.submit = function(){

        var data = {
            username:$scope.username,
            password:$scope.password,
        }

        $http({
            method : "POST",
            url : '/login/custom',
            data: data
        }).then(function mySuccess(response) {
            var data2 = response.data;
            console.log(data2);

            if(data2 === "Farmer"){
                window.location.href="/"+"farmer/routes";
            }if(data2 === "Consumer"){
                window.location.href="/"+"consumer/routes";
            }if(data2 === "DA_Admin"){
                window.location.href="/"+"department_of_agriculture";
            }if(data2 === "Super_Admin"){
                window.location.href="/"+"super_admin/routes";
            }else if(data2 === "error"){
                $scope.username = "";
                $scope.password = "";

                swal({
                    title: "You have entered an invalid credentials",
                    text: "Please check your credential upon sumbitting",
                    icon: "error",
                    buttons: {
                        cancel: "Okay",
                    },
                });

                console.log("myError");
            }else;

        }, function myError(response) {});

    }

});

app.controller('Registration_Controller', function($scope,$http) {
    console.log("Registration_Controller");
    $scope.registration_checkbox = false;

    $scope.Get_Region = function(){
        console.log('ssasa');
        $http({
            method : "GET",
            url : '/Get_Region',
            data: {},
        }).then(function mySuccess(response){
            $scope.Regions = response.data;
        }, function myError(response){
            console.log(response);
        });
    }

    $scope.Get_Provinces = function (region_code){
        var data = {
            region_code : region_code
        }
        $http({
            method : "POST",
            url : '/Get_Province',
            data : data,
        }).then(function mySuccess(response){
            $scope.Provinces = response.data;
        }, function myError(response){

        });
    }

    $scope.Get_City = function (province_code){
        var data = {
            province_code : province_code
        }
        $http({
            method : "POST",
            url : '/Get_City',
            data : data,
        }).then(function mySuccess(response){
            $scope.Cities = response.data;
        }, function myError(response){

        });
    }

    $scope.Get_Brgy = function (city_code){
        var data = {
            city_code : city_code
        }
        $http({
            method : "POST",
            url : '/Get_Brgy',
            data : data,
        }).then(function mySuccess(response){
            $scope.Brgy = response.data;
        }, function myError(response){

        });
    }
    $scope.Get_Region();

    $scope.fileChanged = function(element){
        $scope.file = element.files
        $scope.uptfile = element.files
        $scope.$apply();        
        
        var validCVFiles = ["png","jpeg","jpg",];
        var name  = $scope.file[0].name;
        var fileType = name.substr(name.indexOf(".")+1)

        console.log($scope.file);
    }

    $scope.Sign_Up = function(){
        // console.log($scope.file[0]);
        // $http({
        //     method : "POST",
        //     url : '/register',
        //     data: {},
        //     headers: { 'Content-Type': undefined},
        //     transformRequest: function(data) {
        //         var formData = new FormData();
        //         formData.append("file", $scope.file[0]);
        //         formData.append("user_type", $scope.user_type);
        //         formData.append("username", $scope.username);
        //         formData.append("password", $scope.password);
        //         formData.append("firstname", $scope.firstname);
        //         formData.append("middlename", $scope.middlename);
        //         formData.append("lastname", $scope.lastname);
        //         formData.append("age", $scope.age);
        //         formData.append("gender", $scope.gender);
        //         formData.append("purok", $scope.purok);
        //         formData.append("brgy", $scope.brgy);
        //         formData.append("city_municipality", $scope.city_municipality);
        //         formData.append("province", $scope.province);
        //         formData.append("region", $scope.region);
        //         formData.append("email", $scope.email);
        //         formData.append("contact", $scope.contact);
        //         console.log(formData);
        //         return formData;
        //     },
        // }).then(function mySuccess(response) {
        //         window.location.href = "/login";
        // }, function myError(response) {
        //     console.log(response);
        // });
    }


    // $scope.compare = function() {
    //     $scope.result = angular.equals($scope.PassWord, $scope.password_confirmation);
    //     console.log($scope.result);
    //     if($scope.result === true){
    //         $scope.farmer_registration.password_confirmation.$setValidity("password_confirmation", true);
    //         $scope.farmer_registration.PassWord.$setValidity("PassWord", true);
    //     }else{
    //         $scope.farmer_registration.password_confirmation.$setValidity("password_confirmation", false);
    //         $scope.farmer_registration.PassWord.$setValidity("PassWord", false);
    //     }
    // };



});