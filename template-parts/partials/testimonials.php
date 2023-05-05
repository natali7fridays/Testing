<?php
/**
 * Testimonail content template partial
 *
 * @package adaptdev/base
 * @since 1.0.0
 */

// Check rows exists.
if ( have_rows( 'testimonials' ) ) :
	echo '<ul class="testimonial-slides testimonials">';
	// Loop through rows.
	while ( have_rows( 'testimonials' ) ) :
		the_row();

		$testimonial_text = get_sub_field( 'testimonial_text' );
		$author_name      = get_sub_field( 'name' );
		$author_info      = get_sub_field( 'info' );

		echo '<li class="testimonial testimonials__slide">';

		if ( ! empty( $testimonial_text ) ) :
			echo '<span class="testimonial__text">';
			echo esc_html( $testimonial_text );
			echo '</span>';
		endif;

		echo '<div class="testimonial__author">';

		if ( ! empty( $author_name ) ) :
			echo '<div class="testimonial__author__name">';
			echo esc_html( $author_name );
			echo '</div>';
		endif;

		if ( ! empty( $author_info ) ) :
			echo '<div class="testimonial__author__info">';
			echo esc_html( $author_info );
			echo '</div>';
		endif;

		echo '</div>';

		echo '</li>';
		// End loop.
	endwhile;
	echo '</ul>';
	// No value.
endif;

