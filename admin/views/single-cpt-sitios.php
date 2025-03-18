<?php get_header(); ?>
<?php

#Esta es la vista que se muestra en el single de los sitios
# Muestra la información detallada de un sitio  

// Obtén los datos del CPT 'sitios'
$sitio_id = get_the_ID(); // ID del sitio actual
$sitio_nombre = get_the_title(); // Nombre del sitio
$sitio_descripcion = get_the_excerpt();
$sitio_imagen = get_post_meta($sitio_id, 'site_screenshot', true); // Imagen id 
$sitio_imagen_url = wp_get_attachment_url($sitio_imagen); // URL de la imagen
$sitio_isUNLP = get_post_meta($sitio_id, 'site_isUNLP', true); // ¿Es de la UNLP?
$sitio_isCIC = get_post_meta($sitio_id, 'site_isCIC', true); // ¿Es del CIC?
$sitio_dependencia = get_post_meta($sitio_id, 'site_dependence', true); // Dependencia
$sitio_url = get_post_meta($sitio_id, 'site_url', true); // URL del sitio
$referer_url = wp_get_referer(); // URL de la página anterior   

// Verifica si el sitio existe, si no, muestra una página 404
if (!$sitio_id) {
    wp_redirect(home_url()); // Redirige a la página principal si no se encuentra el sitio
    exit;
}
?>

<main class="main-container">
    <a href="<?php echo esc_url($referer_url);?>" class="back-link">
        Volver al portafolio
    </a>

    <div class="site-content">
        <div class="site-main">
            <div class="image-container">
                <img src="<?php echo esc_url($sitio_imagen_url); ?>" alt="<?php echo esc_attr($sitio_nombre); ?>" class="site-image" />
            </div>

            <h1 class="site-title"><?php echo esc_html($sitio_nombre); ?></h1>

            <div class="description-container">
                <h2 class="section-title">Descripción</h2>
                <p class="site-description"><?php echo esc_html($sitio_descripcion); ?></p>
            </div>
        </div>

        <div class="site-sidebar-new">
            <div class="card-new">
                 <div class="card-content-new">
            <!-- Mostrar los campos adicionales -->
                <div class="site-details-new">
                    <h3 class="section-title-new">Detalles adicionales</h3>
                    <ul>
                         <li><strong>Es UNLP:</strong> <?php echo ($sitio_isUNLP == 1) ? 'Sí' : 'No'; ?></li>
                         <li><strong>Es CIC:</strong> <?php echo ($sitio_isCIC == 1) ? 'Sí' : 'No'; ?></li>
                         <li><strong>Dependencia:</strong> <?php echo esc_html($sitio_dependencia); ?></li>
                    </ul>
                 </div>
            <!-- Mostrar el enlace al sitio -->
            <a href="<?php echo esc_url($sitio_url); ?>" target="_blank"  class="btn-visit-new">
                Visitar sitio
            </a>
            </div>
         
        </div>
    </div>



    </div>
</main>

<?php get_footer(); ?>