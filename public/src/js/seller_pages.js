$(document).ready(function () {
    $("#add-more---").click(function(){

        var item_num = $("").attr('value');
        $(".add-more-div").after('<hr><div class="form-group"><label class="col-lg-2 control-label">Item <span id="item-no">1</span></label></div><div class="form-group"><label for="color" class="col-lg-2 control-label">Choose color:</label><div class="col-xs-4"><input name="color1" type="hidden" id="color_value" value="000000"><a href="#" class="btn btn-default jscolor" data-jscolor="{valueElement: color_value}">Select color</a></div></div><div class="form-group"><label for="type" class="col-lg-2 control-label">Type: </label><div class="col-xs-4"><input type="text" class="form-control" name="type1" placeholder="type"></div></div><div class="form-group"><label for="size" class="col-lg-2 control-label">Size: </label><div class="col-xs-4"><input type="text" class="form-control" name="size1" placeholder="size"></div></div><div class="form-group"><label for="quantity" class="col-lg-2 control-label">Quantity</label><div class="col-xs-4"><input type="text" class="form-control" name="quantity1" placeholder="quantity"></div></div></div>');
    });

    //=================================================
    //copy to clipboard
    //=================================================
    $("#copy-product-name").click(function(){
        if(!$(this).val()){
            var productName = $("#select-product option:selected").attr('product-name');
            var temp = $("<input>")
            $("body").append(temp);
            temp.val(productName).select();
            document.execCommand("copy");
            temp.remove();

            $(this).html('Copied');
            setTimeout(function() {
                $("#copy-product-name").html('Copy Name');
            }, 800);
        }
    });
    $("#copy-buyer-name").click(function(){
        if(!$(this).val()){
            var buyerName = $("#select-buyer option:selected").attr('buyer-name');
            var temp = $("<input>")
            $("body").append(temp);
            temp.val(buyerName).select();
            document.execCommand("copy");
            temp.remove();
            $(this).html('Copied');
            setTimeout(function() {
                $("#copy-buyer-name").html('Copy Name');
            }, 800);;
        }
    });

    // =================================================
    //select box on change eventovi za stranicu
    //=================================================
    $("#select-product").change(function () {
        var text = $("#select-product option:selected").text();
        if(text!=""){
            $("#product-go-to").html("<a class='btn btn-info' href='/pages/product/"+ $("#select-product").val() +"'>Go to product</a>");
        }else {
            $("#product-go-to").html("");
        }
    });

    $("#select-discount").change(function () {
        var text = $("#select-discount option:selected").text();
        var endDate = $("#select-discount option:selected").attr('end-date');
        if(text!=""){
            $("#end-date-write").html("<h5>Until " + endDate+"</h5>");
            $('#change-end-date-button').attr('value','Change duration');
            $('#change-end-date-button').trigger('change');
        }
        else{
            $("#end-date-write").html("");
            $('#change-end-date-button').attr('value','Change duration');

        }

    });

    //=================================================
    //datepicker elementi
    //=================================================
    $("#start-date-special-offer").datepicker(
        {showOtherMonths: true, selectOtherMonths: true,"dateFormat":"yy/mm/dd",changeMonth: true, changeYear: true}
    );
    $("#end-date-special-offer").datepicker(
        {showOtherMonths: true, selectOtherMonths: true,"dateFormat":"yy/mm/dd",changeMonth: true, changeYear: true}
    );


});