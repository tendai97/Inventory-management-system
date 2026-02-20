	$(document).ready(function() {	
//$('[name="type"]').change(function(){		
/*	$("#asset_type").autocomplete("suggest_type.php", {
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
				retStr = row[0]+"  ("+row[1]+")";
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
//	});
	$('#asset_type').result(function(event, data, formatted) { // Autocomplete - Result behaviou

		if (data) { // If something selected
			var fieldType = $(this).attr('id').substr(0,4);
			$(this).val(data[3]);
			$('[name= asset_type]').val(data[1]);
			
		}
	});
	//$('[name="type"]').change(function(){		
	$("#asset_group").autocomplete("suggest_group.php", {
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
				retStr = row[0]+"  ("+row[1]+")";
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
//	});
	$('#asset_group').result(function(event, data, formatted) { // Autocomplete - Result behaviou

		if (data) { // If something selected
			var fieldType = $(this).attr('id').substr(0,4);
			$(this).val(data[3]);
			$('[name= asset_group]').val(data[1]);
			
		}
	});
	*/
	///////////////////////////////////////custodian////////////////////////////////////////////
	
	  $( "#supplier1" ).autocomplete({
                source: function( request, response ) {
					var id;
                    $.ajax({
                        url: "suggest_supplier.php",
                        dataType: "json",
                        data: {
                            q: request.term
                        },
						
                        success: function( data ) {
							
							var array = data.map(function(element) {
                return { 
				id: element['id'], 
				value: element['code'] +" ( "+element['name']+" )",
				code: element['code'],
				name: element['name']
				};
		
            });
			
            response(array);
			return data;									
                        }
                    });
					//return id;
                },
				 select:function(evt, data)
     {
		// alert(data.item.value);
      // when a username is selected, populate related fields in this form
document.getElementById('supplier').value = data.item.id;
        }
      
				
            });
	
		$(function() {
    $(".datepicker" ).datepicker({
	dateFormat: "dd/mm/yy",
	maxDate: 0
	
	});
	
  });
	});