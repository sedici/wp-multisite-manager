
<style>
     <?php echo get_site_option('header_css'); ?>
</style>
<div class="header-container">
<div class="row">
    <div class="col1 column">   
        <h1 style="margin-left:10vh" class="header-title">  
            <a href="<?php echo get_site_option('title_link'); ?> "> <?php echo get_site_option('title_text'); ?> </a>
        </h1>
    </div>

    <div class="col2 column"> 
        <?php
            if( null !== get_site_option('image')){
        ?>
        <a href="<?php echo get_site_option('image_link') ; ?>">
            <img class="header-image" src="<?php echo  wp_get_attachment_url(get_site_option('image_link')); ?>"></img>
    </a>
        <?php } ?>
    </div>
</div>

</div>


