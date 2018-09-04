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

function remove_fields(rid) {
	$('#entry' + rid).slideUp('fast', function () {$(this).remove();});
	$('#btnAdd').attr('disabled', false).prop('value', "add section");
}

function change_serial() {
    var place_id = $("#from_place_id option:selected").val();
    
    for (var rid = 1; rid <= $('.clonedInput').length; rid++) {
        $('#ID' + rid + '_div_serial').html('<select id="ID'+rid+'_serial_id" class="select_pr form-control" type="text" name="ID'+rid+'_serial_id" value="" onchange="change_sku('+rid+')">');
        $('#ID' + rid + '_serial_id').append('<option value="">-Choose-</option>');
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
    var place_id = $("#from_place_id option:selected").val();
    
	$('#ID' + rid + '_div_stock').html('<select id="ID'+rid+'_stock_id" class="select_st form-control" type="text" name="ID'+rid+'_stock_id" value="" onchange="change_unit('+rid+')">');
	$('#ID' + rid + '_stock_id').append('<option value="">-Choose-</option>');
	
    $.ajax({ url: "/admin/moving/ajax-get-sku",
        data: {"serial_id":serial_id, "place_id":place_id},
		dataType: 'json',
        type: 'post',
        success: function(output) {
			//console.log(output);
            for (var x = 0; x < output.length; x++) {
				$('#ID' + rid + '_stock_id').append('<option value="' + output[x].stock_id + '">' + output[x].sku + '</option>');
            }
            $("#ID"+rid+"_buttq_min").attr('disabled', true);
            $("#ID"+rid+"_buttq_add").attr('disabled', false);
        }

    });
}

function change_unit(rid) {
    var stock_id = $("#ID"+rid+"_stock_id option:selected").val();
    var place_id = $("#from_place_id option:selected").val();
	
    $.ajax({ url: "/admin/sales/ajax-get-unit",
        data: {"stock_id":stock_id, "place_id":place_id},
		dataType: 'json',
        type: 'post',
        success: function(output) {
			console.log(output);
			$('#ID' + rid + '_product_unit_id').val(output.datas.product_unit_name);
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
    $('#btnAdd').click(function () {
        var num     = $('.clonedInput').length, // Checks to see how many "duplicatable" input fields we currently have
            newNum  = new Number(num + 1),      // The numeric ID of the new input field being added, increasing by 1 each time
            newElem = $('#entry' + num).clone().attr('id', 'entry' + newNum).fadeIn('fast'); // create the new element via clone(), and manipulate it's ID using newNum value
    
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
        newElem.find('.input_qty').attr('id', 'ID' + newNum + '_qty').attr('name', 'ID' + newNum + '_qty').attr('oninput','change_qty('+newNum + ')').val('');
        newElem.find('.input_pu').attr('id', 'ID' + newNum + '_product_unit_id').attr('name', 'ID' + newNum + '_product_unit_id').val('');
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
		from_place_id: "required",
		to_place_id: "required",
		moving_date: "required",
		moved_by: "required",
		ID1_serial_id: "required",
		ID1_stock_id: "required",
		ID1_qty: "required",
		ID1_product_unit_id: "required"
	};
	var messages = {
		from_place_id: "The From Place field is required.",
		to_place_id: "The To Place field is required.",
		moving_date: "The Moving Date field is required.",
		moved_by: "The Moved By field is required.",
		ID1_serial_id: "The Products field is required, min.1 product.",
		ID1_stock_id: "",
		ID1_qty: "",
		ID1_product_unit_id: ""
	};
	
	$("#form2").validate({
		onchange: false,
		errorClass: "err_msg",
		rules: rules,
        groups: {
            product: "ID1_serial_id ID1_stock_id ID1_qty"
        },
		errorPlacement: function(error, element) {
			if (element.attr("name") == "ID1_serial_id" || element.attr("name") == "ID1_stock_id" || element.attr("name") == "ID1_qty" ) {
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