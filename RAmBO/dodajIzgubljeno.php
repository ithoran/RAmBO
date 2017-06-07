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
        $opis = $_POST['opis'];
        $korisnik = $_SESSION['login_user'];
        if ($naziv != "" && $tip != NULL && $lokacija != "" && $datum != NULL){
            $izgubljeno = new Izgubljeno($naziv, $tip, $lokacija, $datum, $nagrada, $opis, $korisnik, $izgubljeno_za_izmenu->slika, $izgubljeno_za_izmenu->lat, $izgubljeno_za_izmenu->lng);
            izmeni_izgubljeno($izgubljeno_za_izmenu, $izgubljeno);
            header("location: index.php?lang=$lang");
      }else {
         $error = "Pogresni podaci";
      }
           }
       
       
   }
   
   else{
   if(isset($_POST['dodaj_hdn']) && isset($_POST['tip'])) {
      
       
     include ("upload.php");  

     
       
      $naziv = $_POST['naziv'];
      $tip = $_POST['tip']; 
      $lokacija = $_POST['lokacija'];
      $datum = $_POST['datum'];
      $nagrada = $_POST['nagrada'];
      $opis = $_POST['opis'];
      $korisnik = $_SESSION['login_user'];
      $slika = basename( $_FILES["fileToUpload"]["name"]);
      
      if (($_POST['lat']) != ""){
          
      $lat = $_POST['lat'];
      $lng = $_POST['lng'];
      }
      else{
          $lat = 0.0;
          $lng = 0.0;
      }
      
      if ($naziv != "" && $tip != NULL && $lokacija != "" && $datum != NULL){
        $izgubljeno = new Izgubljeno($naziv, $tip, $lokacija, $datum, $nagrada, $opis, $korisnik, $slika, $lat, $lng);
        dodaj_izgubljeno($izgubljeno);
       header("location: index.php?lang=$lang");
      }else {
         $error = "Pogresni podaci";
      }
   }
   }

?>


<html>
<head>
     <script type="text/javascript" src="http://maps.google.com/maps/api/js?libraries=drawing&key=AIzaSyB1fcu7wpjL0yYdF2OJqwCs2wFLcasVvMI"></script>
    <script type="text/javascript">
                    var gmapsLat;
            var gmapsLng;
            var drawingManager;

            function deleteSelectedShape () {
                gmapsLat = null;
                gmapsLng = null;
                initialize();
            }

            function initialize () {
                var map = new google.maps.Map(document.getElementById('map'), {
                    zoom: 8,
                    center: new google.maps.LatLng(44.10943599214824, 20.723862648010254),
                    mapTypeId: google.maps.MapTypeId.roadmap,
                    disableDefaultUI: true,
                    zoomControl: true,
					maxZoom: 16,
					minZoom: 8
                });

                drawingManager = new google.maps.drawing.DrawingManager({
                    markerOptions: {
                        draggable: true
                    },
                    drawingControlOptions: {
                    drawingModes: [
                    google.maps.drawing.OverlayType.MARKER
                    ]},
                    map: map
                });

                var marker = google.maps.event.addListener(drawingManager, 'overlaycomplete', function (e) {
                    var newShape = e.overlay;
                    
                    newShape.type = e.type;
                    
                    gmapsLat = newShape.position.lat();
                    gmapsLng = newShape.position.lng();
                    document.getElementById('lat').value = gmapsLat;
                    document.getElementById('lng').value = gmapsLng;
                    
                    
                    drawingManager.setDrawingMode(null);
                    // To hide:
                    drawingManager.setOptions({
                    drawingControl: false
                    });
                    
                    google.maps.event.addListener(newShape, 'dragend', function (e) {
                        gmapsLat = e.latLng.lat();
                        gmapsLng = e.latLng.lng();
                        document.getElementById('lat').value = gmapsLat;
                        document.getElementById('lng').value = gmapsLng;
                    });
                });
                
                google.maps.event.addDomListener(document.getElementById('delete-button'), 'click', deleteSelectedShape);
            }
            google.maps.event.addDomListener(window, 'load', initialize);
    </script>
    <link rel="stylesheet" type="text/css" href="css/style_main.css?version=256">
    <link rel="stylesheet" href="css/style_forme.css?version=542">
    <link rel="stylesheet" href="css/style_forme_googlemaps.css?version=113">
    <link href="https://fonts.googleapis.com/css?family=Quantico" rel="stylesheet">
  <title>RAmBO L&F</title>
</head>

