var app = angular.module('myApp', ['ngTable']).
controller('UserCtrl', function ($scope, $timeout, ngTableParams) {
    $scope.resetCacheData = {};
    $scope.totalLength = null;
    $scope.tableParams = new ngTableParams({
        page: 1,            // show first page
        count: 10,          // count per page
        sorting: {
            inum: 'desc',     // initial sorting
        }
    }, {
        total: 0,
        getData: function ($defer, params) {
            tableResetPageWhenIfNeeded($scope.resetCacheData, $scope.tableParams, function () {
                $.ajax({
                    url: '/MGMT/api/content/get_items',
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
