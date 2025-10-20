<?php
/**
 * Blog Posts Page Template
 * 
 * This template is used for displaying the blog posts listing page.
 * 
 * @package APC_Theme
 */

get_header(); ?>

<main id="primary" class="site-main">
    
    <!-- Page Header -->
    <section class="page-header blog-header">
        <div class="">
            <div class="page-header-content">
                <h1 class="page-title">
                    <?php 
                    if (is_home() && !is_front_page()) {
                        echo get_the_title(get_option('page_for_posts'));
                    } else {
                        _e('Latest Posts', 'apc-theme');
                    }
                    ?>
                </h1>
                
                
                <!-- Search Form -->
                <div class="blog-search-container">
                    <?php get_template_part('template-parts/search-form'); ?>
                </div>
            </div>
        </div>
    </section>

    <!-- Blog Posts Grid -->
    <section class="blog-posts-section">
        <div class="">
            
            <?php if (have_posts()) : ?>
                
                <!-- Filter Controls -->
                <div class="blog-filters">
                    <div class="filter-container">
                        <div class="filter-controls">
                            <button id="all-button" class="all-button">
                                <i class="fa-solid fa-list"></i> All
                            </button>
                            <select id="post-type-select" class="filter-select" data-type="post_type">
                                <option value="all">All Types</option>
                                <option value="article">Articles</option>
                                <option value="blog">Blog Posts</option>
                                <option value="customer_success">Customer Success</option>
                                <option value="video">Videos</option>
                                <option value="whitepaper">Whitepapers</option>
                            </select>
                            
                            <select id="category-select" class="filter-select" data-type="category">
                                <option value="all">All Categories</option>
                                <?php
                                $categories = get_categories(array(
                                    'hide_empty' => true,
                                    'orderby' => 'name',
                                    'order' => 'ASC'
                                ));
                                foreach ($categories as $category) :
                                ?>
                                    <option value="<?php echo esc_attr($category->slug); ?>">
                                        <?php echo esc_html($category->name); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            
                            
                        </div>
                    </div>
                </div>
                
                <div class="blog-posts-grid" id="blog-posts-container">
                    <!-- Loading State -->
                    <div class="loading-state" id="loading-state" style="display: none;">
                        <div class="loading-spinner"></div>
                        <p>Loading posts...</p>
                    </div>
                    
                    <?php while (have_posts()) : the_post(); 
                        $content_type = get_post_meta(get_the_ID(), '_apc_content_type', true) ?: 'blog';
                        $post_categories = get_the_category();
                        $category_slugs = array();
                        foreach ($post_categories as $cat) {
                            $category_slugs[] = $cat->slug;
                        }
                    ?>
                        
                        <article id="post-<?php the_ID(); ?>" 
                                <?php post_class('blog-post-card'); ?>
                                data-post-type="<?php echo esc_attr($content_type); ?>"
                                data-categories="<?php echo esc_attr(implode(',', $category_slugs)); ?>"
                                data-post-id="<?php the_ID(); ?>">
                            
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="post-thumbnail">
                                    <a href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
                                        <?php the_post_thumbnail('medium_large'); ?>
                                    </a>
                                </div>
                            <?php endif; ?>
                            
                            <!-- Content Type Badge -->
                            <div class="post-type-badge-container">
                                <?php 
                                $type_labels = array(
                                    'article' => 'Article',
                                    'blog' => 'Blog Post',
                                    'customer_success' => 'Customer Success',
                                    'video' => 'Video',
                                    'whitepaper' => 'Whitepaper'
                                );
                                ?>
                                <div class="post-type-badge post-type-<?php echo esc_attr($content_type); ?>">
                                    <span><?php echo esc_html($type_labels[$content_type] ?? 'Blog Post'); ?></span>
                                </div>
                            </div>
                            
                            <div class="post-content">
                                
                                <h2 class="post-title">
                                    <a href="<?php the_permalink(); ?>" rel="bookmark">
                                        <?php the_title(); ?>
                                    </a>
                                </h2>
                                
                            </div>
                            
                        </article>
                        
                    <?php endwhile; ?>
                </div>
                
                <!-- Pagination -->
                <div class="blog-pagination">
                    <?php
                    the_posts_pagination(array(
                        'mid_size' => 2,
                        'prev_text' => __('&laquo; Previous', 'apc-theme'),
                        'next_text' => __('Next &raquo;', 'apc-theme'),
                    ));
                    ?>
                </div>
                
            <?php else : ?>
                
                <!-- No Posts Found -->
                <div class="no-posts-found">
                    <h2><?php _e('Nothing Found', 'apc-theme'); ?></h2>
                    <p><?php _e('It looks like nothing was found at this location. Maybe try a search?', 'apc-theme'); ?></p>
                    <?php get_search_form(); ?>
                </div>
                
            <?php endif; ?>
            
        </div>
    </section>

