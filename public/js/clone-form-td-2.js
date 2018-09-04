/*
Author: Tristan Denyer (based on Charlie Griefer's original clone code, and some great help from Dan - see his comments in blog post)
Plugin repo: https://github.com/tristandenyer/Clone-section-of-form-using-jQuery
Demo at http://tristandenyer.com/using-jquery-to-duplicate-a-section-of-a-form-maintaining-accessibility/
Ver: 0.9.5.0
Last updated: Oct 23, 2015

The MIT License (MIT)

Copyright (c) 2011 Tristan Denyer

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.
*/

function change_method() {
    var customer_id = $("#customer_id option:selected").val();
    
    $.ajax({ url: "/admin/sales/ajax-get-period",
        data: {"customer_id":customer_id},
        dataType: 'json',
        type: 'post',
        success: function(output) {
            //console.log(output);
            if( output.datas.payment_period != 0 ) {
                $('#payment_period').attr('disabled', false).val(output.datas.payment_period);
                $("div.div_method select").val(3); //credit
                $("#payment_status").val(1); //unpaid
            } else {
                $("div.div_method select").val(1); //cash
                $('#payment_period').attr('disabled', true).val('');
                $("#payment_status").val(2); //paid
            }
        }
    });
}

function change_period() {
    var payment_method = $("#payment_method option:selected").val();
    
    if( payment_method == 3 ) { //credit
        $('#payment_period').attr('disabled', false).val('');
        $("#payment_status").val(1); //unpaid
    } else {
        $('#payment_period').attr('disabled', true).val('');
        $("#payment_status").val(2); //paid
    }
}

function change_shipment() {
    var flag = $("#is_shipment option:selected").val();
    
    if( flag == 1 ) {
        $('#expedition_id').attr('disabled', false).val('');
        $('#expedition_cost').attr('disabled', false).val('');
    } else {
        $('#expedition_id').attr('disabled', true).val('');
        $('#expedition_cost').attr('disabled', true).val('');
    }
}

function remove_fields(rid) {
    $('#entry' + rid).slideUp('fast', function () {$(this).remove();});
    $('#btnAdd').attr('disabled', false).prop('value', "add section");
}

function change_serial() {
    var place_id = $("#place_id option:selected").val();
    
    for (var rid = 1; rid <= $('.clonedInput').length; rid++) {
        $('#ID' + rid + '_div_serial').html('<select id="ID'+rid+'_serial_id" class="select_pr form-control" type="text" name="ID'+rid+'_serial_id" value="" onchange="change_sku('+rid+')">');
        $('#ID' + rid + '_serial_id').append('<option value="">-Series Code-</option>');
    }
        
    $.ajax({ url: "/admin/moving/ajax-get-serial",
        data: {"place_id":place_id},
        dataType: 'json',
        type: 'post',
        success: function(output) {
            //console.log(output);
            for (var rid = 1; rid <= $('.clonedInput').length; rid++) {
                for (var x = 0; x < output.length; x++) {
                    $('#ID' + rid + '_serial_id').append('<option value="' + output[x].serial_id + '">' + output[x].serial_code + '</option>');
                }
            }
        }
    });
}

function change_sku(rid) {
    var serial_id = $("#ID"+rid+"_serial_id option:selected").val();
    var place_id = $("#place_id option:selected").val();
    
    $('#ID' + rid + '_div_stock').html('<select id="ID'+rid+'_stock_id" class="select_st form-control" type="text" name="ID'+rid+'_stock_id" value="" onchange="change_unit('+rid+')">');
    $('#ID' + rid + '_stock_id').append('<option value="">-SKU-</option>');
    
    $.ajax({ url: "/admin/moving/ajax-get-sku",
        data: {"serial_id":serial_id, "place_id":place_id},
        dataType: 'json',
        type: 'post',
        success: function(output) {
            //console.log(output);
            for (var x = 0; x < output.length; x++) {
                $('#ID' + rid + '_stock_id').append('<option value="' + output[x].stock_id + '">' + output[x].sku + '</option>');
            }
            $('#ID' + rid + '_product_unit_id').val('');
            $('#ID' + rid + '_convert_to_pcs').val('');
            $('#ID' + rid + '_selling_price').val('');
            $('#ID' + rid + '_capital_price').val('');
            $('#ID' + rid + '_qty').attr('max',0).val('');
            $("#ID"+rid+"_buttq_min").attr('disabled', true);
            $("#ID"+rid+"_buttq_add").attr('disabled', false);
        }
    });
}

