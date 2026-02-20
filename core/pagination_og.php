<?php

	//$total_pages = 200; /// to be deleted
	$adjacents= 1;
	
	$limit = 10; 								//how many items to show per page
	

	if(isset($_GET['limit']))
	$limit=$_GET['limit'];
	
	$page = $_GET['page'];

	if($page) 

		$start = ($page - 1) * $limit; 			//first item to display on this page

	else

		$start = 0;								//if no page var is given, set start to 0


	/* Setup page vars for display. */

	if ($page == 0) $page = 1;					//if no page var is given, default to 1.

	$prev = $page - 1;							//previous page is page - 1

	$next = $page + 1;							//next page is page + 1

	$lastpage = ceil($total_pages/$limit);		//lastpage is = total pages / items per page, rounded up.

	$lpm1 = $lastpage - 1;						//last page minus 1

	

	/* 

		Now we apply our rules and draw the pagination object. 

		We're actually saving the code to a variable in case we want to draw it more than once.

	*/

	$pagination = "";

	if($lastpage > 1)

	{	

		$pagination .= "<div class=\"pagination\"> <ul class=\"pagination\">";

		//previous button

		if ($page > 1) 

			$pagination.= "<li><a href=\"$targetpage&page=$prev&limit=$limit\">« prev</a></li>";

		else
			$pagination.= "<li class=\"disabled\"><a style=\"cursor: pointer;\">« prev</a></li>";

			//$pagination.= "<span class=\"disabled\">&laquo; previous</span>";	

		

		//pages	

		if ($lastpage < 7 + ($adjacents * 2))	//not enough pages to bother breaking it up

		{	

			for ($counter = 1; $counter <= $lastpage; $counter++)

			{

				if ($counter == $page)

					//$pagination.= "<span class=\"current\">$counter</span>";
					$pagination.="<li class=\"active\"><a style=\"cursor: pointer;\">$counter</a></li>";

				else

					$pagination.= "<li><a href=\"$targetpage&page=$counter&limit=$limit\">$counter</a></li>";					

			}

		}

		elseif($lastpage > 5 + ($adjacents * 2))	//enough pages to hide some

		{

			//close to beginning; only hide later pages

			if($page < 1 + ($adjacents * 2))		

			{
				

				for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)

				{

					if ($counter == $page)

						$pagination.= "<li class=\"disabled\"><a style=\"cursor: pointer;\">$counter</a></li>";

					else

						$pagination.= "<li><a href=\"$targetpage&page=$counter&limit=$limit\">$counter</a></li>";					

				}

				$pagination.= "<li class=\"disabled\"><a style=\"cursor: pointer;\">...</a></li>";

				$pagination.= "<li><a href=\"$targetpage&page=$lpm1&limit=$limit\">$lpm1</a></li>";

				$pagination.= "<li><a href=\"$targetpage&page=$lastpage&limit=$limit\">$lastpage</a></li>";		

			}

			//in middle; hide some front and some back

			elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))

			{

				$pagination.= "<li><a href=\"$targetpage&page=1&limit=$limit\">1</a></li>";

				$pagination.= "<li><a href=\"$targetpage&page=2&limit=$limit\">2</a></li>";

				$pagination.= "<li class=\"disabled\"><a style=\"cursor: pointer;\">...</a></li>";

				for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)

				{

					if ($counter == $page)

						$pagination.= "<li class=\"disabled\"><a style=\"cursor: pointer;\">$counter</a></li>";

					else

						$pagination.= "<li><a href=\"$targetpage&page=$counter&limit=$limit\">$counter</a></li>";					

				}

				$pagination.= "<li class=\"disabled\"><a style=\"cursor: pointer;\">...</a></li>";

				$pagination.= "<li><a href=\"$targetpage&page=$lpm1&limit=$limit\">$lpm1</a></li>";

				$pagination.= "<li><a href=\"$targetpage&page=$lastpage&limit=$limit\">$lastpage</a></li>";		

			}

			//close to end; only hide early pages

			else

			{

				$pagination.= "<li><a href=\"$targetpage&page=1&limit=$limit\">1</a></li>";

				$pagination.= "<li><a href=\"$targetpage&page=2&limit=$limit\">2</a></li>";

				$pagination.= "<li class=\"disabled\"><a style=\"cursor: pointer;\">...</a></li>";

				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)

				{

					if ($counter == $page)

						$pagination.= "<li class=\"disabled\"><a style=\"cursor: pointer;\">$counter</a></li>";

					else

						$pagination.= "<li><a href=\"$targetpage&page=$counter&limit=$limit\">$counter</a></li>";					

				}

			}

		}

		

		//next button

		if ($page < $counter - 1) 

			$pagination.= "<li><a href=\"$targetpage&page=$next&limit=$limit\">next »</a></li>";

		else
$pagination.= "<li class=\"disabled\"><a style=\"cursor: pointer;\">next »</a></li>";
			//$pagination.= "<span class=\"disabled\">next &raquo;</span>";

		$pagination.= "</lu></div>\n";		

	}
	//echo $pagination;
	?>