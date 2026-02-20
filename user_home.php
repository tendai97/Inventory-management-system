	<div id="content">
      <h1>Welcome <?php $line = $db->queryUniqueObject("SELECT * FROM _user WHERE username= '".$_SESSION[SITE_NAME]['username']."'");
	 echo ucfirst(strtolower($line->firstname))." ".ucfirst(strtolower($line->surname)) ;
	 ?></h1>
     
      <p align="justify"><br />
      </p>
      <p align="justify">&nbsp;</p>
      <div align="justify"></div>
<div id="respond"></div>
    </div>