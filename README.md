# Multisite Manager | 1.0 (Versión de prueba)

## Plugin de Wordpress para agregar funcionalidad en multisitios

Este plugin de wordpress brinda funcionalidades para las instalaciónes de multisitio de Wordpress.
Las principales son:

- [x] Permitir configurar un Header global para todos los sitios.

- [x] Permitir configurar un Footer global para todos los sitios.

- [x] Crear un Custom Post Type para representar a los sitios, recuperando la información automáticamente.

- [x] Shortcode para listar los CPT de sitios al estilo "Portafolio"

- [x] Shortcode para listar los CPT de sitios al estilo "Carrousel"

- [x] Shortcode para listar los CPT de sitios al estilo "Listado"

## Shortcodes

- **[show_sites_portfolio ]** => Muestra todos los CPT de sitios disponibles, al estilo "Portafolio".
    - 'widget_color' : Sirve para elegir el color que va a tener el contenedor de todo el widget de portafolio. 
    - 'box_color' : Nos permite indicar que color queremos que tenga el contenedor de cada "caja" individual del portafolio.

- **[show_sites_carrousel ]** => Muestra todos los CPT de sitios disponibles, al estilo "Carrousel".
    - 'per_view'=> Permite seleccionar cuantos sitios se van a mostrar a la vez en el carrousel.
    - 'autoplay_seconds' => (Default = 0) Indíca cada cuantos segundos se cambia a la próxima página. Si no se especifica, queda desactivada por defecto la opción de cambiar de página automáticamente

*Los parámetros de color aceptan 3 representaciones : Colores en ingles (Ej. Red), en hexadecimal (Ej. #0000FF) o RGB(Ej. rgb(0, 0, 255) )*.

- **[show_sites_list ]** => Muestra los CPT de sitios disponibles con fecha de creación más reciente, al estilo "Listado".
    - 'cant' : Sirve para determinar la cantidad de sitios a mostrar. Se puede elegir valores entre 1 y 15 o por defecto se muestran todos

ESTO ES UNA PRUEBA