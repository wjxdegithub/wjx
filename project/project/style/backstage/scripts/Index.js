$(function () {
    $(".content-left,.content-right").height($(window).height() - 130);
})
$(".accordion-inner").click(function () {
    $(".active").html($(this).find(".left-body").text());
})

$(window).resize(function () {
    $(".content-left,.content-right").height($(window).height() - 130);
})
/*
用户查询
 */
$('.user_select').click(function(){
    $('.iframe').attr('src','index.php?r=backstage/data_select');
})
/*
 添加公众号
 */
$('#add_Accounts').click(function(){
    $('.iframe').attr('src','index.php?r=backstage/add_accounts');
})