<?php
 /**
 *  Project: Games
 *  Last Modified Date: 2017 Jan
 *  Developer: Cooltey Feng
 *  File: class/games.php
 *  Description: Games Class
 */

class Games{

	var $db;
	var $getLib;
	var $pageName;
	var $getCSRF;
	
	function Games($get_db, $get_lib, $page){				
		$this->getLib 			= $get_lib;
		$this->db				= $get_db;
		$this->pageName    	 	= $page.".php";

		include_once("csrf_protection.php");
		
		$this->getCSRF 			= new CSRFProtection($get_lib);
	}

	// set html title
	function setTitle($getData){

		$returnVal = "";

		$currentPage = $this->getLib->setFilter($getData['p']);
		$getPage 	 = $this->pageName;

		switch($currentPage){
			case "index":
				$returnVal = "首頁";
			break;

			case "gamelist":
				$returnVal = "遊戲列表";
				if($getData['type'] != ""){
					$getType = $this->getLib->setFilter($getData['type'], true);
					$returnVal = $returnVal." - ".$this->getAlias($getType);
				}
				if($getData['category'] != ""){
					$getCategory = $this->getLib->setFilter($getData['category'], true);
					$returnVal = $returnVal." - ".$getCategory;
				}
			break;

			case "read":				

				// get title
				$titleData = $this->getTitleData($getData['id']);

				// if(!isset($_GET['id']) || $_GET['id'] == "" || $titleData['name'] == "") {
				// 	echo $this->getLib->showAlertMsg("查無資料");
				// 	echo $this->getLib->getRedirect("./index.php");
				// 	exit;
				// }


				$returnVal = "遊戲介紹 - ".strip_tags($titleData['name']);
			break;

			case "search":				
				$returnVal = "搜尋遊戲";
			break;

			case "about":
				$returnVal = "關於站長";
			break;

			case "contact":
				$returnVal = "聯絡站長";
			break;

			default:
				$returnVal = "首頁";

			break;

		}	

		return $returnVal;
	}

	// get alias
	function getAlias($get_code){
		// basic category
		$aliasList = array("Android"		    => "Android 遊戲",
						  "iOS" 				=> "iOS 遊戲",
						  "Personal_Computer" 	=> "電腦遊戲",
						  "Member_publish" 		=> "網友分享",
						  "Emulator" 			=> "模擬器",
						  "Game_Boy" 			=> "GB 遊戲",
						  "Game_Boy_Advance" 	=> "GBA 遊戲",
						  "Super_Nintendo" 		=> "SFC 遊戲",
						  "Mobile" 				=> "手機遊戲"
		);

		return $aliasList[$get_code];
	}

	// split tags
	function getTags($tagsArray){
		if($tagsArray != ""){
			return explode(",", $tagsArray);
		}
	}

	// order status for gamelist
	function getOrderStatus($orderBy, $item){
		if($orderBy == $item || ($orderBy == "" && $item == "date")){
			echo " class=\"active\"";
		}
	}

	// breadcrumb for gamelist
	function showBreadCrumbForGameList($getType, $getCategory){

		$getType = $this->getLib->setFilter($getType);
		$getCategory = $this->getLib->setFilter($getCategory);

		if($getType == "" && $getCategory == ""){
			echo "<li class=\"active\"><a href=\"./gamelist.php\">遊戲列表</a></li>";
		}else{
			echo "<li><a href=\"./gamelist.php\">遊戲列表</a></li>";
		}

		if($getType != "" && $getCategory == ""){
			echo "<li class=\"active\"><a href=\"./gamelist.php?type=".$getType."\">".$this->getAlias($getType)."</a></li>";
		}

		if($getType == "" && $getCategory != ""){
			echo "<li class=\"active\"><a href=\"./gamelist.php?category=".$getCategory."\">".$getCategory."</a></li>";
		}

		if($getType != "" && $getCategory != ""){
			echo "<li><a href=\"./gamelist.php?type=".$getType."\">".$this->getAlias($getType)."</a></li>";
			echo "<li class=\"active\"><a href=\"./gamelist.php?type=".$getType."&category=".$getCategory."\">".$getCategory."</a></li>";
		}
	}

