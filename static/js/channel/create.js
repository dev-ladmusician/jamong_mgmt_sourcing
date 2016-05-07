$(document).ready(function () {
});

var app = angular.module('myApp', []).
controller('CreateCtrl', function ($scope) {
    // 정보 업데이트
    $scope.submit = function () {
        var title = $('#jamong-channel-title').val();
        var content = $('#jamong-channel-content').val();

        $.ajax({
            url: '/MGMT/api/channel/create_channel',
            type: 'POST',
            data: {
                title: title,
                content: content
            },
            dataType: 'json',
            success: function (data) {
                if (data > 0) {
                    alert('성공적으로 업데이트 되었습니다.');
                    window.location.replace("/MGMT/channel/detail?channelId=" + data);
                } else {
                    alert('채널을 저장하는데 오류가 발생했습니다.');
                }
            }
        })
    }
});
