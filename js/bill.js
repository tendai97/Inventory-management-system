function tabs(selectedtab) {	
	// contents
	var s_tab_content = "tab_content_" + selectedtab;	
	var contents = document.getElementsByTagName("div");
	for(var x=0; x<contents.length; x++) {
		name = contents[x].getAttribute("name");
		if (name == 'tab_content') {
			if (contents[x].id == s_tab_content) {
			contents[x].style.display = "block";						
			} else {
			contents[x].style.display = "none";
			}
		}
	}	
	// tabs
	var	s_tab = "tab_" + selectedtab;		
	var tabs = document.getElementsByTagName("a");
	for(var x=0; x<tabs.length; x++) {
		name = tabs[x].getAttribute("name");
		if (name == 'tab') {
			if (tabs[x].id == s_tab) {
			tabs[x].className = "active";						
			} else {
			tabs[x].className = "";
			}
		}
	}	  
}

function print_today() {
  // ***********************************************
  // AUTHOR: WWW.CGISCRIPT.NET, LLC
  // URL: http://www.cgiscript.net
  // Use the script, just leave this message intact.
  // Download your FREE CGI/Perl Scripts today!
  // ( http://www.cgiscript.net/scripts.htm )
  // ***********************************************
  var now = new Date();
  var months = new Array('January','February','March','April','May','June','July','August','September','October','November','December');
  var date = ((now.getDate()<10) ? "0" : "")+ now.getDate();
  function fourdigits(number) {
    return (number < 1000) ? number + 1900 : number;
  }
  var today =  months[now.getMonth()] + " " + date + ", " + (fourdigits(now.getYear()));
  return today;
}

// from http://www.mediacollege.com/internet/javascript/number/round.html
function roundNumber(number,decimals) {
  var newString;// The new rounded number
  decimals = Number(decimals);
  if (decimals < 1) {
    newString = (Math.round(number)).toString();
  } else {
    var numString = number.toString();
    if (numString.lastIndexOf(".") == -1) {// If there is no decimal point
      numString += ".";// give it one at the end
    }
    var cutoff = numString.lastIndexOf(".") + decimals;// The point at which to truncate the number
    var d1 = Number(numString.substring(cutoff,cutoff+1));// The value of the last decimal place that we'll end up with
    var d2 = Number(numString.substring(cutoff+1,cutoff+2));// The next decimal, after the last one we want
    if (d2 >= 5) {// Do we need to round up at all? If not, the string will just be truncated
      if (d1 == 9 && cutoff > 0) {// If the last digit is 9, find a new cutoff point
        while (cutoff > 0 && (d1 == 9 || isNaN(d1))) {
          if (d1 != ".") {
            cutoff -= 1;
            d1 = Number(numString.substring(cutoff,cutoff+1));
          } else {
            cutoff -= 1;
          }
        }
      }
      d1 += 1;
    } 
    if (d1 == 10) {
      numString = numString.substring(0, numString.lastIndexOf("."));
      var roundedNum = Number(numString) + 1;
      newString = roundedNum.toString() + '.';
    } else {
      newString = numString.substring(0,cutoff) + d1.toString();
    }
  }
  if (newString.lastIndexOf(".") == -1) {// Do this again, to the new string
    newString += ".";
  }
  var decs = (newString.substring(newString.lastIndexOf(".")+1)).length;
  for(var i=0;i<decimals-decs;i++) newString += "0";
  //var newNumber = Number(newString);// make it a number if you like
  return newString; // Output the result to the form field (change for your purposes)
}

function update_total() {
  var total = 0;
  $('.price').each(function(i){
    price = $(this).html().replace("$","");
    if (!isNaN(price)) total += Number(price);
  });
  
$('#subtotal').html("$"+roundNumber(total,2));

 trans_fee = 0.03 * total ;
  if (trans_fee < 0.3)
   trans_fee = 0.3;
   else if(trans_fee > 1)
   trans_fee=1;
   
   total+=trans_fee;
    $("#trans_fee").val(trans_fee);
  total = roundNumber(total,2);
  $("#total_amount").val(total);
  trans_fee = roundNumber(trans_fee,2);
  
 $('#transaction').html("$"+trans_fee);
  
  $('#total').html("$"+total);
  
  update_balance();
}

function update_balance() {
  var due = $("#total").html().replace("$","") - $("#paid").val().replace("$","");
  due = roundNumber(due,2);
  
  $('.due').html("$"+due);
}

function update_price() {
  var row = $(this).parents('.item-row');
  var price = row.find('.cost').val().replace("$","") * row.find('.qty').val();
  price = roundNumber(price,2);
  isNaN(price) ? row.find('.price').html("N/A") : row.find('.price').html("$"+price);
  
  update_total();
}

function bind() {
  $(".cost").change(update_price);
  $(".qty").change(update_price);
}


