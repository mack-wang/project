$(document).ready(function () {
    //启动日期插件
    var $start = $('#rangestart'), $end = $('#rangeend');

    $start.calendar({
        type: 'datetime',
        text: _TEXT,
        endCalendar: $end,
        ampm: false,
        formatter: {
            date: function (date, settings) {
                if (!date) return '';
                var day = date.getDate() + '';
                if (day.length < 2) {
                    day = '0' + day;
                }
                var month = (date.getMonth() + 1) + '';
                if (month.length < 2) {
                    month = '0' + month;
                }
                var year = date.getFullYear();
                return year + '/' + month + '/' + day;
            }
        }
    });

    $end.calendar({
        type: 'datetime',
        text: _TEXT,
        startCalendar: $start,
        ampm: false,
        formatter: {
            date: function (date, settings) {
                if (!date) return '';
                var day = date.getDate() + '';
                if (day.length < 2) {
                    day = '0' + day;
                }
                var month = (date.getMonth() + 1) + '';
                if (month.length < 2) {
                    month = '0' + month;
                }
                var year = date.getFullYear();
                return year + '/' + month + '/' + day;
            }
        }
    });

    //启动文本编辑器
    var ue = UE.getEditor('container');
    ue.ready(function () {
        //此处为支持laravel5 csrf ,根据实际情况修改,目的就是设置 _token 值.
        ue.execCommand('serverparam', '_token', _TOKEN);
    });



    //上传活动头图
    var ue2 = UE.getEditor('container2');
    ue2.ready(function () {
        //此处为支持laravel5 csrf ,根据实际情况修改,目的就是设置 _token 值.
        ue2.setHide();
        ue2.execCommand('serverparam', '_token', _TOKEN);

        //弹出图片上传的对话框
        $("#headimg_add").click(function () {
            ue2.getDialog("insertimage").open();

            // 弹出文件上传
            // var myFiles = ue2.getDialog("attachment");
            // myFiles.open();
        });

        ue2.addListener('beforeInsertImage', function (t, arg) {
            var headimg =
                '<div class="card">'
                + '<div class="blurring dimmable image">'
                + '<div class="ui dimmer">'
                + '<div class="content">'
                + '<div class="center">'
                + '<div class="ui inverted button delete">删除</div>'
                + '</div>'
                + '</div>'
                + '</div>'
                + '<img data-value="' + arg[0].src + '" src="' + _DOMAIN + arg[0].src + '">'
                + '</div>'
                + '</div>';

            var limit = $('.headimg_box').attr('data-limit');
            if ($(".headimg_box img").length == limit) {
                alert("最多上传"+limit+"张图！");
                return false;
            }

            $("#headimg_box").append(headimg);

            $('.headimg_box.special.cards .image').dimmer({
                on: 'hover'
            });

            $('.headimg_box.special.cards .delete').click(function () {
                $(this).closest('.card').remove();
            });
        });
//            ue2.addListener('afterUpfile', function (t, arg) {
//                alert(arg[0].url);
//            });
    });


});