# Multisite Manager | 1.0

## Descripción

**Multisite Manager** es un plugin exclusivo para instalaciones multisitio de WordPress que permite gestionar y representar todos los subsitios como CPTs (Custom Post Type). Además, proporciona shortcodes personalizables para su visualización en el frontend.

### Funcionalidades principales

- Escanea automáticamente la red multisitio y crea/actualiza CPTs para cada sitio.
- Cada CPT contiene metadatos como descripción, URL, captura de pantalla y fecha de creación.
- Interfaz de administración para listar y gestionar los CPTs mediante una tabla paginada y ordenable.
- Shortcode para mostrar un portafolio visual de los sitios de la red, con opciones de personalización.
- Filtros para gestionar visibilidad (por ejemplo, mostrar solo sitios sin capturas de pantalla).

## Shortcodes

* ```[show_sites_portfolio]```

Muestra un portafolio en forma de grilla con todos los sitios registrados como CPTs.

**Atributos:**

- `widget_color` — Color de fondo del contenedor general del widget.
- `box_color` — Color de fondo de cada caja individual de sitio.
- `order_by` — Criterio de ordenamiento. Valores posibles:
  - `none`, `ID`, `title`, `name`, `date`, `modified`, `rand`
- `order` — Dirección del ordenamiento:
  - `ASC`, `DESC`

Ejemplo:

```shortcode
[show_sites_portfolio widget_color="#f0f0f0" box_color="#ffffff" order_by="title" order="ASC"]
