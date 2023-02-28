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
        <li> <span style="font-weight:bold"> footer-container: </span> <?php _e("esta clase envuelve todo el footer. (Aquí se pueden poner los colores de fondo)");?> </li>
        <li> <span style="font-weight:bold"> footer_column: </span> <?php _e("esta clase maneja las 3 columnas del footer"); ?> </li>
    </ul>


    <?php submit_button(); ?>

     

</div>
</form>

<hr>
