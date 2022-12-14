<?php
/**
 * Carga dinámicamente la clase que intenta ser instanciada en otro lugar del
 * plugin mirando el parámetro $class_name que se pasa como un argumento.
 *
 *
 */

/*
 * Gracias a Tom McFarlin
 * https://code.tutsplus.com/tutorials/using-namespaces-and-autoloading-in-wordpress-plugins-4--cms-27342
 */

spl_autoload_register(function ($class_name) {
    // si el $class_name no esta dentro del namespace especificado sale
    if (false === strpos($class_name, 'Wp_multisite_manager_autoload')) {

        return;
    }
    $file_parts = explode('\\', $class_name);

    // Hace un loop inverso a través de $file_parts para construir la ruta al archivo
    $namespace = '';
    for ($i = count($file_parts) - 1; $i > 0; $i--) {

        $current = strtolower($file_parts[$i]);
        $current = str_ireplace('_', '-', $current);

        // Si estamos en la primera entrada, entonces estamos en el nombre de archivo.

        if (count($file_parts) - 1 === $i) {
            if (strpos(strtolower($file_parts[count($file_parts) - 1]), 'interface')) {

                $interface_name = explode('_', $file_parts[count($file_parts) - 1]);
                $interface_name = $interface_name[0];

                $file_name = "interface-$interface_name.php";

            } else {
                $file_name = "class-$current.php";
            }
        } else {
            $namespace = '/' . $current . $namespace;
        }
    }

    $filepath = trailingslashit(untrailingslashit(plugin_dir_path(dirname(__DIR__))) . $namespace);
    $filepath .= $file_name;
    if (file_exists($filepath)) {
        include_once ($filepath);
    } else {
        wp_die(
            esc_html('The file attempting to be loaded at ' . $filepath . ' does not exist.')
        );
    }

}
);
