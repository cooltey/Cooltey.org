<?php
 /**
 *  Project: Cooltey.org
 *  Last Modified Date: 2017 Jan
 *  Developer: Cooltey Feng
 *  File: ./parts/member_edit_game_page.php
 *  Description: Member Edit Games Page
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
            <li><a href="./member_my_games.php">我的遊戲列表</a></li>
            <li class="active">編輯我的遊戲</li>
          </ol>

          <!-- List Content -->
          <div class="row login">
           <div class="col-md-2">
           </div>
           <div class="col-md-8">
            <h4>編輯我的遊戲</h4>
            <div class="row">
              <div class="col-md-12">
                <form class="form-horizontal" action="./member_edit_game.php?id=<?php echo $getGameData['id'];?>&act=submit" method="post">
                  <div class="form-group">
                    <label for="game_serialid" class="col-sm-2 control-label">文章編號</label>
                    <div class="col-sm-10">
                      <span class="form-control"><?php echo $getGameData['id'];?></span>
                      <input type="hidden" name="game_id" value="<?php echo $getGameData['id'];?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="game_name" class="col-sm-2 control-label">遊戲名稱</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="game_name" name="game_name" placeholder="遊戲名稱" value="<?php echo $getGameData['name'];?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="game_category" class="col-sm-2 control-label">遊戲分類</label>
                    <div class="col-sm-10">
                      <select name="game_category" class="form-control"> 
                          <option value="<?php echo $getGameData['category'];?>"><?php echo $getGameData['category'];?></option>
                          <?php 
                            foreach ($getAllGameCategory AS $cData) {
                          ?>
                          <option value="<?php echo $cData['cate_name'];?>"><?php echo $cData['cate_name'];?></option>
                          <?php
                            }
                          ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="game_pic_1" class="col-sm-2 control-label">遊戲圖片 1</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="game_pic_1" name="game_pic_1" placeholder="請輸入正確網址" value="<?php echo $getGameData['pic1'];?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="game_pic_2" class="col-sm-2 control-label">遊戲圖片 2</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="game_pic_2" name="game_pic_2" placeholder="請輸入正確網址" value="<?php echo $getGameData['pic2'];?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="game_url" class="col-sm-2 control-label">遊戲網址</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="game_url" name="game_url" placeholder="請輸入正確網址" value="<?php echo $getGameData['url'];?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="game_intro" class="col-sm-2 control-label">遊戲介紹</label>
                    <div class="col-sm-10">
                      <textarea id="summernote" name="game_content" ><?php echo $getGameData['content'];?></textarea>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="game_tags" class="col-sm-2 control-label">遊戲標籤</label>
                    <div class="col-sm-10">
                      <div class="row">
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="game_tag_1" name="game_tag_1" placeholder="請輸入標籤" value="<?php echo @$getMyGameTags[0];?>">
                        </div>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="game_tag_2" name="game_tag_2" placeholder="請輸入標籤" value="<?php echo @$getMyGameTags[1];?>">
                        </div>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="game_tag_3" name="game_tag_3" placeholder="請輸入標籤" value="<?php echo @$getMyGameTags[2];?>">
                        </div>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="game_tag_4" name="game_tag_4" placeholder="請輸入標籤" value="<?php echo @$getMyGameTags[3];?>">
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-offset-6 col-sm-4">
                      <button type="submit" class="btn btn-success">更新遊戲</button>
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