<?php
 /**
 *  Project: Besttel
 *  Last Modified Date: 2016 July
 *  Developer: Cooltey Feng
 *  File: class/page.php
 *  Description: Page control
 */

class Pager{
		var $pageVar 	= 0;
		var $manyVar 	= 10;
		var $startVar 	= 0;
		var $displayVar = 5;
		var $pageNameVar;
		var $totalVar;
		
		function __construct($page, $many, $display, $total, $pagename){
			$page 		= strip_tags(intval($page));
			$many 		= strip_tags(intval($many));
			$display 	= strip_tags(intval($display));
			$total 	= strip_tags(intval($total));
			
			if($page == "" || $page == "1" || $page <= "0"){
				$start = 0;
			}else{
				$start = ($page- 1)*$many;
			}
				
			$this->pageVar 		= $page;
			$this->manyVar 		= $many;
			$this->startVar 	= $start;
			$this->displayVar 	= $display;
			$this->totalVar		= $total;
			$this->pageNameVar  = $pagename;
		}
		
		function getPageControler(){
			 // pages
             $total 		= ceil($this->totalVar/$this->manyVar);
			 $now 			= $this->pageVar;
			 $displayNum 	= $this->displayVar;
			 $many			= $this->manyVar;
			 $current_page  = $this->pageNameVar;
			 echo "<ul class=\"pagination pull-right\">";
			 
			 if($now == "" || $now == "1" || $now <= "0"){
            	 $new_now = 1;
                 }else{
                    $new_now = $now;
                    $head_page = $new_now - 1;
                    $new_url = preg_replace("/page={$now}/", "", $org_url);
                 }
                 $head = 0;
                 $last = 0;
                 if(($now-$new_now) > $displayNum)
                 {
                    $head = $now - $displayNum;
                    $last = $total - $displayNum;
                 }
				  if($now > 1 && (($total-$last)+1) > $displayNum && $total > $displayNum){
						echo "<li><a href={$current_page}page=1>最前頁...</a></li>";
				  }
				 
				  $totalDisplay = false;
                  for($i=(1+$head); $i<(($total-$last)+1); $i++)
                  {
                    if(!(($i - $new_now) > $displayNum || ($new_now - $i) > $displayNum))
                    {
                        if($i == $new_now)
                        {
                          echo "<li class=\"active\"><span>{$i}<span class=\"sr-only\">(current)</span></span></li>";
                        }else{
                           echo "<li><a href={$current_page}page={$i}>{$i}</a></li>";
						   if($i == $total || $i == ($total-1)){
							$totalDisplay = true;
						   }
                        }
                     }

                  }
				  if($now != $total && $total > $displayNum && $totalDisplay == false){
						echo "<li><a href={$current_page}page={$total}>...最終頁</a></li>";
				  }
			   echo "</ul>";

		}
		
		function getPageControlerForEvents(){
			 // pages
             $total 		= ceil($this->totalVar/$this->manyVar);
			 $now 			= $this->pageVar;
			 $displayNum 	= $this->displayVar;
			 $many			= $this->manyVar;
			 $current_page  = $this->pageNameVar;
			 echo "<ul class=\"pagination clearfix\">";
			 
			 if($now == "" || $now == "1" || $now <= "0"){
            	 $new_now = 1;
                 }else{
                    $new_now = $now;
                    $head_page = $new_now - 1;
                    $new_url = preg_replace("/page={$now}/", "", $org_url);
                 }
                 $head = 0;
                 $last = 0;
                 if(($now-$new_now) > $displayNum)
                 {
                    $head = $now - $displayNum;
                    $last = $total - $displayNum;
                 }

                  $prev_page = $now;
				  if($now > 1){
					 $prev_page = $now - 1;
				  }

				  echo "<li><a href=\"{$current_page}page={$prev_page}\" aria-label=\"Previous\"\"><span aria-hidden=\"true\">上一頁</span></a></li>";


				 
				  $totalDisplay = false;
                  for($i=(1+$head); $i<(($total-$last)+1); $i++)
                  {
                    if(!(($i - $new_now) > $displayNum || ($new_now - $i) > $displayNum))
                    {
                        if($i == $new_now)
                        {
                          echo "<li class=\"active\"><span>{$i}<span class=\"sr-only\">(current)</span></span></li>";
                        }else{
                           echo "<li><a href={$current_page}page={$i}>{$i}</a></li>";
						   if($i == $total || $i == ($total-1)){
							$totalDisplay = true;
						   }
                        }
                     }

                  }

				$next_page = $now;
			    if($now < $total){
				  	$next_page = $now + 1;
			    }

			    echo "<li><a href=\"{$current_page}page={$next_page}\" aria-label=\"Next\"\"><span aria-hidden=\"true\">下一頁</span></a></li>";

			   echo "</ul>";

		}

		function getPageControlerAjax(){
			 // pages
             $total 		= ceil($this->totalVar/$this->manyVar);
			 $now 			= $this->pageVar;
			 $displayNum 	= $this->displayVar;
			 $many			= $this->manyVar;
			 $current_page  = $this->pageNameVar;
			 echo "<ul class=\"pagination pull-right\">";
			 
			 if($now == "" || $now == "1" || $now <= "0"){
            	 $new_now = 1;
                 }else{
                    $new_now = $now;
                    $head_page = $new_now - 1;
                    $new_url = preg_replace("/page={$now}/", "", $org_url);
                 }
                 $head = 0;
                 $last = 0;
                 if(($now-$new_now) > $displayNum)
                 {
                    $head = $now - $displayNum;
                    $last = $total - $displayNum;
                 }
				  if($now > 1 && (($total-$last)+1) > $displayNum && $total > $displayNum){
						echo "<li><span onclick=\"gotoPage(1);\"\">最前頁...</span></li>";
				  }
				 
				  $totalDisplay = false;
                  for($i=(1+$head); $i<(($total-$last)+1); $i++)
                  {
                    if(!(($i - $new_now) > $displayNum || ($new_now - $i) > $displayNum))
                    {
                        if($i == $new_now)
                        {
                          echo "<li class=\"active\"><span>{$i}<span class=\"sr-only\">(current)</span></span></li>";
                        }else{
                           echo "<li><span onclick=\"gotoPage({$i});\">{$i}</span></li>";
						   if($i == $total || $i == ($total-1)){
							$totalDisplay = true;
						   }
                        }
                     }

                  }
				  if($now != $total && $total > $displayNum && $totalDisplay == false){
						echo "<li><span onclick=\"gotoPage({$total});\">...最終頁</span></li>";
				  }
			   echo "</ul>";

		}
	
}