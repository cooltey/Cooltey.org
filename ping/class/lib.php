<?php
 /**
 *  Project: Besttel
 *  Last Modified Date: 2016 July
 *  Developer: Cooltey Feng
 *  File: class/lib.php
 *  Description: Library for control basic function
 */
 
class Lib{
		
	// prevent magic quote
	function preventMagicQuote(){
		if ( in_array( strtolower( ini_get( 'magic_quotes_gpc' ) ), array( '1', 'on' ) ) ){
			$_POST 		= array_map( 'stripslashes', $_POST );
			$_GET 		= array_map( 'stripslashes', $_GET );
			$_COOKIE 	= array_map( 'stripslashes', $_COOKIE );
		 }
	}
		
	// Password Generator - return Hashed Password & Crypt String
	function genPassword($get_string){
		$returnVal = array("pwd" => "", "salt" => "");
		
		/*$newPassword = md5("nvidia{$get_string}elarning");*/

		//$salt = bin2hex(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM));
		$salt = bin2hex($this->generateRandomString(32));
		$saltedPW =  $get_string . $salt;
		$hashedPW = hash('sha256', $saltedPW);

		$returnVal['pwd'] = $hashedPW;
		$returnVal['salt'] = $salt;
		
		return $returnVal;
	}

	// Password Retrieve
	function bakPassword($pwd, $salt){

		$returnVal = "";

		$saltedPW =  $pwd . $salt;
		$returnVal = hash('sha256', $saltedPW);
	
		return $returnVal;
	}	

	// Password strength checker
	function checkPasswordStrength($password){ 
	     
	    $strength = 0; 
	    $patterns = array('#[a-z]#','#[A-Z]#','#[0-9]#','/[¬!"£$%^&*()`{}\[\]:@~;\'#<>?,.\/\\-=_+\|]/'); 
	    foreach($patterns as $pattern) 
	    { 
	        if(preg_match($pattern,$password,$matches)) 
	        { 
	            $strength++; 
	        } 
	    }

	    // check repeat
	    //if(preg_match("/[aaa]|[bbb]|[ccc]|[ddd]|[eee]|[fff]|[ggg]|[hhh]|[iii]|[jjj]|[kkk]|[lll]|[mmm]|[nnn]|[ooo]|[ppp]|[qqq]|[rrr]|[sss]|[ttt]|[uuu]|[vvv]|[www]|[xxx]|[yyy]|[zzz]|/", $password)){
	    //if(preg_match("/[a-z]{3}/", $password)){
	    //	$strength--;
	    //}

	    return $strength; 
	     
	    // 1 - weak 
	    // 2 - not weak 
	    // 3 - acceptable 
	    // 4 - strong 
	}
		
	
	// success dialog
	function showAlertMsg($get_string){
		$returnVal = $get_string;
		if($this->checkVal($returnVal)){
			if(is_array($get_string)){
				$get_string = implode("\n", $get_string);
			}
			
			$returnVal = "<script> alert(".json_encode($get_string)."); </script>";
			//$returnVal = "<script> alertify.alert('".json_encode(nl2br($get_string))."'); </script>";

		}
		
		return $returnVal;
	}
		
	// success dialog
	function getRedirect($get_string){
		$returnVal = $get_string;
		if($this->checkVal($returnVal)){
			//$returnVal = "<script>window.location.href='{$get_string}'</script>";
			$returnVal = "<meta http-equiv=\"refresh\" content=\"0; url={$get_string}\" />";
			//@header("HTTP/1.1 302 Found"); // response header
			// header('Location: {$get_string}', true, 302);
			// exit;
		}
		
		return $returnVal;
	}	

	// go back
	function goBack(){
		return "<script>window.history.back();</script>";
	}

