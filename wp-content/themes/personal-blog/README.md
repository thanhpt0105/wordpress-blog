# Personal Blog Theme

A minimalist, typography-first WordPress block theme inspired by Medium.com with immersive reading experience, dark mode, and performance-focused enhancements.

## Overview

**Personal Blog** is a custom WordPress theme based on the proven foundation of Custom Theme 3. It features a clean, readable design optimized for long-form content with modern features like dark mode, social sharing, and advanced SEO optimization.

## Features

### Design & Typography
- ✨ Minimalist, Medium.com-inspired design
- 📖 Typography-first approach with fluid font sizes
- 🎨 Clean color palette: #111111 (text), #1a8917 (accent), #ffffff (background)
- 📱 Fully responsive design (mobile, tablet, desktop)
- 🖼️ Beautiful post cards with featured images

### Reading Experience
- 🌙 **Dark Mode Toggle** - Persistent dark/light theme with system preference detection
- 📊 **Reading Progress Bar** - Visual indicator at the top of the page
- ⏱️ **Estimated Reading Time** - Automatically calculated for each post
- 🔗 **Floating Share Buttons** - Copy link, native share, Twitter, Facebook, LinkedIn
- 📚 **Related Posts** - Smart content recommendations based on categories/tags

### Content Features
- 🏠 **Hero Feature Section** - Customizable homepage hero with CTA buttons
- 👤 **Author Bio Card** - Profile card with custom avatar support
- 🏷️ **Category Menu** - Horizontal scrolling category navigation
- 💬 **Comment Support** - Threaded comments ready
- 🔍 **Search Functionality** - Built-in WordPress search
- 📸 **Featured Images** - Automatic optimization and lazy loading

### SEO & Performance
- 🚀 **SEO Optimized** - Open Graph tags, Twitter Cards, Schema.org JSON-LD
- ⚡ **Performance Focused** - Minimal dependencies, optimized assets
- 📱 **Mobile-First** - Progressive enhancement approach
- 🔄 **Cache-Friendly** - Proper cache headers and force refresh support
- 🎯 **Accessibility Ready** - ARIA labels, skip links, semantic HTML

### Developer Features
- 🎨 **Full Site Editing (FSE)** - Block-based theme with theme.json
- 🧩 **Block Patterns** - Pre-designed content patterns
- 🎛️ **Customizer Integration** - Easy theme configuration
- 🔌 **Plugin Friendly** - Compatible with popular WordPress plugins
- 📦 **Modular Code** - Well-organized, documented PHP and JavaScript

## Installation

### Via Docker (Development)

1. Start the WordPress environment:
   ```bash
   cd wordpress-blog-v2
   docker-compose up -d
   ```

2. Visit http://localhost:8080 and complete WordPress installation

3. Log into WordPress admin and go to **Appearance → Themes**

4. Activate **Personal Blog** theme

### Via FTP/File Manager (Production)

1. Upload the `personal-blog` folder to `/wp-content/themes/`

2. Log into WordPress admin

3. Go to **Appearance → Themes**

4. Click **Activate** on Personal Blog

## Configuration

### 1. Theme Setup

After activating the theme, configure these settings:

#### Appearance → Customize → Hero Feature
- Eyebrow Label: `"Featured insight"`
- Heading: `"Share ideas worth reading."`
- Subheading: Your site description
- Primary Button Label & Link
- Secondary Button Page selection
- Testimonial Quote & Attribution

#### Appearance → Customize → Author Bio
- Upload Author Bio Image (square, recommended 300x300px)
- Heading: `"Hi, I'm [Your Name]"`
- Description: Your bio text (2-3 sentences)

#### Appearance → Customize → Footer Social Links
- Facebook URL
- Instagram URL
- LinkedIn URL

### 2. Create Pages

Create these pages with specific templates:

- **About** - Use template: "About Page"
- **Contact** - Use template: "Contact Page"  
- **Blog** - Use default template

### 3. Set Homepage

1. Go to **Settings → Reading**
2. Select "A static page"
3. Choose your homepage as "Front page"
4. Choose your blog page as "Posts page"

### 4. Configure Permalinks

1. Go to **Settings → Permalinks**
2. Select **"Post name"** structure
3. Click **Save Changes**

### 5. Create Navigation Menu

