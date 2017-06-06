<header>
        <a href="index.php?lang=<?php echo $lang?>">
        <h1 id="glavniNaslov">RAmBO <span id="lost">Lost</span>&<span id="found" >Found</span></h1>
        </a>
        
    <form class="zastava" action="" method="post">
        <input type="hidden" name="lang" value="srb">
        <input type="submit" name="lang_submit" value="" class="btn_jezik_srb">
    </form>
    <form class="zastava" action="" method="post">
        <input type="hidden" name="lang" value="eng">
        <input type="submit" name="lang_submit" value="" class="btn_jezik_eng">
    </form>
        
    
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
        
                   $count = proveri_poruke($_SESSION['login_user']);           
        ?>
       
        <?php if($count > 0){?>        
    
    <a href="inbox.php?lang=<?php echo $lang?>">
        <div class="header_right new_message_icon">
        </div>
        </a>
    <div class="header_right_broj">
        <?php echo $count; ?>
        </div>    
        <?php } else{?>
    <a href="inbox.php?lang=<?php echo $lang?>">
        <div class="header_right message_icon">
        </div>
        </a>
        <?php }?>
        
        
    
        <div class="header_username">
            <a href="profil_clana.php?lang=<?php echo $lang?>">
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
