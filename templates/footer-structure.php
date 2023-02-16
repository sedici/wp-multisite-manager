
<style>
     <?php echo get_site_option('footer_css'); ?>
</style>
<div class="footer-container">


    <!-- FIRST COLUMN -->
    <div class="contact-container footer_column">   
       <?php print_contacto(); ?>
    </div>

    <!-- SECOND COLUMN -->
    <div class="col2 footer_column"> 
            <h1  class="footer-title">  
                <a href="<?php echo get_site_option('footer_text_link'); ?> "> <?php echo get_site_option('footer_text'); ?> </a>
            </h1>
        <div class="media-container">
            <?php print_media() ?>
        </div>
    </div>

    <!-- THIRD COLUMN -->
    <div class="footer_column footer-image-container">
       <? echo $data->logos; ?>
    </div>



</div>


<?php

// Helper functions

function exist($field){
    return "" !== get_site_option($field);
}

function print_media(){
    if(exist('footer_fb')){
        echo '<a href="' . get_site_option('footer_fb').'"><img class="media-icon" src="' . plugins_url() . '/wp-multisite-manager/assets/facebook.png" width="28" height="28"></a>';
    }
    if(exist('footer_ig')){
        echo '<a href="' . get_site_option('footer_ig').'"><img class="media-icon" src="' . plugins_url() . '/wp-multisite-manager/assets/instagram.png" width="28" height="28"></a>';
    }
    if(exist('footer_tw')){
        echo '<a href="' . get_site_option('footer_tw').'"><img class="media-icon" src="' . plugins_url() . '/wp-multisite-manager/assets/twitter.png" width="28" height="28"></a>';
    }

}

function print_contacto(){
    $section ="<p class='contact-text'>";
    if (exist('footer_phone')){
        $section= $section . "<p>" . get_site_option('footer_phone') . "</p>";
    }
    if (exist('footer_email')){
        $section= $section . "<p>" . get_site_option('footer_email') . "</p>";
    }

    echo $section . "</p>";
}

function print_logos(){
    switch_to_blog(1);
    $section = "";
    $image_1= get_site_option('footer_logo_1');
    $image_2= get_site_option('footer_logo_2');
    if( !is_wp_error($image_1)){
       $section= $section. '<a href="' .  get_site_option('footer_logo_link_1') . '">
            <img class="footer-image" src="' . wp_get_attachment_url(get_site_option('footer_logo_1')) . '"></img>
        </a>';
    }
    if(!is_wp_error($image_2)){
        $section= $section. '<a href="' .  get_site_option('footer_logo_link_2') . '">
             <img class="footer-image" src="' . wp_get_attachment_url(get_site_option('footer_logo_2')) . '"></img>
         </a>';
     }
     restore_current_blog();
     echo $section;
}

?>