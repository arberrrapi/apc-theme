# Tailored Solutions Block Documentation

## Overview
The Tailored Solutions block is a dynamic WordPress block that displays services from the Services custom post type. It has been converted from a static section to a fully dynamic, reusable block with integrated CSS styling.

## Changes Made

### 1. Services Custom Post Type Updates
- **Removed**: Icon color field (`_service_icon_color` meta field)
- **Kept**: Icon selection, short description, service URL, and price range
- **Reason**: Colors are now handled entirely by CSS for consistency

### 2. Tailored Solutions Block Creation
- **Location**: `/blocks/tailored-solutions/`
- **Files**: 
  - `block.json` - Block configuration and metadata
  - `block.js` - Gutenberg block registration and editor interface
  - `block.php` - Server-side rendering function
  - `style.css` - Frontend styling
- **Block Name**: `apc/tailored-solutions`
- **Category**: APC Blocks

### 3. CSS Migration  
- **Removed**: All tailored-solutions CSS from main `style.css`
- **Added**: Dedicated `blocks/tailored-solutions/style.css` file
- **Benefits**: Self-contained styling, proper separation of concerns, easier maintenance

## Usage

### 1. As a Block (Gutenberg Editor)
1. In the WordPress editor, click the "+" button
2. Search for "Tailored Solutions" 
3. Add the block to your page/post
4. Configure settings in the sidebar:
   - Title
   - Description  
   - Maximum Services (1-20)

### 2. As a Shortcode
```php
[tailored_solutions title="Custom Title" description="Custom description" max_services="6"]
```

### 3. Programmatically (in templates)
```php
echo apc_render_tailored_solutions_block(array(
    'title' => 'Your Title',
    'description' => 'Your description',
    'maxServices' => 8
));
```

## Block Attributes

| Attribute | Type | Default | Description |
|-----------|------|---------|-------------|
| `title` | string | "Tailored solutions, for every problem" | Main heading |
| `description` | string | "From IT support and infrastructure..." | Subtitle text |
| `maxServices` | number | 8 | Maximum number of services to display |

## Service Integration

### Dynamic Content
- Pulls services from the Services custom post type
- Uses service title, icon, and URL (if set)
- Falls back to service permalink if no custom URL
- Displays in menu order, then alphabetical

### Fallback Content
If no services exist in the custom post type, displays default services:
- IT Support & Helpdesk
- Cloud Infrastructure
- Cyber Security
- Network Connectivity
- Managed Contracts
- Data Backup & Recovery
- Software Solutions
- Hardware Management

## Styling

### CSS Variables
The block uses CSS custom properties for theming:
- `--brand-color`: Primary brand color (#2119d4)
- `--secondary-color`: Secondary color
- `--light-color`: Background color (#f8f9fa)
- `--text-color`: Text color (#333)
- `--grey`: Border color (#e0e0e0)

### Responsive Design
- Desktop: Two-column layout (text left, services right)
- Tablet/Mobile: Single column, stacked layout
- Adjusts font sizes and spacing automatically

## Implementation in Front Page

The front page (`front-page.php`) now uses:
```php
echo apc_render_tailored_solutions_block(array(
    'title' => get_theme_mod('tailored_title', 'Tailored solutions, for every problem'),
    'description' => get_theme_mod('tailored_description', 'From IT support and infrastructure to cyber security, connectivity and Managed Contracts - we\'re here to help.'),
    'maxServices' => 8
)); 
```

This maintains customizer integration while using dynamic services.

## Adding New Services

1. Go to WordPress Admin → Services
2. Add New Service
3. Fill in:
   - Title (required)
   - Content (full description)
   - Featured Image (optional)
   - Icon (FontAwesome class)
   - Short Description (for cards)
   - Service URL (optional custom link)
   - Price Range (optional)

## Custom Service Icons

Services support FontAwesome icons. Popular options included:
- `fa-solid fa-headset` - Support/Helpdesk
- `fa-solid fa-cloud` - Cloud Services
- `fa-solid fa-shield-halved` - Security
- `fa-solid fa-network-wired` - Networking
- `fa-solid fa-database` - Data/Backup
- `fa-solid fa-laptop-code` - Software
- `fa-solid fa-server` - Hardware

## Migration Notes

### Existing Installations
- Old CSS removed from main stylesheet
- Icon colors removed (now uses CSS defaults)
- Block maintains exact same visual appearance
- Customizer settings still work for front page

### Benefits of New System
1. **Reusable**: Block can be used on any page/post
2. **Dynamic**: Automatically updates when services change
3. **Manageable**: Services managed through WordPress admin
4. **Consistent**: Single source of truth for service data
5. **Flexible**: Easy to customize per instance

## Troubleshooting

### Services Not Showing
1. Check if services exist in WordPress Admin → Services
2. Verify services are published (not draft)
3. Check max_services attribute isn't too low

### Styling Issues
1. Ensure CSS custom properties are defined in theme
2. Check for conflicting CSS in other stylesheets
3. Browser cache may need clearing

### Block Not Appearing
1. Verify block registration in functions.php
2. Check JavaScript console for errors
3. Ensure `blocks/tailored-solutions/block.js` exists