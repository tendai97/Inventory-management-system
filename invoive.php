<?php
$id=$_GET['id'];
 
			//$line=$db->queryUniqueObject("SELECT * FROM bill INNER JOIN persons ON persons.id=acc_owner WHERE bill.id=$id");
			$line=$db->queryUniqueObject("SELECT * FROM bill INNER JOIN persons ON persons.id=acc_owner INNER JOIN accounts ON persons.id=OWNER WHERE nature='I' AND bill.id=$id");
				//var_dump($line);
				
?>
 <div id="content">

<form method="post">


  <!-- <table>

	<tr>
           <td width="155">ID Number:</td>
           <td width="473"><input name="id_number" type="text" id="id_number"  class="validate[required,length[0,100]] text-input" value="<?php echo $line->id_number; ?>"/>
		   <input name="id" type="hidden" id="id" value="<?php echo $line->id; ?>" />
		   <input name="new" type="hidden" id="new" value="0" />
		   </td>
         </tr>
	
         <tr>
           <td width="155">Firstname:</td>
           <td width="473"><input name="firstname" type="text" id="firstname"  class="validate[required,length[0,100]] text-input" value="<?php echo $line->firstname; ?>"/></td>
         </tr>         
         <tr>
           <td width="155">Surname:</td>
           <td width="473"><input name="surname" type="text" id="surname"  class="validate[required,length[0,100]] text-input" value="<?php echo $line->surname; ?>"/></td>
         </tr>
         <tr>
           <td>Gender: </td>
           <td><label for="gender"></label>
             <select name="gender" id="gender">
               <option value="Male">Male</option>
               <option value="Female">Female</option>
            </select></td>
         </tr>
         
         <tr>
           <td>Date of Birth:</td>
           <td><input name="dob" type="text" id="dob"  class="validate[optional,custom[onlyNumber],length[6,15]] text-input" value="<?php echo $line->dob; ?>"/></td>
         </tr>
		 
         <tr>
           <td width="155">Address:</td>
           <td width="473"><textarea name="address" id="address" cols="15"><?php echo $line->address; ?></textarea></td>
         </tr> <tr>
           <td width="155">City:</td>
           <td width="473"><input name="city" type="text" id="city"  class="validate[required,length[0,100]] text-input" value="<?php echo $line->city; ?>"/></td>
         </tr> <tr>
           <td width="155">Phone:</td>
           <td width="473"><input name="phone" type="text" id="phone"  class="validate[required,length[0,100]] text-input" value="<?php echo $line->phone; ?>"/></td>
         </tr> <tr>
           <td width="155">Email:</td>
           <td width="473"><input name="email" type="text" id="email"  class="validate[required,length[0,100]] text-input" value="<?php echo $line->email; ?>"/></td>
         </tr>  
		 <tr>
           <td width="155">Patient Number:
            <?php
					  $max = $db->maxOfAll("id","persons");
					  $max=$max+1;
					  $autoid="PAT".str_pad($max, 4, "0", STR_PAD_LEFT)."-00";
					  ?>
					  <input type ="hidden" name="patientId" id="patientId" value
					  ="<?php $line->id;?>"/>
					  </td>
           <td width="473"><input name="pat_number" type="text"  id="pat_number" class="validate[required,length[0,100]] text-input pat_number" value="<?php  echo $line->pat_number; //if (isset($_GET['sid'])) echo $line->pat_number; else echo $autoid; ?>"  readonly /></td>
         </tr>
	
	
</table>-->

  <div id="customer">

           
            <table id="meta">
			 <tr>
                    <td class="meta-head">Service Provider</td>
                    <td><span><?php 
					$bnh=$db->queryUniqueObject("SELECT * FROM branch  WHERE id=".$line->branch);
					echo $bnh->name; ?></span></td>
                </tr>
                
                <tr>
                    <td class="meta-head">Invoice #</td>
                    <td><span><?php		echo $id;			?></span></td>
                </tr>
                <tr>

                    <td class="meta-head">Date</td>
                    <td><span id="date"><?php  echo $line->date_of_sevice;?></span></td>
                </tr>
                <tr>
                    <td class="meta-head">Amount </td>
                    <td><div class="due">$<?php echo number_format($line->total_bill+$line->trans_fee,2); ?></div></td>
                </tr>
				<tr>
                    <td class="meta-head">Account Number </td>
                    <td><div class="due"><?php echo $line->acc_number; ?></div></td>
                </tr>
				<tr>
                    <td class="meta-head">Patient </td>
                    <td><div class="due"><?php 
					$patient=$db->queryUniqueObject("SELECT * FROM persons  WHERE id=".$line->patient);
					echo $patient->firstname." ".$patient->surname; ?></div></td>
                </tr>
