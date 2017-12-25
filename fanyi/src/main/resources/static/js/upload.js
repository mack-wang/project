$(document).ready(function () {
    //上传资质证书照片
    $("#uploadCertificatePicture").click(function () {
        $("input[name=certificatePicture]").click();
    });

    //上传营业执照照片
    $("#uploadLicensePicture").click(function () {
        $("input[name=licensePicture]").click();
    });

    //如果返回的信息不是json，切记要把dataType:"json"给删除掉，不然无法接收返回的字符类型的数据

    //上传VIP合同附件
    $("#contractAttachment").click(function () {
        $("input[name=contractAttachment]").click();
    });
    $('input[name=contractAttachment]').fileupload({
        url: '/admin/upload/contract'
        , sequentialUploads: true
        , add: function (e, data) {
            $.each(data.files, function (i, file) {
                if (file.size > 100 * 1024 * 1024) {
                    alert("合同附件不得大于100M，请重新选择");
                    $(this).val("");
                    return;
                }
                var fileName = data.files[0].name;
                var $box = $("#contractAttachmentBox");
                $box.find("span:eq(0)").text(fileName);
                $box.find("span:eq(1)").text("正在上传中...");
                file.jqXHR = data.submit()
                    .success(function (result, textStatus, jqXHR) {
                        $box.find("span:eq(1)").text("上传成功");
                        $('input[name=contractAttachment]').parent().parent().form("set value", "path", result);
                    })
                    .error(function () {
                        alert("上传出错");
                    });
            });
        }
    });

    //上传VIP任务附件
    $("#vipAttachment").click(function () {
        $("input[name=vipAttachment]").click();
    });
    $('input[name=vipAttachment]').fileupload({
        url: '/admin/upload/vipAttachment'
        , sequentialUploads: true
        , add: function (e, data) {
            $.each(data.files, function (i, file) {
                if (file.size > 100 * 1024 * 1024) {
                    alert("翻译内容任务附件不得大于100M，请重新选择");
                    $(this).val("");
                    return;
                }
                var fileName = data.files[0].name;
                var $box = $("#vipAttachmentBox");
                $box.find("span:eq(0)").text(fileName);
                $box.find("span:eq(1)").text("正在上传中...");
                file.jqXHR = data.submit()
                    .success(function (result, textStatus, jqXHR) {
                        $box.find("span:eq(1)").text("上传成功");
                        $('input[name=vipAttachment]').parent().parent().form("set value", "path", result);
                    })
                    .error(function () {
                        alert("上传出错");
                    });
            });
        }
    });

    //上传VIP任务完成稿件
    $("#vipTask").click(function () {
        $("input[name=vipTask]").click();
    });
    $('input[name=vipTask]').fileupload({
        url: '/admin/upload/vipTask'
        , sequentialUploads: true
        , add: function (e, data) {
            $.each(data.files, function (i, file) {
                if (file.size > 100 * 1024 * 1024) {
                    alert("翻译内容任务附件不得大于100M，请重新选择");
                    $(this).val("");
                    return;
                }
                var fileName = data.files[0].name;
                var $box = $("#vipTaskBox");
                $box.find("span:eq(0)").text(fileName);
                $box.find("span:eq(1)").text("正在上传中...");
                file.jqXHR = data.submit()
                    .success(function (result, textStatus, jqXHR) {
                        $box.find("span:eq(1)").text("上传成功");
                        $('input[name=vipTask]').parent().parent().form("set value", "path", result);
                    })
                    .error(function () {
                        alert("上传出错");
                    });
            });
        }
    });

    //上传轮播图
    $("#uploadSlideImage").click(function () {
        $("input[name=uploadSlideImage").click();
    });
    $('input[name=uploadSlideImage]').fileupload({
        url: '/admin/upload/slideImage'
        , sequentialUploads: true
        , add: function (e, data) {

            $.each(data.files, function (i, file) {
                if (file.size > 3 * 1024 * 1024) {
                    alert("轮播图不得大于3M，请重新选择");
                    $(this).val("");
                    return;
                }
                var fileName = data.files[0].name;
                var $box = $("#uploadBox");
                $box.find("span:eq(0)").text(fileName);
                $box.find("span:eq(1)").text("正在上传中...");
                file.jqXHR = data.submit()
                    .success(function (result, textStatus, jqXHR) {
                        $box.find("span:eq(1)").text("上传成功");
                        $("input[name=path]").val(result);
                    })
                    .error(function () {
                        alert("上传出错");
                    });
            });
        }
    });


    //上传单个文件的pai
    $("#uploadApi").click(function () {
        $("#inputFile").click();
    });
    $('#inputFile').fileupload({
        url: '/admin/upload/api'
        , sequentialUploads: true
        , add: function (e, data) {
            var file = data.files[0];
            if (file.size > 3 * 1024 * 1024) {
                alert("上传文件不得大于3M，请重新选择");
                $(this).val("");
                return;
            }
            var fileName = data.files[0].name;
            var $box = $("#uploadBox");
            $box.find("span:eq(0)").text(fileName);
            $box.find("span:eq(1)").text("正在上传中...");
            file.jqXHR = data.submit()
                .success(function (result, textStatus, jqXHR) {
                    $box.find("span:eq(1)").text("上传成功");
                    $("input[name=path]").val(result);
                })
                .error(function () {
                    alert("上传出错");
                });
        }
    });

    //上传修改意见
    $("#uploadAdvice").click(function () {
        $("#inputAdvice").click();
    });
    $('#inputAdvice').fileupload({
        url: '/upload/advice'
        , sequentialUploads: true
        , add: function (e, data) {
            var file = data.files[0];
            if (file.size > 100 * 1024 * 1024) {
                alert("上传文件不得大于100M，请重新选择");
                $(this).val("");
                return;
            }
            var fileName = data.files[0].name;
            var $box = $("#uploadBox");
            $box.find("span:eq(0)").text(fileName);
            $box.find("span:eq(1)").text("正在上传中...");
            file.jqXHR = data.submit()
                .success(function (result, textStatus, jqXHR) {
                    $box.find("span:eq(1)").text("上传成功");
                    $("input[name=path]").val(result);
                })
                .error(function () {
                    alert("上传出错");
                });
        }
    });

    //上传资质证书
    $('input[name=certificatePicture]').fileupload({
        url: '/user/upload/certificatePicture'
        , sequentialUploads: true
        , add: function (e, data) {
            $.each(data.files, function (i, file) {
                if (file.size > 2 * 1024 * 1024) {
                    alert("图片不得大于2M，请重新选择");
                    $(this).val("");
                    return;
                }
                var $elem = $("#certificatePictureContainer").children("div:first").clone(true);
                $elem.addClass("active");
                $elem.find("img").attr("src", getObjectURL(file));
                $("#certificatePictureContainer").append($elem);
                file.jqXHR = data.submit()//把从服务器获取的上传好的路径设置
                    .success(function (result, textStatus, jqXHR) {
                        $elem.attr("data-value", result)
                    })
                    .error(function () {
                        alert("上传出错");
                    });
            });
        }
        , progressall: function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('.active>.progress.certificate:not(".success")').progress({
                percent: progress,
                text: {
                    active: '正在上传{value}%',
                    success: '上传成功'
                }
            });
        }
        , done: function (e, data) {
        }
    });

    //上传营业执照
    $('input[name=licensePicture]').fileupload({
        url: '/user/upload/licensePicture'
        , sequentialUploads: true
        , add: function (e, data) {
            $.each(data.files, function (i, file) {
                if ($("#licensePictureContainer").children("div").length > 1) {
                    alert("营业执照只能上传一张");
                    return;
                }
                if (file.size > 2 * 1024 * 1024) {
                    alert("图片不得大于2M，请重新选择");
                    $(this).val("");
                    return;
                }
                var $elem = $("#licensePictureContainer").children("div:first").clone(true);
                $elem.addClass("active");
                $elem.find("img").attr("src", getObjectURL(file));
                $("#licensePictureContainer").append($elem);
                file.jqXHR = data.submit()//把从服务器获取的上传好的路径设置
                    .success(function (result, textStatus, jqXHR) {
                        $elem.attr("data-value", result)
                    })
                    .error(function () {
                        alert("上传出错");
                    });
            });
        }
        , progressall: function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('.active>.progress.certificate:not(".success")').progress({
                percent: progress,
                text: {
                    active: '正在上传{value}%',
                    success: '上传成功'
                }
            });
        }
        , done: function (e, data) {
        }
    });

    $(".remove.circle.icon.certificate").click(function () {
        var $this = $(this).parent().parent();
        if (!$this.hasClass("active")) return;
        $this.remove();
    });

    //用户上传头像
    var $avatar = $(".avatar.grid>div>img:first");
    $("#uploadAvatar").click(function (e) {
        $(this).prev("input").click();
    });

    $("#uploadAvatarInput").on("change", function () {
        if ($(this).val()) {
            if (this.files[0].size > 2 * 1024 * 1024) {
                alert("图片不得大于2M，请重新选择");
                $(this).val("");
                return;
            }
            var src = getObjectURL(this.files[0]);
            $("#cropAvatar").attr("src", src);
            $avatar.cropper("replace", src);
        }
    });

    $avatar.cropper({
        autoCropArea: 1,//默认裁剪大小比例
        aspectRatio: 16 / 16,//裁剪比例
        preview: "#cropAvatarPreview",
        crop: function (data) {
            // Output the result data for cropping image.
        }
    });

    $(".repeat.button").click(function () {
        $avatar.cropper('rotate', 15)
    });

    $(".undo.button").click(function () {
        $avatar.cropper('rotate', -15)
    });


    $("#uploadAvatarConfirm").click(function () {
        //获取base64的字符串的图片，并转成image/jpeg,质量为0.5
        var blobStr = $avatar.cropper('getCroppedCanvas', {
            width: 200,
            height: 200,
            fillColor: '#fff',
            imageSmoothingEnabled: false,
            imageSmoothingQuality: 'high'
        }).toDataURL("image/jpeg", 0.5);

        //把字符串图片blob的字符串，创建formdata
        var formData = new FormData();
        formData.append('croppedImage', blobStr);
        $.ajax({
            url: "/user/avatar",
            method: "POST",
            data: formData,
            async: true,
            cache: false,
            contentType: false,
            processData: false,
            success: function (result) {
                if (result == true) {
                    alert("头像修改成功");
                    location.href = "/home";
                    return;
                }
            },
            error: function (returndata) {
            }
        });
    });

    //上传翻译附件
    $("#uploadAttachment").click(function () {
        $('input[name=attachment]').click();
    });

    //确保每个附件都有自己的进度条
    var progressCount = 1;
    var $attachmentBox = $("#attachmentBox");
    $('input[name=attachment]').fileupload({
        url: '/task/upload/attachment'
        , sequentialUploads: true
        , add: function (e, data) {

            if ($.trim($("input[name=languageGroup]").val()).length == 0) {
                alert("请先选择翻译语言");
                return;
            }

            if (data.files[0].size > 100 * 1024 * 1024) {
                alert("单个附件不得大于100M，请重新选择");
                $(this).val("");
                return;
            }

            var file = data.files[0];
            var fileName = file.name;
            var suffix = fileName.substring(fileName.lastIndexOf("."), fileName.length).toLowerCase();
            var header = fileName.substr(0, fileName.lastIndexOf("."));
            var className = getFileClassName(suffix);
            //如何是图片类型，则添加download属性
            var download = "";
            if (className == "teal file image outline") {
                download = 'download="' + header + '"';
            }

            //绑定事件对象，以免出错
            data.context = $('<tr><td><i class="ui icon iconFix ' + className + '"></i><span>' + fileName + '</span><span class="progress' + progressCount + '" style="padding-left: 8px;"></span></td><td>大小：计算中...</td><td>字数：<span class="words">计算中...</span></td><td> <a class="wordCount">修改字数</a><a class="remove">删除</a> <a class="download" ' + download + '>下载</a></td></tr>')
                .appendTo($attachmentBox);
            progressCount++;

            data.context.find(".remove").click(function () {
                $(this).parent().parent().remove();
                var totalWords = 0;
                $(".words").each(function (index,item) {
                    totalWords += parseInt($(item).text());
                });
                $("#attachCharsCount").text(totalWords);
            });

            var $edit = data.context.find(".words");

            data.context.find(".wordCount").click(function () {
                if (!$(this).hasClass("confirm")) {
                    $edit.attr("contenteditable", true).addClass("editUnderline");
                    $(this).addClass("confirm").text("确认")
                } else {
                    if(parseInt($edit.text()) != $edit.text()){
                        alert("附件字数必须为整数！");
                        return false;
                    }
                    $edit.attr("contenteditable", false).removeClass("editUnderline");
                    $(this).removeClass("confirm").text("修改字数");
                    var totalWords = 0;
                    $(".words").each(function (index,item) {
                        totalWords += parseInt($(item).text());
                    });
                    $("#attachCharsCount").text(totalWords);
                }
            });

            //添加额外的参数
            data.formData = {languageGroup: $("input[name=languageGroup]").val()};
            file.jqXHR = data.submit()//把从服务器获取的上传好的路径设置
                .success(function (result, textStatus, jqXHR) {
                    data.context.find("td:eq(1)").text("大小：" + getFileSize(result.size));
                    data.context.attr("data-value", result.uuid);
                    var words = 0;
                    if (result.hasCount == "true") {
                        if (result.type == "char") {
                            words = result.chars;
                            data.context.find("td:eq(2)>span").text(words);
                        } else {
                            words = result.words;
                            data.context.find("td:eq(2)>span").text(words);
                        }
                    } else {
                        data.context.find("td:eq(2)>span").attr("contenteditable", true).addClass("editUnderline").text("0");
                        data.context.find(".wordCount").addClass("confirm").text("确认");
                    }
                    data.context.find(".download").attr("href", result.path);
                    var totalWords = 0;
                    $(".words").each(function (index,item) {
                        totalWords += parseInt($(item).text());
                    });
                    $("#attachCharsCount").text(totalWords);
                })
                .error(function () {
                    alert("上传出错");
                });
        }
        , progressall: function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $(".progress" + (progressCount - 1)).text(progress + "%");
        }
        , done: function (e, data) {

        }
    });
});

