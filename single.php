<?php
/**
 * The template for displaying all single posts
 */

get_header(); ?>

<?php while (have_posts()) : the_post(); 
    $content_type = get_post_meta(get_the_ID(), '_apc_content_type', true) ?: 'blog';
?>
    <article class="single-post content-type-<?php echo esc_attr($content_type); ?>">
        <div class="">
            <header class="post-header">
                <h1 class="post-title"><?php the_title(); ?></h1>
                
                <!-- Post Meta: Category and Type -->
                <div class="post-meta-tags">
                    <?php
                    // Get post categories
                    $categories = get_the_category();
                    if ($categories) {
                        foreach ($categories as $category) {
                            echo '<p class="meta-tag category-tag">' . esc_html($category->name) . '</p>';
                        }
                    }
                    
                    // Get post type
                    $type_labels = array(
                        'article' => 'Article',
                        'blog' => 'Blog Post',
                        'customer_success' => 'Customer Success',
                        'video' => 'Video',
                        'whitepaper' => 'Whitepaper'
                    );
                    $type_label = $type_labels[$content_type] ?? 'Blog Post';
                    echo '<p class="meta-tag type-tag">' . esc_html($type_label) . '</p>';
                    ?>
                </div>
                
                <?php if ($content_type !== 'video') : ?>
                   
                <?php endif; ?>
                
                <?php 
                // Display content type specific header content
                if ($content_type === 'video') {
                    $video_url = get_post_meta(get_the_ID(), '_video_url', true);
                    $video_duration = get_post_meta(get_the_ID(), '_video_duration', true);
                    
                    if ($video_url) : ?>
                        <div class="video-header">
                            <div class="video-container">
                                <?php 
                                // Check if it's a YouTube or Vimeo URL and create embed
                                if (preg_match('/youtube\.com\/watch\?v=([a-zA-Z0-9_-]+)/', $video_url, $matches)) {
                                    echo '<iframe width="100%" height="400" src="https://www.youtube.com/embed/' . esc_attr($matches[1]) . '" frameborder="0" allowfullscreen></iframe>';
                                } elseif (preg_match('/youtu\.be\/([a-zA-Z0-9_-]+)/', $video_url, $matches)) {
                                    echo '<iframe width="100%" height="400" src="https://www.youtube.com/embed/' . esc_attr($matches[1]) . '" frameborder="0" allowfullscreen></iframe>';
                                } elseif (preg_match('/vimeo\.com\/(\d+)/', $video_url, $matches)) {
                                    echo '<iframe width="100%" height="400" src="https://player.vimeo.com/video/' . esc_attr($matches[1]) . '" frameborder="0" allowfullscreen></iframe>';
                                } else {
                                    echo '<video width="100%" height="400" controls><source src="' . esc_url($video_url) . '" type="video/mp4"></video>';
                                }
                                ?>
                            </div>
                            <div class="video-meta">
                                <?php if ($video_duration) : ?>
                                    <span class="video-duration">
                                        <i class="fa-solid fa-clock"></i>
                                        Duration: <?php echo esc_html($video_duration); ?>
                                    </span>
                                <?php endif; ?>
                                <span class="post-date">
                                    <i class="fa-solid fa-calendar"></i>
                                    <?php echo get_the_date(); ?>
                                </span>
                            </div>
                        </div>
                    <?php endif;
                } elseif ($content_type === 'customer_success') {
                    $customer_company = get_post_meta(get_the_ID(), '_customer_company', true);
                    $customer_industry = get_post_meta(get_the_ID(), '_customer_industry', true);
                    $customer_logo = get_post_meta(get_the_ID(), '_customer_logo', true);
                    
                    if ($customer_company || $customer_logo) : ?>
                        <div class="customer-success-header">
                            <?php if ($customer_logo) : ?>
                                <div class="customer-logo">
                                    <img src="<?php echo esc_url($customer_logo); ?>" alt="<?php echo esc_attr($customer_company); ?> Logo">
                                </div>
                            <?php endif; ?>
                            <div class="customer-info">
                                <?php if ($customer_company) : ?>
                                    <h2 class="customer-company"><?php echo esc_html($customer_company); ?></h2>
                                <?php endif; ?>
                                <?php if ($customer_industry) : ?>
                                    <span class="customer-industry"><?php echo esc_html($customer_industry); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endif;
                } elseif ($content_type === 'whitepaper') {
                    $whitepaper_file = get_post_meta(get_the_ID(), '_whitepaper_file', true);
                    $whitepaper_size = get_post_meta(get_the_ID(), '_whitepaper_size', true);
                    
                    if ($whitepaper_file) : ?>
                        <div class="whitepaper-download">
                            <a href="<?php echo esc_url($whitepaper_file); ?>" class="download-button" target="_blank">
                                <i class="fa-solid fa-download"></i>
                                Download Whitepaper
                                <?php if ($whitepaper_size) : ?>
                                    <span class="file-size">(<?php echo esc_html($whitepaper_size); ?>)</span>
                                <?php endif; ?>
                            </a>
                        </div>
                    <?php endif;
                } ?>
                
                
            </header>
            
            <div class="post-content">
                <?php if (has_post_thumbnail() && $content_type !== 'video') : ?>
                    <div class="post-featured-image">
                        <?php the_post_thumbnail('full'); ?>
                    </div>
                <?php endif; ?>
                <div class="post-content-inner">
                <?php the_content(); ?>
                </div>
                <?php
                wp_link_pages(array(
                    'before' => '<div class="page-links">' . esc_html__('Pages:', 'apc-theme'),
                    'after'  => '</div>',
                ));
                ?>
            </div>
            
            <footer class="post-footer">
                <!-- Latest Resources Block -->
                <div class="latest-resources-section">
                    <div class="latest-resources-header">
                        <h2>Latest Resources</h2>
                        <p>Discover more insights and solutions</p>
                    </div>
                    
                    <div class="latest-resources-grid">
                        <?php
                        // Get latest posts excluding current post
                        $latest_posts = new WP_Query(array(
                            'post_type' => 'post',
                            'posts_per_page' => 3,
                            'post_status' => 'publish',
                            'post__not_in' => array(get_the_ID()), // Exclude current post
                            'orderby' => 'date',
                            'order' => 'DESC'
                        ));
                        
                        if ($latest_posts->have_posts()) :
                            while ($latest_posts->have_posts()) : $latest_posts->the_post();
                                $post_content_type = get_post_meta(get_the_ID(), '_apc_content_type', true) ?: 'blog';
                                $post_categories = get_the_category();
                        ?>
                            <article class="resource-card">
                                <?php if (has_post_thumbnail()) : ?>
                                    <div class="resource-image">
                                        <a href="<?php the_permalink(); ?>">
                                            <?php the_post_thumbnail('medium'); ?>
                                        </a>
                                    </div>
                                <?php endif; ?>
                                
                                <div class="resource-content">
                                    <!-- Content Type Badge -->
                                    <div class="resource-type-badge">
                                        <span>
                                        <?php 
                                        $type_labels = array(
                                            'article' => 'Article',
                                            'blog' => 'Blog Post',
                                            'customer_success' => 'Customer Success',
                                            'video' => 'Video',
                                            'whitepaper' => 'Whitepaper'
                                        );
                                        echo esc_html($type_labels[$post_content_type] ?? 'Blog Post');
                                        ?>
                                        </span>
                                    </div>
                                    
                                    <h3 class="resource-title">
                                        <a href="<?php the_permalink(); ?>">
                                            <?php the_title(); ?>
                                        </a>
                                    </h3>
                                    
                                  
                                    
                                </div>
                            </article>
                        <?php 
                            endwhile;
                            wp_reset_postdata();
                        endif;
                        ?>
                    </div>
                </div>
            </footer>
            
            <?php
            // If comments are open or we have at least one comment, load up the comment template.
            if (comments_open() || get_comments_number()) :
                comments_template();
            endif;
            ?>
        </div>
    </article>