1. Go to **Appearance → Menus**
2. Create a new menu named "Primary Navigation"
3. Add pages: Home, About, Blog, Contact
4. Assign to "Primary Navigation" location
5. Save menu

## Shortcodes

The theme includes several shortcodes for enhanced functionality:

### Reading Time
```php
[personalblog_estimated_reading_time]
```
Displays estimated reading time (e.g., "5 min read")

### Share Buttons
```php
[personalblog_share_bar]
```
Displays floating share buttons with copy link, native share, and social networks

### Related Posts
```php
[personalblog_related_posts]
```
Displays 3 related posts based on categories/tags

### Footer Social Links
```php
[personalblog_footer_socials]
```
Displays configured social media icons

### Footer Note
```php
[personalblog_footer_note]
```
Displays copyright notice with dynamic year

### Load More Button
```php
[personalblog_load_more]
```
Adds AJAX load more button for archive pages

## Customization

### Colors

Edit colors in `theme.json`:

```json
{
  "settings": {
    "color": {
      "palette": [
        {"slug": "foreground", "color": "#111111"},
        {"slug": "accent", "color": "#1a8917"},
        {"slug": "background", "color": "#ffffff"}
      ]
    }
  }
}
```

### Typography

The theme uses Arial font family by default. To change fonts, edit `theme.json`:

```json
{
  "settings": {
    "typography": {
      "fontFamilies": [
        {
          "slug": "arial-sans",
          "fontFamily": "\"Your Font\", sans-serif"
        }
      ]
    }
  }
}
```

### Custom CSS

Add custom CSS via **Appearance → Customize → Additional CSS** or create a child theme.

### Dark Mode

Dark mode is automatically enabled. Colors are defined in `theme.json`:

- Dark Background: `#121212`
- Dark Surface: `#1e1e1e`
- Dark Text: `#f0f0f0`

## File Structure

```
personal-blog/
├── style.css              # Theme header
├── theme.json             # Theme configuration
├── functions.php          # Theme functions
├── index.php              # Fallback template
├── assets/
│   ├── css/
│   │   ├── frontend.css   # Main stylesheet
│   │   └── editor.css     # Block editor styles
│   └── js/
│       ├── theme.js       # Frontend JavaScript
│       └── avatar.js      # Avatar upload handler
├── inc/
│   └── user-avatar.php    # Custom avatar support
├── parts/
│   ├── header.html        # Header template part
│   └── footer.html        # Footer template part
├── templates/
│   ├── front-page.html    # Homepage template
│   ├── single.html        # Blog post template
│   ├── page.html          # Default page template
│   └── index.html         # Archive template
└── patterns/
    ├── hero-feature.php   # Hero section pattern
    ├── author-bio.php     # Author bio pattern
    ├── category-menu.php  # Category navigation
    └── ...                # Other patterns
```

## Browser Support

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Mobile browsers (iOS Safari, Chrome Mobile)

## Requirements

- WordPress 6.6 or higher
- PHP 8.2 or higher
- Modern browser with JavaScript enabled

## Plugins Compatibility

Tested and compatible with:

- **Yoast SEO** / **Rank Math** - SEO optimization
- **Contact Form 7** - Contact forms
- **Akismet Anti-Spam** - Comment spam protection
- **WP Super Cache** - Page caching
- **Smush** - Image optimization
- **UpdraftPlus** - Backups
- **Nextend Social Login** - Social login integration

## Support

For issues, questions, or feature requests:

1. Check the documentation above
2. Review existing GitHub issues
3. Create a new issue with detailed information

## Credits

- Based on **Custom Theme 3** by Acme Themes
- Inspired by **Medium.com** design philosophy
- Built with WordPress Full Site Editing (FSE)
- Icons: Native emoji and Unicode characters

## License

GNU General Public License v2 or later  
https://www.gnu.org/licenses/gpl-2.0.html

## Changelog

### Version 1.0.0
- Initial release
- Full Site Editing support
- Dark mode with system preference detection
- Reading progress indicator
- Social sharing buttons
- Related posts feature
- Custom avatar support
- SEO optimization (Open Graph, Twitter Cards, Schema.org)
- Customizer integration
- Block patterns library
- Responsive design
- Performance optimizations

---

**Made with ❤️ for writers and readers**
