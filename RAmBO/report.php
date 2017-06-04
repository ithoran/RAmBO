<?php
if(isset($_REQUEST['lang'])){
    if($_REQUEST['lang'] == 'eng'){
        $lang = 'eng';
        include 'Jezici/eng.php';
    }
    else{
        $lang = 'srb';
        include 'Jezici/srb.php';
    }
}
else{
    $lang = 'srb';
    include 'Jezici/srb.php';
}
include_once 'lib.php';

?>

<html>
<head>
    <link rel="stylesheet" type="text/css" href="css/style_main.css?version=1?version=72">
    <link rel="stylesheet" href="css/style_forme.css?version=88">
    <link href="https://fonts.googleapis.com/css?family=Quantico" rel="stylesheet">
  <title>RAmBO L&F</title>
</head>

<body>
     
    <div id="pozadina">
        
    </div>
    <div id="pozadina_filter">
        
    </div>
    
    <header>
        <a href="index.php?lang=<?php echo $lang ?>">
        <h1 id="glavniNaslov">RAmBO <span id="lost">Lost</span>&<span id="found" >Found</span></h1>
        </a>
        <?php 
               include("elementi/logout_btn.php");
        ?>
        <div class="header_username">
            <?php print($_SESSION['login_user']) ?>
        </div>

    </header>

    
    
    <div id="main"> 

        <div class="report_wrapper">
            <div class="report_label"><h2><?php echo $$L_RAZLOGP ?>:</h2></div>
            <form method="post">
                <div class="report_txtbox">
                    <textarea class="report_txt" wrap="soft" maxlength="150"></textarea>
                </div>
                <div class="report_btnsubmit">
                    <input type="submit" class="btn_submit_report" value="<?php echo $L_PRIJAVI ?>">
                </div>
            </form>
        </div>
    </div>
         
   
    <footer>
        RAmBO © 2017 | All rights reserved.
    </footer>

</body>
</html>

