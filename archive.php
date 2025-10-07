<?php
/**
 * The template for displaying archive pages
 */

get_header(); ?>

<section class="archive-page">
    <div class="container">
        <header class="archive-header">
            <h1 class="archive-title">
                <?php
                if (is_category()) {
                    printf(esc_html__('Category: %s', 'apc-theme'), single_cat_title('', false));
                } elseif (is_tag()) {
                    printf(esc_html__('Tag: %s', 'apc-theme'), single_tag_title('', false));
                } elseif (is_author()) {
                    printf(esc_html__('Author: %s', 'apc-theme'), get_the_author());
                } elseif (is_date()) {
                    if (is_year()) {
                        printf(esc_html__('Year: %s', 'apc-theme'), get_the_date('Y'));
                    } elseif (is_month()) {
                        printf(esc_html__('Month: %s', 'apc-theme'), get_the_date('F Y'));
                    } else {
                        printf(esc_html__('Day: %s', 'apc-theme'), get_the_date());
                    }
                } else {
                    esc_html_e('Archives', 'apc-theme');
                }
                ?>
            </h1>
            
            <?php
            // Display category/tag description
            $description = get_the_archive_description();
            if ($description) :
            ?>
                <div class="archive-description">
                    <?php echo $description; ?>
                </div>
            <?php endif; ?>
        </header>

        <div class="archive-content">
            <?php if (have_posts()) : ?>
                <div class="posts-grid">
                    <?php while (have_posts()) : the_post(); ?>
                        <article class="post-card">
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="post-thumbnail">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_post_thumbnail('medium'); ?>
                                    </a>
                                </div>
                            <?php endif; ?>
                            
                            <div class="post-content">
                                <h2 class="post-title">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h2>
                                
                                <div class="post-meta">
                                    <span class="post-date">
                                        <i class="fa-solid fa-calendar"></i>
                                        <?php echo get_the_date(); ?>
                                    </span>
                                    <span class="post-author">
                                        <i class="fa-solid fa-user"></i>
                                        <?php the_author(); ?>
                                    </span>
                                    <?php if (has_category() && !is_category()) : ?>
                                        <span class="post-categories">
                                            <i class="fa-solid fa-folder"></i>
                                            <?php the_category(', '); ?>
                                        </span>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="post-excerpt">
                                    <?php the_excerpt(); ?>
                                </div>
                                
                                <a href="<?php the_permalink(); ?>" class="read-more">
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
                <div class="no-posts">
                    <h2><?php esc_html_e('No Posts Found', 'apc-theme'); ?></h2>
                    <p><?php esc_html_e('No posts were found in this archive. Please try searching for something else.', 'apc-theme'); ?></p>
                    
                    <div class="search-form-wrapper">
                        <?php get_search_form(); ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<style>
.archive-page {
    padding: 60px 0;
    background: #f8f9fa;
    min-height: 60vh;
}

.archive-header {
    text-align: center;
    margin-bottom: 50px;
    padding-bottom: 30px;
    border-bottom: 1px solid #ddd;
}

.archive-title {
    font-size: 2.5rem;
    color: var(--primary-blue, #1a365d);
    margin-bottom: 20px;
}

.archive-description {
    max-width: 600px;
    margin: 0 auto;
    color: #666;
    line-height: 1.6;
}

.posts-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 30px;
    margin-bottom: 40px;
}

.post-card {
    background: white;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    transition: transform 0.3s ease;
}

.post-card:hover {
    transform: translateY(-5px);
}

.post-thumbnail {
    position: relative;
    overflow: hidden;
}

.post-thumbnail img {
    width: 100%;
    height: 200px;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.post-card:hover .post-thumbnail img {
    transform: scale(1.05);
}

.post-card .post-content {
    padding: 25px;
}

.post-card .post-title {
    margin: 0 0 15px 0;
    font-size: 1.3rem;
}

.post-card .post-title a {
    color: var(--primary-blue, #1a365d);
    text-decoration: none;
}

.post-card .post-title a:hover {
    color: var(--accent-blue, #3182ce);
}

.post-card .post-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
    margin-bottom: 15px;
    font-size: 0.9rem;
    color: #666;
}

.post-card .post-meta span {
    display: flex;
    align-items: center;
    gap: 5px;
}

.post-card .post-excerpt {
    margin-bottom: 20px;
    color: #555;
    line-height: 1.6;
}

.post-card .read-more {
    color: var(--accent-blue, #3182ce);
    text-decoration: none;
    font-weight: 500;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    transition: gap 0.3s ease;
}

.post-card .read-more:hover {
    gap: 10px;
}

.no-posts {
    text-align: center;
    background: white;
    padding: 60px 40px;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.no-posts h2 {
    color: var(--primary-blue, #1a365d);
    margin-bottom: 20px;
}

.search-form-wrapper {
    max-width: 400px;
    margin: 30px auto 0;
}

/* Pagination */
.pagination {
    display: flex;
    justify-content: center;
    margin-top: 40px;
}

.pagination .page-numbers {
    display: inline-block;
    padding: 8px 16px;
    margin: 0 4px;
    background: white;
    color: var(--primary-blue, #1a365d);
    text-decoration: none;
    border-radius: 4px;
    border: 1px solid #ddd;
    transition: all 0.3s ease;
}

.pagination .page-numbers:hover,
.pagination .page-numbers.current {
    background: var(--accent-blue, #3182ce);
    color: white;
    border-color: var(--accent-blue, #3182ce);
}

@media (max-width: 768px) {
    .posts-grid {
        grid-template-columns: 1fr;
    }
    
    .archive-title {
        font-size: 2rem;
    }
    
    .post-card .post-meta {
        flex-direction: column;
        gap: 8px;
    }
}
</style>

<?php get_footer(); ?>