$(document).ready(function () {
    var contentTypeInfo = $('#jamong-content-info-type').val();
    var typeSelector = $('#jamong-content-type');
    var xmlCreator = $('.jamong-content-for-vr');

    if (contentTypeInfo == 1) {
        xmlCreator.show();
    } else {
        xmlCreator.hide();
    }

    $('.jamong-content-submit').click(function () {
        $('.jamong-content-upload-container').show();
        $('#jamong-content-submit-container').submit();
    });
});

var app = angular.module('myApp', []).
controller('DetailCtrl', function ($scope) {

    // 정보 업데이트
    $scope.changeContentInfo = function () {
        var id = $('#jamong-content-id').val();
        var price = $('#jamong-content-price').val();
        var title = $('#jamong-content-title').val();
        var content = $('#jamong-content-content').val();
        var channelId = $('#jamong-content-channel').val();
        var typeId = $('#jamong-content-type').val();
        var categoryId = $('#jamong-content-category').val();

         $.ajax({
             url: '/MGMT/api/content/change_content_info',
             type: 'POST',
             data: {
                 contentId: id,
                 price: price,
                 title: title,
                 content: content,
                 channelId: channelId,
                 typeId: typeId,
                 categoryId: categoryId
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
});
