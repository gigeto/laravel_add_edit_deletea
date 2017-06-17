angular.module('orderApp', []).controller('orderController', ['$scope', '$http', function($scope, $http){ 
    
    var orderList = this;  

    function getData(){
        $http.get('http://adcash/')
            .success(function(data) {
                
                console.log(data);
                
                orderList.ordProduct = data;
            });
    }
    
    getData();

    function pushCarInList(){
        carsList.cars.push({
                                    brand : $scope.carsList.carBrand,
                                    model : $scope.carsList.carModel,
                                    description  : $scope.carsList.carDescription
                });
        carsList.carBrand = '';
        carsList.carModel = '';
        carsList.carDescription = '';
    }
    
// UPDATE   
    $scope.newField = {};
    $scope.editing = false;
    
    $scope.editAppKey = function(field) {
        $scope.editing = $scope.carsList.cars.indexOf(field);
    $scope.newField = angular.copy(field);    
    };
    
    $scope.saveEditField = function(field) {
    if ($scope.editing !== false) {
        $scope.carsList.cars[$scope.editing] = $scope.newField;

//      var postData = JSON.stringify(field);
            var postData = angular.toJson(field)          
            var request = $http({
                                    method: "PUT",
                                    url: "http://adcash/"+postData, 
                                    data: postData,
                                   headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
                                });
            request.success(function (data) {
                getData();    
            } );  
        $scope.editing = false;
    }       
    };
    
    $scope.cancel = function(index) {
        if ($scope.editing !== false) {
        $scope.carsList.cars[$scope.editing] = $scope.newField;
        $scope.editing = false;
    }       
    };
//INSERT    
    $scope.addData = function () {

        var error = 1;
        if ((($scope.carsList.carBrand || '').length > 0) || (($scope.carsList.carModel || '').length > 0) || (($scope.carsList.carDescription || '').length > 0)) {
            error = 0;
        }
    
        document.getElementById("message").textContent = "";

            if (error == 0) {
                var formData = {
                                    brand: $scope.orderList.ordUser,
                                    model: $scope.orderList.ordProduct,
                                    description: $scope.orderList.ordQuantity
                                };

                var postData = 'myData=' + angular.toJson(formData);
                var request = $http({
                                        method: "POST",
                                        url: "http://adcash/",
                                        data: postData,
                                        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                                    });

                request.success(function (data) {

                        // getData();

                        $scope.message = "From PHP file : " + data;
                        // pushCarInList();
                    });
            }
            else
            {
                $scope.message = "You have Filled Wrong Details! Error: " + error;
            }

            document.getElementById("message").textContent = $scope.message;
    };
//DELETE
    $scope.deleteField = function(field) {

       var data = field.id;
        // var data = angular.toJson(field.id); 
        var request = $http({
                            method: "DELETE",
                            url: "http://adcash/"+data,
                            data: data,
                            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                        });       


        request.success(function (data) {


            getData();
    

            $scope.message = "Delete " + data;
            document.getElementById("message").textContent = $scope.message;
        });
        
    };
}]);