</main>

<style>
/* Blog Posts Page Styles */
.blog-header {
    background: white;
    color: #333;
    padding: 80px 0 60px;
    text-align: center;
    position: relative;
    border: 2px solid transparent;
    background-clip: padding-box;
}

.blog-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background:linear-gradient(
    90deg,
    var(--secondary-color) 0%,
    var(--brand-color) 100%
  );
    border-radius: inherit;
    z-index: -1;
    margin: -2px;
}

.blog-header .page-title {
    font-size: 96px;
    font-weight: 900;
    margin-bottom: 1rem;
    color: var(--text-color);
}

.blog-header .page-description {
    font-size: 1.2rem;
    opacity: 0.9;
    max-width: 600px;
    margin: 0 auto 2rem;
}

.blog-search-container {
    max-width: 500px;
    margin: 0 auto;
}

.blog-search-container .apc-search-container {
    max-width: 100%;
}

.blog-search-container .search-input-container {
    background: white;
    border: 2px solid #e9ecef;

}

.blog-search-container .search-input-container:focus-within {
    border: 2px solid transparent;
    background: linear-gradient(white, white) padding-box,
                linear-gradient(90deg, var(--secondary-color) 0%, var(--brand-color) 100%) border-box;
}

.blog-search-container .apc-search-input {
    color: #333;
}

.blog-search-container .apc-search-input::placeholder {
    color: #666;
}

.blog-posts-section {
    padding: 80px 0;
}

.blog-posts-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 2rem;
    margin-bottom: 3rem;
}

.blog-post-card {
    background: white;
    overflow: hidden;
    transition: transform 0.3s ease;
}

.blog-post-card:hover {
}

.blog-post-card .post-thumbnail {
    overflow: hidden;
    border-radius: 25px;
}

