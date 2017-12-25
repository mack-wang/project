/**
 * Created by wanglecheng on 8/22/17.
 */
$('.ui.form').form.settings.prompt = {
    empty: '{name}不能为空',
    checked: '{name}未选择',
    email: '{name}格式错误',
    url: '{name}格式错误',
    regExp: '{name}未通过正则验证',
    integer: '{name}必须为整数',
    decimal: '{name}必须是十进制',
    number: '{name}必须是数字',
    is: '{name}必须包含\'{ruleValue}\'',
    isExactly: '{name}必须填\'{ruleValue}\'，并且完全一样',
    not: '{name}禁止包含\'{ruleValue}\'',
    notExactly: '{name}禁止和\'{ruleValue}\'完全一样',
    contain: '{name}必须包含\'{ruleValue}\'',
    containExactly: '{name}必须和\'{ruleValue}\'完全一样',
    doesntContain: '{name}禁止包含\'{ruleValue}\'',
    doesntContainExactly: '{name}禁止和\'{ruleValue}\'完全一样',
    minLength: '{name}至少包含{ruleValue}个字符',
    length: '{name}至少包含{ruleValue}个字符',
    exactLength: '{name}必须刚好为{ruleValue}个字符',
    maxLength: '{name}禁止大于{ruleValue}个字符',
    match: '{name}必须和{ruleValue}相匹配',
    different: '{name}必须和{ruleValue}不同',
    creditCard: '{name}格式错误',
    minCount: '{name}至少选择{ruleValue}个',
    exactCount: '{name}必须选择{ruleValue}个',
    maxCount: '{name}禁止大于{ruleValue}个选择',
    minMath: '{name}最小为{ruleValue}',
    maxMath: '{name}最大为{ruleValue}',
    between: '{name}必须在{ruleValue}之间'
};

// 验证数字
// ^[0-9]*$
// 验证所有整数，包括0和正负数整数
// ^(0|[1-9][0-9]*|-[1-9][0-9]*)$
// 验证负整数
// ^(-[1-9][0-9]*)$
// 验证正整数
// ^([1-9][0-9]*)$

//修正home的脚部布局问题
// $(function () {
//     function footerPosition() {
//         var contentHeight = document.body.scrollHeight,//网页正文全文高度
//             winHeight = window.innerHeight;//可视窗口高度，不包括浏览器顶部工具栏
//         if (!(contentHeight > winHeight)) {
//             $("#homeFooter").addClass("fixed-bottom").removeClass("hide");
//         } else {
//             //当网页正文高度小于可视窗口高度时，为footer添加类fixed-bottom
//             $("#homeFooter").removeClass("hide");
//         }
//     }
//
//     footerPosition();
//     //当窗口发生改变时，动态改变布局
//     $(window).resize(footerPosition());
//     // $(".homeTab>.menu>a.item:eq(1)").click(footerPosition());
// });

//直接添加自定义的验证规则，返回判断的布尔值，错误提示信息在上面来写
//注意，semantic应该是严格模式，所以字符串要转成数字之后再进行比较

//检查数字区间
$.fn.form.settings.rules.between = function(value, between) {
    var arr = between.split("-");
    return (~~value > arr[0] && ~~value < arr[1]);
};

//检查是小值
$.fn.form.settings.rules.minMath = function(value, minMath) {
    return (~~value > minMath);
};

$.fn.form.settings.rules.minDecimalMath = function(value, minDecimalMath) {
    return (parseFloat(value) > minDecimalMath);
};

//检查最大值
$.fn.form.settings.rules.maxMath = function(value, maxMath) {
    return (~~value < maxMath);
};

//检查小数位数,如果没小数，也可以，有小数的话，则不能大于num
$.fn.form.settings.rules.decimalPoint = function(value, num) {
    return (value.length-value.lastIndexOf(".")-2) < num || value.lastIndexOf(".")==-1;
};

//两个选项不能同时为空
$.fn.form.settings.rules.requiredOne = function(value, match) {
    if($.trim(value).length == 0){
       return $.trim($("input[name="+match+"]").val()).length != 0;
    }
    return true;
};


//在ajax的头部添加csrf，这样post时就不用加csrf了
var _token = $("meta[name='_csrf']").attr("content");
var _header = $("meta[name='_csrf_header']").attr("content");
$(document).ajaxSend(function (e, xhr, options) {
    xhr.setRequestHeader(_header, _token);
});


//判断字符串是否以某字符结尾
String.prototype.endWith = function (endStr) {
    var d = this.length - endStr.length;
    return (d >= 0 && this.lastIndexOf(endStr) == d)
};

function getObjectURL(file) {
    var url = null;
    if (window.createObjectURL != undefined) {
        url = window.createObjectURL(file)
    } else if (window.URL != undefined) {
        url = window.URL.createObjectURL(file)
    } else if (window.webkitURL != undefined) {
        url = window.webkitURL.createObjectURL(file)
    }
    return url
};

var _TEXT = {
    days: ['日', '一', '二', '三', '四', '五', '六'],
    months: ['一月', '二月', '三月', '四月', '五月', '六月', '七月', '八月', '九月', '十月', '十一月', '十二月'],
    monthsShort: ['一月', '二月', '三月', '四月', '五月', '六月', '七月', '八月', '九月', '十月', '十一月', '十二月'],
    today: '今天',
    now: '现在',
    am: '上午',
    pm: '下午'
};


$(".ui.dropdown").dropdown();

$(".pointing.link.dropdown").dropdown({
    on: 'hover'
});
