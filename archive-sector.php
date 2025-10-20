<?php
/**
 * Archive Sectors Template
 * 
 * @package APC_Theme
 */

get_header(); ?>

<main id="primary" class="site-main">
    
    <!-- Archive Header -->
    <section class="sectors-archive-header">
        <div class="container">
            <div class="archive-header-content">
                <h1 class="archive-title">
                    <?php 
                    if (is_tax('sector_category')) {
                        single_term_title();
                        echo ' ' . __('Sectors', 'apc-theme');
                    } elseif (is_tax('sector_tag')) {
                        echo __('Sectors tagged: ', 'apc-theme');
                        single_term_title();
                    } else {
                        _e('Our Sectors', 'apc-theme');
                    }
                    ?>
                </h1>
                
                <?php if (is_tax()): ?>
                    <div class="archive-description">
                        <?php echo term_description(); ?>
                    </div>
                <?php else: ?>
                    <div class="archive-description">
                        <p><?php _e('We provide specialized IT solutions across various industry sectors. Explore our expertise and discover how we can help your business thrive.', 'apc-theme'); ?></p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
    
    <!-- Filters -->
    <section class="sectors-filters">
        <div class="container">
            <div class="filter-tabs">
                <a href="<?php echo get_post_type_archive_link('sector'); ?>" 
                   class="filter-tab <?php echo is_post_type_archive('sector') ? 'active' : ''; ?>">
                    <?php _e('All Sectors', 'apc-theme'); ?>
                </a>
                
                <?php 
                $categories = get_terms(array(
                    'taxonomy' => 'sector_category',
                    'hide_empty' => true,
                ));
                
                if ($categories && !is_wp_error($categories)):
                    foreach ($categories as $category): 
                        $is_active = is_tax('sector_category', $category->slug);
                ?>
                        <a href="<?php echo get_term_link($category); ?>" 
                           class="filter-tab <?php echo $is_active ? 'active' : ''; ?>">
                            <?php echo esc_html($category->name); ?>
                            <span class="count">(<?php echo $category->count; ?>)</span>
                        </a>
                <?php 
                    endforeach;
                endif; 
                ?>
            </div>
        </div>
    </section>
    
    <!-- Sectors Grid -->
    <section class="sectors-grid-section">
        <div class="container">
            
            <?php if (have_posts()): ?>
                
                <div class="sectors-grid">
                    <?php while (have_posts()) : the_post(); ?>
                        
                        <article class="sector-card" id="post-<?php the_ID(); ?>">
                            
                            <?php 
                            $sector_icon = get_post_meta(get_the_ID(), '_sector_icon', true);
                            $sector_color = get_post_meta(get_the_ID(), '_sector_color', true);
                            if (!$sector_color) $sector_color = '#2119d4';
                            ?>
                            
                            <div class="sector-card-header" style="border-top: 4px solid <?php echo esc_attr($sector_color); ?>;">
                                <?php if ($sector_icon): ?>
                                    <div class="sector-card-icon" style="color: <?php echo esc_attr($sector_color); ?>;">
                                        <i class="fa <?php echo esc_attr($sector_icon); ?>"></i>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if (has_post_thumbnail()): ?>
                                    <div class="sector-card-image">
                                        <a href="<?php the_permalink(); ?>">
                                            <?php the_post_thumbnail('medium'); ?>
                                        </a>
                                    </div>
                                <?php endif; ?>
                            </div>
                            
                            <div class="sector-card-content">
                                <h2 class="sector-card-title">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h2>
                                
                                <?php if (has_excerpt()): ?>
                                    <div class="sector-card-excerpt">
                                        <?php the_excerpt(); ?>
                                    </div>
                                <?php else: ?>
                                    <div class="sector-card-excerpt">
                                        <?php echo wp_trim_words(get_the_content(), 20, '...'); ?>
                                    </div>
                                <?php endif; ?>
                                
                                <!-- Key Services Preview -->
                                <?php 
                                $sector_services = get_post_meta(get_the_ID(), '_sector_services', true);
                                if ($sector_services): 
                                    $services = explode("\n", trim($sector_services));
                                    $preview_services = array_slice($services, 0, 3);
                                ?>
                                    <div class="sector-card-services">
                                        <h4><?php _e('Key Services:', 'apc-theme'); ?></h4>
                                        <ul>
                                            <?php foreach ($preview_services as $service): ?>
                                                <?php if (trim($service)): ?>
                                                    <li><?php echo esc_html(trim($service)); ?></li>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                            <?php if (count($services) > 3): ?>
                                                <li class="more-services">
                                                    <?php printf(__('+ %d more services', 'apc-theme'), count($services) - 3); ?>
                                                </li>
                                            <?php endif; ?>
                                        </ul>
                                    </div>
                                <?php endif; ?>
                                
                                <!-- Categories and Tags -->
                                <div class="sector-card-meta">
                                    <?php 
                                    $categories = get_the_terms(get_the_ID(), 'sector_category');
                                    if ($categories && !is_wp_error($categories)): ?>
                                        <div class="sector-card-categories">
                                            <?php foreach ($categories as $category): ?>
                                                <span class="sector-category-tag" style="background-color: <?php echo esc_attr($sector_color); ?>20; color: <?php echo esc_attr($sector_color); ?>;">
                                                    <?php echo esc_html($category->name); ?>
                                                </span>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            <div class="sector-card-footer">
                                <a href="<?php the_permalink(); ?>" class="sector-card-link" style="color: <?php echo esc_attr($sector_color); ?>;">
                                    <?php _e('Learn More', 'apc-theme'); ?>
                                    <i class="fa fa-arrow-right"></i>
                                </a>
                            </div>
                            
                        </article>
                        
                    <?php endwhile; ?>
                </div>
                
                <!-- Pagination -->
                <?php
                the_posts_pagination(array(
                    'prev_text' => __('Previous', 'apc-theme'),
                    'next_text' => __('Next', 'apc-theme'),
                ));
                ?>
                
            <?php else: ?>
                
                <div class="no-sectors-found">
                    <h2><?php _e('No sectors found', 'apc-theme'); ?></h2>
                    <p><?php _e('Sorry, no sectors match your criteria. Please try a different filter or check back later.', 'apc-theme'); ?></p>
                    <a href="<?php echo get_post_type_archive_link('sector'); ?>" class="btn btn-primary">
                        <?php _e('View All Sectors', 'apc-theme'); ?>
                    </a>
                </div>
                
            <?php endif; ?>
            
        </div>
    </section>
    
