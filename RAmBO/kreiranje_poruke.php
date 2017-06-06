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

if (isset($_POST['posalji_hdn']))
{
    $sender = $_SESSION['login_user'];
    $receiver = $_POST['korisnik'];
    $imeObjave = $_POST['naziv'];
    $sadrzaj = htmlspecialchars($_POST['sadrzaj_text']);
    echo $sender . $receiver . $imeObjave . $sadrzaj;
    posalji_poruku($sender, $receiver, $imeObjave, $sadrzaj);
    $pom = proveri_tip_objave($_POST['korisnik'], $_POST['naziv']);
    
    if(isset($_POST['odgovori'])){
        header("location: inbox.php?lang=$lang");
        
    }
    
    else if ($pom == 1)
    {
        header("location: izgubljena_stvar.php?korisnik=$receiver&naziv=$imeObjave&lang=$lang");
    }
    else
    {
        header("location: nadjena_stvar.php?korisnik=$receiver&naziv=$imeObjave&lang=$lang");
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
            <div class="report_label"><h2><?php echo $L_SADRZAJ ?></h2></div>
            <form method="post" action="kreiranje_poruke.php?lang=<?php echo $lang ?>">
                <input type="hidden" name="posalji_hdn">
                
                <input type="hidden" name="korisnik" value="<?php echo htmlspecialchars($_GET['korisnik']) ?>">
                
                <input type="hidden" name="naziv" value="<?php echo htmlspecialchars($_GET['naziv']) ?>">
                
                <?php if(isset($_POST['odgovori'])){ ?>
                <input type="hidden" name="odgovori">
                <?php }?>
                
                <div class="report_txtbox">
                    
                    <textarea class="report_txt" wrap="soft" name="sadrzaj_text" maxlength="150"></textarea>
                    
                </div>
                <div class="report_btnsubmit">
                    <input type="submit" class="btn_submit_report" value="<?php echo $L_POSALJI ?>">
                </div>
            </form>
        </div>
    </div>
         
   
    <footer>
        RAmBO © 2017 | All rights reserved.
    </footer>

</body>
</html>