$(document).ready(function() {
	$("#id_number").autocomplete("suggest_account.php?type=individual", {
		width: 260,
		matchContains: true,
		//mustMatch: true,
		//minChars: 0,
		//multiple: true,
		//highlight: false,
		//multipleSeparator: ",",
		selectFirst: false,
		formatItem: function(row, i, max) { // Function to format the values when found
			var retStr;
			if (row.length > 1) {
				retStr = row[2]+" "+row[1]+" ("+row[4]+")";
			// retStr += row[2] + "<br />" + "<br />"+ "<br />";
			} else
			retStr = row[1];
			return retStr; // Return HTML code to show foreach row
		},
		formatResult: function(row) { //Function returning the value to put on the field
			if (row.length > 1)  // e.g. if something found
			//return row[0];  //   first field
			 return row[0];  //   first field

			else
			return '';   //   else blank string
		}
	});
	$('#id_number').result(function(event, data, formatted) { // Autocomplete - Result behaviou

		if (data) { // If something selected
			
			//var row = $(this).parents('.item-row');
			$(this).val(data[4]);
			 $('#firstname').val(data[5]);
			$('#surname').val(data[6]);
			$('#dob').val(data[7]);
			$('#address').val(data[8]);
			$('#city').val(data[9]);
			$('#phone').val(data[10]);
			$('#email').val(data[11]);
			$('#pat_number').val(data[12]);
			$('#patientId').val(data[3]);
			$('#id').val(data[3]);
			$('#new').val("1");
			//$('#description').val(data[2]);
			//$('[name='+fieldType+'Zone]').val(data[2]);
		}
	});
	
	$("#product").autocomplete("suggest_product.php?b="+$('#branch').val(), {
		width: 260,
		matchContains: true,
		//mustMatch: true,
		//minChars: 0,
		//multiple: true,
		//highlight: false,
		//multipleSeparator: ",",
		selectFirst: false,
		formatItem: function(row, i, max) { // Function to format the values when found
			var retStr;
			
			if (row.length > 1) {
				retStr = row[2]+" "+row[1]+" ("+row[3]+")";
				
			// retStr += row[2] + "<br />" + "<br />"+ "<br />";
			} else
			retStr = row[1];
			return retStr; // Return HTML code to show foreach row
		},
		formatResult: function(row) { //Function returning the value to put on the field
			if (row.length > 1)  // e.g. if something found
			//return row[0];  //   first field
			 return row[0];  //   first field

			else
			return '';   //   else blank string
		}
	});
	$('#product').result(function(event, data, formatted) { // Autocomplete - Result behaviou

		if (data) { // If something selected
			
			var row = $(this).parents('.item-row');
			$(this).val(data[1]);
			 row.find('.cost').val(data[3]);
			row.find('.description').html(data[2]);
			row.find('.productid').val(data[0]);
			//$('.cost').val(data[3]);
			//$('#description').val(data[2]);
			//$('[name='+fieldType+'Zone]').val(data[2]);
		}
	});
		
		$('[name="payment_method"]').change(function(){
		
		if ($('[name="payment_method"]:checked').val()== "ewallet") {
		
		$('#login-window').attr("href","#pin-box");
		/*$('#submit').html('&nbsp;&nbsp;&nbsp;<a href="#login-box"  class="login-window"><input type="submit" id="Save" value="Save" name="Submit"></a>');
		
		var mywin = window.open("", "my_popup", "location=0,status=0,scrollbars=0,width=500,height=500");
var contents = "HTML content...";
$(mywin.document.body).html(contents);
		var person = prompt("Please enter your pin");
		 alert(person);
    if (person != "") {
       $('[name="pin"]').val(person);
    }*/
		
		
		}else {
		$('#login-window').attr("href","#");
		//$('#submit').html('&nbsp;&nbsp;&nbsp;<input type="submit" id="Save" value="Save" name="Submit">');
		}
		
				});
/*$('[name="type"]').change(function(){		
	$("#acc_num").autocomplete("suggest_account.php?type="+$('[name="type"]').filter(':checked').val(), {
		width: 260,
		matchContains: true,
		//mustMatch: true,
		//minChars: 0,
		//multiple: true,
		//highlight: false,
		//multipleSeparator: ",",
		selectFirst: false,
		formatItem: function(row, i, max) { // Function to format the values when found
			var retStr="";
			if (row.length > 1) {
				retStr = row[3]+" "+row[1]+" ("+row[2]+")";
			// retStr += row[2] + "<br />" + "<br />"+ "<br />";
			} else
			retStr = row[0];
			return retStr; // Return HTML code to show foreach row
		},
		formatResult: function(row) { //Function returning the value to put on the field
			if (row.length > 1)  // e.g. if something found
			//return row[0];  //   first field
			 return row[0];  //   first field

			else
			return '';   //   else blank string
		}
		})
		//bind();
	});
	$('#acc_num').result(function(event, data, formatted) { // Autocomplete - Result behaviou

		if (data) { // If something selected
			var fieldType = $(this).attr('id').substr(0,4);
			$(this).val(data[3]);
			$('[name='+fieldType+'Municipality]').val(data[0]);
			$('[name='+fieldType+'Zip]').val(data[3]);
			$('[name='+fieldType+'Zone]').val(data[2]);
			data = [];
		}
	});*/
	
	
  $('input').click(function(){
    $(this).select();
  });

  $("#paid").blur(update_balance);
   
   var count =0;
  $("#addrow").click(function(){
    $(".item-row:last").after('<tr class="item-row"><td class="item-name"><div class="delete-wpr"><input type="text" id="product'+count+'" name="product[]" value="" placeholder="Item Name" /><input type="hidden"  class="productid" id="productid" name="productid[]"/><a class="delete" href="javascript:;" title="Remove row">X</a></div></td><td class="description"><span>Description</span></td><td><input type="text" class="cost" name="cost[]" value="$0.00" readonly /></td><td><input type="text" class="qty" name="qty[]" value="0"/></td><td><span class="price">$0.00</span></td></tr>');
	/* $("#product"+count).autocomplete("suggest_product.php", {
		width: 260,
		matchContains: true,
		//mustMatch: true,
		//minChars: 0,
		//multiple: true,
		//highlight: false,
		//multipleSeparator: ",",
		selectFirst: false
	});*/
	
	/////auto complete
	
	$("#product"+count).autocomplete("suggest_product.php?b="+$('#branch').val(), {
		width: 260,
		matchContains: true,
		//mustMatch: true,
		//minChars: 0,
		//multiple: true,
		//highlight: false,
		//multipleSeparator: ",",
		selectFirst: false,
		formatItem: function(row, i, max) { // Function to format the values when found
			var retStr;
			if (row.length > 1) {
				retStr = row[2]+" "+row[1]+" ("+row[3]+")";
			// retStr += row[2] + "<br />" + "<br />"+ "<br />";
			} else
			retStr = row[1];
			return retStr; // Return HTML code to show foreach row
		},
		formatResult: function(row) { //Function returning the value to put on the field
			if (row.length > 1)  // e.g. if something found
			//return row[0];  //   first field
			 return row[0];  //   first field

			else
			return '';   //   else blank string
		}
	});
	$("#product"+count).result(function(event, data, formatted) { // Autocomplete - Result behaviou

		if (data) { // If something selected
			
			var row = $(this).parents('.item-row');
			$(this).val(data[1]);
			 row.find('.cost').val(data[3]);
			 row.find('.description').html(data[2]);
			 row.find('.productid').val(data[0]);
			// row.find('.price').html("$"+price)
			//$('.cost').val(data[3]);
			//$('#description').val(data[2]);
			//$('[name='+fieldType+'Zone]').val(data[2]);
		}
	});
	
	count++;
	
    if ($(".delete").length > 0) $(".delete").show();
    bind();
  });
  
  bind();
  
  $(".delete").live('click',function(){
    $(this).parents('.item-row').remove();
    update_total();
    if ($(".delete").length < 2) $(".delete").hide();
  });
  
  $("#cancel-logo").click(function(){
    $("#logo").removeClass('edit');
  });
  $("#delete-logo").click(function(){
    $("#logo").remove();
  });
  $("#change-logo").click(function(){
    $("#logo").addClass('edit');
    $("#imageloc").val($("#image").attr('src'));
    $("#image").select();
  });
  $("#save-logo").click(function(){
    $("#image").attr('src',$("#imageloc").val());
    $("#logo").removeClass('edit');
  });
  
  $("#date").val(print_today());
  
  
  
  /******************************************************pin code***********************************************/
	$('a.login-window').click(function() {
    
            //Getting the variable's value from a link 
    var loginBox = $(this).attr('href');

    //Fade in the Popup
    $(loginBox).fadeIn(300);
    
    //Set the center alignment padding + border see css style
    var popMargTop = ($(loginBox).height() + 24) / 2; 
    var popMargLeft = ($(loginBox).width() + 24) / 2; 
    
    $(loginBox).css({ 
        'margin-top' : -popMargTop,
        'margin-left' : -popMargLeft
    });
    
    // Add the mask to body
    $('body').append('<div id="mask"></div>');
    $('#mask').fadeIn(300);
    
    return false;
});

// When clicking on the button close or the mask layer the popup closed
$('a.close, #mask').live('click', function() { 
  $('#mask , .login-popup').fadeOut(300 , function() {
    $('#mask').remove();  
}); 
return false;
});
///////////////////////////////////////////////////////////supervisor////////////////////////////////////////////
$('a.pin-window').click(function() {
    
            //Getting the variable's value from a link 
    var loginBox = $(this).attr('href');

	 $('#mask , .login-popup').fadeOut(300 , function() {
   // $('#mask').remove();  
}); 




    //Fade in the Popup
    $(loginBox).fadeIn(300);
    
    //Set the center alignment padding + border see css style
    var popMargTop = ($(loginBox).height() + 24) / 2; 
    var popMargLeft = ($(loginBox).width() + 24) / 2; 
    
    $(loginBox).css({ 
        'margin-top' : -popMargTop,
        'margin-left' : -popMargLeft
    });
    
    // Add the mask to body
    $('body').append('<div id="mask"></div>');
    $('#mask').fadeIn(300);
    
    return false;
});

		});
		
		     
		
	