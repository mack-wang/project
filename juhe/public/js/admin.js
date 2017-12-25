$(document).ready(function () {

    var $imageBox = $('#imageBox');
    var modifyArticleId = $.trim($('#modifyArticleId').attr('data-value'));
    var $navForm = $("#navForm");
    var $headlineForm = $("#headlineForm");
    var $connectForm = $("#connectForm");
    var $wechatForm = $("#wechatForm");
    var $companyForm = $("#companyForm");
    var $resetPasswordForm = $('#resetPasswordForm');

    $('.ui.dropdown.article').dropdown();

    //目录修改
    $catalogForm = $('#catalogForm');
    $catalogForm.form({
        fields: {
            catalog: ['empty', 'maxLength[32]', 'minLength[1]']
        }
    });

    $('.edit.catalog').click(function () {
        $parent = $(this).parent().parent();

        $catalogForm.form('set values', {
            id: $parent.find('td:eq(0)').text(),
            catalog: $parent.find('td:eq(1)').text()
        });

        $('.blue.button.catalog').text('修改目录');
    });

    //文章上传
    $articleForm = $('#articleForm');
    $articleForm.form({
        fields: {
            image: ['empty'],
            catalog: ['empty'],
            brand: ['empty', 'maxLength[32]'],
            title: ['empty', 'maxLength[64]'],
            brief: ['empty', 'maxLength[255]'],
            content: ['empty']
        }
    });

    $('.submit.article.button').click(function () {
        $articleForm.form('set values', {
            image: $imageBox.find('img').attr("data-value"),
            content: UE.getEditor('ueditor').getContent()
        });
    });

    //作为通用的图片上传模板
    if (document.getElementById('uploadImage')) {
        var ue = UE.getEditor('uploadImage');
        ue.ready(function () {
            ue.setHide();
            ue.execCommand('serverparam', '_token', _TOKEN);

            //弹出图片上传的对话框
            $("#imageAdd").click(function () {
                ue.getDialog("insertimage").open();
            });

            //插入要上传的图片，并绑定删除事件
            ue.addListener('beforeInsertImage', function (t, arg) {
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

    //作为通用的文章上传模板
    if (document.getElementById('ueditor')) {
        var ue2 = UE.getEditor('ueditor');
        ue2.ready(function () {
            ue2.execCommand('serverparam', '_token', _TOKEN);
        });
    }


    if (modifyArticleId.length > 0) {
        $.get(_URL + '/product/getArticle/' + modifyArticleId, function (article) {
            _insetImage(article.image, _DOMAIN);
            var ue = UE.getEditor('ueditor');
            ue.ready(function () {
                ue.setContent(article.content);
            });
            $('.submit.article.button').text('修改');
            $articleForm.form('set values', article)
        }, 'json');
    }

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
            $headlineForm.form("set value", "article_id", result.id);
            $companyForm.form("set value", "article_id", result.id);
        }
    });

    $navForm.form({
        fields: {
            image_path: ['empty']
        }
    });

    $companyForm.form({
        fields: {
            article_id: ['empty']
        }
    });

    //导航开启或关闭
    $('.toggle.nav.checkbox')
        .checkbox({
            onChange: function () {
                $.get(_URL + '/index/navToggle/' + $(this).val());
                $(this).checkbox('toggle');
            }
        })
    ;

    //导航修改
    $('.navEdit').click(function () {
        $("#navSubmit").text('修改');
        $("#articleTitle").text($(this).attr('data-title'));
        $.get(_URL + '/nav/getNav/' + $(this).attr('data-value'), function (nav) {
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


    //目录推荐，关闭，置顶的ajax
    $('.checkbox.recommend').checkbox({
        onChange: function () {
            $.get(_URL + '/product/catalog/recommend/' + $(this).val());
            $(this).checkbox('toggle');
        }
    });

    $('.checkbox.top').checkbox({
        onChange: function () {
            $.get(_URL + '/product/catalog/top/' + $(this).val());
            $(this).checkbox('toggle');
        }
    });

    $('.checkbox.article-top').checkbox({
        onChange: function () {
            $.get(_URL + '/article/top/' + $(this).val());
            $(this).checkbox('toggle');
        }
    });

    $('.checkbox.off').checkbox({
        onChange: function () {
            $.get(_URL + '/product/catalog/off/' + $(this).val());
            $(this).checkbox('toggle');
        }
    });

    $headlineForm.form({
        fields: {
            headline: ['empty', 'maxLength[125]']
        }
    });

    $('.edit.headline').click(function () {
        $("#headlineSubmit").text('修改');
        $.get(_URL + '/index/getHeadline/' + $(this).attr('data-value'), function (headline) {
            $headlineForm.form('set values', {
                id: headline.id,
                headline: headline.headline
            });
        }, 'json');
    });

    //服务热线表单提交
    $connectForm.form({
        fields: {
            image: ['empty', 'maxLength[255]'],
            phone: ['empty', 'maxLength[16]'],
            time: ['empty', 'maxLength[32]'],
            content: ['empty', 'maxLength[125]']
        }
    });

    $('#connectSubmit').click(function (e) {
        $connectForm.form('set value', 'image', $imageBox.find('img').attr('data-value'));
    });

    //微信分享设置表单提交
    $wechatForm.form({
        fields: {
            imgUrl: ['empty', 'maxLength[255]'],
            description: ['empty', 'maxLength[255]'],
            title: ['empty', 'maxLength[255]'],
            link: ['empty', 'maxLength[255]']
        }
    });

    $('#wechatSubmit').click(function (e) {
        $wechatForm.form('set value', 'imgUrl', $imageBox.find('img').attr('data-value'));
    });

    //修改管理员密码
    $resetPasswordForm.form({
        fields: {
            'password': ['empty', 'minLength[6]'],
            'resetPassword': ['empty', 'minLength[6]', 'different[password]'],
            'resetPasswordConfirm': ['empty', 'minLength[6]', 'match[resetPassword]']
        }
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