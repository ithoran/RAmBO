<?php
include_once 'lib.php';
include_once 'klase/listaIzgubljenih.php';

session_start();

$korisnik = $_SESSION['login_user'];

if (isset($_GET['naziv_del'])){
    $naziv = $_GET['naziv_del'];
    obrisi_objavu($naziv, $korisnik);
}

$lista_objava = vrati_sve_objave_korisnik($korisnik, 1);


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
                <h3>Moje objave</h3>
                </div>
                <table class="table table-fill">
                <thead>
                <tr class="tr">
                <th class="th text-left">Naziv</th>
                <th class="th text-left">Datum</th>
                <th class="th text-left">Lokacija</th>
                <th class="th text-left">Tip</th>
                <th class="th text-left">Nagrada</th>
                <th class="th text-left"></th>
                <th class="th text-left"></th>
                </tr>
                </thead>
                <tbody class="table-hover">
<?php foreach ($lista_objava->lista as $izgubljeno) { ?>
                <tr class="tr">
                <td class="td text-left"><?php print "$izgubljeno->naziv" ?></td>
                <td class="td text-left"><?php print "$izgubljeno->datum" ?></td>
                <td class="td text-left"><?php print "$izgubljeno->mesto" ?></td>
                <td class="td text-left"><?php print "$izgubljeno->tip" ?></td>
                <td class="td text-left"><?php print "$izgubljeno->nagrada" ?></td>
                <td class="td text-left"><a href="svoje_objave.php?naziv_del=<?php print "$izgubljeno->naziv"?>"><span style="color:red;"> Obrisi objavu</span></a></td>
                <td class="td text-left"><a href="dodajIzgubljeno.php?naziv_izmena=<?php print "$izgubljeno->naziv"?>&korisnik_izmena=<?php print "$izgubljeno->korisnik"?>"><span style="color: green;"> Izmeni objavu</span></a></td>
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