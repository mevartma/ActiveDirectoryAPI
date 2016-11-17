'use strict';

/**
 * Route configuration for the RDash module.
 */
angular.module('RDash').config(['$stateProvider', '$urlRouterProvider',
    function($stateProvider, $urlRouterProvider) {

        // For unmatched routes
        $urlRouterProvider.otherwise('/');

        // Application routes
        $stateProvider
            .state('index', {
                url: '/',
                templateUrl: 'templates/dashboard.html'
            })
            .state('copyuser', {
                url: '/copyuser',
                templateUrl: 'templates/copyuser.html'
            })
            .state('newuser',{
              url: '/newuser',
              templateUrl: 'templates/newuser.html'
            })
            .state('login',{
              url: '/login',
              templateUrl: 'templates/login.html'
            });
    }
]);
