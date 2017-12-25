//设置全局ajax的csrf验证token
// $.ajaxSetup({headers: {'X-XSRF-TOKEN': $.yu.getCookie('XSRF-TOKEN')}});

//semantic form 使用总结：需要在 form元素.form()执行验证，在$('.ui.form').form.settings下表单验证全局设置
//验证文章标题
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

//直接添加自定义的验证规则，返回判断的布尔值，错误提示信息在上面来写
//注意，semantic应该是严格模式，所以字符串要转成数字之后再进行比较
$.fn.form.settings.rules.between = function(value, between) {
    var arr = between.split("-");
    return (~~value > arr[0] && ~~value < arr[1]);
};

$.fn.form.settings.rules.minMath = function(value, minMath) {
    return (~~value > minMath);
};

$.fn.form.settings.rules.maxMath = function(value, maxMath) {
    return (~~value < maxMath);
};

//message创建
function message(type, message) {
    var msg = document.createElement('div');
    msg.className = 'ui ' + type + ' message';
    msg.innerHTML = message;
    return msg;
}

//message弹窗
function alterModal(state,msg) {
    $('.info.modal').html(message(state,msg)).modal('show');
}

//开启信息关闭功能
$('.message .close')
    .on('click', function() {
        $(this)
            .closest('.message')
            .transition('fade')
        ;
    })
;

$('.undevelop').click(function () {
    alert('功能待开发')
});

var _TEXT = {
    days: ['日', '一', '二', '三', '四', '五', '六'],
    months: ['一月', '二月', '三月', '四月', '五月', '六月', '七月', '八月', '九月', '十月', '十一月', '十二月'],
    monthsShort: ['一月', '二月', '三月', '四月', '五月', '六月', '七月', '八月', '九月', '十月', '十一月', '十二月'],
    today: '今天',
    now: '现在',
    am: '上午',
    pm: '下午'
};

var _URL = $('meta[name="domain"]').attr('content');
var _DOMAIN = _URL.replace(/\/admin/g, "");
var _WECHAT = _URL.replace(/\/wechat/g, "");
var _TOKEN = $('meta[name="csrf-token"]').attr('content');

