<?php
/**
 * Title: Callout and note blocks
 * Slug: custom-theme-2/callout-note-warning
 * Categories: acme-utility
 */
?>
<!-- wp:group {"className":"acme-callout","layout":{"type":"constrained"},"style":{"spacing":{"blockGap":"var(--wp--preset--spacing--md)"}}} -->
<div class="wp-block-group acme-callout">
	<!-- wp:group {"className":"acme-note","backgroundColor":"neutral-5","style":{"border":{"width":"1px","color":"var(--wp--preset--color--primary)"}}} -->
	<div class="wp-block-group acme-note has-neutral-5-background-color has-background" style="border-color:var(--wp--preset--color--primary);border-width:1px">
		<!-- wp:heading {"level":4,"fontSize":"small"} -->
		<h4 class="wp-block-heading has-small-font-size">Note</h4>
		<!-- /wp:heading -->
		<!-- wp:paragraph -->
		<p>Use this block for gentle reminders or supplemental context.</p>
		<!-- /wp:paragraph -->
	</div>
	<!-- /wp:group -->

	<!-- wp:group {"className":"acme-note","backgroundColor":"warning","style":{"border":{"width":"1px","color":"var(--wp--preset--color--warning)"}}} -->
	<div class="wp-block-group acme-note has-warning-background-color has-background" style="border-color:var(--wp--preset--color--warning);border-width:1px">
		<!-- wp:heading {"level":4,"fontSize":"small"} -->
		<h4 class="wp-block-heading has-small-font-size">Callout</h4>
		<!-- /wp:heading -->
		<!-- wp:paragraph -->
		<p>Highlight important ideas or follow-up actions.</p>
		<!-- /wp:paragraph -->
	</div>
	<!-- /wp:group -->

	<!-- wp:group {"className":"acme-note","backgroundColor":"danger","style":{"border":{"width":"1px","color":"var(--wp--preset--color--danger)"}}} -->
	<div class="wp-block-group acme-note has-danger-background-color has-background" style="border-color:var(--wp--preset--color--danger);border-width:1px">
		<!-- wp:heading {"level":4,"fontSize":"small"} -->
		<h4 class="wp-block-heading has-small-font-size">Warning</h4>
		<!-- /wp:heading -->
		<!-- wp:paragraph -->
		<p>Flag edge cases, breaking changes, or critical caveats.</p>
		<!-- /wp:paragraph -->
	</div>
	<!-- /wp:group -->
</div>
<!-- /wp:group -->
