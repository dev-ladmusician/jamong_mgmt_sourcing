$(document).ready(function () {
    $('.jamong-manage-submit').click(function () {
        console.log('check');
    });
});
var app = angular.module('myApp', ['ngTable']).
controller('DetailCtrl', function ($scope, $timeout, ngTableParams) {
    $scope.resetCacheData = {};
    $scope.totalLength = null;
    $scope.tableParams = new ngTableParams({
        page: 1,            // show first page
        count: 11,          // count per page
        sorting: {
            channelNum: 'desc',     // initial sorting
        }
    }, {
        total: 0,
        getData: function ($defer, params) {
            tableResetPageWhenIfNeeded($scope.resetCacheData, $scope.tableParams, function () {
                $.ajax({
                    url: '/MGMT/api/channel/get_items?userId=' + $('#jamong-userId').val(),
                    type: 'GET',
                    contentType: 'application/json',
                    //data: JSON.stringify(params.url()),
                    data: params.url(),
                    dataType: 'json',
                    success: function (data) {
                        console.log(data);
                        $scope.page = $scope.tableParams.page();
                        $scope.perpage = $scope.tableParams.count();
                        $scope.totalLength = data.row_count;
                        params.total(data.row_count);
                        $defer.resolve(data.items);
                    }
                })
            });
        }
    });

    $scope.channelResetCacheData = {};
    $scope.channelTableParams = new ngTableParams({
        page: 1,            // show first page
        count: 10,          // count per page
        sorting: {
            userNumber: 'desc',     // initial sorting
        }
    }, {
        total: 0,
        getData: function ($defer, params) {
            tableResetPageWhenIfNeeded($scope.channelResetCacheData, $scope.channelTableParams, function () {
                $.ajax({
                    url: '/MGMT/api/channel/get_items',
                    type: "GET",
                    contentType: 'application/json',
                    data: params.url(),
                    dataType: 'json',
                    success: function (data) {
                        $.each(data.items, function( key, value ) {
                            value.checked = false;
                        });
                        params.total(data.row_count);
                        $defer.resolve(data.items);
                        $scope.channels = data.items;
                    }
                })
            });
        }
    });

    $scope.submitManager = function () {
        var channelList = [];
        var userId = $('#jamong-user-id').val();
        $.each($scope.channels, function(key, value) {
            if (value.checked) {
                channelList.push(value.channelnum);
            }
        });

        $.ajax({
            url: '/MGMT/api/user/add_manager_bulk',
            type: "POST",
            data: {channels: channelList, userId: userId},
            success: function (data) {
                $('#myModal').modal('toggle');
                console.log(data);
                if (data) {
                    window.location.href = "/MGMT/user/detail?userId=" + userId
                } else {
                    alert('권한을 부여하는데 오류가 발생했습니다.');
                }
            }
        });
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


function tableResetPageWhenIfNeeded(cacheData, tableParams, task) {
    if (!(JSON.stringify(cacheData.filter) === JSON.stringify(tableParams.filter()) &&
        JSON.stringify(cacheData.sorting) === JSON.stringify(tableParams.sorting()))) {
        cacheData.filter = $.extend(true, {}, tableParams.filter());
        cacheData.sorting = $.extend(true, {}, tableParams.sorting());
        tableParams.page(1);
    }
    task();
}

