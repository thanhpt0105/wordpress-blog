# Custom Theme 3 — Medium-Inspired WordPress Block Theme

Custom Theme 3 is a typography-first, distraction-free block theme built for writers who love Medium’s reading experience. It ships with thoughtful defaults, dark mode, a reading progress indicator, estimated reading time, AJAX-powered “Load more” posts, and polished block patterns so you can spin up a personal publication quickly.

## Installation

1. Copy the `custom-theme-3` folder to `wp-content/themes/` in your WordPress install.
2. Log into `wp-admin`, navigate to **Appearance → Themes**, and activate **Custom Theme 3**.
3. Visit **Appearance → Editor** to tailor templates, template parts, and global styles if desired.

## Key Features

- Medium-inspired layout with a centered 740 px content column, generous white space, and fluid typography (Inter + Charter).
- Sticky minimal header with dark/light toggle, skip link, and responsive navigation.
- Dark mode (auto-detect + manual toggle) with persistent preference using local storage.
- Reading progress bar, estimated reading time shortcode (`[acme_estimated_reading_time]`), and floating share buttons (`[acme_share_bar]` on single posts).
- Related posts shortcode (`[acme_related_posts]`) pulling matches by category/tag.
- AJAX “Load more” button (`[acme_load_more]`) for the blog index and archives — automatically enabled on templates.
- Accessible, streamlined comments and keyboard-friendly navigation.
- JSON-LD (`Blog`, `BlogPosting`, `BreadcrumbList`, `Person`) plus Open Graph/Twitter cards out of the box.
- Patterns for hero, author bio, quote highlight, post grid, CTA, and link-in-bio landing.

## Optional Enhancements

- **Dark mode toggle**: Included in the header template part. Users can remove or restyle via the Site Editor.
- **Reading progress & load more**: Powered by `assets/js/theme.js`. Remove or customize by editing that script and `functions.php`.

## Customizing Global Styles

The theme relies on `theme.json` for typography, colors, and spacing. Use **Appearance → Editor → Styles** to:

1. Adjust brand accent color (`Accent` preset) for buttons and highlights.
2. Tweak base typography (switch to system sans/serif combos, change size scale, etc.).
3. Modify layout widths (content size/ wide size) under Layout settings.
4. Manage heading/body fonts by selecting alternative presets or adding custom font variations.

All adjustments made in the Site Editor write to `styles/theme.json`, preserving the curated defaults in the shipped file.

## Block Patterns & Demo Content

Reusable patterns live in `patterns/` and appear in the block inserter under **Acme Media**, **Acme Layouts**, and **Acme Calls to Action**. They serve as ready-to-use “demo content”:

- Hero Feature (`custom-theme-3/hero-feature`)
- Author Bio Card (`custom-theme-3/author-bio`)
- Category Menu (`custom-theme-3/category-menu`)
- Post Grid (`custom-theme-3/post-grid`)
- Quote Highlight (`custom-theme-3/quote-highlight`)
- Call to Action (`custom-theme-3/call-to-action`)
- Link in Bio (`custom-theme-3/link-in-bio`)

Insert any pattern to bootstrap pages, the front page, or landing experiences quickly.

## Performance Notes

- No jQuery; all interactions use a lightweight vanilla ES module (`assets/js/theme.js`, ~6 KB before gzip).
- Fonts load via a single Google Fonts request with `display=swap`; remove or self-host if you prefer zero external calls.
- Critical UI (header, typography) is handled via `theme.json` to minimize render-blocking CSS.
- Progress bar and infinite scroll scripts run lazily and bail out when corresponding elements are absent.
- Lazy-loaded images leverage core WordPress defaults; featured images include `loading="lazy"` where applicable.

Expect Lighthouse scores in the 90s for Performance, Accessibility, SEO, and Best Practices on typical content pages, assuming optimized media and caching at the site level.

## Developer Notes

- PHP namespace prefix: `acme_*` functions in `functions.php`.
- Translation-ready (`load_theme_textdomain( 'acme' )`); run `wp i18n make-pot` to generate POT files.
- Tested with WordPress 6.6+ and PHP 8.2+; adheres to WP Coding Standards (escapes, nonces, HTML5 support).
- Extend scripts/styles by hooking into `wp_enqueue_scripts` or editing `assets/js/theme.js` and `assets/css/frontend.css`.

Happy publishing!
