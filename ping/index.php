<?php
 /**
 *  Project: Cooltey.org
 *  Last Modified Date: 2017 Jan
 *  Developer: Cooltey Feng
 *  File: ./index.php
 *  Description: Index Page
 */

 include_once("./config/database.php");
 include_once("./class/lib.php");
 include_once("./class/games.php");
 include_once("./class/auth.php");


 // this page
 $pageName = "index";
 
 // call lib class
 $getLib = new Lib();
 
 // call Main Object
 $getMain = new Games($db, $getLib, $pageName);

 // call auth 
 $getAuth = new Auth($db, $getLib);

 // setup cookie
 if($_GET['l'] != ""){
    $getAuth->setLoginCookie($_SESSION['uremember'], $_SESSION['uid'], $_SESSION['upd']);
 }else{
    // auto login
    $getAuth->autoMemberLogin($_COOKIE['lU'], $_COOKIE['lC'], $_SESSION['member_login'], $_SESSION['uremember']);
 }


 // setup data
 $_GET['p'] = "index";

 ?>

<!DOCTYPE html>
<html lang="zh-Hant">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title>平水相逢 - <?php echo $getMain->setTitle($_GET);?></title>
    <?php
      // include header
      include("./parts/header.php");
    ?>
    
  </head>

  <body>

    <?php
      // navbar
      include("./parts/navbar.php");
    ?>

    <div class="space-20"></div>
    
      <!-- Start Index Main Page -->
      <?php
          // set view
          $getMain->setView($_GET, $_POST, $_SESSION);
      ?>         
      <!-- End Index Main Page -->

      <hr>
    
      <?php
        // footer
        include("./parts/footer.php");        
      ?>

      <?php
        // website js
        include("./parts/website_js.php");        
      ?>

  </body>
</html>
