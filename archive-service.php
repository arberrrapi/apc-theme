<?php
/**
 * The template for displaying service archives
 */

get_header(); ?>

<section class="services-archive">
    <div class="container">
        <!-- Archive Header -->
        <header class="archive-header">
            <div class="archive-hero">
                <h1 class="archive-title">
                    <?php 
                    if (is_tax('service_category')) {
                        printf(__('Services: %s', 'apc-theme'), single_term_title('', false));
                    } else {
                        _e('Our Services', 'apc-theme');
                    }
                    ?>
                </h1>
                
                <?php 
                $description = get_the_archive_description();
                if ($description) : 
                ?>
                    <div class="archive-description">
                        <?php echo $description; ?>
                    </div>
                <?php else : ?>
                    <p class="archive-description">
                        <?php _e('Comprehensive IT solutions tailored to your business needs. From cloud infrastructure to cybersecurity, we\'ve got you covered.', 'apc-theme'); ?>
                    </p>
                <?php endif; ?>
            </div>
        </header>

        <!-- Services Filter -->
        <div class="services-filter">
            <div class="filter-tabs">
                <a href="<?php echo get_post_type_archive_link('service'); ?>" 
                   class="filter-tab <?php echo (!is_tax()) ? 'active' : ''; ?>">
                    <?php _e('All Services', 'apc-theme'); ?>
                </a>
                
                <?php
                $categories = get_terms(array(
                    'taxonomy' => 'service_category',
                    'hide_empty' => true,
                ));
                
                if (!is_wp_error($categories) && !empty($categories)) :
                    foreach ($categories as $category) :
                        $is_active = (is_tax('service_category', $category->slug)) ? 'active' : '';
                ?>
                    <a href="<?php echo get_term_link($category); ?>" 
                       class="filter-tab <?php echo $is_active; ?>">
                        <?php echo esc_html($category->name); ?>
                        <span class="count">(<?php echo $category->count; ?>)</span>
                    </a>
                <?php 
                    endforeach;
                endif; 
                ?>
            </div>
        </div>

        <!-- Services Content -->
        <div class="services-content">
            <?php if (have_posts()) : ?>
                <div class="services-grid">
                    <?php while (have_posts()) : the_post(); 
                        $service_icon = get_post_meta(get_the_ID(), '_service_icon', true);
                        $service_icon_color = get_post_meta(get_the_ID(), '_service_icon_color', true);
                        $service_short_description = get_post_meta(get_the_ID(), '_service_short_description', true);
                        $service_url = get_post_meta(get_the_ID(), '_service_url', true);
                        $service_price_range = get_post_meta(get_the_ID(), '_service_price_range', true);
                    ?>
                    
                    <article class="service-card">
                        <!-- Service Icon -->
                        <?php if ($service_icon) : ?>
                            <div class="service-icon">
                                <i class="<?php echo esc_attr($service_icon); ?>" 
                                   style="color: <?php echo esc_attr($service_icon_color ?: '#3182ce'); ?>;"></i>
                            </div>
                        <?php endif; ?>
                        
                        <!-- Featured Image -->
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="service-image">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('medium'); ?>
                                </a>
                            </div>
                        <?php endif; ?>
                        
                        <!-- Service Content -->
                        <div class="service-content">
                            <h2 class="service-title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h2>
                            
                            <!-- Service Meta -->
                            <div class="service-meta">
                                <?php if ($service_price_range) : ?>
                                    <span class="price-range price-<?php echo esc_attr($service_price_range); ?>">
                                        <i class="fa-solid fa-tag"></i>
                                        <?php
                                        $price_labels = array(
                                            'budget' => __('Budget', 'apc-theme'),
                                            'standard' => __('Standard', 'apc-theme'),
                                            'premium' => __('Premium', 'apc-theme'),
                                            'enterprise' => __('Enterprise', 'apc-theme'),
                                            'custom' => __('Custom', 'apc-theme')
                                        );
                                        echo esc_html($price_labels[$service_price_range] ?? $service_price_range);
                                        ?>
                                    </span>
                                <?php endif; ?>
                                
                                <?php 
                                $categories = get_the_terms(get_the_ID(), 'service_category');
                                if ($categories && !is_wp_error($categories)) : 
                                ?>
                                    <span class="service-categories">
                                        <i class="fa-solid fa-folder"></i>
                                        <?php echo esc_html($categories[0]->name); ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                            
                            <!-- Description -->
                            <div class="service-description">
                                <?php if ($service_short_description) : ?>
                                    <p><?php echo esc_html($service_short_description); ?></p>
                                <?php else : ?>
                                    <?php the_excerpt(); ?>
                                <?php endif; ?>
                            </div>
                            
                            <!-- Service Actions -->
                            <div class="service-actions">
                                <a href="<?php the_permalink(); ?>" class="btn-learn-more">
                                    <?php _e('Learn More', 'apc-theme'); ?>
                                </a>
                                
                                <?php if ($service_url) : ?>
                                    <a href="<?php echo esc_url($service_url); ?>" class="btn-get-started">
                                        <i class="fa-solid fa-arrow-right"></i>
                                        <?php _e('Get Started', 'apc-theme'); ?>
                                    </a>
                                <?php endif; ?>
                            </div>
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
                <div class="no-services">
                    <div class="no-services-content">
                        <i class="fa-solid fa-search" style="font-size: 4rem; color: #ccc; margin-bottom: 20px;"></i>
                        <h2><?php _e('No Services Found', 'apc-theme'); ?></h2>
                        <p><?php _e('No services were found in this category. Please try browsing other categories or contact us for custom solutions.', 'apc-theme'); ?></p>
                        
                        <div class="no-services-actions">
                            <a href="<?php echo get_post_type_archive_link('service'); ?>" class="btn-all-services">
                                <?php _e('View All Services', 'apc-theme'); ?>
                            </a>
                            <a href="#contact" class="btn-contact">
                                <?php _e('Contact Us', 'apc-theme'); ?>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<style>
