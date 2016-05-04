$(document).ready(function () {
});

var app = angular.module('myApp', []).
controller('DetailCtrl', function ($scope) {
    // 정보 업데이트
    $scope.changeContentInfo = function () {
        var id = $('#jamong-content-id').val();
        var price = $('#jamong-content-price').val();
        var nickname = $('#jamong-content-nickname').val();
        var content = $('#jamong-content-content').val();

        console.log(id, price, nickname, content);

        // $.ajax({
        //     url: '/MGMT/api/channel/change_channel_info',
        //     type: 'POST',
        //     data: {
        //         channelId: id,
        //         name: name,
        //         nickname: nickname,
        //         content: content
        //     },
        //     dataType: 'json',
        //     success: function (data) {
        //         console.log(data.rtv);
        //         if (data.rtv > 0) {
        //             alert('성공적으로 업데이트 되었습니다.');
        //         } else {
        //             alert('정보가 변경되지 않았거나, 업데이트 하는데 오류가 발생했습니다.');
        //         }
        //     }
        // })
    }
});
