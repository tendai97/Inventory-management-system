	<div id="content">
      
   <table width="200" border="0">
       <tr>
          <td width="34%"><img src="images/number_of_pats.gif" width="354" height="34" alt="No of Assets" /></td>
          <td width="66%"><?php echo  $count = $db->countOf("assets","active=1");?></td>
        </tr>
        <tr>
          <td><img src="images/number_of_deps.gif" width="354" height="34" alt="No of Departments"/></td>
          <td><?php echo  $count = $db->countOf("company_dept","active='1' ");?></td>
        </tr>
       <tr>
          <td><img src="images/number_of_corporates.gif" width="354" height="34" alt="No of Asset Type"/></td>
          <td><?php echo  $count = $db->countOf("asset_type","active='1'");?></td>
        </tr>
		<tr>
          <td height="22"><img src="images/number_of_ma.gif" width="354" height="34" alt="No of Pojects"/></td>
          <td><?php echo  $count = $db->countOf("mining_venture","active='1'");?></td>
        </tr>
		<tr>
          <td height="22"><img src="images/number_of_ma.gif" width="354" height="34" alt="No of Asset Class"/></td>
          <td><?php echo  $count = $db->countOf("asset_group","active='1'");?></td>
        </tr>
        <tr>
          <td><img src="images/number_of_ia.gif" width="354" height="34" alt="No of User"/></td>
          <td><?php echo  $count = $db->countOf("_user","active ='1'");?></td>
        </tr>
		<!-- <tr>
          <td height="36"><img src="images/number_of_users.gif" width="354" height="34" alt="Average Distribution of asset per site"/></td>
          <td><?php //echo  $count = $db->countOf("_user","user_type!= 'Patient' AND active='1'");?></td>
        </tr>-->
		
      </table>
      <p align="justify"><br />
      </p>
      <p align="justify">&nbsp;</p>
      <div align="justify"></div>
<div id="respond"></div>
    </div>