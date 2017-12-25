$(document).ready(function () {
    var _key = $('#key-value').attr('data-key');
    var _value = $('#key-value').attr('data-value');
    var $search = $('input[name=search]');
    var $editInput = $("#editInput");
    var $imageBox = $("#imageBox");
    var $articleOnlyForm = $("#articleOnly-form");
    var $taskForm = $("#task-form");
    var $prizeForm = $("#prizeForm");
    var $resetPasswordForm = $('#resetPasswordForm');
    var $productForm = $('#productForm');
    var $helpForm = $('#helpForm');



    if (_key != undefined && _key != 'area_id') {
        $search.val(_value);
        $search.next().dropdown('set selected', _key);
    }

    //搜索店铺
    $('#search_shop').click(function () {
        $(this).addClass('loading');
        $key = $('select > option:selected').val();
        $value = $search.val();
        if (!$value) {
            return alert('未输入任何搜索内容');
        }
        location.href = _URL + '/shop/search/' + $key + '/' + $value;
    });

    //搜索管理员
    $('#search_manager').click(function () {
        $(this).addClass('loading');
        $key = $('select > option:selected').val();
        $value = $search.val();
        if (!$value) {
            return alert('未输入任何搜索内容');
        }
        location.href = _URL + '/manager/search/' + $key + '/' + $value;
    });

    //搜索管理员
    $('#search_user').click(function () {
        $(this).addClass('loading');
        $key = $('select > option:selected').val();
        $value = $search.val();
        if (!$value) {
            return alert('未输入任何搜索内容');
        }
        location.href = _URL + '/user/search/' + $key + '/' + $value;
    });

    //搜索管理员
    $('#search_post').click(function () {
        $(this).addClass('loading');
        $key = $('select > option:selected').val();
        $value = $search.val();
        if (!$value) {
            return alert('未输入任何搜索内容');
        }
        location.href = _URL + '/post/search/' + $key + '/' + $value;
    });

    //搜索管理员
    $('#search_applyView').click(function () {
        $(this).addClass('loading');
        $key = $('select > option:selected').val();
        $value = $search.val();
        $activity_id = $(this).data('value');
        if (!$value) {
            return alert('未输入任何搜索内容');
        }
        location.href = _URL + '/list/view/search/' + $key + '/' + $value+'/'+$activity_id;
    });

    //搜索管理员
    $('#search_charge').click(function () {
        $(this).addClass('loading');
        $key = $('select > option:selected').val();
        $value = $search.val();
        if (!$value) {
            return alert('未输入任何搜索内容');
        }
        location.href = _URL + '/charge/search/' + $key + '/' + $value;
    });

    //表单验证
    $('form.add-shop').form({
        fields: {
            name: ['empty', 'maxLength[100]'],
            phone: ['empty', 'number', 'exactLength[11]'],
            cigarette_id: ['exactLength[12]', 'number'],
            level: ['number', 'exactLength[1]'],
            scores: ['number']
        }
    });
    //重置表单
    $('.reset.button').click(function () {
        $('form.add-shop').form('reset');
    });

    //增加单个新店铺
    $('#add-shop').click(function () {
        //这步是为了防止在修改店铺信息时，缓存了表单
        $form = $('form.add-shop');
        if ($form.form('get value', '_method') == 'PUT') {
            $form.form('reset');
            $form.attr('action', _URL + '/shop');
        }
        $('.modal.add-shop')
            .modal('setting',{detachable:false,observeChanges:true})
            .modal({
                onDeny: function () {
                    return true;
                },
                onApprove: function () {
                    $form.submit();
                    return false;
                }
            })
            .modal('show')
            .modal('refresh')
        ;
    });

    //伪装input的文件上传
    $('.shops_template').click(function () {
        $(this).next().click();
    });

    //获取上传的文件名
    $('input[name=excel]').on('change', function () {
        $('.shops_template>span').text($(this).val());
    });

    //使用表格上传多家店铺
    $('#add-shop-excel').click(function () {
        $('.modal.add-shop-excel')
            .modal('setting',{detachable:false,observeChanges:true})
            .modal({
                onDeny: function () {
                    return true;
                },
                onApprove: function () {
                    $('form.add-shop-excel').submit();
                    return false;
                }
            })
            .modal('show')
            .modal('refresh')
        ;
    });

    //修改单个店铺
    $('.edit-button').click(function (e) {
        e.preventDefault();
        $form = $('form.add-shop');
        var $this = $(this).parent().parent();
        $form.form('set values', {
            name: $this.find('.shopname').text().trim(),
            area_id: $this.find('td:eq(1)').attr('data-value'),
            phone: $this.find('td:eq(2)').text(),
            cigarette_id: $this.find('td:eq(3)').text(),
            type: $this.find('td:eq(4)').text(),
            level: $this.find('td:eq(5)').text().replace("星", ""),
            black: $this.find('td:eq(6)').attr('data-value'),
            scores: $this.find('td:eq(7)').text(),
            _method: 'PUT'
        });
        $form.attr('action', _URL + '/shop/' + $this.find('input.shop_id').val());

        $('.modal.add-shop')
            .modal('setting',{detachable:false,observeChanges:true})
            .modal({
                onDeny: function () {
                    return true;
                },
                onApprove: function () {
                    $form.submit();
                    return false;
                }
            })
            .modal('show')
            .modal('refresh')
        ;
    });

    //批量复选框的操作
    $('.shop.checkbox:eq(0)')
        .checkbox({
            onChecked: function () {
                var $childCheckbox = $('.checkbox:gt(0)');
                $childCheckbox.checkbox('check');
            },
            onUnchecked: function () {
                var $childCheckbox = $('.checkbox:gt(0)');
                $childCheckbox.checkbox('uncheck');
            }
        })
    ;


    //批量删除，批量黑名单，批量白名单
    $('#checked > .item').click(function () {
        var data = [];
        $('input.shop_id:checked').each(function () {
            data.push($(this).val());
        });
        $.post(_URL + '/shop/' + $(this).attr('data-value'), {
            id: data,
            _token: TOKEN
        }, function (e) {
            location.href = _URL + '/shop';
        })
    });


    $("#selected_minus").click(function () {
        $('#selected').find('.fields:last').remove();
    });

    var $articleForm = $("#article-form");

    $articleForm.form({
        fields: {
            title: ['empty', 'maxLength[100]'],
            article_id: ['empty'],
            count: ['empty', 'number'],
            description: ['maxLength[125]'],
            exp: ['number'],
            level: ['number'],
            start_at: ['empty'],
            end_at: ['empty'],
            cigarette_id: ['empty'],
            image_path: ['empty']
        }
    });


    //文章表单提交
    $("#article-submit").click(function (e) {
        var headimg = [];
        for (var i = 0; i < $imageBox.find('img').length; i++) {
            headimg.push($imageBox.find("img:eq(" + i + ")").attr("data-value"));
        }
        $articleForm.form("set values", {
            image_path: headimg
        });

    });

    $("#article-save").click(function (e) {
        $articleForm.form("set value", "off", "1");
        $("#article-submit").click();
    });

    //机场烟店文章表单提交


    $articleOnlyForm.form({
        fields: {
            message: ['empty', 'maxLength[100]'],
            count: ['empty', 'number'],
            exp: ['number'],
            level: ['number'],
            start_at: ['empty'],
            end_at: ['empty'],
            image_path: ['empty']
        }
    });

    $("#articleOnly-submit").click(function (e) {
        var headimg = [];
        for (var i = 0; i < $imageBox.find('img').length; i++) {
            headimg.push($imageBox.find("img:eq(" + i + ")").attr("data-value"));
        }
        $articleOnlyForm.form("set value", 'image_path', headimg);
    });

    $("#articleOnly-save").click(function (e) {
        $articleOnlyForm.form("set value", "off", "1");
        $("#articleOnly-submit").click();
    });

    //任务提交


    $taskForm.form({
        fields: {
            message: ['empty', 'maxLength[6]'],
            title: ['empty', 'maxLength[100]'],
            exp: ['number'],
            level: ['number'],
            prize_count: ['empty', 'number'],
            start_at: ['empty'],
            end_at: ['empty']
        }
    });

    $("#task-submit").click(function (e) {
        $taskForm.form("set values", {
            prize_name: $(".selection.dropdown.prize").dropdown("get text")
        });
    });

    $("#task-save").click(function (e) {
        $taskForm.form("set value", "off", "1");
        $("#task-submit").click();
    });

    //用户填写资料提示
    $('.ui.search.brand')
        .search({
            apiSettings: {
                url: '/wechat/search/search?cigarette={query}',
                onResponse: function (data) {
                    var content = [];
                    $.each(data, function (index, item) {
                        if (index > 20) {
                            return false;
                        }
                        content.push({title: item['name'], id: item['cigarette_id']});
                    });
                    return {
                        results: content
                    };
                }
            },
            maxResults: 20,
            minCharacters: 2,
            showNoResults: false,
            type: 'standard',
            onSelect: function (result) {
                $articleForm.form("set value", "cigarette_id", result.id);
                $editInput.val(result.id);
            }
        });


    //添加单选、多选选项
    $("#selected_add").click(function () {
        var $new = '<div class="tow fields">'
            + '<div class="field" style="margin:auto 0;" >'
            + '<div class="ui question checkbox">'
            + '<input type="checkbox">'
            + '<label for="" hidden></label>'
            + '</div>'
            + '</div>'
            + '<div class="field">'
            + '<input type="text" class="options" placeholder="内容">'
            + '</div>'
            + '</div>';
        $('#selected').append($new);
    });

    //问题题目提交
    $('#questionForm').form({
        fields: {
            question: ['empty', 'maxLength[255]']
        }
    });

    $('#questionSubmit').click(function (e) {
        var $form = $('#questionForm');
        var type = $form.form('get value', 'type');
        var selected = '', options = [];
        if (type === 'select' || type === 'radio') {
            $.each($('.question.checkbox'), function (index, item) {
                if ($(item).checkbox('is checked')) {
                    selected += (index + 1);
                }
            });
            $('input.options').each(function () {
                options.push($(this).val());
            });
        }
        $form.form('set values', {
            'selected': selected,
            'options': options,
            'image_path': $(".headimg_box img").attr("data-value")
        });
        $form.submit();
    });

    //修改题目
    $('.questionEdit').click(function (e) {
        e.preventDefault();
        var $form = $('#questionForm');
        var $this = $(this).parent().parent();
        var type = $this.find('td:eq(1)').attr('data-value');
        var image = $this.find('td:eq(2)').attr('data-value');

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
            + '<img data-value="' + image + '" src="' + _DOMAIN + image + '">'
            + '</div>'
            + '</div>';

        if (type === 'photo' || type === 'input') {
            $('#option-frame').hide();
        } else {
            $('#option-frame').show();
        }

        if ($.trim(image).length > 0) {
            $("#headimg_box").empty().append(headimg);
            $('.headimg_box.special.cards .image').dimmer({
                on: 'hover'
            });

            $('.headimg_box.special.cards .delete').click(function () {
                $("#headimg_box").find(".card").remove();
            });
        }

        $("#questionSubmit").text('修改');
        $form.form('set values', {
            id: $this.find('td:eq(0)').text(),
            type: type,
            image_path: image,
            question: $this.find('td:eq(3)').text()
        });
    });

    //验证题目选择
    $('.ui.search.question')
        .search({
            apiSettings: {
                url: '/wechat/search/question?question={query}',
                onResponse: function (data) {
                    var content = [];
                    $.each(data, function (index, item) {
                        if (index > 20) {
                            return false;
                        }
                        content.push({title: item['question'], id: item['id']});
                    });
                    return {
                        results: content
                    };
                }
            },
            maxResults: 10,
            minCharacters: 2,
            showNoResults: false,
            type: 'standard',
            onSelect: function (result) {
                $articleForm.form("set value", "question_id", result.id);
                $taskForm.form("set value", "question_id", result.id);
                $editInput.val(result.id);
            }
        });

    //如果页面存在articleForm,则加载此项
    if (document.getElementById('articleForm')) {
        var ue = UE.getEditor('ueditor');
        ue.ready(function () {
            ue.execCommand('serverparam', '_token', _TOKEN);
        });

        var $article = $('#articleForm');
        $article.form({
            fields: {
                'title': ['empty', 'minLength[2]', 'maxLength[125]'],
                'content': ['empty']
            }
        });

        $('#articleSubmit').click(function () {
            $article.form('set values', {
                content: UE.getEditor('ueditor').getContent()
            })
        });

        //文章修改
        $('.articleEdit').click(function () {
            $("#articleSubmit").text('修改').removeClass('green').addClass('blue');
            $.get(_URL + '/article/getContent/' + $(this).attr('data-value'), function (article) {
                UE.getEditor('ueditor').setContent(article.content);
                $article.form('set values', {
                    id: article.id,
                    title: article.title
                });
            }, 'json');
        })
    }

    //作为通用的图片上传模板
    if (document.getElementById('uploadImage')) {
        var ue2 = UE.getEditor('uploadImage');
        ue2.ready(function () {
            ue2.setHide();
            ue2.execCommand('serverparam', '_token', _TOKEN);

            //弹出图片上传的对话框
            $("#imageAdd").click(function () {
                ue2.getDialog("insertimage").open();
            });

            //插入要上传的图片，并绑定删除事件
            ue2.addListener('beforeInsertImage', function (t, arg) {
                var image = _createImage(arg[0].src, _DOMAIN);
                var limit = $imageBox.attr('data-limit');

                if ($imageBox.find('img').length == limit) {
                    alert("最多上传" + limit + "张图！");
                    return false;
                }
                $imageBox.append(image);
                $imageBox.find('.image').dimmer({
                    on: 'hover'
                });
                $imageBox.find('.delete').click(function () {
                    $(this).closest('.card').remove();
                });
            });
        });
    }

    $navForm = $('#navForm');

    $navForm.form({
        fields: {
            image_path: ['empty']
        }
    });

    //文章选择
    $('.ui.search.article').search({
        apiSettings: {
            url: '/admin/search/article?title={query}',
            onResponse: function (data) {
                var content = [];
                $.each(data, function (index, item) {
                    if (index > 10) {
                        return false;
                    }
                    content.push({title: item['title'], id: item['id']});
                });
                return {
                    results: content
                };
            }
        },
        maxResults: 10,
        minCharacters: 2,
        showNoResults: false,
        type: 'standard',
        onSelect: function (result) {
            $navForm.form("set value", "article_id", result.id);
            $articleForm.form("set value", "article_id", result.id);
            $articleOnlyForm.form("set value", "article_id", result.id);
            $taskForm.form("set value", "article_id", result.id);
            $editInput.val(result.id);
        }
    });

    //品牌选择
    $('#productSearch').search({
        apiSettings: {
            url: '/admin/product/getContent?brand={query}',
            onResponse: function (data) {
                var content = [];
                content.push({title: data.brand, id: data.brand_id});
                return {
                    results: content
                };
            }
        },
        maxResults: 10,
        minCharacters: 2,
        showNoResults: false,
        type: 'standard',
        onSelect: function (result) {
            $productForm.form("set values", {
                brand_id: result.id,
                brand: result.title
            });
        }
    });

    //导航开启或关闭
    $('.toggle.nav.checkbox')
        .checkbox({
            onChange: function () {
                $.get(_URL + '/activity/navToggle/' + $(this).val());
                $(this).checkbox('toggle');
            }
        })
    ;

    //文章开启和关闭
    $('.activities.checkbox')
        .checkbox({
            onChange: function () {
                $.get(_URL + '/activity/activitiesToggle/' + $(this).val());
                $(this).checkbox('toggle');
            }
        })
    ;

    //导航修改
    $('.navEdit').click(function () {
        $("#navSubmit").text('修改').removeClass('green').addClass('blue');
        $("#articleTitle").text($(this).attr('data-title'));
        $.get(_URL + '/nav/getNav/' + $(this).attr('data-value'), function (nav) {
            $imageBox.empty();
            _insetImage(nav.image_path, _DOMAIN);
            $navForm.form('set values', {
                id: nav.id,
                article_id: nav.article_id,
                redirect_path: nav.redirect_path,
                image_path: nav.image_path
            });
        }, 'json');
    });

    //导航表单提交
    $('#navSubmit').click(function () {
        $navForm.form('set value', 'image_path', $imageBox.find('img').attr('data-value'));
    });

    $('.ui.rating.apply').rating({
        maxRating: 5
    });

    //启动日期插件
    if (document.getElementById("rangestart")) {
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
    }


    //修改测评活动
    $('.ui.dropdown.applyDetail').dropdown({
        onChange: function (value, text, $choice) {
            $editInput = $("#editInput")
                .attr('name', value)
                .val($($choice).attr('data-content'))
                .hide();
            $('.ui.search').hide();
            $('.uploadImage').hide();
            switch (value) {
                case "cigarette_id":
                    $(".brand.search").show();
                    break;
                case "article_id":
                    $(".article.search").show();
                    break;
                case "question_id":
                    $(".question.search").show();
                    break;
                case "image_path":
                    var images = $($choice).attr('data-content').split(',');
                    if ($imageBox.find('img').length !== 0) {
                        $imageBox.parent().show();
                        return false;
                    }
                    $.each(images, function (index, item) {
                        _insetImage(item, _DOMAIN);
                    });
                    $imageBox.parent().show();
                    break;
                default:
                    $editInput.show();
            }
        }
    });

    //修改测评活动提交
    $('#applyDetailSubmit').click(function () {
        if ($editInput.attr('name') === 'image_path') {
            var headimg = [];
            for (i = 0; i < $imageBox.find('img').length; i++) {
                headimg.push($imageBox.find("img:eq(" + i + ")").attr("data-value"));
            }
            $editInput.val(headimg);
        }

        $.post(_URL + '/list/edit/' + $editInput.attr('data-type'), {
            activity_id: $editInput.attr('data-value'),
            field: $editInput.attr('name'),
            value: $editInput.val(),
            _token: _TOKEN
        }, function (data) {
            if (data) {
                location.reload();
                alert('修改成功');
            }
        })

    });

    //奖品表单验证
    $prizeForm.form({
        fields: {
            image_path: ['empty'],
            name: ['empty', 'maxLength[100]'],
            count: ['empty', 'number'],
            cost: ['empty', 'number'],
            type: ['empty', 'number'],
            expire: ['empty', 'number']
        }
    });

    //奖品表单提交
    $('#prizeSubmit').click(function () {
        $prizeForm.form('set values', {
            image_path: $imageBox.find('img').attr('data-value')
        });
    });

    //奖品开启或关闭
    $('.toggle.prize.checkbox')
        .checkbox({
            onChange: function () {
                $.get(_URL + '/prize/toggle/' + $(this).val());
                $(this).checkbox('toggle');
            }
        })
    ;

    //奖品修改
    $('.prizeEdit').click(function () {
        $("#prizeSubmit").text('修改').removeClass('green').addClass('blue');
        $.get(_URL + '/prize/getPrize/' + $(this).attr('data-value'), function (prize) {
            $prizeForm.form('set values', prize);
            $imageBox.empty();
            _insetImage(prize.image_path, _DOMAIN);
        }, 'json');
    });

    //修改管理员密码
    $resetPasswordForm.form({
        fields: {
            'password': ['empty', 'minLength[6]'],
            'resetPassword': ['empty', 'minLength[6]', 'different[password]'],
            'resetPasswordConfirm': ['empty', 'minLength[6]', 'match[resetPassword]']
        }
    });

    //奖品邮寄状态修改
    $('.checkbox.post').checkbox({
        onChange: function () {
            $.get(_URL + '/post/toggle/' + $(this).attr('data-value'));
            $(this).checkbox('toggle');
        }
    })
    ;

    //测评产品修改和添加
    $productForm.form({
        fields: {
            status: ['empty'],
            image_url: ['empty'],
            name: ['empty', 'maxLength[100]'],
            brand: ['maxLength[100]'],
            price: ['empty', 'number'],
            packet_code: ['number'],
            carton_code: ['number']
        }
    });

    $('#productSubmit').click(function () {
        $productForm.form('set values', {
            image_url: $imageBox.find('img').attr('data-value')
        });
    });

    $('.productEdit').click(function () {
        $("#productSubmit").text('修改').removeClass('green').addClass('blue');
        $.get(_URL + '/product/getProduct/' + $(this).attr('data-value'), function (product) {
            $productForm.form('set values', product);
            $imageBox.empty();
            _insetImage(product.image_url, _DOMAIN);
        }, 'json');
    });


    //帮助文章开启和关闭
    $('.helpArticles.checkbox')
        .checkbox({
            onChange: function () {
                $.get(_URL + '/help/setHelp/' + $(this).val());
                $(this).checkbox('toggle');
            }
        })
    ;


    //同意申请开启和关闭
    $('.applyView.checkbox')
        .checkbox({
            onChange: function () {
                $.get(_URL + '/list/view/setResultApply/' + $(this).val());
                $(this).checkbox('toggle');
            }
        })
    ;


    //邮寄，只允许开启
    $('.applyView.checkbox')
        .checkbox({
            onChange: function () {
                $.get(_URL + '/list/view/setResultApply/' + $(this).val());
                $(this).checkbox('toggle');
            }
        })
    ;

    //图片弹窗预览
    var $preview = $('#preview');

    $('img.preview.image').click(function () {
        $preview = $('#preview');
        $preview.find('img:first').attr('src',$(this).attr('src'));
        $preview.modal('setting',{detachable:false,observeChanges:true,closable:true}).modal('show').modal('refresh');;
    });

    $preview.find('img:first').click(function () {
        $preview.modal('hide');
    });
});

//生成图片元素
function _createImage(src, url) {
    return '<div class="card"><div class="blurring dimmable image"><div class="ui dimmer"><div class="content"><div class="center"><div class="ui inverted button delete">删除</div></div></div></div><img data-value="' + src + '" src="' + url + src + '"></div></div>';
}

//插入图片
function _insetImage(src, url) {
    var $imageBox = $('#imageBox');
    var image = _createImage(src, url);
    //这里我就默认假设用户之前没有添加任何图片，以便复用
    $imageBox.append(image);
    $imageBox.find('.image').dimmer({
        on: 'hover'
    });
    $imageBox.find('.delete').click(function () {
        $(this).closest('.card').remove();
    });
}