<?php
 /**
 *  Project: Besttel
 *  Last Modified Date: 2016 July
 *  Developer: Cooltey Feng
 *  File: class/members.php
 *  Description: Members Class
 */

class Members{

	var $db;
	var $getLib;
	var $pageName;
	var $getCSRF;
	
	function __construct($get_db, $get_lib, $page){
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
			case "login":
				$returnVal = "會員登入";
			break;

			case "register":
				$returnVal = "加入會員";
			break;

			case "register_success":
				$returnVal = "註冊成功";
			break;

			case "resend_cfm":
				$returnVal = "重新寄送認證信";
			break;

			case "register_cfm":
				$returnVal = "會員認證";
			break;

			case "forgetpwd":
				$returnVal = "忘記密碼";
			break;

			case "forgetpwd_sent":
				$returnVal = "寄送密碼重置信";
			break;

			case "resetpwd":
				$returnVal = "重置密碼";
			break;

			case "resetpwd_success":
				$returnVal = "重置密碼成功";
			break;

			case "index";
				$returnVal = "會員大廳";
			break;

			case "update_info";
				$returnVal = "修改個人資料";
			break;

			case "member_my_games";
				$returnVal = "我的遊戲列表";
			break;

			case "member_my_fav_games";
				$returnVal = "我的收藏列表";
			break;

			case "edit_game";
				$returnVal = "編輯遊戲";
			break;

			case "home":

				$getTmpSession['uid'] = $this->getLib->setFilter($getData['uid']);

				$getResult = $this->memberIndexPage($getTmpSession);

				if($this->getLib->checkVal($getResult)){

					if($getResult['status'] != "success"){
						echo $this->getLib->showAlertMsg("查無資料");
						echo $this->getLib->getRedirect("./index.php");
						exit;
					}else{
						$getMemberData = $getResult['data'];
					}

				}

				$returnVal = $getMemberData['uid']."的個人首頁";
			break;
		}	

