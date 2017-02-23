<?php
 /**
 *  Project: Cooltey.org
 *  Last Modified Date: 2017 Jan
 *  Developer: Cooltey Feng
 *  File: ./parts/member_forgetpwd_page.php
 *  Description: Member Forget Pwd Page
 */

?>
  <div class="container">
      <!-- Example row of columns -->
      <div class="row">

        <div class="col-md-12">
          <!-- Bread Crumb -->
          <ol class="breadcrumb">
            <li><a href="./">首頁</a></li>
            <li class="active">忘記密碼</li>
          </ol>

          <!-- List Content -->
          <div class="row login">
           <div class="col-md-3">
           </div>
           <div class="col-md-6">
            <h4>忘記密碼</h4>
            <p>忘記密碼嗎？沒關係，填寫當初註冊的會員帳號和註冊的 Email ，只要正確的話站長就會寄信到你的信箱囉！</p>
            <hr>
            <form class="form-horizontal" action="./member_forgetpwd.php?act=submit" method="post">
              <div class="form-group">
                <label for="member_username" class="col-sm-4 control-label">當初註冊的帳號</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" name="member_username" id="member_username" placeholder="帳號名稱">
                </div>
              </div>
              <div class="form-group">
                <label for="member_email" class="col-sm-4 control-label">當初註冊的E-mail</label>
                <div class="col-sm-8">
                  <input type="email" class="form-control" name="member_email" id="member_email" placeholder="E-mail">
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                  <button type="submit" class="btn btn-primary pull-right">填好送出</button>
                </div>
              </div>
              <?php echo $this->getCSRF->genTokenFieldForLogin($_SESSION['csrf_token']);?>
            </form>
           </div>
           <div class="col-md-3">
           </div>

          </div>

          

        </div>
      </div>