	// show category links
	function showCategoryLinks($getType, $getCategory){
		$getType = $this->getLib->setFilter($getType);
		$getCategory = $this->getLib->setFilter($getCategory);
		if($getType == ""){
			echo "category=".$getCategory;
		}else{
			echo "type=".$getType."&category=".$getCategory;
		}
	}

	// set view
	function setView($getData, $postData, $getSession){
		  
		$currentPage = $this->getLib->setFilter($getData['p']);
		$getPage 	 = $this->pageName;

		switch($currentPage){
			case "index":
				// check csrf
				// $this->getCSRF->checkToken($postData);
				// check csrf

				// get topic data
				$topicResult = $this->getIndexTopicItem();

				if($this->getLib->checkVal($topicResult)){
					if($topicResult['msg'] != "" && $topicResult['status'] != "success"){
						echo $this->getLib->showAlertMsg($topicResult['msg']);
					}
				}

				// get pc games
				$pcResult = $this->getIndexItem($topicResult['data']['id'], false);

				if($this->getLib->checkVal($pcResult)){
					if($pcResult['msg'] != "" && $pcResult['status'] != "success"){
						echo $this->getLib->showAlertMsg($pcResult['msg']);
					}
				}

				// get mobile games
				$mobileResult = $this->getIndexItem($topicResult['data']['id'], true);

				if($this->getLib->checkVal($mobileResult)){
					if($mobileResult['msg'] != "" && $mobileResult['status'] != "success"){
						echo $this->getLib->showAlertMsg($mobileResult['msg']);
					}
				}


				// set data
				$topicArticle 	= $topicResult['data'];
				$pcArticle 		= $pcResult['data'];
				$mobileArticle 	= $mobileResult['data'];

				// load page
				include_once("./parts/index_page.php");


			break;

			case "gamelist":
				// get pc games
				$listResult = $this->getGameList($getData, 14, $getData['type'], $getData['category'], $getData['orderby']);

				if($this->getLib->checkVal($listResult)){
					if($listResult['msg'] != "" && $listResult['status'] != "success"){
						echo $this->getLib->showAlertMsg($listResult['msg']);
						echo $this->getLib->getRedirect("./index.php");
						exit;
					}else{
						// get data
						$listData  		= $this->getLib->fetchArray($listResult['data']);
				 		$getPage     	= $listResult['pager'];
						$orderByUrl 	= $listResult['url'];

						// get categorylist
						$categoryListData   = $this->getCategoryList();
					}
				}

				// load page
				include_once("./parts/gamelist_page.php");

			break;

			case "read":
				// get title
				$getGameData = $this->getSpecData($getData['id']);

				if(!isset($getData['id']) || $getData['id'] == "" || $getGameData['name'] == "") {
					echo $this->getLib->showAlertMsg("查無資料");
					echo $this->getLib->getRedirect("./index.php");
					exit;
				}

				// add view counts
				$this->addViewCounts($getGameData['id']);

				// get random game
				$getRandomData = $this->getRandomGames($getGameData['id'], $getGameData['type'], $getGameData['category'], 6);

				// load page
				include_once("./parts/game_content_page.php");
			break;

			case "search":
				// get pc games
				$listResult = $this->getSearchGameList($getData, 14, $getData['keyword'], $getData['type'], $getData['category'], $getData['orderby']);

				if(!isset($getData['keyword']) || $getData['keyword'] == "") {
					echo $this->getLib->showAlertMsg("請輸入關鍵字搜尋");
					echo $this->getLib->getRedirect("./index.php");
					exit;
				}

				if($this->getLib->checkVal($listResult)){
					if($listResult['msg'] != "" && $listResult['status'] != "success"){
						echo $this->getLib->showAlertMsg($listResult['msg']);
						echo $this->getLib->getRedirect("./index.php");
						exit;
					}else{
						// get data
						$listData  		= $this->getLib->fetchArray($listResult['data']);
				 		$getPage     	= $listResult['pager'];
						$orderByUrl 	= $listResult['url'];
					}
				}

				// load page
				include_once("./parts/search_page.php");
			break;

			case "about":

				// load page
				include_once("./parts/about_page.php");
			break;

			case "contact":

				// load page
				include_once("./parts/contact_page.php");
			break;

		}	


	}

