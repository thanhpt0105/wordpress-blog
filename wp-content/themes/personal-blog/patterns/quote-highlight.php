<?php
/**
 * Title: Quote Highlight
 * Slug: personal-blog/quote-highlight
 * Categories: personalblog-media
 * Block Types: core/post-content
 */
?>
<!-- wp:group {"layout":{"type":"constrained"},"style":{"spacing":{"padding":{"top":"2.5rem","bottom":"2.5rem","left":"2.5rem","right":"2.5rem"},"blockGap":"1rem"},"border":{"radius":"28px","left":{"color":"var:preset|color|accent","width":"6px"}}},"backgroundColor":"surface"} -->
<div class="wp-block-group has-surface-background-color has-background" style="border-radius:28px;border-left-color:var(--wp--preset--color--accent);border-left-width:6px;padding-top:2.5rem;padding-right:2.5rem;padding-bottom:2.5rem;padding-left:2.5rem">
<!-- wp:paragraph {"style":{"typography":{"fontSize":"2rem","lineHeight":"1.4","fontStyle":"italic"}},"fontFamily":"arial-serif"} -->
<p class="has-arial-serif-font-family" style="font-size:2rem;line-height:1.4;font-style:italic"><?php echo esc_html__( '“Slow pages, sharp words. This layout keeps readers leaning in till the last line.”', 'personalblog' ); ?></p>
	<!-- /wp:paragraph -->
<!-- wp:paragraph {"style":{"typography":{"fontSize":"0.95rem","letterSpacing":"0.18em","textTransform":"uppercase"}},"textColor":"muted","fontFamily":"arial-sans"} -->
<p class="has-text-color has-muted-color has-arial-sans-font-family" style="font-size:0.95rem;letter-spacing:0.18em;text-transform:uppercase"><?php echo esc_html__( 'Reader testimonial', 'personalblog' ); ?></p>
	<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
