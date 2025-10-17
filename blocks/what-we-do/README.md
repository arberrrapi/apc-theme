# What We Do Block

## Overview
A custom WordPress block that displays a "What We Do" section with a label, title, image, and up to any number of customizable info cards with Font Awesome icons.

## Features
- **Label**: Customizable section label (e.g., "What we do")
- **Title**: Main heading for the section
- **Image Upload**: Support for featured image with alt text
- **Info Cards**: Repeatable cards with:
  - Font Awesome icon (configurable)
  - Card title
  - Card description text
  - Add/Remove cards dynamically

## File Structure
```
blocks/what-we-do/
├── block.json          # Block configuration and attributes
├── block.php           # Server-side rendering
├── index.js            # Block editor interface
├── style.css           # Frontend styles
└── editor.css          # Editor-specific styles
```

## Usage

### Adding the Block
1. Edit a page in WordPress
2. Click the "+" to add a block
3. Search for "What We Do"
4. Insert the block

### Customizing Content

#### In the Sidebar (Inspector Controls):
1. **Label**: Enter the section label (appears above the title)
2. **Title**: Enter the main section heading
3. **Image**: Click "Select Image" to upload/choose an image
4. **Info Cards**:
   - Edit existing cards by changing icon class, title, or description
   - Add new cards with the "Add Card" button
   - Remove cards with the "Remove Card" button

### Icon Classes
Use Font Awesome icon classes (must have Font Awesome loaded):
- `fa-solid fa-users` - Team/people icon
- `fa-solid fa-shield-halved` - Security icon
- `fa-solid fa-rocket` - Speed/growth icon
- `fa-solid fa-chart-line` - Analytics icon
- `fa-solid fa-cloud` - Cloud services
- `fa-solid fa-cog` - Settings/configuration
- etc.

Full icon reference: https://fontawesome.com/icons

## Attributes

| Attribute | Type | Default | Description |
|-----------|------|---------|-------------|
| `label` | string | "What we do" | Section label text |
| `title` | string | "Complexity, Simplified and Secured" | Main heading |
| `imageUrl` | string | "" | URL of uploaded image |
| `imageAlt` | string | "What We Do" | Alt text for image |
| `cards` | array | (3 default cards) | Array of card objects |

### Card Object Structure
```json
{
  "icon": "fa-solid fa-users",
  "title": "Card Title",
  "text": "Card description text"
}
```

## Styling

### Frontend Classes
- `.what-we-do` - Main container
- `.section-label` - Label styling
- `.section-title` - Title styling
- `.what-we-do-info` - Cards container
- `.info-card` - Individual card wrapper
- `.info-card i` - Icon styling
- `.info-card h3` - Card title
- `.info-card p` - Card description

### Responsive Breakpoints
- Desktop: 1024px+ (3 columns)
- Tablet: 768-1023px (2 columns)
- Mobile: <768px (single column)

## Customization

### Modify Default Cards
Edit `block.json` and change the `cards.default` array.

### Change Colors
Edit `style.css`:
- Label color: `.section-label { color: #00aaff; }`
- Title color: `.section-title { color: #002d5b; }`
- Icon color: `.info-card i { color: #00aaff; }`

### Adjust Layout
Edit `style.css`:
- Card gap: `.what-we-do-info { gap: 40px; }`
- Max width: `.what-we-do-info { max-width: 1200px; }`

## Server-Side Rendering
The block uses PHP rendering (defined in `block.php`) for better performance and SEO. The editor preview shows a simplified version.

## Registration
Block is registered in `/inc/blocks-customizer.php`:
```php
require_once get_template_directory() . '/blocks/what-we-do/block.php';
register_block_type(get_template_directory() . '/blocks/what-we-do', array(
    'render_callback' => 'apc_render_what_we_do_block'
));
```

## Dependencies
- WordPress 5.8+ (Block API v2)
- Font Awesome 6+ (for icons)

## Notes
- Uses classic block registration (no build process required)
- Server-side rendering for better performance
- Fully responsive design
- Supports image uploads via Media Library
- Cards are dynamically repeatable (no limit)
