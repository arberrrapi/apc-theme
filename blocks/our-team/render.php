<?php
/**
 * Render callback for Our Team block
 */

$team_members = $attributes['teamMembers'] ?? [];
$title = $attributes['title'] ?? 'Our Team';
$description = $attributes['description'] ?? 'Meet the talented professionals behind our success.';
if (empty($team_members)) {
    echo '<!-- No team members found -->';
    return '';
}

// Debug output (remove this in production)
echo '<!-- Our Team Block: ' . count($team_members) . ' members -->';
?>
<div class="our-team-block">
  <!-- Section Header -->
  <div class="team-header">
    <?php if (!empty($title)) : ?>
      <h2 class="team-title"><?php echo esc_html($title); ?></h2>
    <?php endif; ?>
    <?php if (!empty($description)) : ?>
      <p class="team-description"><?php echo esc_html($description); ?></p>
    <?php endif; ?>
  </div>

  <!-- Team Members Grid -->
  <div class="team-members-grid">
    <?php foreach ($team_members as $member) : ?>
      <div class="team-member">
        <div class="member-image">
          <?php if (!empty($member['image'])) : ?>
            <img src="<?php echo esc_url($member['image']); ?>" alt="<?php echo esc_attr($member['name'] ?? 'Team member'); ?>" />
          <?php else : ?>
            <div class="member-image-placeholder">
              <span>Photo</span>
            </div>
          <?php endif; ?>
        </div>
        <div class="member-info">
          <?php if (!empty($member['name'])) : ?>
            <h3 class="member-name"><?php echo esc_html($member['name']); ?></h3>
          <?php endif; ?>
          <?php if (!empty($member['title'])) : ?>
            <p class="member-title"><?php echo esc_html($member['title']); ?></p>
          <?php endif; ?>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>