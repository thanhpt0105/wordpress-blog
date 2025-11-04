<?php
/**
 * Title: Author Bio Card
 * Slug: custom-theme-3/author-bio
 * Categories: acme-media
 */
?>
<!-- wp:group {"layout":{"type":"constrained"},"className":"acme-author-card","style":{"spacing":{"padding":{"top":"2.5rem","bottom":"2.5rem","left":"2rem","right":"2rem"},"blockGap":"1.5rem"}}} -->
<div class="wp-block-group acme-author-card">
	<!-- wp:group {"layout":{"type":"flex","flexWrap":"nowrap","orientation":"horizontal","verticalAlignment":"center"},"style":{"spacing":{"blockGap":"1.5rem"}}} -->
	<div class="wp-block-group">
		<!-- wp:html -->
		<div class="acme-author-card__avatar">
		<?php
		$acme_author_image_id = get_theme_mod( 'acme_author_bio_image', '' );
			$acme_author_image    = '';

			if ( $acme_author_image_id ) {
				if ( is_numeric( $acme_author_image_id ) ) {
					$acme_author_image = wp_get_attachment_image(
						(int) $acme_author_image_id,
						'thumbnail',
						false,
						array(
							'class'   => 'acme-author-card__image',
							'loading' => 'lazy',
							'alt'     => esc_attr__( 'Author portrait', 'acme' ),
						)
					);
				} else {
					$acme_author_image = sprintf(
						'<img class="acme-author-card__image" src="%1$s" alt="%2$s" loading="lazy" />',
						esc_url( $acme_author_image_id ),
						esc_attr__( 'Author portrait', 'acme' )
					);
				}
			}

			if ( ! $acme_author_image ) {
				$acme_author_image = get_avatar(
					get_current_user_id(),
					96,
					'',
					esc_attr__( 'Author portrait', 'acme' ),
					array(
						'class' => 'acme-author-card__image avatar',
					)
				);
			}

			echo $acme_author_image; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			?>
		</div>
		<!-- /wp:html -->

		<!-- wp:group {"layout":{"type":"constrained"},"style":{"spacing":{"blockGap":"0.5rem"}}} -->
		<div class="wp-block-group">
			<!-- wp:heading {"level":3,"fontSize":"lg"} -->
			<h3 class="wp-block-heading has-lg-font-size"><?php echo wp_kses_post( get_theme_mod( 'acme_author_bio_heading', esc_html__( 'Hi, I’m Alex', 'acme' ) ) ); ?></h3>
			<!-- /wp:heading -->
			<!-- wp:paragraph {"fontSize":"md"} -->
			<p class="has-md-font-size"><?php echo wp_kses_post( get_theme_mod( 'acme_author_bio_description', esc_html__( 'Writer, product person, long-form enthusiast. Weekly essays on craft, clarity, and living with more intention.', 'acme' ) ) ); ?></p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:group -->
	</div>
	<!-- /wp:group -->
</div>
<!-- /wp:group -->
