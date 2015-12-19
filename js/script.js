var app = angular.module('depremApp', []);
app.controller('depremCtrl', function($scope) {
    $scope.size= "38";
	$scope.local= "0";
	$scope.hashtag= "0";
	$scope.flash= "0";
	$scope.maps= "o";
});

$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})