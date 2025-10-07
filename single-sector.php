<?php
/**
 * Single Sector Template
 * 
 * @package APC_Theme
 */

get_header(); ?>

<main id="primary" class="site-main">
    <?php while (have_posts()) : the_post(); ?>
        
        <article id="post-<?php the_ID(); ?>" <?php post_class('sector-single'); ?>>
            
            <!-- Hero Section -->
            <section class="sector-hero">
                    <div class="sector-hero-content">
                        <?php 
                        $sector_icon = get_post_meta(get_the_ID(), '_sector_icon', true);
                        $sector_color = get_post_meta(get_the_ID(), '_sector_color', true);
                        if (!$sector_color) $sector_color = '#7055EE';
                        ?>
                        
                        <?php if ($sector_icon): ?>
                            <div class="sector-icon" style="color: <?php echo esc_attr($sector_color); ?>;">
                                <i class="fa <?php echo esc_attr($sector_icon); ?>"></i>
                            </div>
                        <?php endif; ?>
                        
                         <?php if (has_excerpt()): ?>
                            <div class="sector-excerpt">
                                <?php the_excerpt(); ?>
                            </div>
                        <?php endif; ?>
                        <h1 class="sector-title"><?php the_title(); ?></h1>
                        
                       
                        
                        <?php if (has_post_thumbnail()): ?>
                            <div class="sector-featured-image">
                                <?php the_post_thumbnail('large'); ?>
                            </div>
                        <?php endif; ?>
                    </div>
            </section>
            
            <!-- Main Content -->
            <section class="sector-content">
                
                    <div class="sector-content-grid">
                        
                        <!-- Main Description -->
                        <div class="sector-description">
                            <?php the_content(); ?>
                        </div>
                        
                        <!-- APC CTA Section Block -->
    <?php echo do_blocks('<!-- wp:apc/cta {"useGravityForm":true,"gravityFormId":"4"} --><!-- /wp:apc/cta -->'); ?>

                    </div>
               
            </section>
            
           
            
        </article>
        
    <?php endwhile; ?>
</main>



<?php get_footer(); ?>