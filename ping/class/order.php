<?php
 /**
 *  Project: Besttel
 *  Last Modified Date: 2016 July
 *  Developer: Cooltey Feng
 *  File: class/order.php
 *  Description: Order function for list page
 */
 
class Order{
		
		var $getOrderArray;
		var $currentOrderBy;
		var $currentOrderMode;
		var $pageNameVar;
		
		
		// get array
		// array("name" => array("title" => "名稱", "column" => "uae_name"));
		function Order($order_array, $order_by, $order_mode, $pagename){
			$order_by 	= strtolower(strip_tags($order_by));
			$order_mode = strip_tags(intval($order_mode));
			
			$this->currentOrderBy 		= $order_by;
			$this->currentOrderMode 	= $order_mode;
			$this->getOrderArray 		= $order_array;
			$this->pageNameVar  		= $pagename;
		}
		
		function getOrderMode(){
			$returnVal = "DESC";
			if($this->currentOrderMode == 1){
				$returnVal = "ASC";
			}else{
				$returnVal = "DESC";
			}
			
			return $returnVal;
		}
		
		function getOrderUrlLink($getKey){
			$returnVal = "";
			$newOrderMode = 0;
			if($getKey != "pager"){
				if($this->currentOrderMode == 0){
					$newOrderMode = 1;
				}
			}else{
				$newOrderMode = $this->currentOrderMode;
			}
			
			if(array_key_exists($getKey, $this->getOrderArray)){				
				$combineStr = "orderby=".$getKey;	
				$returnVal  = $combineStr;
			}else if(array_key_exists($this->currentOrderBy, $this->getOrderArray)){
				$combineStr = "orderby=".$this->currentOrderBy."&ordermode=".$newOrderMode;	
				$returnVal  = $combineStr;
			}
			
			return $returnVal;
		}
		
		function getOrderWhereStr(){
			$returnVal = "";
			
			if(array_key_exists($this->currentOrderBy, $this->getOrderArray)){			
				$getColumnName = $this->getOrderArray[$this->currentOrderBy]['column'];
				$combineStr = "ORDER BY ".$getColumnName." ".$this->getOrderMode()." ";	
				$returnVal  = $combineStr;
			}else{
				$getColumnName = $this->getOrderArray['id']['column'];
				$combineStr = "ORDER BY `".$getColumnName."` ".$this->getOrderMode()." ";	
				$returnVal  = $combineStr;
			}			
			
			return $returnVal;
		}
		
		function getOrderTitle($getKey){
			$returnVal = "";
			
			if(array_key_exists($getKey, $this->getOrderArray)){			
				$getColumnTitle = $this->getOrderArray[$getKey]['title'];
				$getColumnName 	= $this->getOrderArray[$getKey]['column'];
				if($this->currentOrderMode == 1 && $this->currentOrderBy == $getKey){
					$combineStr = "<a href=\"".$this->pageNameVar."".$this->getOrderUrlLink("")."\"><span class=\"order_th_title\">".$getColumnTitle."</span><span class=\"glyphicon glyphicon-chevron-up\"></span></a>";	
				}else if($this->currentOrderMode == 0 && $this->currentOrderBy == $getKey){					
					$combineStr = "<a href=\"".$this->pageNameVar."".$this->getOrderUrlLink("")."\"><span class=\"order_th_title\">".$getColumnTitle."</span><span class=\"glyphicon glyphicon-chevron-down\"></span></a>";	
				}else{
					$combineStr = "<a href=\"".$this->pageNameVar."".$this->getOrderUrlLink($getKey)."\"><span class=\"order_th_title\">".$getColumnTitle."</span></a>";	
				}
				$returnVal  = $combineStr;
			}else{
				$returnVal  = "沒東西".$getKey;
				
			}			
			
			return $returnVal;
		}

		function getOrderTitlePlain($getKey){
			$returnVal = "";
			
			if(array_key_exists($getKey, $this->getOrderArray)){			
				$getColumnTitle = $this->getOrderArray[$getKey]['title'];
				$getColumnName 	= $this->getOrderArray[$getKey]['column'];
				$returnVal  = $getColumnTitle;
			}else{
				$returnVal  = "沒東西".$getKey;
				
			}			
			
			return $returnVal;
		}
	
}