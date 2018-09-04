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

function change_total(rid) {
	var qty = $("#ID"+rid+"_qty").val();
	var price = $("#ID"+rid+"_price").val();
	var disc = $("#ID"+rid+"_discount").val();
	
	var total = parseInt((qty*price) - disc);
	
	$("#ID"+rid+"_total").val(total);
	
	//get all total
	var num     = $('.clonedInput').length;
	var all_total = 0;
	var total_qty = 0;
	var i;
	
	for(i=1; i<=num; i++){
		all_total += parseInt($("#ID"+i+"_total").val());
		total_qty += parseFloat($("#ID"+i+"_qty").val());
	}
	
	$("#total").val(all_total);
	$("#total_qty").val(total_qty);
}

function remove_fields(rid) {
	$('#entry' + rid).slideUp('fast', function () {$(this).remove();});
	$('#btnAdd').attr('disabled', false).prop('value', "add section");
}

$(function () {
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
	
        newElem.find('.select_acc').attr('id', 'ID' + newNum + '_acc_id').attr('name', 'ID' + newNum + '_acc_id').val('');
        newElem.find('.input_qty').attr('id', 'ID' + newNum + '_qty').attr('name', 'ID' + newNum + '_qty').val('0');
        newElem.find('.input_price').attr('id', 'ID' + newNum + '_price').attr('name', 'ID' + newNum + '_price').val('0');
        newElem.find('.input_disc').attr('id', 'ID' + newNum + '_discount').attr('name', 'ID' + newNum + '_discount').val('0');
        newElem.find('.input_total').attr('id', 'ID' + newNum + '_total').attr('name', 'ID' + newNum + '_total').val('0');
        newElem.find('.butt_add').attr('id', 'btnDel').attr('name', 'btnDel').removeClass('btn-primary').addClass('btn-danger').attr('onclick','remove_fields('+newNum + ')');
        newElem.find('.glyphicon').removeClass('glyphicon-plus').addClass('glyphicon-minus');
		
    // Insert the new element after the last "duplicatable" input field
        $('#entry' + num).after(newElem);
        $('#ID' + newNum + '_acc_id').focus();

    // Right now you can only add 4 sections, for a total of 5. Change '5' below to the max number of sections you want to allow.
        if (newNum == 10)
        $('#btnAdd').attr('disabled', true).prop('value', "You've reached the limit"); // value here updates the text in the 'add' button when the limit is reached 
    });
	
	// 1. prepare the validation rules and messages.
	var rules = {
		acc_purchase_no: "required",
		acc_purchase_date: "required",
		acc_supplier_id: "required",
		payment_status: "required",
		ID1_acc_id: "required",
		ID1_qty: "required",
		ID1_price: "required",
	};
	var messages = {
		acc_purchase_no: "The Purchase No. field is required.",
		acc_purchase_date: "The Purchase Date field is required.",
		acc_supplier_id: "The Supplier Name field is required.",
		payment_status: "The Payment Status field is required.",
		ID1_acc_id: "The Accessories field is required, min.1 acc.",
		ID1_qty: "The Accessories field is required, min.1 acc.",
		ID1_price: "The Accessories field is required, min.1 acc.",
	};
	
	$("#form2").validate({
		onchange: false,
		errorClass: "err_msg",
		rules: rules,
        groups: {
            acc: "ID1_acc_id ID1_qty ID1_price"
        },
		errorPlacement: function(error, element) {
			if ( element.attr("name") == "ID1_acc_id" || element.attr("name") == "ID1_qty" ||  element.attr("name") == "ID1_price") {
				error.insertAfter(".show_err_msg");
			} else {
				error.insertAfter(element);
			}
		},
		messages: messages
	});
	
	$("#submit").click(function () {
		event.preventDefault();

		// test if form is valid 
		if($('#form2').validate().form()) {
			console.log("validates");
			$('#form2').submit();
		} else {
			console.log("does not validate");
		}
	});
});