/**
 * Alerts Controller
 */

angular
    .module('RDash')
    .controller('AlertsCtrl', ['$scope', '$http', AlertsCtrl]);

function AlertsCtrl($scope, $http) {

  var configHeaders = {headers: {
        'Content-Type':'application/json'
    }
  };

  $scope.allusers = [];

  var onSuccess = function(data, status, headers, config){
    $scope.allusers = data;
  }

  var onError = function(data, status, headers, config){
    $scope.error = status;
  }

  var promise = $http.get("http://192.168.1.66/api/phonebook/it", configHeaders);

  promise.success(onSuccess);
  promise.error(onError);
}
