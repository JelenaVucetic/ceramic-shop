/**
 * Created by ilija on 5/22/17.
 */
$(document).ready(function(){

    $("#discout-products-slide").responsiveSlides({
        auto: true,             // Boolean: Animate automatically, true or false
        speed: 400,            // Integer: Speed of the transition, in milliseconds
        timeout: 1700,          // Integer: Time between slide transitions, in milliseconds
        pager: true,           // Boolean: Show pager, true or false
        nav: false,             // Boolean: Show navigation, true or false
        random: false,          // Boolean: Randomize the order of the slides, true or false
        pause: true,           // Boolean: Pause on hover, true or false
        pauseControls: true,    // Boolean: Pause when hovering controls, true or false
        prevText: "Previous",   // String: Text for the "previous" button
        nextText: "Next",       // String: Text for the "next" button
        //maxwidth: "500",           // Integer: Max-width of the slideshow, in pixels
        navContainer: "",       // Selector: Where controls should be appended to, default is after the 'ul'
        manualControls: "",     // Selector: Declare custom pager navigation
        namespace: "rslides1",   // String: Change the default namespace used
        before: function(){},   // Function: Before callback
        after: function(){}     // Function: After callback
    });


    $("[id^=product-data-]").hover(function () {
            $(this).css('border', 'solid 1px');
            $(this).css('border-style', 'outset');
            $(this).css('background-color', 'white');
        },
        function () {
            $(this).css('border', '1px solid transparent');
            $(this).css('background-color', 'inherit');
        });

});