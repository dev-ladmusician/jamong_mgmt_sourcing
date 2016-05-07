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
        getData: function ($defer, params) {
            tableResetPageWhenIfNeeded($scope.resetCacheData, $scope.tableParams, function () {
                $.ajax({
                    url: '/MGMT/api/channel/get_managers',
                    type: "GET",
                    contentType: 'application/json',
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

    $scope.page = $scope.tableParams.page();
    $scope.perpage = $scope.tableParams.count();


    $scope.contentResetCacheData = {};
    $scope.contentTableParams = new ngTableParams({
        page: 1,            // show first page
        count: 10,          // count per page
        sorting: {
            userNumber: 'desc',     // initial sorting
        }
    }, {
        total: 0,
        getData: function ($defer, params) {
            tableResetPageWhenIfNeeded($scope.contentResetCacheData, $scope.contentTableParams, function () {
                $.ajax({
                    url: '/MGMT/api/content/get_items_in_channel?channelId=' + $('#jamong-channelId').val(),
                    type: "GET",
                    contentType: 'application/json',
                    data: params.url(),
                    dataType: 'json',
                    success: function (data) {
                        console.log(data);
                        params.total(data.row_count);
                        $defer.resolve(data.items);
                    }
                })
            });
        }
    });
    
    

    // 정보 업데이트
    $scope.changeChannelInfo = function () {
        var id = $('#jamong-channel-id').val();
        var name = $('#jamong-channel-name').val();
        var nickname = $('#jamong-channel-nickname').val();
        var content = $('#jamong-channel-desc').val();

        $.ajax({
            url: '/MGMT/api/channel/change_channel_info',
            type: 'POST',
            data: {
                channelId: id,
                name: name,
                nickname: nickname,
                content: content
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


function tableResetPageWhenIfNeeded(cacheData, tableParams, task) {
    if (!(JSON.stringify(cacheData.filter) === JSON.stringify(tableParams.filter()) &&
        JSON.stringify(cacheData.sorting) === JSON.stringify(tableParams.sorting()))) {
        cacheData.filter = $.extend(true, {}, tableParams.filter());
        cacheData.sorting = $.extend(true, {}, tableParams.sorting());
        tableParams.page(1);
    }
    task();
}
