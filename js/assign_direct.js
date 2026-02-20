$(document).ready(function() {	

	    $(function() {
     $( "#emp" ).autocomplete({
                source: function( request, response ) {
					var id;
                    $.ajax({
                        url: "suggest_employee.php",
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
document.getElementById('emp_id').value = data.item.id;
        }
      
				
            });
  });
	
	    $(function() {
    $( "#code" ).autocomplete({
                source: function( request, response ) {
					var id;
                    $.ajax({
                        url: "suggest_vehicle.php",
                        dataType: "json",
                        data: {
                            q: request.term
                        },
						
                        success: function( data ) {
							
							var array = data.map(function(element) {
                return { 
				id: element['id'], 
				value: element['reg_no'] +" ( "+element['make']+" "+element['model']+" )" ,
				make:element['make'] ,
				model:element['model'] 
				
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
document.getElementById('reg1').value = data.item.id;

        document.getElementById('make').value  = data.item.make;
//		document.getElementById("make").disabled = true;
		
        document.getElementById('model').value  = data.item.model;
//		document.getElementById("model").disabled = true;
        }
      
				
            });
    
	
	
  });
	
});