$(document).ready(function () {
});

var app = angular.module('myApp', ['ngTable']).
controller('DetailCtrl', function ($scope, $timeout, ngTableParams) {
    $scope.resetCacheData = {};
    $scope.totalLength = null;
    $scope.tableParams = new ngTableParams({
        page: 1,            // show first page
        count: 10,          // count per page
        sorting: {
            userNumber: 'desc',     // initial sorting
        }
    }, {
        total: 0,
    });

    $scope.page = $scope.tableParams.page();
    $scope.perpage = $scope.tableParams.count();

    // 정보 업데이트
    $scope.changeTypeInfo = function () {
        var id = $('#jamong-type-table-id').val();
        var type_id = $('#jamong-type-id').val();
        var name_kr = $('#jamong-type-name-kr').val();

        $.ajax({
            url: '/MGMT/api/type/change_type_info',
            type: 'POST',
            data: {
                tableId: id,
                name_kr: name_kr,
                type: type_id
            },
            dataType: 'json',
            success: function (data) {
                console.log(data.rtv);
                if (data.rtv > 0) {
                    alert('성공적으로 업데이트 되었습니다.');
                } else {
                    alert('정보가 변경되지 않았거나, 업데이트 하는데 오류가 발생했습니다.');
                }
            }
        })
    }
}).directive('loadingContainer', function () {
    return {
        restrict: 'A',
        scope: false,
        link: function (scope, element, attrs) {
            var loadingLayer = angular.element('<div class="loading"></div>');
            element.append(loadingLayer);
            element.addClass('loading-container');
            scope.$watch(attrs.loadingContainer, function (value) {
                loadingLayer.toggleClass('ng-hide', !value);
            });
        }
    };
});
