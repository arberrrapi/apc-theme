<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 */

get_header(); ?>

<?php while (have_posts()) : the_post(); ?>
    <section class="page-content">
        <div class="">
            <div class="page-header"<?php if (apc_is_header_hidden(get_the_ID())) echo ' style="display: none;"'; ?>>
                <?php 
                $button_text = apc_get_header_button_text(get_the_ID());
                $button_url = apc_get_header_button_url(get_the_ID());
                if (!empty($button_text) && !empty($button_url)) : ?>
                    <div class="page-button-wrapper">
                        <a href="<?php echo esc_url($button_url); ?>" class="page-header-button">
                            <?php echo esc_html($button_text); ?>
                        </a>
                    </div>
                <?php endif; ?>

                <h1 class="page-title"><?php the_title(); ?></h1>
                <?php 
                $subtitle = apc_get_header_subtitle(get_the_ID());
                if (!empty($subtitle)) : ?>
                    <p class="page-subtitle"><?php echo esc_html($subtitle); ?></p>
                <?php endif; ?>
                
                
                
                
               
            </div>
            
            <div class="page-content-area">
                <?php the_content(); ?>
                
             
            </div>
          
        </div>
    </section>
<?php endwhile; ?>

<?php get_footer(); ?>