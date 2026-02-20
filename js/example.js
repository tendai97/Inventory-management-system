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
  var trans_fee=0;
  $('.price').each(function(i){
    price = $(this).html().replace("$","");
    if (!isNaN(price)) total += Number(price);
  });

  trans_fee = roundNumber(0.03*total,2);
  if (trans_fee < 0.3)
   trans_fee=roundNumber(0.3,2);
   else if(trans_fee > 1)
   trans_fee=roundNumber(1,2);
   
   
  total = roundNumber(total+trans_fee,2);
  
 $('#transaction').html("$"+trans_fee);
  $('#subtotal').html("$"+total);
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
  $(".cost").blur(update_price);
  $(".qty").blur(update_price);
}

$(document).ready(function() {

  $('input').click(function(){
    $(this).select();
  });

  $("#paid").blur(update_balance);
   
   var count =0;
  $("#addrow").click(function(){
    $(".item-row:last").after('<tr class="item-row"><td class="item-name"><div class="delete-wpr"><input type="text" id="product'+count+'" name="product[]" value="" placeholder="Item Name" /><a class="delete" href="javascript:;" title="Remove row">X</a></div></td><td class="description"><span>Description</span></td><td><input type="text" class="cost" name="cost[]" value="$0.00" readonly /></td><td><input type="text" class="qty" name="qty[]" value="0"/></td><td><span class="price">$0.00</span></td></tr>');
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
	
	$("#product"+count).autocomplete("suggest_product.php", {
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
  
  /* $("#product").autocomplete("suggest_product.php", {
        width: 260,
        matchContains: true,
        selectFirst: false
    });*/
   
  
});