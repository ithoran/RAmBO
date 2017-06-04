<?php
session_start();
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

if (isset($_POST['report_hdn']))
{
    report_korisnika($_SESSION['login_user'], $_POST['korisnik'], $_POST['naziv'], htmlspecialchars($_POST['report_text']));
    $pom = proveri_tip_objave($_POST['korisnik'], $_POST['naziv']);
    if ($pom == 1)
    {
        header("location: spisak_izgubljenih.php?lang=$lang");
    }
    else
    {
        header("location: spisak_nadjenih.php?lang=$lang");
    }
}

?>

<html>
<head>
    <link rel="stylesheet" type="text/css" href="css/style_main.css?version=1?version=444">
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
            <div class="report_label"><h2><?php echo $L_RAZLOGP ?>:</h2></div>
            <form method="post" action="report.php?lang=<?php echo $lang ?>">
                <input type="hidden" name="report_hdn">
                
                <input type="hidden" name="korisnik" value="<?php echo htmlspecialchars($_GET['korisnik']) ?>">
                
                <input type="hidden" name="naziv" value="<?php echo htmlspecialchars($_GET['naziv']) ?>">
                
                <div class="report_txtbox">
                    
                    <textarea class="report_txt" wrap="soft" name="report_text" maxlength="150"></textarea>
                    
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

