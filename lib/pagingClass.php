<?php
class PagingClass2
{
	var $tot_rec;			// Total records in DB  
	var $rec_per_page;		// Records per page to display
	var $tot_pages;			// Total Pages
	var $fix_page;			// Fix Page length to display
	var $html_code;			// Html Code for display


	/****	CONSTRUCTOR		****/
	function PagingClass2($tot_rec, $rec_per_page)
	{
		$this->tot_rec = $tot_rec;
		$this->rec_per_page = $rec_per_page;
		$this->tot_pages = ceil($this->tot_rec / $this->rec_per_page);
		$fix_page = $rec_per_page;
		$this->html_code = "";
	}

	function DisplayPaging($curr_page)
	{
	
		$getString = $this->getQueryString(array("page"));
		$this->html_code = "<table align=center><tr><td>";
		
		// If user clicks on Page number 1
		if($curr_page == 1)
		{
			if($this->tot_pages == 1)
			{
				//$this->html_code .= "<a href=\"?".$getString."&page=$this->tot_pages\">1</a>&nbsp;&nbsp;&nbsp;";
				$this->html_code .= "";
			}
			if($this->tot_pages == 2)
			{
				for($i = 1; $i <= $this->tot_pages; $i++)
				{
					$this->html_code .= "<a href=\"?".$getString."&page=$i\">$i</a>&nbsp;&nbsp;&nbsp;";
				}
			}
			if($this->tot_pages > 2)
			{
				for($i = 1; $i <= 2; $i++)
				{
					$this->html_code .= "<a href=\"?".$getString."&page=$i\">$i</a>&nbsp;&nbsp;&nbsp;";
				}
				$next = $i++;
				$this->html_code .= "<a href=\"?".$getString."&page=$next\">Next</a>&nbsp;&nbsp;&nbsp;";
			}
		}



		// If user clicks on Page number 2
		if($curr_page == 2)
		{
			if($this->tot_pages == 1)
			{
				$this->html_code .= "<a href=\"?".$getString."&page=$this->tot_pages\">1</a>&nbsp;&nbsp;&nbsp;";
			}
			if($this->tot_pages == 2)
			{
				for($i = 1; $i <= $this->tot_pages; $i++)
				{
					$this->html_code .= "<a href=\"?".$getString."&page=$i\">$i</a>&nbsp;&nbsp;&nbsp;";
				}
			}
			if($this->tot_pages > 2)
			{
				for($i = 1; $i <= 2; $i++)
				{
					$this->html_code .= "<a href=\"?".$getString."&page=$i\">$i</a>&nbsp;&nbsp;&nbsp;";
				}
				$next = $i++;
				$this->html_code .= "<a href=\"?".$getString."&page=$next\">Next</a>&nbsp;&nbsp;&nbsp;";
			}
		}


		// If user clicks on Page number greater then 2 (i.e 3+)
		if($curr_page >= 3)
		{
			if($this->tot_pages == $curr_page)
			{
				$prev = $curr_page - 2;

				$firstPg = $curr_page-1;

				$this->html_code .= "<a href=\"?".$getString."&page=$prev\">Prev</a>&nbsp;&nbsp;&nbsp;";
				$this->html_code .= "<a href=\"?".$getString."&page=$firstPg\">$firstPg</a>&nbsp;&nbsp;&nbsp;";
				$this->html_code .= "<a href=\"?".$getString."&page=$curr_page\">$curr_page</a>&nbsp;&nbsp;&nbsp;";
			}
			if($this->tot_pages > $curr_page)
			{
				$prev = $curr_page - 2;

				$firstPg = $curr_page-1;

				$next = $curr_page + 1;

				$this->html_code .= "<a href=\"?".$getString."&page=$prev\">Prev</a>&nbsp;&nbsp;&nbsp;";
				$this->html_code .= "<a href=\"?".$getString."&page=$firstPg\">$firstPg</a>&nbsp;&nbsp;&nbsp;";
				$this->html_code .= "<a href=\"?".$getString."&page=$curr_page\">$curr_page</a>&nbsp;&nbsp;&nbsp;";
				$this->html_code .= "<a href=\"?".$getString."&page=$next\">Next</a>&nbsp;&nbsp;&nbsp;";
			}
		}
		$this->html_code .= "</td></tr></table>";
		return $this->html_code;
	}
	function getQueryString($excludeArr) {
	$queryStr = "";
	foreach($_GET as $ind=>$val) {
		if(!in_array($ind,$excludeArr)) {
		$queryStr .= $ind."=".$val."&";
		}
	}
	return substr($queryStr,0,-1);
	}
}
?>