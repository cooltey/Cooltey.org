<?php
 /**
 *  Project: Cooltey.org
 *  Last Modified Date: 2017 Jan
 *  Developer: Cooltey Feng
 *  File: ./search.php
 *  Description: Index Page
 */

 include_once("./config/database.php");
 include_once("./class/lib.php");
 include_once("./class/games.php");
 include_once("./class/page.php");
 include_once("./class/auth.php");


 // this page
 $pageName = "search";
 
 // call lib class
 $getLib = new Lib();
 
 // call auth 
 $getAuth = new Auth($db, $getLib);
 $getAuth->autoMemberLogin($_COOKIE['lU'], $_COOKIE['lC'], $_SESSION['member_login'], $_SESSION['uremember']);
 
 // call Main Object
 $getMain = new Games($db, $getLib, $pageName);

 // setup data
 $_GET['p'] = "search";

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
