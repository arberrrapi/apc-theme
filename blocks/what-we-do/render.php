<?php
/**
 * Render callback for What We Do block
 */

$label = $attributes['label'] ?? 'What we do';
$title = $attributes['title'] ?? 'Complexity, Simplified and Secured';
$imageUrl = $attributes['imageUrl'] ?? get_template_directory_uri() . '/assets/img/site/what_we_do.png';

$card1Icon = $attributes['card1Icon'] ?? 'fa-solid fa-users';
$card1Title = $attributes['card1Title'] ?? 'Expert Team';
$card1Text = $attributes['card1Text'] ?? 'Our experienced professionals deliver exceptional results with cutting-edge technology solutions.';

$card2Icon = $attributes['card2Icon'] ?? 'fa-solid fa-shield-halved';
$card2Title = $attributes['card2Title'] ?? 'Secure Solutions';
$card2Text = $attributes['card2Text'] ?? 'Enterprise-grade security measures ensure your data and systems remain protected at all times.';

$card3Icon = $attributes['card3Icon'] ?? 'fa-solid fa-rocket';
$card3Title = $attributes['card3Title'] ?? 'Fast Implementation';
$card3Text = $attributes['card3Text'] ?? 'Rapid deployment and seamless integration to get your business up and running quickly.';
?>

<!-- What We Do Section -->
<section class="what-we-do">
    <div class="what-we-do-container">
        <div class="what-we-do-content">
            <div class="what-we-do-text">
                <div class="section-label"><?php echo esc_html($label); ?></div>
                <h2 class="section-title"><?php echo esc_html($title); ?></h2>
            </div>
            <div class="what-we-do-image">
                <img src="<?php echo esc_url($imageUrl); ?>" alt="<?php echo esc_attr($title); ?>" />
            </div>
        </div>
    </div>
</section>

<section class="what-we-do-info">
    <div class="what-we-do-info-container">
        <div class="info-column">
            <div class="info-card">
                <i class="<?php echo esc_attr($card1Icon); ?>"></i>
                <div class="info-content">
                    <h4><?php echo esc_html($card1Title); ?></h4>
                    <p><?php echo esc_html($card1Text); ?></p>
                </div>
            </div>
        </div>
        <div class="info-column">
            <div class="info-card">
                <i class="<?php echo esc_attr($card2Icon); ?>"></i>
                <div class="info-content">
                    <h4><?php echo esc_html($card2Title); ?></h4>
                    <p><?php echo esc_html($card2Text); ?></p>
                </div>
            </div>
        </div>
        <div class="info-column">
            <div class="info-card">
                <i class="<?php echo esc_attr($card3Icon); ?>"></i>
                <div class="info-content">
                    <h4><?php echo esc_html($card3Title); ?></h4>
                    <p><?php echo esc_html($card3Text); ?></p>
                </div>
            </div>
        </div>
    </div>
</section>