/* Services Archive Styles */
.services-archive {
    padding: 0;
    min-height: 70vh;
}

.archive-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 100px 0 60px;
    text-align: center;
}

.archive-title {
    font-size: 3.5rem;
    font-weight: bold;
    margin-bottom: 20px;
}

.archive-description {
    font-size: 1.2rem;
    max-width: 600px;
    margin: 0 auto;
    opacity: 0.9;
    line-height: 1.6;
}

.services-filter {
    background: white;
    padding: 0;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    position: sticky;
    top: 0;
    z-index: 100;
}

.filter-tabs {
    display: flex;
    justify-content: center;
    gap: 0;
    overflow-x: auto;
    padding: 0 20px;
}

.filter-tab {
    padding: 20px 30px;
    text-decoration: none;
    color: #666;
    border-bottom: 3px solid transparent;
    white-space: nowrap;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 8px;
}

.filter-tab:hover,
.filter-tab.active {
    color: var(--primary-blue, #1a365d);
    border-bottom-color: var(--accent-blue, #3182ce);
}

.filter-tab .count {
    background: #f0f0f1;
    color: #666;
    padding: 2px 8px;
    border-radius: 12px;
    font-size: 0.8rem;
}

.filter-tab.active .count {
    background: var(--accent-blue, #3182ce);
    color: white;
}

.services-content {
    padding: 60px 0;
    background: #f8f9fa;
}

.services-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 40px;
    margin-bottom: 60px;
}

.service-card {
    background: white;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
    position: relative;
}

.service-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.15);
}

.service-icon {
    position: absolute;
    top: 20px;
    right: 20px;
    z-index: 2;
    background: white;
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    font-size: 1.5rem;
}

.service-image {
    position: relative;
    overflow: hidden;
    height: 200px;
}

.service-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.service-card:hover .service-image img {
    transform: scale(1.05);
}

