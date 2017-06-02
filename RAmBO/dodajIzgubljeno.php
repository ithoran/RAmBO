<?php

 include_once 'lib.php';
 include_once 'klase/izgubljeno.php';
   
   session_start();
  
   if(isset($_GET['naziv_izmena'])){
   
       $izgubljeno_za_izmenu = vrati_objavu($_GET['naziv_izmena'], $_GET['korisnik_izmena'], 1);
       if(isset($_POST['izmeni_hdn'])) {
              
        $naziv = $_POST['naziv'];
        $tip = $_POST['tip']; 
        $lokacija = $_POST['lokacija'];
        $datum = $_POST['datum'];
        $nagrada = $_POST['nagrada'];
        $korisnik = $_SESSION['login_user'];
        if ($naziv != "" && $tip != NULL && $lokacija != "" && $datum != NULL){
            $izgubljeno = new Izgubljeno($naziv, $tip, $lokacija, $datum, $nagrada, $korisnik);
            izmeni_izgubljeno($izgubljeno_za_izmenu, $izgubljeno);
            header("location: index.php");
      }else {
         $error = "Pogresni podaci za login.";
      }
           }
       
       
   }
   
   else{
   if(isset($_POST['dodaj_hdn']) && isset($_POST['tip'])) {
      
      $naziv = $_POST['naziv'];
      $tip = $_POST['tip']; 
      $lokacija = $_POST['lokacija'];
      $datum = $_POST['datum'];
      $nagrada = $_POST['nagrada'];
      $korisnik = $_SESSION['login_user'];
      
      if ($naziv != "" && $tip != NULL && $lokacija != "" && $datum != NULL){
        $izgubljeno = new Izgubljeno($naziv, $tip, $lokacija, $datum, $nagrada, $korisnik);
        dodaj_izgubljeno($izgubljeno);
        header("location: index.php");
      }else {
         $error = "Pogresni podaci za login.";
      }
   }
   }

?>


<html>
<head>
    <link rel="stylesheet" type="text/css" href="css/style_main.css?version=1">
    <link rel="stylesheet" href="css/style_forme.css?version=2">
    <link href="https://fonts.googleapis.com/css?family=Quantico" rel="stylesheet">
  <title>RAmBO L&F</title>
</head>

<body>
    <div id="pozadina">
        
    </div>
    <div id="pozadina_filter">
        
    </div>
    
    <header>
        <a href="index.php">
        <h1 id="glavniNaslov">RAmBO <span id="lost">Lost</span>&<span id="found" >Found</span></h1>
        </a>
    </header>
    
    <div id="main"> 

        <div class="login">
	
            <?php if(isset($_GET['naziv_izmena'])){ ?>
            <div class="login-screen">
			<div class="form-title dodaj_izgubljeno_title">
				<h1>Izmeni informacije o izgubljenoj stvari</h1>
			</div>
                    <form action="" method="post">
			<div class="login-form">
		
                                <input type="hidden" name="izmeni_hdn">
                            
                                <div class="form_label">Naziv izgubljene stvari:</div>
                                <div class="control-group">
                                <input type="text" class="login-field" name="naziv" value="<?php print $izgubljeno_za_izmenu->naziv ?>">
				</div>
                                
                                <div class="form_label">Izaberite tip izgubljene stvari:</div>
				<div class="control-group">
				<select class="select_forma" name="tip" size="1">
                                <option value="zivotinja" <?php if($izgubljeno_za_izmenu->tip == 'zivotinja') echo"selected"; ?>> Životinja </option>
                                    <option value="dokument" <?php if($izgubljeno_za_izmenu->tip == 'dokument') echo"selected"; ?>> Lični dokument </option>
                                    <option value="uredjaj" <?php if($izgubljeno_za_izmenu->tip == 'uredjaj') echo"selected"; ?>> Elektronski uredjaj </option>
                                    <option value="ostalo" <?php if($izgubljeno_za_izmenu->tip == 'ostalo') echo"selected"; ?>> Ostalo </option>
                                </select>
				</div>
                                
                                <div class="form_label">Unesite lokaciju:</div>
                                <div class="control-group">
                                    <input type="text" class="login-field" name="lokacija" value="<?php print $izgubljeno_za_izmenu->mesto ?>">
				</div>
                                
                                <div class="form_label">Unesite datum:</div>
                                <div class="control-group">
                                    <input type="date" class="login-field" name="datum" value="<?php print $izgubljeno_za_izmenu->datum ?>">
				</div>
                                
                                <div class="form_label">Unesite nagradu (opciono):</div>
                                <div class="control-group">
                                   <input type="text" class="login-field" name="nagrada" value="<?php print $izgubljeno_za_izmenu->nagrada ?>">
				</div>
                                
           
                            <input type="submit" class="btn btn_dodaj_izgubljeno" value="Izmeni" name="izmeniIzgubljeno">

			</div>
                    </form>
		</div>
            <?php } else { ?>
            <div class="login-screen">
			<div class="form-title dodaj_izgubljeno_title">
				<h1>Prijavi izgubljenu stvar</h1>
			</div>
                    <form action="" method="post">
			<div class="login-form">
		
                                <input type="hidden" name="dodaj_hdn">
                            
                                <div class="form_label">Naziv izgubljene stvari:</div>
                                <div class="control-group">
                                <input type="text" class="login-field" name="naziv" value="">
				</div>
                                
                                <div class="form_label">Izaberite tip izgubljene stvari:</div>
				<div class="control-group">
				<select class="select_forma" name="tip" size="1">
                                    <option value=""></option>
                                    <option value="zivotinja"> Životinja </option>
                                    <option value="dokument"> Lični dokument </option>
                                    <option value="uredjaj"> Elektronski uredjaj </option>
                                    <option value="ostalo"> Ostalo </option>
                                </select>
				</div>
                                
                                <div class="form_label">Unesite lokaciju:</div>
                                <div class="control-group">
                                    <input type="text" class="login-field" name="lokacija" value="">
				</div>
                                
                                <div class="form_label">Unesite datum:</div>
                                <div class="control-group">
                                    <input type="date" class="login-field" name="datum" value="">
				</div>
                                
                                <div class="form_label">Unesite nagradu (opciono):</div>
                                <div class="control-group">
                                   <input type="text" class="login-field" name="nagrada" value="">
				</div>
                                
           
                            <input type="submit" class="btn btn_dodaj_izgubljeno" value="Potvrdi" name="dodajIzgubljeno">

			</div>
                    </form>
		</div>
            <?php }?>
	</div>
    </div>   
    
    
    <footer>
        RAmBO © 2017 | All rights reserved.
    </footer>

</body>
</html>

