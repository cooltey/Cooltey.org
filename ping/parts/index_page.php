<?php
 /**
 *  Project: Cooltey.org
 *  Last Modified Date: 2017 Jan
 *  Developer: Cooltey Feng
 *  File: ./parts/index_page.php
 *  Description: Index Page
 */

?> 
    
    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="jumbotron">
      <div class="container headline">
        <h3><a href="./game_page.php?id=<?php echo $topicArticle['id'];?>"><?php echo $topicArticle['name'];?></a></h3>
        <div class="col-lg-8 headline-text">
          <span class="label label-default"><?php echo $topicArticle['date'];?></span>
          <a href="./gamelist.php?type=<?php echo $topicArticle['type'];?>"><span class="label label-warning"><?php echo $topicArticle['type'];?></span></a>
          <?php if($topicArticle['category'] != ""){?>
          <a href="./gamelist.php?category=<?php echo $topicArticle['category'];?>"><span class="label label-success"><?php echo $topicArticle['category'];?></span></a>
          <?php } ?>
          <?php if($topicArticle['category_2'] != ""){?>
          <a href="./gamelist.php?category=<?php echo $topicArticle['category_2'];?>"><span class="label label-success"><?php echo $topicArticle['category_2'];?></span></a>
          <?php } ?>
          <?php if($topicArticle['category_3'] != ""){?>
          <a href="./gamelist.php?category=<?php echo $topicArticle['category_3'];?>"><span class="label label-success"><?php echo $topicArticle['category_3'];?></span></a>
          <?php } ?>
          <?php if($topicArticle['category_4'] != ""){?>
          <a href="./gamelist.php?category=<?php echo $topicArticle['category_4'];?>"><span class="label label-success"><?php echo $topicArticle['category_4'];?></span></a>
          <?php } ?>
          <p>
            <?php 
              $filterContent = strip_tags(str_replace("遊戲概述", "", $topicArticle['content']));
              if(mb_strlen($filterContent) > 150){
                echo mb_substr($filterContent, 0, 150,"utf-8")."...";
              }else{
                echo $filterContent;
              }
            ?>
          </p>
          <p><a class="btn btn-primary btn-lg" href="./game_page.php?id=<?php echo $topicArticle['id'];?>" role="button">想玩啊 &raquo;</a></p>
          <!-- Advertisement -->
          <div class="row">
            <div class="col-lg-12">
              <?php
                // load advertisement
                include("_ad_responsive.php");
              ?>  
            </div>
          </div>
          <!-- Advertisement -->
        </div>
        <div class="col-lg-4">
          <img src="<?php echo $topicArticle['pic1'];?>" class="img-responsive">
        </div>
      </div>
    </div>
    <div class="container index-game-list">
      <!-- Example row of columns -->
      <div class="row">
        <div class="col-md-4">
          <h4>電腦遊戲</h4>
          <?php 
            $counts = 0;
            $getRandNum = rand(0, 4);
            foreach($pcArticle AS $pcData){
          ?>
          <div class="col-md-12 index-game-box well">
            <b><a href="./game_page.php?id=<?php echo $pcData['id'];?>"><?php echo $pcData['name'];?></a></b><br>
          <span class="label label-default"><?php echo $pcData['date'];?></span><br>
          <?php if($pcData['category'] != ""){?>
          <a href="./gamelist.php?category=<?php echo $pcData['category'];?>"><span class="label label-success"><?php echo $pcData['category'];?></span></a>
          <?php } ?>
          <?php if($pcData['category_2'] != ""){?>
          <a href="./gamelist.php?category=<?php echo $pcData['category_2'];?>"><span class="label label-success"><?php echo $pcData['category_2'];?></span></a>
          <?php } ?>
          <?php if($pcData['category_3'] != ""){?>
          <a href="./gamelist.php?category=<?php echo $pcData['category_3'];?>"><span class="label label-success"><?php echo $pcData['category_3'];?></span></a>
          <?php } ?>
          <?php if($pcData['category_4'] != ""){?>
          <a href="./gamelist.php?category=<?php echo $pcData['category_4'];?>"><span class="label label-success"><?php echo $pcData['category_4'];?></span></a>
          <?php } ?>
            <p>
              <?php 
              $filterContent = strip_tags(str_replace("遊戲概述", "", $pcData['content']));
              if(mb_strlen($filterContent) > 90){
                echo mb_substr($filterContent, 0, 90,"utf-8")."...";
              }else{
                echo $filterContent;
              }
            ?>
            </p>
            <div class="img-block">
              <a href="./game_page.php?id=<?php echo $pcData['id'];?>"><img src="<?php echo $pcData['pic1'];?>" class="img-responsive img-thumbnail"></a>
            </div>
          </div>

          <?php
              if($getRandNum === $counts){
          ?>
          <!-- Advertisement -->
          <div class="col-md-12 index-game-box well">
          <?php
                // load advertisement
                include("_ad_responsive.php");
          ?>
          </div>
          <!-- Advertisement -->
          <?php
              }
          ?>
          <?php
              $counts++;
            }
          ?>

          <p><a class="btn btn-primary" href="./gamelist.php?type=Personal_Computer" role="button">更多電腦遊戲 &raquo;</a></p>
        </div>
        <div class="col-md-4">
          <h4>手機遊戲</h4>
          <?php 
            $counts = 0;
            $getRandNum = rand(0, 4);
            foreach($mobileArticle AS $mobileData){
          ?>
          <div class="col-md-12 index-game-box well">
            <b><a href="./game_page.php?id=<?php echo $mobileData['id'];?>"><?php echo $mobileData['name'];?></a></b><br>
          <span class="label label-default"><?php echo $mobileData['date'];?></span><br>
          <?php if($mobileData['category'] != ""){?>
          <a href="./gamelist.php?category=<?php echo $mobileData['category'];?>"><span class="label label-success"><?php echo $mobileData['category'];?></span></a>
          <?php } ?>
          <?php if($mobileData['category_2'] != ""){?>
          <a href="./gamelist.php?category=<?php echo $mobileData['category_2'];?>"><span class="label label-success"><?php echo $mobileData['category_2'];?></span></a>
          <?php } ?>
          <?php if($mobileData['category_3'] != ""){?>
          <a href="./gamelist.php?category=<?php echo $mobileData['category_3'];?>"><span class="label label-success"><?php echo $mobileData['category_3'];?></span></a>
          <?php } ?>
          <?php if($mobileData['category_4'] != ""){?>
          <a href="./gamelist.php?category=<?php echo $mobileData['category_4'];?>"><span class="label label-success"><?php echo $mobileData['category_4'];?></span></a>
          <?php } ?>
            <p>
              <?php 
              $filterContent = strip_tags(str_replace("遊戲概述", "", $mobileData['content']));
              if(mb_strlen($filterContent) > 90){
                echo mb_substr($filterContent, 0, 90,"utf-8")."...";
              }else{
                echo $filterContent;
              }
            ?>
            </p>
            <div class="img-block">
              <a href="./game_page.php?id=<?php echo $mobileData['id'];?>"><img src="<?php echo $mobileData['pic1'];?>" class="img-responsive img-thumbnail"></a>
            </div>
          </div>

          <?php
              if($getRandNum === $counts){
          ?>
          <!-- Advertisement -->
          <div class="col-md-12 index-game-box well">
          <?php
                // load advertisement
                include("_ad_responsive.php");
          ?>
          </div>
          <!-- Advertisement -->
          <?php
              }
          ?>
          <?php
              $counts++;
            }
          ?>

          <p><a class="btn btn-primary" href="./gamelist.php?type=Mobile" role="button">更多手機遊戲 &raquo;</a></p>
        </div>
        <div class="col-md-4">
          <h4>其他東西</h4>
          <div class="col-md-12 index-game-box">
            <div class="fb-like-box" data-href="https://www.facebook.com/cooltey.org" data-width="300" data-colorscheme="light" data-show-faces="true" data-header="true" data-stream="true" data-show-border="true"></div>
          </div>
          <div class="col-md-12 index-game-box">
            <a class="twitter-timeline" href="https://twitter.com/cooltey" data-widget-id="325303912171192320" width="300" height="400">@cooltey的推文</a>
            <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
          </div>
          <!-- Advertisement -->
          <div class="col-md-12 index-game-box">
          <?php
                // load advertisement
                include("_ad_responsive_related.php");
          ?>
          </div>
          <!-- Advertisement -->
        </div>
      </div>
