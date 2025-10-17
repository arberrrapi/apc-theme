<?php
/**
 * Render callback for Featured About Hero block
 */

$chips = $attributes['chips'] ?? [];
if (empty($chips) || count($chips) < 10) {
    echo '<!-- Not enough chips data found -->';
    return '';
}
?>
<div class="featured-about-hero-block">
  <div class="hero-row row1">
   <h1>
    <?php
    // Render chips 0-9 for the first line
    for ($i = 0; $i < 10 && $i < count($chips); $i++) {
        $chip = $chips[$i];
        
        if (!isset($chip['type'])) {
            continue;
        }
        
        if ($chip['type'] === 'image') {
            $url = $chip['url'] ?? '';
            $alt = $chip['alt'] ?? '';
            if (!empty($url)) {
                echo '<span class="image"><img src="' . esc_url($url) . '" alt="' . esc_attr($alt) . '"/></span>';
            } else {
                echo '<span class="image"><img src="' . esc_url(get_template_directory_uri() . '/assets/img/placeholder.jpg') . '" alt="Placeholder"/></span>';
            }
        } elseif ($chip['type'] === 'text') {
            $text = $chip['text'] ?? '';
            echo '<span class="chip">' . wp_kses_post($text) . '</span>';
        }
    }
    ?>
</h1>
</div>
</div>
    