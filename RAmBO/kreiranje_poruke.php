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
    <link rel="stylesheet" type="text/css" href="css/style_main.css?version=1?version=480">
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
        <div class="prikaz_poruke_wrapper">
        <table class="table table-fill">
                <thead>
                <tr class="tr">
                
                <th class="th text-left"><?php echo $L_SADRZAJ ?></th>


                </tr>
                </thead>

        </table>
            <div class="prikaz_poruke_sadrzaj">
                <form action="kreiranje_poruke.php?lang=<?php echo $lang ?>" method="post">
                
                <textarea name="sadrzaj_text" maxlength="300" class="prikaz_poruke_sadrzaj_inner"></textarea>
                      
                <div class="reply_btnsubmit">
                <input type="hidden" name="posalji_hdn">
                
                <input type="hidden" name="korisnik" value="<?php echo htmlspecialchars($_GET['korisnik']) ?>">
                
                <input type="hidden" name="naziv" value="<?php echo htmlspecialchars($_GET['naziv']) ?>">
                
                <?php if(isset($_POST['odgovori'])){ ?>
                <input type="hidden" name="odgovori">
                <?php }?>
                    <input type="submit" class="btn_submit_reply" name="odgovori_submit" value="<?php echo $L_POSALJI ?>">
                </div>
                </form>

            </div>
            
            </div>
        </div>
   
    <footer>
        RAmBO © 2017 | All rights reserved.
    </footer>

</body>
</html>