function getSuffix(fileName) {
    return fileName.substring(fileName.lastIndexOf("."), fileName.length).toLowerCase();
}

function getFileClassName(suffix) {
    console.log(suffix);
    var className = "";
    switch (suffix) {
        case ".doc":
        case ".docx":
            className = "blue file word outline";
            break;
        case ".pdf":
            className = "red file pdf outline";
            break;
        case ".txt":
            className = "file text outline";
            break;
        case ".xls":
        case ".xlsx":
            className = "green file excel outline";
            break;
        case ".ppt":
        case ".pptx":
            className = "orange file powerpoint outline";
            break;
        case ".zip":
        case ".rar":
        case ".tar":
            className = "violet file archive outline";
            break;
        case ".mp3":
        case ".wav":
            className = "purple file audio outline";
            break;
        case ".jpg":
        case ".png":
        case ".jpeg":
        case ".bmp":
        case ".gif":
        case ".svg":
            className = "teal file image outline";
            break;
        default:
            className = "file outline";
            break;
    }
    return className;
}

function getFileSize(size) {
    size = parseInt(size);
    if (size > (1024 * 1024)) {
        return (size / (1024 * 1024)).toFixed(1) + "MB";
    } else {
        return (size / 1024).toFixed(1) + "KB";
    }
}


