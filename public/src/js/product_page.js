$(document).ready(function () {




    //===========================
    // TOTAL PRICE na product page changer
    //===========================
    $('body').click(function () {
        var productPrice = parseInt($("#total-product-price").attr('value'),10);
        var quantity = parseInt($('#quantity').attr('value'),10);
        if(quantity!=0){
            $("#total-product-price").html(productPrice*quantity);
        }

    });

    //===========================
    // select color + hover effect border
    //===========================
    $('[id^=product-color-]').hover(function(){

        $('.product-color').css('border','solid transparent 2px');

        //set border solid 2x na elemente koji imaju selektovanu boju ili preko kojeg se vrsi hover
        $('[id^=product-color-][selected-color="1"]').css('border','solid 2px');
        $(this).css('border',"solid 2px");}
    , function () {
            $('.product-color').css('border','solid transparent 2px');
            $('[id^=product-color-][selected-color="1"]').css('border','solid 2px');
        }
    );




    $('[id^=product-color-]').click(function () {

        $('.product-color').attr('selected-color','0');
        $('.product-color').css('border','solid transparent 2px');

        $(this).attr('selected-color','1');
        $(this).css('border','solid 2px');
    });


    //===========================
    // select size + hover effect border
    //===========================
    $('[id^=product-size-]').hover(function(){

            $('.product-size').css('border','solid transparent 2px');

            //set border solid 2x na elemente koji imaju selektovanu boju ili preko kojeg se vrsi hover
            $('[id^=product-size-][selected-size="1"]').css('border','solid 2px');
            $(this).css('border',"solid 2px");}
        , function () {
            $('.product-size').css('border','solid transparent 2px');
            $('[id^=product-size-][selected-size="1"]').css('border','solid 2px');
        }
    );




    $('[id^=product-size-]').click(function () {

        $('.product-size').attr('selected-size','0');
        $('.product-size').css('border','solid transparent 2px');

        $(this).attr('selected-size','1');
        $(this).css('border','solid 2px');
    });

    //===========================
    // select type
    //===========================
    $('[id^=product-type-]').hover(function(){

            $('.product-type').css('border','solid transparent 2px');

            //set border solid 2x na elemente koji imaju selektovanu boju ili preko kojeg se vrsi hover
            $('[id^=product-type-][selected-type="1"]').css('border','solid 2px');
            $(this).css('border',"solid 2px");}
        , function () {
            $('.product-type').css('border','solid transparent 2px');
            $('[id^=product-type-][selected-type="1"]').css('border','solid 2px');
        }
    );




    $('[id^=product-type-]').click(function () {

        $('.product-type').attr('selected-type','0');
        $('.product-type').css('border','solid transparent 2px');

        $(this).attr('selected-type','1');
        $(this).css('border','solid 2px');
    });


    //===================
    // quantity increase/decrease
    //===================
    $("#quantity_decrease").hover(function(){
        $(this).css('border',"solid 2px");
        }
        , function(){
            $(this).css('border','solid transparent 2px');
        }
    );

    $("#quantity_increase").hover(function(){
            $(this).css('border',"solid 2px");
        }
        , function(){
            $(this).css('border','solid transparent 2px');
        }
    );


    $("#quantity_decrease").click(function () {
        var quantity = parseInt($('#quantity').attr('value'),10);
        if( quantity > 1 ){
            $("#quantity").attr('value',quantity-1);
        }
    });

    $("#quantity_increase").click(function () {
        var quantity = parseInt($('#quantity').attr('value'),10);
        $("#quantity").attr('value',quantity+1);
    });

    var postId = 0;
    var postBodyEllement = null;

    $('.post').find('.interaction').find('a:eq(0)').on('click', function(event){
        event.preventDefault();
        postBodyEllement = event.target.parentNode.parentNode.childNodes[1];
        var postBody = postBodyEllement.innerText;
        postId = event.target.parentNode.parentNode.dataset['postid'];
        //console.log(event.target.parentNode.parentNode.dataset['postid']);
        $("#post-body").val(postBody);
        $("#edit-modal").modal();

    });

    $("#modal-save").on('click', function(){

        $.ajax({
            method: 'POST',
            url: url,
            data: {body:  $("#post-body").val(), postId: postId, _token: token}

        }).done(function(msg){
            $(postBodyEllement).text(msg["new_body"]);
            $("#edit-modal").modal('hide');
        });
    });



});