	// gen random string
	function generateRandomString($length = 10) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, strlen($characters) - 1)];
		}
		return $randomString;
	}	
		
		
	// simple string filter
	function setFilter($get_string, $adv = false){
		$returnVal = $get_string;
		
		$returnVal = strip_tags($get_string);
		$returnVal = stripslashes($returnVal);
		$returnVal = htmlspecialchars($returnVal);
		if($adv == true){
			$returnVal =  htmlentities($returnVal, ENT_QUOTES, 'UTF-8');
		}
		
		return $returnVal;
	}

	// value transfer
	function hideNotice($data, $columns){
		foreach($columns AS $check_array){
			if(!isset($data[$check_array])){
				$data[$check_array] = "";
			}
		}

		return $data;
	}

	// check val
	function checkVal($get_val){
	
		$returnVal = false;
		
		if(isset($get_val) && $get_val != ""){
			$returnVal = true;
		}
		
		return $returnVal;
	}
	
	// Error Msg
	function showErrorMsg($get_error_array){
		
		if(count($get_error_array) > 0){
			?>
				<div class="alert alert-danger">
			<?php
				foreach($get_error_array AS $errorMsg){
				?>
				<li><?php echo $errorMsg;?></li>
				<?php
				}
			?>		
				</div>
			<?php
		}
	}

	// get the path
	function checkAdminPath($page){
	 
		$returnVal = null;
	 
		// default page path
		$admin_page_folder = "../pages/";
		
		// check file exist	
		if(is_file($admin_page_folder.$page.".php")){
			$returnVal = $admin_page_folder.$page.".php";
		}
		
		return $returnVal;
	}

	// get the path
	function checkExportPath($page){
		$returnVal = null;
	 
		// default page path
		$admin_page_folder = "../exports/";
		
		// check file exist	
		if(is_file($admin_page_folder.$page.".php")){
			$returnVal = $admin_page_folder.$page.".php";
		}
		
		return $returnVal;
	}
	 
	function toggleMenu($page, $section){
		if(preg_match("/{$section}/", $page)){
			echo "active";
		}
	}


	// output the active class & some icon with span
	function setSideNaviToggle($match_string, $act, $mode){
		$match_string = $this->setFilter($match_string);
		$act = $this->setFilter($act);

		$returnVal = array("tag" => "", "icon" => "");
		if(preg_match("/^".$match_string."$/", $act)){
			$returnVal['tag'] = " active";
			$returnVal['icon'] = " <span class=\"glyphicon glyphicon-chevron-right\"></span>";
		}

		return $returnVal[$mode];
	}
	 
	// check auth
	function checkAuth($session, $page){
	    if(!preg_match("/login/", $page)){
			$login 	  = $this->setFilter($session['login']);		
			$username = $this->setFilter($session['username']);		
			$password = $this->setFilter($session['password']);
			$rPage	  = "./?p=login&re={$page}";
			if($this->checkVal($login) && $this->checkVal($username) && $this->checkVal($password)){
				if($login == "1" && !preg_match("/logout/", $page)){
					// do nothing
					
				}else{
					echo $this->getRedirect($rPage);
					exit;
				}
			}else{
			   echo $this->getRedirect($rPage);		
			   exit;	
			}
		}
	}


	function getPageContent($page, $act, $obj){
		$getAct 	= $this->setFilter($act);
		$getPage 	= $this->setFilter($page);
		$getLib     = $this;
		$getMain	= $obj; // classes

		// default page path
		$page_folder_path = "../pages";

		if(!$this->checkVal($getAct)){
			$getAct = "list"; // default
		}

		// combine folder
		$final_path = $page_folder_path."/".$getPage."_".$getAct.".php";
		
		// check file exist	
		if(is_file($final_path)){
			include_once($final_path);
		}else{
			echo "Loading Page Error:" . $final_path;
		}
	}

	function printResult($var){
		echo "<pre>";
		print_r($var);
		echo "</pre>";
	}
	
	function getIp(){
		// get ip
		if (!empty($_SERVER['HTTP_CLIENT_IP']))
		{
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		}else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		}else{
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		
		return $ip;
	}

	// file upload
	function fileUpload($getFile, $input_name, $config_upload_folder, $show_subname = true){
		$returnVal = array("status" => false, "file" => array());
		
		$getTotalUploadFiles = count($getFile[$input_name]['name']);
	
		// execute upload process
		if($getTotalUploadFiles > 0){
			// upload loop
			for($i = 0; $i < $getTotalUploadFiles; $i++){
				if($this->checkVal($getFile[$input_name]['name'][$i])){
					// check file val
					if($getFile[$input_name]['error'][$i] == 0){
						$folder				 = $config_upload_folder;
				
						$file_tmp_name		 = $getFile[$input_name]['tmp_name'][$i];
						$file_display_name 	 = $this->setFilter($getFile[$input_name]['name'][$i]);
						$get_file_name_array = explode(".", $file_display_name);
						$get_file_subname    = $get_file_name_array[count($get_file_name_array)-1];
						if($show_subname){
							$file_name		   	 = date("YmdHis").rand(0, 999).".".$get_file_subname;
						}else{
							$file_name		   	 = date("YmdHis").rand(0, 999);
						}
						if(!file_exists($folder.$file_name) 
							&& $get_file_subname != "php"
							&& $get_file_subname != "asp"){
							try{
								move_uploaded_file($file_tmp_name, $folder.$file_name);
								
								$returnVal['status'] 		= true;								
								$returnVal['file'][$i]  	= $file_name;					
								$returnVal['file_name'][$i] = $file_display_name;
								
							}catch(Exception $e){		
							}
						}				
					}
				}
			}
		}
		
		return $returnVal;
	}

	// convert string
	function convertString($string){
		return mb_convert_encoding($string, "utf-8", "Big5");
		//return $string;
	}

	function convertEncode($getString){
		$retrunVal = iconv("utf-8", "big5", $getString);
		//$retrunVal = $getString;
		return $retrunVal;
	}

	function fetchSQL($sth){		
			return $sth->fetch(PDO::FETCH_ASSOC);		
	}
		
	function fetchArray($sth){
		$returnArray = array();
		while($listData = $this->fetchSQL($sth)){
			array_push($returnArray, $listData);
		}
		
		return $returnArray;
		
		// return $sth;
	}

	function getWebsiteUrl(){

		$getUriPrefix = "http://";

		if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on"){ 
		    $getUriPrefix = "https://";
		}

		$getUri 			= $_SERVER['REQUEST_URI'];
		$getUriArray		= explode("/", $getUri);
		$getUriCount		= count($getUriArray)-1;
		unset($getUriArray[$getUriCount]);
		$getNewUri			= implode("/", $getUriArray);
		$finalPath			= $getUriPrefix.$_SERVER['HTTP_HOST'].$getNewUri;

		return $finalPath;
	}

	function outputJson($output){
		 header('Cache-Control: no-cache, must-revalidate');
		 header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
		 header('Content-type: application/json');
		 //echo json_encode($output, JSON_UNESCAPED_SLASHES);
		 echo json_encode($output);
	}

	function stripslashes_deep($value){
		$value = is_array($value) ?
		array_map('stripslashes_deep', $value) :
		stripslashes($value);
		return $value;
	}
}