.blog-post-card .post-thumbnail img {
    width: 100%;
    height: 350px;
    border-radius: 25px;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.blog-post-card:hover .post-thumbnail img {
    transform: scale(1.05);
}

.blog-post-card .post-content {
    padding: 1rem 0;
}

.post-title {
    font-size: 25px;
    font-weight: 300;
    margin: 0;
}

.post-title a {
    color: #333;
    text-decoration: none;
    transition: color 0.3s ease;
}

.post-title a:hover {
    color: var(--brand-color);
}

.blog-pagination {
    text-align: center;
    margin-top: 3rem;
}

.blog-pagination .nav-links {
    display: flex;
    justify-content: center;
    gap: 0.5rem;
    flex-wrap: wrap;
}

.blog-pagination .page-numbers {
    padding: 0.75rem 1rem;
    border: 1px solid #ddd;
    background: white;
    color: #333;
    text-decoration: none;
    border-radius: 6px;
    transition: all 0.3s ease;
}

.blog-pagination .page-numbers:hover,
.blog-pagination .page-numbers.current {
    background: #2119d4;
    color: white;
    border-color: #2119d4;
}

.no-posts-found {
    text-align: center;
    padding: 3rem;
    background: #f8f9fa;
    border-radius: 12px;
}

.no-posts-found h2 {
    color: #333;
    margin-bottom: 1rem;
}

/* Post Type Badge Styles */
.post-type-badge-container {
    padding-top: 1.5rem;
    z-index: 10;
}

.post-type-badge {
    display: inline-block;
    font-size: 14px;
    font-weight: 600;
    padding: 0;
    border-radius: 25px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: #333;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    transition: all 0.3s ease;
    position: relative;
}

.post-type-badge span {
    display: block;
    background: white;
    padding: 8px 10px;
    border-radius: 23px;
    margin: 2px;
}

/* Different gradient border colors for each content type */
.post-type-badge.post-type-article {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
}

.post-type-badge.post-type-blog {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.post-type-badge.post-type-customer_success {
    background: linear-gradient(135deg, #fd7e14 0%, #e83e8c 100%);
}

.post-type-badge.post-type-video {
    background: linear-gradient(135deg, #dc3545 0%, #fd7e14 100%);
}

.post-type-badge.post-type-whitepaper {
    background: linear-gradient(135deg, #6f42c1 0%, #e83e8c 100%);
}

.blog-post-card:hover .post-type-badge {
}

/* Blog Filter Styles */
.blog-filters {
   
    margin-bottom: 3rem;
}

.filter-container {
    width: 50%;
}

.filter-controls {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.filter-select {
    background: white;
    border-radius: 12px;
    padding: 0.75rem 1rem;
    font-size: 24px;
    font-weight: 300;
    color: #333;
    cursor: pointer;
    transition: all 0.3s ease;
    outline: none;
    background-image: linear-gradient(45deg, transparent 50%, #667eea 50%), 
                      linear-gradient(135deg, #667eea 50%, transparent 50%);
    background-position: calc(100% - 15px) calc(1em + 1px), 
                         calc(100% - 10px) calc(1em + 1px);
    background-size: 5px 5px, 5px 5px;
    background-repeat: no-repeat;
    padding-right: 2rem;
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;
    min-width: 140px;
    height: auto;
}

.filter-select:hover {
    border-color: #667eea;
    transform: translateY(-2px) scale(1.02);
}

.filter-select:focus {
    border-color: #667eea;
    transform: translateY(-2px) scale(1.02);
}

.filter-select option {
    padding: 0.75rem;
    font-weight: 500;
}

.all-button {
    background: linear-gradient(135deg, var(--secondary-color, #00c8ff) 0%, var(--brand-color, #2119d4) 100%);
    color: white;
    border: none;
    padding: 0.75rem 1.25rem;
    border-radius: 12px;
    font-size: 24px;
    font-weight: 300;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.all-button:hover {
    transform: translateY(-2px);
}

.all-button:active {
    transform: translateY(0);
}



/* Loading State */
.loading-state {
    grid-column: 1 / -1;
    text-align: center;
    padding: 3rem;
    color: #666;
}

.loading-spinner {
    width: 40px;
    height: 40px;
    border: 4px solid #f3f3f3;
    border-top: 4px solid #667eea;
    border-radius: 50%;
    animation: spin 1s linear infinite;
    margin: 0 auto 1rem;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Scale-based Filter Animation */
.blog-post-card {
    transition: transform 0.3s ease;
    transform-origin: center;
}

.blog-post-card.hide {
    animation: hide 0.3s ease 0s 1 normal forwards;
    transform-origin: center;
}

.blog-post-card.show {
    animation: show 0.3s ease 0s 1 normal forwards;
    transform-origin: center;
}

@keyframes hide {
    0% {
        transform: scale(1);
        opacity: 1;
    }
    100% {
        transform: scale(0);
        opacity: 0;
        width: 0;
        height: 0;
        margin: 0;
    }
}

@keyframes show {
    0% {
        transform: scale(0);
        opacity: 0;
        width: 0;
        height: 0;
        margin: 0;
    }
    100% {
        transform: scale(1);
        opacity: 1;
    }
}

/* Hover effects */
.blog-post-card:hover {
}

.blog-post-card:hover .post-thumbnail img {
    transform: scale(1.05);
}

/* Empty Filter Results */
.empty-filter-results {
    grid-column: 1 / -1;
    text-align: center;
    padding: 4rem 2rem;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-radius: 20px;
    border: 2px dashed #dee2e6;
    margin: 2rem 0;
    transform-origin: center;
    will-change: transform, opacity;
}

.empty-filter-results .empty-icon {
    font-size: 3rem;
    color: #adb5bd;
    margin-bottom: 1rem;
    opacity: 0.7;
    transform: translateY(0);
    transition: transform 0.3s ease;
}

.empty-filter-results h3 {
    color: #495057;
    font-size: 1.5rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
    transform: translateY(10px);
    opacity: 0;
    animation: slideUpFade 0.6s ease 0.2s forwards;
}

.empty-filter-results p {
    color: #6c757d;
    font-size: 1rem;
    margin: 0;
    transform: translateY(10px);
    opacity: 0;
    animation: slideUpFade 0.6s ease 0.4s forwards;
}

/* Smooth slide up animation for text elements */
@keyframes slideUpFade {
    from {
        transform: translateY(10px);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 0.8;
    }
}

/* Icon gentle bounce when empty message appears */
.empty-filter-results:not([style*="opacity: 0"]) .empty-icon {
    animation: gentleBounce 0.8s ease 0.1s;
}

@keyframes gentleBounce {
    0%, 100% {
        transform: translateY(0);
    }
    50% {
        transform: translateY(-5px);
    }
}

/* Responsive Design */
@media (max-width: 1024px) {
    .blog-posts-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 768px) {

.blog-post-card .post-thumbnail img {
    height: 150px;
}

    .blog-header {
        padding: 40px 20px;
    }
    
    .blog-header .page-title {
        font-size: 2rem;
    }
    
    .blog-posts-grid {
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }
    
    .blog-posts-section {
        padding: 40px 0;
    }
    
    .blog-filters {
        margin-bottom: 2rem;
    }
    
    .filter-container {
        width: 100%;
    }
    
    .filter-controls {
        flex-direction: column;
        gap: 1rem;
        align-items: stretch;
    }
    
    .filter-select {
        font-size: 18px;
        padding: 0.65rem 1rem;
        padding-right: 1.75rem;
        min-width: auto;
    }
    
    .all-button {
        padding: 0.65rem 1rem;
        font-size: 18px;
        justify-content: center;
    }

    

}
</style>

<?php get_footer(); ?>