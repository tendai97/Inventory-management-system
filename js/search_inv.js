	    $(function() {
     $( "#code" ).autocomplete({
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
				value: element['id'] +" ( "+element['name']+" "+element['id']+" )"
				
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
			  
	  $('[name="cat"]').change(function() {   
  
   var va = $('#accordion').find('.accordion-toggle-'+this.value);
  // (function(){

      //Expand or collapse this panel
     // $(this).next().slideToggle('fast');
	  va.next().slideToggle('fast');

      //Hide the other panels
     // $(".accordion-content").not($(this).next()).slideUp('fast');
	  $(".accordion-content").not(va.next()).slideUp('fast');

   // });	
});	

    
			  
			  
			  
			  
			  });