<?php endwhile; ?>

<style>
    
/* Post Meta Tags Styling */
.post-meta-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
    margin: 1.5rem 0;
    justify-content: flex-start;
    align-items: center;
}

.meta-tag {
    margin: 0;
    padding: 12px 20px;
    border-radius: 25px;
    font-size: 14px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border: 2px solid transparent;
    background: white;
    position: relative;
}

/* Alternative gradient border approach for better browser support */
.meta-tag {
    background: linear-gradient(white, white) padding-box, 
                linear-gradient(90deg, var(--secondary-color) 0%, var(--brand-color) 100%) border-box;
    border: 2px solid transparent;
}

/* All tags use the same gradient */
.category-tag {
    background: linear-gradient(white, white) padding-box, 
                linear-gradient(90deg, var(--secondary-color) 0%, var(--brand-color) 100%) border-box;
}

.type-tag {
    background: linear-gradient(white, white) padding-box, 
                linear-gradient(90deg, var(--secondary-color) 0%, var(--brand-color) 100%) border-box;
}

/* Hover effects */
.meta-tag:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
}

/* Featured Image Styling with Parallax */
.post-featured-image {
    width: 100%;
    height: 600px;
    margin-bottom: 2rem;
    overflow: hidden;
    border-radius: 25px;
    position: relative;
}

