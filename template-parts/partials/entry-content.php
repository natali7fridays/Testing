<?php
/**
 * Editor content template partial
 *
 * @package adaptdev/base
 * @since 1.0.0
 */

$entry_content = isset( $args['entry-content'] ) ? $args['entry-content'] : false;

if ( $entry_content ) : ?>
	<div class="entry-content">
		<?php echo apply_filters( 'the_content', $entry_content );//phpcs:ignore ?>
	</div>
<?php endif; ?>
