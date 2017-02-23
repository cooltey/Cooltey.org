<?php
 /**
 *  Project: Cooltey.org
 *  Last Modified Date: 2017 Jan
 *  Developer: Cooltey Feng
 *  File: ./parts/member_register_success_page.php
 *  Description: Member Register Success Page
 */

?>
    <div class="container">
      <!-- Example row of columns -->
      <div class="row">

        <div class="col-md-12">
          <!-- Bread Crumb -->
          <ol class="breadcrumb">
            <li><a href="./">首頁</a></li>
            <li class="active">認證會員</li>
          </ol>

          <!-- List Content -->
          <div class="row login">
           <div class="col-md-3">
           </div>
           <div class="col-md-6">
            <h4>您的認證結果...</h4>
            <p><?php echo $resultMsg;?></p>
            <hr>
            <div class="text-center">
              <a href="./index.php" class="btn btn-success">回到首頁</a>
              <a href="./member_login.php" class="btn btn-primary">前往登入</a>
            </div>
           </div>
           <div class="col-md-3">
           </div>

          </div>

          

        </div>
      </div>