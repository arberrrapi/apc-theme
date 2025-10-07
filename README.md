# APC Integrated WordPress Theme

This is a custom WordPress theme converted from the original APC Integrated HTML template. The theme maintains all the original design and functionality while adding WordPress integration and content management capabilities.

## Theme Features

### Core WordPress Features
- ✅ Custom post types support
- ✅ Featured images
- ✅ Custom menus (Primary and Mobile)
- ✅ Widget areas
- ✅ Theme customizer integration
- ✅ Search functionality
- ✅ Archive pages (categories, tags, dates)
- ✅ 404 error page
- ✅ Responsive design
- ✅ Custom logo support

### Original Design Features Preserved
- ✅ Animated hero section with rotating text cube
- ✅ Mega menu navigation
- ✅ Mobile accordion navigation
- ✅ Service cards and solution sections
- ✅ Industry-specific challenge cards
- ✅ Partner logos section
- ✅ Testimonials slider
- ✅ Resources section
- ✅ Contact form with multi-step process
- ✅ All original animations and interactions

### WordPress Template Files Included

1. **style.css** - Main stylesheet with theme information and all original CSS
2. **functions.php** - Theme setup, enqueue scripts/styles, customizer options
3. **index.php** - Main template file (blog homepage)
4. **front-page.php** - Static front page template (recommended for homepage)
5. **header.php** - Header template with navigation
6. **footer.php** - Footer template
7. **page.php** - Individual page template
8. **single.php** - Single post template
9. **archive.php** - Archive pages (categories, tags, etc.)
10. **search.php** - Search results template
11. **searchform.php** - Search form template
12. **404.php** - 404 error page template

## Installation Instructions

### 1. WordPress Setup
Make sure you have WordPress installed and running on your local server (MAMP).

### 2. Theme Installation
The theme is already located in the correct WordPress themes directory:
```
/Applications/MAMP/htdocs/apc/wp-content/themes/apc_theme/
```

### 3. Activate the Theme
1. Go to your WordPress admin dashboard
2. Navigate to **Appearance > Themes**
3. Find "APC Integrated Theme" and click **Activate**

### 4. Configure Menus
1. Go to **Appearance > Menus**
2. Create a new menu for "Primary Menu"
3. Add your pages/links to match the original navigation structure
4. Create another menu for "Mobile Menu" if needed

### 5. Set Up Homepage
1. Go to **Settings > Reading**
2. Select "A static page" for your homepage displays
3. Choose a page to use as your front page (or create a new one)

### 6. Customize Theme Options
Go to **Appearance > Customize** to configure:
- **Site Identity**: Upload your logo
- **APC Theme Options**: Configure header button URLs
- **Hero Section**: Customize hero text and rotating messages
- **CTA Section**: Customize contact form and call-to-action text

## Theme Customizer Options

### APC Theme Options
- **Remote Support URL**: Link for the remote support button
- **Client Portal URL**: Link for the client portal button

### Hero Section
- **Hero Line 1**: First line of hero text
- **Hero Line 2**: Second line of hero text
- **Hero Cube Text**: Four rotating messages in the animated cube

### CTA Section
- **CTA Title**: Main call-to-action title
- **CTA Form Title**: Contact form title
- **Form Button Text**: Submit button text

### Footer Options
- **Footer Contact Text**: Main footer contact message
- **Footer Button Text**: Footer button text
- **IT Health Check**: Title and description
- **Contract Management**: Title and description

## Contact Form

The theme includes a fully functional contact form that:
- Validates required fields
- Sends emails to the site administrator
- Includes nonce security
- Provides user feedback on submission
- Captures all form data (name, email, phone, company, service, message)

## Assets and Media

All original assets are preserved in the `assets/` directory:
- **img/cloud/**: Cloud solution icons
- **img/enterprise/**: Enterprise icons
- **img/partners/**: Partner logos
- **img/performance/**: Performance icons
- **img/processes/**: Process icons
- **img/site/**: Site graphics and images

## JavaScript Functionality

The original `script.js` file is preserved and includes:
- Mobile navigation toggle
- Accordion menus
- Testimonial slider
- Resource slider
- Contact form interactions
- Animation triggers

## Browser Support

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Mobile browsers (iOS Safari, Chrome Mobile)

## Development Notes

### WordPress Integration
- All static content has been converted to use WordPress functions
- Template parts are properly separated (header, footer, content)
- Proper WordPress coding standards followed
- Security best practices implemented (nonces, sanitization)
- SEO-friendly markup and structure

### Customization
- Theme uses WordPress Customizer for easy content management
- All text content can be modified without code changes
- Menu structure is fully manageable through WordPress admin
- Widget areas available for additional content

### Performance
- CSS and JavaScript are properly enqueued
- Images are optimized for web
- Responsive design ensures mobile performance
- Clean, semantic HTML structure

## Support and Maintenance

### Updating Content
- Use WordPress admin to manage pages, posts, and menus
- Theme Customizer for styling and text changes
- Media Library for image management

### Adding New Features
- Follow WordPress coding standards
- Use child themes for major customizations
- Test changes on staging environment first

### Troubleshooting
- Check PHP error logs for issues
- Ensure all WordPress requirements are met
- Verify file permissions are correct
- Clear any caching plugins when making changes

## File Structure
```
apc_theme/
├── style.css (WordPress main stylesheet)
├── styles.css (original CSS file)
├── functions.php
├── index.php
├── front-page.php
├── header.php
├── footer.php
├── page.php
├── single.php
├── archive.php
├── search.php
├── searchform.php
├── 404.php
├── script.js (original JavaScript)
├── apc_logo.png
├── assets/ (all original images and icons)
└── README.md (this file)
```

## Version History

**Version 1.0**
- Initial conversion from HTML template to WordPress theme
- All original functionality preserved
- WordPress integration completed
- Theme customizer options added
- Responsive design maintained

---

*This theme is based on the original APC Integrated HTML template and has been carefully converted to maintain all design elements and functionality while adding WordPress content management capabilities.*