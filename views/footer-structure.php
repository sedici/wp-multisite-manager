
<style>
     <?php echo get_site_option('footer_css'); ?>
</style>
<div class="footer-container">
<div class="row">



    <div class="contact-container footer_column">   
       <?php print_contacto(); ?>
    </div>

    <div class="col2 footer_column"> 
        <h1 style="margin-left:2vh" class="header-title">  
            <a href="<?php echo get_site_option('footer_text_link'); ?> "> <?php echo get_site_option('footer_text'); ?> </a>
        </h1>
        <div class="media-container">
            <?php print_media() ?>
        </div>
        <?php
            if( get_site_option('image') != ""){
        ?>
      
        <?php } ?>
    </div>

    <div class="footer_column">
       <?php print_logos(); ?>
    </div>


</div>

</div>


<?php

// Helper functions

function exist($field){
    return "" !== get_site_option($field);
}

function print_media(){
    if(exist('footer_fb')){
        echo '<a href="' . get_site_option('footer_fb').'"><img class="media-icon" src="' . plugins_url() . '/wp-multisite-manager/assets/facebook.png" width="32" height="32"></a>';
    }
    if(exist('footer_ig')){
        echo '<a href="' . get_site_option('footer_ig').'"><img class="media-icon" src="' . plugins_url() . '/wp-multisite-manager/assets/instagram.png" width="32" height="32"></a>';
    }
    if(exist('footer_tw')){
        echo '<a href="' . get_site_option('footer_tw').'"><img class="media-icon" src="' . plugins_url() . '/wp-multisite-manager/assets/twitter.png" width="32" height="32"></a>';
    }

}

function print_contacto(){
    $section ="<p class='contact-text'>";
    if (exist('footer_phone')){
        $section= $section . get_site_option('footer_phone');
    }
    if (exist('footer_email')){
        $section= $section ." | ". get_site_option('footer_email');
    }

    echo $section . "</p>";
}

function print_logos(){
    $section ="";
    if(get_site_option('footer_logo_1') != ""){
       $section= $section. '<a href="' .  get_site_option('footer_logo_link_1') . '">
            <img class="footer-image" src="' . wp_get_attachment_url(get_site_option('footer_logo_1')) . '"></img>
        </a>';
    }
    if(get_site_option('footer_logo_2') != ""){
        $section= $section. '<a href="' .  get_site_option('footer_logo_link_2') . '">
             <img class="footer-image" src="' . wp_get_attachment_url(get_site_option('footer_logo_2')) . '"></img>
         </a>';
     }
     echo $section;
}

?>