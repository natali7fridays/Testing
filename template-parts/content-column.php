<?php
/**
 * Template for flex content
 *
 * @package adaptdev/base
 * @since 1.0.0
 */

if ( have_rows( 'page-sections' ) ) :
	while ( have_rows( 'page-sections' ) ) :
		the_row();
		get_template_part( 'template-parts/layout', get_row_layout() );
	endwhile;
else :
	get_template_part( 'template-parts/partials/section.php', '' );
endif;
