$(document).ready(function () {

    $resetPasswordForm = $('#resetPasswordForm');

    //钜合头条滑动效果
    var $headlineNode = $('.headlineNode');
    var headlineLen = $headlineNode.length,
        headlineCount = 1;

    $headlineNode.eq(0).slideDown().show();

    setInterval(function () {
        $headlineNode.hide();
        $headlineNode.eq(headlineCount).slideDown().show();
        headlineCount++;
        if (headlineCount === headlineLen) {
            headlineCount = 0;
        }
    }, 5000);

    $('.ui.search.article').search({
        apiSettings: {
            url: '/admin/search/article?title={query}',
            onResponse: function (data) {
                var content = [];
                $.each(data, function (index, item) {
                    if (index > 5) {
                        return false;
                    }
                    content.push({title: item['title'], id: item['id']});
                });
                return {
                    results: content
                };
            }
        },
        maxResults: 5,
        minCharacters: 2,
        showNoResults: false,
        type: 'standard',
        onSelect: function (result) {
            location.href = _URL + '/article/' + result.id;
        }
    });

    //记录头条的阅读数
    $headlineNode.click(function (e) {
        var id = $(this).attr('data-value');
        if ($.trim(id).length > 0) {
            $.get(_WECHAT + '/admin/index/view/' + id);
        }
    });

    $('.phone.icon')
        .transition('tada')
    ;

    //上传或修改用户头像
    $('#uploadAvatar').click(function () {
        $("#avatarInput").click();
    });

    $('#avatarInput').on('change', function () {
        $(this).parent().submit();
    });

    var mySwiper = new Swiper('.swiper-container', {
        autoplay: 5000,
        speed: 1000,
        direction: 'horizontal',
        loop: true,
        pagination: '.swiper-pagination',
        paginationType: 'bullets'
    });

    $resetPasswordForm.form({
        fields:{
            'password':['empty','minLength[6]'],
            'resetPassword':['empty','minLength[6]','different[password]'],
            'resetPasswordConfirm':['empty','minLength[6]','match[resetPassword]']
        }
    });

});