	function getCategoryList(){
		// basic category
		$gameCategory = array("Android"				=> array("data" => array(), "name" => "Android 遊戲", "sum" => 0),
							  "iOS" 				=> array("data" => array(), "name" => "iOS 遊戲", "sum" => 0),
							  "Personal_Computer" 	=> array("data" => array(), "name" => "電腦遊戲", "sum" => 0),
							  "Member_publish" 		=> array("data" => array(), "name" => "網友分享", "sum" => 0),
							  "Emulator" 			=> array("data" => array(), "name" => "模擬器", "sum" => 0),
							  "Game_Boy" 			=> array("data" => array(), "name" => "GB 遊戲", "sum" => 0),
							  "Game_Boy_Advance" 	=> array("data" => array(), "name" => "GBA 遊戲", "sum" => 0),
							  "Super_Nintendo" 		=> array("data" => array(), "name" => "SFC 遊戲", "sum" => 0),
						);

		// sum
		$sql = "SELECT `cate_type`, SUM(`cate_numbers`) AS `sum` 
				FROM `Game_category` 
				GROUP BY `cate_type`";
		$sth = $this->db->prepare($sql);
		$sth->bindValue(":status", $status);
		$sth->execute();
		$groupCategoryData = $this->getLib->fetchArray($sth);


		foreach($groupCategoryData AS $gData){
			$sql = "SELECT `cate_name`, `cate_numbers` 
					FROM `Game_category` 
					WHERE `cate_type` = :type
					AND `cate_name` != ''
					ORDER BY `cate_numbers` DESC";
			$sth = $this->db->prepare($sql);
			$sth->bindValue(":type", $gData['cate_type']);
			$sth->execute();

			// set data
			$gameCategory[$gData['cate_type']]['data'] 	= $this->getLib->fetchArray($sth);
			$gameCategory[$gData['cate_type']]['sum'] 	= $gData['sum'];

		}

		// print_r($gameCategory);

		return $gameCategory;

	}

	function getIndexTopicItem($where_str = null){
		
		$returnVal = array("status" => "", "msg" => array(), "data" => "");

		$msg_array = array();

		// get data from database
		try{
				$status = "yes";
				$sql = "SELECT `id`, `tags`, `uid`, `status`, `date`, `name`, `type`, `content`, `url`
								, `pic1`, `pic2`, `pic_extra`, `category`, `category_2`, `category_3`, `category_4`
								, `count`, `last` 
						FROM `Game_gamelist` 
						WHERE `status` = :status
						{$where_str}
						ORDER BY `last` DESC
						LIMIT 0, 1";
				$sth = $this->db->prepare($sql);
				$sth->bindValue(":status", $status);
				$sth->execute();
				$returnVal['status'] = "success";
				$returnVal['data']   = $this->getLib->fetchSQL($sth);
		}catch(Exception $e){
			$error_msg = "資料庫錯誤 ";
			array_push($msg_array, $error_msg);
		}
		
		if($returnVal['status'] != "success"){				
			$returnVal['status'] = "error";
		}
		
		$returnVal['msg'] = $msg_array;


		return $returnVal;
	}

