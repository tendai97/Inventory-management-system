$(document).ready(function() {	 
 $( "#firstname1" ).autocomplete({
                source: function( request, response ) {
					var id;
                    $.ajax({
                        url: "suggest_custodian.php",
                        dataType: "json",
                        data: {
                            q: request.term
                        },
						
                        success: function( data ) {
							
							var array = data.map(function(element) {
                return { 
				id: element['id'], 
				value: element['id'] +" ( "+element['firstname']+" "+element['surname']+" )",
				firstname: element['firstname'],
				surname: element['surname']
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
document.getElementById('personid').value = data.item.id;
document.getElementById('firstname').value = data.item.firstname;
document.getElementById('surname').value = data.item.surname;
//document.getElementById('personid').value = data.item.id;
        }
      
				
            });
			
			   });