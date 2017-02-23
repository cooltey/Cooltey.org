  
    <meta name="author" content="Cooltey Feng">
    <meta name="description" content="平水相逢,模擬器,手機遊戲,自製程式" /> 
    <meta property="og:url"                content="https://www.cooltey.org/ping/<?php echo basename($_SERVER['REQUEST_URI']);?>" />
    <meta property="og:type"               content="article" />
    <meta property="og:title"              content="平水相逢 - <?php echo $getMain->setTitle($_GET);?>" />
    <?php
        $getMetaData = "";
        if(method_exists($getMain, 'getTitleData')){
            $getMetaData = $getMain->getTitleData($_GET['id']);
        }
        
        if(isset($getMetaData) && $getMetaData['name'] != ""){
            $pageDesc = mb_substr($getMetaData['content'], 0, 50,"utf-8");
            $pageImg  = $getMetaData['pic1'];
        }else{
            $pageDesc = "平水相逢,模擬器,GBA,PHP,小遊戲,手機遊戲";
            $pageImg  = "http://i646.photobucket.com/albums/uu184/cooltey/coolteytw/fb-1.jpg";
        }
    ?>
    <meta property="og:description"        content="<?php echo strip_tags($pageDesc);?>" />
    <meta property="og:image"              content="<?php echo $pageImg;?>" />
    <!-- Bootstrap core CSS -->
    <link href="./css/bootstrap.min.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="./css/ie10-viewport-bug-workaround.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <link href="./css/style.css?<?php echo date("YmdhisB");?>" rel="stylesheet">
    <link rel="shortcut icon" href="website_icon.ico">
    <link href="https://fonts.googleapis.com/css?family=Nunito|Slabo+27px" rel="stylesheet">

    <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <script>
      (adsbygoogle = window.adsbygoogle || []).push({
        google_ad_client: "ca-pub-7789199985896905",
        enable_page_level_ads: true
      });
    </script>