	function getIndexItem($topicId, $is_mobile, $where_str = null){
		
		$returnVal = array("status" => "", "msg" => array(), "data" => "");

		$msg_array = array();

		if($is_mobile == true){
			$typeWhereStr = " AND (`type` = 'iOS' OR `type` = 'Android') ";
		}else{
			$typeWhereStr = " AND `type` = 'Personal_Computer' ";
		}

		// get data from database
		try{
				$status = "yes";
				$sql = "SELECT `id`, `tags`, `uid`, `status`, `date`, `name`, `type`, `content`, `url`
								, `pic1`, `pic2`, `pic_extra`, `category`, `category_2`, `category_3`, `category_4`
								, `count`, `last` 
						FROM `Game_gamelist` 
						WHERE `status` = :status
						AND `id` != :topic_id
						{$where_str}
						{$typeWhereStr}
						ORDER BY `last` DESC
						LIMIT 0, 5";
				$sth = $this->db->prepare($sql);
				$sth->bindValue(":topic_id", $topicId);
				$sth->bindValue(":status", $status);
				$sth->execute();

				$returnVal['status'] = "success";
				$returnVal['data']   = $this->getLib->fetchArray($sth);
		}catch(Exception $e){
			$error_msg = "資料庫錯誤 ";
			array_push($msg_array, $error_msg);
		}
		
		if($returnVal['status'] != "success"){				
			$returnVal['status'] = "error";
		}
		
		$returnVal['msg'] = $msg_array;


		return $returnVal;
	}


	function getGameList($getData, $getMany, $getType, $getCategory, $orderBy, $where_str = null){
		$returnVal = array("status" => "", "msg" => array(), "data" => "", "pager" => "", "order" => "", "url" => "");

		$msg_array = array();

		// initial page class
		if($getType != ""){
			$getType     		= $this->getLib->setFilter($getType, true);
			$getTypeWhereStr	= " AND `type` = :type ";
			if($getType == "Mobile"){
				$getTypeWhereStr	= " AND (`type` = 'Android' OR `type` = 'iOS')";
			}
			$getTypeUrl			= "type=".$getType."&";
		}

		if($getCategory != ""){
			$getCategory     		= $this->getLib->setFilter($getCategory, true);
			$getCategoryWhereStr	= " AND (`category` = :category OR `category_2` = :category OR `category_3` = :category OR `category_4` = :category )";
			$getCategoryUrl			= "category=".$getCategory."&";
		}

		if($orderBy != "" && ($orderBy == "name" || $orderBy == "count" || $orderBy == "date")){
			$orderBy    		= $this->getLib->setFilter($orderBy);
			$orderByWhereStr	= " ORDER BY `".$orderBy."` DESC";
			$orderByUrl			= "orderby=".$orderBy."&";
		}else{
			$orderBy			= "date";
			$orderByWhereStr	= " ORDER BY `".$orderBy."` DESC";
		}

		// call page class
		try{
				$status = "yes";
				$sql = "SELECT `id` FROM `Game_gamelist` 
						WHERE `status` = :status
						{$getTypeWhereStr} 
						{$getCategoryWhereStr} 
						{$where_str}
						{$orderByWhereStr}";
				$sth = $this->db->prepare($sql);
				$sth->bindValue(":status", $status);
				if($getType != "" && $getType != "Mobile"){
					$sth->bindValue(":type", $getType);
				}
				if($getCategory != ""){
					$sth->bindValue(":category", $getCategory);
				}
				$sth->execute();
				$count = $sth->rowCount();
				
				$page    	= $getData['page'];
				$many	 	= $getMany;
				$display 	= "3";
				$total	 	= $count;
				$pagename	= $this->pageName."?".$getTypeUrl.$getCategoryUrl.$orderByUrl;
				$getPage = new Pager($page, $many, $display, $total, $pagename);
				
		}catch(Exception $e){
			$error_msg = "資料庫錯誤 ";
			array_push($msg_array, $error_msg);
		}
		
		// get data from database
		try{
				$status = "yes";
				$start  = intval($getPage->startVar);
				$many   = intval($getPage->manyVar);
				$sql = "SELECT `id`, `uid`, `name`, `content`, `pic1`, `category`, `category_2`, `category_3`, `category_4`, `count`, `date`
						FROM `Game_gamelist` 
						WHERE `status` = :status
						{$getTypeWhereStr} 
						{$getCategoryWhereStr} 
						{$where_str}
						{$orderByWhereStr}
						LIMIT :start,:many";
				$sth = $this->db->prepare($sql);
				$sth->bindValue(":status", $status);
				if($getType != "" && $getType != "Mobile"){
					$sth->bindValue(":type", $getType);
				}
				if($getCategory != ""){
					$sth->bindValue(":category", $getCategory);
				}
				$sth->bindValue(":start", $start, PDO::PARAM_INT);
				$sth->bindValue(":many", $many, PDO::PARAM_INT);
				$sth->execute();
				$returnVal['status'] = "success";
				$returnVal['data']   = $sth;
				$returnVal['pager']  = $getPage;
				$returnVal['order']  = $getOrder;
				$returnVal['url']	 = $getTypeUrl.$getCategoryUrl;
		}catch(Exception $e){
			$error_msg = "資料庫錯誤 ";
			array_push($msg_array, $error_msg);
		}
		
		if($returnVal['status'] != "success"){				
			$returnVal['status'] = "error";
		}
		
		$returnVal['msg'] = $msg_array;


		return $returnVal;
	}

