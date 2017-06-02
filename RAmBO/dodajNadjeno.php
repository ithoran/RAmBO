<?php

 include_once 'lib.php';
 include_once 'klase/nadjeno.php';
   
   session_start();
  
   if(isset($_GET['naziv_izmena'])){
       
       $nadjeno_za_izmenu = vrati_objavu($_GET['naziv_izmena'], $_GET['korisnik_izmena'], 0);
       if(isset($_POST['izmeni_hdn'])) {
              
        $naziv = $_POST['naziv'];
        $tip = $_POST['tip']; 
        $lokacija = $_POST['lokacija'];
        $datum = $_POST['datum'];
        $korisnik = $_SESSION['login_user'];
        
        if ($naziv != "" && $tip != NULL && $lokacija != "" && $datum != NULL){
            $nadjeno = new Nadjeno($naziv, $tip, $lokacija, $datum, $korisnik);
            izmeni_nadjeno($nadjeno_za_izmenu, $nadjeno);
            header("location: index.php");
      }else {
         $error = "Pogresni podaci";
      }
           }
   }
   
   else{
   if(isset($_POST['dodaj_hdn']) && isset($_POST['tip'])) {
      
      $naziv = $_POST['naziv'];
      $tip = $_POST['tip']; 
      $lokacija = $_POST['lokacija'];
      $datum = $_POST['datum'];
      $korisnik = $_SESSION['login_user'];
      
      if ($naziv != "" && $tip != NULL && $lokacija != "" && $datum != NULL){
        $nadjeno = new Nadjeno($naziv, $tip, $lokacija, $datum, $korisnik);
        dodaj_nadjeno($nadjeno);
        header("location: index.php");
      }else {
         $error = "Pogresni podaci";
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
        <div style="height:50px; background-color: transparent"></div>
        <div class="login">
            
            <?php if(isset($_GET['naziv_izmena'])){ ?>
		<div class="login-screen">
			<div class="form-title dodaj_nadjeno_title">
				<h1>Izmeni informacije o nadjenoj stvari</h1>
			</div>
                    <form action="" method="post">
			<div class="login-form">
                                <input type="hidden" name="izmeni_hdn">
                            
                                <div class="form_label">Naziv nadjene stvari:</div>
                                <div class="control-group">
                                <input type="text" class="login-field" name="naziv" value="<?php print $nadjeno_za_izmenu->naziv ?>">
				</div>
                                
                                <div class="form_label">Izaberite tip nadjene stvari:</div>
				<div class="control-group">
				<select class="select_forma" name="tip" size="1">
                                    <option value="zivotinja" <?php if($nadjeno_za_izmenu->tip == 'zivotinja') echo"selected"; ?>> Životinja </option>
                                    <option value="dokument" <?php if($nadjeno_za_izmenu->tip == 'dokument') echo"selected"; ?>> Lični dokument </option>
                                    <option value="uredjaj" <?php if($nadjeno_za_izmenu->tip == 'uredjaj') echo"selected"; ?>> Elektronski uredjaj </option>
                                    <option value="ostalo" <?php if($nadjeno_za_izmenu->tip == 'ostalo') echo"selected"; ?>> Ostalo </option>
                                </select>    
				</div>
                                
                                <div class="form_label">Unesite lokaciju:</div>
                                <div class="control-group">
                                    <input type="text" class="login-field" name="lokacija" value="<?php print $nadjeno_za_izmenu->mesto ?>">
				</div>
                                
                                <div class="form_label">Unesite datum:</div>
                                <div class="control-group">
                                    <input type="date" class="login-field" name="datum" value="<?php print $nadjeno_za_izmenu->datum ?>">
				</div>
                                
           
                            <input type="submit" class="btn" value="Izmeni" name="dodajNadjeno">
                   </div>
                    </form>
		</div>
             <?php } else { ?>
            <div class="login-screen">
			<div class="form-title dodaj_nadjeno_title">
				<h1>Prijavi nadjenu stvar</h1>
			</div>
                    <form action="" method="post">
			<div class="login-form">
                                <input type="hidden" name="dodaj_hdn">
                            
                                <div class="form_label">Naziv nadjene stvari:</div>
                                <div class="control-group">
                                <input type="text" class="login-field" name="naziv" value="">
				</div>
                                
                                <div class="form_label">Izaberite tip nadjene stvari:</div>
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
                                
           
                            <input type="submit" class="btn" value="Potvrdi" name="dodajNadjeno">
                   </div>
                    </form>
		</div>
             <?php } ?>
	</div>
    </div>   
    
    
    <footer>
        RAmBO © 2017 | All rights reserved.
    </footer>

</body>
</html>