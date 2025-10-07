# Navigation Menu Setup Guide

## Overview
The APC theme uses a sophisticated navigation system with mega menus for desktop and accordion menus for mobile. This guide explains how to set up your navigation menus correctly.

## Menu Structure Required

### Desktop Menu (Primary Location)
The desktop navigation supports **3-level menu hierarchy** for mega menus:

```
Level 1: Main Navigation Items
├── About (single link)
├── Solutions (has mega menu)
│   ├── IT Support (column header)
│   │   ├── 24/7 Helpdesk
│   │   ├── Remote Support  
│   │   ├── On-site Support
│   │   └── System Maintenance
│   ├── Cloud Solutions (column header)
│   │   ├── Cloud Migration
│   │   ├── Microsoft Azure
│   │   ├── Cloud Backup
│   │   └── Cloud Hosting
│   ├── Security (column header)
│   │   ├── Cybersecurity
│   │   ├── Threat Monitoring
│   │   ├── Compliance
│   │   └── Data Protection
│   └── Infrastructure (column header)
│       ├── Network Setup
│       ├── Server Management
│       ├── Hardware Supply
│       └── VoIP Solutions
├── Sectors (has mega menu)
│   ├── Professional Services
│   │   ├── Accounting
│   │   ├── Legal
│   │   ├── Consulting
│   │   └── Architecture
│   ├── Healthcare
│   │   ├── Medical Practices
│   │   ├── Dental Clinics
│   │   ├── Veterinary
│   │   └── Care Homes
│   ├── Education & Non-Profit
│   │   ├── Schools
│   │   ├── Universities
│   │   ├── Charities
│   │   └── Government
│   └── Business
│       ├── Manufacturing
│       ├── Retail
│       ├── Hospitality
│       └── Finance
└── Resources (single link)
```

### Mobile Menu (Mobile Location)
The mobile navigation uses the same structure but displays as accordion menus.

## Setup Instructions

### Step 1: Create Menu Items
1. Go to **Appearance > Menus** in WordPress admin
2. Create a new menu or select existing menu
3. Add your main navigation items (About, Solutions, Sectors, Resources)

### Step 2: Add Sub-Menu Items
1. **For mega menus**: Add sub-items under main items
2. **Drag items** to the right to create hierarchy:
   - **Level 1**: Main items (About, Solutions, etc.)
   - **Level 2**: Column headers (IT Support, Cloud Solutions, etc.)
   - **Level 3**: Individual links within columns

### Step 3: Assign Menu Locations
1. In the menu editor, check the boxes for:
   - ✅ **Primary Menu** (for desktop navigation)
   - ✅ **Mobile Menu** (for mobile navigation)
2. Save the menu

### Step 4: Verify Structure
- **Single items** (About, Resources) should have no sub-items
- **Mega menu items** (Solutions, Sectors) should have 2-3 levels of hierarchy
- **Column headers** (Level 2) organize the mega menu layout
- **Links** (Level 3) are the actual clickable items in each column

## Menu Classes and Structure

### Desktop Navigation Classes
```html
<nav class="main-nav">
  <ul class="nav-menu">
    <li class="nav-item"><!-- Single item -->
    <li class="nav-item mega-menu-item"><!-- Mega menu item -->
      <div class="mega-menu">
        <div class="mega-menu-container">
          <div class="mega-menu-column">
            <h4>Column Header</h4>
            <ul>
              <li><a>Sub-item</a></li>
            </ul>
          </div>
        </div>
      </div>
    </li>
  </ul>
</nav>
```

### Mobile Navigation Classes
```html
<nav class="mobile-nav">
  <ul class="mobile-nav-menu">
    <li class="mobile-nav-item"><!-- Single item -->
    <li class="mobile-nav-item mobile-accordion-parent"><!-- Accordion item -->
      <button class="mobile-accordion-toggle">Main Item</button>
      <ul class="mobile-accordion-panel">
        <li class="mobile-accordion-parent">
          <button class="mobile-accordion-toggle">Sub Header</button>
          <ul class="mobile-accordion-panel">
            <li><a>Sub-item</a></li>
          </ul>
        </li>
      </ul>
    </li>
  </ul>
</nav>
```

## Tips for Best Results

### Menu Hierarchy
- Keep **Level 2** items as organizational headers (they can link somewhere but primarily serve as column headers)
- **Level 3** items should be the main clickable links
- Aim for **3-4 columns** maximum in mega menus for best layout

### Linking Strategy
- **Level 1**: Link to main category/overview pages
- **Level 2**: Can link to category pages or just serve as headers
- **Level 3**: Link to specific service pages, blog posts, or external URLs

### Using Custom Services
If you've created services using the custom post type:
- Link **Level 3** items to individual service pages
- Link **Level 2** headers to service category archives
- Use the Services archive (`/services/`) as a main navigation destination

### Content Recommendations
- **Solutions** menu: Link to your services and capabilities
- **Sectors** menu: Link to industry-specific pages or case studies  
- **Resources** menu: Link to blog, downloads, case studies
- **About** menu: Link to company information, team, history

## Troubleshooting

### Menu Not Showing
- Ensure menu is assigned to correct location (Primary Menu)
- Check that menu items exist and are published
- Verify theme location is registered in functions.php

### Mega Menu Not Working
- Confirm menu has proper 3-level hierarchy
- Check that parent items have child items
- Ensure CSS classes are being applied correctly

### Mobile Menu Issues
- Verify mobile menu is assigned to "Mobile Menu" location
- Check that JavaScript is loading correctly
- Ensure accordion functionality is working

### Styling Issues
- All original CSS classes are preserved
- Custom styling should target the correct class names
- Use browser developer tools to inspect element structure

## Advanced Customization

### Adding Icons to Menu Items
You can add FontAwesome icons to menu items using CSS classes:
1. In menu item settings, add CSS class like `icon-cloud`
2. Add custom CSS to display the icon

### Custom Menu Walkers
The theme includes custom walker classes:
- `APC_Walker_Nav_Menu`: For desktop mega menus
- `APC_Mobile_Walker_Nav_Menu`: For mobile accordion menus

These handle the proper HTML structure and CSS classes automatically.

## Summary
The navigation system maintains the original design's sophisticated mega menu layout while providing full WordPress menu management capabilities. Follow the 3-level hierarchy structure for best results, and ensure both Primary and Mobile menu locations are assigned for complete functionality.