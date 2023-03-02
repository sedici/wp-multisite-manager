<h1>Formulario del header</h1>

<p class="comments-about-section"> <?php _e("En esta sección usted podrá editar partes del header global que desea mostrar
    a lo largo de todo su multisitio.",'wp-multisite-manager'); ?> </p>

<hr>
   
<!-- Falta agregar atributos name a los elementos del formulario -->
<form method="POST"  action="edit.php?action=header_update_network_options" enctype=multipart/form-data>
    <?php settings_fields( 'header_settings' ); ?>
    <?php do_settings_sections( 'header_settings' ); ?>
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

    <div id="images-container">

    <div class="general-form-field">
    <h2 class="filds-titles"> <?php _e("Enlace del texto"); ?> </h2>
    <input name="title_link" type="text" value="<?php echo esc_attr( get_site_option('title_link') ); ?>"  >
    </div>

    <hr> 

    <h1 class="section-heading"> <?php _e("Sección de imágenes a mostrar en el header") ?></h1>
    <br></br>
    <h2 style="font-size:x-large"> Editar imágenes actuales </h2>
    <?php $this->print_option_images('header_images'); ?>

    <br></br>

    <h2 style="font-size:x-large"> Agregar imágenes al Header </h2>
    <div class="general-form-field image-row">
        <div>
            <h2 class="filds-titles"> <?php _e("Subir imagen"); ?> </h2>
            <input type="file" name="image" >
        </div>
        <div>
            <h2 class="filds-titles"> <?php _e("Link asociado a la imagen"); ?> </h2>
            <input type="url" name="image_link" >
        </div>
    </div>

</div>

<div class="button-containers"">

    <button id="add-img-input" type="button" class="add-btn" value=1 > Agregar imagen </button>
    <button id="delete-img-input" type="button" class="delete-btn" value=0 > Eliminar imagen </button>

</div>


<hr>
    <h1 class="section-heading"> <?php _e("Sección de CSS") ?></h1>

    <div class="general-form-field">
        <h2 class="filds-titles"> <?php _e("CSS del header"); ?> </h2>
        <textarea name="header_css" value=""><?php echo esc_attr( get_site_option('header_css')); ?></textarea>
    </div>
    
    <h3 style="font-weight:bold"><?php _e("Referencias de clases CSS"); ?> </h3>
    <ul>
        <li> <span style="font-weight:bold"> header-container: </span> <?php _e("esta clase envuelve todo el header. (Aquí se pueden poner los colores de fondo)");?> </li>
        <li> <span style="font-weight:bold"> header-title: </span> <?php _e("esta clase maneja la etiqueta de texto");?> </li>
        <li> <span style="font-weight:bold"> header-column: </span> <?php _e("esta clase maneja las 2 columnas del header"); ?> </li>
        <li> <span style="font-weight:bold"> header-col1 y header-col2: </span> <?php _e("estas clases manejan la columna de texto (col1) y la columna de imagen (col2)"); ?> </li>
        <li> <span style="font-weight:bold"> header-image: </span> <?php _e("esta clase maneja la imagen del header"); ?> </li>

    </ul>


    <?php submit_button(); ?>
     

</div>
</form>


<hr>
