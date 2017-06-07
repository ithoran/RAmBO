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
include_once 'klase/poruka.php';
session_start();

$id_poruke = $_GET['id_poruke'];

//$korisnik = $_GET['korisnik']; // mozda i nece treba
$por = vrati_poruku($id_poruke);
oznaci_jednu($id_poruke);


$objava= vrati_naziv_objave($por->objava_id);
$sender= vrati_ime_korisnika($por->sender_id);
$receiver= vrati_ime_korisnika($por->receiver_id);

if($_SESSION['login_user'] != $sender){
$primljena = 1;
}
else{
$primljena = 0;
}

?>




<html>
<head>
    <script type="text/javascript" src="http://maps.google.com/maps/api/js?libraries=drawing&key=AIzaSyB1fcu7wpjL0yYdF2OJqwCs2wFLcasVvMI"></script>
    <script type="text/javascript" src="js/google_maps_kreiranje.js"></script>
    <link rel="stylesheet" type="text/css" href="css/style_main.css?version=1?version=897">
    <link rel="stylesheet" href="css/style_forme.css?version=3">
    <link rel="stylesheet" href="css/style_googlemaps.css?version=113">
    <link href="https://fonts.googleapis.com/css?family=Quantico" rel="stylesheet">
  <title>RAmBO L&F</title>
</head>

<body>
     
    <div id="pozadina">
        
    </div>
    <div id="pozadina_filter">
        
    </div>
    
<?php include("elementi/header_main.php") ?>

    
    
    <div id="main"> 
        <div class="prikaz_poruke_wrapper">
        <table class="table table-fill">
                <thead>
                <tr class="tr">
                <?php if($primljena == 1){?>
                <th class="th text-left"><?php echo $L_POSL ?> <?php print "$sender" ?></span></th>
                <?php }else{?>
                <th class="th text-left"><?php echo $L_POSL ?> <?php print "$receiver" ?></span></th>
                <?php } ?>
                <th class="th text-left"><?php echo $L_OBJAVA ?>: <?php print "$objava" ?></th>
                <th class="th text-left"><?php echo $L_VREME ?> <?php print "$por->vreme" ?></th>


                </tr>
                </thead>

        </table>
            <div class="prikaz_poruke_sadrzaj">
                <textarea class="prikaz_poruke_sadrzaj_inner" disabled><?php print "$por->content" ?></textarea>
                <?php if($primljena == 1){?>
                <form action="kreiranje_poruke.php?naziv=<?php echo $objava ?>&korisnik=<?php echo $sender ?>&lang=<?php echo $lang?>" method="post">
                <div class="reply_btnsubmit">
                    <input type="hidden" name="odgovori" value="odgovori">
                    <input type="submit" class="btn_submit_reply" name="odgovori_submit" value="<?php echo $L_ODGOVORI ?>">
                </div>
                </form>
                <?php } ?>
            </div>
            
            </div>
        </div>

         
   
    <footer>
        RAmBO © 2017 | All rights reserved.
    </footer>

</body>
</html>
