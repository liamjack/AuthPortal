'use strict';


// Declare app level module which depends on filters, and services
angular.module('myApp', [
  'ngRoute',
  'myApp.filters',
  'myApp.services',
  'myApp.directives',
  'myApp.controllers',
  'angular-loading-bar'
]).
config(['$routeProvider', function($routeProvider, $httpProvider) {
  $routeProvider.when('/home', {templateUrl: 'views/home.html'});
  $routeProvider.when('/login', {templateUrl: 'views/login.html'});
  $routeProvider.when('/register', {templateUrl: 'views/register.html'});
  $routeProvider.when('/reset', {templateUrl: 'views/reset.html'});
  $routeProvider.when('/reset/:key', {templateUrl: 'views/resetpass.html', controller: 'resetPassController'});
  $routeProvider.when('/resendactivation', {templateUrl: 'views/resendactivation.html'});
  $routeProvider.when('/activate/:key', {templateUrl: 'views/activate.html', controller: 'activateController'});
  $routeProvider.otherwise({redirectTo: '/home'});
}]);