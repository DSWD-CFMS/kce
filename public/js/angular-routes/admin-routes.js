app.config(['$routeProvider','$locationProvider',
  function($routeProvider,$locationProvider){
    $routeProvider
    .when('/admin/routes',{
        templateUrl: '/admin/routes/dashboard_contents',
        controller : ''
       //  resolve:{
       //     delay: function($q, $timeout){
       //          var delay = $q.defer();
       //          $timeout(delay.resolve, 1000);
       //          return delay.promise;
       //      }
       // }
    })
    .when('/admin/routes/show_modality',{
        templateUrl: '/admin/routes/modality_list',
        controller : ''
       //  resolve:{
       //     delay: function($q, $timeout){
       //          var delay = $q.defer();
       //          $timeout(delay.resolve, 1000);
       //          return delay.promise;
       //      }
       // }
    })
    .when('/admin/routes/show_user_list',{
        templateUrl: '/admin/routes/user_list_contents',
        controller : ''
       //  resolve:{
       //     delay: function($q, $timeout){
       //          var delay = $q.defer();
       //          $timeout(delay.resolve, 1000);
       //          return delay.promise;
       //      }
       // }
    })
    .when('/admin/routes/files',{
        templateUrl: '/admin/routes/file_contents',
        controller : ''
       //  resolve:{
       //     delay: function($q, $timeout){
       //          var delay = $q.defer();
       //          $timeout(delay.resolve, 1000);
       //          return delay.promise;
       //      }
       // }
    })
    .when('/admin/routes/files/myfiles',{
        templateUrl: '/admin/routes/myfiles',
        controller : ''
       //  resolve:{
       //     delay: function($q, $timeout){
       //          var delay = $q.defer();
       //          $timeout(delay.resolve, 1000);
       //          return delay.promise;
       //      }
       // }
    })
    .when('/admin/routes/files/allfiles',{
        templateUrl: '/admin/routes/allfiles',
        controller : ''
       //  resolve:{
       //     delay: function($q, $timeout){
       //          var delay = $q.defer();
       //          $timeout(delay.resolve, 1000);
       //          return delay.promise;
       //      }
       // }
    })
    .when('/admin/routes/show_reports',{
        templateUrl: '/admin/routes/reports',
        controller : ''
       //  resolve:{
       //     delay: function($q, $timeout){
       //          var delay = $q.defer();
       //          $timeout(delay.resolve, 1000);
       //          return delay.promise;
       //      }
       // }
    })
    .when('/admin/routes/profile',{
        templateUrl: '/admin/routes/my_profiles',
        controller : ''
       //  resolve:{
       //     delay: function($q, $timeout){
       //          var delay = $q.defer();
       //          $timeout(delay.resolve, 1000);
       //          return delay.promise;
       //      }
       // }
    })
        .when('/admin/routes/show_modality',{
        templateUrl: '/admin/routes/fetch_admin_dashboard',
        controller : ''
       //  resolve:{
       //     delay: function($q, $timeout){
       //          var delay = $q.defer();
       //          $timeout(delay.resolve, 1000);
       //          return delay.promise;
       //      }
       // }
    })
            .when('/admin/routes/show_modality',{
        templateUrl: '/admin/routes/show_profile',
        controller : ''
       //  resolve:{
       //     delay: function($q, $timeout){
       //          var delay = $q.defer();
       //          $timeout(delay.resolve, 1000);
       //          return delay.promise;
       //      }
       // }
    })

		$locationProvider.html5Mode({
		enabled: true,
		requireBase: false
	});
  }
]);
