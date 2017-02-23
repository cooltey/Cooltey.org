<?php
 /**
 *  Project: Cooltey.org
 *  Last Modified Date: 2017 Jan
 *  Developer: Cooltey Feng
 *  File: ./parts/member_resetpwd_page.php
 *  Description: Member Reset Pwd Page
 */

?>
  <div class="container">
      <!-- Example row of columns -->
      <div class="row">

        <div class="col-md-12">
          <!-- Bread Crumb -->
          <ol class="breadcrumb">
            <li><a href="./">首頁</a></li>
            <li class="active">重新設定密碼</li>
          </ol>

          <!-- List Content -->
          <div class="row login">
           <div class="col-md-3">
           </div>
           <div class="col-md-6">
            <h4>重新設定密碼</h4>
            <hr>
            <form class="form-horizontal" action="./member_resetpwd.php?act=submit&uid=<?php echo $this->getLib->setFilter($_GET['uid']);?>" method="post">
              <div class="form-group">
                <label for="tmp_pwd" class="col-sm-3 control-label">暫時密碼</label>
                <div class="col-sm-9">
                  <input type="password" class="form-control" name="tmp_pwd" id="tmp_pwd" placeholder="暫時密碼">
                </div>
              </div>
              <div class="form-group">
                <label for="new_pwd" class="col-sm-3 control-label">新密碼</label>
                <div class="col-sm-9">
                  <input type="password" class="form-control" name="new_pwd" id="new_pwd" placeholder="新密碼">
                </div>
              </div>
              <div class="form-group">
                <label for="new_pwd_cfm" class="col-sm-3 control-label">確認新密碼</label>
                <div class="col-sm-9">
                  <input type="password" class="form-control" name="new_pwd_cfm" id="new_pwd_cfm" placeholder="確認新密碼">
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                  <input type="hidden" name="member_username" value="<?php echo $this->getLib->setFilter($_GET['uid']);?>">
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