		return $returnVal;
	}

	function genPassword($val){
		$newVal = md5("cooltey".$val."best");
		
		return $newVal;
	}

	function getRandomString($length = 6) {
		$validCharacters = "abcdefghijklmnopqrstuxyvwzABCDEFGHIJKLMNOPQRSTUXYVWZ123456789";
		$validCharNumber = strlen($validCharacters);
	 
		$result = "";
	 
		for ($i = 0; $i < $length; $i++) {
			$index = mt_rand(0, $validCharNumber - 1);
			$result .= $validCharacters[$index];
		}
	 
		return $result;
	}

	function expCalculator($uexp){	
		$default_exp = 100;	
	
		for($i = 1; $i < 999; $i++)
		{	
	
			$level[$i] = ($default_exp*$i + $total_exp);
			
			$total_exp = $level[$i];
	
			if($uexp - $level[$i] < 0)
			{
				$current_level = $i;
				$exp_reach = $level[$i];
				$exp_percentage = ($uexp - $level[$i-1])/($level[$i] - $level[$i-1])*100;
				$exp_length = "<hr width=".$exp_percentage."% size=5 style='border-style: solid; border-width: 1px; background-color: #006699' align='left'>";
				break;
			}
		}
		
		return array("current" => $current_level, "reach" => $exp_reach, "percentage" => $exp_percentage, "length" => $exp_length);
	}

	function genderFilter($get_gender){
		if($get_gender == "0"){
			return "女生";
		}else{
			return "男生";
		}
	}

	function checkboxChecker($get_val){
		if($get_val == "1"){
			echo " checked";
		}
	}

	// set view
	function setView($getData, $postData, $getSession){
		  
		$currentPage = $this->getLib->setFilter($getData['p']);
		$getPage 	 = $this->pageName;

		switch($currentPage){
			case "login":
				if(isset($_SESSION['member_login']) && $_SESSION['member_login'] == "yes"){
					echo $this->getLib->getRedirect("./index.php");
				}

				//check csrf
				$this->getCSRF->checkToken($postData);
				//check csrf

				// get topic data
				$loginResult = $this->memberLogin($postData, $getData['act']);

				if($this->getLib->checkVal($loginResult)){

					if($loginResult['msg'] != ""){
						echo $this->getLib->showAlertMsg($loginResult['msg']);
					}

					if($loginResult['status'] == "success"){
				      // unset($getData);
				      echo $this->getLib->getRedirect("./index.php?l=".date("YmdHisB"));
				    }
			  	}else{
			    	session_destroy();
			  	}

				// load page
				include_once("./parts/member_login_page.php");


			break;

			case "register":

				// check csrf
				$this->getCSRF->checkToken($postData);
				// check csrf

				// get result
				$getResult = $this->registerMember($postData, $getData['act']);

				if($this->getLib->checkVal($getResult)){
					if($getResult['msg'] != ""){
						echo $this->getLib->showAlertMsg($getResult['msg']);
					}

					if($getResult['status'] == "success"){
						unset($postData);
						echo $this->getLib->getRedirect("./member_register_success.php");
						exit;
					}

				}

				// load page
				include_once("./parts/member_register_page.php");
			break;


			case "register_success":
				// load page
				include_once("./parts/member_register_success_page.php");
			break;

			case "resend_cfm":

				$getResult = $this->resendRegisterCfm($getSession, $getData['act']);
				if($this->getLib->checkVal($getResult)){
					if($getResult['msg'] != ""){
						echo $this->getLib->showAlertMsg($getResult['msg']);
					}

					if($getResult['status'] == "success"){
						unset($postData);
						echo $this->getLib->getRedirect("./index.php");
						exit;
					}

				}
				// load page
				include_once("./parts/member_resend_cfm_page.php");
			break;

			case "register_cfm":

				$resultMsg = $this->registerMemberCfm($getData);

				// load page
				include_once("./parts/member_register_cfm_page.php");
			break;

			case "forgetpwd":
				// check csrf
				$this->getCSRF->checkToken($postData);
				// check csrf

				// get result
				$getResult = $this->forgetPwd($postData, $getData['act']);

				if($this->getLib->checkVal($getResult)){
					if($getResult['msg'] != ""){
						echo $this->getLib->showAlertMsg($getResult['msg']);
					}

					if($getResult['status'] == "success"){
						unset($postData);
						echo $this->getLib->getRedirect("./member_forgetpwd_sent.php");
						exit;
					}

				}

				// load page
				include_once("./parts/member_forgetpwd_page.php");
			break;


			case "forgetpwd_sent":
				// load page
				include_once("./parts/member_forgetpwd_sent_page.php");
			break;

			case "resetpwd":

				// check csrf
				$this->getCSRF->checkToken($postData);
				// check csrf

				// get result
				$getResult = $this->resetPwd($postData, $getData['act']);

				if($this->getLib->checkVal($getResult)){
					if($getResult['msg'] != ""){
						echo $this->getLib->showAlertMsg($getResult['msg']);
					}

					if($getResult['status'] == "success"){
						unset($postData);
						echo $this->getLib->getRedirect("./member_resetpwd_success.php");
						exit;
					}

				}

				// load page
				include_once("./parts/member_resetpwd_page.php");
			break;


			case "resetpwd_success":
				// load page
				include_once("./parts/member_resetpwd_success_page.php");
			break;

			case "index":

				$getResult = $this->memberIndexPage($getSession);

				if($this->getLib->checkVal($getResult)){

					if($getResult['status'] != "success"){
						if($getResult['msg'] != ""){
							echo $this->getLib->showAlertMsg($getResult['msg']);
						}
						session_destroy();
						echo $this->getLib->getRedirect("./index.php");
						exit;
					}else{
						$getMemberData = $getResult['data'];
						$getExpData    = $this->expCalculator($getMemberData['uexp']);
					}

				}

				// index page
				include_once("./parts/member_index_page.php");
			break;

			case "update_info":

				$getResult = $this->memberIndexPage($getSession);

				if($this->getLib->checkVal($getResult)){

					if($getResult['status'] != "success"){
						if($getResult['msg'] != ""){
							echo $this->getLib->showAlertMsg($getResult['msg']);
						}
						session_destroy();
						echo $this->getLib->getRedirect("./index.php");
						exit;
					}else{
						$getMemberData = $getResult['data'];
					}

				}

				$getUpdateResult = $this->updateMyInfo($getSession, $postData, $getData['act']);

				if($this->getLib->checkVal($getUpdateResult)){

					if($getUpdateResult['msg'] != ""){
						echo $this->getLib->showAlertMsg($getUpdateResult['msg']);
					}

					if($getUpdateResult['status'] == "success"){
						unset($postData);
						echo $this->getLib->getRedirect("./member_update_info.php");
						exit;
					}

				}

				// index page
				include_once("./parts/member_update_info_page.php");
			break;

			case "member_my_games":

				$listResult = $this->getMyGameList($getSession, $getData, 15, "", "", "date");

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

				// index page
				include_once("./parts/member_my_games_page.php");
			break;

			case "member_my_fav_games":

				$listResult = $this->getMyFavGameList($getSession, $getData, 15, "", "", "gf_create_time");

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

				// index page
				include_once("./parts/member_my_fav_games_page.php");
			break;

			case "edit_game";
				// update game
				$getUpdateResult = $this->updateMyGame($getSession, $postData, $getData['act']);
				if($this->getLib->checkVal($getUpdateResult)){

					if($getUpdateResult['msg'] != ""){
						echo $this->getLib->showAlertMsg($getUpdateResult['msg']);
					}

					if($getUpdateResult['status'] == "success"){
						unset($postData);
						echo $this->getLib->getRedirect("./member_edit_game.php?id=".$getData['id']);
						exit;
					}

				}

				$getGameData = $this->getMyGameData($getSession, $getData['id']);

				
				if(!isset($getData['id']) || $getData['id'] == "" || $getGameData['name'] == "") {
					echo $this->getLib->showAlertMsg("查無資料");
					echo $this->getLib->getRedirect("./index.php");
					exit;
				}

				if($getGameData['uid'] != $getGameData['uid']){
					echo $this->getLib->showAlertMsg("權限錯誤");
					echo $this->getLib->getRedirect("./index.php");
					exit;
				}

				// get tags
				$getMyGameTags = $this->getTags($getGameData['tags']);

				// get category
				$getAllGameCategory = $this->getGamesCategory();


				// index page
				include_once("./parts/member_edit_game_page.php");
			break;



			case "home":

				$getTmpSession = array();
				$getTmpSession['uid'] = $this->getLib->setFilter($getData['uid']);

				$getResult = $this->memberIndexPage($getTmpSession);

				if($this->getLib->checkVal($getResult)){

					if($getResult['status'] != "success"){
						echo $this->getLib->showAlertMsg("查無資料");
						echo $this->getLib->getRedirect("./index.php");
						exit;
					}else{
						$getMemberData = $getResult['data'];
						$getExpData    = $this->expCalculator($getMemberData['uexp']);
					}

				}

				$listResult = $this->getMyFavGameList($getTmpSession, $getData, 200, "", "", "gf_create_time");

				if($this->getLib->checkVal($listResult)){
					if($listResult['msg'] != "" && $listResult['status'] != "success"){
						echo $this->getLib->showAlertMsg("查無資料");
						echo $this->getLib->getRedirect("./index.php");
						exit;
					}else{
						// get data
						$listData  		= $this->getLib->fetchArray($listResult['data']);
				 		$getPage     	= $listResult['pager'];
						$orderByUrl 	= $listResult['url'];
					}
				}

				// add count
				$this->addVisitCounts($getMemberData['uid']);


				// load page
				include_once("./parts/home_page.php");
			break;
		}	


	}

	// split tags
	function getTags($tagsArray){
		if($tagsArray != ""){
			return explode(",", $tagsArray);
		}
	}

	function getGamesCategory(){
		$type = "Personal_Computer";
		$sql 	= "SELECT `cate_name` FROM `Game_category` 
					WHERE `cate_type` = :type
					AND `cate_name` != ''";
		$sth	= $this->db->prepare($sql);
		$sth->bindValue(":type", $type);

		$sth->execute();	
		
		return $this->getLib->fetchArray($sth);
	}

	// register
	function registerMember($getData, $getAct){
		$returnVal = array("status" => "", "msg" => "");
		if(filter_has_var(INPUT_GET, "act") && $getAct == "submit"){

			$msg_array 					= array();
			$member_username 			= $this->getLib->setFilter($getData['member_username']);
			$member_password 			= $this->getLib->setFilter($getData['member_password']);
			$member_password_cfm 		= $this->getLib->setFilter($getData['member_password_cfm']);
			$member_email 				= $this->getLib->setFilter($getData['member_email']);
			$member_email_privacy 		= intval($this->getLib->setFilter($getData['member_email_privacy']));
			$member_gender 				= intval($this->getLib->setFilter($getData['member_gender']));
			$member_gender_privacy 		= intval($this->getLib->setFilter($getData['member_gender_privacy']));
			$member_birth_day			= intval($this->getLib->setFilter($getData['member_birth_day']));
			$member_birth_month			= intval($this->getLib->setFilter($getData['member_birth_month']));
			$member_birth_year			= intval($this->getLib->setFilter($getData['member_birth_year']));
			$member_birthday_privacy 	= intval($this->getLib->setFilter($getData['member_birthday_privacy']));
			$member_statment_agree		= intval($this->getLib->setFilter($getData['member_statment_agree']));
			$member_register_date 		= date("Y-m-d H:i:s");
			$member_register_ip 		= $this->getLib->getIp();
			$member_activate_code		= md5($member_username.microtime());

			// check password
			if(!filter_has_var(INPUT_POST, "member_username") || !$this->getLib->checkVal($member_username)){
				$error_msg = "請輸入帳號";
				array_push($msg_array, $error_msg);
			}
			
			if(!filter_has_var(INPUT_POST, "member_password") || !$this->getLib->checkVal($member_password)){
				$error_msg = "請輸入密碼";
				array_push($msg_array, $error_msg);
			}

			if(!filter_var($member_email, FILTER_VALIDATE_EMAIL)){
				$error_msg = "E-mail 格式錯誤";
				array_push($msg_array, $error_msg);
			}else{	
				// check username
				$status  = "on";
				$sql 	 = "SELECT `uemail` FROM `Member_data` WHERE `uemail` = :get AND `uactivate` = :status";
				$sth 	 = $this->db->prepare($sql);
				$sth->bindValue(":get", $m_email);
				$sth->bindValue(":status", $status);
				$sth->execute();
				
				$rData = $this->getLib->fetchSQL($sth);
				
				if(is_array($rData)){
					$error_msg = "E-mail 重複申請。";
					array_push($msg_array, $error_msg);		
				}
			}
			
			if(strlen($member_username) < 2){	
				$error_msg = "帳號長度太短，請重新輸入(須大於二個字元)";
				array_push($msg_array, $error_msg);
			}else{	
				// check username
				$sql 	 = "SELECT `uid` FROM `Member_data` WHERE `uid` = :get";
				$sth 	 = $this->db->prepare($sql);
				$sth->bindValue(":get", $member_username);
				$sth->execute();
				
				$rData = $this->getLib->fetchSQL($sth);
				
				if(is_array($rData)){
					$error_msg = "帳號重複申請。";
					array_push($msg_array, $error_msg);		
				}
			}

			// check password

			
			if(strlen($member_password) < 4){	
				$error_msg = "密碼長度太短，請重新輸入(須大於四個字元)";
				array_push($msg_array, $error_msg);
			}else{
				if($member_password != $member_password_cfm){
					$error_msg = "密碼不符";
					array_push($msg_array, $error_msg);

				}
			}

			if($member_statment_agree != "1"){
				$error_msg = "請同意會員條款！";
				array_push($msg_array, $error_msg);		
			}

			// encrypt password
			$mypwd = $member_password;
			$member_password = $this->genPassword($member_password);

			// gender
			if($member_gender == "1"){
				$member_gender = "male";
			}else{
				$member_gender = "female";
			}
			
			// 進行資料庫存取
			if(count($msg_array) == 0){
				try{
					
					$sql = "INSERT INTO `Member_data`(`uid`, 
												`upd`, 
												`uemail`, 
												`uemail_status`, 
												`ugender`, 
												`ugender_status`, 
												`ubyear`, 
												`ubmonth`, 
												`ubday`, 
												`ubirthday_status`, 
												`ureg_date`, 
												`uip`, 
												`uactivate`) 
					VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
					$sth = $this->db->prepare($sql);
					$execute_array = array($member_username, 
											$member_password, 
											$member_email, 
											$member_email_privacy, 
											$member_gender, 
											$member_gender_privacy, 
											$member_birth_year, 
											$member_birth_month, 
											$member_birth_day, 
											$member_birthday_privacy, 
											$member_register_date, 
											$member_register_ip, 
											$member_activate_code);
					$sth->execute($execute_array);
					
					$success_msg = "註冊成功！";
					$returnVal['status'] = "success";					
					array_push($msg_array, $success_msg);


					// send email
					$email_content = "
			
					-------------------------注意，這是系統信件，請勿直接回覆本信---------------------------
					
					您好 ".$member_username."：
			
						您的帳號：".$member_username."
			
						帳號密碼：".$mypwd."
			
						恭喜您成為平水相逢的一份子，但是在成為正式會員之前，要先通過站長的一個考驗.....
			
						「那就是站長要確定你是不是真心真意想要成為會員」的考驗！
			
						請點擊下列啟動帳號網址，以確定你是真的想要成為平水相逢的會員。
			
						http://{$_SERVER['HTTP_HOST']}/ping/member_register_cfm.php?act=confirm&uid=".$member_username."&act_code=".$member_activate_code."
			
					
						祝你有個美好的一天
			
						平水相逢 http://{$_SERVER['HTTP_HOST']}";
			
					$email_headers .= 'From: Cooltey.org <no-reply@cooltey.org>' . "\r\n";

					mail($member_email,"平水相逢網站會員認證信", $email_content, $email_headers);

				}catch(Exception $e){
					$error_msg = "資料庫錯誤 ";
					array_push($msg_array, $error_msg);
				}
				
			}
			
			
			$returnVal['msg'] = $msg_array;
		}
		
		return $returnVal;
	}

	function resendRegisterCfm($getSession, $getAct){

		$returnVal = array("status" => "", "msg" => "");
		$msg_array = array();

		if(filter_has_var(INPUT_GET, "act") && $getAct == "send"){
			// resend
			$email_content = "

			-------------------------注意，這是系統信件，請勿直接回覆本信---------------------------
			
			您好 ".$getSession['uid']."：

				恭喜您成為平水相逢的一份子，但是在成為正式會員之前，要先通過站長的一個考驗.....

				「那就是站長要確定你是不是真心真意想要成為會員」的考驗！

				請點擊下列啟動帳號網址，以確定你是真的想要成為平水相逢的會員。

				http://{$_SERVER['HTTP_HOST']}/ping/member_register_cfm.php?act=confirm&uid=".$getSession['uid']."&act_code=".$getSession['activate_code']."

			
				祝你有個美好的一天

				平水相逢 http://{$_SERVER['HTTP_HOST']}";

			$email_headers .= 'From: Cooltey.org <no-reply@cooltey.org>' . "\r\n";

			mail($getSession['email'],"平水相逢網站會員認證信", $email_content, $email_headers);

			$returnVal['status'] = "success";

			$msg = "認證信已寄出！";
			array_push($msg_array, $msg);

			$returnVal['msg'] = $msg_array;
		}
			
		
		return $returnVal;
	}

	function registerMemberCfm($getData){
		if(isset($getData)){
			$member_username 		= $this->getLib->setFilter($getData['uid']);
			$member_activate_code 	= $this->getLib->setFilter($getData['act_code']);

			// check username
			$sql 	 = "SELECT `uid`, `uactivate` FROM `Member_data` WHERE `uid` = :get";
			$sth 	 = $this->db->prepare($sql);
			$sth->bindValue(":get", $member_username);
			$sth->execute();
			
			$rData = $this->getLib->fetchSQL($sth);
			if($rData['uid'] != ""){
				if($rData['uactivate'] === $member_activate_code){

					$_SESSION['member_activate'] 	= "on";

					$uactivate = "on";

					// update exp times
					$sql = "UPDATE `Member_data` 
							SET `uactivate` = ?
							WHERE `uid` = ?";
					$execute_array = array($uactivate, $member_username);

					$sth = $this->db->prepare($sql);
					$sth->execute($execute_array);

					return "你的帳號已經順利啟動囉！！歡迎您成為平水相逢的一份子";
				}else if($rData['uactivate'] == "on"){
					return "您的帳號已經啟動過囉。";
				}else{
					return "您的啟動碼有誤，請再次檢查您的連結是否正確。";
				}
			}else{
				return "帳號不存在！";
			}
		}else{
			return "未知的錯誤";
		}
	}

	function forgetPwd($getData, $getAct){
		$returnVal = array("status" => "", "msg" => "");
		if(filter_has_var(INPUT_GET, "act") && $getAct == "submit"){

			$msg_array 			= array();
			$member_username 	= $this->getLib->setFilter($getData['member_username']);
			$member_email 		= $this->getLib->setFilter($getData['member_email']);

			// check password
			if(!filter_has_var(INPUT_POST, "member_username") || !$this->getLib->checkVal($member_username)){
				$error_msg = "請輸入帳號";
				array_push($msg_array, $error_msg);
			}
			
			if(!filter_var($member_email, FILTER_VALIDATE_EMAIL)){
				$error_msg = "E-mail 格式錯誤";
				array_push($msg_array, $error_msg);
			}
			
			// 進行資料庫存取
			if(count($msg_array) == 0){
				try{
					
					$sql = "SELECT `uid`, `upd`, `uemail` FROM `Member_data` WHERE `uid` = :username LIMIT 0, 1";
					$sth = $this->db->prepare($sql);
					$sth->bindValue(":username", $member_username);
					$sth->execute();

					$getAccountData = $this->getLib->fetchArray($sth);
					// check account
					$check_count = 0;
					foreach($getAccountData AS $rData){
						if($rData['uid'] == $member_username){
							if($rData['uemail'] == $member_email){			
								

								// gen a tmp password
								$tmp_pwd_clear = $this->getRandomString(6);
								$tmp_pwd = $this->genPassword($tmp_pwd_clear);

								$sql = "UPDATE `Member_data` 
										SET `upd_tmp` = ?
										WHERE `uid` = ?";
								$execute_array = array($tmp_pwd, 
														$member_username);

								$sth = $this->db->prepare($sql);
								$sth->execute($execute_array);
											

								$returnVal['status'] = "success";
								$success_msg = "驗證成功！";
								array_push($msg_array, $success_msg);

								// send mail

								$email_content = "
					
								-------------------------注意，這是系統信件，請勿直接回覆本信---------------------------
							
								您好 ".$rData['uid']."：
					
								怎麼這麼糊塗忘記密碼了呢？沒關係，站長原諒你！
					
								這是您暫時登入的密碼，利用此密碼登入後請重新修改密碼，謝謝。
								
								您的帳號：".$rData['uid']."
								暫時密碼：".$tmp_pwd_clear."
																
								請利用此連結登入：http://{$_SERVER['HTTP_HOST']}/ping/member_resetpwd.php?uid=".$rData['uid']."
																
								若連結無效，就請將上列網址複製到網址列，謝謝。
					
							
								祝你有個美好的一天
					
								平水相逢 http://{$_SERVER['HTTP_HOST']}";
					
								$email_headers .= 'From: Cooltey.org <no-reply@cooltey.org>' . "\r\n";
						
								mail($member_email,"平水相逢會員密碼快遞信", $email_content, $email_headers);

							}else{
								

								$error_msg = "驗證失敗，請確認您的資料是否正確";
								array_push($msg_array, $error_msg);
							}
							$check_count++;
						}
					}
					
					if($check_count == 0){
						$error_msg = "驗證失敗，請確認您的資料是否正確";
						array_push($msg_array, $error_msg);			
					}
				}catch(Exception $e){
					$error_msg = "資料庫錯誤 ";
					array_push($msg_array, $error_msg);
				}
				
			}
			
			
			$returnVal['msg'] = $msg_array;
		}
		
		return $returnVal;
	}


	function resetPwd($getData, $getAct){
		$returnVal = array("status" => "", "msg" => "");
		if(filter_has_var(INPUT_GET, "act") && $getAct == "submit"){

			$msg_array 			= array();
			$member_username 	= $this->getLib->setFilter($getData['member_username']);
			$tmp_pwd 			= $this->getLib->setFilter($getData['tmp_pwd']);
			$new_pwd 			= $this->getLib->setFilter($getData['new_pwd']);
			$new_pwd_cfm 		= $this->getLib->setFilter($getData['new_pwd_cfm']);

			// check password
			if(!filter_has_var(INPUT_POST, "member_username") || !$this->getLib->checkVal($member_username)){
				$error_msg = "請輸入帳號";
				array_push($msg_array, $error_msg);
			}else{
				$sql 	 = "SELECT `upd_tmp` FROM `Member_data` WHERE `uid` = :get";
				$sth 	 = $this->db->prepare($sql);
				$sth->bindValue(":get", $member_username);
				$sth->execute();
				
				$rData = $this->getLib->fetchSQL($sth);
				if($rData['upd_tmp'] != $this->genPassword($tmp_pwd)){
					$error_msg = "密碼驗證失敗，請查看信件中的密碼";
					array_push($msg_array, $error_msg);
				}
			}
			
			if(!filter_has_var(INPUT_POST, "new_pwd") || !$this->getLib->checkVal($new_pwd)){
				$error_msg = "請輸入密碼";
				array_push($msg_array, $error_msg);
			}

			if(strlen($new_pwd) < 4){	
				$error_msg = "密碼長度太短，請重新輸入(須大於四個字元)";
				array_push($msg_array, $error_msg);
			}else{
				if($new_pwd != $new_pwd_cfm){
					$error_msg = "密碼不符";
					array_push($msg_array, $error_msg);

				}
			}



			// encrypt password
			$member_password = $this->genPassword($new_pwd);
			
			// 進行資料庫存取
			if(count($msg_array) == 0){
				try{
					
					$sql = "UPDATE `Member_data` 
							SET `upd` = ?,
							`upd_tmp` = ''
							WHERE `uid` = ?";
					$execute_array = array($member_password, $member_username);

					$sth = $this->db->prepare($sql);
					$sth->execute($execute_array);

					$returnVal['status'] = "success";
					$success_msg = "設定成功，請進行登入";
					array_push($msg_array, $success_msg);
				}catch(Exception $e){
					$error_msg = "資料庫錯誤 ";
					array_push($msg_array, $error_msg);
				}
				
			}
			
			
			$returnVal['msg'] = $msg_array;
		}
		
		return $returnVal;
	}


	// Increase Exp
	function memberIncreaseExp($uid, $expUp){
		// update exp times
		$sql = "UPDATE `Member_data` 
				SET `uexp` = `uexp` + $expUp
				WHERE `uid` = ?";
		$execute_array = array($uid);

		$sth = $this->db->prepare($sql);
		$sth->execute($execute_array);
	}

	function memberLogin($getData, $getAct){
		$returnVal = array("status" => "", "msg" => "");
		if(filter_has_var(INPUT_GET, "act") && $getAct == "dologin"){

			$msg_array 			= array();
			$user_username 		= $this->getLib->setFilter($getData['user_username']);
			$user_password 		= $this->getLib->setFilter($getData['user_password']);
			$user_remember_me 	= intval($this->getLib->setFilter($getData['user_remember_me']));
			$user_login_time 	= date("Y-m-d H:i:s");

			// check password
			if(!filter_has_var(INPUT_POST, "user_username") || !$this->getLib->checkVal($user_username)){
				$error_msg = "請輸入帳號";
				array_push($msg_array, $error_msg);
			}
			
			if(!filter_has_var(INPUT_POST, "user_password") || !$this->getLib->checkVal($user_password)){
				$error_msg = "請輸入密碼";
				array_push($msg_array, $error_msg);
			}
			
			// 進行資料庫存取
			if(count($msg_array) == 0){
				try{
					
					$sql = "SELECT `uid`, `upd`, `uactivate`, `uemail` FROM `Member_data` WHERE `uid` = :username LIMIT 0, 1";
					$sth = $this->db->prepare($sql);
					$sth->bindValue(":username", $user_username);
					$sth->execute();

					$getAccountData = $this->getLib->fetchArray($sth);
					// check account
					$check_count = 0;
					foreach($getAccountData AS $rData){
						if($rData['uid'] == $user_username){
							$getPassword = $this->genPassword($user_password);
							if($rData['upd'] == $getPassword){			
								
								$_SESSION['member_login']		= "yes";
								$_SESSION['email']    			= $rData['uemail'];
								$_SESSION['uid'] 	  			= $rData['uid'];
								$_SESSION['upd']      			= $rData['upd'];
								// for cookie
								$_SESSION['uremember']      	= $user_remember_me;

								$user_login_time = date("Y-m-d H:i:s");

								$sql = "UPDATE `Member_data` 
										SET `ulast_logintime` = ?, 
											`ulogin_times` = `ulogin_times` + 1
										WHERE `uid` = ?";
								$execute_array = array($user_login_time, 
														$user_username);

								$sth = $this->db->prepare($sql);
								$sth->execute($execute_array);
											



								if($rData['uactivate'] != "on"){
									$_SESSION['member_activate'] 	= "off";
									$_SESSION['activate_code']  	= $rData['uactivate'];
									$success_msg = "登入成功，帳號需啟用";	
								}else{
									$_SESSION['member_activate'] 	= "on";
									$success_msg = "登入成功";	
								}			

								$returnVal['status'] = "success";
								array_push($msg_array, $success_msg);

								// add exp
								$this->memberIncreaseExp($user_username, 100);

							}else{
								$uactivate = "off";
								$_SESSION['member_login']		= "";
								$_SESSION['member_activate'] 	= "off";
								$_SESSION['email']    			= "";
								$_SESSION['uid'] 	  			= "";
								$_SESSION['upd']      			= "";
								// for cookie
								$_SESSION['uremember']      	= "";

								$error_msg = "登入失敗！";
								array_push($msg_array, $error_msg);
							}
							$check_count++;
						}
					}
					
					if($check_count == 0){
						$error_msg = "登入失敗！";
						array_push($msg_array, $error_msg);			
					}
				}catch(Exception $e){
					$error_msg = "資料庫錯誤 ";
					array_push($msg_array, $error_msg);
				}
				
			}
			
			
			$returnVal['msg'] = $msg_array;
		}
		
		return $returnVal;
	}


	function memberIndexPage($getSession){

		$returnVal = array("status" => "", "msg" => "", "data" => array());

		if(isset($getSession) && $getSession['uid'] != ""){
			$uid = $this->getLib->setFilter($getSession['uid']);

			$sql 	 = "SELECT * FROM `Member_data` WHERE `uid` = :get";
			$sth 	 = $this->db->prepare($sql);
			$sth->bindValue(":get", $uid);
			$sth->execute();
			
			$getMemberData = $this->getLib->fetchSQL($sth);

			$returnVal['msg'] 		= array("成功");
			$returnVal['status'] 	= "success";
			$returnVal['data']		= $getMemberData;

		}else{
			$returnVal['msg'] 		= array("錯誤");
			$returnVal['status'] 	= "fail";
			$returnVal['data']		= array();
		}

		
		return $returnVal;
	}


	// update
	function updateMyInfo($getSession, $getData, $getAct){
		$returnVal = array("status" => "", "msg" => "");
		if(filter_has_var(INPUT_GET, "act") && $getAct == "submit" && $getSession['uid'] != ""){

			$msg_array 					= array();
			$member_username 			= $this->getLib->setFilter($getSession['uid']);
			$member_password 			= $this->getLib->setFilter($getData['member_password']);
			$member_password_cfm 		= $this->getLib->setFilter($getData['member_password_cfm']);
			$member_email_privacy 		= intval($this->getLib->setFilter($getData['member_email_privacy']));
			$member_gender_privacy 		= intval($this->getLib->setFilter($getData['member_gender_privacy']));
			$member_birthday_privacy 	= intval($this->getLib->setFilter($getData['member_birthday_privacy']));
			$member_pic		 			= $this->getLib->setFilter($getData['member_pic']);
			$member_nickname		 	= $this->getLib->setFilter($getData['member_nickname']);
			$member_career		 		= $this->getLib->setFilter($getData['member_career']);
			$member_education		 	= $this->getLib->setFilter($getData['member_education']);
			$member_school		 		= $this->getLib->setFilter($getData['member_school']);
			$member_homepage		 	= $this->getLib->setFilter($getData['member_homepage']);
			$member_intro			 	= $getData['member_intro'];
			$member_banner_pic		 	= $this->getLib->setFilter($getData['member_banner_pic']);

			// check password
			if(!$this->getLib->checkVal($member_username)){
				$error_msg = "查無帳號，請重新登入";
				array_push($msg_array, $error_msg);
			}
			

			$password_update = false;
			if(filter_has_var(INPUT_POST, "member_password") && $this->getLib->checkVal($member_password)){
				if(strlen($member_password) < 4){	
					$error_msg = "密碼長度太短，請重新輸入(須大於四個字元)";
					array_push($msg_array, $error_msg);
				}else{
					if($member_password != $member_password_cfm){
						$error_msg = "密碼不符";
						array_push($msg_array, $error_msg);
					}else{
						$password_update = true;
					}
				}
			}
			
			// 進行資料庫存取
			if(count($msg_array) == 0){
				try{
					
					if($password_update){
						$member_password = $this->genPassword($member_password);

						$sql = "UPDATE `Member_data` 
								SET `upd` = ?, 
									`ugender_status` = ?, 
									`ubirthday_status` = ?, 
									`uemail_status` = ?, 
									`uheadpicurl` = ?, 
									`unickname` = ?, 
									`ucareer` = ?, 
									`uedubg` = ?, 
									`uschool` = ?, 
									`uhomepage` = ?, 
									`uintro` = ?, 
									`u_home_banner` = ?
								WHERE `uid` = ?";
						$execute_array = array($member_password, 
												$member_gender_privacy, 
												$member_birthday_privacy, 
												$member_email_privacy, 
												$member_pic,
												$member_nickname, 
												$member_career, 
												$member_education, 
												$member_school, 
												$member_homepage, 
												$member_intro, 
												$member_banner_pic,
												$member_username);
					}else{			
						
						$member_password = $this->genPassword($member_password);

						$sql = "UPDATE `Member_data` 
								SET `ugender_status` = ?, 
									`ubirthday_status` = ?, 
									`uemail_status` = ?, 
									`uheadpicurl` = ?, 
									`unickname` = ?, 
									`ucareer` = ?, 
									`uedubg` = ?, 
									`uschool` = ?, 
									`uhomepage` = ?, 
									`uintro` = ?, 
									`u_home_banner` = ?
								WHERE `uid` = ?";
						$execute_array = array($member_gender_privacy, 
												$member_birthday_privacy, 
												$member_email_privacy, 
												$member_pic,
												$member_nickname, 
												$member_career, 
												$member_education, 
												$member_school, 
												$member_homepage, 
												$member_intro, 
												$member_banner_pic,
												$member_username);
					}

					$sth = $this->db->prepare($sql);
					$sth->execute($execute_array);

					$returnVal['status'] = "success";
					$success_msg = "個人資料更新成功！";						
					array_push($msg_array, $success_msg);

				}catch(Exception $e){
					$error_msg = "資料庫錯誤 ";
					array_push($msg_array, $error_msg);
				}
				
			}
			
			
			$returnVal['msg'] = $msg_array;
		}
		
		return $returnVal;
	}

	function getMyGameList($getSession, $getData, $getMany, $getType, $getCategory, $orderBy, $where_str = null){
		$returnVal = array("status" => "", "msg" => array(), "data" => "", "pager" => "", "order" => "", "url" => "");

		$msg_array = array();

		// initial page class
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

		// get username
		$getUsername = $this->getLib->setFilter($getSession['uid']);

		if($getUsername != ""){
			// call page class
			try{
					$status = "yes";
					$sql = "SELECT `id` FROM `Game_gamelist` 
							WHERE `status` = :status
							AND `uid` = :uid
							{$getTypeWhereStr} 
							{$getCategoryWhereStr} 
							{$where_str}
							{$orderByWhereStr}";
					$sth = $this->db->prepare($sql);
					$sth->bindValue(":status", $status);
					$sth->bindValue(":uid", $getUsername);
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
					$display 	= "4";
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
							AND `uid` = :uid
							{$getTypeWhereStr} 
							{$getCategoryWhereStr} 
							{$where_str}
							{$orderByWhereStr}
							LIMIT :start,:many";
					$sth = $this->db->prepare($sql);
					$sth->bindValue(":status", $status);
					$sth->bindValue(":uid", $getUsername);
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
					$returnVal['url']	 = $getTypeUrl.$getCategoryUrl;
			}catch(Exception $e){
				$error_msg = "資料庫錯誤 ";
				array_push($msg_array, $error_msg);
			}
		}else{
			$error_msg = "權限錯誤";
			array_push($msg_array, $error_msg);
		}
		
		if($returnVal['status'] != "success"){				
			$returnVal['status'] = "error";
		}
		
		$returnVal['msg'] = $msg_array;


		return $returnVal;
	}

	function getMyGameData($getSession, $id){

		$getId = $this->getLib->setFilter($id);
		$getUsername = $this->getLib->setFilter($getSession['uid']);

		$status = "yes";
		$sql 	= "SELECT * FROM `Game_gamelist` 
					WHERE `status` = :status 
					AND `id` = :get_id
					AND `uid` = :uid";
		$sth	= $this->db->prepare($sql);
		$sth->bindValue(":status", $status);
		$sth->bindValue(":get_id", $getId);
		$sth->bindValue(":uid", $getUsername);

		$sth->execute();	
		
		return $this->getLib->fetchSQL($sth);
	}

	// update
	function updateMyGame($getSession, $getData, $getAct){
		$returnVal = array("status" => "", "msg" => "");
		if(filter_has_var(INPUT_GET, "act") && $getAct == "submit" && $getSession['uid'] != "" && $getData['game_id']){

			$msg_array 					= array();
			$member_username 			= $this->getLib->setFilter($getSession['uid']);
			$game_id 					= $this->getLib->setFilter($getData['game_id']);
			$game_name 					= $this->getLib->setFilter($getData['game_name']);
			$game_category 				= $this->getLib->setFilter($getData['game_category']);
			$game_pic_1 				= $this->getLib->setFilter($getData['game_pic_1']);
			$game_pic_2 				= $this->getLib->setFilter($getData['game_pic_2']);
			$game_url 					= $this->getLib->setFilter($getData['game_url']);
			$game_content 				= $getData['game_content'];
			$game_tags_1 				= $this->getLib->setFilter($getData['game_tag_1']);
			$game_tags_2 				= $this->getLib->setFilter($getData['game_tag_2']);
			$game_tags_3 				= $this->getLib->setFilter($getData['game_tag_3']);
			$game_tags_4 				= $this->getLib->setFilter($getData['game_tag_4']);


			$game_tags_array 			= array($game_tags_1, $game_tags_2, $game_tags_3, $game_tags_4);
			$game_tags 					= implode(",", $game_tags_array);
			// check it is the game
			$chekcGameData = $this->getMyGameData($getSession, $game_id);

			if(!$this->getLib->checkVal($member_username)){
				$error_msg = "查無帳號，請重新登入";
				array_push($msg_array, $error_msg);
			}

			if($chekcGameData['id'] == "" || $chekcGameData['name'] == ""){
				$error_msg = "權限錯誤";
				array_push($msg_array, $error_msg);
			}
			
			if(!filter_has_var(INPUT_POST, "game_url") || !$this->getLib->checkVal($game_url)){
				$error_msg = "請輸入網址";
				array_push($msg_array, $error_msg);
			}
			
			if(!filter_has_var(INPUT_POST, "game_content") || !$this->getLib->checkVal($game_content)){
				$error_msg = "請輸入內容";
				array_push($msg_array, $error_msg);
			}
			
			// 進行資料庫存取
			if(count($msg_array) == 0){
				try{
						
						
					$member_password = $this->genPassword($member_password);

					$sql = "UPDATE `Game_gamelist` 
							SET `tags` = ?, 
								`name` = ?, 
								`content` = ?,
								`url` = ?, 
								`pic1` = ?, 
								`pic2` = ?, 
								`category` = ?
							WHERE `id` = ? AND `uid` = ?";
					$execute_array = array($game_tags, 
											$game_name, 
											$game_content,
											$game_url, 
											$game_pic_1,
											$game_pic_2, 
											$game_category, 
											$game_id, 
											$member_username);

					$sth = $this->db->prepare($sql);
					$sth->execute($execute_array);

					$returnVal['status'] = "success";
					$success_msg = "資料更新成功！";						
					array_push($msg_array, $success_msg);

				}catch(Exception $e){
					$error_msg = "資料庫錯誤 ";
					array_push($msg_array, $error_msg);
				}
				
			}
			
			
			$returnVal['msg'] = $msg_array;
		}
		
		return $returnVal;
	}

	function getMyFavGameList($getSession, $getData, $getMany, $getType, $getCategory, $orderBy, $where_str = null){
		$returnVal = array("status" => "", "msg" => array(), "data" => "", "pager" => "", "order" => "", "url" => "");

		$msg_array = array();

		// initial page class
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
			$orderBy			= "gf_create_time";
			$orderByWhereStr	= " ORDER BY `".$orderBy."` DESC";
		}

		// get username
		$getUsername = $this->getLib->setFilter($getSession['uid']);

		if($getUsername != ""){
			// call page class
			try{
					$status = "1";
					$sql = "SELECT `gf_index` FROM `Game_favorite` 
							WHERE `gf_status` = :status
							AND `gf_user_id` = :uid
							{$getTypeWhereStr} 
							{$getCategoryWhereStr} 
							{$where_str}
							{$orderByWhereStr}";
					$sth = $this->db->prepare($sql);
					$sth->bindValue(":status", $status);
					$sth->bindValue(":uid", $getUsername);
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
					$display 	= "4";
					$total	 	= $count;
					$pagename	= $this->pageName."?".$getTypeUrl.$getCategoryUrl.$orderByUrl;
					$getPage = new Pager($page, $many, $display, $total, $pagename);
			}catch(Exception $e){
				$error_msg = "資料庫錯誤 ";
				array_push($msg_array, $error_msg);
			}
			
			// get data from database
			try{
					$gf_status = "1";
					$status = "yes";
					$start  = intval($getPage->startVar);
					$many   = intval($getPage->manyVar);
					$sql = "SELECT `a`.`id`, `a`.`uid`, `a`.`name`, `a`.`content`, `a`.`pic1`, `a`.`type`, `a`.`category`, `a`.`category_2`, `a`.`category_3`, `a`.`category_4`, `a`.`count`, `a`.`date` 
							FROM `Game_gamelist` AS `a` RIGHT JOIN `Game_favorite` AS `b` ON `a`.`id` = `b`.`gf_game_id` 
							WHERE `a`.`status` = :status 
							AND `b`.`gf_status` = :gf_status 
							AND `b`.`gf_user_id` = :uid 
							{$getTypeWhereStr} 
							{$getCategoryWhereStr} 
							{$where_str}
							{$orderByWhereStr}
							LIMIT :start,:many";
					$sth = $this->db->prepare($sql);
					$sth->bindValue(":status", $status);
					$sth->bindValue(":gf_status", $gf_status);
					$sth->bindValue(":uid", $getUsername);
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
					$returnVal['url']	 = $getTypeUrl.$getCategoryUrl;
			}catch(Exception $e){
				$error_msg = "資料庫錯誤 ";
				array_push($msg_array, $error_msg);
			}
		}else{
			$error_msg = "權限錯誤";
			array_push($msg_array, $error_msg);
		}
		
		if($returnVal['status'] != "success"){				
			$returnVal['status'] = "error";
		}
		
		$returnVal['msg'] = $msg_array;


		return $returnVal;
	}


	function addVisitCounts($id){

		$getId = $this->getLib->setFilter($id);
		$status = "on";
		$sql 	= "UPDATE `Member_data` SET `ucounts` = `ucounts` + 1
					WHERE `uactivate` = :status 
					AND `uid` = :get_id";
		$sth	= $this->db->prepare($sql);
		$sth->bindValue(":status", $status);
		$sth->bindValue(":get_id", $getId);

		$sth->execute();	
	}

}