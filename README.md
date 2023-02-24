# Multisite Manager | 1.0 (Versión de prueba)

## Plugin de Wordpress para agregar funcionalidad en multisitios

Este plugin de wordpress brinda funcionalidades para las instalaciónes de multisitio de Wordpress.
Las principales son:

- [x] Permitir configurar un Header global para todos los sitios.

- [x] Permitir configurar un Footer global para todos los sitios.

- [x] Crear un Custom Post Type para representar a los sitios, recuperando la información automáticamente.

- [x] Shortcode para listar los CPT de sitios al estilo "Portafolio"

- [x] Shortcode para listar los CPT de sitios al estilo "Carrousel"

## Shortcodes

- **[show_sites_portfolio ]** => Muestra todos los CPT de sitios disponibles, al estilo "Portafolio".
    - 'widget_color' : Sirve para elegir el color que va a tener el contenedor de todo el widget de portafolio. 
    - 'box_color' : Nos permite indicar que color queremos que tenga el contenedor de cada "caja" individual del portafolio.

- **[show_sites_portfolio ]** => Muestra todos los CPT de sitios disponibles, al estilo "Carrousel".

*Los parámetros que representan un color aceptan 3 representaciones : Colores en ingles (Ej. Red), en hexadecimal (Ej. #0000FF) o RGB(Ej. rgb(0, 0, 255) )*.
