<?php
 /**
 *  Project: Besttel
 *  Last Modified Date: 2016 July
 *  Developer: Cooltey Feng
 *  File: class/csrf_protection.php
 *  Description: CSRF PROTECTION Class
 */

class CSRFProtection{

	var $getToken;
	var $getLib;

	function CSRFProtection($get_lib){				
		$this->getLib 		= $get_lib;
	}

	// save token into session
	function genToken(){
		
		$_SESSION['csrf_token'] = $this->getLib->generateRandomString(7);
		
		$this->getToken = $_SESSION['csrf_token'];

	}

	// gen token hidden field
	function genTokenField(){

		// gen token
		if(!$this->getToken){
			$this->genToken();
		}
		return "<input type='hidden' name='csrf_token' value='".$this->getToken."'>";
	}

	// gen token hidden field
	function genTokenFieldForLogin($getSessionToken){
		// gen token
		if($getSessionToken == "" || !$getSessionToken){
			$this->genToken();
		}else{
			$this->getToken = $_SESSION['csrf_token'];
		}

		return "<input type='hidden' name='csrf_token' value='".$this->getToken."'>";
	}

	// check token
	function checkToken($postData){
		if($postData){
			if($_SESSION['csrf_token'] == $postData['csrf_token'] && $postData['csrf_token'] != "" && $_SESSION['csrf_token'] != ""){
				// pass
				$returnVal = true;
			}else{
				echo $this->getLib->showAlertMsg("驗證錯誤，請使用單一視窗操作");
				echo $this->getLib->getRedirect("./");
				exit;
			}
		}
	}
}
