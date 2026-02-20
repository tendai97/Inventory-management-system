$(document).ready(function() {
	$(function() {
    $(".datepicker" ).datepicker({
	dateFormat: "dd/mm/yy",
	maxDate: 0
	
	});
	
  });
  
  
  
   
  $(function() {
   $( ".timepicker" ).timepicker({
        timeFormat: 'HH:mm:ss',
        // year, month, day and seconds are not important
        minTime: new Date(0, 0, 0, 8, 0, 0),
        maxTime: new Date(0, 0, 0, 15, 0, 0),
        // time entries start being generated at 6AM but the plugin 
        // shows only those within the [minTime, maxTime] interval
        startHour: 6,
        // the value of the first item in the dropdown, when the input
        // field is empty. This overrides the startHour and startMinute 
        // options
        startTime: new Date(0, 0, 0, 8, 20, 0),
        // items in the dropdown are separated by at interval minutes
        interval: 10
    });
  });
  
    $(function() {
   
    $( "#natid" ).autocomplete({
                source: function( request, response ) {
					var id;
                    $.ajax({
                        url: "get.persons.php",
                        dataType: "json",
                        data: {
                            q: request.term
                        },
						
                        success: function( data ) {
							
							var array = data.map(function(element) {
                return { 
				id: element['id'], 
				value: element['natid'] +" ( "+element['fname']+" "+element['sname']+" )",
				natid:element['natid'] ,
				gender:element['gender'] ,
				ms:element['ms'] ,
				dob:element['dob'] ,
				fname:element['fname'] ,
				email:element['email'] ,
				phone:element['phone'] ,
				sname:element['sname'] 				
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
//document.getElementById("rname").disabled = true;

        document.getElementById('name').value = data.item.fname;
		document.getElementById("name").disabled = true;
		
        document.getElementById('surname').value  = data.item.sname;
		document.getElementById("surname").disabled = true;
		
        document.getElementById('dob').value  = data.item.dob;
		document.getElementById("dob").disabled = true;
		
        document.getElementById('gender').value  = data.item.gender;
		document.getElementById("gender").disabled = true;
		
		   document.getElementById('maritail_status').value  = data.item.ms;
		   document.getElementById("maritail_status").disabled = true;
		   
		    document.getElementById('phone').value  = data.item.phone;
		   document.getElementById("phone").disabled = true;
		   
		    document.getElementById('e-mail').value  = data.item.email;
		   document.getElementById("e-mail").disabled = true;
        }
      
				
            });
    
	
	   
    $( "#rname , #code" ).autocomplete({
                source: function( request, response ) {
					var id;
                    $.ajax({
                        url: "get.referer.php",
                        dataType: "json",
                        data: {
                            q: request.term
                        },
						
                        success: function( data ) {
							
							var array = data.map(function(element) {
                return { 
				id: element['id'], 
				
				value: element['name']+" ( "+element['qc']+" )",
				name:element['name'] ,
				qc:element['qc'] ,
				code:element['code'] ,
				address:element['address'] ,
				email:element['email'] ,
				telephone:element['telephone'] 				
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
		 //alert(data.item.value);
      // when a username is selected, populate related fields in this form
document.getElementById('rname').value = data.item.name;
document.getElementById("rname").disabled = true;

        document.getElementById('code').value = data.item.id;
		//document.getElementById("code").disabled = true;
		        document.getElementById('rid').value = data.item.id;
        document.getElementById('qualification').value  = data.item.qc;
		document.getElementById("qualification").disabled = true;
		
        document.getElementById('contactNo').value  = data.item.telephone;
		document.getElementById("contactNo").disabled = true;
		
        document.getElementById('re-mail').value  = data.item.email;
		document.getElementById("re-mail").disabled = true;
		
		   document.getElementById('raddress').value  = data.item.address;
		   document.getElementById("raddress").disabled = true;
        }
      
				
            });
  });
  

				})