<h1>Carrousel</h1>



<p class="comments-about-section"> <?php _e("En esta sección usted podrá editar el css del Carrousel."); ?> </p>

<hr>


<form method="POST" action="edit.php?action=carrousel_update_network_options" >
    <?php settings_fields( 'carrousel_settings' ); ?>
    <?php do_settings_sections( 'carrousel_settings' ); ?>
<div>

    
    <div class="general-form-field">
        <h2 class="filds-titles"> <?php _e("CSS personalizado"); ?> </h2>
        <textarea name="carrousel_css" value=""><?php echo esc_attr( get_site_option('carrousel_css')); ?></textarea>
    </div>
    
    <h3 style="font-weight:bold"><?php _e("Referencias de clases CSS"); ?> </h3>
    <ul>
        <li> <span style="font-weight:bold"> swiper: </span> <?php _e("esta clase contiene todo el carrousel, desde aca se puede manejar el ancho, alto, color de fondo, etc.");?> </li>
        <li> <span style="font-weight:bold"> carrousel-box: </span> <?php _e("esta clase maneja cada caja individual del carrousel"); ?> </li>
        <li> <span style="font-weight:bold"> carrousel-title: </span> <?php _e("esta clase maneja los títulos dentro del carrousel"); ?> </li>
        <li> <span style="font-weight:bold"> carrousel-image: </span> <?php _e("esta clase maneja cada imagen dentro del carrousel"); ?> </li>
        <li> <span style="font-weight:bold"> swiper-button-next: </span> <?php _e("esta clase maneja la flecha para pasar a la siguiente sección"); ?> </li>
        <li> <span style="font-weight:bold"> swiper-button-prev: </span> <?php _e("esta clase maneja la flecha para pasar a la sección previa"); ?> </li>

    </ul>


    <?php submit_button(); ?>

     

</div>
</form>

<hr>
