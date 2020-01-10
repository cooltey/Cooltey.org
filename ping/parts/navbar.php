    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="./index.php"><span class="ping">平</span>水相逢</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">

          <ul class="nav navbar-nav">
            <li><a href="./about.php">站長介紹</a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">遊戲專區 <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="./gamelist.php?type=Emulator">模擬器介紹與下載</a></li>
                <li><a href="./gamelist.php?type=Personal_Computer">電腦遊戲</a></li>
                <li><a href="./gamelist.php?type=Android">Android 遊戲介紹</a></li>
                <li><a href="./gamelist.php?type=iOS">iOS 遊戲介紹</a></li>
                <li><a href="./gamelist.php?type=Game_Boy">GB 遊戲介紹</a></li>
                <li><a href="./gamelist.php?type=Game_Boy_Advance">GBA 遊戲介紹</a></li>
                <li><a href="./gamelist.php?type=Super_Nintendo">SFC 遊戲介紹</a></li>
                <li role="separator" class="divider"></li>
                <li><a href="http://twitch.tv/coolteygame">站長玩遊戲</a></li>
              </ul>
            </li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">網友交流 <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="https://facebook.com/cooltey.org">Facebook</a></li>
                <li><a href="#">許願區</a></li>
              </ul>
            </li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">站長自製 <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="https://github.com/cooltey">站長 Github</a></li>
              </ul>
            </li>
            <li><a href="./contact.php">聯絡站長</a></li>
          </ul>


          <ul class="nav navbar-nav navbar-right">
            <li class="dropdown">
            <?php
              if(!isset($_SESSION['member_login']) || $_SESSION['member_login'] != "yes" || $_SESSION['member_login'] == ""){
            ?>
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><b>登入</b> <span class="caret"></span></a>
                <ul id="login-dp" class="dropdown-menu">
                  <li>
                     <div class="row">
                        <div class="col-md-12">
                           <form class="form" role="form" method="post" action="./member_login.php?act=dologin" accept-charset="UTF-8" id="login-nav">
                              <div class="form-group">
                                 <label class="sr-only" for="username">帳號</label>
                                 <input type="username" name="user_username" class="form-control" id="username" placeholder="帳號" required>
                              </div>
                              <div class="form-group">
                                 <label class="sr-only" for="password">密碼</label>
                                 <input type="password" name="user_password" class="form-control" id="password" placeholder="密碼" required>
                                 <div class="help-block text-right"><a href="./member_forgetpwd.php">忘記密碼</a></div>
                              </div>
                              <div class="form-group">
                                 <button type="submit" class="btn btn-primary btn-block">登入</button>
                              </div>
                              <div class="checkbox">
                                 <label>
                                 <input type="checkbox" name="user_remember_me" value="1"> 記住我
                                 </label>
                              </div>
                               <?php echo $getMain->getCSRF->genTokenFieldForLogin($_SESSION['csrf_token']);?>
                           </form>
                        </div>
                        <div class="bottom text-center">
                          不是會員？ <a href="./member_register.php"><b>註冊</b></a>
                        </div>
                     </div>
                  </li>
                </ul>
            <?php
              }else{
            ?>
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><b><?php echo $_SESSION['uid'];?></b> <span class="caret"></span></a>
                <ul id="login-dp" class="dropdown-menu">
                  <li>
                     <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                            <?php
                              if($_SESSION['member_activate'] != "on"){
                            ?>
                               <a href="./member_resend_cfm.php" class="btn btn-success btn-block">重寄認證信</a>
                            <?php
                              }else{
                            ?>
                               <a href="./member_index.php" class="btn btn-primary btn-block">會員大廳</a>
                            <?php    
                              }
                            ?>
                            </div>
                            <div class="form-group">
                               <a href="./member_logout.php" class="btn btn-danger btn-block">登出會員</a>
                            </div>
                        </div>
                     </div>
                  </li>
                </ul>
            <?php    
              }
            ?>
            </li>
          </ul>
          
          <form class="navbar-form navbar-right" action="./search.php" method="get">
            <div class="form-group">
              <input type="text" name="keyword" placeholder="請輸入關鍵字" class="form-control">
            </div>
            <button type="submit" class="btn btn-success">搜尋</button>
          </form>
        </div><!--/.navbar-collapse -->
      </div>
    </nav>