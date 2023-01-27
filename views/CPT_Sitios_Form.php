
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
        <h4> <?php _e("Ingrese unas screenshot del sitio") ?> <h4>
        <input type='file' name="site_screenshot[]" > </input>
    </div>



</form>