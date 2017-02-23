<?php
 /**
 *  Project: Cooltey.org
 *  Last Modified Date: 2017 Jan
 *  Developer: Cooltey Feng
 *  File: ./member_login.php
 *  Description: Member Login Page
 */

 include_once("./config/database.php");
 include_once("./class/lib.php");
 include_once("./class/members.php");
 include_once("./class/auth.php");


 // this page
 $pageName = "register_success";
 
 // call lib class
 $getLib = new Lib();
 
 // call Main Object
 $getMain = new Members($db, $getLib, $pageName);

 // call auth 
 $getAuth = new Auth($db, $getLib);
 $getAuth->autoMemberLogin($_COOKIE['lU'], $_COOKIE['lC'], $_SESSION['member_login'], $_SESSION['uremember']);


 // setup data
 $_GET['p'] = "register_success";

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

    <div class="space-100"></div>

      <!-- Start Gamelist Page -->
      <?php
          // set view
          $getMain->setView($_GET, $_POST, $_SESSION);
      ?>         
      <!-- End Gamelist Page -->

      <hr>
    
      <?php
        // footer
        include("./parts/footer.php");        
      ?>
    </div> <!-- /container -->

      <?php
        // website js
        include("./parts/website_js.php");        
      ?>

  </body>
</html>
