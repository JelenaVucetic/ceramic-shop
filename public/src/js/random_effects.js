$(document).ready(function () {
    //====================================================
    // Inxed.php product div hover + border
    //====================================================
    $("[id^=product-data-]").hover(function () {
            $(this).css('border', 'solid 1px');
            $(this).css('border-style', 'outset');
            $(this).css('background-color', 'white');
        },
        function () {
            $(this).css('border', '1px solid transparent');
            $(this).css('background-color', 'inherit');
        });

    //===================================================
    //tooltip na order page issue button
    //===================================================
    $("[data-toggle=tooltip]").tooltip();

    $(".wishlist_link").hover(function () {
            $(this).css('zoom', '1.3');
        },
        function () {
            $(this).css('zoom', '1');
        });

});