$(document).ready(function () {
    $(".sevice li").each(function (index) {
        var img = $(this).find('img');
        var item = $(this).find('.item');
        img.load(function(){}).each(function () {
            if (this.complete) {
                var w = $(this).height();
                item.css("margin-top", ((w / 2) - 30) + "px");
            }
        });
    });
});