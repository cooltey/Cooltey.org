<?php
 /**
 *  Project: Cooltey.org
 *  Last Modified Date: 2017 Jan
 *  Developer: Cooltey Feng
 *  File: ./parts/member_update_info_page.php
 *  Description: Member Update Info Page
 */
?>
    <div class="container">
      <!-- Example row of columns -->
      <div class="row">

        <div class="col-md-12">
          <!-- Bread Crumb -->
          <ol class="breadcrumb">
            <li><a href="./">首頁</a></li>
            <li><a href="./member_index.php">會員大廳</a></li>
            <li class="active">更新個人資料</li>
          </ol>

          <!-- List Content -->
          <div class="row login">
           <div class="col-md-2">
           </div>
           <div class="col-md-8">
            <h4>更新個人資料</h4>
            <div class="row">
              <div class="col-md-12">
                <form class="form-horizontal" action="./member_update_info.php?act=submit" method="post">
                  <div class="form-group">
                    <div class="col-sm-4">
                    </div>
                    <div class="col-sm-4">
                      <?php
                        if($getMemberData['uheadpicurl'] == ""){
                          $img_url = "http://modacooltey.myweb.hinet.net/data_save/no.gif";
                        }else{
                          $img_url = $getMemberData['uheadpicurl'];
                        }
                      ?>
                      <img src="<?php echo $img_url;?>" class="img-thumbnail img-responsive">
                    </div>
                    <div class="col-sm-4">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="member_pic" class="col-sm-2 control-label">個人頭像</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="member_pic" name="member_pic" placeholder="請輸入網址" value="<?php echo $img_url;?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="member_username" class="col-sm-2 control-label">會員帳號</label>
                    <div class="col-sm-10">
                      <span class="form-control"><?php echo $getMemberData['uid'];?></span>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="member_password" class="col-sm-2 control-label">修改密碼</label>
                    <div class="col-sm-10">
                      <input type="password" class="form-control" id="member_password" name="member_password" placeholder="會員密碼">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="member_password_cfm" class="col-sm-2 control-label">確認密碼</label>
                    <div class="col-sm-10">
                      <input type="password" class="form-control" id="member_password_cfm" name="member_password_cfm" placeholder="確認密碼">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="member_email" class="col-sm-2 control-label">E-Mail</label>
                    <div class="col-sm-10">
                      <label><span class="form-control"><?php echo $getMemberData['uemail'];?> <input type="checkbox" name="member_email_privacy" value="1" <?php $this->checkboxChecker($getMemberData['uemail_status']);?>> 顯示</span></label>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="member_birthday" class="col-sm-2 control-label">生日</label>
                    <div class="col-sm-10">
                      <label><span class="form-control"><?php echo $getMemberData['ubyear']."/".$getMemberData['ubmonth']."/".$getMemberData['ubday'];?> <input type="checkbox" name="member_birthday_privacy" value="1" <?php $this->checkboxChecker($getMemberData['ubirthday_status']);?>> 顯示</span></label>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="member_gender" class="col-sm-2 control-label">性別</label>
                    <div class="col-sm-10">
                      <label><span class="form-control"><?php echo $this->genderFilter($getMemberData['ugender']);?> <input type="checkbox" name="member_gender_privacy" value="1" <?php $this->checkboxChecker($getMemberData['ugender_status']);?>> 顯示</span></label>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="member_nickname" class="col-sm-2 control-label">暱稱</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="member_nickname" name="member_nickname" placeholder="暱稱" value="<?php echo $getMemberData['unickname'];?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="member_career" class="col-sm-2 control-label">職業</label>
                    <div class="col-sm-10">
                      <select name="member_career" class="form-control"> 
                          <option value="<?php echo $getMemberData['ucareer'];?>" selected><?php echo $getMemberData['ucareer'];?></option>
                          <option value="學生">學生</option>
                              <option value="服務">服務</option>
                              <option value="製造">製造</option>
                              <option value="醫藥">醫藥</option>
                              <option value="金融">金融</option>
                              <option value="貿易">貿易</option>
                              <option value="大傳">大傳</option>
                              <option value="營造">營造</option>
                              <option value="軍警">軍警</option>
                              <option value="公務人員">公務人員</option>
                              <option value="教育">教育</option>
                              <option value="勞工">勞工</option>
                              <option value="家管">家管</option>
                              <option value="其它">其它</option>
                              <option value="自由">自由</option>
                              <option value="資訊" >資訊</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="member_edubg" class="col-sm-2 control-label">學歷</label>
                    <div class="col-sm-10">
                      <select name="member_education" class="form-control"> 
                          <option value="<?php echo $getMemberData['uedubg'];?>" selected><?php echo $getMemberData['uedubg'];?></option>
                          <option value="小學">小學</option>
                          <option value="國中(以下)">國中(以下)</option>
                          <option value="高中職">高中職</option>
                          <option value="大專院校">大專院校</option>
                          <option value="碩士">碩士</option>
                          <option value="博士(以上)">博士(以上)</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="member_school" class="col-sm-2 control-label">學校</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="member_school" name="member_school" placeholder="學校" value="<?php echo $getMemberData['uschool'];?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="member_homepage" class="col-sm-2 control-label">個人網站</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="member_homepage" placeholder="個人網站" name="member_homepage" value="<?php echo $getMemberData['uhomepage'];?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="member_intro" class="col-sm-2 control-label">自我介紹</label>
                    <div class="col-sm-10">
                      <textarea id="summernote" name="member_intro"><?php echo $getMemberData['uintro'];?></textarea>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="member_banner_pic" class="col-sm-2 control-label">名片橫幅圖片<br><small>(最佳尺寸：<br>780 * 150)</small></label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="member_banner_pic" name="member_banner_pic" placeholder="請輸入網址"><?php echo $getMemberData['u_home_banner'];?><br>
                    </div>
                    <div class="col-sm-10">
                      <?php
                        if($getMemberData['u_home_banner'] != ""){
                      ?>
                      <img src="<?php echo $getMemberData['u_home_banner'];?>" class="img-responsive">
                      <?php
                        }
                      ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-offset-6 col-sm-4">
                      <button type="submit" class="btn btn-success">更新個人資料</button>
                      <?php echo $this->getCSRF->genTokenFieldForLogin($_SESSION['csrf_token']);?>
                    </div>
                  </div>
                </form>
              </div>
            </div>
           </div>
           <div class="col-md-2">
           </div>

          </div>

          

        </div>
      </div>