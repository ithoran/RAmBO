<?php
   include_once 'lib.php';
   
   session_start();
   $error = "";
   if(isset($_POST['login_hdn'])) {
      
      $myusername = $_POST['username'];
      $mypassword = $_POST['password']; 
      	
      $res = login($myusername, $mypassword);
      
      if($res->count == 1) {
         $_SESSION['login_user'] = $myusername;
         $_SESSION['f_admin'] = $res->f_admin;
         header("location: index.php");
      }else {
         $error = "Pogresni podaci za login.";
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
		<div class="login-screen">
			<div class="form-title">
				<h1>Prijava</h1>
			</div>
                    <form action="login.php" method="post">
                        <input type="hidden" name="login_hdn">
			<div class="login-form">
				<div class="control-group">
				<input type="text" class="login-field" name="username" value="" placeholder="korisničko ime">

				</div>

				<div class="control-group error_message">
				<input type="password" class="login-field" name="password" value="" placeholder="lozinka">

				</div>
                            <div class="error_message">
                            <?php print("$error"); ?>
                            </div>
                            <input type="submit" class="btn" value="Prijavi se" name="login_submit">

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

