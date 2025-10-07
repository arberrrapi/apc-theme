<?php
/**
 * The template for displaying 404 pages (not found)
 */

get_header(); ?>

<section class="error-404">
    <div class="container">
        <div class="error-content">
            <h1 class="error-title">404</h1>
            <h2 class="error-subtitle"><?php esc_html_e('Oops! That page can&rsquo;t be found.', 'apc-theme'); ?></h2>
            <p class="error-text"><?php esc_html_e('It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'apc-theme'); ?></p>
            
            <div class="error-actions">
                <a href="<?php echo esc_url(home_url('/')); ?>" class="btn-primary">
                    <i class="fa-solid fa-home"></i>
                    <?php esc_html_e('Back to Home', 'apc-theme'); ?>
                </a>
                
                <div class="error-search">
                    <?php get_search_form(); ?>
                </div>
            </div>
            
            <div class="error-help">
                <h3><?php esc_html_e('Popular Pages', 'apc-theme'); ?></h3>
                <ul class="error-links">
                    <li><a href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('Home', 'apc-theme'); ?></a></li>
                    <li><a href="#about"><?php esc_html_e('About Us', 'apc-theme'); ?></a></li>
                    <li><a href="#solutions"><?php esc_html_e('Solutions', 'apc-theme'); ?></a></li>
                    <li><a href="#contact"><?php esc_html_e('Contact', 'apc-theme'); ?></a></li>
                </ul>
            </div>
        </div>
    </div>
</section>

<style>
.error-404 {
    padding: 100px 0;
    text-align: center;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    min-height: 60vh;
    display: flex;
    align-items: center;
}

.error-content {
    max-width: 600px;
    margin: 0 auto;
}

.error-title {
    font-size: 8rem;
    font-weight: bold;
    margin: 0;
    opacity: 0.8;
}

.error-subtitle {
    font-size: 2rem;
    margin: 20px 0;
}

.error-text {
    font-size: 1.1rem;
    margin: 30px 0;
    opacity: 0.9;
}

.error-actions {
    margin: 40px 0;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 20px;
}

.btn-primary {
    background: white;
    color: #667eea;
    padding: 15px 30px;
    border-radius: 25px;
    text-decoration: none;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 10px;
    transition: transform 0.3s ease;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.2);
}

.error-search {
    width: 100%;
    max-width: 400px;
}

.error-search input[type="search"] {
    width: 100%;
    padding: 15px;
    border: none;
    border-radius: 25px;
    text-align: center;
    font-size: 1rem;
}

.error-help {
    margin-top: 50px;
}

.error-help h3 {
    margin-bottom: 20px;
    font-size: 1.3rem;
}

.error-links {
    list-style: none;
    padding: 0;
    display: flex;
    justify-content: center;
    gap: 30px;
    flex-wrap: wrap;
}

.error-links a {
    color: white;
    text-decoration: none;
    opacity: 0.8;
    transition: opacity 0.3s ease;
}

.error-links a:hover {
    opacity: 1;
    text-decoration: underline;
}

@media (max-width: 768px) {
    .error-title {
        font-size: 4rem;
    }
    
    .error-subtitle {
        font-size: 1.5rem;
    }
    
    .error-links {
        flex-direction: column;
        gap: 15px;
    }
}
</style>

<?php get_footer(); ?>