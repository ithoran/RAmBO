<?php
include_once 'lib.php';
include_once 'klase/listaKorisnika.php';

session_start();

if (isset($_GET['username_del'])){
    $username = $_GET['username_del'];
    obrisi_korisnika($username);
}

$lista_korisnika = vrati_sve_korisnike();


?>


<html>
<head>
    <link rel="stylesheet" type="text/css" href="css/style_main.css?version=1?version=66">
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
                <h3>Lista clanova</h3>
                </div>
                <table class="table table-fill">
                <thead>
                <tr class="tr">
                <th class="th text-left">Korisnicko ime</th>
                <th class="th text-left">Drzava</th>
                <th class="th text-left">E-mail</th>
                <th class="th text-left"></th>
                </tr>
                </thead>
                <tbody class="table-hover">
<?php foreach ($lista_korisnika->lista as $korisnik) { ?>
                <tr class="tr">
                <td class="td text-left"><?php print "$korisnik->username" ?></td>
                <td class="td text-left"><?php print "$korisnik->drzava" ?></td>
                <td class="td text-left"><?php print "$korisnik->email" ?></td>
                <td class="td text-left"><a href="lista_clanova?username_del=<?php print "$korisnik->username"?>"><span style="color:red;"> Obrisi clana</span></a></td>
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