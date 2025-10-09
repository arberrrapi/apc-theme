<?php
/**
 * Render callback for Featured About Hero block
 */

$chips = $attributes['chips'] ?? [];
if (empty($chips) || count($chips) < 10) {
    echo '<!-- Not enough chips data found -->';
    return '';
}

// Debug output (remove this in production)
echo '<!-- Featured About Hero Block: ' . count($chips) . ' chips -->';
?>
<div class="featured-about-hero-block">
  <!-- Row 1: 4 columns with widths 10%, 40%, 10%, 40% -->
  <div class="hero-row row1">
   <h1>
    <span class="image">
    <img src="<?php echo site_url('/wp-content/uploads/2025/10/apc_real_estate.jpg'); ?>" alt=""/>
</span>
<span class="chip">Solving</span>
<span class="image">
    <img src="<?php echo site_url('/wp-content/uploads/2025/10/apc_real_estate.jpg'); ?>" alt=""/>
</span>
<span class="chip">business</span>
<span class="chip">challenges</span>
<span class="chip">using</span>
<span class="chip">Microsoft</span>
<span class="chip">technology</span>
<span class="image">
    <img src="<?php echo site_url('/wp-content/uploads/2025/10/apc_real_estate.jpg'); ?>" alt=""/>
</span>
<span class="chip">for over 25 years</span>
</h1>
</div>
    