.post-featured-image img {
    width: 100%;
    height: calc(100% + 200px);
    min-height: 800px;
    border-radius: 25px;
    display: block;
    object-fit: cover;
    object-position: center top;
    position: absolute;
    top: -100px;
    left: 0;
    will-change: transform;
    transition: none;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .post-meta-tags {
        justify-content: left;
        margin: 1rem 0;
    }
    
    .meta-tag {
        padding: 10px 16px;
        font-size: 12px;
    }
    
    /* Parallax responsive adjustments */
    @media (max-width: 768px) {
        .post-featured-image {
            height: 400px;
        }
        
        .post-featured-image img {
            height: 110%;
        }
    }
}

/* Latest Resources Styling */
.latest-resources-section {
    margin-top: 4rem;
    padding: 3rem 0;
}

.latest-resources-header {
    text-align: left;
    margin-bottom: 2rem;
}

.latest-resources-header h2 {
    font-size: 48px;
    font-weight: 700;
    color: var(--text-color);
    margin-bottom: 0.5rem;
}

.latest-resources-header p {
    font-size: 20px;
    color: #666;
    margin: 0;
}

.latest-resources-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 2rem;
    margin-top: 2rem;
}

.resource-card {
    background: white;
    border-radius: 25px;
    overflow: hidden;
    transition: all 0.3s ease;
}

.resource-card:hover {
}

.resource-image {
    position: relative;
    overflow: hidden;
    height: 200px;
}

.resource-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.resource-card:hover .resource-image img {
    transform: scale(1.05);
}

.resource-content {
    padding: 1.5rem;
}

.resource-type-badge {
    display: inline-block;
    font-size: 12px;
    font-weight: 600;
    padding: 0;
    border-radius: 15px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: var(--brand-color);
    background: linear-gradient(90deg, var(--secondary-color) 0%, var(--brand-color) 100%);
    transition: all 0.3s ease;
    position: relative;
    margin-bottom: 1rem;
}

.resource-type-badge span {
    display: block;
    background: white;
    padding: 6px 12px;
    border-radius: 13px;
    margin: 2px;
}

.resource-title {
    margin: 0 0 1rem 0;
    font-size: 24px;
    font-weight: 300;
}

.resource-title a {
    color: var(--text-color);
    text-decoration: none;
    transition: color 0.3s ease;
}

.resource-title a:hover {
    color: var(--brand-color);
}

.resource-categories {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
    margin-bottom: 1rem;
}

.resource-category {
    background: #f8f9fa;
    color: #666;
    padding: 4px 8px;
    border-radius: 12px;
    font-size: 12px;
    font-weight: 500;
}

.resource-date {
    color: #999;
    font-size: 14px;
    font-weight: 500;
}

/* Responsive Design for Latest Resources */
@media (max-width: 1024px) {
    .latest-resources-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 1.5rem;
    }
}

@media (max-width: 768px) {
    .latest-resources-section {
        margin-top: 2rem;
        padding: 2rem 0;
    }
    
    .latest-resources-header h2 {
        font-size: 36px;
    }
    
    .latest-resources-header p {
        font-size: 18px;
    }
    
    .latest-resources-grid {
        grid-template-columns: 1fr;
        gap: 1rem;
    }
    
    .resource-image {
        height: 180px;
    }
    
    .resource-content {
        padding: 1rem;
    }
    
    .resource-title {
        font-size: 18px;
    }
}


</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const featuredImage = document.querySelector('.post-featured-image img');
    const featuredContainer = document.querySelector('.post-featured-image');
    
    if (!featuredImage || !featuredContainer) return;
    
    console.log('Parallax initialized'); // Debug log
    
    function updateParallax() {
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        const containerRect = featuredContainer.getBoundingClientRect();
        const containerTop = containerRect.top + scrollTop;
        const windowHeight = window.innerHeight;
        
        // Check if container is in viewport (with some buffer)
        if (containerRect.bottom > -200 && containerRect.top < windowHeight + 200) {
            // Calculate parallax offset
            // When scrollTop = containerTop, parallax should be 0
            // As we scroll past, image should move slower (creating parallax effect)
            const parallaxSpeed = 0.5; // 50% of scroll speed
            const yOffset = (scrollTop - containerTop) * parallaxSpeed;
            
            // Apply transform
            featuredImage.style.transform = `translateY(${yOffset}px)`;
            
            console.log('Parallax offset:', yOffset); // Debug log
        }
    }
    
    // Simple scroll handler
    function handleScroll() {
        requestAnimationFrame(updateParallax);
    }
    
    window.addEventListener('scroll', handleScroll, { passive: true });
    window.addEventListener('resize', updateParallax);
    window.addEventListener('load', updateParallax);
    
    // Initial call
    setTimeout(updateParallax, 100);
});
</script>

<?php get_footer(); ?>