$(document).ready(function () {


    //====================================================================
    //Add to wishlist
    //====================================================================

    $('.wishlist_link').click(function () {
        var id = $(this).attr('value');

        $.ajax({
            //url : $(this).attr('action') || window.location.pathname,
            url: "/my/wishlist",
            type: "POST",
            data: {
                "wishlist": "1",
                "product_id": id,
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function () {
                $("#wishlist_link_" + id).html("");

            },
            error: function (jqXHR, textStatus, errorThrown) {
                //console.log(jqXHR);
                alert(errorThrown + textStatus);
            }
        });
    });


    //====================================================================
    //logout user
    //====================================================================
    $('.logout_user').click(function () {
        var confirmDialog = confirm("Are you sure you want to logout?");
        if (confirmDialog == true) {
            $.ajax({
                //url : $(this).attr('action') || window.location.pathname,
                url: "/logout",
                type: "POST",
                data: {
                    "logout": "1",
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function () {
                    window.location.href = '/';

                },
                error: function (jqXHR, textStatus, errorThrown) {
                    //console.log(jqXHR);
                    alert(errorThrown + textStatus);
                }
            });
        }
        else {
            return false;
        }

    });

    //====================================================================
    //Select user information
    //====================================================================
    $("[id^=user-info-select-]").click(function () {
        var select_user_info_id = $(this).attr('value');
        $(".dropdown-toggle").parent().closest('div').removeClass('dropdown open').addClass('dropdown');

        $.ajax({
            //url: window.location.href,
            url: "/",
            type: "POST",
            data: {
                "select_user_info": "1",
                "select_user_info_id": select_user_info_id
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function () {
                alert(select_user_info_id);

                //var first_name = $('[id^=user-info-input-]:checked').attr('first-name');
                //$("#first-name-span").html("Hello, "+first_name);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                //console.log(jqXHR);
                alert(errorThrown + textStatus);
            }
        });
    });
    //====================================================================
    //Remove order from shopping cart
    //====================================================================
    $("[id^=remove-order-]").click(function () {
        var order_id = $(this).attr('value');
        $.ajax({
            url: '/my/shopping_cart',
            type: "POST",
            data: {
                "remove_order": "1",
                "order_id": order_id
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function () {
                $(".order-row-" + order_id).remove();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                //console.log(jqXHR);
                alert(errorThrown + textStatus);
            }
        });
    });

    //====================================================================
    //Check availability of items on product page
    //====================================================================
    //first selected: color
    $("[id^=product-color-]").click(function () {
        selectedColor = $(this).attr('color');
    });

    //first selected: size


    //first selected: type


    //====================================================================
    //Add to cart
    //====================================================================
    $('#add_to_cart').click(function () {
        var add_to_cart = '1';
        var product_id = $(this).attr("product-id");
        var color = $('[id^=product-color-][selected-color="1"]').attr('color');
        var size = $('[id^=product-size-][selected-size="1"]').attr('size');
        var type = $("#product-type option:selected").text();
        var quantity = parseInt($('#quantity').attr('value'), 10);
        var shipping_id = $('#select-shipping').val();
        $.ajax({
            //url : $(this).attr('action') || window.location.pathname,
            //url: window.location.href,
            url: url2,
            type: "POST",
            data: {
                "add_to_cart": add_to_cart,
                "cart_product_id": product_id,
                "cart_color": color,
                "cart_size": size,
                "cart_type": type,
                "cart_quantity": quantity,
                "cart_shipping_id": shipping_id,
                "_token" : token
            },
            success: function (data) {
                data = JSON.parse(data);
                $("#ajax-message-span").html(data["message"]);
                $("#ajax-message").css("display", "block");
                var badge = $('.badge');
                var number = parseInt(badge.html());
                badge.html(number + 1);
                //$("#quantity").val(0);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                //console.log(jqXHR);
                alert(errorThrown + textStatus);
            }
        });

    });

    //====================================================================
    //Add to cart default
    //====================================================================
    $('#add_to_cart_default').click(function () {
        var add_to_cart = '1';
        var product_id = $(this).attr("product-id");
        var color = $('[id^=product-color-][selected-color="1"]').attr('color');
        var size = $('[id^=product-size-][selected-size="1"]').attr('size');
        var type = $("#product-type option:selected").text();
        var quantity = parseInt($('#quantity').attr('value'), 10);
        var shipping_id = $('#select-shipping').val();
        $.ajax({
            //url : $(this).attr('action') || window.location.pathname,
            url: window.location.href,
            type: "POST",
            data: {
                "add_to_cart": add_to_cart,
                "cart_product_id": product_id,
                "cart_color": color,
                "cart_size": size,
                "cart_type": type,
                "cart_quantity": quantity,
                "cart_shipping_id": shipping_id,
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function () {
                alert('added');
            },
            error: function (jqXHR, textStatus, errorThrown) {
                //console.log(jqXHR);
                alert(errorThrown + textStatus);
            }
        });

    });

    //=================================================================
    // confirm received product - order page - button click
    //=================================================================
    $("[id^=confirm-received-]").click(function () {
        var order_id = $(this).attr('value');
        alert("con");
        $.ajax({
            //url : $(this).attr('action') || window.location.pathname,
            url: "/my/orders",
            type: "POST",
            data: {
                "confirm_received": "1",
                "order_id": order_id,
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function () {
                alert('confirmed ' + order_id);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                //console.log(jqXHR);
                alert(errorThrown + textStatus);
            }
        });


    });

    $("#delete-discount").click(function () {
        var discount_id = $("#select-discount").val();
        var confirmDialog = confirm("Are you sure?");
        if (confirmDialog == true) {
            $.ajax({
                //url : $(this).attr('action') || window.location.pathname,
                url: "/seller/seller_main",
                type: "POST",
                data: {
                    "delete_discount": "1",
                    "discount_id": discount_id
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function () {
                    alert('confirmed ' + discount_id);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    //console.log(jqXHR);
                    alert(errorThrown + textStatus);
                }
            });
        } else {
            return false;
        }
    });
    $("#delete-product").click(function () {
        var product_id = $("#select-product").val();
        var confirmDialog = confirm("Are you sure?");
        if (confirmDialog == true) {
            $.ajax({
                //url : $(this).attr('action') || window.location.pathname,
                url: "/seller/seller_main",
                type: "POST",
                data: {
                    "delete_product": "1",
                    "product_id": product_id
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function () {
                    alert('confirmed ' + discount_id);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    //console.log(jqXHR);
                    alert(errorThrown + textStatus);
                }
            });
        } else {
            return false;
        }
    });

    //===========================================================
    //datepicker za produzavanje trajanja snizenja ~/seller main page
    //===========================================================
    $("#change-end-date-button").datepicker(
        {showOtherMonths: true, selectOtherMonths: true, "dateFormat": "yy/mm/dd", changeMonth: true, changeYear: true,
            onSelect: function(dateText){
                var confirmDialog = confirm("Are you sure?");
                if (confirmDialog == true) {
                    var discount_id = $("#select-discount option:selected").val();

                    $.ajax({
                        //url : $(this).attr('action') || window.location.pathname,
                        url: "/seller/seller_main",
                        type: "POST",
                        data: {
                            "change_end_date": "1",
                            "discount_id": discount_id,
                            "end_date": dateText
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function () {
                            alert('Successfully changed duration of discount. ');
                            $("#end-date-write").html("<h5>Until " + dateText+"</h5>");
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            //console.log(jqXHR);
                            alert(errorThrown + textStatus);
                        }
                    });
                }
                else return false;
            }
        }
    );

    //==================================================================================================================
    // BAN AND UNBAN
    //==================================================================================================================
    $("[id^=button-ban-]").click(function () {

        var confirmDialog = confirm("Are you sure you want to ban this user?");
        if (confirmDialog == true) {
            $.ajax({
                //url : $(this).attr('action') || window.location.pathname,
                url: "/admin/admin_main",
                type: "POST",
                data: {
                    "ban_user": "1",
                    "user_id": $(this).attr('value'),
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function () {
                    alert('User successfully banned.');
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    //console.log(jqXHR);
                    alert(errorThrown + textStatus);
                }
            });
        } else {
            return false;
        }
    });
    $("[id^=button-unban-]").click(function () {

        var confirmDialog = confirm("Are you sure you want to ban this user?");
        if (confirmDialog == true) {
            $.ajax({
                //url : $(this).attr('action') || window.location.pathname,
                url: "/admin/admin_main",
                type: "POST",
                data: {
                    "unban_user": "1",
                    "user_id": $(this).attr('value'),
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function () {
                    alert('User successfully unbanned.');
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    //console.log(jqXHR);
                    alert(errorThrown + textStatus);
                }
            });
        } else {
            return false;
        }
    });

});


