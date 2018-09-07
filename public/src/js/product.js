/**
 * Created by ilija on 5/1/17.
 */
$(document).ready(function(){

    $(":file").filestyle({buttonText: "Odaberi slike"});
    $('#table').DataTable();


});

function resetId(){
    $("#product_id").val("-1");
}

function updateProduct(product_id){

    var name = $("#prod"+product_id).find("td:nth-child(1)").text();
    var category_id = $("#prod"+product_id).find("td:nth-child(2) span").attr("data-id");
    var price = $("#prod"+product_id).find("td:nth-child(3)").text();
    var tax = $("#prod"+product_id).find("td:nth-child(4)").text();
    var description = $("#prod"+product_id).find("td:nth-child(5)").text();

    $("#edit-modal").modal("show");

    $("#product_id").val(product_id);
    $("#product_name").val(name);
    $("#category_id").val(category_id);
    $("#price").val(price);
    $("#old_price").val(price);
    $("#tax").val(tax);
    $("#old_tax").val(tax);
    $("#description").val(description);
}

function showHistory(product_id){

    $("#history-modal").modal("show");

    $.get("/admin/product/history/"+product_id, function(data){

        var html_prices =  "<table class='table table-condensed table-striped'><thead><tr>" +
                    "<td>Cijene</td><td></td>" +
                    "<tr></tr></thead><tbody>";


        //data = JSON.parse(data);

        var prices = data["prices"];

        $.each(prices, function( index, value ) {
            html_prices += "<tr><td>"+ value.created_at + "</td><td>" + value.price + "</td></tr>";
        });

        html_prices += "</tbody></table>";

        var html_taxes =  "<table class='table table-condensed table-striped'><thead><tr>" +
                    "<td>Porez</td><td></td>" +
                    "<tr></tr></thead><tbody>";


        //data = JSON.parse(data);

        var taxes = data["taxes"];

        $.each(taxes, function( index, value ) {
            html_taxes += "<tr><td>" + value.created_at + "</td><td>" + value.tax + "</td></tr>";
        });

        html_taxes += "</tbody></table>";

       $("#history-modal-body").html(html_prices + html_taxes);
    });
}

