(function ($) {
 
    $.fn.limit = function (elem, limit) {
 
        var target = this,
            display = $(elem);
 
        target.on('focus keyup', function () {
            var len = target.val().length;
            display.text(limit - len);
        });
 
    };
 
}(jQuery));