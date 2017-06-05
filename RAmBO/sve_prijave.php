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
include_once 'klase/listaPrijava.php';

session_start();

$korisnik = $_SESSION['login_user'];

if (isset($_GET['prijava_del'])){
    $prij = $_GET['prijava_del'];
    obrisi_prijavu($prij);
}

if (isset($_GET['user_del'])){
    $user = $_GET['user_del'];
    obrisi_korisnika($user);
}

$lista_prijava = vrati_sve_prijave();

?>


<html>
<head>
    <link rel="stylesheet" type="text/css" href="css/style_main.css?version=1?version=44">
    <link rel="stylesheet" href="css/style_forme.css?version=88">
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
        <div class="clanovi_wrapper">

            <div class="table-title">
                <h3><?php echo $L_MYOBJ ?></h3>
                </div>
                <table class="table table-fill">
                <thead>
                <tr class="tr">
                <th class="th text-left"><?php echo $L_PRIJAVILAC ?></th>
                <th class="th text-left"><?php echo $L_OBJAVA ?></th>
                <th class="th text-left"><?php echo $L_PRIJAVLJENI ?></th>
                <th class="th text-left"><?php echo $L_RAZLOGTEKST ?></th>
                <th class="th text-left"></th>
                <th class="th text-left"></th>
                <th class="th text-left"></th>
                </tr>
                </thead>
                <tbody class="table-hover">
<?php foreach ($lista_prijava->lista as $prijava) { ?>
                <tr class="tr">
                    <td class="td text-left"><?php echo vrati_ime_korisnika($prijava->idP) ?></td>
                <td class="td text-left"><?php echo vrati_ime_korisnika($prijava->idR) ?></td>
                <td class="td text-left"><?php echo vrati_ime_korisnika($prijava->idP) ?></td>
                <td class="td text-left"><?php echo "$prijava->tekst" ?></td>
                <td class="td text-left"><a href="sve_prijave.php?prijava_del=<?php print "$prijava->id"?>&lang=<?php echo $lang?>"><span style="color:red;"> <?php echo $L_DELPRIJAVA ?></span></a></td>
                <td class="td text-left"><a href="sve_prijave.php?user_del=<?php echo vrati_ime_korisnika($prijava->idR) ?>&lang=<?php echo $lang?>"><span style="color: green;"> <?php echo $L_DELPRIJAVLJENI ?></span></a></td>
                <td class="td text-left"><a href="sve_prijave.php?user_del=<?php echo vrati_ime_korisnika($prijava->idP) ?>&lang=<?php echo $lang?>"><span style="color: green;"> <?php echo $L_DELPRIJAVILAC ?></span></a></td>
                </tr>
<?php } ?>
                
                </tbody>
                </table>
        </div>
    </div>
         
   
    <footer>
        RAmBO © 2017 | All rights reserved.
    </footer>

</body>
</html>