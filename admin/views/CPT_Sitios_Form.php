
<form action="" enctype="multipart/form-data" method="POST">

<?php
    function get_post_info($input){
        $post_id = get_the_ID();
        return get_post_meta($post_id, $input,true);
    }
?>
<!--
    <div>
        <h4> <?php _e("Ingrese nombre del sitio") ?> <h4>
        <input type='text' name="site_title"> </input>
    </div>
-->
    <div>
        <h4> <?php _e("Ingrese URL del sitio") ?> <h4>
        <input type='url' name="site_url" value=<?php echo get_post_info('site_url')?> > </input>
    </div>

    <div>
        <h4> <?php _e("Ingrese una descripción") ?> <h4>
        <input type='text' name="site_description" value=<?php echo get_post_info('site_description')?>> </input>
    </div>

    <div>
        <h4> <?php _e("Ingrese una screenshot del sitio") ?> <h4>
        <input type='file' name="site_screenshot" > </input>

    </div>
    <?php
            $image = get_post_info('site_screenshot');
            if(!is_wp_error($image)){
        ?>
        <p style="font-weight:bold"> Screenshot actual </p> 
            <img class="header-image" style="max-height:25vh; border:5px solid black; border-radius:5px" src="<?php echo  wp_get_attachment_url(get_post_info('site_screenshot')); ?>"></img>
        <?php 
        } 
    ?>



</form>