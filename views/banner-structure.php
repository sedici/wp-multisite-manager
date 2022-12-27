
<style>
     <?php echo get_site_option('header_css'); ?>
</style>
<div class="banner-container">
<div class="row">
    <div class="column">   
        <h1 style="margin-left:10vh" class="header-title"> <?php echo get_site_option('title_text'); ?> </h1>
    </div>

    <div class="column"> 
        <img src="<?php echo wp_get_attachment_url(get_site_option('image')) ; ?>"></img>
    </div>
</div>

</div>


