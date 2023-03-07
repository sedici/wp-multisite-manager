
<style>
     <?php echo get_site_option('header_css'); ?>
</style>
<div class="header-container">
    <div class="header-col1 header-column">   
        <h1  class="header-title">  
            <a href="<?php echo get_site_option('title_link'); ?> "> <?php echo get_site_option('title_text'); ?> </a>
        </h1>
    </div>

    <div class="header-col2 header-column"> 

       <?php echo $data->logos;?>

    </div>
</div>

</div>


