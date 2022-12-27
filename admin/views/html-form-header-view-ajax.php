<h1>Header</h1>

<p class="comments-about-section"> <?php _e("En esta sección usted podrá editar partes del header global que desea mostrar
    a lo largo de todo su multisitio.",'wp-multisite-manager'); ?> </p>

<hr>
   
<!-- Falta agregar atributos name a los elementos del formulario -->
<form method="POST"  action="edit.php?action=header_update_network_options" enctype=multipart/form-data>
    <?php settings_fields( 'header_settings' ); ?>
    <?php do_settings_sections( 'header_settings' ); ?>
   <h1> <?php echo get_site_option('image'); ?> </h1>
<div>
    <div class="general-form-field">
        <h2 class="filds-titles"> <?php _e("Habilitado"); ?> </h2>
        <input type="checkbox" name="enabled" value=1   <?php checked(get_site_option('enabled')); ?> />
    </div>
    <!-- Podria agregarse algun placeholder -->
    <div class="general-form-field">
        <h2 class="filds-titles"> <?php _e("Texto"); ?> </h2>
        <input type="text" name="title_text" value="<?php echo esc_attr( get_site_option('title_text') ); ?>" >
    </div>

    

    <div class="general-form-field">
    <h2 class="filds-titles"> <?php _e("Enlace del texto"); ?> </h2>
    <input name="title_link" type="text" value="<?php echo esc_attr( get_site_option('title_link') ); ?>"  >
    </div>

    <hr>

    <div class="general-form-field">
        <h2 class="filds-titles"> <?php _e("Imagen"); ?> </h2>
        <input type="file" name="image" value="<?php echo esc_attr( get_site_option('image') ); ?>" >
    </div>

    

    <div class="general-form-field">
        <h2 class="filds-titles"> <?php _e("Enlace de la imagen"); ?> </h2>
        <input type="url" name="image_link" value="<?php echo esc_attr( get_site_option('image_link') ); ?>" >
    </div>


    <div class="general-form-field">
        <h2 class="filds-titles"> <?php _e("CSS del header"); ?> </h2>
        <textarea name="header_css" value="<?php echo esc_attr( get_site_option('header_css') ); ?>"></textarea>
    </div>
    
    <span style="font-weight:bold"><?php _e("Referencias de clases CSS"); ?> </span>
    <ul>
        <li> <span style="font-weight:bold"> banner-container: </span> esta clase envuelve todo el banner. (Aquí se pueden poner los colores de fondo) </li>
        <li> <span style="font-weight:bold"> header-title: </span> esta clase maneja la etiqueta de texto </li>
    </ul>


    <?php submit_button(); ?>
     

</div>
</form>


<hr>

