<?php
 /**
 *  Project: Cooltey.org
 *  Last Modified Date: 2017 Jan
 *  Developer: Cooltey Feng
 *  File: ./parts/search_page.php
 *  Description: Search Page
 */

?> 
    
    <div class="container">
      <!-- Example row of columns -->
      <div class="row">

        <div class="col-md-9">
          <!-- Bread Crumb -->
          <ol class="breadcrumb">
            <li><a href="./">首頁</a></li>
            <li class="active">搜尋結果</li>
          </ol>

          <div class="dropdown-menu-zone">
            <!-- Single button -->
            <div class="btn-group">
              <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                排序方式 <span class="caret"></span>
              </button>
              <ul class="dropdown-menu">
                <li <?php $this->getOrderStatus($_GET['orderby'], "name");?>><a href="./search.php?<?php echo $orderByUrl;?>&orderby=name">名稱</a></li>
                <li <?php $this->getOrderStatus($_GET['orderby'], "date");?>><a href="./search.php?<?php echo $orderByUrl;?>&orderby=date">時間</a></li>
                <li <?php $this->getOrderStatus($_GET['orderby'], "count");?>><a href="./search.php?<?php echo $orderByUrl;?>&orderby=count">人氣</a></li>
              </ul>
            </div>
          </div>

          <!-- List Content -->
          <div class="row gamelist">
            <?php
              foreach($listData AS $lData){
            ?>
            <div class="col-md-4">
              <a href="./game_page.php?id=<?php echo $lData['id'];?>">
              <div class="gamelist-box btn-default">
                <b><?php echo $lData['name'];?></b><br>
                <div class="img-area">
                  <img src="<?php echo $lData['pic1'];?>" class="img-responsive img-thumbnail">
                </div>
                <span class="label label-default">人氣：<?php echo number_format($lData['count']);?></span>
                <a href="./gamelist.php?<?php echo $this->showCategoryLinks($_GET['type'], $lData['category_1']);?>"><span class="label label-success"><?php echo $lData['category_1'];?></span></a>
                <a href="./gamelist.php?<?php echo $this->showCategoryLinks($_GET['type'], $lData['category_2']);?>"><span class="label label-success"><?php echo $lData['category_2'];?></span></a>
                <a href="./gamelist.php?<?php echo $this->showCategoryLinks($_GET['type'], $lData['category_3']);?>"><span class="label label-success"><?php echo $lData['category_3'];?></span></a>
                <br>
                <span class="label label-default">發表日期：<?php echo $lData['date'];?></span>
              </div>
              </a>
            </div>
            <?php
              }
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