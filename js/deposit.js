	$(document).ready(function() {	
$('[name="type"]').change(function(){		
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
	});
	});
	