// ======================
// Product page pictures:
// ======================
$(document).ready(function () {

    // ================================
    //klik na thumbnail otvara full pic
    // ================================
    $('.prod-thumb').click(function () {
        var id = $(this).attr('id');
        var src = $("#" + id).attr('src');
        var alt = $("#" + id).attr('alt');
        $('.prod-thumb').css('border', 'solid transparent 2px');
        $(this).css('border', 'solid 2px').css('border-bottom','solid transparent 2px');

        $(".prod-full").attr('src', src);
        $('.prod-pic-text').html(alt);
    });

    // =====================
    //zoom in/out full pic-a
    // =====================
    $('.prod-full').hover(function () {
            if($(this).hasClass('transition')==false){
                $(this).css('cursor', 'zoom-in');
            }

        }, function () {
            $(this).css('cursor', 'default');
            $(this).removeClass('transition');
        }
    );

    $('.prod-full').click(function () {
        if ($(this).hasClass('transition')) {
            $(this).css('cursor', 'zoom-in');
            $(this).removeClass('transition');
        }else{
            $(this).css('cursor','zoom-out');
            $(this).addClass('transition');
        }
    });
});