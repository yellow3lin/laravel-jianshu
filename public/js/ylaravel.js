$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

var editor = new wangEditor('content');
if (editor.config) {
    // 上传图片（举例）
    editor.config.uploadImgUrl = '/posts/image/upload';

    editor.config.uploadHeaders = {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    };

    // 隐藏掉插入网络图片功能。该配置，只有在你正确配置了图片上传功能之后才可用。
    editor.config.hideLinkImg = true;
    editor.create();
}

$(".like-button").click(function (event) {
    target = $(event.target);
    var current_like = target.attr("like-value");
    var user_id = target.attr("like-user");
    //已经关注点击取消关注按钮,并显示关注按钮
    if(current_like == 1){
        //取消关注
        $.ajax({
            url: "/user/" + user_id + "/unfan",
            method: "POST",
            dataType: "json",
            success: function success(data) {
                if(data.error != 0){
                    alert(data.msg);
                    return;
                }
                target.attr("like-value", 0);
                target.text("关注");
            }
        })
    }else{
        $.ajax({
            url: "/user/" + user_id + "/fan",
            method: "POST",
            dataType: "json",
            success: function success(data) {
                if(data.error != 0){
                    alert(data.msg);
                    return;
                }
                target.attr("like-value", 1);
                target.text("取消关注");
            }
        })

    }
});