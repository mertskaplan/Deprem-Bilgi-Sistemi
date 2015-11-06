var app = angular.module('depremApp', []);
app.controller('depremCtrl', function($scope) {
    $scope.email= "gravatar@mertskaplan.com";
    $scope.size= "38";
	$scope.local= "0";
	$scope.maps= "o";
});

$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})