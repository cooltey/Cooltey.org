<?php
 /**
 *  Project: Cooltey.org
 *  Last Modified Date: 2017 Jan
 *  Developer: Cooltey Feng
 *  File: ./parts/member_register_page.php
 *  Description: Member Register Page
 */

?>
<div class="container">
      <!-- Example row of columns -->
      <div class="row">

        <div class="col-md-12">
          <!-- Bread Crumb -->
          <ol class="breadcrumb">
            <li><a href="./">首頁</a></li>
            <li class="active">加入會員</li>
          </ol>

          <!-- List Content -->
          <div class="row login">
           <div class="col-md-2">
           </div>
           <div class="col-md-8">
            <h4>加入會員</h4>
            <form class="form-horizontal" action="./member_register.php?act=submit" method="post">
              <div class="form-group">
                <label for="member_username" class="col-sm-2 control-label">帳號名稱</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" name="member_username" id="member_username" placeholder="帳號名稱">
                </div>
              </div>
              <div class="form-group">
                <label for="member_password" class="col-sm-2 control-label">帳號密碼</label>
                <div class="col-sm-10">
                  <input type="password" class="form-control" name="member_password" id="member_password" placeholder="帳號密碼">
                </div>
              </div>
              <div class="form-group">
                <label for="member_password_cfm" class="col-sm-2 control-label">再次確認密碼</label>
                <div class="col-sm-10">
                  <input type="password" class="form-control" name="member_password_cfm" id="member_password_cfm" placeholder="再次確認密碼">
                </div>
              </div>
              <div class="form-group">
                <label for="member_email" class="col-sm-2 control-label">E-mail</label>
                <div class="col-sm-10">
                  <input type="email" class="form-control" name="member_email" id="member_email" placeholder="E-mail">
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" name="member_email_privacy" value="1"> 不公開
                    </label>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="member_gender" class="col-sm-2 control-label">性別<br><small class="text-danger">註冊後無法更改</small></label>
                <div class="col-sm-10">
                  <div class="radio">
                    <label>
                      <input type="radio" name="member_gender" value="1"> 男生
                    </label>
                    <label>
                      <input type="radio" name="member_gender" value="2"> 女生
                    </label>
                  </div>
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" name="member_gender_privacy" value="1"> 不公開
                    </label>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="member_birthday" class="col-sm-2 control-label">生日<br><small class="text-danger">註冊後無法更改</small></label>
                <div class="col-sm-10">
                  <div class="col-sm-4">
                    年
                    <select name="member_birth_year" class="form-control">
                        <?php
                            for($i = 1930; $i <= date("Y"); $i++){
                              if($i == 2000){
                                $selected = "selected";
                              }else{
                                $selected = "";
                              }
                        ?>
                      <option value="<?php echo $i;?>" <?php echo $selected;?>><?php echo $i;?></option>
                        <?php
                            }
                        ?>
                    </select>
                  </div>
                  <div class="col-sm-4">
                    月
                    <select name="member_birth_month" class="form-control">
                        <?php
                            for($i = 1; $i <= 12; $i++){
                        ?>
                      <option value="<?php echo $i;?>"><?php echo $i;?></option>
                        <?php
                            }
                        ?>
                    </select>
                  </div>
                  <div class="col-sm-4">
                    日
                    <select name="member_birth_day" class="form-control">
                        <?php
                            for($i = 1; $i <= 31; $i++){
                        ?>
                      <option value="<?php echo $i;?>"><?php echo $i;?></option>
                        <?php
                            }
                        ?>
                    </select>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="member_birthday_privacy" class="col-sm-2 control-label"></label>
                <div class="col-sm-10">
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" name="member_birthday_privacy" value="1"> 不公開
                    </label>
                  </div>
                </div>
              </div>
              <div class="form-group">

                <label for="member_statement" class="col-sm-2 control-label">會員條款</label>
                <div class="col-sm-10">
                   <textarea name="statement" rows="5" class="form-control">平水相逢會員註冊條款
                          
                  歡迎您即將成為平水相逢的一份子，但是在註冊之前，有些規定需要知道的，請網友們耐心看完這些條款並且遵守。     
                      
                  1. 此帳號不能用來在平水相逢中發表色情文章、廣告文章、暴力文章、木馬連結...，若經網友檢舉，站長有權利刪除該帳號。 
                          
                  2. 註冊完成之後，如果在時間之內沒有確認電子郵件，此帳號將會在一定時間內刪除。          

                  3. 站長有權利修改、刪除會員資料，但是是以「危害他人權益」為前題。

                  當您將「我同意以上條款」打勾並且送出時，就表示您願意遵守以上條款。
                  </textarea>
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" name="member_statment_agree" value="1"> 我同意以上條款
                    </label>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                  <button type="submit" class="btn btn-primary pull-right">註冊會員</button>
                </div>
              </div>
              <?php echo $this->getCSRF->genTokenFieldForLogin($_SESSION['csrf_token']);?>
            </form>
           </div>
           <div class="col-md-2">
           </div>

          </div>

          

        </div>
      </div>