$(document).ready(function () {
    var _URL = $('meta[name="domain"]').attr('content');
    var _TOKEN = $('meta[name="csrf-token"]').attr('content');

    $('.ui.agreement.checkbox').checkbox();


    //首次登入弹出警示窗
    if (!$.yu.getCookie('warning')) {
        $('.ui.warning.modal').modal('show');
        $.yu.setCookie('warning', 1);
    }

    //等级星星设置
    $('.ui.apply.star.rating').rating('disable');

    //根据当前设备来设置轮播图的宽度,并可以插入任意数量的轮播图

    var bodyWidth = $('body').width();
    var slidesCount = $('#slide-image>ul>li').length;
    // $('#slide-image').width(bodyWidth * slidesCount);
    $('#slide-image>ul>li').width(bodyWidth);

    $(function () {
        function move() {
            var index = 1, page = 1;

            function start() {
                $("#slide-image").css({transform: "translateX(" + -bodyWidth * index + "px)"});
                index += page;
                if (index >= slidesCount - 1) {
                    page = -page;
                } else if (index <= 0) {
                    page = -page;
                }
            }

            setInterval(function () {
                start();
            }, 5000);
        }

        move();
    });


    //用户登入手机注册
    $userForm = $('.ui.form.user');

    $userForm.on('submit', function (e) {
        if (!$('.ui.checkbox').checkbox('is checked')) {
            e.preventDefault();
            return $('.ui.warning.modal').modal('show');
        }
    });

    $userForm.form({
        fields: {
            password: ['empty', 'minLength[6]', 'maxLength[30]'],
            phone: ['empty', 'number', 'exactLength[11]'],
            code: ['number', 'exactLength[6]']
        }
    });

    //短信倒计时
    var timer = 60;
    var timeOn = false;
    $getCode = $('#get-code');
    $getCode.click(function () {
        if (timeOn) return;
        timeOn = true;
        $.get(_URL + '/login/sendCode/', {phone: $userForm.form('get value', 'phone')},
            function (data) {
                if (data.state == 'error') {
                    alert(data.message);
                }
            }, 'json'
        );
        function Countdown() {
            if (timer >= 1) {
                timer -= 1;
                $getCode.text(timer + 's');
                setTimeout(function () {
                    Countdown();
                }, 1000);
            } else {
                $getCode.text('获取');
                timer = 60;
                timeOn = false;
            }
        }

        Countdown();
    });

    //用户填写资料验证
    $('#user-register').form({
        fields: {
            age: ['empty', 'number', 'between[18-120]'],
            cigarette_age: ['empty', 'number', 'between[1-100]'],
            price: ['empty', 'number', 'between[5-1000]'],
            brand: ['empty'],
            expect: ['empty'],
            real_name: ['empty'],
            mail_phone: ['empty', 'exactLength[11]', 'number'],
            province: ['empty'],
            city: ['empty'],
            area: ['empty'],
            address: ['empty']
        },
        onInvalid: function (field) {
            alterModal('error', field[0])
        }
    });


    //用户填写资料表单提交
    $('#user-submit').click(function () {
        var brand_ids = [], expect_ids = [];
        $.each($('.ui.green.label'), function (index, item) {
            brand_ids.push(item.getAttribute('data-value'));
        });
        $.each($('.ui.yellow.label'), function (index, item) {
            expect_ids.push(item.getAttribute('data-value'));
        });
        $('#user-register').form('set values', {
            brand_id: brand_ids,
            expect_id: expect_ids
        });
        $('#user-register').submit();
    });

    //用户填写资料搜索提示
    $('.ui.search.brand')
        .search({
            apiSettings: {
                url: '/wechat/search/search?cigarette={query}',
                onResponse: function (data) {
                    var content = [];
                    $.each(data, function (index, item) {
                        if (index > 5) {
                            return false;
                        }
                        content.push({title: item['name'], id: item['cigarette_id']});
                    });
                    return {
                        results: content
                    };
                }
            },
            maxResults: 6,
            minCharacters: 2,
            showNoResults: false,
            type: 'standard',
            onSelect: function (result) {
                if ($('.ui.green.label').length == 2) {
                    return alert('最多选择两个卷烟品牌');
                }
                if (result.title == undefined) {
                    return false;
                }
                var label = '<a class="ui green label" data-value="'
                    + result.id
                    + '">'
                    + result.title
                    + '<i class="delete icon"></i></a>';

                $('.brand.label').append(label);

                $('.ui.green.label>i').click(function () {
                    $(this).parent().remove();
                });
            }
        })
    ;


    $('.ui.search.expect')
        .search({
            apiSettings: {
                url: '/wechat/search/search?cigarette={query}',
                onResponse: function (data) {
                    var content = [];
                    $.each(data, function (index, item) {
                        if (index > 5) {
                            return false;
                        }
                        content.push({title: item['name'], id: item['cigarette_id']});
                    });
                    return {
                        results: content
                    };
                }
            },
            minCharacters: 2,
            maxResults: 6,
            type: 'standard',
            showNoResults: false,
            onSelect: function (result) {
                $('.tips').remove();
                if ($('.ui.yellow.label').length == 2) {
                    return alert('最多选择两个卷烟品牌');
                }
                var label = '<a class="ui yellow label" data-value="'
                    + result.id
                    + '">'
                    + result.title
                    + '<i class="delete icon"></i></a>';

                $('.expect.label').append(label);

                $('.ui.yellow.label>i').click(function () {
                    $(this).parent().remove();
                });
            }
        })
    ;


    //显示用户协议
    $('#showAgreement').click(function () {
        $('.ui.agreement.modal').modal('show');
    });

    $('.closeModal').click(function () {
        $(this).parent().modal('hide');
    });


    $('#province').on('change', function () {
        var pid = $('#province>option:selected').val();
        $.get(_URL + '/search/city/' + pid, function (data) {
            $city = $('#city');
            $city.find('option:gt(0)').remove();
            $.each(data, function (index, item) {
                var option = '<option value="' +
                    item['id'] +
                    '">' +
                    item['name'] +
                    '</option>';
                $city.append(option);
            });
        }, 'json');
    });

    $('#city').on('change', function () {
        var pid = $('#city>option:selected').val();
        $.get(_URL + '/search/city/' + pid, function (data) {
            $area = $('#area');
            $area.find('option:gt(0)').remove();
            $.each(data, function (index, item) {
                var option = '<option value="' +
                    item['id'] +
                    '">' +
                    item['name'] +
                    '</option>';
                $area.append(option);
            })
        }, 'json');
    });

    $('.level-explain.button').click(function () {
        $('.ui.level-explain.modal').modal('show');
    });

    $('.exp-explain.button').click(function () {
        $('.ui.exp-explain.modal').modal('show');
    });

    $('.get-ticket.button').click(function () {
        $('.ui.get-ticket.modal').modal('show');
    });

    $('.invite-friend.button').click(function () {
        $('.ui.invite-friend.modal').modal('show');
    });

    //倒计时通用
    $.each($('.count-down'), function (index, item) {
        var $bind = $(item);
        var time = $bind.attr('data-value');
        if (time > 0) {
            var a = time * 1000;
            var fortime = setInterval(function () {
                countTime();
            }, 1000);

            function countTime() {
                if (a == 0) {
                    $bind.text("秒杀活动正在进行");
                    clearInterval(fortime);
                    return false;
                }
                a = a - 1000;
                var b = new Date();
                b.setTime(0);
                var c = new Date();
                c.setTime(a);
                var day1 = b.getDate();    //为方便调用，把天数、小时等单独定义
                var hours1 = b.getHours();
                var minu1 = b.getMinutes();
                var seco1 = b.getSeconds();
                var day2 = c.getDate();
                var hours2 = c.getHours();
                var minu2 = c.getMinutes();
                var seco2 = c.getSeconds();
                var day = day2 - day1;
                var hours = Math.abs(hours2 - hours1);
                var minu = minu2 - minu1;
                var seco = seco2 - seco1;
                $bind.find('span:eq(0)').text(day);
                $bind.find('span:eq(1)').text(hours);
                $bind.find('span:eq(2)').text(minu);
                $bind.find('span:eq(3)').text(seco);
            }
        }
    });


    $("#reportImages").on('change', function () {
        var srcs = this.files;   //获取路径
        var windowURL = window.URL || window.webkitURL;
        if (($(".card.report").length + this.files.length) > 9) {
            alert('最多上传9张图片');
            return false;
        }
        for (var i = 0; i < srcs.length; i++) {
            var image = '<div class="ui card report">'
                + '<div class="image">'
                + '<img class="image preview" src="' + windowURL.createObjectURL(srcs[i]) + '" alt="">'
                + '</div>'
                + '</div>'
            ;
            $("#headimg_box").append(image);
        }
    });

    $("#reportForm").form({
        fields: {
            smoke: ['empty', 'minLength[20]'],
            images: ['empty'],
            scores: ['empty']
        }
    });

    $("#reportGood").one('click', function (e) {
        e.preventDefault();
        var $this = $(this);
        $.get($this.attr('href'), function () {
            $this.find('i').removeClass('yu-good-o').addClass('yu-good');
            $this.find('span')[0].innerHTML++;
        })
    });

    var $preview = $('#preview');

    $('img.preview.image').click(function () {
        $preview.find('img:first').attr('src',$(this).attr('src'));
        $preview.modal('setting',{detachable:false,observeChanges:true,closable:true}).modal('show').modal('refresh');
    });

    $preview.find('img:first').click(function () {
        $preview.modal('hide');
    });



});
