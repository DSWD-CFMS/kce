app.config(['$routeProvider','$locationProvider',
  function($routeProvider,$locationProvider){
    $routeProvider
    .when('/rpmo/routes',{
        templateUrl: '/rpmo/routes/dashboard_contents',
        controller : ''
       //  resolve:{
       //     delay: function($q, $timeout){
       //          var delay = $q.defer();
       //          $timeout(delay.resolve, 1000);
       //          return delay.promise;
       //      }
       // }
    })
    .when('/rpmo/routes/profile',{
        templateUrl: '/rpmo/routes/my_profiles',
        controller : ''
       //  resolve:{
       //     delay: function($q, $timeout){
       //          var delay = $q.defer();
       //          $timeout(delay.resolve, 1000);
       //          return delay.promise;
       //      }
       // }
    })
    .when('/rpmo/routes/show_modality',{
        templateUrl: '/rpmo/routes/my_modality_contents',
        controller : ''
       //  resolve:{
       //     delay: function($q, $timeout){
       //          var delay = $q.defer();
       //          $timeout(delay.resolve, 1000);
       //          return delay.promise;
       //      }
       // }
    })
    .when('/rpmo/routes/files',{
        templateUrl: '/rpmo/routes/file_contents',
        controller : ''
       //  resolve:{
       //     delay: function($q, $timeout){
       //          var delay = $q.defer();
       //          $timeout(delay.resolve, 1000);
       //          return delay.promise;
       //      }
       // }
    })
    .when('/rpmo/routes/files/myfiles',{
        templateUrl: '/rpmo/routes/myfiles',
        controller : ''
       //  resolve:{
       //     delay: function($q, $timeout){
       //          var delay = $q.defer();
       //          $timeout(delay.resolve, 1000);
       //          return delay.promise;
       //      }
       // }
    })
    .when('/rpmo/routes/files/allfiles',{
        templateUrl: '/rpmo/routes/allfiles',
        controller : ''
       //  resolve:{
       //     delay: function($q, $timeout){
       //          var delay = $q.defer();
       //          $timeout(delay.resolve, 1000);
       //          return delay.promise;
       //      }
       // }
    })
    .when('/rpmo/routes/show_reports',{
        templateUrl: '/rpmo/routes/reports',
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
