<?php
   include_once 'lib.php';
   
   session_start();
   
   if(isset($_POST['register_hdn'])) {
      
      $myusername = $_POST['username'];
      $mypassword = $_POST['password'];
      $mypassword2 = $_POST['password2'];
      $myemail = $_POST['email'];
      	
      $count = check_username($myusername);
      
      if($count == 0 && $mypassword==$mypassword2 && $mypassword!="" && $myusername!="" && $myemail!="") {
         register($myusername, $mypassword, $myemail);
         
         header("location: login.php");
      }else {
         $error = "Neuspesna registracija";
      }
   }
?>

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
			<div class="app-title">
				<h1>Registracija</h1>
			</div>
                    <form action="" method="post">
			<div class="login-form">
                            <input type="hidden" name="register_hdn">
                                <div class="control-group">
				<input type="text" class="login-field" name="username" value="" placeholder="unesite korisničko ime">
				</div>

				<div class="control-group">
				<input type="password" class="login-field" name="password" value="" placeholder="unesite lozinku">
				</div>
                            
                                <div class="control-group">
				<input type="password" class="login-field" name="password2" value="" placeholder="potvrdite lozinku">
				</div>
                            
                                <div class="control-group">
				<input type="text" class="login-field" name="email" value="" placeholder="unesite e-mail adresu">
				</div>
                            
                                
                            <input type="submit" class="btn btn_reg" value="Registruj se" name="register">

			</div>
                    </form>
		</div>
	</div>
    </div>   
    
    
    <footer id="footer">
        RAmBO © 2017 | All rights reserved.
    </footer>

</body>
</html>
