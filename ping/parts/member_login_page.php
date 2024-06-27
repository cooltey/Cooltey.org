<?php
 /**
 *  Project: Cooltey.org
 *  Last Modified Date: 2017 Jan
 *  Developer: Cooltey Feng
 *  File: ./parts/member_login_page.php
 *  Description: Member login Page
 */

?>


    <div class="container">
      <!-- Example row of columns -->
      <div class="row">

        <div class="col-md-12">
          <!-- Bread Crumb -->
          <ol class="breadcrumb">
            <li><a href="./index.php">首頁</a></li>
            <li class="active">會員登入</li>
          </ol>

          <!-- List Content -->
          <div class="row login">
           <div class="col-md-3">
           </div>
           <div class="col-md-6">
            <h4>會員登入</h4>
            <form class="form-horizontal" method="post" action="./member_login.php?act=dologin">
              <div class="form-group">
                <label for="user_username" class="col-sm-2 control-label">會員帳號</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" name="user_username" id="user_username" placeholder="會員帳號">
                </div>
              </div>
              <div class="form-group">
                <label for="user_password" class="col-sm-2 control-label">會員密碼</label>
                <div class="col-sm-10">
                  <input type="password" class="form-control" name="user_password" id="user_password" placeholder="會員密碼">
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" name="user_remember_me" value="1"> 記住這台電腦
                    </label>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                  <button type="submit" class="btn btn-primary">登入會員</button>
                  <a href="./member_forgetpwd.php" class="btn btn-danger pull-right">忘記密碼</a>
                </div>
              </div>
              <?php echo $this->getCSRF->genTokenFieldForLogin($_SESSION['csrf_token']);?>
            </form>
            <hr>
            <div class="col-md-3">
                <!-- Advertisement -->
                <div class="col-md-12 index-game-box">
                <?php
                      // load advertisement
                      // include("_ad_responsive.php");
                ?>
                </div>
                <!-- Advertisement -->
            </div>
            <hr>
              <div class="bottom text-center">
                不是會員？ <a href="./member_register.php"><b>加入會員！</b></a>
              </div>
           </div>
           <div class="col-md-3">
           </div>

          </div>

          

        </div>
      </div>