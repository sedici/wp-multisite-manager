
<?php
#Esta es la vista que se muestra en el shortcode [mis_sitios]
# hace la consulta de los sitios y los muestra en una grilla




if (!defined('ABSPATH')) exit; // Seguridad

$query = new WP_Query([
    'post_type'      => 'cpt-sitios',
    'posts_per_page' => -1,
]);

if ($query->have_posts()) :
?>
    <div class="container">
        <h1 class="page-title">Nuestros Proyectos</h1>
        
        <div class="grid-container">
            <?php while ($query->have_posts()) : $query->the_post(); ?>
                <a href="<?php the_permalink(); ?>" class="card-link">
                    <div class="card">
                        <div class="image-container">
                        <?php 
                            $screenshot = get_post_meta(get_the_ID(), 'site_screenshot', true);
                            $screenshot_url = wp_get_attachment_url($screenshot);
                            if (!empty($screenshot)) : ?>
                                <img src="<?php echo esc_url($screenshot_url); ?>" alt="<?php the_title(); ?>">
                            <?php else : ?>
                                <p><strong>No hay imagen disponible</strong></p>
                            <?php endif; ?>
                        </div>
                        <div class="card-header">
                            <h2><?php the_title(); ?></h2>
                        </div>
                        <div class="card-content">
                            <p><?php echo get_the_excerpt(); ?></p>
                        </div>
                        <div class="card-footer">
                            <span>Ver detalles</span>
                        </div>
                    </div>
                </a>
            <?php endwhile; ?>
        </div>
    </div>
<?php
endif;

wp_reset_postdata();
?>
