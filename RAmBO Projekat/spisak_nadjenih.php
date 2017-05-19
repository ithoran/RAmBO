<?php

session_start();

?>

<html>
<head>
    <link rel="stylesheet" type="text/css" href="css/style_main.css?version=1">
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
        <?php 
            if (isset($_SESSION['login_user'])){
               include("elementi/logout_btn.php");
        ?>
        <div class="header_username">
            <?php print($_SESSION['login_user']) ?>
        </div>
        
        <?php
            }else{
            include("elementi/login_btn.php"); 
            include("elementi/register_btn.php"); 
        }
        ?>
    </header>
   
    <div id="main"> 

        
    </div>   
    
    
    <footer>
        RAmBO © 2017 | All rights reserved.
    </footer>

</body>
</html>



