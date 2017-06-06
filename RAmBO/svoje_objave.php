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
include_once 'klase/listaIzgubljenih.php';
include_once 'klase/listaNadjenih.php';


session_start();

$korisnik = $_SESSION['login_user'];

if (isset($_GET['naziv_del'])){
    $naziv = $_GET['naziv_del'];
    obrisi_objavu($naziv, $korisnik);
}

$lista_izgubljenih = vrati_sve_objave_korisnik($korisnik, 1);
$lista_nadjenih = vrati_sve_objave_korisnik($korisnik, 0);



?>


<html>
<head>
    <link rel="stylesheet" type="text/css" href="css/style_main.css?version=1?version=74">
    <link rel="stylesheet" href="css/style_forme.css?version=87">
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
                <th class="th text-left"><?php echo $L_NAZ ?></th>
                <th class="th text-left"><?php echo $L_DATUM ?></th>
                <th class="th text-left"><?php echo $L_LOK ?></th>
                <th class="th text-left"><?php echo $L_TIP ?></th>
                <th class="th text-left"><?php echo $L_NAGRADA ?></th>
                <th class="th text-left"></th>
                <th class="th text-left"></th>
                </tr>
                </thead>
                <tbody class="table-hover">
<?php foreach ($lista_izgubljenih->lista as $izgubljeno) { ?>
                <tr class="tr">
                <td class="td text-left"><?php print "$izgubljeno->naziv" ?></td>
                <td class="td text-left"><?php print "$izgubljeno->datum" ?></td>
                <td class="td text-left"><?php print "$izgubljeno->mesto" ?></td>
                <td class="td text-left"><?php print "$izgubljeno->tip" ?></td>
                <td class="td text-left"><?php print "$izgubljeno->nagrada" ?></td>
                <td class="td text-left"><a href="svoje_objave.php?naziv_del=<?php print "$izgubljeno->naziv"?>&lang=<?php echo $lang?>"><span style="color:red;"> <?php echo $L_DELOBJ ?></span></a></td>
                <td class="td text-left"><a href="dodajIzgubljeno.php?naziv_izmena=<?php print "$izgubljeno->naziv"?>&korisnik_izmena=<?php print "$izgubljeno->korisnik"?>&lang=<?php echo $lang?>"><span style="color: green;"> <?php echo $L_CHAOBJ ?></span></a></td>
                </tr>
<?php } ?>
<?php foreach ($lista_nadjenih->lista as $nadjeno) { ?>
                <tr class="tr">
                <td class="td text-left"><?php print "$nadjeno->naziv" ?></td>
                <td class="td text-left"><?php print "$nadjeno->datum" ?></td>
                <td class="td text-left"><?php print "$nadjeno->mesto" ?></td>
                <td class="td text-left"><?php print "$nadjeno->tip" ?></td>
                <td class="td text-left">/</td>
                <td class="td text-left"><a href="svoje_objave.php?naziv_del=<?php print "$nadjeno->naziv"?>&lang=<?php echo $lang?>"><span style="color:red;"> <?php echo $L_DELOBJ ?></span></a></td>
                <td class="td text-left"><a href="dodajNadjeno.php?naziv_izmena=<?php print "$nadjeno->naziv"?>&korisnik_izmena=<?php print "$nadjeno->korisnik"?>&lang=<?php echo $lang?>"><span style="color: green;"> <?php echo $L_CHAOBJ ?></span></a></td>
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