	function getSearchGameList($getData, $getMany, $getKeyword, $getType, $getCategory, $orderBy, $where_str = null){
		$returnVal = array("status" => "", "msg" => array(), "data" => "", "pager" => "", "order" => "", "url" => "");

		$msg_array = array();

		// initial page class
		if($getKeyword != ""){
			$getKeyword  			= $this->getLib->setFilter($getKeyword, true);
			$getKeywordWhereStr		= " AND `name` LIKE '%".$getKeyword."%' ";
			$getKeywordUrl			= "keyword=".$getKeyword."&";
		}else{
			$error_msg = "請輸入關鍵字";
			array_push($msg_array, $error_msg);
		}

		if($getType != ""){
			$getType     		= $this->getLib->setFilter($getType, true);
			$getTypeWhereStr	= " AND `type` = :type ";
			$getTypeUrl			= "type=".$getType."&";
		}

		if($getCategory != ""){
			$getCategory     		= $this->getLib->setFilter($getCategory, true);
			$getCategoryWhereStr	= " AND (`category` = :category OR `category_2` = :category OR `category_3` = :category OR `category_4` = :category )";
			$getCategoryUrl			= "category=".$getCategory."&";
		}

		if($orderBy != "" && ($orderBy == "name" || $orderBy == "count" || $orderBy == "date")){
			$orderBy    		= $this->getLib->setFilter($orderBy);
			$orderByWhereStr	= " ORDER BY `".$orderBy."` DESC";
			$orderByUrl			= "orderby=".$orderBy."&";
		}else{
			$orderBy			= "date";
			$orderByWhereStr	= " ORDER BY `".$orderBy."` DESC";
		}

		// call page class
		try{
				$status = "yes";
				$sql = "SELECT `id` FROM `Game_gamelist` 
						WHERE `status` = :status
						{$getTypeWhereStr} 
						{$getCategoryWhereStr} 
						{$getKeywordWhereStr} 
						{$where_str}
						{$orderByWhereStr}";
				$sth = $this->db->prepare($sql);
				$sth->bindValue(":status", $status);
				if($getType != ""){
					$sth->bindValue(":type", $getType);
				}
				if($getCategory != ""){
					$sth->bindValue(":category", $getCategory);
				}
				$sth->execute();
				$count = $sth->rowCount();
				
				$page    	= $getData['page'];
				$many	 	= $getMany;
				$display 	= "3";
				$total	 	= $count;
				$pagename	= $this->pageName."?".$getTypeUrl.$getCategoryUrl.$orderByUrl.$getKeywordUrl;
				$getPage = new Pager($page, $many, $display, $total, $pagename);
				
		}catch(Exception $e){
			$error_msg = "資料庫錯誤 ";
			array_push($msg_array, $error_msg);
		}
		
		// get data from database
		try{
				$status = "yes";
				$start  = intval($getPage->startVar);
				$many   = intval($getPage->manyVar);
				$sql = "SELECT `id`, `uid`, `name`, `content`, `pic1`, `category`, `category_2`, `category_3`, `category_4`, `count`, `date`
						FROM `Game_gamelist` 
						WHERE `status` = :status
						{$getTypeWhereStr} 
						{$getCategoryWhereStr} 
						{$getKeywordWhereStr} 
						{$where_str}
						{$orderByWhereStr}
						LIMIT :start,:many";
				$sth = $this->db->prepare($sql);
				$sth->bindValue(":status", $status);
				if($getType != ""){
					$sth->bindValue(":type", $getType);
				}
				if($getCategory != ""){
					$sth->bindValue(":category", $getCategory);
				}
				$sth->bindValue(":start", $start, PDO::PARAM_INT);
				$sth->bindValue(":many", $many, PDO::PARAM_INT);
				$sth->execute();

				$returnVal['status'] = "success";
				$returnVal['data']   = $sth;
				$returnVal['pager']  = $getPage;
				$returnVal['order']  = $getOrder;
				$returnVal['url']	 = $getTypeUrl.$getCategoryUrl.$getKeywordUrl;
		}catch(Exception $e){
			$error_msg = "資料庫錯誤 ";
			array_push($msg_array, $error_msg);
		}
		
		if($returnVal['status'] != "success"){				
			$returnVal['status'] = "error";
		}
		
		$returnVal['msg'] = $msg_array;


		return $returnVal;
	}