function change_unit(rid) {
    var stock_id = $("#ID"+rid+"_stock_id option:selected").val();
    var place_id = $("#place_id option:selected").val();
    
    $.ajax({ url: "/admin/sales/ajax-get-unit",
        data: {"stock_id":stock_id, "place_id":place_id},
        dataType: 'json',
        type: 'post',
        success: function(output) {
            //console.log(output);
            $('#ID' + rid + '_product_unit_id').val(output.datas.product_unit_name);
            $('#ID' + rid + '_convert_to_pcs').val(output.datas.convert_to_pcs);
            $('#ID' + rid + '_selling_price').val(output.datas.selling_price);
            $('#ID' + rid + '_capital_price').val(output.datas.capital_price);
            $('#ID' + rid + '_qty').attr('max',output.datas.qty_max).val('');
            $("#ID"+rid+"_buttq_min").attr('disabled', true);
            $("#ID"+rid+"_buttq_add").attr('disabled', false);
        }
    });
}

function change_qty(rid) {
    var value = $('#ID' + rid + '_qty').val();
    var max_val = $('#ID' + rid + '_qty').attr('max');
    var min_val = $('#ID' + rid + '_qty').attr('min');
    
    if ((value !== '') && (value.indexOf('.') === -1)) {
        $('#ID' + rid + '_qty').val(Math.max(Math.min(value, max_val), min_val));
    }
    
    if( value == max_val ) {
        $("#ID"+rid+"_buttq_min").attr('disabled', false);
        $("#ID"+rid+"_buttq_add").attr('disabled', true);
    } else if( value == min_val ) {
        $("#ID"+rid+"_buttq_min").attr('disabled', true);
        $("#ID"+rid+"_buttq_add").attr('disabled', false);
    } else if( min_val < value < max_val ) {
        $("#ID"+rid+"_buttq_min").attr('disabled', false);
        $("#ID"+rid+"_buttq_add").attr('disabled', false);
    } else {
        $("#ID"+rid+"_buttq_min").attr('disabled', true);
        $("#ID"+rid+"_buttq_add").attr('disabled', false);
    }
}

function change_total(rid) {
    var qty = $("#ID"+rid+"_qty").val();
    var unit = $("#ID"+rid+"_convert_to_pcs").val();
    var price = $("#ID"+rid+"_selling_price").val();
    var capital_price = $("#ID"+rid+"_capital_price").val();
    var disc = $("#ID"+rid+"_discount").val();
    
    var total_qty = (qty*unit);
    var total = parseInt((total_qty*price) - disc);
    $("#ID"+rid+"_total").val(total);
    
    var total_capital = parseInt((total_qty*capital_price));
    $("#ID"+rid+"_total_capital").val(total_capital);
    
    //get all total
    var num     = $('.clonedInput').length;
    var all_total = 0;
    var all_total_capital = 0;
    var qty_pcs = 0;
    var i;
    
    for(i=1; i<=num; i++){
        var total = $("#ID"+i+"_total").val();
        if( typeof(total) != "undefined" && total !== null && total !== "" ) {
            all_total += parseInt($("#ID"+i+"_total").val());
            all_total_capital += parseInt($("#ID"+i+"_total_capital").val());
            qty_pcs += $("#ID"+rid+"_qty").val()*$("#ID"+rid+"_convert_to_pcs").val();
        }
    }
    
    $("#total").val(all_total);
    $("#total_capital").val(all_total_capital);
    $("#qty_pcs").val(qty_pcs);
}

function min_qty(rid) {
    var currentVal = parseFloat($("#ID"+rid+"_qty").val());
    console.log(currentVal);
    if (!isNaN(currentVal)) {
        if(currentVal > $("#ID"+rid+"_qty").attr('min')) {
            $("#ID"+rid+"_qty").val(currentVal - 0.5).change();
            $("#ID"+rid+"_buttq_add").attr('disabled', false);
        } 
        if(parseFloat(currentVal) == $("#ID"+rid+"_qty").attr('min')) {
            $("#ID"+rid+"_buttq_min").attr('disabled', true);
        }
    } else {
        $("#ID"+rid+"_qty").val(0);
    }
}

function plus_qty(rid) {
    var currentVal = parseFloat($("#ID"+rid+"_qty").val());
    console.log(currentVal);
    if (!isNaN(currentVal)) {
        if(currentVal < $("#ID"+rid+"_qty").attr('max')) {
            $("#ID"+rid+"_qty").val(currentVal + 0.5).change();
            $("#ID"+rid+"_buttq_min").attr('disabled', false);
        } 
        if(parseFloat(currentVal) == $("#ID"+rid+"_qty").attr('max')) {
            $("#ID"+rid+"_buttq_add").attr('disabled', true);
        }
    } else {
        $("#ID"+rid+"_qty").val(0);
    }
}

