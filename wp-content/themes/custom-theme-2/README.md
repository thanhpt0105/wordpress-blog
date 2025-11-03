# Custom Theme 2

Custom Theme 2 is a typography-first, performance-focused WordPress block theme built for personal blogs. It embraces WordPress 6.6 full site editing, includes author-centric patterns, and ships without third-party bloat so you can publish fast, accessible stories.

## Requirements

- WordPress 6.6 or newer
- PHP 8.2+
- Gutenberg plugin (optional but recommended for the latest block features)

## Installation

1. Copy the `custom-theme-2` folder into `wp-content/themes/`.
2. In `wp-admin`, visit **Appearance → Themes** and activate *Custom Theme 2*.
3. Import the demo content (optional):
   - Go to **Tools → Import → WordPress**.
   - Upload `demo-content/demo.xml` and assign content to your author.
4. Visit **Appearance → Editor** to adjust templates, template parts, and styles.

## Key Features

- Fluid typography scale with 8‑pt spacing rhythm and tasteful shadows.
- Light, Dark, Solarized, and High Contrast style variations.
- Mobile-first navigation with focus trap and dark-mode toggle (auto + manual).
- Reading niceties: progress bar, estimated reading time, copy-link-to-heading, table of contents, related posts shortcode.
- JSON-LD schema (Website, Blog, BlogPosting, Person) plus Open Graph-ready markup.
- Accessible defaults: skip links, focus outlines, keyboard-friendly off-canvas nav, comment honeypot.
- Patterns for hero, featured post, grids, newsletter, series index, gallery lightbox, link-in-bio, callouts, footer variants.
- Optional WooCommerce support with minimal styling.

## Theme Options & Toggles

The front-end script reads `window.acmeThemeSettings`. Override defaults via the `acme_theme_js_settings` filter in a mu-plugin or child theme:

```php
add_filter( 'acme_theme_js_settings', function( $settings ) {
	$settings['toggles']['darkMode']        = true;  // or false
	$settings['toggles']['readingProgress'] = true;
	$settings['toggles']['tableOfContents'] = true;
	$settings['toggles']['copyHeadings']    = true;
	$settings['toggles']['readingTime']     = 'minutes';

	return $settings;
} );
```

Browser storage (`localStorage`) remembers the dark-mode choice. Users with `prefers-color-scheme: dark` default to the dark palette unless they choose otherwise.

## Patterns Overview

| Pattern | Slug | Notes |
| --- | --- | --- |
| Home hero intro | `custom-theme-2/home-hero` | Author bio, CTA buttons, social links |
| Featured post spotlight | `custom-theme-2/featured-post` | Surfaces sticky posts |
| Latest posts (grid) | `custom-theme-2/latest-posts-grid` | 3-column responsive grid |
| Latest posts (list) | `custom-theme-2/latest-posts-list` | Publication meta + reading time |
| Series spotlight | `custom-theme-2/series-index` | Query filtered by tag slug `series` (adjust in block sidebar) |
| About the author card | `custom-theme-2/about-author` | Avatar, bio, social links |
| Newsletter signup | `custom-theme-2/newsletter-signup` | Compatible with Mailchimp/Jetpack/ConvertKit forms |
| Callout / Note / Warning | `custom-theme-2/callout-note-warning` | Semantic message boxes |
| Gallery with lightbox | `custom-theme-2/gallery-lightbox` | Uses native images + vanilla JS lightbox |
| Link in bio | `custom-theme-2/link-in-bio` | Landing page template + pattern |
| Footer classic | `custom-theme-2/footer-classic` | Newsletter + footer part |
| Footer minimal | `custom-theme-2/footer-minimal` | Lightweight alternative |

## Shortcodes

- `[acme_reading_time]` – outputs "X minute read".
- `[acme_share_links]` – lightweight share buttons (Twitter/X, LinkedIn, Facebook, copy link).
- `[acme_related_posts title="Related reads" count="3"]` – grid of posts sharing categories/tags.
- `[acme_year]` – current year.
- `[acme_feed_link label="RSS"]` – accessible RSS anchor.

Use the Shortcode block or embed within paragraphs.

## Customization Tips

- **Global Styles**: adjust color palette, fonts (system sans/serif/mono), spacing scale, and block defaults in **Appearance → Editor → Styles**.
- **Dark mode styling**: tweak `styles/dark.json`, `styles/solarized.json`, or `styles/high-contrast.json` and re-save in the editor for custom palettes.
- **Fonts**: The theme defaults to system stacks. To introduce Google Fonts, register them via `functions.php` or a child theme, enqueue as needed, and update `theme.json` `fontFamilies`.
- **Newsletter forms**: Replace the placeholder HTML in the Newsletter pattern with your provider's embed or a core Form block. The CSS is intentionally generic.
- **Gallery lightbox**: Any link with `data-acme-lightbox` gets the vanilla lightbox treatment. Replace placeholder images with your media library assets.
- **Series pattern**: Set the tag slug in the Query block sidebar so only relevant posts appear.

## Accessibility Notes

- Always provide descriptive alt text for images and galleries included in posts.
- Ensure contrast remains WCAG 2.1 AA compliant when adjusting palette colors.
- Off-canvas navigation is focus-trapped and escape-key dismissible; verify any custom markup inside the nav preserves focus order.

## Performance Checklist (90+ Lighthouse Targets)

- Keep `style.css` lean (critical CSS only); extend styling in `assets/css/frontend.css`.
- Avoid enabling unused Google Fonts; prefer system fonts where possible.
- Serve appropriately sized images (`core/image` block already outputs responsive `srcset`).
- Use WebP/AVIF uploads for hero and featured imagery.
- Enable server caching (page + object) and a CDN if available.
- Defer/async any additional scripts; copy the pattern used in `assets/js/theme.js`.
- Minimize third-party embeds; lazy-load videos with core blocks or placeholders.
- Audit with **Site Health → Info** to ensure PHP opcache and persistent object cache are enabled.

## Troubleshooting

- **Table of Contents missing**: Ensure the post includes at least two `h2`/`h3` headings. The TOC hides itself otherwise.
- **Reading time format**: Adjust the `acme_theme_js_settings` filter or override `acme_get_reading_time()` in a child theme.
- **WooCommerce**: Once WooCommerce is active, the theme enables minimal styling and removes default Woo CSS. Customize via Global Styles for a perfect match.

## Contributing

- Stick to WordPress Coding Standards (PHPCS – WordPress ruleset).
- Prefix PHP functions with `acme_` to avoid conflicts.
- Use vanilla JS; no jQuery dependency is bundled.
