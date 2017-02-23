<?php
 /**
 *  Project: Cooltey.org
 *  Last Modified Date: 2017 Jan
 *  Developer: Cooltey Feng
 *  File: ./parts/member_my_fav_games_page.php
 *  Description: Member My Fav Games Page
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
            <li class="active">已收藏遊戲</li>
          </ol>

          <!-- List Content -->
          <div class="row login">
           <div class="col-md-12">
            <h4>已收藏遊戲</h4>
            <div class="row">
              <div class="col-md-12">
                <!-- List Content -->
                <div class="row gamelist">
                  <?php
                    foreach($listData AS $lData){
                  ?>
                  <div class="col-md-4">
                    <a href="./game_page.php?id=<?php echo $lData['id'];?>">
                    <div class="gamelist-box btn-default z-depth-5">
                      <b><?php echo $lData['name'];?></b><br>
                      <div class="img-area">
                        <img src="<?php echo $lData['pic1'];?>" class="img-responsive img-thumbnail">
                      </div>
                      <span class="label label-default">人氣：<?php echo number_format($lData['count']);?></span>
                      <a href="./gamelist.php?type=<?php echo $lData['type'];?>&category=<?php echo $lData['category_1'];?>"><span class="label label-success"><?php echo $lData['category_1'];?></span></a>
                      <a href="./gamelist.php?type=<?php echo $lData['type'];?>&category=<?php echo $lData['category_2'];?>"><span class="label label-success"><?php echo $lData['category_2'];?></span></a>
                      <a href="./gamelist.php?type=<?php echo $lData['type'];?>&category=<?php echo $lData['category_3'];?>"><span class="label label-success"><?php echo $lData['category_3'];?></span></a>
                      <br>
                      <span class="label label-default">發表日期：<?php echo $lData['date'];?></span>
                    </div>
                    </a>
                  </div>
                  <?php
                    }
                  ?>

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