<body>
    <div id="pozadina">
        
    </div>
    <div id="pozadina_filter">
        
    </div>
    
    <header>
        <a href="index.php?lang=<?php echo $lang?>">
        <h1 id="glavniNaslov">RAmBO <span id="lost">Lost</span>&<span id="found" >Found</span></h1>
        </a>
    </header>
    
    <div id="main"> 

        
	
            <?php if(isset($_GET['naziv_izmena'])){ ?>

                   
            <div class="login-dodaj">
            <div class="login-screen-dodaj">
			<div class="form-title dodaj_izgubljeno_title">
				<h1><?php echo $L_IZGIZM ?></h1>
			</div>
                    <form action="" method="post">
			<div class="login-form">
		
                            
                            <div class="form_left">
                            
                                <input type="hidden" name="izmeni_hdn">
                            
                                <div class="form_label_dodaj"><?php echo $L_IZGNAM ?>:</div>
                                <div class="control-group">
                                <input maxlength="20" type="text" class="login-field" name="naziv" value="<?php print $izgubljeno_za_izmenu->naziv ?>">

				</div>
                                
                                <div class="form_label_dodaj"><?php echo $L_TIP ?>:</div>
				<div class="control-group">
				<select class="select_forma" name="tip" size="1">
                                    <option value="zivotinja" <?php if($izgubljeno_za_izmenu->tip == 'zivotinja') echo"selected"; ?>> <?php echo $L_ZIV ?> </option>
                                    <option value="dokument" <?php if($izgubljeno_za_izmenu->tip == 'dokument') echo"selected"; ?>> <?php echo $L_DOK ?> </option>
                                    <option value="uredjaj" <?php if($izgubljeno_za_izmenu->tip == 'uredjaj') echo"selected"; ?>> <?php echo $L_ELU ?> </option>
                                    <option value="ostalo" <?php if($izgubljeno_za_izmenu->tip == 'ostalo') echo"selected"; ?>> <?php echo $L_OST ?> </option>
                                </select>
				</div>
                                
                              
                                                 <div class="form_label_dodaj"><?php echo $L_DATUM ?></div>
                                <div class="control-group">
                                    <input id="date" name="datum"  data-format="YYYY-MM-DD" data-template="D MMM YYYY" type="text"  class="login-field" value="<?php print $izgubljeno_za_izmenu->mesto ?>"> 
                                    <script>
                                      $('#date').combodate({
                                            minYear: 1975,
                                            maxYear: 2017
                                        });   
                                    </script>
				</div>
                                
                            </div>   
                                
                            <div class="form_right">
                                
                                
               
                                  <div class="form_label_dodaj"><?php echo $L_LOK ?></div>
                                <div class="control-group">
                                    <input maxlength="20" type="text" class="login-field" name="lokacija" value="<?php print $izgubljeno_za_izmenu->mesto ?>">
				</div>
                                
                                <div class="form_label_dodaj"><?php echo $L_NAGUNOS ?></div>
                                <div class="control-group">
                                   <input maxlength="20" type="text" class="login-field" name="nagrada" value="<?php print $izgubljeno_za_izmenu->nagrada ?>">
				</div>
           
                            
                            </div>
                            
                            <div class='clear'></div>
                            <div class="form_label_dodaj"><?php echo $L_OPIS ?></div>
                            <div class="opis_txtbox">
                    
                            <textarea class="opis_txt" wrap="soft" name="opis" maxlength="150"><?php print $izgubljeno_za_izmenu->opis ?></textarea>
                    
                            </div>
 
                            <input type="submit" class="btn btn_dodaj_izgubljeno" value='<?php echo $L_IZM ?>' name="izmeniIzgubljeno">
			</div>
                    </form>
		</div>
            </div>
       
            
            
            
            <?php } else { ?>
       
    
    
    
    <div class="login-dodaj">
            <div class="login-screen-dodaj">
			<div class="form-title dodaj_izgubljeno_title">
				<h1><?php echo $L_IZGREP ?></h1>
			</div>
                    <form action="" method="post" enctype="multipart/form-data">
			<div class="login-form">
		
                            
                            <div class="form_left">
                            
                                <input type="hidden" name="dodaj_hdn">
                            
                                <div class="form_label_dodaj"><?php echo $L_IZGNAM ?>:</div>
                                <div class="control-group">
                                <input maxlength="20" type="text" class="login-field" name="naziv" value="">

				</div>
                                
                                <div class="form_label_dodaj"><?php echo $L_TIP ?>:</div>
				<div class="control-group">
				<select class="select_forma" name="tip" size="1">
                                    <option value=""></option>
                                    <option value="zivotinja"> <?php echo $L_ZIV ?> </option>
                                    <option value="dokument"> <?php echo $L_DOK ?> </option>
                                    <option value="uredjaj"> <?php echo $L_ELU ?> </option>
                                    <option value="ostalo"> <?php echo $L_OST ?> </option>
                                </select>
				</div>
                                
                              
                                                 <div class="form_label_dodaj"><?php echo $L_DATUM ?></div>
                                <div class="control-group">
                                    <input id="date" name="datum"  data-format="YYYY-MM-DD" data-template="D MMM YYYY" type="text"  class="login-field" value="<?php echo date('Y-m-d'); ?>"> 
                                    <script>
                                      $('#date').combodate({
                                            minYear: 1975,
                                            maxYear: 2017
                                        });   
                                    </script>
				</div>
                                
                            </div>   
                                
                            <div class="form_right">
                                
                                
               
                                  <div class="form_label_dodaj"><?php echo $L_LOK ?></div>
                                <div class="control-group">
                                    <input maxlength="20" type="text" class="login-field" name="lokacija" value="">
				</div>
                                
                                <div class="form_label_dodaj"><?php echo $L_NAGUNOS ?></div>
                                <div class="control-group">
                                   <input maxlength="20" type="text" class="login-field" name="nagrada" value="">
				</div>
                                
                                <div class="form_label_dodaj"><?php echo $L_IZABERISLIKU ?></div>
                                <input type="file" class="login-field" name="fileToUpload" id="fileToUpload">
                                <input type="hidden" name="upload_image>">
           
                            
                            </div>
                            
                            <div class='clear'></div>
                            <div class="form_label_dodaj"><?php echo $L_OPIS ?></div>
                            <div class="opis_txtbox">
                    
                            <textarea class="opis_txt" wrap="soft" name="opis" maxlength="150"></textarea>
                    
                            </div>
                            
                            <div id="map"></div>
                            
                            <input type="hidden" id="lat" value="" name="lat">
                            <input type="hidden" id="lng" value="" name="lng">
                            
                            <input type="submit" class="btn btn_dodaj_izgubljeno" value='<?php echo $L_CNF ?>' name="dodajIzgubljeno">
			</div>
                    </form>
		</div>
            </div>
            <?php }?>
	
    </div>
    
    
    <footer>
        RAmBO © 2017 | All rights reserved.
    </footer>

</body>
</html>

