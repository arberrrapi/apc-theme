<?php
/**
 * Q&A Display Block Render Function
 * 
 * @package APC_Theme
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Render the Q&A Display block
 */
function apc_render_qa_display_block($attributes) {
    $title = isset($attributes['title']) ? $attributes['title'] : 'Explore Answers';
    $description = isset($attributes['description']) ? $attributes['description'] : 'Here’s What You Need to Know About Our Managed IT Services';
    $show_all_categories = isset($attributes['showAllCategories']) ? $attributes['showAllCategories'] : true;
    $selected_categories = isset($attributes['selectedCategories']) ? $attributes['selectedCategories'] : array();
    $items_per_page = isset($attributes['itemsPerPage']) ? intval($attributes['itemsPerPage']) : 10;
    $accordion_style = isset($attributes['accordionStyle']) ? $attributes['accordionStyle'] : true;

    // Prepare query arguments
    $query_args = array(
        'post_type' => 'qa',
        'posts_per_page' => $items_per_page,
        'post_status' => 'publish',
        'orderby' => 'date',
        'order' => 'DESC'
    );

    // Add taxonomy query if specific categories are selected
    if (!$show_all_categories && !empty($selected_categories)) {
        $query_args['tax_query'] = array(
            array(
                'taxonomy' => 'qa_category',
                'field'    => 'term_id',
                'terms'    => $selected_categories,
            ),
        );
    }

    $qa_query = new WP_Query($query_args);

    if (!$qa_query->have_posts()) {
        return '';
    }

    ob_start();
    ?>
    <div class="qa-display-wrapper">
        <div class="">
            <div class="qa-display-header">
                <?php if (!empty($title)) : ?>
                    <h2 class="qa-display-title"><?php echo wp_kses_post($title); ?></h2>
                <?php endif; ?>
                <?php if (!empty($description)) : ?>
                    <p class="qa-display-description"><?php echo wp_kses_post($description); ?></p>
                <?php endif; ?>
            </div>
            
            <div class="qa-display-content">
                <div class="<?php echo $accordion_style ? 'qa-accordion' : 'qa-list'; ?>">
                    <?php while ($qa_query->have_posts()) : $qa_query->the_post();
                        // Always use post title as question and post content as answer
                        $display_question = get_the_title();
                        $display_answer = get_the_content();
                        
                        if (empty($display_question)) continue;
                    ?>
                        <div class="<?php echo $accordion_style ? 'qa-accordion-item' : 'qa-list-item'; ?>">
                            <?php if ($accordion_style) : ?>
                            <div class="qa-accordion-item-inner">
                            <?php endif; ?>
                                <div class="<?php echo $accordion_style ? 'qa-accordion-header' : 'qa-question'; ?>" 
                                     <?php if ($accordion_style) : ?>onclick="toggleQAItem(this)"<?php endif; ?>>
                                    <p><?php echo esc_html($display_question); ?></p>
                                </div>
                                <div class="<?php echo $accordion_style ? 'qa-accordion-content' : 'qa-answer'; ?>">
                                    <div class="qa-answer-text">
                                        <?php echo wp_kses_post($display_answer); ?>
                                    </div>
                                </div>
                            <?php if ($accordion_style) : ?>
                            </div>
                            <?php endif; ?>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
        </div>
    </div>

    <?php if ($accordion_style) : ?>
    <script>
    function toggleQAItem(header) {
        const item = header.parentElement.parentElement;
        const content = item.querySelector('.qa-accordion-content');
        const isActive = item.classList.contains('active');
        
        // Close all other accordion items
        document.querySelectorAll('.qa-accordion-item.active').forEach(function(activeItem) {
            if (activeItem !== item) {
                activeItem.classList.remove('active');
            }
        });
        
        // Toggle current item
        if (isActive) {
            item.classList.remove('active');
        } else {
            item.classList.add('active');
        }
    }
    </script>
    <?php endif; ?>

    <?php
    wp_reset_postdata();
    return ob_get_clean();
}
?>