<h1>Footer</h1>



<p class="comments-about-section"> <?php _e("En esta sección usted podrá editar partes del footer global que desea mostrar
    a lo largo de todo su multisitio."); ?> </p>

<hr>


<form method="POST" action="edit.php?action=footer_update_network_options" enctype=multipart/form-data>
    <?php settings_fields( 'footer_settings' ); ?>
    <?php do_settings_sections( 'footer_settings' ); ?>
<div>
<div class="general-form-field">
        <h2 class="filds-titles"> <?php _e("Habilitado"); ?> </h2>
        <input type="checkbox" name="footer_enabled" value=1   <?php checked(get_site_option('footer_enabled')); ?> />
    </div>
    
    <!-- Redes sociales -->
    <div class="general-form-field">

        <h2 class="filds-titles"> <?php _e("Links de redes sociales"); ?> </h2>
        <label for="footer_fb"> <?php _e("Enlace de Facebook"); ?>  </label>
        <input type="url" name="footer_fb" value=<?php getValue('footer_fb')?> >
        <br><br>

        <label for="footer_tw"> <?php _e("Enlace de Twitter"); ?>  </label>
        <input type="url" name="footer_tw" value=<?php getValue('footer_tw')?>>
        <br><br>

        <label for="footer_tw"> <?php _e("Enlace de Instagram"); ?>  </label>
        <input type="url" name="footer_ig" value=<?php getValue('footer_ig')?>>
    </div>

    <!-- Contacto---------------------->

    <div class="general-form-field">
        <h2 class="filds-titles"> <?php _e("Contacto"); ?> </h2>

        <h4> <?php _e("Mail"); ?> </h4>
        <input type="email" name="footer_email" value=<?php getValue('footer_email')?> >
        <br><br>
        <h4> <?php _e("Teléfono"); ?> </h4>
        <input type="tel" name="footer_phone" value=<?php getValue('footer_phone')?> >
    </div>

    
    <!-- Texto + Logos 1 y 2 ----------->

    <div class="general-form-field">
        <h2 class="filds-titles"><?php _e("Texto y logos");?></h2>
        
        <h4 class="filds-titles"><?php _e("Texto");?></h4>

        <input type="text" name="footer_text" value=<?php getValue('footer_text')?> >
    </div>
    

    <div class="general-form-field">
        <h4 class="filds-titles"><?php _e("Enlace del texto");?></h4>

        <input type="url" name="footer_text_link" value=<?php getValue('footer_text_link') ?> >
    <div>

    

    <div class="general-form-field">
        <h4 class="filds-titles"><?php _e("Imagen logo 1");?></h4>
        <input type="file" name="footer_logo_1" value=<?php getValue('footer_logo_1')?>>
    </div>

    <div class="general-form-field">
        <h4 class="filds-titles"><?php _e("Enlace del logo 1 ");?></h4>
        <input type="url" name="footer_logo_link_1" value=<?php getValue('footer_logo_link_1')?>>
    </div>

    <div class="general-form-field">
        <h4 class="filds-titles"><?php _e("Imagen logo 2");?></h4>
        <input type="file" name="footer_logo_2" value=<?php getValue('footer_logo_2')?>>
    </div>

    <div class="general-form-field">
        <h4 class="filds-titles"><?php _e("Enlace del logo 2 ");?></h4>
        <input type="url" name="footer_logo_link_2" value=<?php getValue('footer_logo_link_2')?>>
    </div>

    
    <div class="general-form-field">
        <h2 class="filds-titles"> <?php _e("CSS del header"); ?> </h2>
        <textarea name="footer_css" value=""><?php echo esc_attr( get_site_option('footer_css')); ?></textarea>
    </div>
    
    <h3 style="font-weight:bold"><?php _e("Referencias de clases CSS"); ?> </h3>
    <ul>
        <li> <span style="font-weight:bold"> footer-container: </span> <?php _e("esta clase envuelve todo el footer. (Aquí se pueden poner los colores de fondo)");?> </li>
        <li> <span style="font-weight:bold"> footer_column: </span> <?php _e("esta clase maneja las 3 columnas del footer"); ?> </li>
        <li> <span style="font-weight:bold"> footer-image: </span> <?php _e("esta clase maneja las imagenes del footer"); ?> </li>
        <li> <span style="font-weight:bold"> contact-text: </span> <?php _e("esta clase maneja el texto de la información de contacto"); ?> </li>
        <li> <span style="font-weight:bold"> contact-container: </span> <?php _e("esta clase maneja el contenedor de la información de contacto"); ?> </li>
        <li> <span style="font-weight:bold"> media-icon: </span> <?php _e("esta clase maneja los logos de las redes sociales"); ?> </li>
        <li> <span style="font-weight:bold"> media-container: </span> <?php _e("esta clase maneja el contenedor de las redes sociales"); ?> </li>
    </ul>


    <?php submit_button(); ?>

     

</div>
</form>

<hr>

<?php

function getValue($field){
    echo '"' . esc_attr(get_site_option($field)) . '"';
}

?>