	function getTitleData($id){

		$getId = $this->getLib->setFilter($id);

		$status = "yes";
		$sql 	= "SELECT `name`, `pic1`, `content` FROM `Game_gamelist` 
					WHERE `status` = :status 
					AND `id` = :get_id";
		$sth	= $this->db->prepare($sql);
		$sth->bindValue(":status", $status);
		$sth->bindValue(":get_id", $getId);

		$sth->execute();	
		
		return $this->getLib->fetchSQL($sth);
	}

	function getSpecData($id){

		$getId = $this->getLib->setFilter($id);

		$status = "yes";
		$sql 	= "SELECT * FROM `Game_gamelist` 
					WHERE `status` = :status 
					AND `id` = :get_id";
		$sth	= $this->db->prepare($sql);
		$sth->bindValue(":status", $status);
		$sth->bindValue(":get_id", $getId);

		$sth->execute();	
		
		return $this->getLib->fetchSQL($sth);
	}

	function getRandomGames($id, $type, $category, $many){


		$getId = $this->getLib->setFilter($id);

		$status = "yes";
		$sql 	= "SELECT `id`, `name` FROM `Game_gamelist` 
					WHERE `status` = :status 
					AND `id` != :get_id
					AND `type` = :get_type
					AND `category` = :get_category
					ORDER BY RAND()
					LIMIT 0, :many";
		$sth	= $this->db->prepare($sql);
		$sth->bindValue(":status", $status);
		$sth->bindValue(":get_id", $getId);
		$sth->bindValue(":get_type", $type);
		$sth->bindValue(":get_category", $category);
		$sth->bindValue(":many", $many, PDO::PARAM_INT);

		$sth->execute();	
		
		return $this->getLib->fetchArray($sth);
	}

	function addViewCounts($id){

		$getId = $this->getLib->setFilter($id);
		$status = "yes";
		$sql 	= "UPDATE `Game_gamelist` SET `count` = `count` + 1
					WHERE `status` = :status 
					AND `id` = :get_id";
		$sth	= $this->db->prepare($sql);
		$sth->bindValue(":status", $status);
		$sth->bindValue(":get_id", $getId);

		$sth->execute();	
	}


}