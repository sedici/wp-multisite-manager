<h1>Footer</h1>

<p class="comments-about-section"> <?php _e("En esta sección usted podrá editar partes del footer global que desea mostrar
    a lo largo de todo su multisitio."); ?> </p>

<hr>

<!-- Falta agregar atributos name a los elementos del formulario -->
<form action="" method="post">
<div>
    
    <!-- Podria agregarse algun placeholder -->
    <div class="general-form-field">
        <h2 class="filds-titles"> <?php _e("Links de redes sociales"); ?> </h2>
        <label for="footer_fb"> <?php _e("Enlace de Facebook"); ?>  </label>
        <input type="url" name="footer_fb" >
        <br><br>
        <label for="footer_tw"> <?php _e("Enlace de Twitter"); ?>  </label>
        <input type="url" name="footer_tw">
        <br><br>
        <label for="footer_tw"> <?php _e("Enlace de Instagram"); ?>  </label>
        <input type="url" name="footer_ig">
    </div>

    

    <div class="general-form-field">
        <h2 class="filds-titles"> <?php _e("Contacto"); ?> </h2>

        <h4> <?php _e("Mail"); ?> </h4>
        <input type="email" placeholder=<?php _e("Ingrese un mail..");?>>
        <br><br>
        <h4> Teléfono </h4>
        <input type="tel" placeholder=<?php _e("Ingrese un telefono..");?>>
    </div>

    

    <div class="general-form-field">
        <h2 class="filds-titles"><?php _e("Texto");?></h2>

        <input type="text">
    </div>

    

    <div class="general-form-field">
        <h2 class="filds-titles"><?php _e("Enlace del texto");?></h2>

        <input type="url">
    <div>

    

    <div class="general-form-field">
        <h2 class="filds-titles"><?php _e("Imagen");?></h2>
        <input type="file">
    </div>

    

    <div class="general-form-field">
        <h2 class="filds-titles"><?php _e("Enlace de la imagen");?></h2>
        <input type="url">
    </div>

    

    <div class="general-form-field">
        <button id="save-changes-button" type="submit"><?php _e("Guardar cambios");?></button>
    </div>
     

</div>
</form>

<hr>