</main>

<style>
/* Sectors Archive Styles */
.sectors-archive-header {
    background: var(--light-grey, #f8f9fa);
    padding: 80px 0 60px 0;
    border-bottom: 1px solid #e1e5e9;
}

.archive-header-content {
    text-align: center;
    max-width: 800px;
    margin: 0 auto;
}

.archive-title {
    font-size: 48px;
    font-weight: 700;
    color: var(--text-color, #333);
    margin-bottom: 20px;
    line-height: 1.2;
}

.archive-description {
    font-size: 20px;
    color: var(--text-color, #666);
    line-height: 1.6;
}

.sectors-filters {
    background: white;
    padding: 30px 0;
    border-bottom: 1px solid #e1e5e9;
    position: sticky;
    top: 80px;
    z-index: 10;
}

.filter-tabs {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 10px;
}

.filter-tab {
    padding: 12px 20px;
    background: #f8f9fa;
    border: 2px solid transparent;
    border-radius: 25px;
    color: var(--text-color, #666);
    text-decoration: none;
    font-weight: 500;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 5px;
}

.filter-tab:hover,
.filter-tab.active {
    background: var(--brand-color, #2119d4);
    color: white;
    border-color: var(--brand-color, #2119d4);
    text-decoration: none;
}

.filter-tab .count {
    background: rgba(255, 255, 255, 0.2);
    padding: 2px 8px;
    border-radius: 12px;
    font-size: 12px;
}

.sectors-grid-section {
    padding: 80px 0;
}

.sectors-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 30px;
}

.sector-card {
    background: white;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 5px 20px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
    display: flex;
    flex-direction: column;
}

.sector-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(0,0,0,0.15);
}

.sector-card-header {
    position: relative;
    padding: 30px;
    background: #f8f9fa;
}

.sector-card-icon {
    font-size: 40px;
    margin-bottom: 20px;
    text-align: center;
}

.sector-card-image {
    text-align: center;
    margin-top: 20px;
}

.sector-card-image img {
    width: 100%;
    max-width: 200px;
    height: auto;
    border-radius: 10px;
}

.sector-card-content {
    padding: 30px;
    flex-grow: 1;
    display: flex;
    flex-direction: column;
}

.sector-card-title {
    font-size: 24px;
    font-weight: 600;
    margin-bottom: 15px;
    line-height: 1.3;
}

.sector-card-title a {
    color: var(--text-color, #333);
    text-decoration: none;
    transition: color 0.3s ease;
}

.sector-card-title a:hover {
    color: var(--brand-color, #2119d4);
}

.sector-card-excerpt {
    color: var(--text-color, #666);
    line-height: 1.6;
    margin-bottom: 20px;
}

.sector-card-services {
    margin-bottom: 20px;
    flex-grow: 1;
}

.sector-card-services h4 {
    font-size: 16px;
    font-weight: 600;
    color: var(--text-color, #333);
    margin-bottom: 10px;
}

.sector-card-services ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.sector-card-services li {
    padding: 5px 0;
    color: var(--text-color, #666);
    font-size: 14px;
    position: relative;
    padding-left: 15px;
}

.sector-card-services li:not(.more-services)::before {
    content: '•';
    position: absolute;
    left: 0;
    color: var(--brand-color, #2119d4);
    font-weight: bold;
}

.sector-card-services .more-services {
    font-style: italic;
    color: var(--brand-color, #2119d4);
    font-weight: 500;
}

.sector-card-meta {
    margin-bottom: 20px;
}

.sector-card-categories {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
}

.sector-category-tag {
    padding: 4px 12px;
    border-radius: 15px;
    font-size: 12px;
    font-weight: 500;
}

.sector-card-footer {
    padding: 0 30px 30px 30px;
}

.sector-card-link {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
}

.sector-card-link:hover {
    text-decoration: none;
    transform: translateX(5px);
}

.no-sectors-found {
    text-align: center;
    padding: 80px 20px;
}

.no-sectors-found h2 {
    font-size: 32px;
    color: var(--text-color, #333);
    margin-bottom: 20px;
}

.no-sectors-found p {
    font-size: 18px;
    color: var(--text-color, #666);
    margin-bottom: 30px;
    max-width: 500px;
    margin-left: auto;
    margin-right: auto;
}

.btn {
    display: inline-block;
    padding: 15px 30px;
    background: var(--brand-color, #2119d4);
    color: white;
    text-decoration: none;
    border-radius: 25px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn:hover {
    background: var(--secondary-color, #5a4bcc);
    color: white;
    text-decoration: none;
    transform: translateY(-2px);
}

/* Pagination Styles */
.pagination {
    margin-top: 60px;
    text-align: center;
}

.pagination .page-numbers {
    display: inline-block;
    padding: 10px 15px;
    margin: 0 5px;
    background: white;
    border: 2px solid #e1e5e9;
    border-radius: 8px;
    color: var(--text-color, #666);
    text-decoration: none;
    transition: all 0.3s ease;
}

.pagination .page-numbers:hover,
.pagination .page-numbers.current {
    background: var(--brand-color, #2119d4);
    border-color: var(--brand-color, #2119d4);
    color: white;
    text-decoration: none;
}

/* Responsive Design */
@media (max-width: 768px) {
    .sectors-archive-header {
        padding: 60px 0 40px 0;
    }
    
    .archive-title {
        font-size: 32px;
    }
    
    .archive-description {
        font-size: 18px;
    }
    
    .sectors-filters {
        padding: 20px 0;
        position: relative;
        top: auto;
    }
    
    .filter-tabs {
        flex-direction: column;
        align-items: stretch;
    }
    
    .filter-tab {
        justify-content: center;
    }
    
    .sectors-grid-section {
        padding: 60px 0;
    }
    
    .sectors-grid {
        grid-template-columns: 1fr;
        gap: 20px;
    }
    
    .sector-card-header,
    .sector-card-content,
    .sector-card-footer {
        padding: 20px;
    }
    
    .sector-card-footer {
        padding-top: 0;
    }
}
</style>

<?php get_footer(); ?>