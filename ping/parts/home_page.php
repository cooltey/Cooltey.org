<?php
 /**
 *  Project: Cooltey.org
 *  Last Modified Date: 2017 Jan
 *  Developer: Cooltey Feng
 *  File: ./parts/home_page.php
 *  Description: Home Page
 */
?>

    <div class="container">
      <!-- Example row of columns -->
      <div class="row">

        <div class="col-md-12">
          <!-- Bread Crumb -->
          <ol class="breadcrumb">
            <li><a href="./">首頁</a></li>
            <li class="active"><?php echo $getMemberData['uid'];?>(<?php echo $getMemberData['unickname'];?>)的名片</li>
          </ol>

          <!-- List Content -->
          <div class="row about">
            
            <div class="col-md-1">
            </div>
            <div class="col-md-10">
                <div class="row well">
                    <div class="col-md-12">

                        <?php
                          if($getMemberData['u_home_banner'] != ""){
                            $img_url = $getMemberData['u_home_banner'];
                        ?>
                        <img src="<?php echo $img_url;?>" class="img-responsive img-rounded home-banner">
                        <?php
                          }else{
                        ?>
                            無設定個人 Banner...
                        <?php
                          }
                        ?>
                    </div>
                </div>
                <div class="row well">
                    <div class="col-md-2">

                        <?php
                          if($getMemberData['uheadpicurl'] == ""){
                            $img_url = "http://modacooltey.myweb.hinet.net/data_save/no.gif";
                          }else{
                            $img_url = $getMemberData['uheadpicurl'];
                          }
                        ?>
                        <img src="<?php echo $img_url;?>" class="img-responsive img-rounded home-banner">
                        <span>等級:<?php echo $getExpData['current'];?> (<?php echo number_format($getExpData['percentage'], 2);?>%)</span>
                    </div>
                    <div class="col-md-10">
                        <h4>自我介紹</h4>
                        <p><?php echo $getMemberData['uintro'];?></p>
                        <hr>
                        <h4>基本資料</h4>
                        <li>ID：<?php echo $getMemberData['uid'];?>(<?php echo $getMemberData['unickname'];?>)</li>
                        <?php 
                            if($getMemberData['ugender_status'] == "1"){
                                if($getMemberData['ugender'] == "male"){
                                    $gender = "男生";
                                }else{
                                    $gender = "女生";
                                }
                        ?>
                        <li>性別：<?php echo $gender;?></li>
                        <?php        
                            }
                        ?>
                        <?php 
                            if($getMemberData['uemail_status'] == "1"){
                        ?>
                        <li>電子郵件：<?php echo $getMemberData['uemail'];?></li>
                        <?php        
                            }
                        ?>
                        <?php 
                            if($getMemberData['ubirthday_status'] == "1"){
                        ?>
                        <li>生日：<?php echo $getMemberData['ubyear'];?> - <?php echo $getMemberData['ubmonth'];?> - <?php echo $getMemberData['ubday'];?></li>
                        <?php        
                            }
                        ?>
                        <?php 

                            if($getMemberData['uhomepage'] != ""){
                                $homepage = $getMemberData['uhomepage'];
                            }else{
                                $homepage = "無";
                            }

                            if($getMemberData['uschool'] != ""){
                                $school = $getMemberData['uschool'];
                            }else{
                                $school = "無";
                            }
                        ?>
                        <li>個人網站：<?php echo $homepage;?></li>
                        <li>就讀(畢業)學校：<?php echo $school;?></li>
                        <li>註冊日期：<?php echo $getMemberData['ureg_date'];?></li>
                        <li>登入次數：<?php echo number_format($getMemberData['ulogin_times']);?></li>
                        <li>上次登入時間：<?php echo $getMemberData['ulast_logintime'];?></li>
                        <li>人氣：<?php echo number_format($getMemberData['ucounts']);?> 人瀏覽過</li>
                    </div>
                </div>
                <div class="row well">
                    <div class="col-md-12">
                        <h4>我的收藏</h4>
                        <hr>
                        <div class="row">
                            <?php 
                                foreach($listData AS $favData){
                            ?>
                            <a href="./game_page.php?id=<?php echo $favData['id'];?>">
                            <div class="col-md-2 home-fav-game-box btn">
                                <b><?php echo $favData['name'];?></b>
                                <img src="<?php echo $favData['pic1'];?>" class="img-rounded img-responsive">
                            </div>
                            </a>
                            <?php
                                }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="row well">
                    <div class="col-md-12">
                        <h4>留言板</h4>
                        <hr>
                        <div id="disqus_thread"></div>
                        <noscript>Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
                    </div>
                </div>
            </div>
            <div class="col-md-1">
            </div>


          </div>

          

        </div>
      </div>
      <script>
        var disqus_shortname    = 'cooltey'; 
        var disqus_identifier   = '<?php echo $getMemberData['uid'];?>';
        var disqus_url          = 'http://www.cooltey.org/ping/home.php?uid=<?php echo $getMemberData['uid'];?>';
        
        /* * * DON'T EDIT BELOW THIS LINE * * */
        (function() {
            var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
            dsq.src = 'http://' + disqus_shortname + '.disqus.com/embed.js';
            (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
        })();
        (function () {
            var s = document.createElement('script'); s.async = true;
            s.type = 'text/javascript';
            s.src = 'http://' + disqus_shortname + '.disqus.com/count.js';
            (document.getElementsByTagName('HEAD')[0] || document.getElementsByTagName('BODY')[0]).appendChild(s);
        }());
      </script>