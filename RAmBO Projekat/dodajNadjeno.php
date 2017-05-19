<html>
<head>
    <link rel="stylesheet" type="text/css" href="css/style_main.css?version=1">
    <link rel="stylesheet" href="css/style_forme.css?version=1">
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
		<div class="login-screen">
			<div class="app-title dodaj_nadjeno_title">
				<h1>Prijavi nadjenu stvar</h1>
			</div>
                    <form action="index.php" method="post">
			<div class="login-form">
				<div class="control-group">
				<input type="text" class="login-field" name="naziv" value="" placeholder="naziv nadjene stvari">
				</div>

				<div class="control-group">
				<select name="tip_izgubljenog" size="1">
                                    <option value="" disabled selected hidden style="color: gray">Izaberite tip nadjene stvari</option>
                                    <option value="zivotinja"> Životinja </option>
                                    <option value="dokument"> Lični dokument </option>
                                    <option value="uredjaj"> Elektronski uredjaj </option>
                                    <option value="ostalo"> Ostalo </option>
                                </select>
				</div>
                            
                                <div class="control-group">
				<input type="text" class="login-field" name="lokacija" value="" placeholder="unesite lokaciju">
				</div>
                            
                                <div class="control-group">
				<input type="date" class="login-field" name="datum" value="" placeholder="unesite datum">
				</div>
                                
           
                            <input type="submit" class="btn" value="Potvrdi" name="dodajNadjeno">
                   </div>
                    </form>
		</div>
	</div>
    </div>   
    
    
    <footer>
        RAmBO © 2017 | All rights reserved.
    </footer>

</body>
</html>