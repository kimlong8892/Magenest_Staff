require(['jquery'], function ($) {
    $(document).ready(function () {
        if(type != '')
        {
            setTimeout(function () {
                $(".price").append('(' + type + ')');
            }, 1000);
        }
    });
});