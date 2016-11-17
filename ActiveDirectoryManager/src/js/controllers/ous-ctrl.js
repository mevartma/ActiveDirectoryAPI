
angular
    .module('RDash')
    .controller('ouCtrl', ['$scope', '$http', ouCtrl]);

function ouCtrl($scope, $http) {

  var configHeaders = {headers: {
        'Content-Type':'application/json'
    }
  };

  $scope.allous = [];
  $scope.alldomains = [];
  $scope.userList = [];
  $scope.ouList = ["24FX","Affilates","Content","CS","CS-Compliance","CS-Joel","CS-Valentina","Finance","BackOffice","Grand","IT","Management","HR","Marketing","Email","Media","MSO","PPC","Product","Quickoption","Risk","Sales-AR-Conv","Sales-EN-Conv","Sales-EN-Ret","Sales-FR-Conv","Sales-FR-Ret","Sales-GR-Conv","Sales-GR-Ret","Sales-IT-Conv","Sales-IT-Ret","Sales-RU-PRet","Sales-RU-Ret1","Sales-RU-Ret2","Sales-Management","Sales-SP-Conv","Sales-SP-Ret","Ybinary","Scipio","Studio","Web-PHP","Web-Net","Web-QA"];
  $scope.extList = [];

  $scope.copyUserTask = function (scu,se,sd,frn,lrn,fsn,lsn) {
    var data = {
      sUserNameCopyFrom: scu,
      sUserExt: se,
      sUserDomain: sd,
      sUserFirstRealName: frn,
      sUserLastRealName: lrn,
      sUserFirstStageName: fsn,
      sUserLastStageName: lsn,
      sUserNameSkype: "test@test",
      sUserNameQMAgent: "test@test"
    };
    $http.post("http://192.168.1.66/api/employee/valiadateuser",data,configHeaders).success(function(data, status, headers, config){
      alert("OK");
      console.log(data);
    });
    console.log(data);
  };

  $scope.getUsersByOu = function(opSelected){
    var url = "http://192.168.1.66/api/employee/usersbyou?ouPath=" + opSelected;
    var onSuccessUserByOu = function(data, status, headers, config){
      $scope.userList = data;
    }

    var onErrorUserByOu = function(data, status, headers, config){
      $scope.error = status;
    }

    var userByOuPromise = $http.get(url, configHeaders);

    userByOuPromise.success(onSuccessUserByOu);
    userByOuPromise.error(onErrorUserByOu);
  };

  var onSuccessDomain = function(data, status, headers, config){
    $scope.alldomains = data;
  }
  var onErrorDomain = function(data, status, headers, config){
    $scope.error = status;
  }
  var domainPromise = $http.get("http://192.168.1.66/api/domain/alldomains", configHeaders);
  domainPromise.success(onSuccessDomain);
  domainPromise.error(onErrorDomain);

  var onSuccessExt = function(data, status, headers, config){
    $scope.extList = data;
  }
  var onErrorExt = function(data, status, headers, config){
    $scope.extList = status;
  }
  var extPromise = $http.get("http://192.168.1.66/api/sip/allsips", configHeaders);
  extPromise.success(onSuccessExt);
  extPromise.error(onErrorExt);
}