<!-- <tr>
                    <td class="meta-head">Payment Method</td>
                    <td>
						<input type="radio" name="payment_method" id="type" value="cash">Cash<br>
						<input type="radio" name="payment_method" id="type"  value="mobile">Mobile Cash<br>
						<input type="radio" name="payment_method" id="type"  value="zimswitch">Zimswitch<br>
						<input type="radio" name="payment_method" id="type"  value="ewallet">e-Wallet<br>
					</td>
                </tr>-->
            </table>
		
		</div>
		
	
		
		<table id="items">
		
		  <tr>
		      <th width="10%">Item</th>
		      <th width="30%">Description</th>
		      <th width="10%">Unit Cost</th>
		      <th width="10%">Quantity</th>
		      <th width="10%">Price</th>
		  </tr>
		  
		  <?php 
		  $result = mysql_query("SELECT *, treatment.price as selling_price FROM treatment INNER JOIN products_services ON products_services.id=product WHERE invoice=$id");
		 if( mysql_num_rows($result)==0)
		 $result = mysql_query("SELECT *, treatment.price as selling_price FROM treatment WHERE invoice=$id");
		 
		  	while($row = mysql_fetch_array($result))
			{
		  ?>
		  <tr class="item-row">
		      <td class="item-name"><span class= "description"><?php echo $row['code']; ?></span></td>
		      <td class="description"><span class= "description"><?php if ($row['product']==0) echo "Pharmacy Drug Dispensation"; else echo $row['description']; ?></span></td>
		      <td><span class= "description">$<?php echo number_format($row['selling_price'],2); ?></span></td>
		      <td><span class= "description"><?php echo $row['qty']; ?></span></td>
		      <td><span class= "description">$<?php  $cost=$row['selling_price']*$row['qty'];echo number_format($cost,2);?></span></td>
		  </tr>
		  
		 <?php } ?>
		  
		  
		 
		 <tr>
		      <td colspan="2" class="blank"> </td>
		      <td colspan="2" class="total-line">Subtotal</td>
		      <td class="total-value"><div id="subtotal">$<?php $sub= $line->total_bill; echo number_format($sub,2); ?></div></td>
		  </tr>
		   <tr>

		      <td colspan="2" class="blank"> </td>
		      <td colspan="2" class="total-line">Transaction Fee</td>
		      <td class="total-value"><div id="transaction">$<?php echo number_format($line->trans_fee,2); ?></div></td>
		  </tr>
		  <tr>

		      <td colspan="2" class="blank"> </td>
		      <td colspan="2" class="total-line">Total</td>
		      <td class="total-value"><div id="total">$<?php echo number_format($line->total_bill+$line->trans_fee,2); ?></div></td>
		  </tr>
		 <!-- <tr>
		      <td colspan="2" class="blank"> </td>
		      <td colspan="2" class="total-line">Amount Paid</td>

		      <td class="total-value"><input name="pat_number" type="text"  class="validate[required,length[0,100]] text-input qty" id="paid" value="$0.00" /></td>
		  </tr>
		  <input name="paid" type="hidden"  class="validate[required,length[0,100]] text-input qty" id="paid" value="$0.00" />
		  <tr>
		      <td colspan="2" class="blank"> </td>
		      <td colspan="2" class="total-line balance">Balance Due</td>
			  <input type="hidden" name="total_amount" id="total_amount"/>
		      <td class="total-value balance"><div class="due">$0.00</div></td>
		  </tr>-->
		  
		  <td align="right">
		  <script type="text/javascript"> 

function popup(form) {

    window.open("print_invoice.php?id="+ <?php echo $_GET['id'];?>, 'formpopup', 'view text','menubar=yes,scrollbars=yes,resizable=yes,width=640,height=700');
    form.target = 'formpopup';
}
</script>
		  
		  <input type="button" name="Reset" value="Reprint" onClick="popup(this)" />
             &nbsp;&nbsp;&nbsp;</td>
		
		</table>
		
		<!--<div id="terms">
		  <h5>Terms</h5>
		  NET 30 Days. Finance Charge of 1.5% will be made on unpaid balances after 30 days.
		</div>-->
	
	
		
		<!--<table><tr>
           <td align="right"><input type="reset" name="Reset" value="Reset" />
             &nbsp;&nbsp;&nbsp;</td>
           <td id= "submit">&nbsp;&nbsp;&nbsp;
		   
		   <a href="#"  class="login-window" id="login-window"><input type="submit" id="Save" value="Save" name="Submit"></a>
             <input type="submit" name="Submit" value="Save" id="Save"/>
			 
			 <input type= "hidden" name="pin" id="pin"/>
			 </td>
         </tr></table>-->

	


	</form>
</div>