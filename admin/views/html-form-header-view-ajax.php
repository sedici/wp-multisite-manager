<h1>Header</h1>

<p class="comments-about-section"> <?php _e("En esta sección usted podrá editar partes del header global que desea mostrar
    a lo largo de todo su multisitio.",'wp-multisite-manager'); ?> </p>

<hr>
   
<!-- Falta agregar atributos name a los elementos del formulario -->
<form>
<div>
    
    <!-- Podria agregarse algun placeholder -->
    <div class="general-form-field">
        <h2 class="filds-titles"> Texto <?php plugin_basename(__FILE__); ?> </h2>
        <input type="text">
    </div>

    

    <div class="general-form-field">
        <h2 class="filds-titles"> <?php _e("Enlace del texto"); ?> </h2>
        <input type="url">
    </div>

    

    <div class="general-form-field">
        <h2 class="filds-titles"> <?php _e("Imagen"); ?> </h2>
        <input type="file">
    </div>

    

    <div class="general-form-field">
        <h2 class="filds-titles"> <?php _e("Enlace de la imagen"); ?> </h2>
        <input type="url">
    </div>

    

    <div class="general-form-field">
        <button id="save-changes-button" type="submit"><?php _e("Guardar cambios");?></button>
    </div>
     

</div>
</form>


<hr>

