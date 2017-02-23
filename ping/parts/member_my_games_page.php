<?php
 /**
 *  Project: Cooltey.org
 *  Last Modified Date: 2017 Jan
 *  Developer: Cooltey Feng
 *  File: ./parts/member_my_games_page.php
 *  Description: Member My Games Page
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
            <li class="active">我的遊戲列表</li>
          </ol>

          <!-- List Content -->
          <div class="row login">
           <div class="col-md-12">
            <h4>我的遊戲列表</h4>
            <div class="row">
              <div class="col-md-12">
                <div class="table-responsive">
                <table class="table table-hover">
                  <tr>
                      <th>編號</th>
                      <th>遊戲名稱</th>
                      <th>發表時間</th>
                      <th>人氣</th>
                      <th>操作</th>
                  </tr>
                  <?php
                    foreach($listData AS $lData){
                  ?>
                  <tr>
                      <td><?php echo $lData['id'];?></td>
                      <td><?php echo strip_tags($lData['name']);?></td>
                      <td><?php echo $lData['date'];?></td>
                      <td><?php echo number_format($lData['count']);?></td>
                      <td><a href="./member_edit_game.php?id=<?php echo $lData['id'];?>">編輯遊戲</a></td>
                  </tr>
                  <?php
                    }
                  ?>
                </table>
                </div>
                <!-- Pagination -->
                <div class="pagination-zone">
                  <?php
                      if($getPage){
                          $getPage->getPageControlerForEvents();
                      }
                  ?>
                </div>
              </div>
            </div>
           </div>

          </div>

          

        </div>
      </div>