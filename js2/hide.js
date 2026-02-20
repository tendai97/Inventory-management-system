$(document).ready(function() {
	$("#conditional").change(function() {
		 if(this.checked) {
	
	
		document.getElementById('cond_gen').style.display='block';
	document.getElementById('cond_gen').style.visibility='visible';
	document.getElementById('cond_gen1').style.display='none';
	document.getElementById('cond_gen1').style.visibility='hidden'
	
	document.getElementById('cond_gen2').style.display='block';
	document.getElementById('cond_gen2').style.visibility='visible';
	document.getElementById('cond_gen3').style.display='none';
	document.getElementById('cond_gen3').style.visibility='hidden'
	
     }
     else {
	 
        
			document.getElementById('cond_gen1').style.display='block';
	document.getElementById('cond_gen1').style.visibility='visible';
	document.getElementById('cond_gen').style.display='none';
	document.getElementById('cond_gen').style.visibility='hidden'
         
		 document.getElementById('cond_gen3').style.display='block';
	document.getElementById('cond_gen3').style.visibility='visible';
	document.getElementById('cond_gen2').style.display='none';
	document.getElementById('cond_gen2').style.visibility='hidden'
		
     }
	});

 // put all your jQuery goodness in here.
   $("#has_image").change(function() {
     if(this.checked) {
	
	
        $("#addtional").slideDown(1000);
		
	
     }
     else {
	 
        $("#addtional").slideUp(1000); 
			
     }
});
	
   // put all your jQuery goodness in here.
   $("#has_sub").change(function() {
     if(this.checked) {
	 //document.getElementById('image1').style.display='block';
	//document.getElementById('image1').style.visibility='visible';
	// document.getElementById('image').style.display='none';
	//document.getElementById('image').style.visibility='hidden';
	$("#image").slideUp(1000); 
         $("#image1").slideDown(1000);
     }
     else {
	 
         $("#image1").slideUp(1000); 
         $("#image").slideDown(1000);
		 //document.getElementById('image1').style.display='none';
	//document.getElementById('image1').style.visibility='hidden';
     }
});
  $('[name="pay_method"]').change(function() {   
  
     if(this.value =="Medical_aid") {
	document.getElementById('image').style.display='block';
	document.getElementById('image').style.visibility='visible';
	// document.getElementById('image').style.display='none';
	//document.getElementById('image').style.visibility='hidden';
	//$("#image").slideUp(1000); 
       //  $("#image1").slideDown(1000);
	
     }
    else {
	 
        // $("#image").slideUp(1000); 
       // $("#image").slideDown(1000);
		 document.getElementById('image').style.display='none';
	document.getElementById('image').style.visibility='hidden';
     }
});

$('[name="solutionchoice"]').change(function() {

     
     if(this.value=="range") {
	
	  //document.getElementById('solution').value="text"; 
	  $('#solution').attr("value", "1");
	//lert(document.getElementById('solution').value);
	   (document.getElementById('imagesol').parentNode).removeChild(document.getElementById('imagesol'));
	  (document.getElementById('imagemis').parentNode).removeChild(document.getElementById('imagemis'));
	   
      $("#textsol").slideDown(1000);
	   // $("#textmis").slideDown(1000);
	  
	  //$("#imagemis").slideUp(1000);
	 //(document.getElementById('imagemis').parentNode).removeChild(document.getElementById('imagemis'));
	  
      $("#textmis").slideDown(1000);
     }
     else if(this.value=="absolute"){
	   $('#solution').attr("value", "0");
      
		(document.getElementById('textsol').parentNode).removeChild(document.getElementById('textsol'));
		
		 
		// $("#textmis").slideUp(1000); 
		(document.getElementById('textmis').parentNode).removeChild(document.getElementById('textmis'));
		 $("#imagemis").slideDown(1000);
	 $("#imagesol").slideDown(1000);
     }
	 $(":radio[name='solutionchoice']").attr("disabled", true);
});
   /*
   $(":radio").click(function(){
   var radioName = $(this).attr("name"); //Get radio name
   $(":radio[name='"+radioName+"']").attr("disabled", true); //Disable all with the same name
});*/
 });

function pagechange(frompage, topage) {
  var page=document.getElementById('formpage_'+frompage);
  if (!page) return false;
  page.style.visibility='hidden';
  page.style.display='none';

  page=document.getElementById('formpage_'+topage);
  if (!page) return false;
  page.style.display='block';
  page.style.visibility='visible';

  return true;
}
function pagechange(topage) {
 
  myContainerArray = document.getElementsByName('insert');
for (i=0; i < myContainerArray.length; i++)
{
myContainerArray[i].style.visibility = 'hidden';  
myContainerArray[i].style.display='none';
//alert(myContainerArray[i].getAttribute("id"));
}
 
  

  var page=document.getElementById('formpage_'+topage);
  if (!page) return false;
  page.style.display='block';
  page.style.visibility='visible';

  return true;
}
function newupload() {
 myContainerArray = document.getElementsByName('solutionchoice');
 var newrow = document.createElement('div');
 for (i=0; i < myContainerArray.length; i++)
{


if(myContainerArray[i].checked){
if(myContainerArray[i].value=='text'){
  newrow.innerHTML = '<div class="boxfield"> Answer :<input type="text" name="answer[]" size=70> </div>';
  }
  else if(myContainerArray[i].value=='image'){
  newrow.innerHTML = '<div class="boxfield"> Answer :<input type="file" name="answer[]" size=70> </div>';
  }
  }
  }
  document.getElementById("misleading").appendChild(newrow);
}
function cupload(){
 myContainerArray = document.getElementsByName('solutionchoice');
 var newrow = document.createElement('div');
 for (i=0; i < myContainerArray.length; i++)
{


if(myContainerArray[i].checked){
if(myContainerArray[i].value=='text'){
  newrow.innerHTML = '<div class="boxfield"> Correct Answer :<input type="text" name="correctAns[]" size=70> </div>';
  }
  else if(myContainerArray[i].value=='image'){
  newrow.innerHTML = '<div class="boxfield"> Correct Answer :<input type="file" name="correctAns[]" size=70> </div>';
  }
  }
  }
  document.getElementById("correct").appendChild(newrow);

}
function setVal(target, source){
document.getElementById(target).value = document.getElementById(source).value;
}


