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
include_once 'klase/listaPoruka.php';

session_start();

$korisnik = $_SESSION['login_user'];

if (isset($_GET['poruka_del'])){
    $id = $_GET['poruka_del'];
    obrisi_poruku($id);
}

oznaci_kao_procitano($korisnik);

$lista_poruka_prim = vrati_sve_primljene_poruke($korisnik);
$lista_poruka_posl = vrati_sve_poslate_poruke($korisnik);

?>



<html>
<head>
    <link rel="stylesheet" type="text/css" href="css/style_main.css?version=1?version=744">
    <link rel="stylesheet" href="css/style_forme.css?version=958">
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
                <h3><?php echo $L_PRIMPOR ?></h3>
                </div>
                <table class="table table-fill">
                <thead>
                <tr class="tr">
                <th class="th text-left"><?php echo $L_POSL ?></th>
                <th class="th text-left"><?php echo $L_OBJAVA ?>:</th>
                <th class="th text-left"><?php echo $L_VREME ?></th>
                <th class="th text-left"></th>

                </tr>
                </thead>
                <tbody class="table-hover">
<?php foreach ($lista_poruka_prim->lista as $poruka) { ?>
                <tr class="tr">
                <td style="cursor:pointer" onclick="location.href='prikaz_poruke.php?id_poruke=<?php print $poruka->id?>&lang=<?php print $lang?>'" class="td text-left"><?php echo vrati_ime_korisnika($poruka->sender_id) ?></td>
                <td style="cursor:pointer" onclick="location.href='prikaz_poruke.php?id_poruke=<?php print $poruka->id?>&lang=<?php print $lang?>'" class="td text-left"><?php echo vrati_naziv_objave($poruka->objava_id) ?></td>
                <td style="cursor:pointer" onclick="location.href='prikaz_poruke.php?id_poruke=<?php print $poruka->id?>&lang=<?php print $lang?>'" class="td text-left"><?php echo $poruka->vreme ?></td>
                <td class="td text-left"><a href="inbox.php?poruka_del=<?php print "$poruka->id"?>&lang=<?php echo $lang?>"><span style="color:red;"> <?php echo $L_OBRISIPOR ?></span></a></td>
                
                </tr>
<?php } ?>
                
                </tbody>
                </table>
             
            
            
            
            <div class="table-title">
                <h3><?php echo $L_POSLPOR ?></h3>
                </div>
                <table class="table table-fill">
                <thead>
                <tr class="tr">
                <th class="th text-left"><?php echo $L_PRIM ?></th>
                <th class="th text-left"><?php echo $L_OBJAVA ?>:</th>
                <th class="th text-left"><?php echo $L_VREME ?></th>
                <th class="th text-left"></th>

                </tr>
                </thead>
                <tbody class="table-hover">
<?php foreach ($lista_poruka_posl->lista as $poruka) { ?>
                
                    <tr class="tr">
             
                <td style="cursor:pointer" onclick="location.href='prikaz_poruke.php?id_poruke=<?php print $poruka->id?>&lang=<?php print $lang?>'" class="td text-left"><?php echo vrati_ime_korisnika($poruka->receiver_id) ?></td>
                <td style="cursor:pointer" onclick="location.href='prikaz_poruke.php?id_poruke=<?php print $poruka->id?>&lang=<?php print $lang?>'" class="td text-left"><?php echo vrati_naziv_objave($poruka->objava_id) ?></td>
                <td style="cursor:pointer" onclick="location.href='prikaz_poruke.php?id_poruke=<?php print $poruka->id?>&lang=<?php print $lang?>'" class="td text-left"><?php echo $poruka->vreme ?></td>

                <td class="td text-left"><a href="inbox.php?poruka_del=<?php print "$poruka->id"?>&lang=<?php echo $lang?>"><span style="color:red;"> <?php echo $L_OBRISIPOR ?></span></a></td>
                
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