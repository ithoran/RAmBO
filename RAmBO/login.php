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
   
   session_start();
   $error = "";
   if(isset($_POST['login_hdn'])) {
      
      $myusername = $_POST['username'];
      $mypassword = $_POST['password']; 
      	
      $res = login($myusername, $mypassword);
      
      if($res->count == 1) {
         $_SESSION['login_user'] = $myusername;
         $_SESSION['f_admin'] = $res->f_admin;
         header("location: index.php?lang=$lang");
      }else {
         $error = "Pogresni podaci za login.";
      }
   }
?>




<html>
<head>
    <link rel="stylesheet" type="text/css" href="css/style_main.css?version=159">
    <link rel="stylesheet" href="css/style_forme.css?version=29">
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
        <div style="height:50px; background-color: transparent"></div>
        <div class="login">
		<div class="login-screen">
			<div class="form-title">
				<h1><?php echo $L_LOG ?></h1>
			</div>
                    <form action="login.php?lang=<?php echo $lang?>" method="post">
                        <input type="hidden" name="login_hdn">
			<div class="login-form">
				<div class="control-group">
				<input type="text" class="login-field" name="username" value="" placeholder="<?php echo $L_UNAM ?>">

				</div>

				<div class="control-group error_message">
				<input type="password" class="login-field" name="password" value="" placeholder="<?php echo $L_PASS ?>">

				</div>
                            <a href="register.php?lang=$lang">
                                <div class="nemate_nalog">
                                    <?php echo $L_NEMATENALOG ?>
                                </div>
                            </a>
                            <div class="error_message">
                            <?php print("$error"); ?>
                            </div>
                            <input type="submit" class="btn" value="<?php echo $L_LOGSE ?>" name="login_submit">

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