$(function () {
/*
    $('.btn-number').click(function(e){
        e.preventDefault();
        
        fieldName = $(this).attr('data-field');
        type      = $(this).attr('data-type');
        alert(fieldName);
        alert(type);
        var input = $("input[name='"+fieldName+"']");
        var currentVal = parseFloat(input.val());
        if (!isNaN(currentVal)) {
            if(type == 'minus') {
                
                if(currentVal > input.attr('min')) {
                    input.val(currentVal - 0.5).change();
                } 
                if(parseFloat(input.val()) == input.attr('min')) {
                    $(this).attr('disabled', true);
                }

            } else if(type == 'plus') {

                if(currentVal < input.attr('max')) {
                    input.val(currentVal + 0.5).change();
                }
                if(parseFloat(input.val()) == input.attr('max')) {
                    $(this).attr('disabled', true);
                }

            }
        } else {
            input.val(0);
        }
    });
    
    $('.input-number').focusin(function(){
       $(this).data('oldValue', $(this).val());
    });
    
    $('.input-number').change(function() {
        minValue =  parseFloat($(this).attr('min'));
        maxValue =  parseFloat($(this).attr('max'));
        valueCurrent = parseFloat($(this).val());
        
        name = $(this).attr('name');
        if(valueCurrent >= minValue) {
            $(".btn-number[data-type='minus'][data-field='"+name+"']").removeAttr('disabled')
        } else {
            alert('Sorry, the minimum value was reached');
            $(this).val($(this).data('oldValue'));
        }
        if(valueCurrent <= maxValue) {
            $(".btn-number[data-type='plus'][data-field='"+name+"']").removeAttr('disabled')
        } else {
            alert('Sorry, the maximum value was reached');
            $(this).val($(this).data('oldValue'));
        }
    });
    
    $(".input-number").keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
             // Allow: Ctrl+A
            (e.keyCode == 65 && e.ctrlKey === true) || 
             // Allow: home, end, left, right
            (e.keyCode >= 35 && e.keyCode <= 39)) {
                 // let it happen, don't do anything
                 return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });
    
    */
    $('#btnAdd').click(function () {
        var num     = $('.clonedInput').length, // Checks to see how many "duplicatable" input fields we currently have
            newNum  = new Number(num + 1),      // The numeric ID of the new input field being added, increasing by 1 each time
            newElem = $('#entry' + num).clone().attr('id', 'entry' + newNum).attr('onchange','change_total('+newNum + ')').fadeIn('fast'); // create the new element via clone(), and manipulate it's ID using newNum value
    
    /*  This is where we manipulate the name/id values of the input inside the new, cloned element
        Below are examples of what forms elements you can clone, but not the only ones.
        There are 2 basic structures below: one for an H2, and one for form elements.
        To make more, you can copy the one for form elements and simply update the classes for its label and input.
        Keep in mind that the .val() method is what clears the element when it gets cloned. Radio and checkboxes need .val([]) instead of .val('').
    */
    
        newElem.find('.div_serial').attr('id', 'ID' + newNum + '_div_serial').attr('name', 'ID' + newNum + '_div_serial');
        newElem.find('.select_pr').attr('id', 'ID' + newNum + '_serial_id').attr('name', 'ID' + newNum + '_serial_id').attr('onchange','change_sku('+newNum + ')').val('');
        newElem.find('.div_stock').attr('id', 'ID' + newNum + '_div_stock').attr('name', 'ID' + newNum + '_div_stock');
        newElem.find('.select_st').attr('id', 'ID' + newNum + '_stock_id').attr('name', 'ID' + newNum + '_stock_id').attr('onchange','change_unit('+newNum + ')').val('');
        newElem.find('.input_qty').attr('id', 'ID' + newNum + '_qty').attr('name', 'ID' + newNum + '_qty').attr('max','0').attr('oninput','change_qty('+newNum + ')').attr('onchange','change_qty('+newNum + ')').val('');
        newElem.find('.input_pu').attr('id', 'ID' + newNum + '_product_unit_id').attr('name', 'ID' + newNum + '_product_unit_id').val('');
        newElem.find('.input_prc').attr('id', 'ID' + newNum + '_selling_price').attr('name', 'ID' + newNum + '_selling_price').val('');
        newElem.find('.input_cprc').attr('id', 'ID' + newNum + '_capital_price').attr('name', 'ID' + newNum + '_capital_price').val('');
        newElem.find('.input_dis').attr('id', 'ID' + newNum + '_discount').attr('name', 'ID' + newNum + '_discount').val('');
        newElem.find('.input_ttl').attr('id', 'ID' + newNum + '_total').attr('name', 'ID' + newNum + '_total').val('');
        newElem.find('.input_ttlc').attr('id', 'ID' + newNum + '_total_capital').attr('name', 'ID' + newNum + '_total_capital').val('');
        newElem.find('.input_pcs').attr('id', 'ID' + newNum + '_convert_to_pcs').attr('name', 'ID' + newNum + '_convert_to_pcs').val('');
        newElem.find('.buttq_min').attr('id', 'ID' + newNum + '_buttq_min').attr('onclick','min_qty('+newNum + ')').attr("disabled", true);
        newElem.find('.buttq_add').attr('id', 'ID' + newNum + '_buttq_add').attr('onclick','plus_qty('+newNum + ')').attr("disabled", false);
        newElem.find('.butt_add').attr('id', 'btnDel').attr('name', 'btnDel').removeClass('btn-primary').addClass('btn-danger').attr('onclick','remove_fields('+newNum + ')');
        newElem.find('.buttc_add').removeClass('glyphicon-plus').addClass('glyphicon-minus');
        
    // Insert the new element after the last "duplicatable" input field
        $('#entry' + num).after(newElem);
        $('#ID' + newNum + '_serial_id').focus();

    // Right now you can only add 4 sections, for a total of 5. Change '5' below to the max number of sections you want to allow.
        if (newNum == 10)
        $('#btnAdd').attr('disabled', true).prop('value', "You've reached the limit"); // value here updates the text in the 'add' button when the limit is reached 
    });
    
    // 1. prepare the validation rules and messages.
    var rules = {
        place_id: "required",
        sales_no: "required",
        sales_date: "required",
        customer_id: "required",
        payment_status: "required",
        ID1_serial_id: "required",
        ID1_stock_id: "required",
        ID1_qty: "required",
        ID1_price: "required",
    };
    var messages = {
        place_id: "The Store field is required.",
        sales_no: "The Sales No. field is required.",
        sales_date: "The Sales Date field is required.",
        customer_id: "The Customer By field is required.",
        expedition_id: "The Expedition field is required.",
        expedition_cost: "The Expedition Cost field is required.",
        sales_cost: "The Sales Cost field is required.",
        payment_status: "The Payment Status field is required.",
        ID1_serial_id: "The Products field is required, min.1 product.",
        ID1_stock_id: "The Products field is required, min.1 product.",
        ID1_qty: "The Products field is required, min.1 product.",
        ID1_price: "The Products field is required, min.1 product.",
    };
    
    var validator = $("#form2").validate({
        onchange: false,
        errorClass: "err_msg",
        rules: rules,
        groups: {
            product: "ID1_serial_id ID1_stock_id ID1_qty ID1_price"
        },
        errorPlacement: function(error, element) {
            if (element.attr("name") == "ID1_serial_id" || element.attr("name") == "ID1_stock_id" || element.attr("name") == "ID1_qty" || element.attr("name") == "ID1_price") {
                error.insertAfter(".show_err_msg");
            } else {
                error.insertAfter(element);
            }
        },
        messages: messages
    });
    
    $("#submit").click(function () {
        event.preventDefault();

        var num     = $('.clonedInput').length;
        var stock_id = {};
        var total;
        var next = 1;
        var vars = [];
        
        for(i=1; i<=num; i++) {
            vars["qty_" + $("#ID"+i+"_stock_id").val()] = 0;
            vars["max_" + $("#ID"+i+"_stock_id").val()] = $("#ID"+i+"_qty").attr("max");
        }
        
        for(i=1; i<=num; i++) {
            vars["qty_" + $("#ID"+i+"_stock_id").val()] += parseFloat($("#ID"+i+"_qty").val());
            
            if( vars["qty_" + $("#ID"+i+"_stock_id").val()] > vars["max_" + $("#ID"+i+"_stock_id").val()] ) {
                $('.show_err_msg').html('<font color="#FF0000" style="font-weight: 600; letter-spacing: 1px;">Quantity must be lower than available quantity stock</font>');
                next = 0;
                $('#ID' + i + '_qty').focus();
            }
        }
        
        // test if form is valid 
        if($('#form2').validate().form()) {
            if( next == 1) {
                $('#form2').submit();
            } else {
                $('.show_err_msg').focus();
            }
        } else {
            validator.focusInvalid();
            console.log("does not validate");
        }
    });
});