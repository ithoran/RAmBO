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
include_once 'klase/listaIzgubljenih.php';

session_start();

if(isset($_GET['naziv_del']) && isset($_GET['korisnik_del'])){
    $naziv = $_GET['naziv_del'];
    $korisnik = $_GET['korisnik_del'];
    obrisi_objavu($naziv, $korisnik);
}

if(isset($_POST['filter_hdn']) && !isset($_POST['reset_submit'])){
    
    
    $naziv = $_POST['filter_naziv'];
    $lokacija = $_POST['filter_lokacija'];
    $tip = $_POST['filter_tip'];
    $datum_od = $_POST['filter_datum_od'];
    $brStrana = ceil(vrati_broj_objava_filter($naziv, $tip, $lokacija, $datum_od, 1)/6);
    
    if (isset($_GET['page'])){
    $page = $_GET['page'];
         }
    else {
    $page = 1;
    }
   
    $lista_izg = vrati_sve_objave_filter_limit($naziv, $tip, $lokacija, $datum_od,($page*6) - 6, 6, 1);
}
 else {
    $brStrana = ceil(vrati_broj_objava(1)/6); 
    if (isset($_GET['page'])){
    $page = $_GET['page'];
}
else {
    $page = 1;
}
    $lista_izg = vrati_sve_objave_limit(($page*6) - 6, 6, 1);
}

?>

<html>
<head>
    <link rel="stylesheet" type="text/css" href="css/style_main.css?version=1">
    <link rel="stylesheet" href="css/style_forme.css?version=95">
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
                    <?php echo $L_IZGNAM ?>: <br> 
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
                <input type="hidden" name="filter_hdn">
                <input type="submit" value="<?php echo $L_PRETRAZI ?>" name="filter_submit" class="button filter_button filter">
                <input type="submit" value="Reset" name="reset_submit" class="button filter_button">
            </form>
            
        </div>

      
        
        <div class="content-list">
            <?php foreach($lista_izg->lista as $izgubljeno){?>
             <a href="izgubljena_stvar.php?naziv=<?php echo $izgubljeno->naziv ?>&korisnik=<?php echo $izgubljeno->korisnik ?>&lang=<?php echo $lang?>">
            <div class="stvar_u_listi">
                <div class="slika_objave_wrapper_lista">
                                <div class="slika_objave_lista">
    <?php if ($izgubljeno->slika == "") { ?>
                                        <img src="images/placeholder.jpg">
    <?php } else { ?>
                                        <img src="uploads/<?php echo $izgubljeno->slika ?>">
                                    <?php } ?>
                                </div>
                            </div>
                <div class="label_stvar_u_listi label_stvar_u_listi_naziv"> <?php print "$izgubljeno->naziv" ?></div>
                <div class="label_stvar_u_listi"><?php echo $L_LOK ?> <?php print "$izgubljeno->mesto" ?></div>
                <div class="label_stvar_u_listi"><?php echo $L_DATUM ?> <?php print "$izgubljeno->datum" ?></div>            
            </div>
             </a>
            <?php } ?>
                  <?php if($brStrana > 1) {?>
                <div class="pagination">
                 
                <?php for($j = 1; $j <= $brStrana; $j++) { ?>
                <a  href="spisak_izgubljenih.php?page=<?php echo $j ?>&lang=<?php echo $lang ?>">
                <div class="strana_link">
                    <?php echo $j ?>
                </div>
                </a>
            <?php } ?>
            </div>
            <?php } ?>
            
        </div>
        <div class='clear'></div>
        
        
    </div>   

    
    <footer>
        RAmBO © 2017 | All rights reserved.
    </footer>

</body>
</html>


