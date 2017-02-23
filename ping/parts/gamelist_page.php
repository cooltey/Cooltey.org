<?php
 /**
 *  Project: Cooltey.org
 *  Last Modified Date: 2017 Jan
 *  Developer: Cooltey Feng
 *  File: ./parts/gamelist_page.php
 *  Description: Gamelist Page
 */

?> 
    
    <div class="container">
      <!-- Example row of columns -->
      <div class="row">

        <div class="col-md-9">
          <!-- Bread Crumb -->
          <ol class="breadcrumb">
            <li><a href="./">首頁</a></li>
            <?php $this->showBreadCrumbForGameList($_GET['type'], $_GET['category']);?>
          </ol>

          <div class="dropdown-menu-zone">
            <!-- Single button -->
            <div class="btn-group">
              <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                排序方式 <span class="caret"></span>
              </button>
              <ul class="dropdown-menu">
                <li <?php $this->getOrderStatus($_GET['orderby'], "name");?>><a href="./gamelist.php?<?php echo $orderByUrl;?>&orderby=name">名稱</a></li>
                <li <?php $this->getOrderStatus($_GET['orderby'], "date");?>><a href="./gamelist.php?<?php echo $orderByUrl;?>&orderby=date">時間</a></li>
                <li <?php $this->getOrderStatus($_GET['orderby'], "count");?>><a href="./gamelist.php?<?php echo $orderByUrl;?>&orderby=count">人氣</a></li>
              </ul>
            </div>
          </div>

          <!-- List Content -->
          <div class="row gamelist">
            <?php
              $counts = 0;
              $getRandNum = rand(0, 14);
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
                <a href="./gamelist.php?<?php echo $this->showCategoryLinks($_GET['type'], $lData['category']);?>"><span class="label label-success"><?php echo $lData['category'];?></span></a>
                <a href="./gamelist.php?<?php echo $this->showCategoryLinks($_GET['type'], $lData['category_2']);?>"><span class="label label-success"><?php echo $lData['category_2'];?></span></a>
               <!--  <a href="./gamelist.php?<?php echo $this->showCategoryLinks($_GET['type'], $lData['category_3']);?>"><span class="label label-success"><?php echo $lData['category_3'];?></span></a> -->
                <br>
                <span class="label label-default">發表日期：<?php echo $lData['date'];?></span>
              </div>
              </a>
            </div>
            <?php
                if($getRandNum === $counts){
            ?>
            <!-- Advertisement -->
            <div class="col-md-4">
              <div class="gamelist-box btn-default z-depth-5 ad">
                <b>這是廣告</b><br><br>
              <?php
                    // load advertisement
                    include("_ad_200x200.php");
              ?>
              </div>
            </div>
            <!-- Advertisement -->
            <?php
                }
            ?>
            <?php
                $counts++;
              }
            ?>
          </div>

          <!-- Advertisement -->
          <div class="row">
            <div class="col-md-12">
              <?php
                    // load advertisement
                    include("_ad_responsive.php");
              ?>
            </div>
          </div>
          <!-- Advertisement -->
          
          <!-- Pagination -->
          <div class="pagination-zone">
            <?php
                if($getPage){
                    $getPage->getPageControlerForEvents();
                }
            ?>
          </div>


        </div>


        <div class="col-md-3">
            <div class="panel-group" id="accordion">
              <?php
                foreach($categoryListData AS $keyData => $valData){
              ?>
              <!-- List Group Start -->
              <div class="panel panel-default">
                <div class="panel-heading">
                  <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#<?php echo $keyData;?>">
                    <?php echo $valData['name'];?> </a> <span class="badge pull-right"><?php echo $valData['sum'];?></span>
                  </h4>
                </div>
                <div id="<?php echo $keyData;?>" class="panel-collapse collapse">
                    <ul class="list-group">
                      <?php
                        foreach($valData['data'] AS $lData){
                      ?>
                      <li class="list-group-item">
                        <span class="badge"><?php echo $lData['cate_numbers'];?></span>
                       <a href="./gamelist.php?type=<?php echo $keyData;?>&category=<?php echo $lData['cate_name'];?>"><?php echo $lData['cate_name'];?></a>
                      </li>
                      <?php
                        }
                      ?>
                    </ul>
                </div>
              </div>
              <!-- List Group End -->
              <?php
                }
              ?>
            </div>
            <!-- Advertisement -->
            <div class="col-md-12 index-game-box">
            <?php
                  // load advertisement
                  include("_ad_responsive.php");
            ?>
            </div>
            <!-- Advertisement -->
        </div>
      </div>