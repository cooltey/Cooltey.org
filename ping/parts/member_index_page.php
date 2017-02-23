<?php
 /**
 *  Project: Cooltey.org
 *  Last Modified Date: 2017 Jan
 *  Developer: Cooltey Feng
 *  File: ./parts/member_index_page.php
 *  Description: Member Index Sent Page
 */

?>
    <div class="container">
      <!-- Example row of columns -->
      <div class="row">

        <div class="col-md-12">
          <!-- Bread Crumb -->
          <ol class="breadcrumb">
            <li><a href="./">首頁</a></li>
            <li class="active">會員大廳</li>
          </ol>

          <!-- List Content -->
          <div class="row login">
           <div class="col-md-3">
           </div>
           <div class="col-md-6">
            <h4>會員大廳</h4>
            <div class="row">
             <div class="col-md-6">
                <?php
                  if($getMemberData['uheadpicurl'] == ""){
                    $img_url = "http://modacooltey.myweb.hinet.net/data_save/no.gif";
                  }else{
                    $img_url = $getMemberData['uheadpicurl'];
                  }
                ?>
                <img src="<?php echo $img_url;?>" class="img-rounded img-responsive">
             </div>
             <div class="col-md-6">
                  <p><a href="./member_update_info.php" class="btn btn-primary btn-lg">編輯個人資料</a></p>
                  <p><a href="./member_my_games.php" class="btn btn-primary btn-lg">編輯我的遊戲</a></p>
                  <p><a href="./member_my_fav_games.php" class="btn btn-primary btn-lg">已儲存的遊戲</a></p>
                  <p><a href="./member_logout.php" class="btn btn-danger btn-lg">登出會員</a></p>
             </div>
            </div>
              <div class="row">
                <hr>
                <ul>
                  <li>登入次數：<?php echo number_format($getMemberData['ulogin_times']);?> 次</li>
                  <li>註冊時間：<?php echo $getMemberData['ureg_date'];?></li>
                  <li>上次登入時間：<?php echo $getMemberData['ulast_logintime'];?></li>
                  <li>目前等級：<?php echo $getExpData['current'];?> (<?php echo number_format($getExpData['percentage'], 2);?>%)</li>
                </ul>
              </div>
           </div>
           <div class="col-md-3">
           </div>

          </div>

          

        </div>
      </div>