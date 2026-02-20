$(document).ready(function() {	

	
	    $(function() {
     $( "#code" ).autocomplete({
                source: function( request, response ) {
					var id;
                    $.ajax({
                        url: "leave/suggest_employee.php",
                        dataType: "json",
                        data: {
                            q: request.term
                        },
						
                        success: function( data ) {
							
							var array = data.map(function(element) {
                return { 
				id: element['id'], 
				value: element['id'] +" ( "+element['firstname']+" "+element['surname']+" )"
				
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
document.getElementById('code1').value = data.item.id;
        }
      
				
            });
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////			
    
    $( "#asset" ).autocomplete({
                source: function( request, response ) {
					var id;
                    $.ajax({
                        url: "suggest_asset.php",
                        dataType: "json",
                        data: {
                            q: request.term
                        },
						
                        success: function( data ) {
							
							var array = data.map(function(element) {
                return { 
				id: element['id'], 
				value: element['description'] +" ( "+element['assert_no']+" )"
					
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
document.getElementById('asset1').value = data.item.id;

        }
      
				
            });
    
	
	
  });
	
});