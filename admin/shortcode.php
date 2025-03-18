<?php
# Declaro el shortcode
function mostrar_sitios_shortcode() {
    ob_start();

    $template = plugin_dir_path(__FILE__) . 'views/archive-cpt-sitios.php';

    if (file_exists($template)) {
        include $template;
    } else {
        echo '<p>Error: No se encontró la plantilla.</p>';
    }

    return ob_get_clean();
}
add_shortcode('mis_sitios', 'mostrar_sitios_shortcode');

?>