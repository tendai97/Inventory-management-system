<div id="content">
<?php
//var_dump($_POST);//exit;
			$firstname=mysql_real_escape_string($_POST['firstname']);
			$surname=mysql_real_escape_string($_POST['surname']);
			$gender=mysql_real_escape_string($_POST['gender']);
			$id_number=mysql_real_escape_string($_POST['id_number']);
			$dob=mysql_real_escape_string($_POST['dob']);
			$address=mysql_real_escape_string($_POST['address']);
			$city=mysql_real_escape_string($_POST['city']);
			$phone=mysql_real_escape_string($_POST['phone']);
			$email=mysql_real_escape_string($_POST['email']);
			$category=mysql_real_escape_string($_POST['category']);
			$pat_number=mysql_real_escape_string($_POST['pat_number']);
			$corparateId=mysql_real_escape_string($_POST['corparateId']);
			$payment_method=mysql_real_escape_string($_POST["payment_method"]);
			$ismember=mysql_real_escape_string($_POST["new"]);
			$patientId=mysql_real_escape_string($_POST["patientId"]);
			$total_amount=mysql_real_escape_string($_POST["total_amount"]);
			$trans_fee=mysql_real_escape_string($_POST["trans_fee"]);
			$acc_owner=mysql_real_escape_string($_POST["acc_owner"]);

			//$total_amount-=$trans_fee;
			$branch=$_SESSION[SITE_NAME]['branch'];
			$acc_num= $_GET['acc'];
			$line=$db->queryUniqueObject("SELECT * FROM persons INNER JOIN accounts ON persons.id=OWNER WHERE nature='I' AND acc_number =$acc_num");
				
					if(isset($_POST["total_amount"]))
					{
					
				
					if(true)
					{
					if($line->role!="M"){
					if($line->balance >= $total_amount){
						//////////////////inserting bill//////
					$amount=$total_amount-$trans_fee;
						$db->query("INSERT INTO `bill`(`id`,  `patient`,  `date_of_sevice`, `status`, `method_of_payment`,  total_bill, branch,trans_fee,acc_owner)
						VALUES (NULL,' $patientId', NOW(),'Paid', '$payment_method','$amount','$branch','$trans_fee',' $acc_owner')");
		
						$billId=mysql_insert_id();
				
						$db->query("INSERT INTO `transactions`(`id`,`type`,`amount`, `account`, `ref`,insTS,insU,branch)VALUES (NULL,'W','$total_amount','$line->acc_number','$billId',NOW(),'".$_SESSION[SITE_NAME]['username']."','".$_SESSION[SITE_NAME]['branch']."')");
						$new_bal=$line->balance -$total_amount;
						//$new_bal=0;
						if($db->query("UPDATE accounts  SET balance='$new_bal' WHERE acc_number= ".$line->acc_number)){
					
						$branch=$db->queryUniqueObject("SELECT * FROM accounts  WHERE nature='B' AND owner =".$_SESSION[SITE_NAME]['branch']);
						
						$branch_bal=$branch->balance + $amount;
						$db->query("UPDATE accounts  SET balance='$branch_bal' WHERE acc_number= ".$branch->acc_number);
						
						/////////////////////////////////////////////////////
						
						$global=$db->queryUniqueObject("SELECT * FROM accounts  WHERE acc_number= 2");
						
						$global_bal=$global->balance + $trans_fee;
						$db->query("UPDATE accounts  SET balance='$global_bal' WHERE acc_number= 2");
							
					}
					//var_dump($_POST);
		
					for($i=0;$i<count($_POST['qty']);$i++){
					
					if ($_POST['cost'][$i][0]=='$') $cash=substr($_POST['cost'][$i], 1); else $cash=$_POST['cost'][$i];
					$db->query("
					INSERT INTO `treatment` (`id`, `invoice`, `product`,  `price`,  `qty`)
			VALUES (NULL, '$billId', '".$_POST['productid'][$i]."', '".$cash."',   '".$_POST['qty'][$i]."');");
					
			
		}
					
echo "<br><font color=green size=+1 >  $firstname $surname Payment was successfull!</font>" ;
?>
<script type="text/javascript"> 
//var view;
//function viewClick(url) {
  //view= window.open(url,'view text','menubar=yes,scrollbars=yes,resizable=yes,width=640,height=700');
  //view.focus();
//}

//function popup(form) {
//form="print_invoice.php?id="+ <?php echo $billId;?>;
    window.open("print_invoice.php?id="+ <?php echo $billId;?>, 'formpopup', 'view text','menubar=yes,scrollbars=yes,resizable=yes,width=640,height=700');
    form.target = 'formpopup';
//}
</script>
<?php
							}
							else{
								echo "<br><font color=red size=+1 >  $firstname $surname has Insufficent Balance!</font>" ;
							}
						}
		else{
			$inline=$db->queryUniqueObject("SELECT  * FROM corporate_members INNER JOIN `accounts` ON `corparateId`=OWNER WHERE  nature ='c' AND memberId =".$line->id);

			if($inline->balance >=$total_amount){
			//////////////////inserting bill//////
					$amount=$total_amount-$trans_fee;
			$db->query("	INSERT INTO `bill`(`id`,  `patient`,  `date_of_sevice`, `status`, `method_of_payment`,  total_bill, branch,trans_fee,acc_owner)
				VALUES (NULL,' $patientId', NOW(),'Paid', '$payment_method','$amount','$branch','$trans_fee',' $acc_owner')");
		
				$billId=mysql_insert_id();
				
				$db->query("INSERT INTO `transactions`(`id`,`type`,`amount`, `account`, `ref`,insTS,insU,branch)VALUES (NULL,'W','$total_amount','$line->acc_number','$billId',NOW(),'".$_SESSION[SITE_NAME]['username']."','".$_SESSION[SITE_NAME]['branch']."')");
					$new_bal=$line->balance-$total_amount;
					if($db->query("UPDATE accounts  SET balance='$new_bal' WHERE acc_number= ".$line->acc_number)){
					
					$new_corp_bal=$inline->balance -$total_amount;
					$db->query("UPDATE accounts  SET balance='$new_corp_bal' WHERE acc_number= ".$inline->acc_number);
					
					$branch=$db->queryUniqueObject("SELECT * FROM accounts  WHERE nature='B' AND owner =".$_SESSION[SITE_NAME]['branch']);
						$branch_bal=$branch->balance + $amount;
						
						$db->query("UPDATE accounts  SET balance='$branch_bal' WHERE acc_number= ".$branch->acc_number);
						
						$global=$db->queryUniqueObject("SELECT * FROM accounts  WHERE acc_number= 2");
						
						$global_bal=$global->balance + $trans_fee;
						$db->query("UPDATE accounts  SET balance='$global_bal' WHERE acc_number= 2");
				
					}
					
					
	
		
					for($i=0;$i<count($_POST['qty']);$i++){
					
					if ($_POST['cost'][$i][0]=='$') $cash=substr($_POST['cost'][$i], 1); else $cash=$_POST['cost'][$i];
					$db->query("
					INSERT INTO `treatment` (`id`, `invoice`, `product`,  `price`,  `qty`)
			VALUES (NULL, '$billId', '".$_POST['productid'][$i]."', '".$cash."',   '".$_POST['qty'][$i]."');");
					
			
		}
echo "<br><font color=green size=+1 >  $firstname $surname Payment was successfull!</font>" ;
	}
else{
echo "<br><font color=red size=+1 >  $firstname $surname's Corporate has Insufficent Balance!</font>" ;
}
}			
			}	else{
			echo "<br><font color=red size=+1 >  $firstname $surname has Insufficent Balance!</font>" ;
			}	
		}			
						
?>


<form method="post">
<input type="hidden" name ="branch" id="branch" value="<?php echo $_SESSION[SITE_NAME]['branch'];?>" />

   <table>
     <tr>
                    <td class="meta-head">Invoice #</td>
                    <td><span><?php
					
					  $max = $db->maxOfAll("id","bill");
					  $max=$max+1;
					  $autoid=str_pad($max, 6, "0", STR_PAD_LEFT);
					  echo $autoid;
					?></span></td>
                </tr>
                <tr>

                    <td class="meta-head">Date</td>
                    <td><span id="date"><?php $today = date("j, n, Y");  echo $today;?></span></td>
                </tr>

	<tr>
           <td width="155">Account Number:</td>
           <td width="473"><span><?php echo $acc_num; ?></span>
		   
		   </td>
         </tr>
	
         <tr>
           <td width="155">Account Holder:</td>
           <td width="473"><span><?php echo $line->firstname ." ".$line->surname; ?></span>
		   <input type="hidden" name="acc_owner" value="<?php echo $line->id;?>"/>
		   </td>
         </tr>         
         <tr>
           <td width="155">Patient:</td>
           
           <td><label for="patientId"></label>
             <select name="patientId" id="patientId">
			 <option value="">Please Select a Patient</option>
               <option value="<?php echo $line->id;?>">Self</option>
			   <?php
			   $result = mysql_query("SELECT * FROM dependant INNER JOIN persons ON dependent=persons.id WHERE holder=".$line->id);
		  	while($row = mysql_fetch_array($result))
			{
			   ?>
               <option value="<?php echo $row['id']; ?>"><?php echo $row['firstname']." ".$row['surname']; ?></option>
			   <?php } ?>
            </select></td>
         </tr>
       
	
</table>

<?php 
$branch=$db->queryUniqueObject("SELECT * FROM branch  WHERE id =".$_SESSION[SITE_NAME]['branch']);

?>
<table id="item">
<tr class="item-row">
	
	<td class="item-name">Qty</td>
	<td class="item-name">Description</td>
	<td class="item-name">Price</td>
	</tr>
	 <tr>
		      <td></td>
		      <td  class="total-line">Subtotal</td>
		      <td class="total-value"><div id="subtotal">$0.00</div></td>
		  </tr>
		   <tr>

		    <td></td>
		      <td class="total-line">Transaction Fee</td>
		      <td class="total-value"><div id="transaction">$0.00</div>
			  <input type="hidden" name="trans_fee" id="trans_fee">
			  </td>
		  </tr>
		  <tr>

		     <td></td>
		      <td  class="total-line">Total</td>
		      <td class="total-value"><div id="total">$0.00</div></td>
		  </tr>
	
		  <input name="paid" type="hidden"  class="validate[required,length[0,100]] text-input qty" id="paid" value="$0.00" />
		  <tr>
		      <td></td>
		      <td class="total-line balance">Balance Due</td>
			  <input type="hidden" name="total_amount" id="total_amount"/>
		      <td class="total-value balance"><div class="due">$0.00</div></td>
		  </tr>
	</table>
	<?php 
	//while (true)
	//{
	?>
		 
		<table id="items">
		
		
		      
		  
		  
		  <tr>
		       <td>Item</td> 
			   <td class="item-name"><div class="delete-wpr"><input type="text"  id="product"  placeholder="Item Name" />
			   <input type="hidden" class="productid"  id="productid"   />
		</td>
			 </tr>
			   <tr>
		          <td>Description</td>
		      <td class="description"><span class= "description">Description</span></td>
			  </tr>
			  <tr>
			  <td>Unit Cost</td>
		      <td><input type="text" class="cost" value="$0.00" readonly /></td>
			  </tr>
			  <tr>
			  <td>Quantity</td>
		      <td>
			  <input  type="text"   class="qty"  value="0"/>
			 </td>
			 </tr>
			 <tr>
			       <td>Price</td>
		      <td><span class="price">$0.00</span></td>
		  </tr>
		  	 <?php 
	if ($branch->type== 'C'){
	?> 
		  <tr id="hiderow">
		  
		    <td colspan="5"><a id="addrow" href="javascript:;" title="Add a row">Add a row</a></td>
	
		  </tr>
		  <?php } ?>

		 <!--<tr id="hiderow">
		   
			<td colspan="5"><a id="cal" href="javascript:;" title="Calculate">Calculate</a></td>
		  </tr>-->
		
		
		</table>
		
		<?php //} ?>

		<table><tr>
           <td align="right"><input type="reset" name="Reset" value="Reset" />
             &nbsp;&nbsp;&nbsp;</td>
           <td id= "submit">&nbsp;&nbsp;&nbsp;
		   
		   <a href="#"  class="login-window" id="login-window"><input type="submit" id="Save" value="Save" name="Submit"></a>
            
			 </td>
         </tr></table>
	



	</form>
</div>