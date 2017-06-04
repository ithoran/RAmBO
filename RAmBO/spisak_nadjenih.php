    <script src="js/jquery-3.2.1.min.js"></script> 
    <script src="js/moment.js"></script> 
    <script src="js/combodate.js"></script> 

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
		 <input type="hidden" name="lang" value="<?php echo $lang ?>">	
                <div class="filter_group">
                    <?php echo $L_NADNAM ?>: <br> 
                    <input type="text" value="" name="filter_naziv" class="filter_input">                  
                </div>
                
                <div class="filter_group">
                    <?php echo $L_LOK ?> <br> 
                    <input type="text" value="" name="filter_lokacija" class="filter_input">                  
                </div>
                
                <div class="filter_group">
                    <?php echo $L_TIP ?>: <br> 
                    <select class="filter_input" name="filter_tip" size="1">
                        <option value=""> </option>
                        <option value="zivotinja"> <?php echo $L_ZIV ?> </option>
                        <option value="dokument"> <?php echo $L_DOK ?> </option>
                        <option value="uredjaj"> <?php echo $L_ELU ?> </option>
                        <option value="ostalo"> <?php echo $L_OST ?> </option>
                    </select>
                </div>
                
                <div class="filter_group">
                    <?php echo $L_DATOD ?> <br> 
                      <input id="date" type="text" value="" name="filter_datum_od" class="filter_input" value="<?php echo date('Y-m-d');?>" data-format="YYYY-MM-DD" data-template="D MMM YYYY">
                                    <script>
                                      $('#date').combodate({
                                            minYear: 1975,
                                            maxYear: 2017
                                        });   
                                    </script>
                </div>
                
                <input type="submit" value="<?php echo $L_PRETRAZI ?>" name="filter_submit" class="button filter_button">
            </form>
        </div>

        
        
        <div class="content-list">
            <?php foreach($lista_nadj->lista as $nadjeno){?>
             <a href="nadjena_stvar.php?naziv=<?php echo $nadjeno->naziv ?>&korisnik=<?php echo $nadjeno->korisnik ?>&lang=<?php echo $lang?>">
            <div class="stvar_u_listi">
                <div class="label_stvar_u_listi label_stvar_u_listi_naziv"> <?php print "$nadjeno->naziv" ?></div>
                <div class="label_stvar_u_listi"><?php echo $L_LOK ?> <?php print "$nadjeno->mesto" ?></div>
                <div class="label_stvar_u_listi"><?php echo $L_DATUM ?> <?php print "$nadjeno->datum" ?></div>            
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




