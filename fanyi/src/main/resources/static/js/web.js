/**
 * Created by wanglecheng on 8/22/17.
 */

$(function () {

    $("div.fixContent").each(function () {
        var element = $(this);
        var temp = element.text().replace(/\n/g, '<br/>');
        element.html(temp);
    });

});

$(document).ready(function () {
    //根据id为activeMenu的元素的data-value的值来激活对应的menu

    //判断是否是IE9
    var browser = navigator.appName;
    var b_version = navigator.appVersion;
    var version = b_version.split(";");
    if (version[1]) {
        var trim_Version = version[1].replace(/[ ]/g, "");
    } else {
        var trim_Version = "";
    }

    var isIE9 = browser == "Microsoft Internet Explorer" && trim_Version == "MSIE9.0";

    if (isIE9) {
        $("head").append('<link href="/css/ie9.css" rel="stylesheet"/>');
        //使ie9兼容placeholder
        $(function () {
            jQuery('[placeholder]').focus(function () {
                var input = jQuery(this);
                if (input.val() == input.attr('placeholder')) {
                    input.val('');
                    input.removeClass('placeholder');
                }
            }).blur(function () {
                var input = jQuery(this);
                if (input.val() == '' || input.val() == input.attr('placeholder')) {
                    input.addClass('placeholder');
                    input.val(input.attr('placeholder'));
                }
            }).blur().parents('form').submit(function () {
                jQuery(this).find('[placeholder]').each(function () {
                    var input = jQuery(this);
                    if (input.val() == input.attr('placeholder')) {
                        input.val('');
                    }
                })
            });
        });
    }
    ;


    //异步获取客服列表
    if ($(".customerService")[0]) {
        //<a class="item" th:href="@{/chat?to=service1}">翻易客服1</a>
        $.get("/customer/service", function (data) {
            var elems = "";
            $.each(data, function (index, item) {
                elems += '<a class="item" href="/chat?to=' + item[0] + '">' + item[1] + '</a>'
            });
            $(".customerService").append(elems);
        }, "json")
    }

    //用户注册验证
    var $registerUserForm = $("#registerUserForm");
    $registerUserForm
        .form({
            on: 'blur',
            inline: true,//添加此属性，才会显示提示
            fields: {
                phone: {
                    identifier: 'phone',
                    rules: [
                        {
                            type: 'exactLength[11]',
                            prompt: '请输入11位手机号'
                        },
                        {
                            type: 'regExp[/^1/]',
                            prompt: '请输入正确的手机号'
                        }
                    ]
                },
                username: {
                    identifier: 'username',
                    rules: [
                        {
                            type: 'regExp[/^[A-Za-z0-9_-]{3,32}$/]',
                            prompt: '请输入3到32个字符的用户名,可包含字母、数字、横线、下划线'
                        }
                    ]
                },
                password: {
                    identifier: 'password',
                    rules: [
                        {
                            type: 'empty',
                            prompt: '密码不能为空'
                        },
                        {
                            type: 'minLength[6]',
                            prompt: '密码至少为6位'
                        },
                        {
                            type: 'maxLength[32]',
                            prompt: '密码不得大于32位'
                        }
                    ]

                },
                passwordConfirm: {
                    identifier: 'passwordConfirm',
                    rules: [
                        {
                            type: 'match[password]',
                            prompt: '确认密码和原密码必须相同'
                        }
                    ]
                },
                sms: {
                    identifier: 'sms',
                    rules: [
                        {
                            type: 'number',
                            prompt: '短信验证码为6位数字'
                        },
                        {
                            type: 'minLength[6]',
                            prompt: '短信验证码为6位数字'
                        }
                    ]
                },
                rule: {
                    identifier: 'rule',
                    rules: [
                        {
                            type: 'checked',//检查checkbox是否勾选上
                            prompt: '请确认已经阅读注册声明'
                        }
                    ]
                }
            }
        })
    ;

    //异步检查用户名是否重复
    $registerUserForm.find("input[name=username]").on("blur", function () {
        var $this = $(this);
        //判断用户名是否已经存在
        $.post("/public/user/exists/",
            $registerUserForm.form("get values", ["username", "_csrf"]),
            function (data) {
                if (data == true) {
                    $this.parent().addClass("error");
                    $this.next().remove();
                    $this.after('<div class="ui basic red pointing prompt label transition visible">账号已被使用</div>');
                }
            });
    });

    //异步检查昵称是否被使用
    $registerUserForm.find("input[name=nickname]").on("blur", function () {
        var $this = $(this);
        //判断用户名是否已经存在
        $.post("/public/nickname/exists/",
            $registerUserForm.form("get values", ["nickname", "_csrf"]),
            function (data) {
                if (data == true) {
                    $this.parent().addClass("error");
                    $this.next().remove();
                    $this.after('<div class="ui basic red pointing prompt label transition visible">昵称已被使用</div>');
                }
            });
    });


    //注册页面，异步检查手机号是否被使用
    $registerUserForm.find("input[name=phone]").on("blur", function () {
        var $this = $(this);
        //判断用户名是否已经存在
        $.post("/public/phone/exists/",
            $registerUserForm.form("get values", ["phone", "_csrf"]),
            function (data) {
                if (data == true) {
                    timeOn = true;
                    $this.parent().parent().addClass("error");
                    $this.parent().next().remove();
                    $this.parent().after('<div class="ui basic red pointing prompt label transition visible">手机号已被使用</div>');
                } else {
                    timeOn = false;
                    $this.parent().parent().removeClass("error");
                    $this.parent().next().remove();
                }
            });
    });


    $("#registerRule").click(function () {

        layer.open({
            title: "翻易服务协议",
            type: 1,
            content: $(".userAgreement").removeClass("hide"),
            btn: ['我同意', '我不同意'],
            yes: function () {
                layer.closeAll();
                $(".ui.checkbox.registerRule").checkbox("check");
                $(".userAgreement").addClass("hide")
            },
            btn2: function () {
                $(".userAgreement").addClass("hide")
            },
            cancel: function () {
                $(".userAgreement").addClass("hide");
            }
        });
    });


    //异步发送短信验证码
    //短信倒计时
    var timer = 60;
    var timeOn = false;
    var $getSms = $('#getSms');
    $getSms.click(function () {

        if ($("#newPhone")[0]) {
            $("#newPhone").trigger("blur");
        }

        var phone = $("input[name=phone]").val();
        var captcha = $("input[name=captcha]").val();
        if (phone.length != 11) {
            alert("手机号不正确！");
            return false;
        }

        if (captcha.length != 4) {
            alert("图形验证码输入有误！");
            return false;
        }

        if (timeOn) return false;
        timeOn = true;
        $.post('/public/sendSms/', {phone: phone, captcha: captcha},
            function (data) {
                if (data == "success") {
                    alert("短信验证码已经发送");
                } else {
                    timer = 0;
                    if (data == "phoneError") {
                        alert("手机号错误");
                    }

                    if (data == "sendError") {
                        alert("短信发送失败");
                    }

                    if (data == "captchaError") {
                        alert("图形验证码错误");
                    }

                    if (data == "tooOften") {
                        alert("获取短信验证码过于频繁，请1分钟后再试");
                    }
                }
            });
        function Countdown() {
            if (timer >= 1) {
                timer -= 1;
                $getSms.text(timer + 's');
                setTimeout(function () {
                    Countdown();
                }, 1000);
            } else {
                $getSms.text('获取短信验证码');
                timer = 60;
                timeOn = false;
            }
        }

        Countdown();
    });

    $(".remember.checkbox").checkbox();

    $("#registerUserSubmit").click(function (e) {
        e.preventDefault();
        if ($(".field.error").length > 0) {
            $(".field.error").transition('shake');
        } else {
            $registerUserForm.submit();
        }
    });

//用户登入表单
    var $userLoginForm = $("#userLoginForm");
    $userLoginForm.form({
        inline: true,//添加此属性，才会显示提示
        fields: {
            username: {
                identifier: 'username',
                rules: [
                    {
                        type: 'regExp[/^[A-Za-z0-9_-]{3,32}$/]',
                        prompt: '请输入3到32个字符的用户名,可包含字母、数字、横线、下划线'
                    }
                ]
            },
            password: {
                identifier: 'password',
                rules: [
                    {
                        type: 'empty',
                        prompt: '密码不能为空'
                    },
                    {
                        type: 'minLength[6]',
                        prompt: '密码至少为6位'
                    },
                    {
                        type: 'maxLength[32]',
                        prompt: '密码不得大于32位'
                    }
                ]
            }
        }
    });


//用户手机登入表单验证
    var $userLoginByPhoneForm = $("#userLoginByPhoneForm");
    $userLoginByPhoneForm.form({
        inline: true,//添加此属性，才会显示提示
        fields: {
            phone: {
                identifier: 'phone',
                rules: [
                    {
                        type: 'exactLength[11]',
                        prompt: '请输入11位手机号'
                    },
                    {
                        type: 'regExp[/^1/]',
                        prompt: '请输入正确的手机号'
                    }
                ]
            },
            password2: {
                identifier: 'password2',
                rules: [
                    {
                        type: 'requiredOne[sms]',
                        prompt: '密码不能为空'
                    }
                ]
            },
            sms: {
                identifier: 'sms',
                rules: [
                    {
                        type: 'requiredOne[password2]',
                        prompt: '短信验证码不能为空'
                    }
                ]
            }
        }
    });


//任何页面都可以退出，退出要post所以使用了这个
    $(".logout").click(function () {
        $('#logoutForm').submit();
    });

//激活tab
    $('.tabular.menu .item').tab();

    $('.ui.rating')
        .rating()
    ;

    $('.homeTab .menu .item')
        .tab({
            context: '.homeTab'
        })
    ;


//用户修改昵称
    var toggle = 0;
    $("#updateNickname").click(function () {
        if (toggle == 0) {
            $(this).text("确认");
            var nickname = $("#nicknameTd").text();

            $("#nicknameTd").text("").append('<div class="ui input"><input type="text" name="nickname" value="' + nickname + '"></div>');
            toggle = 1;
        } else {
            var nickname = $("#nicknameTd").find("div>input").val();
            if (nickname.length < 2 || nickname.length > 32) {
                alert("昵称应在2到32个字符之间");
                return;
            }
            $(this).text("修改昵称");
            $.get("/update/nickname/" + nickname);
            $("#nicknameTd").text(nickname);
            //把缓存处昵称显示修改
            $(".nickname").text(nickname);
            toggle = 0;
        }
    });


//用户修改性别
    $(".sex.checkbox").checkbox({
        onChange: function () {
            var sex = $(this).val();
            var sexNumber;
            $("#sex").text(sex);
            if (sex == "男") {
                sexNumber = 1;
            } else {
                sexNumber = 0
            }
            $.get("/update/sex/" + sexNumber);
        }
    });

//用户修改简介
    var toggle1 = 0;
    $("#updateIntroduce").click(function () {
        if (toggle1 == 0) {
            $(this).text("确认");
            var introduce = $.trim($("#introduce").text());
            $("#introduce").text("").append('<div class="ui input"><input type="text" name="introduce" value="' + introduce + '"></div>');
            toggle1 = 1;
        } else {
            $(this).text("修改简介");
            var introduce = $("#introduce").find("div>input").val();
            if (introduce.length > 125) {
                alert("简介应该小于125个字");
                return;
            }
            $.get("/update/introduce/" + introduce);
            $("#introduce").text(introduce);
            toggle1 = 0;
        }
    });

//用户前去进行认证
    $("#toUserAuth").click(function () {
        $(".menu>.item[data-tab=third]").click();
    });


    if ($("#updateProvince")[0]) {
        $.get("/rest/mhCities/search/level?level=1", function (data) {
            var options = "";
            var cities = data._embedded.mhCities;

            $.each(cities, function (index, item) {
                options += "<option value='" + item["id"] + "'>" + item["name"] + "</option>"
            });
            $("#updateProvince").append(options);
        }, "json");
    }


//做城市设置
    $(".dropdown.province").dropdown({
        onChange: function () {
            var pid = $(this).find("option:selected").val();
            $.get("/rest/mhCities/search/pid?pid=" + pid, function (data) {
                var options = "<option value=''>城市</option>";
                var cities = data._embedded.mhCities;
                $.each(cities, function (index, item) {
                    options += "<option value='" + item["id"] + "'>" + item["name"] + "</option>"
                });
                $("#updateCity").empty().append(options);
            }, "json");
        }
    });

    $("#updateCityButton").click(function () {
        var value = $(".dropdown.city").dropdown("get value");
        if (value.length == 0) {
            alert("您未选择任何城市");
            return;
        }

        $.post("/update/city", {city: value}, function (data) {
            if (data == true) {
                alert("修改成功");
                location.href = "/home";
            } else {
                alert("修改失败");
            }
        })
    });

//判断当前是否是login界面
    if (window.location.href.indexOf("login") > 0) {
        $("#registerAndLogin>.item").removeClass("active");
        $("#registerAndLogin>.item:eq(1)").addClass("active");
    }

//根据url的hash部分，来切换tab
// if (window.location.hash) {
//     var hash = window.location.hash.replace("#", "");
//     $(".menu>.item[data-tab=" + hash + "]").click();
// }

//判断用户注册的手机是否有人在用
//判断用户修改的新手机号是否有人在用
    $("#newPhone").on("blur", function () {
        var $this = $(this);
        var phone = $this.val();
        if (phone.length != 11) return;
        $.post("/public/phone/exists/",
            {phone: phone},
            function (data) {
                if (data == true) {
                    $this.parent().parent().addClass("error");
                    $this.parent().next().remove();
                    $this.parent().after('<div class="ui basic red pointing prompt label transition visible">手机号已被使用</div>');
                } else {
                    $this.parent().parent().removeClass("error");
                    $this.parent().next().remove();
                }
            });
    });

//修改邮箱，验证字段
//用户手机登入表单验证
    var $updateEmailForm = $("#updateEmailForm");
    $updateEmailForm.form({
        inline: true,//添加此属性，才会显示提示
        fields: {
            email: {
                identifier: 'email',
                rules: [
                    {
                        type: 'email',
                        prompt: '请输入正确的邮箱号'
                    }
                ]
            }
        }
    });

    $('#updateEmailButton').click(function (e) {
        e.preventDefault();
        var $this = $("input[name=email]");
        var email = $this.val();
        if (email.length > 0 && email.indexOf("@") > 0) {
            $.post("/public/email/exists",
                {email: email},
                function (data) {
                    if (data == true) {
                        $this.parent().addClass("error");
                        $this.next().remove();
                        $this.after('<div class="ui basic red pointing prompt label transition visible">邮箱已被使用</div>');
                        return;
                    } else {
                        $this.parent().removeClass("error");
                        $this.next().remove();
                        $updateEmailForm.submit();
                    }
                });
        } else {
            $updateEmailForm.submit();
        }
    });

//实名认证城市选项加载
//加载省
    if ($(".dropdown.authProvince")[0]) {
        $.get("/rest/mhCities/search/level?level=1", function (data) {
            var options = "";
            var cities = data._embedded.mhCities;
            $.each(cities, function (index, item) {
                options += "<div class='item' data-value='" + item["id"] + "'>" + item["name"] + "</div>"
            });
            $(".dropdown.authProvince").find(".menu").append(options);
        }, "json");
    }

//加载市
    $(".dropdown.authProvince").dropdown({
        onChange: function () {
            var pid = $(this).dropdown("get value");
            $.get("/rest/mhCities/search/pid?pid=" + pid, function (data) {
                var options = "";
                var cities = data._embedded.mhCities;
                $.each(cities, function (index, item) {
                    options += "<div class='item' data-value='" + item["id"] + "'>" + item["name"] + "</div>"
                });
                $(".dropdown.authCity").find(".menu").append(options);
            }, "json");
        }
    });

//加载区
    $(".dropdown.authCity").dropdown({
        onChange: function () {
            var pid = $(this).dropdown("get value");
            $.get("/rest/mhCities/search/pid?pid=" + pid, function (data) {
                var options = "";
                var cities = data._embedded.mhCities;
                $.each(cities, function (index, item) {
                    options += "<div class='item' data-value='" + item["id"] + "'>" + item["name"] + "</div>"
                });
                $(".dropdown.authArea").find(".menu").append(options);
            }, "json");
        }
    });

//实名认证
//上传身份证正面
    $("#idCardFrontButton").click(function () {
        $("input[name=idCardFront]").click();
    });

    $("#idCardBackButton").click(function () {
        $("input[name=idCardBack]").click();
    });

//身份证照片预览
    $("input[name=idCardFront]").on("change", function () {
        if (this.files[0].size > 2 * 1024 * 1024) {
            alert("图片不得大于2M，请重新选择");
            $(this).val("");
            return;
        }
        var src = getObjectURL(this.files[0]);
        $("#idCardFrontButton").prev().attr("src", src);
    });

    $("input[name=idCardBack]").on("change", function () {
        if (this.files[0].size > 2 * 1024 * 1024) {
            alert("图片不得大于2M，请重新选择");
            $(this).val("");
            return;
        }
        var src = getObjectURL(this.files[0]);
        $("#idCardBackButton").prev().attr("src", src);
    });

//实名认证表单提交验证
    var $nameCertificateForm = $("#nameCertificateForm");
    $nameCertificateForm
        .form({
            on: 'blur',
            inline: true,//添加此属性，才会显示提示
            fields: {
                name: {
                    identifier: 'name',
                    rules: [
                        {
                            type: 'empty',
                            prompt: '姓名不能为空'
                        },
                        {
                            type: 'regExp[/^[\u4e00-\u9fa5][\u4e00-\u9fa5]{1,5}$/]',
                            prompt: '请输入2到6个汉字中文名（特殊名字情况请输入简称）'
                        }
                    ]
                },
                address: {
                    identifier: 'address',
                    rules: [
                        {
                            type: 'empty',
                            prompt: '具体地址不能为空'
                        },
                        {
                            type: 'minLength[2]',
                            prompt: '至少输入2个字'
                        }
                    ]
                },
                idNumber: {
                    identifier: 'idNumber',
                    rules: [
                        {
                            type: 'empty',
                            prompt: '身份证号码不能为空'
                        },
                        {
                            type: 'minLength[15]',
                            prompt: '身份证号码不正确'
                        },
                        {
                            type: 'maxLength[18]',
                            prompt: '身份证号码不正确'
                        }
                    ]
                }
            }
        })
    ;

    $nameCertificateForm.on("submit", function (e) {
        var province = $(".dropdown.authProvince").dropdown("get value");
        var city = $(".dropdown.authCity").dropdown("get value");
        var area = $(".dropdown.authArea").dropdown("get value");
        var idCardFront = $("input[name=idCardFront]").val();
        var idCardBack = $("input[name=idCardBack]").val();
        var $area = $("#areaField");
        var $id = $("#idField");
        if (province.length == 0 || city.length == 0 || area.length == 0) {
            $area.parent().addClass("error");
            $area.next().remove();
            $area.after('<div class="ui basic red pointing prompt label transition visible">居住地址未选择完整</div>');
            e.preventDefault();
            return;
        } else {
            $area.parent().removeClass("error");
            $area.next().remove();
        }

        if (idCardFront.length == 0 || idCardBack.length == 0) {
            $id.parent().addClass("error");
            $id.next().remove();
            $id.after('<div class="ui basic red pointing prompt label transition visible">身份证未上传完整</div>');
            e.preventDefault();
            return;
        } else {
            $id.parent().removeClass("error");
            $id.next().remove();
        }

        $(this).form("set values", {
            province: province,
            city: city,
            area: area,
            idCardFront: idCardFront,
            idCardBack: idCardBack
        });
    });


//显示证书种类列表
    if ($(".certificateKind")[0]) {
        $.get("/rest/certificateKinds", function (data) {
            var options = "";
            var kinds = data._embedded.certificateKinds;
            $.each(kinds, function (index, item) {
                options += "<option value='" + item["id"] + "'>" + item["name"] + "</option>"
            });
            $(".certificateKind").find('select').append(options);
        }, "json");
    }

//添加其他证书
    $("#addCertificate").click(function () {
        var value = $("#otherCertificateInput").val();
        if (value.length > 0) {
            var same = false;
            $("#addCertificateContainer").find("a").each(function () {
                if ($(this).data("value") == value) {
                    same = true;
                    return;
                }
            });
            if (same) {
                alert("相同资质证书不能重复添加");
                return;
            }

            var elem = '<a class="ui compact large label transition visible labelFix" data-value="' + value + '">' + value + '<i class="delete icon"></i></a>';
            $("#addCertificateContainer").append(elem);
            $("#addCertificateContainer").find(".delete.icon").click(function () {
                $(this).parent().remove();
            });
            $("#otherCertificateInput").val("");
        } else {
            alert("未填写任何资质证书名称");
            return;
        }
    });

//翻译语言不能和原语言相同
    $(".dropdown.translate").dropdown({
        onChange: function (value) {

        }
    });

//添加翻译价格，并验证
    $("#addTranslatePrice").click(function () {
        var group = $(".dropdown.group").dropdown("get value");
        var type = $(".dropdown.translateType").dropdown("get value");
        var price = $("#prices").val();
        var priceType = $(".dropdown.translatePrice").dropdown("get value");
        var groupText = $(".dropdown.group").dropdown("get text");
        var typeText = $(".dropdown.translateType").dropdown("get text");
        var priceText = $(".dropdown.translatePrice").dropdown("get text");
        var text = groupText + "，" + typeText + "，" + price + priceText;
        if (hasEmpty([group, type, price, priceType])) {
            alert("未填写完整，请检查");
            return;
        } else {

            if (parseInt(price) != price) {
                alert("价格应该为整数");
                return;
            }

            var value = group + '&' + type + '&' + price + '&' + priceType;

            var same = false;
            $("#translatePriceContainer").find("a").each(function () {
                if ($(this).data("value") == value) {
                    same = true;
                    return;
                }
            });

            if (same) {
                alert("不能重复添加相同的翻译价格");
                return;
            }

            if (type == "translate") {
                if (priceType == "hour" || priceType == "day") {
                    alert("笔译的价格单位不能为元/小时，元/天");
                    return;
                }
            } else {
                if (priceType == "word" || priceType == "page") {
                    alert("口译的价格单位不能为元/千字，元/页");
                    return;
                }
            }

            var elem = '<a class="ui large label transition visible labelFix" data-value="' + value + '">' + text + '<i class="delete icon"></i></a>';
            $("#translatePriceContainer").append(elem);
            $("#translatePriceContainer").find(".delete.icon").click(function () {
                $(this).parent().remove();
            });

            //重置
            $("#translatePriceField").find(".dropdown").dropdown("restore defaults");
            $("#prices").val("");
        }
    });

//加载母语
    if ($(".language.dropdown")[0]) {
        $.get("/rest/languageses", function (data) {
            var options = "";
            var items = data._embedded.languageses;
            $.each(items, function (index, item) {
                options += "<option value='" + item["id"] + "'>" + item["name"] + "</option>"
            });
            $(".language.dropdown").find("select").append(options);
        }, "json");
    }

//加载擅长领域
    if ($(".skilledField.dropdown")[0]) {
        $.get("/rest/skilledFields", function (data) {
            var options = "";
            var items = data._embedded.skilledFields;
            $.each(items, function (index, item) {
                options += "<option value='" + item["id"] + "'>" + item["skilledField"] + "</option>"
            });
            $(".skilledField.dropdown").find("select").append(options);
        }, "json");
    }
//加载擅长领域
    if ($(".skilledUsage.dropdown")[0]) {
        $.get("/rest/skilledUsages", function (data) {
            var options = "";
            var items = data._embedded.skilledUsages;
            $.each(items, function (index, item) {
                options += "<option value='" + item["id"] + "'>" + item["skilledUsage"] + "</option>"
            });
            $(".skilledUsage.dropdown").find("select").append(options);
        }, "json");
    }

//重置教育背景
    $(".educationReset").click(function () {
        $("#educationFields>.field>input").val("");
    });

//重置其他资质
    $(".otherCertificateReset").click(function () {
        $("#otherCertificateInput").val("");
    });

//重置翻译语言
    $(".translatePriceReset").click(function () {
        $("#translatePriceField").find(".dropdown").dropdown("restore defaults");
        $("#prices").val("");
    });

//添加学历按钮
    $("#addEducation").click(function () {
        var $educationFields = $("#educationFields");
        var number = $educationFields.find("input:eq(1)").val();
        var school = $educationFields.find("input:eq(2)").val();
        var degree = $educationFields.find("input:eq(3)").val();
        var major = $educationFields.find("input:eq(4)").val();
        var startYear = $educationFields.find("input:eq(5)").val();
        var endYear = $educationFields.find("input:eq(6)").val();
        var text = number + "，" + school + "，" + degree + "，" + major + "，" + startYear + "年入学，" + endYear + "年毕业";
        var value = number + "&" + school + "&" + degree + "&" + major + "&" + startYear + "&" + endYear;
        if (hasEmpty([number, school, degree, major, startYear, endYear])) {
            alert("学历未填写完整，请检查");
            return;
        } else {
            var same = false;
            $("#educationFieldsContainer").find("a").each(function () {
                if ($(this).data("value") == value) {
                    same = true;
                    return;
                }
            });
            if (same) {
                alert("相同学历不能重复添加");
                return;
            }

            //检查年份
            if (startYear.length != 4 || (startYear.substr(0, 2) != "19" && startYear.substr(0, 2) != "20")) {
                alert("入学年份不正确，请填写1900~2099内的数字");
                return;
            }

            //检查年份
            if (endYear.length != 4 || (endYear.substr(0, 2) != "19" && endYear.substr(0, 2) != "20")) {
                alert("毕业年份不正确，请填写1900~2099内的数字");
                return;
            }

            var elem = '<a class="ui large label transition visible labelFix" data-value="' + value + '">' + text + '<i class="delete icon"></i></a>';
            $("#educationFieldsContainer").append(elem);
            $("#educationFieldsContainer").find(".delete.icon").click(function () {
                $(this).parent().remove();
            });

            //重置
            $("#educationFields>.field>input").val("");
        }
    });


    $("#educationCertificateForm").form({
        on: 'blur',
        inline: true,//添加此属性，才会显示提示
        fields: {
            education: {
                identifier: 'education',
                rules: [
                    {
                        type: 'empty',
                        prompt: '教育背景不能为空'
                    }
                ]
            },
            language: {
                identifier: 'language',
                rules: [
                    {
                        type: 'empty',
                        prompt: '母语不能为空'
                    }
                ]
            },
            certificate: {
                identifier: 'certificate',
                rules: [
                    {
                        type: 'different[otherCertificate]',
                        prompt: '资质证书不能为空'
                    }
                ]
            },
            certificatePictureUrl: {
                identifier: 'certificatePictureUrl',
                rules: [
                    {
                        type: 'empty',
                        prompt: '资质证书照片不能为空'
                    }
                ]
            },
            price: {
                identifier: 'price',
                rules: [
                    {
                        type: 'empty',
                        prompt: '翻译语言不能为空'
                    }
                ]
            },
            translateYear: {
                identifier: 'translateYear',
                rules: [
                    {
                        type: 'empty',
                        prompt: '翻译年限不能为空'
                    },
                    {
                        type: 'decimal',
                        prompt: '翻译年限应为整数'
                    }

                ]
            },
            skilledField: {
                identifier: 'skilledField',
                rules: [
                    {
                        type: 'empty',
                        prompt: '擅长领域不能为空'
                    }
                ]
            },
            skilledUsage: {
                identifier: 'skilledUsage',
                rules: [
                    {
                        type: 'empty',
                        prompt: '擅长用途不能为空'
                    }
                ]
            },
        }
    });


    $("#educationCertificateSubmit").click(function (e) {
        var $form = $("#educationCertificateForm");
        var education = [];
        var otherCertificate = [];
        var price = [];
        // var educationPicture = [];
        var certificatePicture = [];
        $("#educationFieldsContainer").find("a").each(function () {
            education.push($(this).data("value"));
        });

        $("#addCertificateContainer").find("a").each(function () {
            otherCertificate.push($(this).data("value"));
        });

        $("#translatePriceContainer").find("a").each(function () {
            price.push($(this).data("value"));
        });

        //学历照片不用再交了
        // $("#educationPictureContainer").children("div:gt(0)").each(function () {
        //     educationPicture.push($(this).data("value"));
        // });

        $("#certificatePictureContainer").children("div:gt(0)").each(function () {
            certificatePicture.push($(this).data("value"));
        });

        $form.form("set values", {
            education: education,
            certificate: $(".certificateKind.dropdown").dropdown("get value"),
            otherCertificate: otherCertificate,
            price: price,
            language: $(".language.dropdown").dropdown("get value"),
            skilledField: $(".skilledField.dropdown").dropdown("get value"),
            skilledUsage: $(".skilledUsage.dropdown").dropdown("get value"),
            // educationPictureUrl: educationPicture,
            certificatePictureUrl: certificatePicture
        });

    });


//用户修改真实姓名
    var toggle2 = 0;
    $("#updateRealName").click(function () {
        var $target = $(this).parent().prev();
        if (toggle2 == 0) {
            $(this).text("确认");
            var realName = $target.text();
            $target.text("").append('<div class="ui input"><input type="text" name="realName" value="' + realName + '"></div>');
            toggle2 = 1;
        } else {
            $(this).text("修改姓名");
            var realName = $target.find("div>input").val();
            if (realName.length < 2 || realName.length > 6) {
                alert("姓名应在2到6个字符之间");
                return;
            }
            $.post("/update/realName", {realName: realName});
            $target.text(realName);
            toggle2 = 0;
        }
    });

    $("#updateAddressClick").click(function () {
        $(".ui.tab.active[data-tab=first]").hide();
        $("#updateAddressTab").attr("data-tab", "first").removeClass("hide");
    });


    $("#updateAddressButton").click(function (e) {
        e.preventDefault();
        var $this = $("#updateAddressForm");

        var $areaField = $("#areaField");
        var province = $areaField.children("div:eq(0)").dropdown("get value");
        var city = $areaField.children("div:eq(1)").dropdown("get value");
        var area = $areaField.children("div:eq(2)").dropdown("get value");
        if (hasEmpty([province, city, area])) {
            alert("城市未选择完整");
            return;
        }

        var address = $this.form("get value", "address");
        if (address.length < 2) {
            alert("详细地址最少为2个字符");
            return;
        }

        $this.form("set value", "provinceCityAreaId", [province, city, area]);
        $this.submit();
    });

//禁止dropdown显示选择的内容到text
    $('.indexMenuDropdown.dropdown')
        .dropdown({
            action: 'hide'
        })
    ;

//修改姓名验证
    $("#updateNameForm").form({
        inline: true,//添加此属性，才会显示提示
        fields: {
            name: {
                identifier: 'name',
                rules: [
                    {
                        type: 'regExp[/^[\u4e00-\u9fa5][\u4e00-\u9fa5]{1,5}$/]',
                        prompt: '请输入2到6个汉字中文名（特殊名字情况请输入简称）'
                    }
                ]
            },
        }
    });

//修改身份证验证
    $("#updateIdNumberForm").form({
        inline: true,//添加此属性，才会显示提示
        fields: {
            idNumber: {
                identifier: 'idNumber',
                rules: [
                    {
                        type: 'empty',
                        prompt: '身份证号码不能为空'
                    },
                    {
                        type: 'minLength[15]',
                        prompt: '身份证号码不正确'
                    },
                    {
                        type: 'maxLength[18]',
                        prompt: '身份证号码不正确'
                    }
                ]
            }
        }
    });

    $("#updateIdCardForm").on("submit", function (e) {
        if (hasEmpty([$(this).form("get value", "idCardFront")])) {
            alert("身份证正面照片不能为空");
            e.preventDefault();
            return;
        }
        if (hasEmpty([$(this).form("get value", "idCardBack")])) {
            alert("身份证背面照片不能为空");
            e.preventDefault();
            return;
        }
    });

    $("#forgetPassword").click(function () {
        alert("忘记密码可以通过【手机号登录-短信验证码登录】修改密码。若手机号停用，请通过在线客服进行申诉！")
    });

    var toggle3 = 1;
    $("#loginBySms").click(function () {
        if (toggle3) {
            $userLoginByPhoneForm.children(".field:eq(1)").toggleClass("hide");
            $userLoginByPhoneForm.children(".field:eq(2)").toggleClass("hide");
            $userLoginByPhoneForm.children(".field:eq(3)").toggleClass("hide");
            $(this).text("密码登录");
            toggle3 = 0
        } else {
            $userLoginByPhoneForm.children(".field:eq(1)").toggleClass("hide");
            $userLoginByPhoneForm.children(".field:eq(2)").toggleClass("hide");
            $userLoginByPhoneForm.children(".field:eq(3)").toggleClass("hide");
            $(this).text("短信验证码登录");
            toggle3 = 1;
        }
    });

//企业认证提交
    var $companyCertificateForm = $("#companyCertificateForm");
    $companyCertificateForm.form({
        inline: true,//添加此属性，才会显示提示
        fields: {
            company: {
                identifier: 'company',
                rules: [
                    {
                        type: 'empty',
                        prompt: '企业名称不能为空'
                    },
                ]
            },
            licensePictureUrl: {
                identifier: 'licensePictureUrl',
                rules: [
                    {
                        type: 'empty',
                        prompt: '企业执照不能为空'
                    },
                ]
            },
            address: {
                identifier: 'address',
                rules: [
                    {
                        type: 'empty',
                        prompt: '详细地址不能为空'
                    },
                ]
            },
            contactName: {
                identifier: 'contactName',
                rules: [
                    {
                        type: 'empty',
                        prompt: '联系人姓名不能为空'
                    },
                ]
            },
            contactPhone: {
                identifier: 'contactPhone',
                rules: [
                    {
                        type: 'empty',
                        prompt: '联系方式不能为空'
                    },
                ]
            },
        }
    });

    $("#companyCertificateSubmit").click(function (e) {
        var $areaField = $("#areaField");
        var province = $areaField.children("div:eq(0)").dropdown("get value");
        var city = $areaField.children("div:eq(1)").dropdown("get value");
        var area = $areaField.children("div:eq(2)").dropdown("get value");
        if (hasEmpty([province, city, area])) {
            alert("城市未选择完整");
            return;
        }
        $companyCertificateForm.form("set values", {
            province: province,
            city: city,
            area: area,
            licensePictureUrl: $("#licensePictureContainer").children("div:gt(0)").data("value")
        });
    });

//客户任务附件修改字数
    $("#attachmentBox").find(".remove").click(function () {
        $(this).parent().parent().remove();
    });

    $("#attachmentBox").find(".wordCount").click(function () {
        var $that = $(this).parent().prev();
        var text = $that.data("value");
        if (text.length != 0) {
            $that.text("").append('<div class="ui input"><input class="inputCount" value="' + text + '" type="text" placeholder="请输入字数"></div>');
        }
    });

//任务-显示翻译内容实时字数
    $("#translateContent").on("keyup", function () {
        var $this = $(this);
        var str = $this.val();
        $("#wordsCount").text(wordCount(str));
        var result = str.replace(/\s/g, "").replace(/[\r\n]/g, "");//去掉空格,去掉换行
        $("#charsCount").text(result.length);
    });

//任务-翻译内容提交
    var $taskTranslateOneForm = $("#taskTranslateOneForm");

    $taskTranslateOneForm.form({
        inline: true,//添加此属性，才会显示提示
        fields: {
            translateGroup: {
                identifier: 'translateGroup',
                rules: [
                    {
                        type: 'empty',
                        prompt: '翻译语言不能为空'
                    },
                ]
            },
            title: {
                identifier: 'title',
                rules: [
                    {
                        type: 'empty',
                        prompt: '任务标题不能为空'
                    },
                    {
                        type: 'maxLength[255]',
                        prompt: '任务标题不能大于255个字符'
                    },
                ]
            },
            translateContent: {
                identifier: 'translateContent',
                rules: [
                    {
                        type: 'requiredOne[attachmentUrl]',
                        prompt: '翻译内容或者翻译文件不能都为空'
                    },
                    {
                        type: 'maxLength[10000]',
                        prompt: '翻译内容不能超过1万字，大文本请使用附件上传'
                    },
                ]
            }
        }
    });

    if ($("select[name=interpretType]").length > 0) {
        //验证设置是覆盖的，后者全覆盖前者
        $taskTranslateOneForm.form({
            inline: true,//添加此属性，才会显示提示
            fields: {
                translateGroup: {
                    identifier: 'translateGroup',
                    rules: [
                        {
                            type: 'empty',
                            prompt: '翻译语言不能为空'
                        },
                    ]
                },
                title: {
                    identifier: 'title',
                    rules: [
                        {
                            type: 'empty',
                            prompt: '任务标题不能为空'
                        },
                        {
                            type: 'maxLength[255]',
                            prompt: '任务标题不能大于255个字'
                        },
                    ]
                },
                translateContent: {
                    identifier: 'translateContent',
                    rules: [
                        {
                            type: 'requiredOne[attachmentUrl]',
                            prompt: '翻译内容或者翻译文件不能都为空'
                        },
                        {
                            type: 'maxLength[10000]',
                            prompt: '翻译内容不能超过1万字，大文本请使用附件上传'
                        },
                    ]
                },
                workTime: {
                    identifier: 'workTime',
                    rules: [
                        {
                            type: 'between[0-25]',
                            prompt: '只能填写1-24之间的整数'
                        },
                        {
                            type: 'empty',
                            prompt: '只能填写1-24之间的整数'
                        },
                        {
                            type: 'regExp[^([1-9][0-9]*)$]',
                            prompt: '必须是整数'
                        },
                    ]
                },
                interpretStartTime: {
                    identifier: 'interpretStartTime',
                    rules: [
                        {
                            type: 'empty',
                            prompt: '口译开始时间不能为空'
                        },
                    ]
                },
                interpretEndTime: {
                    identifier: 'interpretEndTime',
                    rules: [
                        {
                            type: 'empty',
                            prompt: '口译结束时间不能为空'
                        },
                    ]
                },
                province: {
                    identifier: 'province',
                    rules: [
                        {
                            type: 'empty',
                            prompt: '省份未选择'
                        },
                    ]
                },
                city: {
                    identifier: 'city',
                    rules: [
                        {
                            type: 'empty',
                            prompt: '城市未选择'
                        },
                    ]
                },
                area: {
                    identifier: 'area',
                    rules: [
                        {
                            type: 'empty',
                            prompt: '地区未选择'
                        },
                    ]
                },
                address: {
                    identifier: 'address',
                    rules: [
                        {
                            type: 'empty',
                            prompt: '详细地址不能为空'
                        },
                        {
                            type: 'minLength[2]',
                            prompt: '至少输入2个字'
                        }
                    ]
                }
            }
        });
    }

    $taskTranslateOneForm.find(".submitButton").click(function (e) {
        var attachment = [];
        var clientWords = [];
        var error = false;

        //专门为口译准备的验证

        $.each($("#attachmentBox").find("tr"), function (index, item) {
            if ($(item).find("td:eq(1)").text().length == 0) {
                alert("附件正在上传中，请稍等片刻...");
                error = true;
            }

            attachment.push($(item).data("value"));
            var val = $(item).find(".words").text();
            if ($.trim(val).length > 0) {
                //判断字数是否是整数
                if (parseInt(val) != val) {
                    alert("附件字数必须填整数");
                    error = true;
                }

                clientWords.push(val);
            } else {
                alert("附件字数必须要填哦");
                error = true;
            }

            if ($(item).find(".wordCount").hasClass("confirm")) {
                alert("您还有未确认字数的附件，请点击确认！");
                error = true;
            }

        });
        if (error) return;

        $taskTranslateOneForm.form("set values", {
            attachmentUrl: attachment,
            clientWords: clientWords
        }).submit();
    });

    var $taskTranslateTwoForm = $("#taskTranslateTwoForm");
    $taskTranslateTwoForm.form({
        inline: true,//添加此属性，才会显示提示
        fields: {
            brief: {
                identifier: 'brief',
                rules: [
                    {
                        type: 'maxLength[140]',
                        prompt: '内容摘要不能超过140字'
                    },
                ]
            },
            translateRequest: {
                identifier: 'translateRequest',
                rules: [
                    {
                        type: 'empty',
                        prompt: '翻译要求不能为空'
                    },
                    {
                        type: 'maxLength[1000]',
                        prompt: '翻译要求不能超过1000字'
                    },
                ]
            },
        }
    });

//启动semantic日历
    var $start = $('#rangestart'), $end = $('#rangeend');

    if ($start.length > 0) {
        $start.calendar({
            minDate: new Date(),
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
            minDate: new Date(),
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

    var $timeStart = $('#timeStart');
    if ($timeStart.length > 0) {
        $timeStart.calendar({
            minDate: new Date(),
            type: 'datetime',
            text: _TEXT,
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


//翻译任务发布任务提交
    var $taskTranslateThreeForm = $("#taskTranslateThreeForm");
    if ($("#isInterpretForm").length > 0) {
        $taskTranslateThreeForm.form({
            on: "blur",
            inline: true,//添加此属性，才会显示提示
            fields: {
                taskEndTime: {
                    identifier: 'taskEndTime',
                    rules: [
                        {
                            type: 'empty',
                            prompt: '任务截止时间不能为空'
                        },
                    ]
                }
            }
        });
    } else {
        $taskTranslateThreeForm.form({
            on: "blur",
            inline: true,//添加此属性，才会显示提示
            fields: {
                taskEndTime: {
                    identifier: 'taskEndTime',
                    rules: [
                        {
                            type: 'empty',
                            prompt: '任务截止时间不能为空'
                        },
                    ]
                },
                translateEndTime: {
                    identifier: 'translateEndTime',
                    rules: [
                        {
                            type: 'empty',
                            prompt: '翻译稿件交稿时间不能为空'
                        },
                    ]
                }
            }
        });
    }


//任务关键词市场搜索
    $("#marketSearchButton").click(function () {
        var val = $(this).prev("input").val();
        if (val.length == 0) {
            alert("您未输入关键词");
            return;
        }
        var param = "";
        if ($(this).data('value').indexOf("?") < 0) {
            param = "?title=";
        } else {
            param = "&title=";
        }
        location.href = encodeURI($(this).data('value') + param + val);
    });

    var $marketLanguageGroup = $(".dropdown.marketLanguageGroup");
    if ($marketLanguageGroup.find(".selected").length > 0) {
        var text = $marketLanguageGroup.find(".selected").text();
        var elem = '<a class="item active">' + text + '</a>';
        $marketLanguageGroup.after(elem);
    }

    $marketLanguageGroup.dropdown({
        action: "hide"
    });

    var $chatInput = $("#chatInput");
    $chatInput.focus();

//显示未读信息数量
    $.post("/chat/getUnread", function (data) {
        $("#getUnread").find("label").text(data);
    });

    $("#taskSelectedForm").form({
        on: "blur",
        inline: true,//添加此属性，才会显示提示
        fields: {
            price: {
                identifier: 'price',
                rules: [
                    {
                        type: 'empty',
                        prompt: '投标金额不能为空'
                    },
                    {
                        type: 'number',
                        prompt: '投标金额必须为数字'
                    },
                    {
                        type: 'minDecimalMath[0]',
                        prompt: '投标金额不能小于等于0'
                    },
                    {
                        type: 'decimalPoint[2]',
                        prompt: '投标金额最多2位小数'
                    },
                ]
            }
        }
    })

    var $taskEditForm = $("#taskEditForm");
    $taskEditForm.form({
        inline: true,//添加此属性，才会显示提示
        fields: {
            title: {
                identifier: 'title',
                rules: [
                    {
                        type: 'empty',
                        prompt: '任务标题不能为空'
                    },
                    {
                        type: 'maxLength[255]',
                        prompt: '任务标题不能大于255个字符'
                    },
                ]
            },
            translateRequest: {
                identifier: 'translateRequest',
                rules: [
                    {
                        type: 'empty',
                        prompt: '翻译要求不能为空'
                    },
                    {
                        type: 'maxLength[1000]',
                        prompt: '翻译要求不能超过1000字'
                    },
                ]
            },
        }
    });

    $("#taskEditSubmit").click(function () {

        var top = $("input[name=top]:checked").val();
        var price = $("input[name=top]:checked").data("value");
        $taskEditForm.form("set value", "topValue", top);

        if (top != 0) {
            showPayInput(price, $taskEditForm)
        } else {
            $taskEditForm.submit();
        }
    });

    //支付预付款
    $(".taskSelect.button").click(function () {
        var price = $(this).data("price");
        var $taskSelectForm = $("#taskSelectForm");
        $taskSelectForm.form("set value", "username", $(this).data("value"));
        //直接支付预付款
        showPayInput(price, $taskSelectForm);
    });

    var toggle4 = 1;
    $(".changeTenderPrice").click(function () {
        var price = $(this).data("price");
        var id = $(this).data("id");
        if (toggle4) {
            $(this).prev("span").remove();
            $(this).parent().prepend('<div class="ui compact input" style="width: 100px"><input type="text" name="price" value="' + price + '"></div>')
            $(this).text("确认")
            ;
            toggle4 = 0;
        } else {
            price = $(this).prev("div.input").children("input").val();
            if (/^\d+(\.\d{1,2})?$/.test(price)) {
                $(this).prev("div.input").remove();

                $(this).parent().prepend('<span>' + price + '元</span>');
                $(this).text("修改")
                    .attr("data-price", price)
                ;

                $.post("/tender/price", {price: price, id: id}, function (data) {
                    if (data == false) {
                        alert("修改失败！");
                        return;
                    }
                });

                toggle4 = 1;
            } else {
                alert("金额为整数或者两位以内的小数");
                return;
            }
        }
    });


//译员提交翻译稿件
    var $tenderTranslateForm = $("#tenderTranslateForm");
    $tenderTranslateForm.form({
        inline: true,//添加此属性，才会显示提示
        fields: {
            translateContent: {
                identifier: 'translateContent',
                rules: [
                    {
                        type: 'requiredOne[attachmentUrl]',
                        prompt: '翻译内容或者翻译文件不能都为空'
                    },
                    {
                        type: 'maxLength[10000]',
                        prompt: '翻译内容不能超过1万字，大文本请使用附件上传'
                    }
                ]
            }
        }
    });

    $tenderTranslateForm.find(".submitButton").click(function (e) {
        var attachment = [];
        var clientWords = [];
        var error = false;

        $.each($("#attachmentBox").find("tr"), function (index, item) {
            if ($(item).find("td:eq(1)").text().length == 0) {
                alert("附件正在上传中，请稍等片刻...");
                error = true;
            }

            attachment.push($(item).data("value"));
            var val = $(item).find(".words").text();
            if ($.trim(val).length > 0) {
                //判断字数是否是整数
                if (parseInt(val) != val) {
                    alert("附件字数必须填整数");
                    error = true;
                }

                clientWords.push(val);
            } else {
                alert("附件字数必须要填哦");
                error = true;
            }

            if ($(item).find(".wordCount").hasClass("confirm")) {
                alert("您还有未确认字数的附件，请点击确认！");
                error = true;
            }

        });
        if (error) return;

        $tenderTranslateForm.form("set values", {
            attachmentUrl: attachment,
            clientWords: clientWords
        }).submit();
    });

//修改意见
    $("#translateAdviceForm").form({
        inline: true,//添加此属性，才会显示提示
        fields: {
            advice: {
                identifier: 'advice',
                rules: [
                    {
                        type: 'empty',
                        prompt: '修改意见不能为空'
                    },
                    {
                        type: 'maxLength[10000]',
                        prompt: '修改意见不能超过10000字'
                    }
                ]
            }
        }
    });

//评价选择按钮激活
    $(".taskComment>.button").click(function () {
        $(this).toggleClass("blue");
    });

    $("#taskCommentForm").form({
        inline: true,//添加此属性，才会显示提示
        fields: {
            clientComment: {
                identifier: 'clientComment',
                rules: [
                    {
                        type: 'maxLength[140]',
                        prompt: '评价不能超过140字'
                    }
                ]
            }
        }
    });

    $(".commentFormSubmit").click(function () {
        var $form = $(this).parent();
        var templateComment = [];
        $(".taskComment>.blue.button").each(function () {
            templateComment.push($(this).text());
        });
        if (templateComment.length > 0) {
            $form.form("set value", "templateComment", templateComment);
        }
        //打分提交
        $form.form("set value", "star", $(".ui.star.rating.taskComment").rating("get rating"));
        $form.submit();
    });

//评价后的星不能动
    $(".ui.star.rating.taskCommented").rating("disable");

//切换查看全文和局部全文
    $(".switchContent").click(function () {
        $(this).text() == '查看全文' ? $(this).text("收起") : $(this).text("查看全文");
        $(this).parent().children("div").toggleClass("hide");
    })

//咨询在线客服留言
    $(".serviceQuestion").form({
        inline: true,//添加此属性，才会显示提示
        fields: {
            question: {
                identifier: 'question',
                rules: [
                    {
                        type: 'empty',
                        prompt: '咨询问题不能为空'
                    },
                    {
                        type: 'maxLength[400]',
                        prompt: '咨询问题不能超过400字'
                    },
                    {
                        type: 'minLength[15]',
                        prompt: '咨询问题不能少于15字'
                    }
                ]
            },
            email: {
                identifier: 'question',
                rules: [
                    {
                        type: 'empty',
                        prompt: '邮箱不能为空'
                    },
                    {
                        type: 'email',
                        prompt: '邮箱格式错误'
                    }
                ]
            }
        }
    });
})
;

function showPayInput(price, $form) {
    //显示支付金额
    $("#payDetail").find("span:eq(1)").text(price);
    //如果余额不足，显示充值,乘100后比较，以免出错
    if ($("#payDetail").find("span:eq(0)").text() * 100 < price * 100) {
        $("#payDetail").children("div:last").removeClass("hide");
    } else {
        $("#payDetail").children("div:last").addClass("hide");
    }

    layer.open({
        title: "请输入支付密码",
        type: 1,
        content: $("#payInput").removeClass("hide"),
        btn: ['确认支付', '取消支付'],
        yes: function () {
            var password = "";
            $.each($("#payInput").find("input"), function (index, item) {
                password += $(item).val();
            });
            if (password.length != 6) {
                alert("支付密码未填写完成");
                return;
            }
            if (parseInt(password) != password) {
                alert("支付密码为6位数字");
                return;
            }
            $form.form("set value", "password", password).submit();
            $("#clearPayPassword").click();
        },
        btn2: function () {
            $("#clearPayPassword").click();
            $("#payInput").addClass("hide");
        },
        cancel: function () {
            $("#payInput").addClass("hide");
            $("#clearPayPassword").click();
        }
    });
}

function hasEmpty(paramArray) {
    var result = false;
    $.each(paramArray, function (index, item) {
        if ($.trim(item).length == 0) {
            return result = true;
        }
    });
    return result;
}

function wordCount(str) {
    var count = 0;
    for (var i = 0; i <= str.length; i++) {
        if (str.charAt(i) == " " || str.charAt(i) == "\n") {//检查空格和回车
            count++;
        }
    }
    return count;
}

(function (window, document) {
    //只允许输入数字
    $("#payInput>input").bind("keyup", function () {
        if (parseInt($(this).val()) != $(this).val()) {
            $(this).val("");
            active++;
        }
        // $(this).val($(this).val().replace(/[^\-?\d.]/g,''));
    });

    //清空支付密码
    $("#clearPayPassword").click(function () {
        $(this).prevAll("input").val("");
        active = 0;
    });

    var active = 0,
        inputBtn = document.querySelectorAll('#payInput>input');
    for (var i = 0; i < inputBtn.length; i++) {
        inputBtn[i].addEventListener('click', function () {
            inputBtn[active].focus();
        }, false);
        inputBtn[i].addEventListener('focus', function () {
            this.addEventListener('keyup', listenKeyUp, false);
        }, false);
        inputBtn[i].addEventListener('blur', function () {
            this.removeEventListener('keyup', listenKeyUp, false);
        }, false);
    }

    /**
     * 监听键盘的敲击事件
     */
    function listenKeyUp() {
        var beginBtn = document.querySelector('#beginBtn');
        if (!isNaN(this.value) && this.value.length != 0) {
            if (active < 5) {
                active += 1;
            }
            inputBtn[active].focus();
        } else if (this.value.length == 0) {
            this.value = "";
            if (active > 0) {
                active -= 1;
            }
            inputBtn[active].focus();
        }
        if (active >= 5) {
            var _value = inputBtn[active].value;
            if (beginBtn.className == 'begin-no' && !isNaN(_value) && _value.length != 0) {
                beginBtn.className = 'begin';
                beginBtn.addEventListener('click', function () {
                    calculate.begin();
                }, false);
            }
        } else {
            if (beginBtn.className == 'begin') {
                beginBtn.className = 'begin-no';
            }
        }
    }
})(window, document);

$(function () {
    //显示激活菜单状态


    //管理员-用户列表搜索
    $("#adminUserListSearch").click(function () {
        var url = $(this).data("value");
        var key = $(this).prev().dropdown("get value");
        var value = $(this).prev().prev().val();
        if (value.length == 0) {
            alert("未输入任何搜索条件");
            return;
        }
        location.href = encodeURI(url + '?' + key + '=' + value);
    });

    //回复用户留言
    $(".questionRespond").click(function () {
        var $form = $(this).parent().parent().find("form");
        var respond = $form.form("get value", "respond");
        if (respond.length == 0 || respond.length > 400) {
            alert("字数不能为0或者大于400字");
            return;
        }
        $form.submit();
    });

    //以弹窗的形式显示所有 .showImage
    $(".showImage").click(function () {
        layer.open({
            type: 1,
            title: false,
            closeBtn: 0,
            area: '800px',
            skin: 'layui-layer-nobg', //没有背景色
            shadeClose: true,
            content: '<img src="' + $(this).attr("src") + '" style="width:100%" />'
        });
    });

    //实名认证审核
    $("#checkRealNameForm").find(".submitButton").click(function () {
        var $form = $(this).parent();
        var reasons = [];
        $(".taskComment>.blue.button").each(function () {
            reasons.push($(this).text());
        });
        var reason = $form.form("get value", "reason");
        if (reason.length > 0) {
            reasons.push(reason);
        }

        if (reasons.length > 0) {
            $form.form("set value", "reasons", reasons);
        } else {
            alert("您未选择或输入任何审核不通过的理由！");
            return;
        }
        $form.submit();
    });

    //用户修改学历
    $("#updateEducationForm>.submitButton").click(function (e) {
        e.preventDefault();
        var $form = $("#updateEducationForm");
        var education = [];
        $("#educationFieldsContainer").find("a").each(function () {
            education.push($(this).data("value"));
        });
        if (education.length == 0) {
            alert("您未提交任何学历");
            return;
        }
        $form.form("set value", "education", education).submit();

    });

    //修改资质证书及其照片
    $("#updateCertificateBook").click(function (e) {
        e.preventDefault();
        var $form = $(this).parent();
        var otherCertificate = [];
        var certificatePicture = [];
        $("#addCertificateContainer").find("a").each(function () {
            otherCertificate.push($(this).data("value"));
        });

        $("#certificatePictureContainer").children("div:gt(0)").each(function () {
            certificatePicture.push($(this).data("value"));
        });

        if (otherCertificate.length == 0) {
            alert("您未提交任何资质证书");
            return;
        }

        if (certificatePicture.length == 0) {
            alert("您未提交任何资质证书照片");
            return;
        }

        $form.form("set values", {
            certificate: $(".certificateKind.dropdown").dropdown("get value"),
            otherCertificate: otherCertificate,
            certificatePictureUrl: certificatePicture
        }).submit();
    });

    //修改翻译价格
    $("#updateTranslatePrice").click(function (e) {
        e.preventDefault();
        var $form = $(this).parent();
        var price = [];
        $("#translatePriceContainer").find("a").each(function () {
            price.push($(this).data("value"));
        });

        if (price.length == 0) {
            alert("您未提交任何翻译语言");
            return;
        }

        $form.form("set values", {
            price: price,
        }).submit();
    });

    $("#updateMotherTongueForm").form({
        inline: true,//添加此属性，才会显示提示
        fields: {
            language: {
                identifier: 'language',
                rules: [
                    {
                        type: 'empty',
                        prompt: '母语不能为空'
                    }
                ]
            }
        }
    })

    $("#updateTranslateYearForm").form({
        inline: true,//添加此属性，才会显示提示
        fields: {
            translateYear: {
                identifier: 'translateYear',
                rules: [
                    {
                        type: 'empty',
                        prompt: '翻译年限不能为空'
                    },
                    {
                        type: 'decimal',
                        prompt: '翻译年限应为整数'
                    }
                ]
            }
        }
    })

    $("#updateSkilledFieldForm>.submitButton").click(function (e) {
        e.preventDefault();
        var skilled = $(".skilledField.dropdown").dropdown("get value");
        if (skilled.length == 0) {
            alert("您未选择任何擅长领域");
            return;
        }
        $(this).parent().form("set value", "skilledField", skilled).submit()
    });

    $("#updateSkilledUsageForm>.submitButton").click(function (e) {
        e.preventDefault();
        var skilled = $(".skilledUsage.dropdown").dropdown("get value");
        if (skilled.length == 0) {
            alert("您未选择任何擅长领域");
            return;
        }
        $(this).parent().form("set value", "skilledUsage", skilled).submit();
    });

    //修改企业名称
    $("#updateCompanyNameForm").form({
        inline: true,//添加此属性，才会显示提示
        fields: {
            name: {
                identifier: 'name',
                rules: [
                    {
                        type: 'empty',
                        prompt: '企业名称不能为空'
                    },
                    {
                        type: 'maxLength[225]',
                        prompt: '企业名称最长为225字'
                    }
                ]
            }
        }
    });

    //修改营业执照
    $("#updateLicenseForm").form({
        inline: true,//添加此属性，才会显示提示
        fields: {
            licensePictureUrl: {
                identifier: 'licensePictureUrl',
                rules: [
                    {
                        type: 'empty',
                        prompt: '营业执照不能为空'
                    }
                ]
            }
        }
    });

    $("#updateLicenseForm>.submitButton").click(function (e) {
        e.preventDefault();
        $("#updateLicenseForm").form("set value", "licensePictureUrl", $("#licensePictureContainer").children("div:gt(0)").data("value")).submit();
    });

    //修改联系人名字
    $("#updateContactNameForm").form({
        inline: true,//添加此属性，才会显示提示
        fields: {
            contactName: {
                identifier: 'contactName',
                rules: [
                    {
                        type: 'empty',
                        prompt: '联系人姓名不能为空'
                    }
                ]
            }
        }
    });

    //修改联系方式
    $("#updateContactPhoneForm").form({
        inline: true,//添加此属性，才会显示提示
        fields: {
            contactPhone: {
                identifier: 'contactPhone',
                rules: [
                    {
                        type: 'empty',
                        prompt: '联系方式不能为空'
                    }
                ]
            }
        }
    });

    if (document.getElementById("editorText")) {
        //<!-- 注意， 只需要引用 JS，无需引用任何 CSS ！！！-->
        //文章图片上传
        var E = window.wangEditor;
        var editor = new E('#editorToolbar', '#editorText');
        // 或者 var editor = new E( document.getElementById('#editor') )
        editor.customConfig.uploadImgServer = '/admin/upload';
        // 将图片大小限制为 3M
        editor.customConfig.uploadImgMaxSize = 3 * 1024 * 1024;
        // 限制一次最多上传 5 张图片
        editor.customConfig.uploadImgMaxLength = 5;

        //上传图片时可自定义传递一些参数，例如传递验证的_csrf等。参数会被添加到formdata中。
        editor.customConfig.uploadImgParams = {
            _csrf: _token
        };


        editor.create();

        //让图片宽度为100%；
        $(".w-e-menu>.ui.expand.icon").click(function () {
            $("img.w-e-selected").toggleClass("fullWidth");
        })
    }

    var $catalogUpdateForm = $("#catalogUpdateForm");

    //目录添加
    $catalogUpdateForm.form({
        fields: {
            catalog: {
                identifier: 'catalog',
                rules: [
                    {
                        type: 'empty',
                        prompt: '目录中文名不能为空'
                    },
                    {
                        type: 'maxLength[100]',
                        prompt: '目录中文名不能长于100字'
                    }
                ]
            },
            ecatalog: {
                identifier: 'ecatalog',
                rules: [
                    {
                        type: 'empty',
                        prompt: '目录英文名不能为空'
                    },
                    {
                        type: 'maxLength[100]',
                        prompt: '目录英文名不能长于100字'
                    }
                ]
            }
        }
    });

    //修改目录
    $(".edit.catalog").click(function () {
        var $parent = $(this).parent().parent();
        $catalogUpdateForm.form("set values", {
            id: $parent.children("td:eq(0)").text(),
            catalog: $parent.children("td:eq(1)").text(),
            ecatalog: $parent.children("td:eq(2)").text()
        });
        $(".cancelCatalogEdit").removeClass("hide");
        $catalogUpdateForm.find(".submit").text("修改目录");
    });

    $(".cancelCatalogEdit").click(function () {
        $catalogUpdateForm.form("reset");
        $(this).prev().text("添加新目录");
        $(this).addClass("hide");
    });

    //目录置顶修改
    $('.catalogTop.checkbox')
        .checkbox({
            onChange: function () {
                $.get('/admin/catalog/top?id=' + $(this).val());
                $(this).checkbox('toggle');
            }
        })
    ;

    //目录关闭修改
    $('.catalogOff.checkbox')
        .checkbox({
            onChange: function () {
                $.get('/admin/catalog/off?id=' + $(this).val());
                $(this).checkbox('toggle');
            }
        })
    ;

    var $articleForm = $("#articleForm");
    $articleForm.form({
        inline: true,//添加此属性，才会显示提示
        fields: {
            title: {
                identifier: 'title',
                rules: [
                    {
                        type: 'empty',
                        prompt: '文章标题不能为空'
                    },
                    {
                        type: 'maxLength[255]',
                        prompt: '文章标题不能长于255字符'
                    }
                ]
            },
            article: {
                identifier: 'article',
                rules: [
                    {
                        type: 'empty',
                        prompt: '文章内容不能为空'
                    },
                    {
                        type: 'maxLength[10000]',
                        prompt: '文章内容不能大于1万字'
                    }
                ]
            }
        }
    });

    $articleForm.find(".submitButton").click(function () {
        console.log(editor.txt.html());
        $articleForm.form("set value", "article", editor.txt.html()).submit();
    });

    //文章置顶修改
    $('.articleTop.checkbox')
        .checkbox({
            onChange: function () {
                $.get('/admin/article/top?id=' + $(this).val());
                $(this).checkbox('toggle');
            }
        })
    ;

    //文章关闭修改
    $('.articleOff.checkbox')
        .checkbox({
            onChange: function () {
                $.get('/admin/article/off?id=' + $(this).val());
                $(this).checkbox('toggle');
            }
        })
    ;

    //做个虚假的点赞按钮
    $("#thumbsButton>.button").click(function () {
        $(this).toggleClass("blue");
    });

    //让文章列表，点击td就能跳转到相应的链接
    $("#activeLink>tr>td").click(function () {
        location.href = $(this).children("a").attr("href");
    });


    //文章搜索
    $('.ui.search.article')
        .search({
            apiSettings: {
                url: '/article/search?title={query}',
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
                location.href = "/article?id=" + result.id;
            }
        });

    //创建支付密码验证
    $("#payPasswordAddForm").form({
        inline: true,//添加此属性，才会显示提示
        fields: {
            password: {
                identifier: 'password',
                rules: [
                    {
                        type: 'empty',
                        prompt: '支付密码不能为空'
                    },
                    {
                        type: 'exactLength[6]',
                        prompt: '支付密码必须为6位的数字'
                    },
                    {
                        type: 'regExp[/^[0-9]*$/]',
                        prompt: '支付密码必须为6位的数字'
                    }
                ]
            },
            passwordConfirm: {
                identifier: 'passwordConfirm',
                rules: [
                    {
                        type: 'empty',
                        prompt: '重复支付密码不能为空'
                    },
                    {
                        type: 'match[password]',
                        prompt: '重复支付密码必须和新密码相同'
                    }
                ]
            }
        }
    });

    //修改支付密码验证
    $("#payPasswordUpdateForm").form({
        inline: true,//添加此属性，才会显示提示
        fields: {
            passwordOld: {
                identifier: 'passwordOld',
                rules: [
                    {
                        type: 'empty',
                        prompt: '旧密码不能为空'
                    },
                    {
                        type: 'exactLength[6]',
                        prompt: '旧密码必须为6位的数字'
                    },
                    {
                        type: 'regExp[/^[0-9]*$/]',
                        prompt: '旧密码必须为6位的数字'
                    }
                ]
            },
            password: {
                identifier: 'password',
                rules: [
                    {
                        type: 'empty',
                        prompt: '支付密码不能为空'
                    },
                    {
                        type: 'exactLength[6]',
                        prompt: '支付密码必须为6位的数字'
                    },
                    {
                        type: 'regExp[/^[0-9]*$/]',
                        prompt: '支付密码必须为6位的数字'
                    },
                    {
                        type: 'different[passwordOld]',
                        prompt: '支付密码必须和旧密码不同'
                    }
                ]
            }
        }
    });

    //新增vip
    $("#vipAddForm").form({
        inline: true,//添加此属性，才会显示提示
        fields: {
            username: {
                identifier: 'username',
                rules: [
                    {
                        type: 'regExp[/^[A-Za-z0-9_-]{3,32}$/]',
                        prompt: '用户名不正确'
                    }
                ]
            },
            endTime: {
                identifier: 'endTime',
                rules: [
                    {
                        type: 'empty',
                        prompt: '合同到期日不能为空'
                    }
                ]
            }
        }
    });

    //新增vip的翻译价格
    //修改翻译价格
    $("#vipAddForm").find(".submit.button").click(function (e) {
        e.preventDefault();
        var $form = $("#vipAddForm");
        var price = [];
        $("#translatePriceContainer").find("a").each(function () {
            price.push($(this).data("value"));
        });

        console.log(price);

        if (price.length == 0) {
            alert("您未提交任何翻译价格");
            return;
        }

        $form.form("set values", {
            price: price
        });
    });

    //新建vip任务
    $("#viptaskAddForm").form({
        inline: true,//添加此属性，才会显示提示
        fields: {
            title: {
                identifier: 'title',
                rules: [
                    {
                        type: 'empty',
                        prompt: '任务标题不能为空'
                    }
                ],
                rules: [
                    {
                        type: 'maxLength[64]',
                        prompt: '任务标题不能大于64字'
                    }
                ]
            },
            languageGroup: {
                identifier: 'languageGroup',
                rules: [
                    {
                        type: 'empty',
                        prompt: '翻译语言不能为空'
                    }
                ]
            },
            path: {
                identifier: 'path',
                rules: [
                    {
                        type: 'empty',
                        prompt: '翻译内容附件不能为空'
                    }
                ]
            },
            unitPrice: {
                identifier: 'unitPrice',
                rules: [
                    {
                        type: 'empty',
                        prompt: '单价不能为空'
                    },
                    {
                        type: 'number',
                        prompt: '单价必须为数字'
                    },
                    {
                        type: 'minDecimalMath[0]',
                        prompt: '单价不能小于等于0'
                    },
                    {
                        type: 'decimalPoint[3]',
                        prompt: '单价最多3位小数'
                    },
                ]
            },
            word: {
                identifier: 'word',
                rules: [
                    {
                        type: 'number',
                        prompt: '翻译字数必须为数字'
                    },
                ]
            },
            hour: {
                identifier: 'hour',
                rules: [
                    {
                        type: 'number',
                        prompt: '翻译时长必须为数字'
                    },
                    {
                        type: 'requiredOne[word]',
                        prompt: '翻译字数和翻译时长至少要填一项'
                    }
                ]
            },
            price: {
                identifier: 'price',
                rules: [
                    {
                        type: 'empty',
                        prompt: '总额不能为空'
                    },
                    {
                        type: 'number',
                        prompt: '总额必须为数字'
                    },
                    {
                        type: 'minDecimalMath[0]',
                        prompt: '总额不能小于等于0'
                    },
                    {
                        type: 'decimalPoint[2]',
                        prompt: '总额最多2位小数'
                    }
                ]
            }
        }
    });

    //提交vip任务翻译稿件
    $("#vipTaskTranslateForm").form({
        inline: true,
        fields: {
            path: {
                identifier: 'path',
                rules: [
                    {
                        type: 'empty',
                        prompt: '翻译稿件不能为空'
                    }
                ]
            }
        }
    });

    //支付单个vip账单
    $(".billPay").click(function () {
        var id = $(this).data("id");
        var price = $(this).data("value");
        $("#billPayForm").form("set value", "id", id);
        showPayInput(price, $("#billPayForm"));
    });

    //支付全部账单
    $("#billAllPay").click(function () {
        var price = $(this).data("value");
        showPayInput(price, $("#billAllPayForm"));
    });


    //提交轮播图
    var $slideImageUpdateForm = $("#slideImageUpdateForm");

    $slideImageUpdateForm.form({
        inline: true,
        fields: {
            path: {
                identifier: 'path',
                rules: [
                    {
                        type: 'empty',
                        prompt: '未上传轮播图'
                    }
                ]
            },
            link: {
                identifier: 'link',
                rules: [
                    {
                        type: 'empty',
                        prompt: '链接不能为空'
                    },
                    {
                        type: 'maxLength[255]',
                        prompt: '链接不能超过255字'
                    }
                ]
            }
        }
    });

    //修改目录
    $(".edit.slideImage").click(function () {
        var $parent = $(this).parent().parent();
        $slideImageUpdateForm.form("set values", {
            id: $parent.children("td:eq(0)").text(),
            path: $parent.children("td:eq(1)").children("img").data("value"),
            link: $parent.children("td:eq(2)").text()
        });
        $(".cancelSlideImageEdit").removeClass("hide");
        $slideImageUpdateForm.find(".submit").text("修改轮播图");
    });

    $(".cancelSlideImageEdit").click(function () {
        $slideImageUpdateForm.form("reset");
        $(this).prev().text("添加新轮播图");
        $(this).addClass("hide");
    });

    //上传广告图
    $("#webAdForm").form({
        inline: true,
        fields: {
            path: {
                identifier: 'path',
                rules: [
                    {
                        type: 'empty',
                        prompt: '未上传广告图'
                    }
                ]
            }
        }
    })

    //支付宝充值
    var $chargeForm = $("#chargeForm");
    $chargeForm.form({
        inline: true,
        fields: {
            payType: {
                identifier: 'payType',
                rules: [
                    {
                        type: 'empty',
                        prompt: '您未选择支付方式'
                    }
                ]
            },
            price: {
                identifier: 'price',
                rules: [
                    {
                        type: 'empty',
                        prompt: '充值金额不能为空'
                    },
                    {
                        type: 'number',
                        prompt: '充值金额必须为数字'
                    },
                    {
                        type: 'minDecimalMath[0]',
                        prompt: '充值金额不能小于等于0'
                    },
                    {
                        type: 'decimalPoint[2]',
                        prompt: '充值金额最多2位小数'
                    }
                ]
            }
        }
    });

    $(".payType>.button").click(function () {
        $(".payType>.button").removeClass("blue");
        $(this).addClass("blue");
        $chargeForm.form("set value", "payType", $(this).data("value"));
        $chargeForm.attr("action", $(this).data("value"));
    });

    $(".payPrice>.button").click(function () {
        $chargeForm.form("set value", "price", $(this).data("value"));
    });

    //提现表单切换
    var $withdrawForm = $("#withdrawForm");
    $withdrawForm.form({
        inline: true,
        fields: {
            payType: {
                identifier: 'payType',
                rules: [
                    {
                        type: 'empty',
                        prompt: '您未选择支付方式'
                    }
                ]
            },
            account: {
                identifier: 'account',
                rules: [
                    {
                        type: 'empty',
                        prompt: '提现账号不能为空'
                    }
                ]
            },
            price: {
                identifier: 'price',
                rules: [
                    {
                        type: 'empty',
                        prompt: '提现金额不能为空'
                    },
                    {
                        type: 'number',
                        prompt: '提现金额必须为数字'
                    },
                    {
                        type: 'minDecimalMath[0]',
                        prompt: '提现金额不能小于等于0'
                    },
                    {
                        type: 'decimalPoint[2]',
                        prompt: '提现金额最多2位小数'
                    }
                ]
            }
        }
    });
    $(".withdrawAction>.button").click(function () {
        $(".withdrawAction>.button").removeClass("blue");
        $(this).addClass("blue");
        $withdrawForm.form("set value", "payType", $(this).data("value"));
        $withdrawForm.attr("action", $(this).data("value"));
    });

    $(".withdrawPrice>.button").click(function () {
        $withdrawForm.form("set value", "price", $(this).data("value"));
    });

    //提现
    $withdrawForm.find(".submitButton").click(function () {
        var price = $withdrawForm.form("get value", "price");
        var money = $(this).data("value");
        if (price > money) {
            alert("提现金额不能大于余额!");
            return;
        }
        showPayInput(price, $withdrawForm);
    });

    //修改用户的邮寄地址
    var $updateUserAddressForm = $("#updateUserAddressForm");
    $updateUserAddressForm.form({
        inline: true,
        fields: {
            name: {
                identifier: 'name',
                rules: [
                    {
                        type: 'empty',
                        prompt: '收件人姓名不能为空'
                    },
                    {
                        type: 'regExp[/^[\u4e00-\u9fa5][\u4e00-\u9fa5]{1,5}$/]',
                        prompt: '请输入2到6个汉字中文名（特殊名字情况请输入简称）'
                    }
                ]
            },
            phone: {
                identifier: 'phone',
                rules: [
                    {
                        type: 'empty',
                        prompt: '手机号不能为空'
                    },
                    {
                        type: 'exactLength[11]',
                        prompt: '请输入11位手机号'
                    },
                    {
                        type: 'regExp[/^1/]',
                        prompt: '请输入正确的手机号'
                    }
                ]
            },
            provinceCityAreaId: {
                identifier: 'provinceCityAreaId',
                rules: [
                    {
                        type: 'empty',
                        prompt: '地址未选择完整'
                    }
                ]
            },
            address: {
                identifier: 'address',
                rules: [
                    {
                        type: 'empty',
                        prompt: '具体地址不能为空'
                    },
                    {
                        type: 'minLength[2]',
                        prompt: '至少输入2个字'
                    }
                ]
            }
        }
    });

    $updateUserAddressForm.find(".submitButton").click(function () {
        var $this = $updateUserAddressForm;

        var $areaField = $("#areaField");
        var province = $areaField.children("div:eq(0)").dropdown("get value");
        var city = $areaField.children("div:eq(1)").dropdown("get value");
        var area = $areaField.children("div:eq(2)").dropdown("get value");
        if (hasEmpty([province, city, area])) {
            alert("城市未选择完整");
            return;
        }

        $this.form("set value", "provinceCityAreaId", [province, city, area]);
        $this.submit();
    });

    var $updateInvoiceForm = $("#updateInvoiceForm");
    $updateInvoiceForm.form({
        inline: true,
        fields: {
            title: {
                identifier: 'title',
                rules: [
                    {
                        type: 'empty',
                        prompt: '名称不能为空'
                    }
                ]
            },
            tax: {
                identifier: 'tax',
                rules: [
                    {
                        type: 'empty',
                        prompt: '纳税人识别号不能为空'
                    }
                ]
            },
            address: {
                identifier: 'address',
                rules: [
                    {
                        type: 'empty',
                        prompt: '地址不能为空'
                    }
                ]
            },
            phone: {
                identifier: 'phone',
                rules: [
                    {
                        type: 'empty',
                        prompt: '电话不能为空'
                    }
                ]
            },
            bank: {
                identifier: 'bank',
                rules: [
                    {
                        type: 'empty',
                        prompt: '开户行不能为空'
                    }
                ]
            },
            account: {
                identifier: 'account',
                rules: [
                    {
                        type: 'empty',
                        prompt: '账号不能为空'
                    }
                ]
            }
        }
    });

    $("#updateInvoiceFormTwo").form({
        inline: true,
        fields: {
            title: {
                identifier: 'title',
                rules: [
                    {
                        type: 'empty',
                        prompt: '名称不能为空'
                    }
                ]
            },
            tax: {
                identifier: 'tax',
                rules: [
                    {
                        type: 'empty',
                        prompt: '纳税人识别号不能为空'
                    }
                ]
            }
        }
    });

    $("#updateInvoiceFormThree").form({
        inline: true,
        fields: {
            title: {
                identifier: 'title',
                rules: [
                    {
                        type: 'empty',
                        prompt: '名称不能为空'
                    }
                ]
            }
        }
    });

    //首次注册时出现欢迎语
    if (document.getElementById("registerUsername")) {
        layer.open({
            type: 1,
            title: false, //不显示标题
            content: $("#registerUsername").removeClass("hide"),
            yes: function () {

                $(".ui.checkbox.registerRule").checkbox("check");

            },
            cancel: function () {
                $("#registerUsername").addClass("hide");
            }
        });
        $("#closeLayer").click(function () {
            $("#registerUsername").addClass("hide");
            layer.closeAll();
        });
    }

    var toggle5 = 0;
    $("#writeDirectButton").click(function () {
        if (toggle5 == 0) {
            $(this).text("取消输入");
            toggle5 = 1;
        } else {
            toggle5 = 0;
            $(this).text("直接输入");
        }
        $(".writeDirectly").toggleClass("hide");
    });

    //确认支付
    $("#taskPassButton").click(function () {
        var $form = $(this).parent();
        layer.open({
            title: "请输入支付密码",
            type: 1,
            content: $("#payInput").removeClass("hide"),
            btn: ['确认支付', '取消支付'],
            yes: function () {
                var password = "";
                $.each($("#payInput").find("input"), function (index, item) {
                    password += $(item).val();
                });
                if (password.length != 6) {
                    alert("支付密码未填写完成");
                    return;
                }
                if (parseInt(password) != password) {
                    alert("支付密码为6位数字");
                    return;
                }
                $form.form("set value", "password", password).submit();
                $("#clearPayPassword").click();
            },
            btn2: function () {
                $("#clearPayPassword").click();
                $("#payInput").addClass("hide");
            },
            cancel: function () {
                $("#payInput").addClass("hide");
                $("#clearPayPassword").click();
            }
        });
    });

    $("#superAddAdminForm").form({
        on: 'blur',
        inline: true,//添加此属性，才会显示提示
        fields: {
            phone: {
                identifier: 'phone',
                rules: [
                    {
                        type: 'exactLength[11]',
                        prompt: '请输入11位手机号'
                    },
                    {
                        type: 'regExp[/^1/]',
                        prompt: '请输入正确的手机号'
                    }
                ]
            },
            username: {
                identifier: 'username',
                rules: [
                    {
                        type: 'regExp[/^[A-Za-z0-9_-]{3,32}$/]',
                        prompt: '请输入3到32个字符的用户名,可包含字母、数字、横线、下划线'
                    }
                ]
            },
            password: {
                identifier: 'password',
                rules: [
                    {
                        type: 'empty',
                        prompt: '密码不能为空'
                    },
                    {
                        type: 'minLength[6]',
                        prompt: '密码至少为6位'
                    },
                    {
                        type: 'maxLength[32]',
                        prompt: '密码不得大于32位'
                    }
                ]

            }
        }
    });


    $("#superResetPasswordForm").form({
        on: 'blur',
        inline: true,//添加此属性，才会显示提示
        fields: {
            username: {
                identifier: 'username',
                rules: [
                    {
                        type: 'regExp[/^[A-Za-z0-9_-]{3,32}$/]',
                        prompt: '请输入3到32个字符的用户名,可包含字母、数字、横线、下划线'
                    }
                ]
            },
            password: {
                identifier: 'password',
                rules: [
                    {
                        type: 'empty',
                        prompt: '密码不能为空'
                    },
                    {
                        type: 'minLength[6]',
                        prompt: '密码至少为6位'
                    },
                    {
                        type: 'maxLength[32]',
                        prompt: '密码不得大于32位'
                    }
                ]

            }
        }
    });

    $("#superResetPhoneForm").form({
        on: 'blur',
        inline: true,//添加此属性，才会显示提示
        fields: {
            phone: {
                identifier: 'phone',
                rules: [
                    {
                        type: 'exactLength[11]',
                        prompt: '请输入11位手机号'
                    },
                    {
                        type: 'regExp[/^1/]',
                        prompt: '请输入正确的手机号'
                    }
                ]
            },
            username: {
                identifier: 'username',
                rules: [
                    {
                        type: 'regExp[/^[A-Za-z0-9_-]{3,32}$/]',
                        prompt: '请输入3到32个字符的用户名,可包含字母、数字、横线、下划线'
                    }
                ]
            }
        }
    });

    $("#sendBillButton").click(function () {
        var $this = $(this);
        var ids = [];
        //显示正在发送月账单
        $this.next().addClass("active");
        $this.next().next().removeClass("hide");
        //遍历所有的checkbox如果选中的就加入到ids
        $(".sendBillCheckbox.checkbox").each(function (index, item) {
            if($(item).checkbox("is checked")){
                ids.push($(item).data("value"));
            }
        });
        if (ids.length == 0) {
            alert("未选择任何账单");
            return false;
        }

        $this.next().form("set value", "ids", ids).submit();
    });

    //提交快递处理结果
    $(".invoiceDeal").click(function () {
        var form = $(this).parent().prev().children("form");
        if(form.form("get value","trackingNumber").length == 0){
            alert("未填写任何快递信息");
            return false;
        }else{
            //提交表单
            form.submit();
        }
    });

    //显示快递单号
    $(".showInvoiceResult").click(function () {
        alert($(this).data("value"));
    });

    //提交盖章处理结果
    $(".signatureDeal").click(function () {
        var form = $(this).parent().prev().children("form");
        if(form.form("get value","trackingNumber").length == 0){
            alert("未填写任何快递信息");
            return false;
        }else{
            //提交表单
            form.submit();
        }
    });

    //显示快递单号
    $(".showSignatureResult").click(function () {
        alert($(this).data("value"));
    });

})
;


















