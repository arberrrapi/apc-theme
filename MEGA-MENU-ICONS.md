# Mega Menu Icons Guide

This guide explains how to add icons to your mega menu columns in WordPress.

## How It Works

The mega menu now supports icons for column headers. Icons are added using CSS classes in the WordPress menu system.

## Step-by-Step Instructions

### 1. Navigate to WordPress Menu Editor
1. Log in to your WordPress admin
2. Go to **Appearance > Menus**
3. Select your primary navigation menu

### 2. Enable CSS Classes
If you don't see the CSS Classes field:
1. Click **Screen Options** (top right corner)
2. Check the box for **CSS Classes**
3. The CSS Classes field will now appear for each menu item

### 3. Add Icon Class to Menu Items
1. Find the menu item you want to add an icon to (must be a **second-level item** under a mega menu parent)
2. Expand the menu item by clicking the arrow
3. In the **CSS Classes (optional)** field, enter the Font Awesome classes
   - Example: `fa-solid fa-cloud`
   - Enter the complete class string with both parts
4. Click **Save Menu**

**Example:**
```
Menu Item: Cloud Services
CSS Classes (optional): fa-solid fa-cloud
```

The icon will appear before the text "Cloud Services" in your mega menu.

## Available Icon Classes

### Font Awesome Icons (Recommended)

The theme uses Font Awesome 6.4.0. Add Font Awesome classes directly to the **CSS Classes** field.

**Format:** `fa-solid fa-icon-name` or `fa-regular fa-icon-name` or `fa-brands fa-icon-name`

**Popular Examples:**
- `fa-solid fa-cloud` - Cloud services
- `fa-solid fa-shield-halved` - Security
- `fa-solid fa-headset` - Support
- `fa-solid fa-server` - Infrastructure
- `fa-solid fa-network-wired` - Network
- `fa-solid fa-database` - Database
- `fa-solid fa-lock` - Security/Privacy
- `fa-solid fa-users` - Team/Collaboration
- `fa-solid fa-chart-line` - Analytics
- `fa-solid fa-code` - Development

Find more icons at: [https://fontawesome.com/icons](https://fontawesome.com/icons)

### Custom SVG Icons (Optional)

If you want to use custom SVG icons instead:
- `icon-bg icon-cloud` - Cloud/hosting related services
- `icon-bg icon-security` - Security services
- `icon-bg icon-support` - Support services
- `icon-bg icon-infrastructure` - Infrastructure services

## Example Menu Structure

```
Solutions (Top Level - has mega menu)
├── Cloud Services (CSS Classes: fa-solid fa-cloud)
│   ├── Cloud Hosting
│   ├── Cloud Backup
│   └── Cloud Migration
├── Security (CSS Classes: fa-solid fa-shield-halved)
│   ├── Firewall Management
│   └── Security Audits
└── Support (CSS Classes: fa-solid fa-headset)
    ├── 24/7 Support
    └── Helpdesk
```

**Important:** Enter the complete Font Awesome class string in the CSS Classes field, including both parts (e.g., `fa-solid fa-cloud`)

## Adding Custom Icons

### Option 1: Using SVG Icons (Recommended)

1. **Prepare your icon:**
   - Create or download an SVG icon
   - Optimize it for web (keep file size small)
   - Save it in `/assets/img/icons/` directory

2. **Add CSS rule:**
   Open `style.css` and add a new rule in the mega menu icons section:

   ```css
   .mega-menu-icon.icon-yourname {
     background-image: url('../assets/img/icons/youricon.svg');
   }
   ```

3. **Use the class:**
   Add `icon-yourname` to your menu item's CSS Classes field

### Option 2: Using Font Awesome Icons (Already Configured!)

Font Awesome 6.4.0 is already loaded and configured! Just add the Font Awesome classes:

1. **Find an icon** at [fontawesome.com/icons](https://fontawesome.com/icons)
2. **Copy the class** (e.g., `fa-solid fa-cloud`)
3. **Paste into CSS Classes field** in your menu item
4. **Save the menu**

That's it! The icon will automatically appear next to your menu column title.

### Option 3: Using Emoji Icons

Simply add the emoji directly in the menu item title:
- ☁️ Cloud Services
- 🔒 Security
- 🎯 Support

## Icon Customization

To customize icon appearance, modify these CSS properties in `style.css`:

```css
.mega-menu-icon {
  width: 24px;          /* Icon size */
  height: 24px;         /* Icon size */
  gap: 12px;            /* Space between icon and text */
}
```

## Troubleshooting

### Icons not showing?
1. **Check the CSS class** - Make sure you've typed the class correctly (e.g., `icon-cloud`)
2. **Check icon files** - Verify SVG files exist in `/assets/img/icons/`
3. **Clear cache** - Clear your browser cache and any WordPress caching plugins
4. **Check menu depth** - Icons only work on second-level items (mega menu column headers)

### Wrong icon appearing?
- Check for typos in the CSS Classes field
- Make sure you only have one `icon-` class per menu item

### Icon too big/small?
- Adjust the `width` and `height` in `.mega-menu-icon` CSS rule

## Pro Tips

1. **Consistent sizing:** Keep all icon SVG files the same dimensions (e.g., 24x24px)
2. **Color matching:** Use icons that match your brand colors or can be easily styled
3. **Performance:** Optimize SVG files to reduce page load time
4. **Accessibility:** Ensure icons complement text, don't replace it entirely

## Need More Help?

- Icons are processed by the `APC_Walker_Nav_Menu` class in `/inc/navigation-walkers.php`
- CSS styles are in the main `style.css` file under "Mega Menu Icons"
- Add new icon rules by following the pattern of existing ones
