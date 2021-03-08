app.config(['$routeProvider','$locationProvider',
  function($routeProvider,$locationProvider){
    $routeProvider
    .when('/dac/routes',{
        templateUrl: '/dac/routes/dashboard_contents',
        controller : ''
       //  resolve:{
       //     delay: function($q, $timeout){
       //          var delay = $q.defer();
       //          $timeout(delay.resolve, 1000);
       //          return delay.promise;
       //      }
       // }
    })
    .when('/dac/routes/show_modality',{
        templateUrl: '/dac/routes/modality_contents',
        controller : ''
       //  resolve:{
       //     delay: function($q, $timeout){
       //          var delay = $q.defer();
       //          $timeout(delay.resolve, 1000);
       //          return delay.promise;
       //      }
       // }
    })
    .when('/dac/routes/files',{
        templateUrl: '/dac/routes/file_contents',
        controller : ''
       //  resolve:{
       //     delay: function($q, $timeout){
       //          var delay = $q.defer();
       //          $timeout(delay.resolve, 1000);
       //          return delay.promise;
       //      }
       // }
    })
    .when('/dac/routes/files/myfiles',{
        templateUrl: '/dac/routes/myfiles',
        controller : ''
       //  resolve:{
       //     delay: function($q, $timeout){
       //          var delay = $q.defer();
       //          $timeout(delay.resolve, 1000);
       //          return delay.promise;
       //      }
       // }
    })
    .when('/dac/routes/files/allfiles',{
        templateUrl: '/dac/routes/allfiles',
        controller : ''
       //  resolve:{
       //     delay: function($q, $timeout){
       //          var delay = $q.defer();
       //          $timeout(delay.resolve, 1000);
       //          return delay.promise;
       //      }
       // }
    })
    .when('/dac/routes/profile',{
        templateUrl: '/dac/routes/my_profiles',
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
