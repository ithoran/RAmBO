<header>
        <a href="index.php">
        <h1 id="glavniNaslov">RAmBO <span id="lost">Lost</span>&<span id="found" >Found</span></h1>
        </a>
        <?php 
            if (isset($_SESSION['login_user'])){
               include("elementi/logout_btn.php");
               if ($_SESSION['f_admin'] == 1){
                   include("elementi/lista_clanova_btn.php"); ?>
        
                        <div class="header_username">
                            <span style="font-size: 20px;"> Administrator:</span> <?php print($_SESSION['login_user']) ?>
                        </div>
        <?php     
               }
               else{
        ?>
        
        <div class="header_username">
            <a href="profil_clana.php">
            <?php print($_SESSION['login_user']) ?>
            </a>
    
        </div>
        
        <?php
        }}else{
            include("elementi/login_btn.php"); 
            include("elementi/register_btn.php"); 
        }
        ?>
</header>
