<?php
/**
 * The template for displaying search results pages
 */

get_header(); ?>

<section class="search-results">
    <div class="container">
        <header class="search-header">
            <h1 class="search-title">
                <?php
                printf(
                    esc_html__('Search Results for: %s', 'apc-theme'),
                    '<span>' . get_search_query() . '</span>'
                );
                ?>
            </h1>
            
            <div class="search-form-wrapper">
                <?php get_search_form(); ?>
            </div>
        </header>

        <div class="search-content">
            <?php if (have_posts()) : ?>
                <div class="search-results-list">
                    <?php while (have_posts()) : the_post(); ?>
                        <article class="search-result-item">
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="search-result-thumbnail">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_post_thumbnail('medium'); ?>
                                    </a>
                                </div>
                            <?php endif; ?>
                            
                            <div class="search-result-content">
                                <h2 class="search-result-title">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h2>
                                
                                <div class="search-result-meta">
                                    <span class="search-result-date">
                                        <i class="fa-solid fa-calendar"></i>
                                        <?php echo get_the_date(); ?>
                                    </span>
                                    <span class="search-result-type">
                                        <i class="fa-solid fa-file"></i>
                                        <?php echo get_post_type_object(get_post_type())->labels->singular_name; ?>
                                    </span>
                                </div>
                                
                                <div class="search-result-excerpt">
                                    <?php the_excerpt(); ?>
                                </div>
                                
                                <a href="<?php the_permalink(); ?>" class="search-result-link">
                                    <?php esc_html_e('Read More', 'apc-theme'); ?>
                                    <i class="fa-solid fa-arrow-right"></i>
                                </a>
                            </div>
                        </article>
                    <?php endwhile; ?>
                </div>
                
                <?php
                // Pagination
                the_posts_pagination(array(
                    'mid_size'  => 2,
                    'prev_text' => __('&laquo; Previous'),
                    'next_text' => __('Next &raquo;'),
                ));
                ?>
                
            <?php else : ?>
                <div class="no-search-results">
                    <h2><?php esc_html_e('Nothing Found', 'apc-theme'); ?></h2>
                    <p><?php esc_html_e('Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'apc-theme'); ?></p>
                    
                    <div class="search-suggestions">
                        <h3><?php esc_html_e('Search Suggestions:', 'apc-theme'); ?></h3>
                        <ul>
                            <li><?php esc_html_e('Try different keywords', 'apc-theme'); ?></li>
                            <li><?php esc_html_e('Try more general keywords', 'apc-theme'); ?></li>
                            <li><?php esc_html_e('Check your spelling', 'apc-theme'); ?></li>
                        </ul>
                    </div>
                    
                    <div class="popular-content">
                        <h3><?php esc_html_e('Popular Content', 'apc-theme'); ?></h3>
                        <?php
                        $popular_posts = new WP_Query(array(
                            'posts_per_page' => 5,
                            'meta_key' => 'post_views_count',
                            'orderby' => 'meta_value_num',
                            'order' => 'DESC'
                        ));
                        
                        if ($popular_posts->have_posts()) :
                        ?>
                            <ul class="popular-posts-list">
                                <?php while ($popular_posts->have_posts()) : $popular_posts->the_post(); ?>
                                    <li>
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    </li>
                                <?php endwhile; ?>
                            </ul>
                        <?php 
                            wp_reset_postdata();
                        endif;
                        ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<style>
.search-results {
    padding: 60px 0;
    background: #f8f9fa;
    min-height: 60vh;
}

.search-header {
    text-align: center;
    margin-bottom: 40px;
    padding-bottom: 20px;
    border-bottom: 1px solid #ddd;
}

.search-title {
    font-size: 2rem;
    color: var(--primary-blue, #1a365d);
    margin-bottom: 20px;
}

.search-title span {
    color: var(--accent-blue, #3182ce);
}

.search-form-wrapper {
    max-width: 400px;
    margin: 0 auto;
}

.search-results-list {
    display: flex;
    flex-direction: column;
    gap: 30px;
}

.search-result-item {
    background: white;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    display: flex;
    transition: transform 0.3s ease;
}

.search-result-item:hover {
    transform: translateY(-2px);
}

.search-result-thumbnail {
    flex: 0 0 200px;
}

.search-result-thumbnail img {
    width: 100%;
    height: 150px;
    object-fit: cover;
}

.search-result-content {
    flex: 1;
    padding: 20px;
}

.search-result-title {
    margin: 0 0 10px 0;
    font-size: 1.5rem;
}

.search-result-title a {
    color: var(--primary-blue, #1a365d);
    text-decoration: none;
}

.search-result-title a:hover {
    color: var(--accent-blue, #3182ce);
}

.search-result-meta {
    display: flex;
    gap: 20px;
    margin-bottom: 15px;
    font-size: 0.9rem;
    color: #666;
}

.search-result-meta span {
    display: flex;
    align-items: center;
    gap: 5px;
}

.search-result-excerpt {
    margin-bottom: 15px;
    line-height: 1.6;
}

.search-result-link {
    color: var(--accent-blue, #3182ce);
    text-decoration: none;
    font-weight: 500;
    display: inline-flex;
    align-items: center;
    gap: 5px;
}

.search-result-link:hover {
    text-decoration: underline;
}

.no-search-results {
    text-align: center;
    background: white;
    padding: 60px 40px;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.no-search-results h2 {
    color: var(--primary-blue, #1a365d);
    margin-bottom: 20px;
}

.search-suggestions, .popular-content {
    margin-top: 40px;
    text-align: left;
    max-width: 500px;
    margin-left: auto;
    margin-right: auto;
}

.search-suggestions h3, .popular-content h3 {
    color: var(--primary-blue, #1a365d);
    margin-bottom: 15px;
}

.search-suggestions ul, .popular-posts-list {
    list-style: none;
    padding: 0;
}

.search-suggestions li, .popular-posts-list li {
    padding: 8px 0;
    border-bottom: 1px solid #eee;
}

.popular-posts-list a {
    color: var(--accent-blue, #3182ce);
    text-decoration: none;
}

.popular-posts-list a:hover {
    text-decoration: underline;
}

@media (max-width: 768px) {
    .search-result-item {
        flex-direction: column;
    }
    
    .search-result-thumbnail {
        flex: none;
    }
    
    .search-result-meta {
        flex-direction: column;
        gap: 5px;
    }
}
</style>

<?php get_footer(); ?>