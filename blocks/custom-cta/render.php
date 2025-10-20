<?php
/**
 * Render callback for Custom CTA block
 */

$title = $attributes['title'] ?? 'Ready to transform your IT infrastructure?';
$buttonText = $attributes['buttonText'] ?? 'Get Started';
$buttonLink = $attributes['buttonLink'] ?? '#contact';
$buttonType = $attributes['buttonType'] ?? 'url';
$buttonPage = $attributes['buttonPage'] ?? 0;

// Determine the final button URL
$finalButtonUrl = '';
if ($buttonType === 'page' && !empty($buttonPage)) {
    $finalButtonUrl = get_permalink($buttonPage);
} elseif ($buttonType === 'url' && !empty($buttonLink)) {
    $finalButtonUrl = $buttonLink;
}
?>

<div class="custom-cta-block">
    <div class="custom-cta-container">
        <div class="custom-cta-content">
            <h2 class="custom-cta-title"><?php echo esc_html($title); ?></h2>
            <?php if (!empty($finalButtonUrl)) : ?>
                <a href="<?php echo esc_url($finalButtonUrl); ?>" class="custom-cta-button">
                    <?php echo esc_html($buttonText); ?>
                </a>
            <?php endif; ?>
        </div>
    </div>
</div>
