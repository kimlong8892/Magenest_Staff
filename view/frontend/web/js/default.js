require(['jquery'], function ($) {
    $(document).ready(function () {
        var check = false;
        var refreshId = setInterval(function () {
            if($(".price").text() != '' && !check){
                $(".price").append('(' + type + ')');
                check = true;
                clearInterval(refreshId);
            }
        }, 1000);
    });
});