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
  $routeProvider.when('/password', {templateUrl: 'views/password.html'});
  $routeProvider.when('/email', {templateUrl: 'views/email.html'});
  $routeProvider.when('/delete', {templateUrl: 'views/delete.html'});
  $routeProvider.otherwise({redirectTo: '/home'});
}]);