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

function change_qty(rid) {
    var value = $('#ID' + rid + '_material_weight').val();
    var max_val = $('#ID' + rid + '_material_weight').attr('max');
    var min_val = $('#ID' + rid + '_material_weight').attr('min');
    
    if ((value !== '') && (value.indexOf('.') === -1)) {
        
        $('#ID' + rid + '_material_weight').val(Math.max(Math.min(value, max_val), min_val));
    }
}

function change_max(rid) {
    var material_id = $("#ID"+rid+"_material_id option:selected").val();
	
    $.ajax({ url: "/admin/material-reduction/ajax-get-max",
        data: {"material_id":material_id},
		dataType: 'json',
        type: 'post',
        success: function(output) {
			//console.log(output);
			$('#ID' + rid + '_material_weight').attr('max',output.datas.qty_max).val('0');
        }
    });
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
	
        newElem.find('.select_material').attr('id', 'ID' + newNum + '_material_id').attr('name', 'ID' + newNum + '_material_id').attr('onchange','change_max('+newNum + ')').val('');
        newElem.find('.input_weight').attr('id', 'ID' + newNum + '_material_weight').attr('name', 'ID' + newNum + '_material_weight').attr('oninput','change_qty('+newNum + ')').val('0');
        newElem.find('.input_desc').attr('id', 'ID' + newNum + '_description').attr('name', 'ID' + newNum + '_description').val('');
        newElem.find('.butt_add').attr('id', 'btnDel').attr('name', 'btnDel').removeClass('btn-primary').addClass('btn-danger').attr('onclick','remove_fields('+newNum + ')');
        newElem.find('.glyphicon').removeClass('glyphicon-plus').addClass('glyphicon-minus');
		
    // Insert the new element after the last "duplicatable" input field
        $('#entry' + num).after(newElem);
        $('#ID' + newNum + '_material_id').focus();

    // Right now you can only add 4 sections, for a total of 5. Change '5' below to the max number of sections you want to allow.
        if (newNum == 10)
        $('#btnAdd').attr('disabled', true).prop('value', "You've reached the limit"); // value here updates the text in the 'add' button when the limit is reached 
    });
	
	// 1. prepare the validation rules and messages.
	var rules = {
		ID1_material_id: "required",
		ID1_material_weight: "required",
	};
	var messages = {
		ID1_material_id: "The Material field is required, min.1 material.",
		ID1_material_weight: "The Material field is required, min.1 material.",
	};
	
	$("#form2").validate({
		onchange: false,
		errorClass: "err_msg",
		rules: rules,
        groups: {
            material: "ID1_material_id ID1_material_weight "
        },
		errorPlacement: function(error, element) {
			if ( element.attr("name") == "ID1_material_id" || element.attr("name") == "ID1_material_weight" ) {
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