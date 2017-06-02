<?php
include_once 'lib.php';
include_once 'klase/listaNadjenih.php';

session_start();

if(isset($_GET['naziv_del']) && isset($_GET['korisnik_del'])){
    $naziv = $_GET['naziv_del'];
    $korisnik = $_GET['korisnik_del'];
    obrisi_objavu($naziv, $korisnik);
}

if(isset($_POST['filter_submit'])){
    $naziv = $_POST['filter_naziv'];
    $lokacija = $_POST['filter_lokacija'];
    $tip = $_POST['filter_tip'];
    $datum_od = $_POST['filter_datum_od'];
    
    $lista_nadj = vrati_sve_objave_filter($naziv, $tip, $lokacija, $datum_od, 0);
}
 else {
    $lista_nadj = vrati_sve_objave(0);
}
?>

<html>
<head>
    <link rel="stylesheet" type="text/css" href="css/style_main.css?version=54">
    <link rel="stylesheet" href="css/style_forme.css?version=6">
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
        <div class="left_filter_div">
            <form action="" method="post">
			
                <div class="filter_group">
                    Naziv nadjene stvari: <br> 
                    <input type="text" value="" name="filter_naziv" class="filter_input">                  
                </div>
                
                <div class="filter_group">
                    Lokacija: <br> 
                    <input type="text" value="" name="filter_lokacija" class="filter_input">                  
                </div>
                
                <div class="filter_group">
                    Tip: <br> 
                    <select class="filter_input" name="filter_tip" size="1">
                        <option value=""> </option>
                        <option value="zivotinja"> Životinja </option>
                        <option value="dokument"> Lični dokument </option>
                        <option value="uredjaj"> Elektronski uredjaj </option>
                        <option value="ostalo"> Ostalo </option>
                    </select>
                </div>
                
                <div class="filter_group">
                    Datum od: <br> 
                    <input type="date" value="" name="filter_datum_od" class="filter_input">
                </div>
                
                <input type="submit" value="Pretrazi" name="filter_submit" class="button filter_button">
            </form>
        </div>

        
        
        <div class="content-list">
            <?php foreach($lista_nadj->lista as $nadjeno){?>
             <a href="nadjena_stvar.php?naziv=<?php echo $nadjeno->naziv ?>&korisnik=<?php echo $nadjeno->korisnik ?>">
            <div class="stvar_u_listi">
                <div class="label_stvar_u_listi label_stvar_u_listi_naziv"> <?php print "$nadjeno->naziv" ?></div>
                <div class="label_stvar_u_listi">Mesto: <?php print "$nadjeno->mesto" ?></div>
                <div class="label_stvar_u_listi">Datum: <?php print "$nadjeno->datum" ?></div>            
            </div>
             </a>
            <?php } ?>
        </div>
        <div class='clear'></div>
    </div>   
    
    
    <footer>
        RAmBO © 2017 | All rights reserved.
    </footer>

</body>
</html>




