<?php
 /**
 *  Project: Cooltey.org
 *  Last Modified Date: 2017 Jan
 *  Developer: Cooltey Feng
 *  File: ./parts/game_content_page.php
 *  Description: Game intro Page
 */

?> 
    <div class="container">
      <!-- Example row of columns -->
      <div class="row">

        <div class="col-md-9">
          <!-- Bread Crumb -->
          <ol class="breadcrumb">
            <li><a href="./index.php">首頁</a></li>
            <li><a href="./gamelist.php?type=<?php echo $getGameData['type'];?>"><?php echo $this->getAlias($getGameData['type']);?></a></li>
            <li class="active"><?php echo strip_tags($getGameData['name']);?></li>
          </ol>


          <!-- List Content -->
          <div class="row game-page">
            <div class="col-md-12">
              <h4><?php echo strip_tags($getGameData['name']);?></h4>
              <div class="space-20"></div>
              <div class="row game-img-slide">
                <?php 
                  if($getGameData['pic1'] != "" && !strpos($getGameData['pic1'], "myweb")){
                ?>
                <div class="col-md-4">
                  <a href="#img1"><img src="<?php echo $getGameData['pic1'];?>" class="img-responsive img-thumbnail"></a>
                  <a href="#_" class="lightbox" id="img1">
                    <img src="<?php echo $getGameData['pic1'];?>"">
                  </a>
                </div>
                <?php
                  }
                ?>
                <?php 
                  if($getGameData['pic2'] != "" && !strpos($getGameData['pic2'], "myweb")){
                ?>
                <div class="col-md-4">
                  <a href="#img2"><img src="<?php echo $getGameData['pic2'];?>" class="img-responsive img-thumbnail"></a>
                  <a href="#_" class="lightbox" id="img2">
                    <img src="<?php echo $getGameData['pic2'];?>"">
                  </a>
                </div>
                <?php
                  }
                ?>
                <?php 
                  $img_count = 3;
                  if($getGameData['pic_extra'] != ""){
                    // split data
                    $picExtraData = explode("|", $getGameData['pic_extra']);
                    foreach($picExtraData AS $picData){
                      if (!strpos($picData, "myweb")) {
                ?>
                <div class="col-md-4">
                  <a href="#img<?php echo $img_count;?>"><img src="<?php echo $picData;?>" class="img-responsive img-thumbnail"></a>
                  <a href="#_" class="lightbox" id="img<?php echo $img_count;?>">
                    <img src="<?php echo $picData;?>"">
                  </a>
                </div>
                <?php
                        $img_count++;
                      }
                    }
                  }
                ?>

              </div>
              <!-- Advertisement -->
              <!-- Advertisement -->
              <div class="space-20"></div>

              <!-- Content -->
              <div class="panel panel-default game-panel">
                <div class="panel-body">
                    
                    <?php
                      echo $this->getLib->stripslashes_deep($getGameData['content']);

                      // if gb, gba, sfc, then hide links
                      $downloadLink = $getGameData['url'];
                      $downloadWord = "點我玩遊戲";
                      if($getGameData['type'] == "Game_Boy_Advance" || $getGameData['type'] == "Game_Boy" || $getGameData['type'] == "Super_Nintendo"){
                        $downloadLink = "#";
                        $downloadWord = "<del>已不提供下載</del>";
                      }
                    ?>

                    <?php
                      if($_SESSION['member_login'] == "yes"){
                    ?>
                    <!-- <?php echo $getGameData['url'];?> -->
                    <?php
                      }
                    ?>
                    <div class="game-download-area">
                        <a class="btn btn-warning glyphicon glyphicon-hand-up" href="<?php echo $downloadLink;?>" target="_blank"> <?php echo $downloadWord;?></a>
                    </div>
                    <!-- Advertisement -->
                    <div class="space-20"></div>
                    <div class="row">
                      <div class="col-md-12">
                        <?php
                            if ($downloadLink != "#") {
                              // load advertisement
                              include("_ad_responsive.php");
                            }
                        ?>
                      </div>
                    </div>
                    <!-- Advertisement -->
                </div>
                <div id="game-detail" class="panel-collapse collapse">
                    <div class="col-md-6">
                      <h4>遊戲資料</h4>
                      <li>遊戲平台：<a href="./gamelist.php?type=<?php echo $getGameData['type'];?>"><?php echo $this->getAlias($getGameData['type']);?></a></li>
                      <li>遊戲類型：<a href="./gamelist.php?type=<?php echo $getGameData['type'];?>&category=<?php echo $getGameData['category'];?>"><?php echo $getGameData['category'];?></a>
                      <a href="./gamelist.php?type=<?php echo $getGameData['type'];?>&category=<?php echo $getGameData['category_2'];?>"><?php echo $getGameData['category_2'];?></a>
                      <a href="./gamelist.php?type=<?php echo $getGameData['type'];?>&category=<?php echo $getGameData['category_3'];?>"><?php echo $getGameData['category_3'];?></a>
                      <a href="./gamelist.php?type=<?php echo $getGameData['type'];?>&category=<?php echo $getGameData['category_4'];?>"><?php echo $getGameData['category_4'];?></a></li>
                      <li>發表時間：<?php echo $getGameData['date'];?></li>
                      <li>訪問人數：<?php echo number_format($getGameData['count']);?></li>
                      <li>發表會員：<a href="./home.php?uid=<?php echo $getGameData['uid'];?>"><?php echo $getGameData['uid'];?></a></li>
                      <li>遊戲標籤：
                      <?php
                        if($getGameData['tags'] != ""){
                          foreach($this->getTags($getGameData['tags']) AS $tagsData){
                      ?>
                        <a href="./search.php?keyword=<?php echo strip_tags($tagsData);?>"><?php echo strip_tags($tagsData);?></a>
                      <?php
                          }
                        }
                      ?>
                      </li>
                    <br><br>
                    </div>
                    <div class="col-md-6">
                      <h4>其他推薦</h4>
                      <?php 
                        $count = 0;
                        foreach($getRandomData AS $rData){
                      ?>
                      <li><a href="./game_page.php?id=<?php echo $rData['id'];?>"><?php echo strip_tags($rData['name']);?></a></li>
                      <?php
                          $count++;
                        }

                        if($count < 6){
                          for($i = $count; $i < 6; $i++){
                            echo "<br>";
                          }
                        }
                      ?>
                    <br><br>
                    </div>
                </div>
                <div class="panel-footer game-detail-area"><a data-toggle="collapse" data-parent="#accordion" href="#game-detail"><b>詳細資料</b></a></div>
                
              </div>
              <!-- Advertisement -->
              <!-- Advertisement -->
              <!-- Disqus -->
              <div class="panel panel-default">
                <div class="panel-body">
                  <div id="disqus_thread"></div>
                  <noscript>Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
                </div>
              </div>
              <!-- Disqus End -->
            </div>
            
          </div>

        </div>


        <div class="col-md-3">
            <!-- Advertisement -->
            <div class="col-md-12 index-game-box">
            <?php
                  // load advertisement
                  if ($downloadLink != "#") {
                    include("_ad_responsive.php");
                  }
            ?>
            </div>
            <!-- Advertisement -->
        </div>
      </div>

      <script>
          var disqus_config = function () {
              this.page.url = '<?php echo $this->getLib->getWebsiteUrl();?>/game_page.php?id=<?=$getGameData['id'];?>';
              this.page.identifier = '<?php echo $getGameData['id'];?>';
            };
          (function() {  // DON'T EDIT BELOW THIS LINE
              var d = document, s = d.createElement('script');
              s.src = 'https://cooltey.disqus.com/embed.js';
              s.setAttribute('data-timestamp', +new Date());
              (d.head || d.body).appendChild(s);
          })();
      </script>
