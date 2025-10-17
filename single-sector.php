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