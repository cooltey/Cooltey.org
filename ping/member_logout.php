<?php
 /**
 *  Project: Cooltey.org
 *  Last Modified Date: 2017 Jan
 *  Developer: Cooltey Feng
 *  File: ./member_logout.php
 *  Description: Member Logout Page
 */

 include_once("./config/database.php");
 include_once("./class/lib.php");
 include_once("./class/auth.php");
 
 // call lib class
 $getLib = new Lib();

 // call auth 
 $getAuth = new Auth($db, $getLib);

 $getAuth->setLoginCookie("clear", "", "");

 session_destroy();
 
 echo $getLib->getRedirect("./index.php");



 ?>