.service-content {
    padding: 30px;
}

.service-title {
    margin: 0 0 15px 0;
    font-size: 1.4rem;
}

.service-title a {
    color: var(--primary-blue, #1a365d);
    text-decoration: none;
}

.service-title a:hover {
    color: var(--accent-blue, #3182ce);
}

.service-meta {
    display: flex;
    gap: 15px;
    margin-bottom: 15px;
    flex-wrap: wrap;
}

.service-meta span {
    display: flex;
    align-items: center;
    gap: 5px;
    font-size: 0.85rem;
    padding: 4px 10px;
    border-radius: 15px;
    background: #f0f0f1;
    color: #666;
}

.price-range.price-budget { background: rgba(34, 197, 94, 0.1); color: #16a34a; }
.price-range.price-standard { background: rgba(59, 130, 246, 0.1); color: #2563eb; }
.price-range.price-premium { background: rgba(168, 85, 247, 0.1); color: #7c3aed; }
.price-range.price-enterprise { background: rgba(251, 191, 36, 0.1); color: #d97706; }
.price-range.price-custom { background: rgba(239, 68, 68, 0.1); color: #dc2626; }

.service-description {
    margin-bottom: 20px;
    color: #666;
    line-height: 1.6;
}

.service-actions {
    display: flex;
    gap: 15px;
    align-items: center;
}

.btn-learn-more {
    flex: 1;
    padding: 12px 20px;
    background: #f8f9fa;
    color: var(--primary-blue, #1a365d);
    text-decoration: none;
    border-radius: 8px;
    text-align: center;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-learn-more:hover {
    background: var(--primary-blue, #1a365d);
    color: white;
}

.btn-get-started {
    padding: 12px 20px;
    background: var(--accent-blue, #3182ce);
    color: white;
    text-decoration: none;
    border-radius: 8px;
    display: flex;
    align-items: center;
    gap: 8px;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-get-started:hover {
    background: var(--primary-blue, #1a365d);
    transform: translateX(2px);
}

.no-services {
    text-align: center;
    padding: 100px 20px;
}

.no-services-content {
    max-width: 500px;
    margin: 0 auto;
}

.no-services h2 {
    color: var(--primary-blue, #1a365d);
    margin-bottom: 20px;
}

.no-services-actions {
    margin-top: 30px;
    display: flex;
    gap: 20px;
    justify-content: center;
    flex-wrap: wrap;
}

.btn-all-services,
.btn-contact {
    padding: 15px 25px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-all-services {
    background: var(--accent-blue, #3182ce);
    color: white;
}

.btn-contact {
    background: transparent;
    color: var(--primary-blue, #1a365d);
    border: 2px solid var(--primary-blue, #1a365d);
}

.btn-all-services:hover,
.btn-contact:hover {
    transform: translateY(-2px);
}

/* Pagination */
.pagination {
    display: flex;
    justify-content: center;
    margin-top: 40px;
}

.pagination .page-numbers {
    display: inline-block;
    padding: 12px 18px;
    margin: 0 5px;
    background: white;
    color: var(--primary-blue, #1a365d);
    text-decoration: none;
    border-radius: 8px;
    border: 1px solid #ddd;
    transition: all 0.3s ease;
}

.pagination .page-numbers:hover,
.pagination .page-numbers.current {
    background: var(--accent-blue, #3182ce);
    color: white;
    border-color: var(--accent-blue, #3182ce);
    transform: translateY(-2px);
}

@media (max-width: 768px) {
    .archive-title {
        font-size: 2.5rem;
    }
    
    .services-grid {
        grid-template-columns: 1fr;
        gap: 30px;
    }
    
    .filter-tabs {
        justify-content: flex-start;
    }
    
    .service-actions {
        flex-direction: column;
    }
    
    .no-services-actions {
        flex-direction: column;
        align-items: center;
    }
}
</style>

<?php get_footer(); ?>