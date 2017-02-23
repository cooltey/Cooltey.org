<?php
 /**
 *  Project: Cooltey.org
 *  Last Modified Date: 2017 Jan
 *  Developer: Cooltey Feng
 *  File: ./parts/member_resend_cfm_page.php
 *  Description: Member Resend Confirmation Page
 */

?>
    <div class="container">
      <!-- Example row of columns -->
      <div class="row">

        <div class="col-md-12">
          <!-- Bread Crumb -->
          <ol class="breadcrumb">
            <li><a href="./">首頁</a></li>
            <li class="active">重新寄送認證信</li>
          </ol>

          <!-- List Content -->
          <div class="row login">
           <div class="col-md-3">
           </div>
           <div class="col-md-6">
            <h4>請注意</h4>
            <p>在點擊『重新寄送認證信』之前，請再次檢查垃圾信箱中是否有收到信件。</p>
            <p>如果真的沒有收到認證信的話，就點擊下面按鈕吧。</p>

            <hr>
            <div class="text-center">
              <a href="./index.php" class="btn btn-success">回到首頁</a>
              <?php
                if(!isset($_GET['act'])){
              ?>
              <a href="./member_resend_cfm.php?act=send" class="btn btn-primary">重新寄送認證信</a>
              <?php
                }
              ?>
            </div>
           </div>
           <div class="col-md-3">
           </div>

          </div>

          

        </div>
      </div>